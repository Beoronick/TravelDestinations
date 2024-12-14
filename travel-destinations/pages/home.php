<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">

<div class="container py-5" style="font-family: 'Poppins', sans-serif;">
    <div class="row justify-content-center text-center">
        <div class="col-md-8">
            <h1 class="display-4 fw-bold text-body-emphasis mb-3">Най-добрите туристически дестинации избрани от вас!</h1>
            <p class="lead">Помогнете на любителите на пътешествията да намерят уникални по рода си места, да изследват нови култури и създадат нови спомени за цял живот.</p>
            <a href="?page=destinations" class="btn btn-lg mt-4" style="background-color: #FF6F61; color: white; border-color: #FF6F61;">Към дестинациите</a>
        </div>
    </div>

    <div class="row justify-content-center mt-5">
        <div class="col-12 col-md-10">
            <div id="destinationCarousel" class="carousel slide shadow-lg rounded-3" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#destinationCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#destinationCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#destinationCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
                </div>

                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="https://cdn.adventure-life.com/96/91/7/ThinkstockPhotos-510081860/1300x820.webp" class="d-block w-100" alt="Дестинация 1" style="max-height: 400px; object-fit: cover;">
                        <div class="carousel-caption d-none d-md-block">
                            <h5 style="color: #FF6F61;">Тропическите плажове на Бали</h5>
                            <p>Почувствайте магията на райските острови.</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="https://www.toureiffel.paris/sites/default/files/styles/1200x630/public/actualite/image_principale/IMG_0815.jpg" class="d-block w-100" alt="Дестинация 2" style="max-height: 400px; object-fit: cover;">
                        <div class="carousel-caption d-none d-md-block">
                            <h5 style="color: #FF6F61;">Културните красоти на Париж</h5>
                            <p>Изследвайте Лувъра и Айфеловата кула.</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="https://www.pelago.com/img/destinations/kyoto/1129-0642_kyoto-xlarge.jpg" class="d-block w-100" alt="Дестинация 3" style="max-height: 400px; object-fit: cover;">
                        <div class="carousel-caption d-none d-md-block">
                            <h5 style="color: #FF6F61;">Приключения в Киото</h5>
                            <p>Съвременно и традиционно в перфектен баланс.</p>
                        </div>
                    </div>
                </div>

                <button class="carousel-control-prev" type="button" data-bs-target="#destinationCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Предишна</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#destinationCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Следваща</span>
                </button>
            </div>
        </div>
    </div>
</div>
