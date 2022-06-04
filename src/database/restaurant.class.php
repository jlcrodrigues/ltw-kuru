<?php
    declare(strict_types = 1);

    class Restaurant{
        public int $id;
        public string $name;
        public string $opens;
        public string $closes;
        public string $category;
        public string $address;

        public function __construct(int $id, string $name, string $opens, string $closes, string $category,string $address){
            $this->id = $id;
            $this->name = $name;
            $this->opens = $opens;
            $this->closes = $closes;
            $this->category = $category;
            $this->address = $address;
        }

        static function getRestaurants(PDO $db, int $count) : array {
            $stmt = $db->prepare(
                'SELECT idRestaurant, name, opens, closes, category, address
                 FROM Restaurant
                 LIMIT ?');
            $stmt->execute(array($count));

            $restaurants = array();
            while ($restaurant = $stmt->fetch()){
               $restaurants[] = new Restaurant(
                  intval($restaurant['idRestaurant']),
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
                'SELECT idRestaurant, name, opens, closes, category, address
                 FROM Restaurant
                 WHERE name 
                 LIKE ? 
                 LIMIT ?');
            $stmt->execute(array($search . '%', $count));
        
            $restaurants = array();
            while ($restaurant = $stmt->fetch()) {
              $restaurants[] = new Restaurant(
                  intval($restaurant['idRestaurant']),
                  $restaurant['name'],
                  $restaurant['opens'],
                  $restaurant['closes'],
                  $restaurant['category'],
                  $restaurant['address']);
            }
        
            return $restaurants;
        }

        static function getCategories(PDO $db) : array {
            $stmt = $db->prepare(
                'SELECT DISTINCT category
                 FROM Restaurant');
            $stmt->execute();
            $result = $stmt->fetchAll();
            $categories = [];
            foreach ($result as $r) {$categories[] = $r['category'];}
            return $categories;
        }

        static function getRestaurantsByCategory(PDO $db, string $category) : array {
            $stmt = $db->prepare(
                'SELECT idRestaurant, name, opens, closes, category, address
                 FROM Restaurant
                 WHERE category
                 LIKE ?');
            $stmt->execute(array($category . '%'));
        
            $restaurants = array();
            while ($restaurant = $stmt->fetch()) {
              $restaurants[] = new Restaurant(
                  intval($restaurant['idRestaurant']),
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
                'SELECT idRestaurant, name, opens, closes, category, address
                 FROM Restaurant
                 WHERE idRestaurant = ?');
            $stmt->execute(array($id));
        
            $restaurant = $stmt->fetch();
        
            return new Restaurant(
                intval($restaurant['idRestaurant']),
                $restaurant['name'],
                $restaurant['opens'],
                $restaurant['closes'],
                $restaurant['category'],
                $restaurant['address']);
        }  

        static function getOrderRestaurant(PDO $db, int $idOrder) : Restaurant {
            $stmt = $db->prepare(
                'SELECT DISTINCT Request.idRestaurant, name, opens, closes, category, address
                 FROM Restaurant, Request
                 WHERE Request.idRequest = ?
                 AND Restaurant.idRestaurant = Request.idRestaurant');
            $stmt->execute(array($idOrder));
        
            $restaurant = $stmt->fetch();
        
            return new Restaurant(
                intval($restaurant['idRestaurant']),
                $restaurant['name'],
                $restaurant['opens'],
                $restaurant['closes'],
                $restaurant['category'],
                $restaurant['address']);
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
