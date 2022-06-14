<?php

declare(strict_types=1);

class Restaurant
{
    public int $id;
    public int $idUser;
    public string $name;
    public string $opens;
    public string $closes;
    public string $category;
    public string $address;
    public ?string $photo;

    public function __construct(int $id, int $idUser, string $name, string $opens, string $closes, string $category, string $address, ?string $photo)
    {
        $this->id = $id;
        $this->idUser = $idUser;
        $this->name = $name;
        $this->opens = $opens;
        $this->closes = $closes;
        $this->category = $category;
        $this->address = $address;
        $this->photo = $photo;
    }

    static function getRestaurants(PDO $db, int $count): array
    {
        $stmt = $db->prepare(
            'SELECT idRestaurant, idUser, name, opens, closes, category, address, photo
                 FROM Restaurant
                 LIMIT ?'
        );
        $stmt->execute(array($count));

        $restaurants = array();
        while ($restaurant = $stmt->fetch()) {
            $restaurants[] = new Restaurant(
                intval($restaurant['idRestaurant']),
                intval($restaurant['idUser']),
                $restaurant['name'],
                $restaurant['opens'],
                $restaurant['closes'],
                $restaurant['category'],
                $restaurant['address'],
                $restaurant['photo']
            );
        }
        return $restaurants;
    }

    static function searchRestaurants(PDO $db, string $search, int $count): array
    {
        $stmt = $db->prepare(
            'SELECT idRestaurant, idUser, name, opens, closes, category, address, photo
                 FROM Restaurant
                 WHERE name 
                 LIKE ? 
                 LIMIT ?'
        );
        $stmt->execute(array($search . '%', $count));

        $restaurants = array();
        while ($restaurant = $stmt->fetch()) {
            $restaurants[] = new Restaurant(
                intval($restaurant['idRestaurant']),
                intval($restaurant['idUser']),
                $restaurant['name'],
                $restaurant['opens'],
                $restaurant['closes'],
                $restaurant['category'],
                $restaurant['address'],
                $restaurant['photo']
            );
        }

        return $restaurants;
    }


    static function getRestaurant(PDO $db, int $id): Restaurant
    {
        $stmt = $db->prepare(
            'SELECT idRestaurant, idUser, name, opens, closes, category, address, photo
                 FROM Restaurant
                 WHERE idRestaurant = ?'
        );
        $stmt->execute(array($id));

        $restaurant = $stmt->fetch();

        return new Restaurant(
            intval($restaurant['idRestaurant']),
            intval($restaurant['idUser']),
            $restaurant['name'],
            $restaurant['opens'],
            $restaurant['closes'],
            $restaurant['category'],
            $restaurant['address'],
            $restaurant['photo']
        );
    }


    static function getOwnerRestaurants(PDO $db, int $idUser)
    {
        $stmt = $db->prepare(
            'SELECT idRestaurant, idUser, name, opens, closes, category, address, photo
                FROM RESTAURANT 
                WHERE idUser = ?'
        );

        $stmt->execute(array($idUser));

        $restaurants = array();
        while ($restaurant = $stmt->fetch()) {
            $restaurants[] = new Restaurant(
                intval($restaurant['idRestaurant']),
                intval($restaurant['idUser']),
                $restaurant['name'],
                $restaurant['opens'],
                $restaurant['closes'],
                $restaurant['category'],
                $restaurant['address'],
                $restaurant['photo']
            );
        }
        return $restaurants;
    }


    static function getCategories(PDO $db): array
    {
        $stmt = $db->prepare(
            'SELECT DISTINCT category
                 FROM Restaurant'
        );
        $stmt->execute();
        $result = $stmt->fetchAll();
        $categories = [];
        foreach ($result as $r) {
            $categories[] = $r['category'];
        }
        return $categories;
    }

    static function getRestaurantsByCategory(PDO $db, string $category): array
    {
        $stmt = $db->prepare(
            'SELECT idRestaurant, idUser, name, opens, closes, category, address, photo
                 FROM Restaurant
                 WHERE category
                 LIKE ?'
        );
        $stmt->execute(array($category . '%'));

        $restaurants = array();
        while ($restaurant = $stmt->fetch()) {
            $restaurants[] = new Restaurant(
                intval($restaurant['idRestaurant']),
                intval($restaurant['idUser']),
                $restaurant['name'],
                $restaurant['opens'],
                $restaurant['closes'],
                $restaurant['category'],
                $restaurant['address'],
                $restaurant['photo']
            );
        }

        return $restaurants;
    }



    static function getRestaurantOwner(PDO $db, int $id)
    {
        $stmt = $db->prepare(
            'SELECT idUser 
                FROM Restaurant 
                WHERE idRestaurant = ?'
        );

        $stmt->execute(array($id));

        $user = $stmt->fetch();

        return $user['idUser'];
    }

