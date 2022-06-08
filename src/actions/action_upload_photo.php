<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../utils/session.php');

    require_once(__DIR__ . '/../database/restaurant.class.php');
    require_once(__DIR__ . '/../database/connection.db.php');
    require_once(__DIR__ . '/../database/user.class.php');

    $session = new Session();
    $db = getDatabaseConnection();
    $id = $_POST['id_restaurant'];
    // $id = intval($_GET['id']);

    if (!$session->isOwner($session->getId()) || !$session->isLoggedIn() || Restaurant::getRestaurantOwner($db, intval($id)) != $session->getId()) {
        die(header('Location: /')); 
     }

    //  if ( !preg_match ("/^https?:\/\/(?:[a-z-]+.)+[a-z]{2,6}(?:\/[^\#?]+)+.(?:jpe?g|gif|png)$/", $_POST['picture'])) {
    //     die("Location: ../profile.php");
    //  }


     if (!is_dir('../photos')) mkdir('photos');
     if (!is_dir('../photos/originals')) mkdir('photos/originals');
     if (!is_dir('../photos/medium')) mkdir('photos/medium');
     if (!is_dir('../photos/thumbnails')) mkdir('photos/thumbs_small');

    //  $originalFileName = "photos/originals/$id.jpg";
    //  $thumbNailFileName = "photos/thumbnails/$id.jpg";

    $originalDir = '../photos/originals/';
    $mediumDir = '../photos/medium/';
    $thumbnailDir = '../photos/thumbnails/';
    $photo = $_FILES['restaurant_image'];

    if ($photo['size']) {

        // original photo section
        $extension = pathinfo($photo['name'], PATHINFO_EXTENSION);
        $original_photo_path = $originalDir . $id . '.' . $extension; 
        $medium_photo_path = $mediumDir . $id . "." . $extension;
        $thumbnail_photo_path = $thumbnailDir . $id . "." . $extension;
        $dbDir = $id . '.' . $extension;
        move_uploaded_file($photo['tmp_name'], $original_photo_path);


        // medium photo section
        $original = imagecreatefromjpeg($original_photo_path);
        if (!$original) $original = imagecreatefrompng($original_photo_path);
        if (!$original) $original = imagecreatefromgif($original_photo_path);
        if (!$original) die();

        $max_width = 500;
        $max_height = 300;
        $photo_width = imagesx($original);
        $photo_height = imagesy($original);
        $new_width = $photo_height * $max_width/$max_height;
        $new_height = $photo_width * $max_height/$max_width;

        $medium_photo = imagecreatetruecolor($photo_width, $photo_height);
        if($new_width > $photo_width) {
            $h_point = (($photo_height - $new_height) / 2);
            imagecopyresampled($medium_photo, $original, 0, 0, 0, $h_point, $max_width, $max_height, $photo_width, intval($new_width)); 
        } else {
            $w_point = (($photo_width - $new_width / 2));
            imagecopyresampled($medium_photo, $original, 0, 0, $w_point, 0, $max_width, $max_height, intval($new_width), $photo_height); 
        }
        imagejpeg($medium_photo, $medium_photo_path);

        if (Restaurant::updateRestaurantPhoto($db, $dbDir, intval($id))) {
            $session->addMessage('success', 'Photo updated!');
            die(header('Location: ' . $_SERVER['HTTP_REFERER']));
        }
    }

?>