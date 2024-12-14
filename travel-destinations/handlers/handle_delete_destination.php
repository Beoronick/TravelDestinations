<?php

require_once('../functions.php');
require_once('../db.php');

$id = intval($_POST['destination_id'] ?? 0);

if ($id <= 0) {
    $_SESSION['flash']['message']['type'] = 'danger';
    $_SESSION['flash']['message']['text'] = "Грешен идентификатор на дестинация!";
    header('Location: ../index.php?page=destinations');
    exit;
}

$query = "DELETE FROM destinations WHERE id = :id";
$stmt = $pdo->prepare($query);
if ($stmt->execute(['id' => $id])) {
    $_SESSION['flash']['message']['type'] = 'success';
    $_SESSION['flash']['message']['text'] = "Дестинацията беше изтрита успешно!";
} else {
    $_SESSION['flash']['message']['type'] = 'danger';
    $_SESSION['flash']['message']['text'] = "Грешка при изтриване на дестинация!";
}

header('Location: ../index.php?page=destinations');
exit;
?>