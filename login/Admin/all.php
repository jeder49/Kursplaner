<html>
  <head>
    <!--definds -->
    <meta charset="UTF-8">

    <!---->
    <link rel="stylesheet" href="all_style_dark.css">
    <link rel="stylesheet" href="all_style_white.css">

    <title>all</title>
  </head>
  <body>
    <header>
      <button type="button" id="search" href="startAdmin.html">search</button>
      <button type="button" id="all" href="all.php">all</button>
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
