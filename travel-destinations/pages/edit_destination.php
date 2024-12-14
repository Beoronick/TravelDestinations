<?php
    $destination_id = intval($_GET['destination_id'] ?? 0);

    if ($destination_id <= 0) {
        $_SESSION['flash']['message']['type'] = 'danger';
        $_SESSION['flash']['message']['text'] = "Грешен идентификатор на дестинация!";
        header('Location: ./index.php?page=destinations');
        exit;
    }

    $query = "SELECT * FROM destinations WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->execute([':id' => $destination_id]);
    $destination = $stmt->fetch();

    if (!$destination) {
        $_SESSION['flash']['message']['type'] = 'danger';
        $_SESSION['flash']['message']['text'] = "Дестинацията не съществува!";
        header('Location: ./index.php?page=destinations');
        exit;
    }
?>

<form class="border rounded p-4 w-50 mx-auto" method="POST" action="./handlers/handle_edit_destination.php" enctype="multipart/form-data">
    <h3 class="text-center">Редактирай дестинация</h3>
    <div class="mb-3">
        <label for="title" class="form-label">Заглавие:</label>
        <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($destination['title'] ?? '') ?>">
    </div>
    <div class="mb-3">
        <label for="price" class="form-label">Цена:</label>
        <input type="number" step="0.01" class="form-control" id="price" name="price" value="<?php echo htmlspecialchars($destination['price'] ?? '') ?>">
    </div>
    <div class="mb-3">
        <label for="location" class="form-label">Локация:</label>
        <input type="text" class="form-control" id="location" name="location" value="<?php echo htmlspecialchars($destination['location'] ?? '') ?>">
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Описание:</label>
        <textarea class="form-control" id="description" name="description" rows="3"><?php echo htmlspecialchars($destination['description'] ?? '') ?></textarea>
    </div>
    <div class="mb-3">
        <label for="image" class="form-label">Изображение:</label>
        <input type="file" class="form-control" id="image" name="image" accept="image/*">
    </div>

    <div class="mb-3">
        <img src="./uploads/<?php echo htmlspecialchars($destination['image']) ?>" alt="<?php echo htmlspecialchars($destination['title']) ?>" class="img-thumbnail">
    </div>
    <input type="hidden" name="destination_id" value="<?php echo $destination['id'] ?? 0 ?>">
    <button type="submit" class="btn btn-success mx-auto">Редактирай</button>
</form>
