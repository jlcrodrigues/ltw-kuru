<?php
  declare(strict_types = 1);

  class Dish {
    public int $idDish;
    public int $idRestaurant;
    public string $name;
    public string $description;
    public float $price;
    public int $promotion;
    public string $category;

    public function __construct(int $idDish, int $idRestaurant, string $name, string $description, float $price, int $promotion, string $category)
    {
      $this->idDish = $idDish;
      $this->idRestaurant = $idRestaurant;
      $this->name = $name;
      $this->description = $description;
      $this->price = $price;
      $this->promotion = $promotion;
      $this->category = $category;
    }

    static function getRestaurantDishes(PDO $db, int $idRestaurant) : array {
        $stmt = $db->prepare('SELECT idDish, idRestaurant, name, description, price, promotion, category FROM Dish WHERE idRestaurant = ?');
        $stmt->execute(array($idRestaurant));
    
        $dishes = [];
  
        while ($dish = $stmt->fetch()) {
          $dishes[] = new Dish(
            $dish['idDish'], 
            $dish['idRestaurant'],
            $dish['name'],
            $dish['desctiption'],
            $dish['price'],
            $dish['pomotion'],
            $dish['category']
          );
        }
        return $dishes;
      }

    static function getDish(PDO $db, int $idDish) : Dish {
      $stmt = $db->prepare('
      SELECT idDish, idRestaurant, name, description, price, promotion, category from Dish where idDish = ?');

      $stmt->execute(array($idDish));
  
      $dish = $stmt->fetch();
  
      return new Dish(
        $dish['idDish'], 
        $dish['idRestaurant'],
        $dish['name'],
        $dish['desctiption'],
        $dish['price'],
        $dish['pomotion'],
        $dish['category']
      );
    }

    function addDish(PDO $db, $idDish, $idRestaurant, $name, $description, $price, $promotion, $category) {
        $stmt = $db->prepare('INSERT into Dish (idDish, idRestaurant, name, description, price, promotion, category) VALUES (?, ?, ?, ?, ?, ?, ?');

        try {
            $stmt->execute(array($idDish, $idRestaurant, $name, $description, $price, $promotion, $category));
            return true;
        }
        catch (Exception $e) {
            return false;
        }
    }
  }
?>