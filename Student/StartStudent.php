<html>
  <head>
    <!--definds -->
    <meta charset="UTF-8">

    <!---->
    <link rel="stylesheet" href="startStudent_style.css">

    <title>home</title>
  </head>

  <body>

    <!--if user is not registerd he gets back to login.php-->
    <?php
      //setcookie('name','wert'(var),'Existensberechtigung'(int))
      if(!isset($_COOKIE['login'])){                           //möglicher Fehler
        if (isset($_COOKIE['typ']) {
          setcookie("typ", "", time() - 3600);
        }
        include 'login.php';
      }
    ?>

    <header>
      <button type="button" id="Menu"></button>
      <button type="button" id="Mo" onclick=clicked(1)></button>
      <button type="button" id="Di" onclick=clicked(2)></button>
      <button type="button" id="Mi" onclick=clicked(3)></button>
      <button type="button" id="Do" onclick=clicked(4)></button>
      <button type="button" id="Fr" onclick=clicked(5)></button>
      <button type="button" id=""></button>

      <!--gets the default date and the input of the button-->
      <script>
        var d = new Date();
        var n = d.getDay();
        if(n>5){
          n=1;
        }
        document.cookie = "day="+n;

        function clicked(day){
          document.cookie = "day="+day;
        }
      </script>

    </header>

    <div>
      <table>
        <?php
          //userid
          $id = $_COOKIE['id'];

          //gets the day by the cookie
          $day= $_COOKIE['day'];

          //sql command: you get all classes of the user for one day ordered by the time it starts
          $sql = "SELECT KID FROM termin WHERE Tag= $day AND KID=(SELECT KID FROM belegt WHERE UID=$id) ORDER BY Zeitslot;";  //möglicher Anführungszeichen Fehler!

          //creates connection to database
          $connection = new mysqli('localhost', 'root', '', 'Kursplaner');

          //gets the result of the DB for the sql comand
          $result = $connection->query($sql);

          //if there is no data in the database for that day or the cookie for the day does not exists
          if(!isset($_COOKIE['day'] || $result=false){
            echo 'Sorry, there is a problem and I am too lazy to program some thing!';
          } else {

            $datensatz = $result->fetch_assoc()

            for(int i=0;i<5;i++){
              //get Id of the class
              $kid = $datensatz['KID'][0];

              //new sql comand to get the subject and kürzel of the termin
              $sql1 = "SELECT Fach, Kuerzel FROM kurs WHERE KID="+$kid+";";

              //new result
              $result1 = $connection->query($sql1);

              //new datensatz
              $datensatz1 = $result->fetch_assoc();

              //Create new <tr> tag with subject name in it
              $th = $dom->createElement('th',$datensatz1['Fach']);

              //Add the <tr> tag to document
              $dom->appendChild($th);
            }

          }
        ?>
      </table>
    </div>

  </body>
</html>
