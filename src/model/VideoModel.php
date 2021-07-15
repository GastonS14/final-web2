<?php

class VideoModel {

    // Se asume que el id de valoracion es serial
    public function addValoracion($id_usuario, $valoracion, $id_video) {
        //
        $query = INSERT INTO valoracion(id_video, id_usuario, valoracion) VALUES(?, ?, ?)
        $query->execute(array($id_usuario, $valoracion, $id_video));
        $query->fetch(PDO::class);
    }

    public function isOwnVideo($id_usuario, $id_video) {
        $query = SELECT 1 FROM video v WHERE ? IN(
            SELECT id_usuario FROM video WHERE $id_video = ?
        )
        $query->execute(array($id_usuario, $id_video));
        $query->fetch(PDO::class);
    }

    public function isVotedForUser($id_usuario, $id_video) {
        $query = SELECT 1 FROM valoracion WHERE $id_usuario = ? AND $id_video = ?;
        $query->execute(array($id_usuario, $id_video));
        $query->fetch(PDO::class);
    }

    public function findLessThanValueByAvg($value) {
        $query =
            SELECT id_video, avg(valoracion) as avgVideos
            FROM valoracion
            GROUP BY id_video
            HAVING(avgVideos < ?);
        $query->execute(array($value));
        $query->fetch(PDO::class);
    }

    public function findAvgByVideo($id_video) {
        $query = SELECT avg(valoracion) FROM valoracion WHERE WHERE $id_video = ?;
        $query->execute(array($id_video));
        $query->fetch(PDO::class);
    }

    public function findById($id_video) {
        $query = SELECT * FROM video WHERE $id_usuario = ?;
        $query->execute(array($id_video));
        $query->fetch(PDO::class);
    }

    // Se asume que valoracion tiene una FK a video con el valoracion.id_video -> vide.id
    public function findAllByVideoId($id_video) {
        $query = SELECT u.nombre, va.valoracion,
        FROM video v
        JOIN valoracion va
        ON(v.id = va.id_video)
        JOIN usuario u
        ON(v.id_usuario = u.id);
        $query->execute(array($id_usuario, $id_video));
        $query->fetch(PDO::class);
    }

    public function existOrExistWithoutValue($id_video) {
        $query = SELECT 1
        FROM video v
        JOIN valoracion va
        ON(v.id = va.id_video)
            WHERE va.id_video = ?
        $query->execute(array($id_video));
        $query->fetch(PDO::class);
    }
}
