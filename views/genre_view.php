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
                <h2 class="h2 section-title"><?php echo htmlspecialchars($genreName); ?> Genre Results:</h2>

                <ul class="filter-list">
                    <li>
                        <a href="?id=<?php echo htmlspecialchars($id); ?>&type=movie&page=1"
                            class="filter-btn <?php echo ($type == 'movie') ? 'active' : ''; ?>">Movies</a>
                    </li>
                    <li>
                        <a href="?id=<?php echo htmlspecialchars($id); ?>&type=tv&page=1"
                            class="filter-btn <?php echo ($type == 'tv') ? 'active' : ''; ?>">TV Shows</a>
                    </li>
                    <li>
                        <div class="dropdown filter-btn">
                            <button class="dropbtn">Genre</button>
                            <div class="dropdown-content">
                                <?php if ($type == 'movie'): ?>
                                    <?php foreach ($moviesG as $genre): ?>
                                        <a
                                            href="?id=<?php echo $genre['id']; ?>&type=movie&page=1"><?php echo $genre['name']; ?></a>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <?php foreach ($tvShowG as $genre): ?>
                                        <a
                                            href="?id=<?php echo $genre['id']; ?>&type=tv&page=1"><?php echo $genre['name']; ?></a>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </div>
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
                                href="?id=<?php echo htmlspecialchars($id); ?>&type=<?php echo htmlspecialchars($type); ?>&page=<?php echo $page - 1; ?>">Previous</a>
                        </li>
                    <?php endif; ?>
                    <li>
                        <span class="filter-btn" >Page <?php echo $page; ?></span>
                    </li>
                    <?php if ($page < $results['total_pages']): ?>
                        <li>
                            <a class="filter-btn"
                            href="?id=<?php echo htmlspecialchars($id); ?>&type=<?php echo htmlspecialchars($type); ?>&page=<?php echo $page + 1; ?>">Next</a>

                        </li>
                        <?php endif; ?>
                </div>
            </div>
        </section>
    </main>
</body>

</html>