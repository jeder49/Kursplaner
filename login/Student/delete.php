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
