<html>
  <head>
    <!--definds -->
    <meta charset="UTF-8">

    <!---->
    <link rel="stylesheet" href="startAdmin_style.css">

    <title>home</title>
  </head>
  <body>
    <?php
      if(array_key_exists('button1', $_POST)) {
        insert();
      }
    ?>

    <form method="post">

      <?php
        function insert(){

        }
      ?>
      <input type="submit" value="do it" name="button1"/><br/>
    </form>
  </body>
</html>
