<?php
  $html = '
  <html>
    <head>
      <!--definds -->
      <meta charset="UTF-8">

      <!--
      <link rel="stylesheet" href="class_style.css">
      -->
      <title>classes</title>
    </head>
    <body>

        <!--sortieren nach...-->



        <center>
          <h1>
            Classes:
          </h1>
        </center>


      <div>
        <center>
          <table id="classes">
          </table>
        </center>
      </div>

    </body>
  </html>
  ';
  $id = 2;//$_COOKIE['id'];

  $sql = "SELECT token,subject FROM class natural join (SELECT KID FROM take WHERE UID=$id) as t;";

  //creates connection to database
  $connection = new mysqli('localhost', 'root', '', 'kursplaner');

  //gets the result of the DB for the sql comand
  $result = $connection->query($sql);

  while ($datensatz = $result->fetch_assoc()) {

    //Create new document with specified version number
    $doc = new DOMDocument();

    //
    $doc->loadHTML($html);

    //
    $descBox = $doc->getElementById('classes');

    //
    $subject = 'echo "<a href=class.php?name='.$datensatz['subject'].'>'.$datensatz['subject'].'</a>'.'</br>'.$datensatz['token'].'</br>"';

    //Create new <tr> tag with subject name in it
    $th = $doc->createElement('th', $subject);

    //Add the <tr> tag to document
    $descBox->appendChild($th);

    echo $doc->saveHTML();
  }
?>
