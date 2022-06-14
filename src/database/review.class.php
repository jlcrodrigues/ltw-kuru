<?php
    declare(strict_types = 1);

    class Review{
        public int $idReview;
        public int $idUser;
        public int $idRestaurant;
        public int $rating;
        public string $fullText;
        public string $data;

        public function __construct(int $idReview, int $idUser, int $idRestaurant, int $rating, string $fullText, string $data) {
            $this->idReview = $idReview;
            $this->idUser = $idUser;
            $this->idRestaurant = $idRestaurant;
            $this->rating = $rating;
            $this->fullText = $fullText;
            $this->data = $data;
        }

        static function getRestaurantReviews(PDO $db, int $idRestaurant) : array {
            $stmt = $db->prepare(
                'SELECT idReview, idUser, idRestaurant, rating, fullText, data
                 FROM REVIEW WHERE idRestaurant = ?');
            $stmt->execute(array($idRestaurant));

            $reviews = [];

            while ($review = $stmt->fetch()) {
                $reviews[] = new Review(
                    intval($review['idReview']),
                    intval($review['idUser']),
                    intval($review['idRestaurant']),
                    intval($review['rating']),
                    $review['fullText'],
                    $review['data']
                );
            }
            return $reviews;
        }

        static function getUserReviews(PDO $db, int $idUser) : array {
            $stmt = $db->prepare(
                'SELECT idReview, idUser, idRestaurant, rating, fullText, data
                 FROM REVIEW WHERE idUser = ?');
            $stmt->execute(array($idUser));

            $reviews = [];

            while ($review = $stmt->fetch()) {
                $reviews[] = new Review(
                    intval($review['idReview']),
                    intval($review['idUser']),
                    intval($review['idRestaurant']),
                    intval($review['rating']),
                    $review['fullText'],
                    $review['data']
                );
            }
            return $reviews;
        }

        static function addReview(PDO $db, int $idUser, int $idRestaurant, int $rating, string $text) {
            $stmt = $db->prepare(
                'INSERT INTO Review(idUser, idRestaurant, rating, fullText, data)
                 VALUES (?, ?, ?, ?, ?)');
            $stmt->execute(array($idUser, $idRestaurant, $rating, $text, date("d/m/Y")));
        }
    }
?>