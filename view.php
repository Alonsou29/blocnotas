
<!DOCTYPE html>
<html>
<head>
  <title>Nota</title>
  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
   
</head>
<body>
  <div class="container">
    <?php
    if (isset($_GET['file'])) {
      $file = $_GET['file'];
      if (is_file($file)) {
        $content = file_get_contents($file);
        echo '<h2>Nota</h2>';
        echo '<hr>';
        echo '<form method="post" action="view.php">';
        echo '<div class="form-group">';
        echo '<textarea class="form-control" id="content" name="content" rows="10">' . htmlspecialchars($content) . '</textarea>';
        echo '</div>';
        echo '<input type="hidden" name="file" value="' . $file . '">';
        echo '<a href="index.php" class="btn btn-primary">Volver</a>';
        echo '</form>';
      }
    }
    ?>
  </div>
</body>
</html>

