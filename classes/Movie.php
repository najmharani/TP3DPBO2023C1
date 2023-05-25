<?php

class Movie extends DB
{
    function getMovieJoin()
    {
        $query = "SELECT * FROM movie JOIN genre ON movie.genre_id=genre.id_genre JOIN director ON movie.director_id=director.id_director ORDER BY movie.id_movie";

        return $this->execute($query);
    }
    function sortByName($type)
    {
        $query = "SELECT * FROM movie JOIN genre ON movie.genre_id=genre.id_genre JOIN director ON movie.director_id=director.id_director ORDER BY movie.title $type";

        return $this->execute($query);
    }

    function getMovie()
    {
        $query = "SELECT * FROM movie";
        return $this->execute($query);
    }

    function getMovieById($id)
    {
        $query = "SELECT * FROM movie JOIN genre ON movie.genre_id=genre.id_genre JOIN director ON movie.director_id=director.id_director WHERE id_movie=$id";
        return $this->execute($query);
    }

    function searchMovie($keyword)
    {
        $query = "SELECT * FROM movie JOIN genre ON movie.genre_id=genre.id_genre JOIN director ON movie.director_id=director.id_director WHERE title LIKE '%$keyword%'";
        return $this->execute($query);
    }

    function addData($data, $file)
    {
        $title = $data['title'];
        $release_year = $data['year'];
        $country = $data['country'];
        $genre = $data['genre'];
        $director = $data['director'];
        $query = "INSERT INTO movie VALUES('', '$title', '$release_year', '$file', '$country', '$director','$genre')";
        return $this->executeAffected($query);
    }

    function updateData($id, $data, $file)
    {
        $title = $data['title'];
        $release_year = $data['year'];
        $country = $data['country'];
        $genre = $data['genre'];
        $director = $data['director'];
        $query = "UPDATE movie SET movie_poster='$file', title='$title', release_year='$release_year', country='$country', genre_id='$genre', director_id='$director' WHERE id_movie=$id";
        return $this->executeAffected($query);
    }

    function deleteData($id)
    {
        $query = "DELETE FROM movie WHERE id_movie=$id";
        return $this->executeAffected($query);
    }
}