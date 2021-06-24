<html>
  <head>
    <!--definds -->
    <meta charset="UTF-8">

      <link rel="stylesheet" href="startStudent_style_white.css" id="white">

    <title>home</title>
  </head>

  <body>
    <!--if user is not registerd he gets back to login.php & get date-->
    <?php
      //setcookie('name','wert'(var),'Existensberechtigung'(int))
      /*
      if(!isset($_COOKIE['login'])){                           //möglicher Fehler
        if (isset($_COOKIE['typ']) {
          setcookie("typ", "", time() - 3600);
        }
        include 'login.php';
      }
      */
      $type = $_GET['type'];
    ?>
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
			<a>Menu</a>
      <?php
        $id= $_GET['id'];
			  echo "<a  class='hover' href='exams.php?id=$id'>exams</a>";
        echo "<a  class='hover' href='classes.php?id=$id'>classes</a>";
        echo "<a  class='hover' href='setting.php?id=$id'>settings</a>";
      ?>
    </div>

    <div id="main">
			<div id="montag" class="stundenplan" href="#">
				<h1>Stundenplan Montag</h1>
				<div>
        <table>
          <?php
            if(array_key_exists('Mon', $_POST)) {
              echo '<script>openMonday();</script>';
              button1($type);
            }
            else if(array_key_exists('Tue', $_POST)) {
              echo '<script>openTuesday();</script>';
              button2($type);
            }
            else if(array_key_exists('Wed', $_POST)) {
              echo '<script>openWednesday();</script>';
              button3($type);
            }
            else if(array_key_exists('Thur', $_POST)) {
              echo '<script>openThursday();</script>';
              button4($type);
            }
            else if(array_key_exists('Fri', $_POST)) {
              echo '<script>openFriday();</script>';
              button5($type);
            }
            else{
              load(date("N"),$type);
            }

            function button1($type) {
              load(1,$type);
            }
            function button2($type) {
              load(2,$type);
            }
            function button3($type) {
              load(3,$type);
            }
            function button4($type) {
              load(4,$type);
            }
            function button5($type) {
              load(5,$type);
            }

            function load($day,$type) {
              //userid
              $id = 2;//$_COOKIE['id'];

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
                    echo '<tr><th><a href=class.php?id='.$datensatz1['KID'].'&type='.$type.'>'.$datensatz1['subject'].'</a>'.'</br>'.$datensatz1['token'].'</th></tr>';
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
