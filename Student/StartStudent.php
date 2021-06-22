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

    <!--if user is not registerd he gets back to login.php & get date-->
    <?php
      //setcookie('name','wert'(var),'Existensberechtigung'(int))
      /*
      if(!isset($_COOKIE['login'])){                           //möglicher Fehler
        if (isset($_COOKIE['typ']) {
          setcookie("typ", "", time() - 3600);
        }
        include 'login.php';
      }
      */

      $day = date("N");
    ?>


    <header>
      <button type="button" id="Menu"></button>
      <button type="button" id="Mon" onclick=<?php $day=1?>>Monday</button>
      <button type="button" id="Tue" onclick=<?php $day=1?>>Tuesday</button>
      <button type="button" id="Wed" onclick=<?php $day=1?>>Wednesday</button>
      <button type="button" id="Thur" onclick=<?php $day=1?>>Thursday</button>
      <button type="button" id="Fri" onclick=<?php $day=1?>>Friday</button>
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

          //sql command: you get all classes of the user for one day ordered by the time it starts
          $sql = 'SELECT KID FROM takesPlace as tp natural join appointment as ap natural join (SELECT KID FROM take WHERE UID=2) as t WHERE day= 1 ORDER BY timeslot';//"SELECT KID FROM takesPlace natural join appointment WHERE day= $day AND KID=(SELECT KID FROM take WHERE UID=$id) ORDER BY timeslot;";

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

              for($i=0;$i<7;$i++){
                //get Id of the class
                $kid = $datensatz['KID'];

                //new sql comand to get the subject and kürzel of the termin
                $sql1 = "SELECT subject, token FROM class WHERE KID=$kid;";

                //new result
                $result1 = $connection->query($sql1);

                //new datensatz
                $datensatz1 = $result->fetch_assoc();

                //if there is no subject for one timeslot
                //if($i==1 and ){

                //}
                  //Create new <tr> tag with subject name in it
                  echo '<tr id="'.$i.'"><th>'.$datensatz1['subject'].'</br>'.$datensatz1['token'].'</th></tr>';

              }
            }
            $connection->close();
          }
        ?>
      </table>
    </div>

  </body>
</html>
