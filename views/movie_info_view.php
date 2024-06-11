<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Free Guy 2021</title>


</head>

<body id="#top">

  <style>
    .movie-detail {
      background:
        linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)),
        /* Gradient overlay */
        url('<?php echo "https://image.tmdb.org/t/p/original/" . $movie["poster_path"]; ?>') no-repeat;
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
    <?php if($watch): ?>
      <div class="movie-container">
        <iframe src="<?php echo $url;?>" width="100%" height="100%" frameborder="0" allowfullscreen></iframe>
      </div>
    <?php endif?>
    <article>

      <!-- 
        - #MOVIE DETAIL
      -->

      <section class="movie-detail">
        <div class="container">

          <figure class="movie-detail-banner">

            <img src='<?php echo "https://image.tmdb.org/t/p/original/" . $movie["poster_path"]; ?>'
              alt="Free guy movie poster">

            <button class="play-btn">
              <ion-icon name="play-circle-outline"></ion-icon>
            </button>

          </figure>

          <div class="movie-detail-content">

            <h2 class="h2 detail-title">
              <strong><?php echo $movie["title"]; ?></strong>
            </h2>

            <div class="meta-wrapper">

              <div class="badge-wrapper">
                <div class="badge badge-fill"><a href="<?php echo $trailer_url;?>" target="__blank">Trailer</a></div>

                <div class="badge badge-outline">HD</div>
              </div>

              <div class="ganre-wrapper">
                <?php foreach ($movie["genres"] as $genre): ?>
                  <a href="/pages/genre.php?id=<?php echo $genre['name']; ?>"><?php echo $genre['name']; ?></a>
                <?php endforeach; ?>
              </div>

              <div class="date-time">

                <div>
                  <ion-icon name="calendar-outline"></ion-icon>

                  <time datetime="2021"><?php echo substr($movie['release_date'], 0, 4); ?></time>
                </div>

                <div>
                  <ion-icon name="time-outline"></ion-icon>

                  <time datetime="PT115M"><?php echo $movie['runtime']; ?> min</time>
                </div>

              </div>

            </div>

            <p class="storyline">
              <?php echo $movie['overview']; ?>
            </p>
            <button class="btn btn-primary" style="margin-bottom: 20px">
              <ion-icon name="play"></ion-icon>
              <a href="./movie_info.php?id=<?php echo $movie['id']; ?>&watch=true">
                <span>Watch now</span> </a>
            </button>

            <div class="details-actions">

              <button class="share">
                <ion-icon name="share-social"></ion-icon>
                <a href="<?php echo $movie['homepage']; ?>"><span>Share</span></a>
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
              echo "<li>" . createDynamicMovieCard($movie) . "</li>";
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