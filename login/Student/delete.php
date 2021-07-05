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
      $sql04 = 'UPDATE token SET looksAt= "delete" WHERE ToID ='.$datensatz0['ToID'].';';

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
<?php
  //name of the table elements are deleted from
  $table = $_GET['table'];
  //classid
  $kid = $_GET['KID'];
  //userid
  $id = $_GET['id'];
  //index of element
  $i = $_GET['l'];

  echo 'table: '.$table.'</br>';
  echo 'kid: '.$kid.'</br>';
  echo 'id: '.$id.'</br>';
  echo 'i: '.$i.'</br>';

  //creates connection to database
  $connection = new mysqli('localhost', 'root', '', 'Kursplaner');

  if($table=='homework'){

    $sql= "DELETE FROM homework WHERE HID=$i";

    //gets the result of the DB for the sql comand
    $result = $connection->query($sql);

    header('Location: /Kursplaner/login/Student/editMode.php?id='.$id.'&kid='.$kid);
  }

  elseif ($table=='exam') {

    $sql="DELETE FROM exam WHERE EID=$i";

    //gets the result of the DB for the sql comand
    $result = $connection->query($sql);

    //
    header('Location: /Kursplaner/login/Student/editMode.php?id='.$id.'&kid='.$kid);
  }

  elseif ($table=='mates') {

    $sql="DELETE FROM take WHERE UID=$i AND KID=$kid";

    //gets the result of the DB for the sql comand
    $result = $connection->query($sql);
    header('Location: /Kursplaner/login/Student/editMode.php?id='.$id.'&kid='.$kid);
  }
  $connection->close();
?>
