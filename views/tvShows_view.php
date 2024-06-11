<!-- tv shows list -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filmlane - Best movie collections</title>


    <style>
        .hero {
            background:
                linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('<?php echo "https://image.tmdb.org/t/p/original/" . $pMoviesDetails["poster_path"]; ?>') no-repeat;
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

<body id="#top">


    <main>
        <article>
        
        <h2 class="section-subtitle">TV shows</h2>

            <section class="upcoming">
                <div class="container">

                    <div class="flex-wrapper">

                        <div class="title-wrapper">
                            <h2 class="h2 section-title">Trending Tv shows</h2>
                        </div>

                    </div>

                    <ul class="movies-list  has-scrollbar">

                        <?php
                        foreach ($trendingTvshows as $movie) {
                            echo "<li>" . createDynamicMovieCard($movie) . "</li>";
                        }
                        ?>
                </div>
            </section>

             <!-- Filter Container -->
             <section class="genre-filter">
                <div class="container filter-container">
                    <!-- Genre Dropdown -->
                    <div class="dropdown">
                        <button class="dropbtn">Genre</button>
                        <div class="dropdown-content">
                            <a href="?genre=">All</a>
                            <?php foreach ($tvshowsG as $genre): ?>
                                <a href="?genre=<?php echo $genre['id']; ?>"><?php echo $genre['name']; ?></a>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Year Filter Form -->
                    <div class="search-container">
                        <form action="" method="get">
                            <div class="input-container">
                                <input type="text" name="year" placeholder="Enter Year" value="<?php echo isset($_GET['year']) ? htmlspecialchars($_GET['year']) : ''; ?>"  />
                                <button type="submit">Search</button>
                            </div>
                        </form>
                    </div>
                </div>
            </section>


            <section class="upcoming">
                <div class="container">

                    <div class="flex-wrapper">

                        <div class="title-wrapper">
                            <h2 class="h2 section-title">TV shows</h2>
                        </div>

                    </div>

                    <ul class="movies-list  has-scrollbar">

                        <?php
                        foreach ($Tvshows as $movie) {
                            echo "<li>" . createDynamicMovieCard($Tvshows) . "</li>";
                        }

                    // Calculate total pages based on the total number of movies (assuming 10 movies per page)
                    $totalPages = ceil(count($Tvshows) / 10);
                        ?>
                    </ul>

                    <!-- Pagination -->
                    <div class="pagination">
                        <?php if ($currentPage > 1): ?>
                            <a href="?year=<?php echo $selectedYear; ?>&page=<?php echo $currentPage - 1; ?>">&laquo; Prev</a>
                        <?php endif; ?>

                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <a href="?year=<?php echo $selectedYear; ?>&page=<?php echo $i; ?>" class="<?php echo $i == $currentPage ? 'active' : ''; ?>"><?php echo $i; ?></a>
                        <?php endfor; ?>

                        <?php if ($currentPage < $totalPages): ?>
                            <a href="?year=<?php echo $selectedYear; ?>&page=<?php echo $currentPage + 1; ?>">Next &raquo;</a>
                        <?php endif; ?>
                    </div>
    
                </div>
            </section>



            

        </article>
    </main>




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