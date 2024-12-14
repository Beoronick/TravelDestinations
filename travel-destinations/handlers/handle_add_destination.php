<?php

require_once('../functions.php');
require_once('../db.php');

$title = $_POST['title'] ?? '';
$price = $_POST['price'] ?? '';
$location = $_POST['location'] ?? '';
$description = $_POST['description'] ?? '';

if (empty($title) || empty($price) || empty($location) || empty($description)) {
    $_SESSION['flash']['message']['type'] = 'danger';
    $_SESSION['flash']['message']['text'] = "Моля попълнете всички полета!";
    header('Location: ../index.php?page=add_destination');
    exit;
}

if (mb_strlen($title) > 56) {
    $_SESSION['flash']['message']['type'] = 'danger';
    $_SESSION['flash']['message']['text'] = "Заглавието трябва да бъде максимум 56 символа!";
    header('Location: ../index.php?page=add_destination');
    exit;
}

if (mb_strlen($description) > 123) {
    $_SESSION['flash']['message']['type'] = 'danger';
    $_SESSION['flash']['message']['text'] = "Описанието трябва да бъде максимум 123 символа!";
    header('Location: ../index.php?page=add_destination');
    exit;
}


if (!isset($_FILES['image']) || $_FILES['image']['error'] != 0) {
    $_SESSION['flash']['message']['type'] = 'danger';
    $_SESSION['flash']['message']['text'] = "Моля качете изображение!";
    header('Location: ../index.php?page=add_destination');
    exit;
}

$new_filename = time() . '_' . $_FILES['image']['name'];
$upload_dir = '../uploads/';

if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0755, true);
}

if (!move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir . $new_filename)) {
    $_SESSION['flash']['message']['type'] = 'danger';
    $_SESSION['flash']['message']['text'] = "Грешка при запис на файла!";
    header('Location: ../index.php?page=add_destination');
    exit;
}

$query = "INSERT INTO destinations (title, price, location, description, image) 
          VALUES (:title, :price, :location, :description, :image)";
$stmt = $pdo->prepare($query);
$params = [
    ':title' => $title,
    ':price' => $price,
    ':location' => $location,
    ':description' => $description,
    ':image' => $new_filename
];

if ($stmt->execute($params)) {
    $_SESSION['flash']['message']['type'] = 'success';
    $_SESSION['flash']['message']['text'] = "Дестинацията беше добавена успешно!";
    header('Location: ../index.php?page=destinations');
    exit;
} else {
    $_SESSION['flash']['message']['type'] = 'danger';
    $_SESSION['flash']['message']['text'] = "Грешка при добавяне на дестинация!";
    header('Location: ../index.php?page=add_destination');
    exit;
}

?>
