<?php
require_once '../includes/api.php';

class Movie
{
    private $conn;

    public function __construct()
    {
        $this->conn = curl_init();
    }

    public function search($query, $page = 1)
    {
        $url = API_URL . '3/search/multi?query=' . urlencode($query) . '&include_adult=false&language=en-US&page=' . $page;

        $list = $this->sendRequest($url);
        $allList = [];
        foreach ($list['results'] as $ls) {
            if ($ls['media_type'] == 'movie') {
                $allList['movie'][] = $ls;
            } elseif ($ls['media_type'] == 'tv') {
                $allList['tv'][] = $ls;
            }
        }
        if (!empty($allList['movie'])) {
            usort($allList['movie'], function($a, $b) {
                return $b['vote_average'] - $a['vote_average'];
            });
        }

        if (!empty($allList['tv'])) {
            usort($allList['tv'], function($a, $b) {
                return $b['vote_average'] - $a['vote_average'];
            });
        }

        return $allList;
    }

    private function sendRequest($url)
    {
        curl_setopt($this->conn, CURLOPT_URL, $url);
        curl_setopt($this->conn, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->conn, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . API_KEY,
            'Accept: application/json',
        ]);

        $response = curl_exec($this->conn);

        if (curl_errno($this->conn)) {
            echo 'Error:' . curl_error($this->conn);
        } else {
            return json_decode($response, true);
        }
    }
    public function getMovie($id)
    {
        $url = API_URL . '3/movie/' . $id . '?language=en-US';

        return $this->sendRequest($url);
    }

    public function getTVShow($id)
    {
        $url = API_URL . '3/tv/' . $id . '?language=en-US';

        return $this->sendRequest($url);
    }

    public function getMovieCredits($id)
    {
        $url = API_URL . '3/movie/' . $id . '/credits';

        return $this->sendRequest($url);
    }

    public function getTVShowCredits($id)
    {
        $url = API_URL . '3/tv/' . $id . '/credits';

        return $this->sendRequest($url);
    }

    public function getMovieReviews($id)
    {
        $url = API_URL . '3/movie/' . $id . '/reviews';

        return $this->sendRequest($url);
    }

    public function getTVShowReviews($id)
    {
        $url = API_URL . '3/tv/' . $id . '/reviews';

        return $this->sendRequest($url);
    }

    public function getMovieVideos($id)
    {
        $url = API_URL . '3/movie/' . $id . '/videos';

        return $this->sendRequest($url);
    }

    public function getTVShowVideos($id)
    {
        $url = API_URL . '3/tv/' . $id . '/videos';

        return $this->sendRequest($url);
    }

    public function getMovieImages($id)
    {
        $url = API_URL . '3/movie/' . $id . '/images';

        return $this->sendRequest($url);
    }

    public function getTVShowImages($id)
    {
        $url = API_URL . '3/tv/' . $id . '/images';

        return $this->sendRequest($url);
    }

    public function getMovieRecommendations($id)
    {
        $url = API_URL . '3/movie/' . $id . '/recommendations';

        return $this->sendRequest($url);
    }

    public function getTVShowRecommendations($id)
    {
        $url = API_URL . '3/tv/' . $id . '/recommendations';

        return $this->sendRequest($url);
    }

    public function getMovieSimilar($id)
    {
        $url = API_URL . '3/movie/' . $id . '/similar';

        return $this->sendRequest($url);
    }

    public function getTVShowSimilar($id)
    {
        $url = API_URL . '3/tv/' . $id . '/similar';

        return $this->sendRequest($url);
    }

    public function getMovieGenres()
    {
        $url = API_URL . '3/genre/movie/list?language=en-US';

        return $this->sendRequest($url);
    }

    public function getTVShowGenres()
    {
        $url = API_URL . '3/genre/tv/list?language=en-US';

        return $this->sendRequest($url);
    }

    public function getMovieByGenre($genreID, $page = 1)
    {
        $url = API_URL . '3/discover/movie?with_genres=' . $genreID . '&language=en-US&page=' . $page;

        return $this->sendRequest($url);
    }

    public function getTVShowByGenre($genreID, $page = 1)
    {
        $url = API_URL . '3/discover/tv?with_genres=' . $genreID . '&language=en-US&page=' . $page;

        return $this->sendRequest($url);
    }

    public function getMovieByYear($year, $page = 1)
    {
        $url = API_URL . '3/discover/movie?primary_release_year=' . $year . '&language=en-US&page=' . $page;

        return $this->sendRequest($url);
    }

    public function getTVShowByYear($year, $page = 1)
    {
        $url = API_URL . '3/discover/tv?first_air_date_year=' . $year . '&language=en-US&page=' . $page;

        return $this->sendRequest($url);
    }

    public function getPopularMovies($page = 1)
    {
        $url = API_URL . '3/movie/popular?language=en-US&page=' . $page;

        return $this->sendRequest($url);
    }

    public function getTopRatedMovies($page = 1)
    {
        $url = API_URL . '3/movie/top_rated?language=en-US&page=' . $page;

        return $this->sendRequest($url);
    }

    public function getNowPlayingMovies($page = 1)
    {
        $url = API_URL . '3/movie/now_playing?language=en-US&page=' . $page;

        return $this->sendRequest($url);
    }

    public function getUpcomingMovies($page = 1)
    {
        $url = API_URL . '3/movie/upcoming?language=en-US&page=' . $page;

        return $this->sendRequest($url);
    }

    public function getPopularTVShows($page = 1)
    {
        $url = API_URL . '3/tv/popular?language=en-US&page=' . $page;

        return $this->sendRequest($url);
    }

    public function getTopRatedTVShows($page = 1)
    {
        $url = API_URL . '3/tv/top_rated?language=en-US&page=' . $page;

        return $this->sendRequest($url);
    }

    public function getSeasonDetail($series_id, $season_number) {
        $url = API_URL . "3/tv/{$series_id}/season/{$season_number}";
        return $this->sendRequest($url);
    }

    public function getOnTheAirTVShows($page = 1)
    {
        $url = API_URL . '3/tv/on_the_air?language=en-US&page=' . $page;

        return $this->sendRequest($url);
    }

    public function getAiringTodayTVShows($page = 1)
    {
        $url = API_URL . '3/tv/airing_today?language=en-US&page=' . $page;

        return $this->sendRequest($url);
    }

    public function getTrendingMovies($page = 1)
    {
        $url = API_URL . '3/trending/movie/day?page=' . $page;

        return $this->sendRequest($url);
    }

    public function getTrendingTVShows($page = 1)
    {
        $url = API_URL . '3/trending/tv/day?page=' . $page;

        return $this->sendRequest($url);
    }

    public function getTrendingPeople($page = 1)
    {
        $url = API_URL . '3/trending/person/day?page=' . $page;

        return $this->sendRequest($url);
    }

    public function getPerson($id)
    {
        $url = API_URL . '3/person/' . $id . '?language=en-US';

        return $this->sendRequest($url);
    }

    public function getPersonCredits($id)
    {
        $url = API_URL . '3/person/' . $id . '/combined_credits?language=en-US';

        return $this->sendRequest($url);
    }

    public function getPersonImages($id)
    {
        $url = API_URL . '3/person/' . $id . '/images';

        return $this->sendRequest($url);
    }

    public function getPersonTaggedImages($id)
    {
        $url = API_URL . '3/person/' . $id . '/tagged_images';

        return $this->sendRequest($url);
    }

    public function getMovieListDetails($list)
    {
        $all = [];
        foreach ($list as $ls) {
            $all[] = $this->getMovie($ls['id']);
        }
        return $all;
    }
    public function getTvshowListDetails($list)
    {
        $all = [];
        foreach ($list as $ls) {
            $all[] = $this->getTVShow($ls['id']);
        }
        return $all;
    }


}