    static function newRestaurant($db, $idUser, $name, $opens, $closes, $category, $address)
    {
        $stmt = $db->prepare('INSERT INTO Restaurant (idUser, name, opens, closes, category, address) 
                                values(?, ?, ?, ?, ?, ?)');
        try {
            $stmt->execute(array($idUser, $name, $opens, $closes, $category, $address));
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }


    static function updateRestaurant(PDO $db, string $name, string $opens, string $closes, string $category, string $address, int $id)
    {
        $stmt = $db->prepare('
                UPDATE Restaurant SET name = ?, opens = ?, closes = ?, category = ?, address = ?
                WHERE idRestaurant = ?
            ');

        try {
            $stmt->execute(array($name, $opens, $closes, $category, $address, $id));
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }


    static function getAverage(PDO $db, int $id): ?float
    {
        $stmt = $db->prepare(
            'SELECT avg(rating) as average
                 FROM Review
                 WHERE idRestaurant = ?
                '
        );
        $stmt->execute(array($id));

        $rating = $stmt->fetch();

        return floatval($rating['average']);
    }

    static function getDishRestaurant(PDO $db, $idDish)
    {
        $stmt = $db->prepare('
            SELECT restaurant.idRestaurant, idUser, restaurant.name, opens, closes, restaurant.category, address, restaurant.photo
            FROM dish, restaurant 
            WHERE idDish = ? and dish.idRestaurant = restaurant.idRestaurant;');

        $stmt->execute(array($idDish));

        $restaurant = $stmt->fetch();

        return new Restaurant(
            intval($restaurant['idRestaurant']),
            intval($restaurant['idUser']),
            $restaurant['name'],
            $restaurant['opens'],
            $restaurant['closes'],
            $restaurant['category'],
            $restaurant['address'],
            $restaurant['photo']
        );
    }


    static function deleteRestaurant(PDO $db, int $id)
    {
        $stmt = $db->prepare('
            DELETE FROM Restaurant WHERE idRestaurant = ?');
            
            try {
              $stmt->execute(array($id));
              return true;
            } catch (PDOException $e) {
              return false;
            }
          }

          static function deletePhoto(PDO $db, int $id) {
            $stmt = $db->prepare('
            UPDATE Restaurant SET photo = NULL where idRestaurant = ?');

            try {
                $stmt->execute(array($id));
                return true;
            } catch (PDOException $e) {
                return false;
            }
          }

    static function getOrderRestaurant(PDO $db, int $idOrder): ?Restaurant
    {
        $stmt = $db->prepare(
            'SELECT DISTINCT Request.idRestaurant, restaurant.idUser, name, opens, closes, category, address, photo
                 FROM Restaurant, Request
                 WHERE Request.idRequest = ?
                 AND Restaurant.idRestaurant = Request.idRestaurant'
        );
        $stmt->execute(array($idOrder));

        $restaurant = $stmt->fetch();
        if (!isset($restaurant['idRestaurant'])) return null;

        return new Restaurant(
            intval($restaurant['idRestaurant']),
            intval($restaurant['idUser']),
            $restaurant['name'],
            $restaurant['opens'],
            $restaurant['closes'],
            $restaurant['category'],
            $restaurant['address'],
            $restaurant['photo']
        );
    }

    static function getRestaurantOrders(PDO $db, int $idRestaurant): array
    {
        $stmt = $db->prepare(
            "SELECT idRequest
                 FROM Request
                 WHERE Request.idRestaurant = ?
                 AND state
                 LIKE 'Processing'"
        );
        $stmt->execute(array($idRestaurant));

        $orders = [];

        while ($order = $stmt->fetch()) {
            $orders[] = intval($order['idRequest']);
        }
        return $orders;
    }


    static function getReviewRestaurant(PDO $db, int $idReview): Restaurant
    {
        $stmt = $db->prepare(
            'SELECT DISTINCT Review.idRestaurant, restaurant.idUser, name, opens, closes, category, address, photo
                 FROM Restaurant, Review
                 WHERE Review.idReview = ?
                 AND Restaurant.idRestaurant = Review.idRestaurant'
        );
        $stmt->execute(array($idReview));

        $restaurant = $stmt->fetch();

        return new Restaurant(
            intval($restaurant['idRestaurant']),
            intval($restaurant['idUser']),
            $restaurant['name'],
            $restaurant['opens'],
            $restaurant['closes'],
            $restaurant['category'],
            $restaurant['address'],
            $restaurant['photo']
        );
    }



    static function updateRestaurantPhoto(PDO $db, string $photo, int $id)
    {
        $stmt = $db->prepare(
            'UPDATE restaurant SET photo = ? where idRestaurant = ?'
        );

        try {
            $stmt->execute(array($photo, $id));
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
}
