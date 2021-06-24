<html>
  <head>
    <!--definds -->
    <meta charset="UTF-8">

    <!--
      <link rel="stylesheet" href="startStudent_style_dark.css">
      <link rel="stylesheet" href="startStudent_style_white.css">
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
      $type = $_GET['type'];
    ?>


    <header>
      <center>
        <form method="post">
          <input type="submit" name="Menu" value="Menu"/>
          <input type="submit" name="Mon" value="Monday"/>
          <input type="submit" name="Tue" value="Tuesday"/>
          <input type="submit" name="Wed" value="Wednesday"/>
          <input type="submit" name="Thur" value="Thursday"/>
          <input type="submit" name="Fri" value="Friday"/>
        </form>
      </center>

    </header>

    <div>
      <center>
        <table>
          <?php
            if(array_key_exists('Mon', $_POST)) {
              button1($type);
            }
            else if(array_key_exists('Tue', $_POST)) {
              button2($type);
            }
            else if(array_key_exists('Wed', $_POST)) {
              button3($type);
            }
            else if(array_key_exists('Thur', $_POST)) {
              button4($type);
            }
            else if(array_key_exists('Fri', $_POST)) {
              button5($type);
            }
            else{
              load(date("N"),$type);
            }

            function button1($type) {
              load(1,$type);
            }
            function button2($type) {
              load(2,$type);
            }
            function button3($type) {
              load(3,$type);
            }
            function button4($type) {
              load(4,$type);
            }
            function button5($type) {
              load(5,$type);
            }

            function load($day,$type) {
              //userid
              $id = 2;//$_COOKIE['id'];

              //creates connection to database
              $connection = new mysqli('localhost', 'root', '', 'kursplaner');

              for($i=1;$i<6;$i++){

                //get kid where timeslot is = i and which are taken by the student
                $sql = "SELECT KID FROM takesPlace as tp natural join appointment as ap natural join (SELECT KID FROM take WHERE UID=$id) as t WHERE ap.day= $day AND ap.timeslot = $i";

                //
                $result = $connection->query($sql);

                if (!$result) {
                  echo '<tr id="'.$i.'"><th>Free time!</th></tr>';
                }else{
                  //
                  $datensatz = $result->fetch_assoc();

                  //get Id of the class
                  $kid = $datensatz['KID'];

                  //new sql comand to get the subject and kürzel of the termin
                  $sql1 = "SELECT KID,subject, token FROM class WHERE KID=$kid;";

                  //
                  $result1 = $connection->query($sql1);

                  if (!$result1) {
                    echo '<tr id="'.$i.'"><th>Free time!</th></tr>';
                  }else{
                    $datensatz1 = $result1->fetch_assoc();
                    //Create new <tr> tag with subject name in it
                    echo '<tr><th><a href=class.php?id='.$datensatz1['KID'].'&type='.$type.'>'.$datensatz1['subject'].'</a>'.'</br>'.$datensatz1['token'].'</th></tr>';
                  }
                }
              }
              $connection->close();
            }
          ?>
        </table>
      </center>
    </div>

  </body>
</html>
