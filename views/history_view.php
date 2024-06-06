<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filmlane - Best movie collections</title>

    <link rel="stylesheet" href="/public/css/style.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        .hero {
            background: url('<?php echo "https://image.tmdb.org/t/p/original/" . $pMoviesDetails["poster_path"]; ?>') no-repeat;
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 750px;
            height: 100vh;
            max-height: 1000px;
            display: flex;
            justify-content: flex-start;
            align-items: center;
            padding-block: var(--section-padding);
        }
    </style>
</head>

<body>
    <main>
        <article>
        <section class="top-rated">
                <div class="container">

                    <h2 class="h2 section-title">Your history</h2>

                    <ul class="clear-list">
                        <li>
                            <button class="clear-btn">Clear History</button>
                        </li>
                    </ul>
                    
                    <ul class="movies-list">

                        <?php
                        session_start();
                        
                        $user_id = $_SESSION["user_id"];

                        require_once '../models/UserHistory.php';

                        // create instance of userHistory model
                        $userHistoryModel = new $userHistoryModel();

                        // fetch user history from the database
                        $userHistoryMovies = $userHistoryModel->getHistory($user_id);//user id from session
                        
                       
                        // Group the history by date_watched
                        $historyByDate = array();
                        foreach ($userHistory as $movie) {
                            $dateWatched = date("F Y", strtotime($movie['date_watched']));
                            if (!isset($historyByDate[$dateWatched])) {
                                $historyByDate[$dateWatched] = array();
                            }
                            $historyByDate[$dateWatched][] = $movie;
                        }

                        // Display the history list in sections
                        foreach ($historyByDate as $date => $movies) {
                            echo "<h2>$date</h2>";
                            foreach ($movies as $movie) {
                                echo "<li>". createDynamicMovieCard($movie). "</li>";
                            }
                    }
                    ?>
                    </ul>

                </div>
            </section>
        </article>
    </main>
</body>

<footer class="footer">

        <div class="footer-top">
            <div class="container">

                <div class="footer-brand-wrapper">

                    <a href="./index.html" class="logo">
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

                    </ul>

                </div>

                <div class="divider"></div>

                <div class="quicklink-wrapper">

                    <ul class="social-list">

                        <li>
                            <a href="#" class="social-link">
                                <ion-icon name="logo-facebook"></ion-icon>
                            </a>
                        </li>

                        <li>
                            <a href="#" class="social-link">
                                <ion-icon name="logo-twitter"></ion-icon>
                            </a>
                        </li>

                        <li>
                            <a href="#" class="social-link">
                                <ion-icon name="logo-pinterest"></ion-icon>
                            </a>
                        </li>

                        <li>
                            <a href="#" class="social-link">
                                <ion-icon name="logo-linkedin"></ion-icon>
                            </a>
                        </li>

                    </ul>

                </div>

            </div>
        </div>

    </footer>



    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

</body>

</html>
