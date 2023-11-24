<?php
require_once "../repository/Db.php";

// Verificar si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Obtener los datos del formulario
    $id = $_POST["id"];
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

    // Actualizar datos en la base de datos
    $query = "UPDATE noticias SET 
              fechaComienzo = :fechaInicio,
              fechaFin = :fechaFin,
              duracion = :duracion,
              prioridad = :prioridad,
              titulo = :titulo,
              perfil = :perfil,
              tipo = :tipoContenido,
              contenido = :contenido,
              url = :url,
              formato = :formato
              WHERE id = :id";

    $stmt = $conexion->prepare($query);

    // Verificar si la preparación fue exitosa
    if ($stmt) {
        // Enlazar parámetros
        $stmt->bindParam(":id", $id);
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

        // Verificar si la actualización fue exitosa
        if ($stmt->rowCount() > 0) {
            echo "Noticia actualizada correctamente.";
        } else {
            echo "Error al actualizar la noticia.";
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
