<?php
function createDynamicMovieCard($movie)
{
    $posterUrl = "https://image.tmdb.org/t/p/original/" . $movie["poster_path"];
    $title = $movie['original_title'];
    $releaseYear = substr($movie['release_date'], 0, 4);
    $runtime = $movie['runtime'];
    $rating = $movie['vote_average'];
    $id = $movie['id'];

    $card = <<<HTML
<div class="movie-card">
    <a href="./movie_info.php?id={$id}">
        <figure class="card-banner">
            <img src="$posterUrl" alt="$title movie poster">
        </figure>
    </a>
    <div class="title-wrapper">
        <a href="./movie_info.php?id={$id}">
            <h3 class="card-title">$title</h3>
        </a>
        <time datetime="$releaseYear">$releaseYear</time>
    </div>
    <div class="card-meta">
        <div class="badge badge-outline">HD</div>
        <div class="duration">
            <ion-icon name="time-outline"></ion-icon>
            <time datetime="PT{$runtime}M">{$runtime} min</time>
        </div>
        <div class="rating">
            <ion-icon name="star"></ion-icon>
            <data>$rating</data>
        </div>
    </div>
</div>
HTML;

    return $card;
}

function createDynamicTvshowCard($tvShow)
{
    $posterUrl = "https://image.tmdb.org/t/p/original/" . $tvShow["poster_path"];
    $title = $tvShow['name'];
    $id = $tvShow['id'];
    if (isset($tvShow['first_air_date'])) {
        $releaseYear = substr($tvShow['first_air_date'], 0, 4);
    } else {
        $releaseYear = "N/A";
    }
    if (!empty($tvShow['episode_run_time'])) {
        $runtime = $tvShow['episode_run_time'][0];
    } else {
        $runtime = 0;
    }

    $rating = $tvShow['vote_average'];

    $card = <<<HTML
<div class="movie-card">
    <a href="./series_info.php?id={$id}">
        <figure class="card-banner">
            <img src="$posterUrl" alt="$title movie poster">
        </figure>
    </a>
    <div class="title-wrapper">
        <a href="./series_info.php?id={$id}">
            <h3 class="card-title">$title</h3>
        </a>
        <time datetime="$releaseYear">$releaseYear</time>
    </div>
    <div class="card-meta">
        <div class="badge badge-outline">HD</div>
        <div class="duration">
            <ion-icon name="time-outline"></ion-icon>
            <time datetime="PT{$runtime}M">{$runtime} min</time>
        </div>
        <div class="rating">
            <ion-icon name="star"></ion-icon>
            <data>$rating</data>
        </div>
    </div>
</div>
HTML;

    return $card;
}