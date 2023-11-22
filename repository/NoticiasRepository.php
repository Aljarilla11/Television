<?php

require_once '../repository/Db.php';
require_once '../entities/Noticias.php';

class NoticiaRepository
{
    private $conexion;

    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }

    public function getAllNoticias()
    {
        $sql = "SELECT * FROM noticias";
        $result = $this->conexion->query($sql);
        $noticias = [];
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) 
        {
            $noticias[] = new Noticia(
                $row['id'],
                $row['fechaComienzo'],
                $row['fechaFin'],
                $row['duracion'],
                $row['prioridad'],
                $row['titulo'],
                $row['perfil'],
                $row['tipo'],
                $row['contenido'],
                $row['url'],
                $row['formato']
            );
        }
        return $noticias;
    }

    public function getNoticiaById($id)
    {
        $sql = "SELECT * FROM noticias WHERE id = :id";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new Noticia(
                $row['id'],
                $row['fechaComienzo'],
                $row['fechaFin'],
                $row['duracion'],
                $row['prioridad'],
                $row['titulo'],
                $row['perfil'],
                $row['tipo'],
                $row['contenido'],
                $row['url'],
                $row['formato']
            );
        } else {
            return null;
        }
    }

    public function deleteNoticiaById($id)
    {
        $sql = "DELETE FROM noticias WHERE id = :id";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }
}

?>