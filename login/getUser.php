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
        $i=$_GET['i'];
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

    </header>
    <form method="post">

      <!---->
      <input name = "username" placeholder="name or email"/>

      <!---->
      <input type="submit"/>
      <?php
        if(array_key_exists('login', $_POST)) {
          doit();
        }
        function randomNum(){
          $n = rand(0,9);
          for($f=0;$f<5;$f++){
            $n = $n.rand(0,9);
          }
          return $n;
        }
        $code = randomNum();
        function doit(){

          if($i=0){
            $sql = "SELECT UID,email FROM user WHERE username = $input OR email = $input;";

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
            header('Location: /Kursplaner/login/getUser.php?i=1&id='.$datensatz['UID']);
          }elseif ($i=1) {
            header('Location: /Kursplaner/login/reset.php?id=');
          }
        }
      ?>
    </form>
  </body>
</html>
