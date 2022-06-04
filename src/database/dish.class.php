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

    public function __construct(int $idDish, int $idRestaurant, string $name, string $description, float $price, string $category)
    {
      $this->idDish = $idDish;
      $this->idRestaurant = $idRestaurant;
      $this->name = $name;
      $this->description = $description;
      $this->price = $price;
      $this->category = $category;
    }

    static function getRestaurantDishes(PDO $db, int $idRestaurant) : array {
        $stmt = $db->prepare(
          'SELECT idDish, idRestaurant, name, description, price, category 
          FROM Dish 
          WHERE idRestaurant = ?');
        $stmt->execute(array($idRestaurant));
    
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

    static function getDish(PDO $db, int $idDish) : Dish {
      $stmt = $db->prepare(
        'SELECT idDish, idRestaurant, name, description, price, category 
        FROM Dish
        WHERE idDish = ?');

      $stmt->execute(array($idDish));
  
      $dish = $stmt->fetch();

      return new Dish(
        intval($dish['idDish']), 
        intval($dish['idRestaurant']),
        $dish['name'],
        $dish['description'],
        floatval($dish['price']),
        $dish['category']
      );
    }

    static function getDishCategories(PDO $db, int $idRestaurant) : array {
        $stmt = $db->prepare(
          'SELECT DISTINCT category 
          FROM Dish
          WHERE idRestaurant = ?');
        $stmt->execute(array($idRestaurant));
    
        $categories = [];
  
        while ($category = $stmt->fetch()) {
          $categories[] = $category['category'];
        }
        return $categories;
      }

    static function getRestaurantDishesByCategory(PDO $db, string $category, int $idRestaurant) : array {
        $stmt = $db->prepare(
          'SELECT idDish, idRestaurant, name, description, price, category 
          FROM Dish 
          WHERE category
          LIKE ?
          AND idRestaurant = ?
          LIMIT 7');
        $stmt->execute(array($category . '%', $idRestaurant));
    
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

    static function addDish(PDO $db, $idDish, $idRestaurant, $name, $description, $price, $promotion, $category) {
        $stmt = $db->prepare('INSERT into Dish (idDish, idRestaurant, name, description, price, promotion, category) VALUES (?, ?, ?, ?, ?, ?, ?');

        try {
            $stmt->execute(array($idDish, $idRestaurant, $name, $description, $price, $promotion, $category));
            return true;
        }
        catch (Exception $e) {
            return false;
        }
    }

    static function getOrderDishes(PDO $db, int $idOrder) : array {
        $stmt = $db->prepare(
          'SELECT Dish.idDish, Dish.idRestaurant, name, description, price, category 
          FROM Dish, Request_Dish
          WHERE idRequest = ?
          AND Dish.idDish = Request_Dish.idDish');
        $stmt->execute(array($idOrder));
    
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

    static function addDishToOrder(PDO $db, int $idDish, int $idUser) {
      $dish = Dish::getDish($db, $idDish);

      // Check for existing orders
      if (User::getOrderByRestaurant($db, $idUser, $dish->idRestaurant) == null) {
        $stmt = $db->prepare("
          INSERT INTO REQUEST (idUser, idRestaurant, state)
          VALUES (?, ?, 'Ordering')
        ");
        $stmt->execute(array($idUser, $dish->idRestaurant));
      }

      // Get the id of the Order
      $id = User::getOrderByRestaurant($db, $idUser, $dish->idRestaurant);

      // Add the dish to the orders
      $stmt = $db->prepare("
        INSERT INTO REQUEST_DISH (idRequest, idDish)
        VALUES (?, ?)
      ");
      $stmt->execute(array($id, $dish->idDish));
    }
  }
?>