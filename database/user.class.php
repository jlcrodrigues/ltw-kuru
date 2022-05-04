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

        static function getUsers(PDO $db, int $count) : array {
            $stmt = $db->prepare(
                'SELECT idUser, firstName, lastName, address, city, country, phone, email, password
                 FROM User
                 LIMIT ?');
            $stmt->execute(array($count));

            $users = array();
            while ($user = $stmt->fetch()){
                $users = new User($user['idUser'],$user['firstName'],$user['lastName'],$user['address'],$user['city'],$user['country'],$user['phone'],$user['email'],$user['password']);
            }
            return $users;
        }


        static function getUser(PDO $db, string $email, string $password) : User {
            $stmt = $db->prepare(
                'SELECT idUser, firstName, lastName, address, city, country, phone, email, password
                 FROM Restaurant
                 WHERE email = ?
                 AND password = ?');
            $stmt->execute(array($email,$password));
        
            $user = $stmt->fetch();
        
            return new User($user['idUser'],$user['firstName'],$user['lastName'],$user['address'],$user['city'],$user['country'],$user['phone'],$user['email'],$user['password']);
        }  
    }
?>