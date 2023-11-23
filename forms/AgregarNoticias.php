<?php
require_once "../repository/Db.php";

// Verificar si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["enviarFormulario"])) {
    // Obtener los datos del formulario
    $fechaInicio = $_POST["fechaInicio"];
    $fechaFin = $_POST["fechaFin"];
    $duracion = $_POST["duracion"];
    $prioridad = $_POST["prioridad"];
    $titulo = $_POST["titulo"];
    $perfil = $_POST["perfil"];
    $tipoContenido = $_POST["tipoContenido"];
    $contenido = isset($_POST["contenido"]) ? $_POST["contenido"] : null;
    $url = '';
    $formato = '';

    if ($fechaInicio != null && $fechaFin != null){

    // Convertir el formato de fecha
    $fechaInicio = DateTime::createFromFormat('d/m/Y H:i:s', $fechaInicio)->format('Y-m-d H:i:s');
    $fechaFin = DateTime::createFromFormat('d/m/Y H:i:s', $fechaFin)->format('Y-m-d H:i:s');
    }
    // Determinar los campos específicos según el tipo de contenido
    if ($tipoContenido === "Web") {
        $url = ''; // Para el tipo Web, no se necesita una URL adicional
    } elseif ($tipoContenido === "Imagen") {
        $url = $_POST["urlImagenInput"];
    } elseif ($tipoContenido === "Video") {
        $url = $_POST["urlVideoInput"];
        $formato = $_POST["formatoVideoInput"];
    }

    // Realizar la conexión a la base de datos con PDO
    $conexion = Db::conectar();

    // Insertar datos en la base de datos
    $query = "INSERT INTO noticias (fechaComienzo, fechaFin, duracion, prioridad, titulo, perfil, tipo, contenido, url, formato)
              VALUES (:fechaInicio, :fechaFin, :duracion, :prioridad, :titulo, :perfil, :tipoContenido, :contenido, :url, :formato)";

    $stmt = $conexion->prepare($query);

    // Verificar si la preparación fue exitosa
    if ($stmt) {
        // Enlazar parámetros
        $stmt->bindParam(":fechaInicio", $fechaInicio);
        $stmt->bindParam(":fechaFin", $fechaFin);
        $stmt->bindParam(":duracion", $duracion);
        $stmt->bindParam(":prioridad", $prioridad);
        $stmt->bindParam(":titulo", $titulo);
        $stmt->bindParam(":perfil", $perfil);
        $stmt->bindParam(":tipoContenido", $tipoContenido);
        $stmt->bindParam(":contenido", $contenido);
        $stmt->bindParam(":url", $url);
        $stmt->bindParam(":formato", $formato);

        // Ejecutar la consulta
        $stmt->execute();

        // Verificar si la inserción fue exitosa
        if ($stmt->rowCount() > 0) {
            echo "Noticia insertada correctamente.";
        } else {
            echo "Error al insertar la noticia.";
        }

        // Cerrar la declaración
        $stmt = null;
    } else {
        echo "Error en la preparación de la consulta.";
    }

    // Cerrar la conexión
    $conexion = null;
    header("Location: GestionarNoticias.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Evento</title>
    <script src="../js/AgregarNoticia.js"></script>
    <link rel="stylesheet" href="../estilos/estiloAgregarNoticia.css">
</head>
<body>
    <h1>Formulario de Evento</h1>
    
    <form action="" method="post">
        <label for="titulo">Título:</label>
        <input type="text" name="titulo" id="titulo" placeholder="Ejemplo: Título de la Noticia" required>

        <label for="fechaInicio">Fecha de Inicio (dd/mm/aaaa hh:mm:ss):</label>
        <input type="text" name="fechaInicio" id="fechaInicio" placeholder="Ejemplo: 01/01/2023 12:00:00" required>

        <label for="fechaFin">Fecha de Fin (dd/mm/aaaa hh:mm:ss):</label>
        <input type="text" name="fechaFin" id="fechaFin" placeholder="Ejemplo: 02/01/2023 14:30:00" required>

        <label for="duracion">Duración (segundos):</label>
        <input type="number" name="duracion" id="duracion" placeholder="Ejemplo: 3600" required>

        <label for="prioridad">Prioridad:</label>
        <input type="number" name="prioridad" id="prioridad" placeholder="Ejemplo: 1" required>

        <label for="tipoContenido">Tipo de Contenido:</label>
        <select name="tipoContenido" id="tipoContenido" onchange="mostrarCamposContenido()" required>
            <option value="Web">Web</option>
            <option value="Video">Video</option>
            <option value="Imagen">Imagen</option>
        </select>

        <div id="contenidoTextArea">
            <label for="contenido">Contenido (para tipo Web):</label>
            <textarea name="contenido" id="contenido" rows="4" placeholder="Escribe aquí el contenido"></textarea>
        </div>

        <div id="urlImagen">
            <label for="urlImagenInput">URL de la Imagen (para tipo Imagen):</label>
            <input type="text" name="urlImagenInput" id="urlImagenInput" placeholder="Ejemplo: https://ejemplo.com/imagen.jpg">
        </div>

        <div id="urlVideo">
            <label for="urlVideoInput">URL del Video (para tipo Video):</label>
            <input type="text" name="urlVideoInput" id="urlVideoInput" placeholder="Ejemplo: https://ejemplo.com/video.mp4">
        </div>

        <div id="formatoVideo">
            <label for="formatoVideoInput">Formato del Video (para tipo Video):</label>
            <select name="formatoVideoInput" id="formatoVideoInput">
                <option value="mp4">MP4</option>
                <option value="avi">AVI</option>
                <option value="mpg">MPG</option>
                <option value="ogg">OGG</option>
            </select>
        </div>

        <label for="perfil">Perfil:</label>
        <select name="perfil" id="perfil" required>
            <option value="todos">Todos</option>
            <option value="alumno">Alumno</option>
            <option value="profesor">Profesor</option>
        </select>

        <button type="submit" name="enviarFormulario">Enviar</button>
    </form>
</body>
</html>