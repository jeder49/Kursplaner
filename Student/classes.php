  <html>
    <head>
      <!--definds -->
      <meta charset="UTF-8">

      <!--
        <link rel="stylesheet" href="classes_style_dark.css">
        <link rel="stylesheet" href="classes_style_white.css">
      -->
      <title>classes</title>
    </head>
    <body>

        <!--sortieren nach...-->


      <header>
        <center>
          <h1>
            Classes:
          </h1>
        </center>
      </header>

      <div>
        <center>
          <table id="classes">
            <?php
              $id = $_GET['id'];

              $sql = "SELECT KID,token,subject FROM class natural join (SELECT KID FROM take WHERE UID=$id) as t;";

              //creates connection to database
              $connection = new mysqli('localhost', 'root', '', 'kursplaner');

              //gets the result of the DB for the sql comand
              $result = $connection->query($sql);

              while ($datensatz = $result->fetch_assoc()) {

                //
                echo '<tr><th><a href=class.php?id='.$datensatz['KID'].'>'.$datensatz['subject'].'</a>'.'</br>'.$datensatz['token'].'</th></tr>';

              }
              $connection->close();
            ?>
          </table>
        </center>
      </div>

    </body>
  </html>
