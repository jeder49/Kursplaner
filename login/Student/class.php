<html>
  <?php
    if(isset($_COOKIE['id'])){

      //get user id from cookie
      $id = $_COOKIE['id'];

      //get user ip so that permision is granted to the right pc
      $ip = $_SERVER['REMOTE_ADDR'];

      //gets all token with the owner with the id
      $sql0 = "SELECT ToID,IP,dateTime FROM online natural join token WHERE UID = $id;";

      //creates connection to database
      $connection = new mysqli('localhost', 'root', '', 'Kursplaner');

      //get result of sql comand
      $result0 = $connection->query($sql0);

      //if the commant produces no mistake
      if($result0!=false){

        //looks if one of the token is over time and if yes it delets it
        while ($datensatz0 = $result0->fetch_assoc()) {

          //get datetime
          $date = date('Y-m-d h:i:s', time());

          //if the date of the token is in the past
          if($datensatz0['dateTime'] < $date){
              //delets all entries in online that have a out of time token
              $sql01 = 'DELETE FROM online WHERE ToID ='.$datensatz0['ToID'].';';

              //sents sql comant to database
              $connection->query($sql01);

              //delets all entries in online that have a out of time token
              $sql02 = 'DELETE FROM token WHERE ToID ='.$datensatz0['ToID'].';';

              //sents sql comant to database
              $connection->query($sql02);
          }

        }

      }else{

        //sent you to hell
        header('Location: /Kursplaner/login/MagicWord.html');

      }

      //looks if there is token with the ip
      $sql0 = "SELECT ToID,count(UID) FROM online as o natural join (SELECT ToID FROM token WHERE IP = '$ip') as t WHERE UID = $id;";

      //get result of sql comand
      $result0 = $connection->query($sql0);

      //stors the number of
      $datensatz0 = $result0->fetch_assoc();

      //if there are no token for this pc and user combination
      if($datensatz0['count(UID)'] == 0){

        //close conection to Database
        $connection->close();

        //sent you to hell
        header('Location: /Kursplaner/login/MagicWord.html');

      }else{
        $kid = $_GET["kid"];

        //get data about the class
        $sql03 = "SELECT token FROM class WHERE KID=$kid;";

        //gets the result of the Database for the sql comand
        $result03 = $connection->query($sql03);

        //
        $datensatz03 = $result03->fetch_assoc();

        // change "looksAt" attribut in "token" to token of class
        $sql04 = 'UPDATE token SET looksAt= "'.$datensatz03['token'].'" WHERE ToID ='.$datensatz0['ToID'].';';

        //sents sql comant to database
        $connection->query($sql04);

        //close conection to Database
        $connection->close();

      }
    }else {

      //sent you to hell
      header('Location: /Kursplaner/login/MagicWord.html');

    }

    function logout (){
      //get user id from cookie
      $id = $_COOKIE['id'];

      //get user ip so that permision is granted to the right pc
      $ip = $_SERVER['REMOTE_ADDR'];

      //creates connection to database
      $connection = new mysqli('localhost', 'root', '', 'kursplaner');

      //looks if there is token with the ip
      $sql0 = "SELECT ToID FROM online as o natural join (SELECT ToID FROM token WHERE IP = '$ip') as t WHERE UID = $id;";

      //get result of sql comand
      $result0 = $connection->query($sql0);

      //stors the number of
      $datensatz0 = $result0->fetch_assoc();

      //delets all entries in "online" that have a out of time token
      $sql05 = 'DELETE FROM online WHERE ToID ='.$datensatz0['ToID'].';';

      //sents sql comant to database
      $connection->query($sql05);

      //delets all entries in "online" that have a out of time token
      $sql06 = 'DELETE FROM token WHERE ToID ='.$datensatz0['ToID'].';';

      //sents sql comant to database
      $connection->query($sql06);

      //close conection to Database
      $connection->close();
    }

    if(array_key_exists('logout', $_POST)) {
      logout();
      header('Location: /Kursplaner/login/login.php');
    }

  ?>
  <head>
    <!--definds -->
    <meta charset="UTF-8">

    <!--
      <link rel="stylesheet" href="class_style_dark.css">-->
      <link rel="stylesheet" href="class_style_white.css">

    <title>
      <?php

        //gets Id by former page
        $id = $_COOKIE['id'];
        $kid = $_GET["kid"];

        //get data about the class
        $sql = "SELECT token,TID,subject FROM class WHERE KID=$kid;";

        //creates connection to database
        $connection = new mysqli('localhost', 'root', '', 'Kursplaner');

        //gets the result of the DB for the sql comand
        $result = $connection->query($sql);

        //
        $datensatz = $result->fetch_assoc();

        echo $datensatz['token'];
      ?>
    </title>
  </head>
  <body>
    <header>
      <nav class= "navbar">
        <div class="A">
          <a onclick="openSlideMenu()">
            <div class="side open-slide">
              <div class="b"></div>
              <div class="b"></div>
              <div class="b"></div>
            </div>
          </a>
        </div>
      </nav>

      <center>

        <h1>

          <!--makes contact to the DB and prints out subjectname-->
          <?php
            echo $datensatz['subject'];
          ?>
        </h1>
        </br>

        <!--prints out the token of the class and the teacher-->
        <?php
          $tid=$datensatz['TID'];
          $sql1 = "SELECT token FROM teacher WHERE UID=$tid;";
          $result1 = $connection->query($sql1);
          if($result1!=false){
            $datensatz1 = $result1->fetch_assoc();
            echo $datensatz['token'].' - '.$datensatz1['token'];
          }else{
            echo 'strange! this class seams to have no teacher?! But who cares.';
          }
        ?>

      </center>
      <?php
        $sql2 = "SELECT count(UID) FROM represent WHERE UID=$id AND KID=$kid;";
        $result2 = $connection->query($sql2);
        if($result2!=false){
          $datensatz2 = $result2->fetch_assoc();
          if($datensatz2['count(UID)'] != 0){
              echo '<button onclick=window.location.href="editMode.php?id='.$id.'&kid='.$kid.'">edit</button>';
          }
        }
      ?>
    </header>

    <div id="side-menu" class="side-nav">
			<a href="#" class="btn-close" onclick="closeSlideMenu()">&times;</a>
      <?php
        $id= $_GET['id'];
        echo "<a  class='hover' href='startStudent.php?id=$id'>Menu</a>";
			  echo "<a  class='hover' href='exams.php?id=$id'>exams</a>";
        echo "<a  class='hover' href='classes.php?id=$id'>classes</a>";
        echo "<a  class='hover' href='setting.php?id=$id'>settings</a>";
      ?>
      <form method="post">
        <input type="submit" name="logout" class='hover' value="log out" />
      </form>
    </div>

    <div>
      <center>
        <table>
          <!--title exam-->
          <tr>
            <th>
              EXAM:
            </th>
          </tr>

          <!--get exam-->
          <tr>
            <td>
              <?php
                $tid=$datensatz['TID'];
                $sql3 = "SELECT date,topic FROM exam WHERE KID=$kid;";
                $result3 = $connection->query($sql3);
                if($result3!=false){

                  while ($datensatz3 = $result3->fetch_assoc()) {

                    $now = time();


                    $exam_date = $datensatz3['date'];


                    $datediff = $now - $exam_date;

                    if($datediff <= 3){
                      echo '<p style="color:#ff0000;">'.$datensatz3['date'].'</p>';
                    }else if($datediff <= 7){
                      echo '<p style="color:#FFB500;">'.$datensatz3['date'].'</p>';
                    }else{
                      echo '<p>'.$datensatz3['date'].'</p>';
                    }
                    echo $datensatz3['topic'];
                  }

                }else{
                  echo 'no exams?! you are a lucky boy/girl!';
                }
                ?>
              </td>
            </tr>

            <!--title homework-->
            <tr>
              <th>
                HOMEWORK:
              </th>
            </tr>

            <!--get homework-->
            <tr>
              <td>
                <?php
                  $sql4 = "SELECT discription FROM homework WHERE KID=$kid;";
                  $result4 = $connection->query($sql4);
                  if($result4!=false){
                    while ($datensatz4 = $result4->fetch_assoc()) {
                      echo $datensatz4['discription'].'</br>';
                    }
                  }
                ?>
              </td>
            </tr>

            <!--title classmates-->
            <tr>
              <th>
                CLASSMATES:
              </th>
            </tr>

            <!--get classmates-->
            <tr>
              <td>
                <?php
                $sql5 = "SELECT nickname,username FROM user as u right join (SELECT UID FROM take WHERE KID=$kid) as a on u.UID=a.UID;";
                $result5 = $connection->query($sql5);
                if($result5!=false){
                  while ($datensatz5 = $result5->fetch_assoc()) {
                    echo $datensatz5['nickname'].' AKA '.$datensatz5['username'].'</br>';
                  }
                }else{
                  echo 'It seams like you are alone in this class! Feel already lonely?';
                }
                ?>
              </td>
            </tr>

        </table>
      </center>
    </div>

    <?php
      //close connection to DB
      $connection->close();
    ?>
    <script>
			function openSlideMenu(){
				document.getElementById('side-menu').style.width= '250px';
				document.getElementById('side-menu').style.marginLeft= '0';
			  }
        function closeSlideMenu(){
        document.getElementById('side-menu').style.width= '0';
        document.getElementById('side-menu').style.marginLeft= '0';
        }
    </script>
  </body>
</html>
