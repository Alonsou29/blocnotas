<?php
if (isset($_POST['save'])) {
  $file = $_POST['file'];
  $content = $_POST['content'];
  file_put_contents($file, $content);
  header('Location: index.php');
}
?>
