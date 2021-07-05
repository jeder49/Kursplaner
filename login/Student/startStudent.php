<html>
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

          // TODO: does not work!
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
        $sql04 = 'UPDATE token SET looksAt= "home" WHERE ToID ='.$datensatz0['ToID'].';';

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
  <head>
    <!--definds -->
    <meta charset="UTF-8">

      <link rel="stylesheet" href="startStudent_style_white.css" id="white">

    <title>home</title>
  </head>

  <body>
    <nav class= "navbar">
      <div class="A">
        <a onclick="openSlideMenu()">
          <div class="side open-slide">
            <div class="b"></div>
            <div class="b"></div>
            <div class="b"></div>
          </div>
        </a>
      </div>
    <form class= "form" method="post">
      <input id="bMonday" class="navbar-nav" type="submit" name="Mon" id="bMonday" onclick="openMonday()" value="Monday"/>
      <input id="bTuesday" class="navbar-nav" type="submit" name="Tue" id="bTuesday" onclick="openTuesday()" value="Tuesday"/>
      <input id="bWednesday" class="navbar-nav" type="submit" name="Wed" id="bWednesday" onclick="openWednesday()" value="Wednesday"/>
      <input id="bThursday" class="navbar-nav" type="submit" name="Thur" id="bThursday" onclick="openThursday()" value="Thursday"/>
      <input  id="bFriday" class="navbar-nav" type="submit" name="Fri" id="bFriday" onclick="openFriday()" value="Friday"/>
    </form>
    </nav>

    <div id="side-menu" class="side-nav">
			<a href="#" class="btn-close" onclick="closeSlideMenu()">&times;</a>
      <?php
      function logout (){
          //get user id from cookie
          $id = $_COOKIE['id'];

          //get user ip so that permision is granted to the right pc
          $ip = $_SERVER['REMOTE_ADDR'];

          //creates connection to database
          $connection = new mysqli('localhost', 'root', '', 'kursplaner');

          //looks if there is token with the ip
          $sql0 = "SELECT ToID FROM online as o natural join (SELECT ToID FROM token WHERE IP = '$ip') as t WHERE UID = $id;";

          //get result of sql comand
          $result0 = $connection->query($sql0);

          //stors the number of
          $datensatz0 = $result0->fetch_assoc();

          //delets all entries in "online" that have a out of time token
          $sql05 = 'DELETE FROM online WHERE ToID ='.$datensatz0['ToID'].';';

          //sents sql comant to database
          $connection->query($sql05);

          //delets all entries in "online" that have a out of time token
          $sql06 = 'DELETE FROM token WHERE ToID ='.$datensatz0['ToID'].';';

          //sents sql comant to database
          $connection->query($sql06);

          //close conection to Database
          $connection->close();
        }
        echo "<a  class='hover' href='startStudent.php?id=$id'>Menu</a>";
			  echo "<a  class='hover' href='exams.php?id=$id'>exams</a>";
        echo "<a  class='hover' href='classes.php?id=$id'>classes</a>";
        echo "<a  class='hover' href='setting.php?&id=$id'>settings</a>";
      ?>
      <form method="post">
        <input type="submit" name="logout" class='hover' value="log out" />
      </form>
    </div>

    <div id="main">
			<div id="montag" class="stundenplan" href="#">
				<?php
          function title($day){
            switch ($day) {
              case '1':
                echo "<h1>Plan for Monday</h1></br>";
                break;
              case '2':
                echo "<h1>Plan for Tuesday</h1></br>";
                break;
              case '3':
                echo "<h1>Plan for Wednesday</h1>";
                break;
              case '4':
                echo "<h1>Plan for Thursday</h1>";
                break;
              case '5':
                echo "<h1>Plan for Friday</h1>";
                break;
              case '6':
                echo "<h1>Plan for Monday</h1>";
                break;
              case '7':
                echo "<h1>Plan for Monday</h1>";
                break;
              default:
                echo "<h1>sorry some thing went wrong!</h1>";
                break;
            }
          }
        ?>
        </br>
				<div>
        <table>
          <?php
            if(array_key_exists('logout', $_POST)) {
              logout();
              header('Location: /Kursplaner/login/login.php');
            }
            if(array_key_exists('Mon', $_POST)) {
              echo '<script>openMonday();</script>';
              load(1);
              title(1);
            }
            else if(array_key_exists('Tue', $_POST)) {
              echo '<script>openTuesday();</script>';
              load(2);
              title(2);
            }
            else if(array_key_exists('Wed', $_POST)) {
              echo '<script>openWednesday();</script>';
              load(3);
              title(3);
            }
            else if(array_key_exists('Thur', $_POST)) {
              echo '<script>openThursday();</script>';
              load(4);
              title(4);
            }
            else if(array_key_exists('Fri', $_POST)) {
              echo '<script>openFriday();</script>';
              load(5);
              title(5);
            }
            else{
              load(date("N"));
              title(date("N"));
            }


            function load($day) {
              //userid
              $id= $_GET['id'];

              if($day > 5){
                $day = 1;
              }

              //creates connection to database
              $connection = new mysqli('localhost', 'root', '', 'kursplaner');

              for($i=1;$i<6;$i++){

                //get kid where timeslot is = i and which are taken by the student
                $sql = "SELECT KID FROM takesPlace as tp natural join appointment as ap natural join (SELECT KID FROM take WHERE UID=$id) as t WHERE ap.day= $day AND ap.timeslot = $i";

                //
                $result = $connection->query($sql);

                if (!$result) {
                  echo '<tr id="'.$i.'"><th>Free time!</th></tr>';
                }else{
                  //
                  $datensatz = $result->fetch_assoc();

                  //get Id of the class
                  $kid = $datensatz['KID'];

                  //new sql comand to get the subject and kürzel of the termin
                  $sql1 = "SELECT KID,subject, token FROM class WHERE KID=$kid;";

                  //
                  $result1 = $connection->query($sql1);

                  if (!$result1) {
                    echo '<tr id="'.$i.'"><th>Free time!</th></tr>';
                  }else{
                    $datensatz1 = $result1->fetch_assoc();
                    //Create new <tr> tag with subject name in it
                    echo '<tr><th><a href=class.php?id='.$id.'&kid='.$datensatz1['KID'].'>'.$datensatz1['subject'].'</a>'.'</br>'.$datensatz1['token'].'</th></tr>';
                  }
                }
              }
              $connection->close();
            }
          ?>
        </table>
      </div>
    </div>
    </div>

    <script>
			function openSlideMenu(){
				document.getElementById('side-menu').style.width= '250px';
				document.getElementById('side-menu').style.marginLeft= '0';
			  }
			  function closeSlideMenu(){
				document.getElementById('side-menu').style.width= '0';
				document.getElementById('side-menu').style.marginLeft= '0';
			  }
			  function closeAll(){
				var close = document.getElementsByClassName("stundenplan");
				for(var i =0;i<5;i++){
					//close[i].style.height="0";
				}
			  }
			  function uncolor(){
				var buttons = document.getElementsByClassName('navbar-nav');
				for(var i =0;i<5;i++){
					buttons[i].style.backgroundColor= '#000659';
					buttons[i].style.color='#f2f2f2';
				}
			  }
			  function openMonday(){
				closeAll();
				uncolor();
				//document.getElementsByClassName('stundenplan').style.height= '100%';
				document.getElementById('bMonday').style.backgroundColor= '#ddd';
				document.getElementById('bMonday').style.color= '#000';
			  }
			  function openTuesday(){
				closeAll();
				uncolor();
        //document.getElementById('stundenplan').style.height= '100%';
				document.getElementById('bTuesday').style.backgroundColor= '#ddd';
				document.getElementById('bTuesday').style.color= '#000';
			  }
			  function openWednesday(){
				closeAll();
				uncolor();
        //document.getElementById('stundenplan').style.height= '100%';
				document.getElementById('bWednesday').style.backgroundColor= '#ddd';
				document.getElementById('bWednesday').style.color= '#000';
				}
			  function openThursday(){
				closeAll();
				uncolor();
        //document.getElementById('stundenplan').style.height= '100%';
				document.getElementById('bThursday').style.backgroundColor= '#ddd';
				document.getElementById('bThursday').style.color= '#000';
			  }
			  function openFriday(){
				closeAll();
				uncolor();
        //document.getElementById('stundenplan').style.height= '100%';
				document.getElementById('bFriday').style.backgroundColor= '#ddd';
				document.getElementById('bFriday').style.color= '#000';
      }
		 </script>

  </body>
</html>
