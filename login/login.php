<?php
  function check($username,$password){
    //test data
    //$username = 'user0';
    //$password = 'password0';

    //sql command
    $sql = "SELECT Benutzername, Passwort FROM user;";

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
            return true;
          }

        }

    }

    //disconnect from database
    $connection->close();

    //retuns false because no user with this password exists
    return false;
  }
?>
