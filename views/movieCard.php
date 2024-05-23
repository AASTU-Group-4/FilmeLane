
<div class="movie-card">

<a href="./movie-details.html">
    <figure class="card-banner">
        <img src="<?php echo "https://image.tmdb.org/t/p/original/" . $movie["poster_path"]; ?>" alt="The Northman movie poster">
    </figure>
</a>

<div class="title-wrapper">
    <a href="./movie-details.html">
        <h3 class="card-title">The Northman</h3>
    </a>

    <time datetime="2022">2022</time>
</div>

<div class="card-meta">
    <div class="badge badge-outline">HD</div>

    <div class="duration">
        <ion-icon name="time-outline"></ion-icon>

        <time datetime="PT137M">137 min</time>
    </div>

    <div class="rating">
        <ion-icon name="star"></ion-icon>

        <data>8.5</data>
    </div>
</div>