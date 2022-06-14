<?php 
    require_once(__DIR__ . '/../utils/session.php');

    require_once(__DIR__ . '/../database/restaurant.class.php');
    require_once(__DIR__ . '/../database/connection.db.php');
    require_once(__DIR__ . '/../database/user.class.php');

    $session = new Session();
    $db = getDatabaseConnection();
    $id_dish = $_POST['id_dish'];
    $restaurant = Restaurant::getDishRestaurant($db, $id_dish);
    $id = $restaurant->id;

     if (!$session->isOwner($session->getId()) || !$session->isLoggedIn() || !$session->isOwnerRestaurant($restaurant->id)) {
         die(header('Location: /')); 
      }


     if (!is_dir('../photos')) mkdir('photos');
     if (!is_dir('../photos/dishes')) mkdir('photos/dishes');
     if (!is_dir('../photos/dishes/originals')) mkdir('photos/originals');
     if (!is_dir('../photos/dishes/mini')) mkdir('photos/mini');

    $originalDir = '../photos/dishes/originals/';
    $miniDir = '../photos/dishes/mini/';
    $photo = $_FILES['dish_image'];

    if ($photo['size']) {

        // creating photo paths
        $original_photo_path = $originalDir . $id_dish . '.png';
        $mini_photo_path = $miniDir . $id_dish . '.png';
        $dbDir = $id_dish . '.png';

        // move original photo to respective directory
        move_uploaded_file($photo['tmp_name'], $original_photo_path);

        // copy of original photo
        $original = imagecreatefrompng($original_photo_path);
        if (!$original) $original = imagecreatefromjpeg($original_photo_path);
        if (!$original) $original = imagecreatefromgif($original_photo_path);
        if (!$original) {
            $session->addMessage('error', 'Error uploading file!');
            die(header('Location: ' . $_SERVER['HTTP_REFERER']));
        };



        $max_width = 150;
        $max_height = 150;
        $photo_width = imagesx($original);
        $photo_height = imagesy($original);
        $square = min($photo_width, $photo_height);
        $resized_photo = imagecreatetruecolor(150, 150);
        imagecopyresized($resized_photo, $original, 0, 0, ($photo_width>$square)?($photo_width-$square)/2:0, ($photo_height>$square)?($photo_height-$square)/2:0, $max_width, $max_height, $square, $square);
        imagepng($resized_photo, $mini_photo_path);

        if (Dish::updateDishPhoto($db, $dbDir, intval($id_dish))) {
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

