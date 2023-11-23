<?php
require_once "../repository/Db.php";

// Obtener la conexión
$conexion = Db::conectar();

// Obtener el ID de la noticia a editar
$id = isset($_GET['id']) ? $_GET['id'] : '';

// Obtener los datos de la noticia
$query = "SELECT * FROM noticias WHERE id = :id";
$stmt = $conexion->prepare($query);
$stmt->bindParam(':id', $id);
$stmt->execute();
$noticia = $stmt->fetch(PDO::FETCH_ASSOC);

// Cerrar la conexión
$conexion = null;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Noticia</title>
    <link rel="stylesheet" href="../estilos/estiloAgregarNoticia.css">
</head>
<body>

<h1>Editar Noticia</h1>

<form action="ProcesarEdicion.php" method="post">
    <!-- Campo oculto para el ID -->
    <input type="hidden" name="id" value="<?php echo $noticia['id']; ?>">
    <label for="titulo">Título:</label>
<input type="text" name="titulo" value="<?php echo $noticia['titulo']; ?>" required>

<label for="fechaInicio">Fecha de Inicio (dd/mm/aaaa hh:mm:ss):</label>
<input type="text" name="fechaInicio" value="<?php echo $noticia['fechaComienzo']; ?>" required>

<label for="fechaFin">Fecha de Fin (dd/mm/aaaa hh:mm:ss):</label>
<input type="text" name="fechaFin" value="<?php echo $noticia['fechaFin']; ?>" required>

<label for="duracion">Duración (segundos):</label>
<input type="number" name="duracion" value="<?php echo $noticia['duracion']; ?>" required>

<label for="prioridad">Prioridad:</label>
<input type="number" name="prioridad" value="<?php echo $noticia['prioridad']; ?>" required>

<label for="tipoContenido">Tipo de Contenido:</label>
<select name="tipoContenido" required>
    <option value="Web" <?php echo ($noticia['tipo'] === 'Web') ? 'selected' : ''; ?>>Web</option>
    <option value="Video" <?php echo ($noticia['tipo'] === 'Video') ? 'selected' : ''; ?>>Video</option>
    <option value="Imagen" <?php echo ($noticia['tipo'] === 'Imagen') ? 'selected' : ''; ?>>Imagen</option>
</select>

<div id="contenidoTextArea" style="display: <?php echo ($noticia['tipo'] === 'Web') ? 'block' : 'none'; ?>">
    <label for="contenido">Contenido (para tipo Web):</label>
    <textarea name="contenido" rows="4" placeholder="Escribe aquí el contenido"><?php echo $noticia['contenido']; ?></textarea>
</div>

<div id="urlImagen" style="display: <?php echo ($noticia['tipo'] === 'Imagen') ? 'block' : 'none'; ?>">
    <label for="urlImagenInput">URL de la Imagen (para tipo Imagen):</label>
    <input type="text" name="urlImagenInput" value="<?php echo $noticia['url']; ?>" placeholder="Ejemplo: https://ejemplo.com/imagen.jpg">
</div>

<div id="urlVideo" style="display: <?php echo ($noticia['tipo'] === 'Video') ? 'block' : 'none'; ?>">
    <label for="urlVideoInput">URL del Video (para tipo Video):</label>
    <input type="text" name="urlVideoInput" value="<?php echo $noticia['url']; ?>" placeholder="Ejemplo: https://ejemplo.com/video.mp4">
</div>

<div id="formatoVideo" style="display: <?php echo ($noticia['tipo'] === 'Video') ? 'block' : 'none'; ?>">
    <label for="formatoVideoInput">Formato del Video (para tipo Video):</label>
    <select name="formatoVideoInput">
        <option value="mp4" <?php echo ($noticia['formato'] === 'mp4') ? 'selected' : ''; ?>>MP4</option>
        <option value="avi" <?php echo ($noticia['formato'] === 'avi') ? 'selected' : ''; ?>>AVI</option>
        <option value="mpg" <?php echo ($noticia['formato'] === 'mpg') ? 'selected' : ''; ?>>MPG</option>
        <option value="ogg" <?php echo ($noticia['formato'] === 'ogg') ? 'selected' : ''; ?>>OGG</option>
    </select>
</div>

<label for="perfil">Perfil:</label>
<select name="perfil" required>
    <option value="Todos" <?php echo ($noticia['perfil'] === 'Todos') ? 'selected' : ''; ?>>Todos</option>
    <option value="Alumno" <?php echo ($noticia['perfil'] === 'Alumno') ? 'selected' : ''; ?>>Alumno</option>
    <option value="Profesor" <?php echo ($noticia['perfil'] === 'Profesor') ? 'selected' : ''; ?>>Profesor</option>
</select>

<button type="submit">Guardar Cambios</button>
</form>

</body>
</html>