<?php

include('config/db.php');
include('classes/DB.php');
include('classes/Director.php');
include('classes/Template.php');

$director = new Director($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$director->open();
$director->getDirector();

$table = 'director';
$sortType = 'A-Z';

if (isset($_POST['btn-search'])) {
    $director->searchDirector($_POST['search']);
} else if (isset($_POST['btn-sort-A-Z'])) {
    $director->sortByName('ASC');
    $sortType = 'Z-A';
} else if (isset($_POST['btn-sort-Z-A'])) {

    $director->sortByName('DESC');
    $sortType = 'A-Z';
} else {
    $director->getDirector();
}

if (!isset($_GET['id'])) {
    if (isset($_POST['submit'])) {
        if ($director->addDirector($_POST) > 0) {
            echo "<script>
                alert('Data berhasil ditambah!');
                document.location.href = 'director.php';
            </script>";
        } else {
            echo "<script>
                alert('Data gagal ditambah!');
                document.location.href = 'director.php';
            </script>";
        }
    }

    $btn = 'Add';
    $formTitle = 'Add New Director';
    $formAction = 'action="director.php"';
}

$view = new Template('templates/skintabel.html');

$mainTitle = 'Director';
$header = '<tr>
<th scope="row">No.</th>
<th scope="row">Director Name</th>
<th scope="row">Action</th>
</tr>';
$data = null;
$no = 1;
$formLabel = 'Director';

while ($div = $director->getResult()) {
    $data .= '<tr>
    <th scope="row">' . $no . '</th>
    <td>' . $div['director_name'] . '</td>
    <td style="font-size: 22px;">
        <a href="director.php?id=' . $div['id_director'] . '" title="Edit Data"><i class="bi bi-pencil-square text-warning"></i></a>&nbsp;<a href="director.php?hapus=' . $div['id_director'] . '" title="Delete Data"><i class="bi bi-trash-fill text-danger"></i></a>
        </td>
    </tr>';
    $no++;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if ($id > 0) {
        if (isset($_POST['submit'])) {
            if ($director->updateDirector($id, $_POST) > 0) {
                echo "<script>
                alert('Data berhasil diubah!');
                document.location.href = 'director.php';
            </script>";
            } else {
                echo "<script>
                alert('Data gagal diubah!');
                document.location.href = 'director.php';
            </script>";
            }
        }

        $director->getDirectorById($id);
        $row = $director->getResult();

        $dataUpdate = 'value="' . $row['director_name'] . '"';
        $btn = 'Save';
        $formTitle = 'Update Director';
        $formAction = 'action="director.php?id=' . $id . '"';

        $view->replace('FORM_VALUE', $dataUpdate);
    }
}

if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    if ($id > 0) {
        if ($director->deleteDirector($id) > 0) {
            echo "<script>
                alert('Data berhasil dihapus!');
                document.location.href = 'director.php';
            </script>";
        } else {
            echo "<script>
                alert('Data gagal dihapus!');
                document.location.href = 'director.php';
            </script>";
        }
    }
}

$director->close();

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