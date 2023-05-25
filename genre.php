<?php

include('config/db.php');
include('classes/DB.php');
include('classes/Genre.php');
include('classes/Template.php');

$genre = new Genre($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$genre->open();
$genre->getGenre();
$table = 'genre';
$sortType = 'A-Z';

if (isset($_POST['btn-search'])) {
    $genre->searchGenre($_POST['search']);
} else if (isset($_POST['btn-sort-A-Z'])) {
    $genre->sortByName('ASC');
    $sortType = 'Z-A';
} else if (isset($_POST['btn-sort-Z-A'])) {

    $genre->sortByName('DESC');
    $sortType = 'A-Z';
} else {
    $genre->getGenre();
}

if (!isset($_GET['id'])) {
    if (isset($_POST['submit'])) {
        if ($genre->addGenre($_POST) > 0) {
            echo "<script>
                alert('Data berhasil ditambah!');
                document.location.href = 'genre.php';
            </script>";
        } else {
            echo "<script>
                alert('Data gagal ditambah!');
                document.location.href = 'genre.php';
            </script>";
        }
    }

    $btn = 'Add';
    $formTitle = 'Add New Genre';
    $formAction = 'action="genre.php"';
}

$view = new Template('templates/skintabel.html');

$mainTitle = 'Genre';
$header = '<tr>
<th scope="row">No.</th>
<th scope="row">Genre Name</th>
<th scope="row">Action</th>
</tr>';
$data = null;
$no = 1;
$formLabel = 'Genre';

while ($div = $genre->getResult()) {
    $data .= '<tr>
    <th scope="row">' . $no . '</th>
    <td>' . $div['genre_name'] . '</td>
    <td style="font-size: 22px;">
        <a href="genre.php?id=' . $div['id_genre'] . '" title="Edit Data"><i class="bi bi-pencil-square text-warning"></i></a>&nbsp;<a href="genre.php?hapus=' . $div['id_genre'] . '" title="Delete Data"><i class="bi bi-trash-fill text-danger"></i></a>
        </td>
    </tr>';
    $no++;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if ($id > 0) {
        if (isset($_POST['submit'])) {
            if ($genre->updateGenre($id, $_POST) > 0) {
                echo "<script>
                alert('Data berhasil diubah!');
                document.location.href = 'genre.php';
            </script>";
            } else {
                echo "<script>
                alert('Data gagal diubah!');
                document.location.href = 'genre.php';
            </script>";
            }
        }

        $genre->getGenreById($id);
        $row = $genre->getResult();

        $dataUpdate = 'value="' . $row['genre_name'] . '"';
        $btn = 'Save';
        $formTitle = 'Update Genre';
        $formAction = 'action="genre.php?id=' . $id . '"';

        $view->replace('FORM_VALUE', $dataUpdate);
    }
}

if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    if ($id > 0) {
        if ($genre->deleteGenre($id) > 0) {
            echo "<script>
                alert('Data berhasil dihapus!');
                document.location.href = 'genre.php';
            </script>";
        } else {
            echo "<script>
                alert('Data gagal dihapus!');
                document.location.href = 'genre.php';
            </script>";
        }
    }
}

$genre->close();

$view->replace('MAIN_DATA_TITLE', $mainTitle);
$view->replace('SORT_TYPE', $sortType);
$view->replace('TABLE_NAME', $table);
$view->replace('TABLE_DATA_HEADER', $header);
$view->replace('TABLE_DATA', $data);
$view->replace('FORM_LABEL', $formLabel);
$view->replace('FORM_TITLE', $formTitle);
$view->replace('FORM_ACTION', $formAction);
$view->replace('DATA_BUTTON', $btn);
$view->write();