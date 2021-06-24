<?php
  $table = $_GET['table'];

  $kid = $_GET['KID'];

  $id = $_GET['id'];

  //creates connection to database
  $connection = new mysqli('localhost', 'root', '', 'Kursplaner');

  if($table='homework'){

    $sql= "UPDATE class SET homework = '' WHERE KID=$kid";

    //gets the result of the DB for the sql comand
    $result = $connection->query($sql);
  }

  elseif ($table='exam') {

    $sql="SELECT EID FROM exam WHERE KID=$kid";

    //gets the result of the DB for the sql comand
    $result = $connection->query($sql1);

    $datensatz = $result->fetch_assoc();

    for($i=0;$i==$id+1;$i++){
      if($i==$id){
        $sql1="DELETE FROM exam WHERE EID=".$datensatz['EID'];
      }
    }

    //gets the result of the DB for the sql comand
    $result = $connection->query($sql1);
  }

  elseif ($table='mates') {

    $sql="DELETE FROM take WHERE UID=$id AND KID=$kid";

    //gets the result of the DB for the sql comand
    $result = $connection->query($sql);
  }
?>
