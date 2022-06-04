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
            'SELECT Restaurant.idRestaurant, name, opens, closes, category, address
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
                $restaurant['name'],
                $restaurant['opens'],
                $restaurant['closes'],
                $restaurant['category'],
                $restaurant['address']
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

    static function setFavoriteRestaurant(PDO $db, int $idUser, int $idRestaurant) : string
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

    static function setFavoriteDish(PDO $db, int $idUser, int $idDish)
    {
        if (User::isFavoriteDish($db, $idUser, $idDish)) {
            $stmt = $db->prepare(
                'DELETE FROM Favorite_Dish
                 WHERE idUser = ?
                 AND idDish = ?
                '
            );
            $stmt->execute(array($idUser, $idDish));
        } else {
            $stmt = $db->prepare(
                'INSERT INTO Favorite_Dish (idUser, idDish) VALUES (?, ?)'
            );
            $stmt->execute(array($idUser, $idDish));
        }
    }
}
