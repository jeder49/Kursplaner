<?php
  $id;
  $username = $_POST['username'];
  $password = $_POST['password'];
  print_r($username);
  print_r($password);
  function checklogin(){

    //sql command
    $sql = "SELECT UID,username,password FROM user;";

    //creates connection to database
    $connection = new mysqli('localhost', 'root', '', 'Kursplaner');

    //gets the result of the DB for the sql comand
    $result = $connection->query($sql);

    //when there is a problem with the sql comand like wrong spelled collmn the DB returns false

    //if DB returns false it error message is printed
    if($result==false){

      echo "error 01: [login.php]: database returns false";

    }
    else{

      //runs throught the array
      while ($datensatz = $result->fetch_assoc()) {

          //echo " user: ".$datensatz["Benutzername"].";"." password: ".$datensatz["Passwort"].";";

          //if username and password fit it returns true
          if($datensatz["Benutzername"] == $username && $datensatz["Passwort"] == $password){
            //is admin or not?
            $id = setcookie('id',$datensatz['UID']);
            checkRights();
          }

        }

    }
    //disconnect from database
    $connection->close();

    //retuns false because no user with this password exists
    return false;
  }


  function checkRights(){
    //looks if user is admin, teacher, student or students representitive
    $sql1 = "SELECT cout(UID) FROM class WHERE UID=$id;";
    $sql2 = "SELECT cout(UID) FROM teacher WHERE UID=$id;";
    $sql4 = "SELECT cout(UID) FROM admin WHERE UID=$id;";

    //gets the result of the DB for the sql comand
    $result1 = $connection->query($sql1);
    if( 0 != $result1){

      //cookie to save type of user
      setcookie('typ','student representetive');

      //cookie.js
      echo "<script>" . file_get_contents('./cookie.js') . "</script>";//'../admin'

      //
      header('Location: /StartStudent.php');
    }
    $result1 = $connection->query($sql2);
    if( 0 != $result1){

      //cookie to save type of user
      setcookie('typ','teacher');

      //cookie.js
      echo "<script>" . file_get_contents('./cookie.js') . "</script>";//'../admin'

      //
      header('Location: /StartStudent.php');
    }
    $result1 = $connection->query($sql4);
    if( 0 != $result1){

      //cookie to save type of user
      setcookie('typ','admin');

      //cookie.js
      echo "<script>" . file_get_contents('./cookie.js') . "</script>";//'../admin'

      //
      header('Location: /StartAdmin.php');
    }
  }
?>
