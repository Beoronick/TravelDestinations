<?php
require_once('functions.php');
require_once('db.php');

$page = $_GET['page'] ?? 'home';

$flash = [];
if (isset($_SESSION['flash'])) {
    $flash = $_SESSION['flash'];
    unset($_SESSION['flash']);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Агенция за пътувания "My Way"</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootswatch@5.2.3/dist/lux/bootstrap.min.css">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <style>
        body {
            background-color: #fef6e4; 
        }
        .navbar {
            background-color: #add8e6 !important; 
        }
        .navbar .nav-link {
            color: #000 !important; 
        }
        .navbar .nav-link.active {
            color: #007bff !important; 
            font-weight: bold;
        }
    </style>
</head>
<body>
    <script>
        $(function() {
            $(document).on('click', '.add-favorite', function() {
                let btn = $(this);
                let destinationId = btn.data('destination');

                $.ajax({
                    url: './ajax/manage_favorites.php',
                    method: 'POST',
                    data: {
                        destination_id: destinationId
                    },
                    success: function(response) {
                        let res = JSON.parse(response);
                        if (res.success) {
                            alert('Дестинацията бе успешно добавена към "Любими"!');

                            let removeBtn = $(`<button type="button" class="btn btn-sm btn-danger remove-favorite" data-destination="${destinationId}">Remove from Favorites</button>`);
                            btn.replaceWith(removeBtn);
                        } else {
                            alert(res.error);
                        }
                    },
                    error: function(error) {
                        console.error(error);
                    }
                });
            });

            $(document).on('click', '.remove-favorite', function() {
                let btn = $(this);
                let destinationId = btn.data('destination');

                $.ajax({
                    url: './ajax/remove_favorite.php',
                    method: 'POST',
                    data: {
                        destination_id: destinationId
                    },
                    success: function(response) {
                        let res = JSON.parse(response);
                        if (res.success) {
                            alert('Дестинацията бе успешно премахната от "Любичи"!');

                            let addBtn = $(`<button type="button" class="btn btn-sm btn-primary add-favorite" data-destination="${destinationId}">Add to Favorites</button>`);
                            btn.replaceWith(addBtn);
                        } else {
                            alert(res.error);
                        }
                    },
                    error: function(error) {
                        console.error(error);
                    }
                });
            });
        });
    </script>
    <header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#"><i class="fas fa-plane"></i> Агенция за пътувания "My Way"</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
                <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link <?php echo($page == 'home' ? 'active' : '') ?>" href="?page=home"><i class="fas fa-home"></i> Начало</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo($page == 'destinations' ? 'active' : '') ?>" href="?page=destinations"><i class="fas fa-map-marked-alt"></i> Дестинации</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo($page == 'contacts' ? 'active' : '') ?>" href="?page=contacts"><i class="fas fa-envelope"></i> Контакти</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo($page == 'add_destination' ? 'active' : '') ?>" href="?page=add_destination"><i class="fas fa-plus-circle"></i> Добави Дестинация</a>
                        </li>
                    </ul>
                    <div class="d-flex flex-row align-items-center gap-3">
                        <?php
                            if (isset($_SESSION['username'])) {
                                echo '<span class="text-light me-3">Здравейте, ' . htmlspecialchars($_SESSION['username']) . '</span>';
                                echo '
                                    <form method="POST" action="./handlers/handle_logout.php" class="m-0">
                                        <button type="submit" class="btn btn-outline-light">Изход</button>
                                    </form>
                                ';
                            } else {
                                echo '<a href="?page=login" class="btn btn-outline-light">Вход</a>';
                                echo '<a href="?page=register" class="btn btn-outline-light">Регистрация</a>';
                            }
                        ?>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <main class="container py-4" style="min-height:80vh;">
        <?php
            if (isset($flash['message'])) {
                echo '
                    <div class="alert alert-' . $flash['message']['type'] . '">
                        ' . $flash['message']['text'] . '
                    </div>
                ';
            }

            if (file_exists("pages/$page.php")) {
                require_once("pages/$page.php");
            } else {
                require_once("pages/not_found.php");
            }
        ?>
    </main>
    <footer class="text-center py-5 mt-auto" style="background-color: #add8e6;">
        <div class="container">
            <span class="text-dark">© Александър Иванов Рашков - 2024 - All rights reserved</span>
        </div>
    </footer>
</body>
</html>
