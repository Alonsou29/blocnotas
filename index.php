<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bloc de Notas</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
   
    <style>
      .container{
        background-color: whitesmoke;
        border-radius: 10px;
      }

      
      .container-fluid{
        background-color: darkcyan;
        border-radius: 5px;
        text-decoration: none;
      }

      .navbar-collapse{
        background-color: darkcyan;
        text-decoration: none;
      }

      h5{
        border-radius: 50px;
        
      }

      .type{
        background-color: teal;
      }

    </style>
</head>
<body>
<div class= container>
  <nav id="bloc" class="navbar navbar-expand-lg bg-primary">
    <div class="container-fluid">
      <a class="navbar-brand text-light" href="index.php">Bloc de Notas</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="#index.php"><b>Inicio</b></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#directorio"><b>Directorio</b></a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</div>


<div class="container">
  <br>
  <h5 class= "p-3 mb-2 bg-secondary text-white">Crear Archivos o Carpetas</h5>
  <br>
    <form method="post" action="index.php">
    <div class="form-group">
        <label for="type"><b>Tipo:</b></label>
        <select class="form-control" id="type" name="type">
          <option value="file">Archivo</option>
          <option value="folder">Carpeta</option>
        </select>
      </div>
      <br>
      <div  class="form-group">
        <label for="name"><b>Nombre:</b></label>
        <input type="text" class="form-control" id="name" name="name" required>
      </div>
      <br>
      <div class="mb-3" id="content-group">
        <label class="form-label"><b>Escribe tu nota:</b></label>
        <textarea class="form-control" id="content" name="content" rows="3"></textarea>
      </div>
      <button type="submit" name="create" class="btn btn-primary">Crear</button>
    </form>
  </div>
  <br>
  <hr>


  <h5 id="directorio" class="container p-3 mb-2 bg-secondary text-white">Directorio</h5>
  <br>

  <?php
    $dir = 'Archivos/';

    // Crear archivo o carpeta
    if (isset($_POST['create'])) {
      $name = $_POST['name'];
      $type = $_POST['type'];

      if ($type == 'file') {
        $fileContent = $_POST['content'] ?? '';
        $fileTitle = $_POST['title'] ?? '';
        $filePath = $dir . '/' . $name . '.txt'; // Agregar la extensión ".txt"
        $fileData = "Título: $fileTitle\n\n$fileContent";
        file_put_contents($filePath, $fileData);
      } elseif ($type == 'folder') {
        $folderPath = $dir . '/' . $name;
        mkdir($folderPath); // Crea una nueva carpeta
      }
    }

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
      echo '<a href="index.php?delete=' . $file . '" class="btn btn-danger">Eliminar</a>';
      if (is_file($file)) {
        echo '<a href="edit.php?file=' . $file . '" class="btn btn-primary">Editar</a>';
        echo '<a href="view.php?file=' . $file . '" class="btn btn-secondary">Ver</a>';
      } else {
        echo '<a href="browse.php?dir=' . $file . '" class="btn btn-primary">Abrir</a>';
        echo '<a href="create.php?dir=' . $file . '" class="btn btn-success">Crear</a>';
      }
      echo '</div>';
      echo '</div>';
    }
    ?>
    <br>

    <div class="container">
      <a href="#bloc" class="btn btn-primary">Volver</a>
    </div>
    <br>



  <script>
    document.getElementById('type').addEventListener('change', function() {
      var contentGroup = document.getElementById('content-group');
      if (this.value === 'file') {
        contentGroup.style.display = 'block';
      } else {
        contentGroup.style.display = 'none';
      }
    });
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>
