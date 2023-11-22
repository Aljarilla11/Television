<?php
require_once "../repository/Db.php";

// Obtener la conexión
$conexion = Db::conectar();

// Obtener todas las noticias
$query = "SELECT * FROM noticias";
$stmt = $conexion->prepare($query);
$stmt->execute();
$noticias = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Cerrar la conexión
$conexion = null;

// Formatear los datos como un array de noticias
$arrayDeNoticias = [];
foreach ($noticias as $noticia) {
    $arrayDeNoticias[] = [
        'id' => $noticia['id'],
        'fechaComienzo' => $noticia['fechaComienzo'],
        'fechaFin' => $noticia['fechaFin'],
        'duracion' => $noticia['duracion'],
        'prioridad' => $noticia['prioridad'],
        'titulo' => $noticia['titulo'],
        'perfil' => $noticia['perfil'],
        'tipo' => $noticia['tipo'],
        'contenido' => $noticia['contenido'],
        'url' => $noticia['url'],
        'formato' => $noticia['formato']
    ];
}

// Crear el objeto JSON con la estructura deseada
$jsonResponse = json_encode(['noticias' => $arrayDeNoticias]);

// Configurar las cabeceras para indicar que la respuesta es JSON
header('Content-Type: application/json');

// Devolver la respuesta JSON
echo $jsonResponse;
?>
