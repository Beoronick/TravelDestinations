<?php
require_once('../db.php');

$user_id = $_SESSION['user_id'] ?? 0;

if ($user_id <= 0) {
    echo json_encode(['success' => false, 'message' => 'Не сте логнати в сесия за да добавяте към "Любими".']);
    exit;
}

$destination_id = intval($_POST['destination_id'] ?? 0);
$action = $_POST['action'] ?? '';

if ($destination_id <= 0) {
    echo json_encode(['success' => false, 'message' => 'Невалидна дестинация.']);
    exit;
}

if ($action === 'add') {
    $query = "INSERT INTO destinations_users (user_id, destination_id) VALUES (:user_id, :destination_id)";
} elseif ($action === 'remove') {
    $query = "DELETE FROM destinations_users WHERE user_id = :user_id AND destination_id = :destination_id";
} else {
    echo json_encode(['success' => false, 'message' => 'Невалидно действие.']);
    exit;
}

$stmt = $pdo->prepare($query);
if ($stmt->execute([':user_id' => $user_id, ':destination_id' => $destination_id])) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Операцията към базата данни се провали.']);
}
exit;
