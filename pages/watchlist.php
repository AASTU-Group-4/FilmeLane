<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require_once ('../includes/db_connection.php');
require_once ('../models/UserWatchlist.php');
require_once ('../models/Movie.php');

$user_id = $_SESSION['user_id'];
$UserWatchlist = new UserWatchList();
$movie = new Movie();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];

    switch ($action) {
        case 'create':
            $user_id = $_POST['user_id'];
            $movie_id = $_POST['movie_id'];
            $type = $_POST['type'];
            $UserWatchlist->addToWatchlist($user_id, $movie_id, $type);
            break;

        case 'delete':
            $watchlist_id = $_POST['watchlist_id'];
            $UserWatchlist->removeMovieFromWatchlist($user_id, $watchlist_id);
            break;

        case 'clear':
            $UserWatchlist->clearWatchlist($user_id);
            break;
    }

    header("Location: watchlist.php");
    exit;
}

$UserWatchlistList = $UserWatchlist->getWatchlist($user_id);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../public/favicon.svg" type="image/svg+xml">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../public/css/watchlist.css">
    <title>User Watchlist</title>

</head>

<body>
    <div class="container-xl px-4 mt-4">
        <!-- Account page navigation-->
        <nav class="nav nav-borders">
            <a class="nav-link active ms-0" href="/pages/update_account.php" target="__blank">Profile</a>
            <a class="nav-link" href="/pages/home.php" target="__blank">Home</a>
            <a class="nav-link" href="/pages/history.php" target="__blank">History</a>
            <a class="nav-link" href="/pages/watchlist.php" target="__blank">My List</a>
            <a class="nav-link" href="/pages/logout.php">Logout</a>
        </nav>
        <div class="container mt-5">
            <h2>User Watchlist</h2>
            <div class="mb-3">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addWatchlistModal">Add to Watchlist</button>
                <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#clearWatchlistModal">Clear Watchlist</button>
            </div>

            <div class="mb-3">
                <input type="text" id="searchInput" class="form-control" placeholder="Search watchlist...">
            </div>

            <div class="table-container">
                <table class="table table-bordered" id="watchlistTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Movie <button class="btn btn-link p-0" onclick="sortTable(1)">Sort</button></th>
                            <th>Added At <button class="btn btn-link p-0" onclick="sortTable(2)">Sort</button></th>
                            <th>Type <button class="btn btn-link p-0" onclick="sortTable(3)">Sort</button></th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($UserWatchlistList as $watchlist): ?>
                            <?php
                            if ($watchlist['type'] == 'movie') {
                                $movieDetails = $movie->getMovie($watchlist['movie_id']);
                                $id = $watchlist['movie_id'];
                                $title = $movieDetails['title'];
                                $url = "<a href='./movie_info.php?id={$id}' target='_blank'>{$title}</a>";
                            } else {
                                $movieDetails = $movie->getTVShow($watchlist['movie_id']);
                                $id = $watchlist['movie_id'];
                                $title = $movieDetails['name'];
                                $url = "<a href='./series_info.php?id={$id}' target='_blank'>{$title}</a>";
                            }
                            ?>
                            <tr>
                                <td><?php echo $watchlist['watchlist_id']; ?></td>
                                <td><?php echo $url; ?></td>
                                <td><?php echo $watchlist['added_at']; ?></td>
                                <td><?php echo $watchlist['type']; ?></td>
                                <td>
                                    <form action="watchlist.php" method="POST" class="d-inline">
                                        <input type="hidden" name="watchlist_id" value="<?php echo $watchlist['watchlist_id']; ?>">
                                        <input type="hidden" name="action" value="delete">
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <nav aria-label="Page navigation">
                <ul class="pagination">
                    <!-- Pagination links will go here -->
                </ul>
            </nav>
        </div>

        <!-- Add to Watchlist Modal -->
        <div class="modal fade" id="addWatchlistModal" tabindex="-1" aria-labelledby="addWatchlistModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="watchlist.php" method="POST">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addWatchlistModalLabel">Add to Watchlist</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="action" value="create">
                            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                            <div class="mb-3">
                                <label for="movie_id" class="form-label">Movie ID</label>
                                <input type="text" class="form-control" id="movie_id" name="movie_id" required>
                            </div>
                            <div class="mb-3">
                                <label for="type" class="form-label">Type</label>
                                <select class="form-control" id="type" name="type" required>
                                    <option value="movie">Movie</option>
                                    <option value="tv">TV</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Clear Watchlist Modal -->
        <div class="modal fade" id="clearWatchlistModal" tabindex="-1" aria-labelledby="clearWatchlistModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="watchlist.php" method="POST">
                        <div class="modal-header">
                            <h5 class="modal-title" id="clearWatchlistModalLabel">Clear Watchlist</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="action" value="clear">
                            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                            <p>Are you sure you want to clear your entire watchlist?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger">Clear Watchlist</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for sorting and filtering -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Sort table by column index
        function sortTable(columnIndex) {
            let table, rows, switching, i, x, y, shouldSwitch;
            table = document.getElementById("watchlistTable");
            switching = true;
            while (switching) {
                switching = false;
                rows = table.rows;
                for (i = 1; i < (rows.length - 1); i++) {
                    shouldSwitch = false;
                    x = rows[i].getElementsByTagName("td")[columnIndex].innerText.toLowerCase();
                    y = rows[i + 1].getElementsByTagName("td")[columnIndex].innerText.toLowerCase();
                    if (x > y) {
                        shouldSwitch = true;
                        break;
                    }
                }
                if (shouldSwitch) {
                    rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                    switching = true;
                }
            }
        }

        // Filter table based on search input
        document.getElementById("searchInput").addEventListener("keyup", function () {
            let input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("searchInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("watchlistTable");
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[1]; // Column index for movie title
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        });
    </script>

    <script>
        // Example pagination handling
        // This is just a basic example to show pagination structure
        const table = document.getElementById('watchlistTable');
        const tableRows = table.getElementsByTagName('tr');
        const rowsPerPage = 5; // Number of rows per page
        let currentPage = 1;

        function paginate(page) {
            currentPage = page;
            for (let i = 0; i < tableRows.length; i++) {
                if (i < currentPage * rowsPerPage && i >= (currentPage - 1) * rowsPerPage) {
                    tableRows[i].style.display = '';
                } else {
                    tableRows[i].style.display = 'none';
                }
            }
        }

        function nextPage() {
            if (currentPage < Math.ceil(tableRows.length / rowsPerPage)) {
                paginate(currentPage + 1);
            }
        }

        function prevPage() {
            if (currentPage > 1) {
                paginate(currentPage - 1);
            }
        }

        // Initialize pagination
        paginate(1);
    </script>
</body>

</html>
