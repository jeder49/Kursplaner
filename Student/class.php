<html>
  <head>
    <!--definds -->
    <meta charset="UTF-8">

    <!---->
    <link rel="stylesheet" href="class_style.css">

    <title>home</title>
  </head>
  <body>
    <header>
      <center>
        <h1>
          <?php
            $name = $_GET["name"];
            echo $name;
          ?>
        </h1>
      </center>
    </header>
    <div>
      <table>
        <?php
          echo $name;
        ?>
      </table>
    </div>
  </body>
</html>
