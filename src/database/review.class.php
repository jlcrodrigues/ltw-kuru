<?php
    declare(strict_type = 1);

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
                'SELECT idReview, idUser, idRestaurant, rating, fullText, data FROM REVIEW WHERE idRestaurant = ?');
            $stmt->execute(array($idRestaurant));

            $reviews = [];

            while ($review = $stmt->fetch()) {
                $reviews[] = new Review(
                    $review['idReview'],
                    $review['idUser'],
                    $review['idRestaurant'],
                    $review['rating'],
                    $review['fullText'],
                    $review['data']
                );
            }
            return $reviews;
        }

    }
?>