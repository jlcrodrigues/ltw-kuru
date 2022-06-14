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
    public ?string $photo;
    

    public function __construct(int $idDish, int $idRestaurant, string $name, string $description, float $price, string $category, ?string $photo)
    {
      $this->idDish = $idDish;
      $this->idRestaurant = $idRestaurant;
      $this->name = $name;
      $this->description = $description;
      $this->price = $price;
      $this->category = $category;
      $this->photo = $photo;
    }

    static function getRestaurantDishes(PDO $db, int $idRestaurant) : array {
        $stmt = $db->prepare(
          'SELECT idDish, idRestaurant, name, description, price, category, photo
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
            $dish['category'],
            $dish['photo']
          );
        }
        return $dishes;
      }

    static function getDish(PDO $db, int $idDish) : Dish {
      $stmt = $db->prepare(
        'SELECT idDish, idRestaurant, name, description, price, category, photo 
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
        $dish['category'],
        $dish['photo']
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
          'SELECT idDish, idRestaurant, name, description, price, category, photo 
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
            $dish['category'],
            $dish['photo']
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

    static function updateDish(PDO $db, string $name, string $description, float $price, string $category, int $id) {
      $stmt = $db->prepare('
          UPDATE Dish SET name = ?, description = ?, price = ?, category = ?
          WHERE idDish = ?
      ');
      
      try {
          $stmt->execute(array($name, $description, $price, $category, $id));
          return true;
      } catch (PDOException $e) {
          return false;
      }
  }

  static function deleteDish(PDO $db, int $id) {
    $stmt = $db->prepare('
    DELETE FROM DISH WHERE idDish = ?');
    
    try {
      $stmt->execute(array($id));
      return true;
    } catch (PDOException $e) {
      return false;
    }
  }

  static function newDish(PDO $db, int $idRestaurant, string $name, string $description, float $price, string $category) {
    $stmt = $db->prepare('
      INSERT INTO Dish (idRestaurant, name, description, price, category)
      VALUES (?, ?, ?, ?, ?)'
    );
    
    try {
      $stmt->execute(array($idRestaurant, $name, $description, $price, $category));
      return true;
    } catch (PDOException $e) {
      return true;
    }
  }


    static function getOrderDishes(PDO $db, int $idOrder) : array {
        $stmt = $db->prepare(
          'SELECT Dish.idDish, Dish.idRestaurant, name, description, price, category, photo 
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
            $dish['category'],
            $dish['photo']
          );
        }
        return $dishes;
      }

    static function addDishToOrder(PDO $db, int $idDish, int $idUser, int $quantity) {
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
      for ($i = 0; $i < $quantity; $i++) {
        $stmt = $db->prepare("
          INSERT INTO REQUEST_DISH (idRequest, idDish)
          VALUES (?, ?)
        ");
        $stmt->execute(array($id, $dish->idDish));
      }
    }

  static function updateDishPhoto(PDO $db, string $photo, int $id) {
    $stmt = $db->prepare(
        'UPDATE dish SET photo = ? where idDish = ?');

    try {
        $stmt->execute(array($photo, $id));
        return true;
    } catch (PDOException $e) {
        return false;
      }
  }

  static function deletePhoto(PDO $db, int $id) {
    $stmt = $db->prepare('
    UPDATE Dish SET photo = NULL where idDish = ?');

    try {
        $stmt->execute(array($id));
        return true;
    } catch (PDOException $e) {
        return false;
    }
  }
}
?>