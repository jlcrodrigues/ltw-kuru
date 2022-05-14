<?php
    declare(strict_type=1);

    class User{
        public int $id;
        public string $first_name;
        public string $last_name;
        public string $address;
        public string $city;
        public string $country;
        public string $phone;
        public string $email;
        public string $password;

        public function __construct(int $id, string $first_name, string $last_name, string $address, string $city,string $country, string $phone, string $email, string $password){
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

        function name() {
            return $this->firstName . ' ' . $this->lastName;
          }

        function save($db) {
        $stmt = $db->prepare('
            UPDATE Customer SET FirstName = ?, LastName = ?
            WHERE CustomerId = ?
        ');
    
        $stmt->execute(array($this->firstName, $this->lastName, $this->id));
        }

        // function getNumUsers() {
        //     $stmt = $db->prepare('
        //     SELECT COUNT(*) FROM USER');
        //     $stmt->execute();
        //     $number = $stmt->fetch();
        //     return $number;

        // }

        function isLoginCorrect($username, $password) {
            global $dbh;
            $stmt = $dbh->prepare('SELECT * FROM User WHERE username = ?');
            $stmt->execute(array(strtolower($username)));
            $user = $stmt->fetch();
            return ($user !== false && password_verify($password, $user['password']));
        }


        function newUser(PDO $db, int $id, string $first_name, string $last_name, string $address, string $city, string $country, string $phone, string $email, string $password){
            $stmt = $db->prepare('INSERT INTO User (idUser, fistName, lastName, address, city, country, phone, email, password) values(?, ?, ?, ?, ?, ?, ?, ?, ?)');
            try {
                  $stmt->execute(array($id, $first_name, $last_name, $address, $city, $country, $phone, $email, $password));
                return true;
            }
            catch (Exception $e) {
                return false;
            }
        }

        static function getUsers(PDO $db, int $count) : array {
            $stmt = $db->prepare(
                'SELECT idUser, firstName, lastName, address, city, country, phone, email, password
                 FROM User
                 LIMIT ?');
            $stmt->execute(array($count));

            $users = array();
            while ($user = $stmt->fetch()){
                $users = new User($user['idUser'],
                $user['firstName'],
                $user['lastName'],
                $user['address'],
                $user['city'],
                $user['country'],
                $user['phone'],
                $user['email'],
                $user['password']);
            }
            return $users;
        }


        static function getUserById(PDO $db, int $id) : User {
            $stmt = $db->prepare(
                'SELECT idUser, firstName, lastName, address, city, country, phone, email, password FROM  USER WHERE idUser = ?');
            $stmt->execute(array($id));
        
            $user = $stmt->fetch();
        
            return new User(
                $user['idUser'],
                $user['firstName'],
                $user['lastName'],
                $user['address'],
                $user['city'],
                $user['country'],
                $user['phone'],
                $user['email'],
                $user['password']);
        }


        static function getUser(PDO $db, string $email, string $password) : User {
            $stmt = $db->prepare(
                'SELECT idUser, firstName, lastName, address, city, country, phone, email, password
                 FROM Restaurant
                 WHERE email = ?
                 AND password = ?');
            $stmt->execute(array($email,$password));
        
            $user = $stmt->fetch();
        
            return new User(
                $user['idUser'],
                $user['firstName'],
                $user['lastName'],
                $user['address'],
                $user['city'],
                $user['country'],
                $user['phone'],
                $user['email'],
                $user['password']);
        }  
    }
?>