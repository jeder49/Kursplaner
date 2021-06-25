<html>
  <head>
    <!--definds -->
    <meta charset="UTF-8">

    <!--
    <link rel="stylesheet" href="getUser_style_dark.css">
    <link rel="stylesheet" href="getUser_style_white.css">
    -->
    <title>
      <?php
        $i=0;
        if($i==0){
          echo 'getUser';
        }elseif ($i==1) {
          echo 'code';
        }
      ?>
    </title>

  </head>
  <body>
    <header>
      <button type="button" id="search" href="startAdmin.html">search</button>
      <button type="button" id="all" href="all.php">all</button>
    </header>
    <form action="code.php" method="post">

      <!---->
      <input name = "username" placeholder="name or email"><br/>

      <!---->
      <input type="submit"></input>
      <?php
        $sql = "SELECT email FROM user WHERE username = $input OR email = $input;";

        //creates connection to database
        $connection = new mysqli('localhost', 'root', '', 'Kursplaner');

        //gets the result of the DB for the sql comand
        $result = $connection->query($sql);

        //if DB returns false it error message is printed
        if($result != false){
          //if some one has the idea to enter a username as email
          while ($datensatz = $result->fetch_assoc()) {
            $to = $datensatz['email'];
            $message = "Hallo, Haben sie versucht ";
            mail( $to, 'password', message);
          }
        }
      ?>
    </form>
  </body>
</html>
