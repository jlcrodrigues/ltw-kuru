<?php
  require_once(__DIR__ . '/../database/restaurant.class.php');
  require_once(__DIR__ . '/../database/connection.db.php');

  class Session {
    private array $messages;

    public function __construct() {
      session_start();

      $this->messages = isset($_SESSION['messages']) ? $_SESSION['messages'] : array();
      unset($_SESSION['messages']);
    }

    public function isLoggedIn() : bool {
      return isset($_SESSION['id']);    
    }

    public function getId() : ?int {
      return isset($_SESSION['id']) ? intval($_SESSION['id']) : null;    
    }

    public function isOwner(int $id) : bool {
      $db = getDatabaseConnection();
      $onwer_restaurants = Restaurant::getOwnerRestaurants($db, $id);
      if (empty($onwer_restaurants)) {
        return false;
      }
      return true;
    }

    public function isOwnerRestaurant(int $idRestaurant) : bool {
      if (!self::isOwner(self::getId())) return false;
      $db = getDatabaseConnection();
      $restaurant = Restaurant::getRestaurant($db, $idRestaurant);
      if ($restaurant->idUser == self::getId()) return true;
      return false;
    }

    public function logout() {
      session_destroy();
    }


    public function getName() : ?string {
      return isset($_SESSION['name']) ? $_SESSION['name'] : null;
    }

    public function setId(int $id) {
      $_SESSION['id'] = $id;
    }

    public function setName(string $name) {
      $_SESSION['name'] = $name;
    }

    public function addMessage(string $type, string $text) {
      $_SESSION['messages'][] = array('type' => $type, 'text' => $text);
    }

    public function getMessages() {
      return $this->messages;
    }
  }
?>