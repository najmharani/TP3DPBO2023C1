<?php

include('config/db.php');
include('classes/DB.php');
include('classes/Movie.php');
include('classes/Template.php');

$listMovie = new Movie($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);

$listMovie->open();
$listMovie->getMovieJoin();

$sortType = 'A-Z';

if (isset($_POST['btn-search'])) {
    $listMovie->searchMovie($_POST['search']);
} else if (isset($_POST['btn-sort-A-Z'])) {

    $listMovie->sortByName('ASC');
    $sortType = 'Z-A';
} else if (isset($_POST['btn-sort-Z-A'])) {

    $listMovie->sortByName('DESC');
    $sortType = 'A-Z';
} else {
    $listMovie->getMovieJoin();
}

$data = null;

while ($row = $listMovie->getResult()) {
    $data .= '<div class="col gx-2 gy-3 justify-content-center">' .
        '<div class="card pt-4 px-2 movie-thumbnail">
        <a href="detail.php?id=' . $row['id_movie'] . '">
            <div class="row justify-content-center">
                <img src="assets/images/' . $row['movie_poster'] . '" class="card-img-top" alt="' . $row['movie_poster'] . '">
            </div>
            <div class="card-body">
                <p class="card-text title my-0">' . $row['title'] . '</p>
                <p class="card-text genre-name">' . $row['genre_name'] . '</p>
                <p class="card-text director-name my-0">' . $row['director_name'] . '</p>
            </div>
        </a>
    </div>    
    </div>';
}

$listMovie->close();

$home = new Template('templates/skin.html');

$home->replace('SORT_TYPE', $sortType);
$home->replace('MOVIE_DATA', $data);
$home->write();