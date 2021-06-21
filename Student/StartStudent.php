<html>
  <head>
    <!--definds -->
    <meta charset="UTF-8">

    <!--
    <link rel="stylesheet" href="startStudent_style.css">
    -->
    <title>home</title>
  </head>

  <body>

    <!--if user is not registerd he gets back to login.php-->
    <!--
      //setcookie('name','wert'(var),'Existensberechtigung'(int))
      if(!isset($_COOKIE['login'])){                           //möglicher Fehler
        if (isset($_COOKIE['typ']) {
          setcookie("typ", "", time() - 3600);
        }
        include 'login.php';
      }
    -->

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
      //if('day'==null){
          var d = new Date();
          var n = d.getDay();
          if(n>5){
            n=1;
          }
          document.cookie = "day="+n;       //delete cookie after time
        //}

        function clicked(day){
          document.cookie = "day="+day;
          window.location.reload();
        }
      </script>

    </header>

    <div>
      <table>
        <?php
          //userid
          $id = 2;//$_COOKIE['id'];

          //gets the day by the cookie
          $day= $_COOKIE['day'];

          //echo "day: "+$day;

          //sql command: you get all classes of the user for one day ordered by the time it starts
          $sql = "SELECT KID FROM takesPlace natural join appointment WHERE day= $day AND KID=(SELECT KID FROM take WHERE UID=$id) ORDER BY timeslot;";  //möglicher Anführungszeichen Fehler!

          //creates connection to database
          $connection = new mysqli('localhost', 'root', '', 'kursplaner');

          //gets the result of the DB for the sql comand
          $result = $connection->query($sql);

          //if there is no data in the database for that day or the cookie for the day does not exists
          if(null == isset($_COOKIE['day']) || $result==false){
            echo 'Sorry, there is a problem and I am too lazy to program some thing!';
          } else {
            if (!$result) {
				          exit("Fehler: <br/>".$connection->error);
            }else{

              while ($datensatz = $result->fetch_assoc()) {
                echo $datensatz['KID'];
              }
              //print_r($datensatz);

              for($i=0;$i<5;$i++){
                //get Id of the class
                $kid = $datensatz['KID'][$i];

                //new sql comand to get the subject and kürzel of the termin
                $sql1 = "SELECT subject, token FROM class WHERE KID="+$kid+";";

                //new result
                $result1 = $connection->query($sql1);

                //new datensatz
                $datensatz1 = $result->fetch_assoc();

                //Create new document with specified version number
                $dom = new DOMDocument('1.0');

                //Create new <tr> tag with subject name in it
                $th = $dom->createElement('th',$datensatz1['subject'][$i]);

                //Add the <tr> tag to document
                $dom->appendChild($th);
              }
            }
            $connection->close();
          }
        ?>
      </table>
    </div>

  </body>
</html>
