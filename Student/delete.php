<?php
  $table = $_GET['table'];

  $kid = $_GET['KID'];

  $id = $_GET['id'];

  $i = $_GET['i'];

  //creates connection to database
  $connection = new mysqli('localhost', 'root', '', 'Kursplaner');

  if($table='homework'){

    $sql= "UPDATE class SET homework = '' WHERE KID=$kid";

    //gets the result of the DB for the sql comand
    $result = $connection->query($sql);

    $sql1= "DELETE FROM homework WHERE HID=$i AND KID=$kid";

    //gets the result of the DB for the sql comand
    $result1 = $connection->query($sql1);

    header('Location: /kursplaner/Student/editMode.php?id='.$id.'&kid='.$kid);
  }

  elseif ($table='exam') {

    $sql="SELECT EID FROM exam WHERE KID=$kid";

    //gets the result of the DB for the sql comand
    $result = $connection->query($sql1);

    $datensatz = $result->fetch_assoc();

    for($f=0;$f==$i+1;$f++){
      if($f==$i){
        $sql1="DELETE FROM exam WHERE EID=".$datensatz['EID'];
      }
    }

    //gets the result of the DB for the sql comand
    $result = $connection->query($sql1);
    header('Location: /kursplaner/Student/editMode.php?id='.$id.'&kid='.$kid);
  }

  elseif ($table='mates') {

    $sql="DELETE FROM take WHERE UID=$i AND KID=$kid";

    //gets the result of the DB for the sql comand
    $result = $connection->query($sql);
    header('Location: /kursplaner/Student/editMode.php?id='.$id.'&kid='.$kid);
  }
?>
