<?php

require_once('../functions.php');
require_once('../db.php');

$title = $_POST['title'] ?? '';
$price = $_POST['price'] ?? '';
$location = $_POST['location'] ?? '';
$description = $_POST['description'] ?? '';
$destination_id = intval($_POST['destination_id'] ?? 0);

if (mb_strlen($title) <= 0 || mb_strlen($title) > 56 ||
    mb_strlen($description) <= 0 || mb_strlen($description) > 123 ||
    $price <= 0 || empty($location) || $destination_id <= 0) {
    
    $_SESSION['flash']['message']['type'] = 'danger';
    $_SESSION['flash']['message']['text'] = "Моля попълнете всички полета коректно!";
    header('Location: ../index.php?page=edit_destination&destination_id=' . $destination_id);
    exit;
}

$img_uploaded = false;
if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
    $new_filename = time() . '_' . $_FILES['image']['name'];
    $upload_dir = '../uploads/';
    
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }

    if (!move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir . $new_filename)) {
        $_SESSION['flash']['message']['type'] = 'danger';
        $_SESSION['flash']['message']['text'] = "Грешка при запис на файла!";
        header('Location: ../index.php?page=edit_destination&destination_id=' . $destination_id);
        exit;
    } else {
        $img_uploaded = true;
    }
}

$query = '';
if ($img_uploaded) {
    $query = "UPDATE destinations SET title = :title, price = :price, location = :location, description = :description, image = :image WHERE id = :id";
} else {
    $query = "UPDATE destinations SET title = :title, price = :price, location = :location, description = :description WHERE id = :id";
}

$stmt = $pdo->prepare($query);
$params = [
    ':title' => $title,
    ':price' => $price,
    ':location' => $location,
    ':description' => $description,
    ':id' => $destination_id
];
if ($img_uploaded) {
    $params[':image'] = $new_filename;
}

if ($stmt->execute($params)) {
    $_SESSION['flash']['message']['type'] = 'success';
    $_SESSION['flash']['message']['text'] = "Дестинацията беше редактирана успешно!";
} else {
    $_SESSION['flash']['message']['type'] = 'danger';
    $_SESSION['flash']['message']['text'] = "Грешка при редакция на дестинация!";
}

header('Location: ../index.php?page=edit_destination&destination_id=' . $destination_id);
exit;

?>
