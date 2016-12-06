<html>
  <?php
    require('head.php');
  ?>
  <body>
    <?php
      require('header.php');
      $vars = $_GET ? sanitize($_GET) : sanitize($_POST);
      #echo json_encode($vars);
      doAction( $vars );
      require('footer.php');
    ?>
  </body>
</html>
