<!--parameter: table, KID-->
<html>
  <head>
    <!--definds -->
    <meta charset="UTF-8">

    <!--
    <link rel="stylesheet" href="startAdmin_style.css">
    -->
    <title>
      <?php
        $table = $_GET['table'];
        $kid = $_GET['kid'];
        echo $table.' - add';
      ?>
    </title>
  </head>
  <body>
    <form method="post">
      <input type="submit" value="X" name="exit"/><br/>
    </form>
    <form method="post">
      <?php
        if($table == 'exam'){
          echo "new Exam: </br>";
          echo '<input type="text" name="date" placeholder="date"/>';
          echo '<input type="text" name="topic" placeholder="toic"/>';
        }
        elseif ($table=='homework') {
          echo "new homework: </br>";
          echo '<input type="text" name="discription" placeholder="discription"/>';
        }
        elseif ($table=='mates') {
          echo "new class mate: </br>";
          echo '<input type="text" name="name" placeholder="name"/>';
        }

      ?>
      <input type="submit" value="do it" name="button1"/><br/>
    </form>

    <?php
      //if button is pressed
      if(array_key_exists('button1', $_POST)) {
        insert();
      }
      //if button is pressed
      if(array_key_exists('exit', $_POST)) {
        leaf();
      }
      //called when button is pressed
      function insert(){
        $table = $_GET['table'];
        $kid = $_GET['kid'];
        $connection = new mysqli('localhost', 'root', '', 'Kursplaner');
        //looks if it is getting the right parameter
        if($table == 'exam'){
          $date = $_POST['date'];
          $topic = $_POST['topic'];
          if(isdate($date)){
            $sql = "INSERT INTO exam (KID,date,topic) VALUES($kid,'$date','$topic');";
          }
          else {
            echo "That is not a date!";
          }
        }
        elseif ($table=='homework') {
          $discription = $_POST['discription'];
          $id = $_COOKIE['id'];
          $sql1 = "SELECT username FROM user WHERE UID = $id;";
          $result1 = $connection->query($sql1);
          if($result1!=false){
            $datensatz1 = $result1->fetch_assoc();
            $discription = $discription."</br>-".$datensatz1['username'];
          }
          $sql = "INSERT INTO homework (discription,KID) VALUES('$discription',$kid);";
        }
        elseif ($table == 'mates') {
          $name = $_POST['name'];
          $sql1 = "SELECT UID FROM user WHERE username = $name;";
          $result1 = $connection->query($sql1);
          if($result1 != false){
            $datensatz1 = $result1->fetch_assoc();
            $uid = $datensatz1['UID'];
            $sql = "INSERT INTO take (UID,KID) VALUES($uid,$kid);";
          }
        }
        $result = $connection->query($sql);
        $connection->close();
      }
      function leaf(){
        $kid = $_GET['kid'];
        $id = $_COOKIE['id'];
        header('Location: /Kursplaner/login/Student/editMode.php?id='.$id.'&kid='.$kid);
      }
      function isdate($date){
        if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$date)) {
          return true;
        } else {
          return false;
        }
      }
    ?>
  </body>
</html>
