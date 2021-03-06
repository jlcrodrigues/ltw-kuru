<?php

declare(strict_types=1);

require_once('restaurant.class.php');
require_once('dish.class.php');

class User
{
    public int $id;
    public string $first_name;
    public string $last_name;
    public ?string $address;
    public ?string $city;
    public ?string $country;
    public ?string $phone;
    public string $email;
    public string $password;

    public function __construct(int $id, string $first_name, string $last_name, ?string $address, ?string $city, ?string $country, ?string $phone, string $email, string $password)
    {
        $this->id = $id;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->address = $address;
        $this->city = $city;
        $this->country = $country;
        $this->phone = $phone;
        $this->email = $email;
        $this->password = $password;
    }

    function name()
    {
        return $this->firstName . ' ' . $this->lastName;
    }

    static function updateUser(PDO $db, string $email, string $first_name, string $last_name, string $address, string $city, string $country, string $phone, int $id)
    {
        $stmt = $db->prepare('
            UPDATE USER SET email = ?, firstName = ?, lastName = ?, address = ?, city = ?, country = ?, phone = ?
            WHERE idUser = ?
        ');

        try {
            $stmt->execute(array($email, $first_name, $last_name, $address, $city, $country, $phone, $id));
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }



    static function getUserWithPassword(PDO $db, string $email, string $password): ?User
    {
        $stmt = $db->prepare(
            'SELECT idUser, firstName, lastName, address, city, country, phone, email, password FROM USER WHERE email = ? AND password = ?'
        );
        $stmt->execute(array($email, $password));

        if ($user = $stmt->fetch()) {
            return new User(
                intval($user['idUser']),
                $user['firstName'],
                $user['lastName'],
                $user['address'],
                $user['city'],
                $user['country'],
                $user['phone'],
                $user['email'],
                $user['password']
            );
        }

        return null;
    }


    static function getUsers(PDO $db, int $count): array
    {
        $stmt = $db->prepare(
            'SELECT idUser, firstName, lastName, address, city, country, phone, email, password
                 FROM User
                 LIMIT ?'
        );
        $stmt->execute(array($count));

        $users = array();
        while ($user = $stmt->fetch()) {
            $users = new User(
                $user['idUser'],
                $user['firstName'],
                $user['lastName'],
                $user['address'],
                $user['city'],
                $user['country'],
                $user['phone'],
                $user['email'],
                $user['password']
            );
        }
        return $users;
    }


    static function getUserById(PDO $db, int $id): User
    {
        $stmt = $db->prepare(
            'SELECT idUser, firstName, lastName, address, city, country, phone, email, password FROM  USER WHERE idUser = ?'
        );
        $stmt->execute(array($id));

        $user = $stmt->fetch();

        return new User(
            intval($user['idUser']),
            $user['firstName'],
            $user['lastName'],
            $user['address'],
            $user['city'],
            $user['country'],
            $user['phone'],
            $user['email'],
            $user['password']
        );
    }

    static function emailInUse(PDO $db, $email)
    {
        $stmt = $db->prepare('SELECT * FROM User where email = ?');
        $stmt->execute(array(strtolower($email)));
        return ($stmt->fetch() !== false);
    }


    static function newUser($db, $first_name, $last_name, $email, $password)
    {
        $stmt = $db->prepare('INSERT INTO User (firstName, lastName, email, password) values(?, ?, ?, ?)');
        try {
            $stmt->execute(array($first_name, $last_name, $email, $password));
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    static function getFavoriteRestaurants(PDO $db, int $idUser): array
    {
        $stmt = $db->prepare(
            'SELECT Restaurant.idRestaurant, Restaurant.idUser, name, opens, closes, category, address, photo
                 FROM Restaurant, Favorite_Restaurant
                 WHERE Restaurant.idRestaurant = Favorite_Restaurant.idRestaurant
                 AND Favorite_Restaurant.idUser = ?
                 '
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
                $restaurant['photo'],
            );
        }

        return $restaurants;
    }

    static function getFavoriteDishes(PDO $db, int $idUser): array
    {
        $stmt = $db->prepare(
            'SELECT Dish.idDish, idRestaurant, name, description, price, category
                 FROM Dish, Favorite_Dish
                 WHERE Dish.idDish = Favorite_Dish.idDish
                 AND Favorite_Dish.idUser = ?
                 '
        );
        $stmt->execute(array($idUser));

        $dishes = [];

        while ($dish = $stmt->fetch()) {
            $dishes[] = new Dish(
                intval($dish['idDish']),
                intval($dish['idRestaurant']),
                $dish['name'],
                $dish['description'],
                floatval($dish['price']),
                $dish['category']
            );
        }
        return $dishes;
    }

    static function isFavoriteRestaurant(PDO $db, int $idUser, int $idRestaurant): bool
    {
        $stmt = $db->prepare(
            'SELECT Restaurant.idRestaurant
                 FROM Restaurant, Favorite_Restaurant
                 WHERE Restaurant.idRestaurant = Favorite_Restaurant.idRestaurant
                 AND Favorite_Restaurant.idUser = ?
                 AND Restaurant.idRestaurant = ?
                 '
        );
        $stmt->execute(array($idUser, $idRestaurant));

        $restaurant = $stmt->fetchAll();
        return (count($restaurant) > 0);
    }

    static function setFavoriteRestaurant(PDO $db, int $idUser, int $idRestaurant): string
    {
        if (User::isFavoriteRestaurant($db, $idUser, $idRestaurant)) {
            $stmt = $db->prepare(
                'DELETE FROM Favorite_Restaurant
                 WHERE idUser = ?
                 AND idRestaurant = ?
                '
            );
            $stmt->execute(array($idUser, $idRestaurant));
            return "";
        } else {
            $stmt = $db->prepare(
                'INSERT INTO Favorite_Restaurant (idUser, idRestaurant) VALUES (?, ?)'
            );
            $stmt->execute(array($idUser, $idRestaurant));
            return "favorite-active";
        }
        return "error";
    }

    static function isFavoriteDish(PDO $db, int $idUser, int $idDish): bool
    {
        $stmt = $db->prepare(
            'SELECT Dish.idDish
                 FROM Dish, Favorite_Dish
                 WHERE Dish.idDish = Favorite_Dish.idDish
                 AND Favorite_Dish.idUser = ?
                 AND Dish.idDish = ?
                 '
        );
        $stmt->execute(array($idUser, $idDish));

        $dish = $stmt->fetchAll();
        return (count($dish) > 0);
    }

    static function setFavoriteDish(PDO $db, int $idUser, int $idDish): string
    {
        if (User::isFavoriteDish($db, $idUser, $idDish)) {
            $stmt = $db->prepare(
                'DELETE FROM Favorite_Dish
                 WHERE idUser = ?
                 AND idDish = ?
                '
            );
            $stmt->execute(array($idUser, $idDish));
            return "";
        } else {
            $stmt = $db->prepare(
                'INSERT INTO Favorite_Dish (idUser, idDish) VALUES (?, ?)'
            );
            $stmt->execute(array($idUser, $idDish));
            return "favorite-active";
        }
        return "error";
    }

    static function getOrdersByState(PDO $db, int $idUser, string $state): array
    {
        $stmt = $db->prepare(
            "SELECT idRequest
                 FROM Request
                 WHERE idUser = ?
                 AND state
                 LIKE ?
                 "
        );
        $stmt->execute(array($idUser, $state));

        $orders = [];

        while ($order = $stmt->fetch()) {
            $orders[] = $order['idRequest'];
        }
        return $orders;
    }

    static function getOrderByRestaurant(PDO $db, int $idUser, int $idRestaurant): ?int
    {
        $stmt = $db->prepare("
            SELECT idRequest
            FROM Request
            WHERE idUser = ?
            AND idRestaurant = ?
            AND state
            LIKE 'Ordering'
        ");
        $stmt->execute(array($idUser, $idRestaurant));
        $id = $stmt->fetch();
        if ($id == FALSE) return null;
        return intval($id['idRequest']);
    }

    static function deleteOrder(PDO $db, int $idUser, int $idOrder)
    {
        $stmt = $db->prepare("
            DELETE
            FROM Request
            WHERE idUser = ?
            AND idRequest = ?
            AND state
            LIKE 'Ordering'
        ");
        $count = $stmt->execute(array($idUser, $idOrder));
        if ($count) {
            $stmt = $db->prepare("
                DELETE
                FROM Request_Dish
                WHERE idRequest = ?
            ");
            $stmt->execute(array($idOrder));
            $stmt->fetchAll();
        }
    }

    static function submitOrder(PDO $db, int $idUser, int $idOrder)
    {
        $stmt = $db->prepare("
            UPDATE Request
            SET state = 'Processing'
            WHERE idUser = ?
            AND idRequest = ?
            AND state
            LIKE 'Ordering'
        ");
        $stmt->execute(array($idUser, $idOrder));
        $stmt->fetch();
    }

    static function deliverOrder(PDO $db, int $idUser, int $idOrder)
    {
        $stmt = $db->prepare("
            UPDATE Request
            SET state = 'Completed'
            WHERE idUser = ?
            AND idRequest = ?
            AND state
            LIKE 'Processing'
        ");
        $stmt->execute(array($idUser, $idOrder));
        $stmt->fetch();
    }

    static function deleteOrderDish(PDO $db, int $idUser, int $idOrder, int $idDish)
    {
        $stmt = $db->prepare("
            SELECT idUser
            FROM Request
            WHERE idRequest = ?;
            AND state
            LIKE 'Ordering'
        ");
        $stmt->execute(array($idOrder));
        if ($stmt->fetch()['idUser'] != $idUser) return;

        $stmt = $db->prepare("
            DELETE
            FROM Request_Dish
            WHERE idRequest = ?
            AND idDish = ?
        ");
        $stmt->execute(array($idOrder, $idDish));
        $stmt->fetch();
    }

    static function repeatOrder(PDO $db, int $idUser, int $idOrder)
    {
        $restaurant = Restaurant::getOrderRestaurant($db, $idOrder);
        $dishes = Dish::getOrderDishes($db, $idOrder);
        $id = User::getOrderByRestaurant($db, $idUser, $restaurant->id);
        if ($id == null) {
            $stmt = $db->prepare("
                INSERT
                INTO REQUEST
                (idUser, idRestaurant, state)
                VALUES (?, ?, 'Ordering')
            ");
            $stmt->execute(array($idUser, $restaurant->id));
            $stmt->fetch();
            $stmt = $db->prepare("
                SELECT idRequest
                FROM Request
                WHERE idUser = ?
                AND idRestaurant = ?
                AND state
                LIKE 'Ordering'
            ");
            $stmt->execute(array($idUser, $restaurant->id));
            $id = intval($stmt->fetch()['idRequest']);
        }
        foreach($dishes as $dish){
            $stmt = $db->prepare("
                INSERT
                INTO REQUEST_DISH
                (idRequest, idDish)
                VALUES (?, ?)
            ");
            $stmt->execute(array($id, $dish->idDish));
            $stmt->fetch();
        }
    }

    static function getOrderUser(PDO $db, int $idOrder): User
    {
        $stmt = $db->prepare(
            'SELECT User.idUser, firstName, lastName, address, city, country, phone, email, password
            FROM USER, REQUEST
            WHERE User.idUser = Request.idUser
            AND Request.idRequest = ?'
        );
        $stmt->execute(array($idOrder));

        $user = $stmt->fetch();

        return new User(
            intval($user['idUser']),
            $user['firstName'],
            $user['lastName'],
            $user['address'],
            $user['city'],
            $user['country'],
            $user['phone'],
            $user['email'],
            $user['password']
        );
    }


    function updateUserPhoto(PDO $db, string $photo, int $id) {
        $stmt = $db->prepare(
            'UPDATE user SET photo = ? where idUser = ?');

        try {
            $stmt->execute(array($photo, $id));
            return true;
        } catch (PDOException $e) {
            return false;
          }
    }

}
