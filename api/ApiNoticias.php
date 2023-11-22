<?php
require_once "../repository/Db.php";
require_once "../repository/NoticiasRepository.php";

// Obtener la conexión
$conexion = Db::conectar();

// Crear una instancia de NoticiaRepository
$noticiaRepository = new NoticiaRepository($conexion);

// Obtener todas las noticias
$noticias = $noticiaRepository->getAllNoticias();

// Cerrar la conexión
$conexion = null;

// Formatear los datos como un array de noticias
$arrayDeNoticias = [];
foreach ($noticias as $noticia) {
    $arrayDeNoticias[] = [
        'id' => $noticia->getId(),
        'fechaComienzo' => $noticia->getFechaComienzo(),
        'fechaFin' => $noticia->getFechaFin(),
        'duracion' => $noticia->getDuracion(),
        'prioridad' => $noticia->getPrioridad(),
        'titulo' => $noticia->getTitulo(),
        'perfil' => $noticia->getPerfil(),
        'tipo' => $noticia->getTipo(),
        'contenido' => $noticia->getContenido(),
        'url' => $noticia->getUrl(),
        'formato' => $noticia->getFormato()
    ];
}

// Crear el objeto JSON con la estructura deseada
$jsonResponse = json_encode(['noticias' => $arrayDeNoticias]);

// Configurar las cabeceras para indicar que la respuesta es JSON
header('Content-Type: application/json');

// Devolver la respuesta JSON
echo $jsonResponse;
?>s