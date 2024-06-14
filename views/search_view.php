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
</head>

<body>
    <main>
        <section class="top-rated top-padding" style="min-height: 100vh;">
            <div class="container">
                <h2 class="h2 section-title"><?php echo htmlspecialchars($query); ?>:</h2>

                <ul class="filter-list">
                    <li>
                        <a href="?search=<?php echo htmlspecialchars($query); ?>&type=movie&page=1"
                            class="filter-btn <?php echo ($type == 'movie') ? 'active' : ''; ?>">Movies</a>
                    </li>
                    <li>
                        <a href="?search=<?php echo htmlspecialchars($query); ?>&type=tv&page=1"
                            class="filter-btn <?php echo ($type == 'tv') ? 'active' : ''; ?>">TV Shows</a>
                    </li>
                </ul>

                <ul class="movies-list">
                    <?php
                    if ($type == 'movie') {
                        foreach ($SearchResults as $genreMovie) {
                            echo "<li>" . createDynamicMovieCard($genreMovie) . "</li>";
                        }
                    } else {
                        foreach ($SearchResults as $genreTvShow) {
                            echo "<li>" . createDynamicTvshowCard($genreTvShow) . "</li>";
                        }
                    }
                    ?>
                </ul>

                <div class="filter-list" style="margin-top:20px">
                    <?php if ($page > 1): ?>
                        <li>
                            <a class="filter-btn"
                                href="?search=<?php echo htmlspecialchars($query); ?>&type=<?php echo htmlspecialchars($type); ?>&page=<?php echo $page - 1; ?>">Previous</a>
                        </li>
                    <?php endif; ?>
                    <li>
                        <span class="filter-btn" >Page <?php echo $page; ?></span>
                    </li>
                    <?php if ($page < $results['total_pages']): ?>
                        <li>
                            <a class="filter-btn"
                            href="?search=<?php echo htmlspecialchars($query); ?>&type=<?php echo htmlspecialchars($type); ?>&page=<?php echo $page + 1; ?>">Next</a>

                        </li>
                        <?php endif; ?>
                </div>
            </div>
        </section>
    </main>
</body>

</html>