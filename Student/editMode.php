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
        $sql = "SELECT token,homework,TID,subject FROM class WHERE KID=$id;";

        //creates connection to database
        $connection = new mysqli('localhost', 'root', '', 'Kursplaner');

        //gets the result of the DB for the sql comand
        $result = $connection->query($sql);

        //
        $datensatz = $result->fetch_assoc();

        echo $datensatz['token'];
      ?>
      - editMode
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
        echo '<button onclick=window.location.href="class.php?id='.$id.'&type='.$type.'">edit</button>';
      ?>
    </header>
    <div>
      <center>
        <table>
          <!--title exam-->
          <tr>
            <th>
              EXAM:
              <?php
                echo '<a href=insert.php?table=exam>insert</a>';
              ?>
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
                  $i=1;
                  while ($datensatz2 = $result2->fetch_assoc()) {

                    $now = time();

                    $exam_date = $datensatz2['date'];


                    $datediff = $now - $exam_date;

                    if($datediff <= 3){
                      echo '<div><p style="color:#ff0000;">'.$datensatz2['date'].'<button onclick=window.location.href="delete.php?table=exam&id='.$i.'&KID='.$id.'">delete</button></p>';
                    }else if($datediff <= 7){
                      echo '<div><p style="color:#FFB500;">'.$datensatz2['date'].'<button onclick=window.location.href="delete.php?table=exam&id='.$i.'&KID='.$id.'">delete</button></p>';
                    }else{
                      echo '<div><p>'.$datensatz2['date'].'<button onclick=window.location.href="delete.php?table=exam&id='.$i.'&KID='.$id.'">delete</button></p>';
                    }
                    echo $datensatz2['topic'].'</div>';

                    $i++;
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
                <?php
                  echo '<a href=insert.php?table=homework>insert</a>';
                ?>
              </th>
            </tr>

            <!--get homework-->
            <tr>
              <td>
                <?php
                  $hid=$datensatz['homework'];
                  $sql3 = "SELECT discription FROM homework WHERE HID=$hid;";
                  $result3 = $connection->query($sql3);
                  if($result3!=false){

                    while ($datensatz3 = $result3->fetch_assoc()) {
                      echo $datensatz3['discription'].'<button onclick=window.location.href="delete.php?table=homework&id=0&KID='.$id.'">delete</button>';
                    }
                  }
                ?>
              </td>
            </tr>

            <!--title classmates-->
            <tr>
              <th>
                CLASSMATES:
                <?php
                  echo '<a href=insert.php?table=take>insert</a>';
                ?>
              </th>
            </tr>

            <!--get classmates (more like: get frinds xD)-->
            <tr>
              <td>
                <?php
                $sql3 = "SELECT u.UID,nickname,username FROM user as u right join (SELECT UID FROM take WHERE KID=$id) as a on u.UID=a.UID;";
                $result3 = $connection->query($sql3);
                if($result3!=false){
                  while ($datensatz3 = $result3->fetch_assoc()) {
                    echo $datensatz3['nickname'].' AKA '.$datensatz3['username'].'<button onclick=window.location.href="delete.php?table=mates&id='.$datensatz3['UID'].'&KID='.$id.'">delete</button></br>';
                  }
                }else{
                  echo '(DB error)It seams like you are alone in this class! Feel already lonely?';
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
