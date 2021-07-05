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
          $date = date('m/d/Y h:i:s a', time());

          // TODO: does not work!
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
        $sql04 = 'UPDATE token SET looksAt= "settings" WHERE ToID ='.$datensatz0['ToID'].';';

        //sents sql comant to database
        $connection->query($sql04);

        //close conection to Database
        $connection->close();

      }
    }else {

      //sent you to hell
      header('Location: /Kursplaner/login/MagicWord.html');

    }

    if(array_key_exists('search', $_POST)) {
      header('Location: /Kursplaner/login/Admin/startAdmin.php');
    }
    if(array_key_exists('all', $_POST)) {
      header('Location: /Kursplaner/login/Admin/all.php');
    }
    if(array_key_exists('online', $_POST)) {
      header('Location: /Kursplaner/login/Admin/online.php');
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
    <link rel="stylesheet" href="all_style_dark.css">
    <link rel="stylesheet" href="all_style_white.css">-->

    <title>all</title>
  </head>
  <body>
    <header>
      <form method="post">
        <input type="submit" name="search" class='hover' value="search" />
        <input type="submit" name="all" class='hover' value="all" />
        <input type="submit" name="online" class='hover' value="online" />
        <input type="submit" name="logout" class='hover' value="log out" />
      </form>
    </header>
    <div>

      <div>
        User:</br>
        <?php
          //sql command to get the username and password of the user
          $sql = "SELECT UID,username,password FROM user WHERE username='$username';";

          //creates connection to database
          $connection = new mysqli('localhost', 'root', '', 'Kursplaner');

          //gets the result of the DB for the sql comand
          $result = $connection->query($sql);

          //when there is a problem with the sql comand like wrong spelled collmn the DB returns false

          //if DB returns false it error message is printed
          if($result==false){

            echo "error 01: [login.php]: database returns false: ".$sql;

          }
          else{

            //runs throught the array
            while ($datensatz = $result->fetch_assoc()) {

            }
          }
        ?>
      </div>


    </div>
  </body>
</html>
