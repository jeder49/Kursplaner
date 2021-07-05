<!--parameter: table, KID-->
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

        // change "looksAt" attribut in "token" to token of class
        $sql04 = 'UPDATE token SET looksAt= "insert" WHERE ToID ='.$datensatz0['ToID'].';';

        //sents sql comant to database
        $connection->query($sql04);

        //close conection to Database
        $connection->close();

      }
    }else {

      //sent you to hell
      header('Location: /Kursplaner/login/MagicWord.html');

    }
  ?>
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
