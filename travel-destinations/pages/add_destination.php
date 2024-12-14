<form class="border rounded p-4 w-50 mx-auto" method="POST" action="./handlers/handle_add_destination.php" enctype="multipart/form-data">
    <h3 class="text-center">Добави дестинация</h3>
    
    <div class="mb-3">
        <label for="title" class="form-label">Заглавие:</label>
        <input type="text" class="form-control" id="title" name="title" required>
    </div>
    
    <div class="mb-3">
        <label for="price" class="form-label">Цена (лв):</label>
        <input type="number" step="0.01" class="form-control" id="price" name="price" required>
    </div>
    
    <div class="mb-3">
        <label for="location" class="form-label">Локация:</label>
        <input type="text" class="form-control" id="location" name="location" required>
    </div>
    
    <div class="mb-3">
        <label for="description" class="form-label">Описание:</label>
        <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
    </div>

    <div class="mb-3">
        <label for="image" class="form-label">Изображение:</label>
        <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
    </div>

    <button type="submit" class="btn btn-success w-100">Добави</button>
</form>
