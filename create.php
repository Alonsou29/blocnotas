<?php
$dir = $_GET['dir'] ?? 'files/';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $type = $_POST['type'];

    if ($type == 'file') {
        $fileContent = $_POST['content'] ?? '';
        $fileTitle = $_POST['title'] ?? '';
        $filePath = $dir . '/' . $name . '.txt'; // Agregar la extensión ".txt"
        $fileData = "Título: $fileTitle\n\n$fileContent";
        file_put_contents($filePath, $fileData);
    } elseif ($type == 'folder') {
        $folderPath = $dir . $name;
        mkdir($folderPath);
    }

    header('Location: browse.php?dir=' . $dir);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Archivo o Carpeta</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>
<body>
  <br>
    <h4 class="container">Crear nuevo archivo o carpeta en: <?php echo $dir; ?></h4>
    <br>
    <form class="container" method="post" action="create.php?dir=<?php echo $dir; ?>">
      <div class="form-group">
        <label for="name">Nombre:</label>
        <input type="text" class="form-control" id="name" name="name" required>
      </div>
      <div class="form-group">
        <label for="type">Tipo:</label>
        <select class="form-control" id="type" name="type">
          <option value="file">Archivo</option>
          <option value="folder">Carpeta</option>
        </select>
      </div>
      <div class="mb-3" id="content-group">
        <label class="form-label">Escribe tu nota</label>
        <textarea class="form-control" id="content" name="content" rows="3"></textarea>
      </div>
      <button type="submit" name="create" class="btn btn-primary">Crear</button>
    </form>

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



   






<?php
/*
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $filename = $_POST["filename"];
    $filePath = "./files/" . $filename . ".txt"; // Ruta del archivo a crear
    $fileContent = ""; // Contenido inicial del archivo (vacío)

    // Verificar si el directorio existe, si no, crearlo
    $directory = dirname($filePath);
    if (!is_dir($directory)) {
        mkdir($directory, 0777, true);
    }

    $file = fopen($filePath, "w");
    if ($file) {
        fwrite($file, $fileContent);
        fclose($file);

        header("Location: index.php");
        exit;
    } else {
        echo "Error al crear el archivo.";
    }
}

*/
?>
