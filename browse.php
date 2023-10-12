<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Explorar Carpeta</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
   
</head>
<body>
<div class="container">
    <h2>Explorar Carpeta</h2>
    <hr>
    <?php
    $dir = $_GET['dir'] ?? 'files/';

    // Eliminar archivo o carpeta
    if (isset($_GET['delete'])) {
        $file = $_GET['delete'];
        if (is_file($file)) {
            unlink($file);
        } else {
            deleteDir($file);
        }
    }

    function deleteDir($dirPath) {
        if (!is_dir($dirPath)) {
            return;
        }
        if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
            $dirPath .= '/';
        }
        $files = glob($dirPath . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (is_dir($file)) {
                deleteDir($file);
            } else {
                unlink($file);
            }
        }
        rmdir($dirPath);
    }

    // Obtener lista de archivos y carpetas
    $files = glob($dir . '*');
    foreach ($files as $file) {
        $name = basename($file);
        $size = is_file($file) ? filesize($file) : '';
        $type = is_file($file) ? 'Archivo' : 'Carpeta';
        $created = date('Y-m-d H:i:s', filectime($file));
        $modified = date('Y-m-d H:i:s', filemtime($file));

        echo '<div class="card container">';
        echo '<div class="card-body">';
        echo '<h5 class="card-title">' . $name . '</h5>';
        echo '<p class="card-text">Tipo: ' . $type . '</p>';
        echo '<p class="card-text">Tamaño: ' . $size . ' bytes</p>';
        echo '<p class="card-text">Creado: ' . $created . '</p>';
        echo '<p class="card-text">Modificado: ' . $modified . '</p>';
        if (is_file($file)) {
            echo '<a href="edit.php?file=' . $file . '" class="btn btn-primary">Editar</a>';
            echo '<a href="view.php?file=' . $file . '" class="btn btn-secondary">Ver</a>';
            echo '<a href="browse.php?dir=' . $file . '" class="btn btn-primary">Abrir</a>';
        } else {
            echo '<a href="create.php?dir=' . $file . '" class="btn btn-success">Crear</a>';
        }
        echo '<a href="browse.php?delete=' . $file . '" class="btn btn-danger">Eliminar</a>';
        echo '</div>';
        echo '</div>';
    }
    ?>
    <hr>
    <a href="index.php" class="btn btn-primary">Volver</a>
</div>
</body>
</html>

