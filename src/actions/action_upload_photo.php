<?php 
    require_once(__DIR__ . '/../utils/session.php');

    require_once(__DIR__ . '/../database/restaurant.class.php');
    require_once(__DIR__ . '/../database/connection.db.php');
    require_once(__DIR__ . '/../database/user.class.php');

    $session = new Session();
    $db = getDatabaseConnection();
    $id = $_POST['id_restaurant'];

    if (!$session->isOwner($session->getId()) || !$session->isLoggedIn() || Restaurant::getRestaurantOwner($db, intval($id)) != $session->getId()) {
        die(header('Location: /')); 
     }


     if (!is_dir('../photos')) mkdir('photos');
     if (!is_dir('../photos/restaurants')) mkdir('photos/restaurants');
     if (!is_dir('../photos/restaurants/originals')) mkdir('photos/restaurants/riginals');
     if (!is_dir('../photos/restaurants/medium')) mkdir('photos/restaurants/medium');
     if (!is_dir('../photos/restaurants/mini')) mkdir('photos/restaurants/mini');
     if (!is_dir('../photos/restaurants/thumbnails')) mkdir('photos/restaurants/thumbs_small');


    $originalDir = '../photos/restaurants/originals/';
    $mediumDir = '../photos/restaurants/medium/';
    $miniDir = '../photos/restaurants/mini/';
    $thumbnailDir = '../photos/restaurants/thumbnails/';
    $photo = $_FILES['restaurant_image'];

    if ($photo['size']) {

        // creating photo paths
        $original_photo_path = $originalDir . $id . '.jpg'; 
        $medium_photo_path = $mediumDir . $id . '.jpg';
        $mini_photo_path = $miniDir . $id . '.jpg';
        $thumbnail_photo_path = $thumbnailDir . $id . '.jpg';
        $dbDir = $id . '.jpg';

        // move original photo to respective directory
        move_uploaded_file($photo['tmp_name'], $original_photo_path);

        // copy of original photo
        $original = imagecreatefromjpeg($original_photo_path);
        if (!$original) $original = imagecreatefrompng($original_photo_path);
        if (!$original) $original = imagecreatefromgif($original_photo_path);
        if (!$original) {
            $session->addMessage('error', 'Error uploading file!');
            die(header('Location: ' . $_SERVER['HTTP_REFERER']));
        };

        // medium photo section
        $max_width = 500;
        $max_height = 300;
        $medium_photo = resizePhoto($original, $max_width, $max_height);
        imagejpeg($medium_photo, $medium_photo_path);

        // mini photo section
        $max_width = 200;
        $max_height = 200;
        $photo_width = imagesx($original);
        $photo_height = imagesy($original);
        $square = min($photo_width, $photo_height);
        $mini_photo = imagecreatetruecolor(200, 200);
        imagecopyresized($mini_photo, $original, 0, 0, ($photo_width>$square)?($photo_width-$square)/2:0, ($photo_height>$square)?($photo_height-$square)/2:0, $max_width, $max_height, $square, $square);
        imagejpeg($mini_photo, $mini_photo_path);

        // thumbnail photo section
        $max_width = 250;
        $max_height = 150;
        $thumbnail_photo = resizePhoto($original, $max_width, $max_height);
        imagejpeg($thumbnail_photo, $thumbnail_photo_path);

        if (Restaurant::updateRestaurantPhoto($db, $dbDir, intval($id))) {
            $session->addMessage('success', 'Photo updated!');
            die(header('Location: ' . $_SERVER['HTTP_REFERER']));
        }
    }
    $session->addMessage('error', 'A file must be selected first!');
    die(header('Location: ' . $_SERVER['HTTP_REFERER']));


    function resizePhoto(GdImage $original, int $max_width, int $max_height) : GdImage {
        $photo_width = imagesx($original);
        $photo_height = imagesy($original);

        $new_width = $photo_height * $max_width/$max_height;
        $new_height = $photo_width * $max_height/$max_width;

        $resized_photo = imagecreatetruecolor($max_width, $max_height);
        if($new_width > $photo_width) {
            $h_point = (($photo_height - $new_height) / 2);
            imagecopyresampled($resized_photo, $original, 0, 0, 0, $h_point, $max_width, $max_height, $photo_width, $new_width); 
        } 
        if ($new_width > $photo_width) {
            $w_point = (($photo_width - $new_width) / 2);
            imagecopyresampled($resized_photo, $original, 0, 0, $w_point, 0, $max_width, $max_height,$new_width, $photo_height); 
        }
        return $resized_photo;
    }
?>

