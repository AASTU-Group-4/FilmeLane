<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Free Guy 2021</title>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('season-select').addEventListener('click', function () {
                var tvId = <?php echo json_encode($tv_id); ?>;
                var season = this.value;
                window.location.href = '/pages/series_info.php?id=' + tvId + '&season=' + season;
            });
        });
    </script>

</head>

<body id="#top">

    <style>
        .movie-detail {
            background:
                linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)),
                /* Gradient overlay */
                url('<?php echo "https://image.tmdb.org/t/p/original/" . $tvShow["poster_path"]; ?>') no-repeat;
            background-size: cover;
            background-position: center;
            padding-top: 160px;
            padding-bottom: var(--section-padding);
            background-attachment: fixed;
            color: #ffffff;
            /* Text color */
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
            /* Text shadow for better visibility */
        }
    </style>



    <main>
        <?php if ($watch): ?>
            <div class="movie-container">
                <iframe src="<?php echo $url; ?>" width="100%" height="100%" frameborder="0" allowfullscreen></iframe>
            </div>
        <?php endif ?>
        <article>

            <!-- 
        - #MOVIE DETAIL
      -->

            <section class="movie-detail">
                <div class="container">

                    <figure class="movie-detail-banner">

                        <img src='<?php echo "https://image.tmdb.org/t/p/original/" . $tvShow["poster_path"]; ?>'
                            alt="Free guy movie poster">

                        <button class="play-btn">
                            <ion-icon name="play-circle-outline"></ion-icon>
                        </button>

                    </figure>

                    <div class="movie-detail-content">

                        <h2 class="h2 detail-title">
                            <strong><?php echo $tvShow["name"]; ?></strong>
                        </h2>

                        <div class="meta-wrapper">

                            <div class="badge-wrapper">
                                <div class="badge badge-fill"><a href="<?php echo $trailer_url; ?>"
                                        target="__blank">Trailer</a></div>

                                <div class="badge badge-outline">HD</div>
                            </div>

                            <div class="ganre-wrapper">
                                <?php foreach ($tvShow["genres"] as $genre): ?>
                                    <a
                                        href="/pages/genre.php?id=<?php echo $genre['id']; ?>"><?php echo $genre['name']; ?></a>
                                <?php endforeach; ?>
                            </div>

                            <div class="date-time">

                                <div>
                                    <ion-icon name="calendar-outline"></ion-icon>

                                    <time datetime="2021"><?php if (!empty($tvShow['first_air_date'])) {
                                        echo substr($tvShow['first_air_date'], 0, 4);
                                    } ?></time>
                                </div>

                                <div>
                                    <ion-icon name="time-outline"></ion-icon>

                                    <time datetime="PT115M"><?php if (!empty($tvShow['episode_run_time'])) {
                                        echo $tvShow['episode_run_time'][0];
                                    } else {
                                        echo "N/A";
                                    }
                                    ?> min</time>
                                </div>

                            </div>

                        </div>

                        <p class="storyline">
                            <?php echo $tvShow['overview']; ?>
                        </p>
                        <button class="btn btn-primary" style="margin-bottom: 20px">
                            <ion-icon name="play"></ion-icon>
                            <a href="./series_info.php?id=<?php echo $tvShow['id']; ?>">
                                <span>Watch now</span> </a>
                        </button>

                        <div class="details-actions">

                            <button class="share">
                                <ion-icon name="share-social"></ion-icon>
                                <a href="<?php echo $tvShow['homepage']; ?>"><span>Share</span></a>
                            </button>

                            <div class="title-wrapper">
                                <p class="title">Prime Video</p>

                                <p class="text">Streaming Channels</p>
                            </div>

                            <button class="btn btn-primary">
                                <ion-icon name="add"></ion-icon>

                                <span>Add to favorite</span>
                            </button>

                        </div>

                    </div>

                </div>
                <div class="series-container-main">
                    <div class="series-container">
                        <div class="season-select">
                            <select id="season-select">
                                <?php
                                foreach ($tvShow['seasons'] as $Season) {
                                    $seasonName = htmlspecialchars($Season['name'], ENT_QUOTES, 'UTF-8');
                                    $season_number = $Season['season_number'];
                                    $selected = ($season_number == $season) ? 'selected' : '';
                                    echo "<option value='$season_number' $selected>$seasonName</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <?php if (!empty($tvShow['seasons'][$season])): ?>
                            <div class="episode-list">
                                <?php
                                foreach ($seasonDetails['episodes'] as $episode) {
                                    $selected = ($episode['episode_number'] == $eps) ? 'active' : '';
                                    $viewUrl = "/pages/series_info.php?id=$tv_id&season=$season&eps=" . $episode['episode_number'];
                                    echo "<div class='episode {$selected}'><a href='{$viewUrl}'>Eps ". $episode['episode_number']. ": " . $episode['name'] . "</a></div>";
                                }
                                ?>
                            </div>

                        <?php endif ?>
                        <a href=''>
                    </div>
                </div>
            </section>




            <section class="upcoming">
                <div class="container">

                    <div class="flex-wrapper">

                        <div class="title-wrapper">
                            <p class="section-subtitle">Online Streaming</p>

                            <h2 class="h2 section-title">Recommendation</h2>
                        </div>

                        <ul class="filter-list">

                            <li>
                                <button class="filter-btn">Movies</button>
                            </li>

                            <li>
                                <button class="filter-btn">TV Shows</button>
                            </li>

                            <li>
                                <button class="filter-btn">Anime</button>
                            </li>

                        </ul>

                    </div>

                    <ul class="movies-list  has-scrollbar">

                        <?php
                        foreach ($movieRecommendations as $movie) {
                            echo "<li>" . createDynamicTvshowCard($movie) . "</li>";
                        }
                        ?>

                    </ul>

                </div>
            </section>

        </article>
    </main>





    <!-- 
    - #FOOTER
  -->

    <footer class="footer">

        <div class="footer-top">
            <div class="container">

                <div class="footer-brand-wrapper">

                    <a href="" class="logo">
                        <img src="/public/images/logo.svg" alt="Filmlane logo">
                    </a>

                    <ul class="footer-list">

                        <li>
                            <a href="./index.html" class="footer-link">Home</a>
                        </li>

                        <li>
                            <a href="#" class="footer-link">Movie</a>
                        </li>

                        <li>
                            <a href="#" class="footer-link">TV Show</a>
                        </li>

                        <li>
                            <a href="#" class="footer-link">Web Series</a>
                        </li>

                        <li>
                            <a href="#" class="footer-link">Pricing</a>
                        </li>

                    </ul>

                </div>



</body>

</html>