<html>
  <head>
    <!--definds -->
    <meta charset="UTF-8">

    <!--
    <link rel="stylesheet" href="getUser_style_dark.css">
    <link rel="stylesheet" href="getUser_style_white.css">-->

    <title>
      getUser
    </title>

  </head>
  <body>
    <form method="post">

      <!--input for 0:username/email 1:code-->
      <?php
        //button is not clicked
        $i=0;

        echo "<input name='userIn' placeholder='name or email'/>";

        //generates a random 6 digit code
        function randomNum(){
          $n = rand(0,9);
          for($f=0;$f<5;$f++){
            $n = $n.rand(0,9);
          }
          return $n;
        }

        //if the button 'enter' is pressed
        if(array_key_exists('enter', $_POST)) {
          //saves a 6 digit code in $code
          $code = randomNum();

          //if user just entered the page with out pressing the button
          if($i==0){
            //get user input
            $input = $_POST['userIn'];

            //what if some one is called like some one email?
            //what if email does not exist?

            //sql command to get email of user
            $sql = "SELECT UID,email,username FROM user WHERE username = '$input' OR email = '$input';";

            //creates connection to database
            $connection = new mysqli('localhost', 'root', '', 'Kursplaner');

            //gets the result of the DB for the sql comand
            $result = $connection->query($sql);

            //if DB returns not false it
            if($result != false){
              ini_set('SMTP', "smtp.gmail.com");
              ini_set('smtp_port', "25");
              ini_set('sendmail_from', "jeder@gmail.com");
              //if some one has the idea to enter a username as email
              while ($datensatz = $result->fetch_assoc()) {
                $to = "irgendetwas3@gmx.de";//$datensatz['email'];
                $message = "Hello ".$datensatz['username'].",</br> did you try to reset your password? If yes, here is the six digit code:</br><b>$code</b>";
                $header = "From: jeder@gmail.com";
                if(mail( $to, 'password', $message,$header)){
                  echo "</br>Code was sent.</br>";
                }else {
                  echo "</br>something went wrong</br>";
                }
              }
            }else{
              echo "</br>Sorry, we got a error from the database. input: $input</br>";
            }
            echo "<input name='codeIn' placeholder='code'/>";
            $i++;
          }

          //if
          elseif ($i==1) {
            //get user input
            $input = $_POST['codeIn'];

            //if the variable $code is not defined (should only happen if i was set 1 in the beginning)
            if($code==0){
              echo "You are a durty little harcker aren't you?!";
            }else{

              echo "<input name='codeIn'/>";
              $codeIn = $_GET('codeIn');

              //if the user input
              if($codeIn==$code){
                header('Location: /Kursplaner/login/reset.php?id=');
              }
            }
          }
        }
      ?>

      </br>

      <!--button to submit 0:username/email 1:code to php code-->
      <input type="submit" name="enter"/>
    </form>
  </body>
</html>
