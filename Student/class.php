<html>
  <head>
    <!--definds -->
    <meta charset="UTF-8">

    <!--
      <link rel="stylesheet" href="class_style_dark.css">
      <link rel="stylesheet" href="class_style_white.css">
    -->
    <title>
      <?php
        $type = $_GET['type'];

        //gets Id by former page
        $id = $_GET["id"];

        //get data about the class
        $sql = "SELECT token,homework,TID,SID,subject FROM class WHERE KID=$id;";

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
        if($type == "studentRepresentetive"){
          echo '<a href=editMode.php?id='.$id.'&type='.$type.'>edit</a>';
        }
      ?>
    </header>
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
                $sql2 = "SELECT date,topic FROM exam WHERE KID=$id;";
                $result2 = $connection->query($sql2);
                if($result2!=false){

                  while ($datensatz2 = $result2->fetch_assoc()) {

                    $now = time();


                    $exam_date = $datensatz2['date'];


                    $datediff = $now - $exam_date;

                    if($datediff <= 3){
                      echo '<p style="color:#ff0000;">'.$datensatz2['date'].'</p>';
                    }else if($datediff <= 7){
                      echo '<p style="color:#FFB500;">'.$datensatz2['date'].'</p>';
                    }else{
                      echo '<p style="color:#00FF16;">'.$datensatz2['date'].'</p>';
                    }
                    echo $datensatz2['topic'];
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
                  echo $datensatz['homework'];
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
                $sql3 = "SELECT nickname,username FROM user as u right join (SELECT UID FROM take WHERE KID=$id) as a on u.UID=a.UID;";
                $result3 = $connection->query($sql3);
                if($result3!=false){
                  while ($datensatz3 = $result3->fetch_assoc()) {
                    echo $datensatz3['nickname'].' AKA '.$datensatz3['username'].'</br>';
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

  </body>
</html>
