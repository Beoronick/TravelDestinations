<?php

$destinations = [];
$search = $_GET['search'] ?? '';
$min_price = $_GET['min_price'] ?? '';
$max_price = $_GET['max_price'] ?? '';
$selected_location = $_GET['location'] ?? '';

$locations = [];
$sql_locations = 'SELECT DISTINCT location FROM destinations';
$stmt_locations = $pdo->query($sql_locations);
while ($row = $stmt_locations->fetch()) {
    $locations[] = $row['location'];
}

$sql = '
    SELECT d.*, 
           IF(du.id IS NOT NULL, 1, 0) AS is_favorite
    FROM destinations d
    LEFT JOIN destinations_users du ON du.destination_id = d.id AND du.user_id = :user_id
    WHERE 1=1
';

$params = [':user_id' => $_SESSION['user_id'] ?? 0];

if (!empty($search)) {
    $sql .= ' AND d.title LIKE :search';
    $params['search'] = '%' . $search . '%';
}
if (!empty($min_price)) {
    $sql .= ' AND d.price >= :min_price';
    $params['min_price'] = $min_price;
}
if (!empty($max_price)) {
    $sql .= ' AND d.price <= :max_price';
    $params['max_price'] = $max_price;
}
if (!empty($selected_location)) {
    $sql .= ' AND d.location = :location';
    $params['location'] = $selected_location;
}

$sql .= ' ORDER BY is_favorite DESC, d.location ASC';

$stmt = $pdo->prepare($sql);
$stmt->execute($params);

$destinations = $stmt->fetchAll();
?>


<div class="row mb-4">
    <div class="col-md-12 mb-3">
        <form method="GET">
            <input type="hidden" name="page" value="destinations">
            <input type="text" class="form-control" placeholder="Търси дестинация" name="search" value="<?php echo htmlspecialchars($search); ?>">
        </form>
    </div>

    <form method="GET" class="row g-1">
        <input type="hidden" name="page" value="destinations">

        <div class="col-md-3">
            <input type="number" class="form-control" placeholder="Мин. Цена" name="min_price" value="<?php echo htmlspecialchars($min_price); ?>">
        </div>
        <div class="col-md-3">
            <input type="number" class="form-control" placeholder="Макс. Цена" name="max_price" value="<?php echo htmlspecialchars($max_price); ?>">
        </div>

        <div class="col-md-4">
            <select class="form-select" name="location">
                <option value="">Всички локации</option>
                <?php foreach ($locations as $location): ?>
                    <option value="<?php echo htmlspecialchars($location); ?>" 
                        <?php echo ($selected_location === $location) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($location); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-md-2">
            <button class="btn btn-primary w-100" type="submit">Филтрирай</button>
        </div>
    </form>
</div>

<div class="row g-4">
    <?php foreach ($destinations as $destination): ?>
        <div class="col-md-4">
            <div class="card shadow-sm position-relative">
                <div class="position-absolute bottom-0 end-0 p-2">
                    <a href="#" 
                        class="favorite-toggle position-absolute bottom-0 end-0 p-2" 
                        data-destination-id="<?php echo $destination['id']; ?>" 
                        data-action="<?php echo $destination['is_favorite'] ? 'remove' : 'add'; ?>">
                        <img src="assets/<?php echo $destination['is_favorite'] ? 'filled_star.png' : 'empty_star.png'; ?>" 
                        alt="Toggle Favorite" 
                        style="width: 24px; height: 24px;">
                    </a>
                </div>

                <img src="uploads/<?php echo htmlspecialchars($destination['image']); ?>" class="card-img-top" alt="Destination Image" style="height: 200px; object-fit: cover;">

                <div class="card-body">
                    <h5 class="card-title"><?php echo htmlspecialchars($destination['title']); ?></h5>
                    <p class="card-text"><?php echo htmlspecialchars($destination['description']); ?></p>
                    <p class="text-muted">Цена: <?php echo htmlspecialchars($destination['price']); ?> лв</p>

                    <a href="?page=edit_destination&destination_id=<?php echo $destination['id']; ?>" class="btn btn-warning btn-sm">Редактирай</a>
                    <form method="POST" action="./handlers/handle_delete_destination.php" class="d-inline">
                        <input type="hidden" name="destination_id" value="<?php echo $destination['id']; ?>">
                        <button type="submit" class="btn btn-danger btn-sm">Изтрий</button>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<script>
   document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.favorite-toggle').forEach((button) => {
        button.addEventListener('click', (e) => {
            e.preventDefault();

            const destinationId = button.getAttribute('data-destination-id');
            const action = button.getAttribute('data-action');

            fetch(`./ajax/manage_favorites.php`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `destination_id=${destinationId}&action=${action}`,
            })
                .then((response) => response.json())
                .then((data) => {
                    if (data.success) {
                        window.location.reload();
                    } else {
                        alert(data.message || 'Грешка при актуализиране на любимите дестинации.');
                    }
                })
                .catch(() => {
                    alert('Възникна грешка. Моля, опитайте отново.');
                });
        });
    });
});
</script>
