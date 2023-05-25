<?php

include('config/db.php');
include('classes/DB.php');
include('classes/Movie.php');
include('classes/Genre.php');
include('classes/Director.php');
include('classes/Template.php');

$movie = new Movie($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$movie->open();

$genre = new Genre($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$genre->open();

$director = new Director($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$director->open();

$data = null;

$value_title = '';
$value_year = '';
$value_country = '';
$next_action = '';
$script = '';

if (isset($_FILES['poster'])) {
    $poster = $_FILES['poster'];
    $posterName = basename($poster['name']);
    $posterTmpName = $poster['tmp_name'];
    $posterError = $poster['error'];
    $posterSize = $poster['size'];

    $uploadDirectory = "assets/images/";

    if ($posterError === UPLOAD_ERR_OK) {
        move_uploaded_file($posterTmpName, $uploadDirectory . $posterName);
    }
}

if (!isset($_GET['id'])) {
    if (isset($_POST['submit'])) {


        if ($movie->addData($_POST, $posterName) > 0) {
            echo "<script>
                    alert('Data berhasil ditambah!');
                    document.location.href = 'index.php';
                    </script>";
        } else {
            echo "<script>
                    alert('Data gagal ditambah!');
                    document.location.href = 'create.php';
                    </script>";
        }
    }
    $action = "Add";
    $next_action = 'action="create.php"';

} else {
    $id = $_GET['id'];
    if ($id > 0) {

        if (isset($_POST['submit'])) {

            if ($movie->updateData($id, $_POST, $posterName) > 0) {
                echo "<script>
                alert('Data berhasil diubah!');
                document.location.href = 'index.php';
            </script>";
            } else {
                echo "<script>
            alert('Data gagal diubah!');
            document.location.href = 'index.php';
            </script>";
            }
        }

        $movie->getMovieById($id);
        $row = $movie->getResult();

        $value_title .= 'value="' . $row['title'] . '"';
        $value_year .= 'value="' . $row['release_year'] . '"';
        $value_country .= 'value="' . $row['country'] . '"';

        $script .= '<script>
        document.getElementById("genre").value = "' . $row['id_genre'] . '";
        document.getElementById("director").value = "' . $row['id_director'] . '";
        document.getElementById("poster").value = "' . $row['movie_poster'] . '";
        </script>';

        $action = "Update";
        $next_action = 'action="create.php?id=' . $id . '"';

    }

}

$director_option = '';
$director->getDirector();

while ($row = $director->getResult()) {
    $director_option .= '<option value="' . $row['id_director'] . '">' . $row['director_name'] . '</option>';
}

$genre_option = '';
$genre->getGenre();

while ($row = $genre->getResult()) {
    $genre_option .= '<option value="' . $row['id_genre'] . '">' . $row['genre_name'] . '</option>';
}

$movie->close();
$genre->close();
$director->close();

$form = new Template('templates/skinform.html');
$form->replace('ACTION', $action);
$form->replace('DIRECTOR_OPTION', $director_option);
$form->replace('GENRE_OPTION', $genre_option);
$form->replace('VALUE_TITLE', $value_title);
$form->replace('VALUE_YEAR', $value_year);
$form->replace('VALUE_COUNTRY', $value_country);
$form->replace('NEXT_ACTION', $next_action);
$form->replace('SCRIPT', $script);
$form->write();