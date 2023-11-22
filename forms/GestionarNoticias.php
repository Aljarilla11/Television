<?php
require_once "../repository/Db.php";

// Obtener la conexión
$conexion = Db::conectar();

// Acciones
$action = isset($_GET['action']) ? $_GET['action'] : '';

switch ($action) {
    case 'create':
        break;

    case 'edit':
        // Muestra el formulario de edición con los datos actuales
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            header("Location: EditarNoticia.php?id=$id");
            exit();
        }
        break;


    case 'delete':
        // Eliminar la noticia
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $query = "DELETE FROM noticias WHERE id = :id";
            $stmt = $conexion->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
        }

        // Redirigir a la página del CRUD
        header("Location: GestionarNoticias.php");
        exit();
        break;

    default:
        // Obtener todas las noticias
        $query = "SELECT * FROM noticias";
        $stmt = $conexion->prepare($query);
        $stmt->execute();
        $noticias = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Cerrar la conexión
        $conexion = null;
        break;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD de Noticias</title>
    <link rel="stylesheet" href="../estilos/estiloGestionarNoticias.css">
</head>
<body>

<h1>Noticias</h1>

<table border="1">
    <tr>
        <th>Título</th>
        <th>Fecha de Comienzo</th>
        <th>Acciones</th>
    </tr>

    <?php foreach ($noticias as $noticia) : ?>
        <tr>
            <td><?php echo $noticia['titulo']; ?></td>
            <td><?php echo $noticia['fechaComienzo']; ?></td>
            <td>
                <a href="?action=edit&id=<?php echo $noticia['id']; ?>">Editar</a>
                <a href="?action=delete&id=<?php echo $noticia['id']; ?>">Eliminar</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<a href="AgregarNoticias.php">Crear Noticia</a>

</body>
</html>
