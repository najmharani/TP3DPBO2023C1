<?php

include('config/db.php');
include('classes/DB.php');
include('classes/Movie.php');
include('classes/Genre.php');
include('classes/Director.php');
include('classes/Template.php');

$movie = new Movie($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$movie->open();

$data = null;

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    if ($id > 0) {
        if ($movie->deleteData($id) > 0) {
            echo "<script>
                alert('Data berhasil dihapus!');
                document.location.href = 'index.php';
            </script>";
        } else {
            echo "<script>
                alert('Data gagal dihapus!');
                document.location.href = 'index.php';
            </script>";
        }
    }
}

if (isset($_GET['id'])) {

    $id = $_GET['id'];
    if ($id > 0) {
        $movie->getMovieById($id);
        $row = $movie->getResult();

        $data .= '<div class="card-header text-center">
        <h3 class="my-0">Detail ' . $row['title'] . '</h3>
        </div>
        <div class="card-body text-end">
            <div class="row mb-5">
                <div class="col-3">
                    <div class="row justify-content-center">
                        <img src="assets/images/' . $row['movie_poster'] . '" class="img-thumbnail" alt="' . $row['movie_poster'] . '" width="60">
                        </div>
                    </div>
                    <div class="col-9">
                        <div class="card px-3">
                            <table border="0" class="text-start">
                                <tr>
                                    <td>Title</td>
                                    <td>:</td>
                                    <td>' . $row['title'] . '</td>
                                </tr>
                                <tr>
                                <tr>
                                    <td>Genre</td>
                                    <td>:</td>
                                    <td>' . $row['genre_name'] . '</td>
                                </tr>
                                    <td>Year</td>
                                    <td>:</td>
                                    <td>' . $row['release_year'] . '</td>
                                </tr>
                                <tr>
                                    <td>Country</td>
                                    <td>:</td>
                                    <td>' . $row['country'] . '</td>
                                </tr>
                                <tr>
                                    <td>Director</td>
                                    <td>:</td>
                                    <td>' . $row['director_name'] . '</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-end">
                <a href="create.php?id=' . $row['id_movie'] . '"><button type="button" class="btn btn-success text-white">Update Data</button></a>
                <a href="detail.php?delete=' . $row['id_movie'] . '"><button type="button" class="btn btn-danger" id="delete" name ="delete">Delete Data</button></a>
            </div>';
    }
}

$movie->close();
$detail = new Template('templates/skindetail.html');
$detail->replace('DATA_DETAIL_MOVIE', $data);
$detail->write();