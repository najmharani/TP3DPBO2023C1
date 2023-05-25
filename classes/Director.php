<?php

class Director extends DB
{
    function getDirector()
    {
        $query = "SELECT * FROM director";
        return $this->execute($query);
    }
    function searchDirector($keyword)
    {
        $query = "SELECT * FROM director WHERE director_name LIKE '%$keyword%'";
        return $this->execute($query);
    }
    function sortByName($type)
    {
        $query = "SELECT * FROM director ORDER BY director_name $type";
        return $this->execute($query);
    }

    function getDirectorById($id)
    {
        $query = "SELECT * FROM director WHERE id_director=$id";
        return $this->execute($query);
    }

    function addDirector($data)
    {
        $name = $data['name'];
        $query = "INSERT INTO director VALUES('', '$name')";
        return $this->executeAffected($query);
    }

    function updateDirector($id, $data)
    {
        $name = $data['name'];
        $query = "UPDATE director SET director_name='$name' WHERE id_director=$id";
        return $this->executeAffected($query);
    }

    function deleteDirector($id)
    {
        $query = "DELETE FROM director WHERE id_director=$id";
        return $this->executeAffected($query);
    }
}