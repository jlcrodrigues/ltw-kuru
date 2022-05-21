<?php
    declare(strict_types = 1);

    class Restaurant{
        public int $id;
        public int $idUser;
        public string $name;
        public string $opens;
        public string $closes;
        public string $category;
        public string $address;

        public function __construct(int $id, int $idUser, string $name, string $opens, string $closes, string $category,string $address){
            $this->id = $id;
            $this->idUser = $idUser;
            $this->name = $name;
            $this->opens = $opens;
            $this->closes = $closes;
            $this->category = $category;
            $this->address = $address;
        }

        static function getRestaurants(PDO $db, int $count) : array {
            $stmt = $db->prepare(
                'SELECT idRestaurant, idUser, name, opens, closes, category, address
                 FROM Restaurant
                 LIMIT ?');
            $stmt->execute(array($count));

            $restaurants = array();
            while ($restaurant = $stmt->fetch()){
                $restaurants[] = new Restaurant(
                    $restaurant['idRestaurant'],
                    $restaurant['idUser'],
                    $restaurant['name'],
                    $restaurant['opens'],
                    $restaurant['closes'],
                    $restaurant['category'],
                    $restaurant['address']);
            }
            return $restaurants;
        }

        static function searchRestaurants(PDO $db, string $search, int $count) : array {
            $stmt = $db->prepare(
                'SELECT idRestaurant, idUser, name, opens, closes, category, address
                 FROM Restaurant
                 WHERE name 
                 LIKE ? 
                 LIMIT ?');
            $stmt->execute(array($search . '%', $count));
        
            $restaurants = array();
            while ($restaurant = $stmt->fetch()) {
              $restaurants[] = new Restaurant(
                  $restaurant['idRestaurant'],
                  $restaurant['idUser'],
                  $restaurant['name'],
                  $restaurant['opens'],
                  $restaurant['closes'],
                  $restaurant['category'],
                  $restaurant['address']);
            }
        
            return $restaurants;
        }


        static function getRestaurant(PDO $db, int $id) : Restaurant {
            $stmt = $db->prepare(
                'SELECT idRestaurant, idUser, name, opens, closes, category, address
                 FROM Restaurant
                 WHERE idRestaurant = ?');
            $stmt->execute(array($id));
        
            $restaurant = $stmt->fetch();
        
            return new Restaurant(
                $restaurant['idRestaurant'],
                $restaurant['idUser'],
                $restaurant['name'],
                $restaurant['opens'],
                $restaurant['closes'],
                $restaurant['category'],
                $restaurant['address']);
        }  



        static function getOwnerRestaurants(PDO $db, int $idUser) {
            $stmt = $db->prepare(
                'SELECT idRestaurant, idUser, name, opens, closes, category, address
                FROM RESTAURANT 
                WHERE idUser = ?'
            );

            $stmt->execute(array($idUser));

            $restaurants = array();
                while ($restaurant = $stmt->fetch()){
                    $restaurants[] = new Restaurant(
                        $restaurant['idRestaurant'],
                        $restaurant['idUser'],
                        $restaurant['name'],
                        $restaurant['opens'],
                        $restaurant['closes'],
                        $restaurant['category'],
                        $restaurant['address']);
                }
                return $restaurants;
        }

        static function getRestaurantOwner(PDO $db, int $id) {
            $stmt = $db->prepare(
                'SELECT idUser 
                FROM Restaurant 
                WHERE idRestaurant = ?'
            );

            $stmt->execute(array($id));

            $user = $stmt->fetch();

            return $user['idUser'];
            
        }

        static function newRestaurant($db, $idUser, $name, $opens, $closes, $category, $address){
            $stmt = $db->prepare('INSERT INTO Restaurant (idUser, name, opens, closes, category, address) values(?, ?, ?, ?, ?, ?)');
            try {
                  $stmt->execute(array($idUser, $name, $opens, $closes, $category, $address));
                return true;
            }
            catch (PDOException $e) {
                return false;
            }
        }


        static function updateRestaurant(PDO $db, string $name, string $opens, string $closes, string $category, string $address, int $id) {
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


        static function getAverage(PDO $db, int $id) : ?float {
            $stmt = $db->prepare(
                'SELECT avg(rating) as average
                 FROM Review
                 WHERE idRestaurant = ?
                ');
            $stmt->execute(array($id));

            $rating = $stmt->fetch();

            return floatval($rating['average']);
        }

    }
?>