<html>
  <head>
    <!--definds -->
    <meta charset="UTF-8">

    <!--
      <link rel="stylesheet" href="classes_style_dark.css">-->
      <link rel="stylesheet" href="exams_style_white.css">
    <title>exams</title>
  </head>
  <body>

      <!--sortieren nach...-->


    <header>
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
      </nav>
      <center>
        <h1>
          EXAMS:
        </h1>
      </center>
    </header>

    <div id="side-menu" class="side-nav">
			<a href="#" class="btn-close" onclick="closeSlideMenu()">&times;</a>
      <?php
        $id= $_GET['id'];
        $type= $_GET['type'];
        echo "<a  class='hover' href='startStudent.php?type=$type&id=$id'>Menu</a>";
			  echo "<a  class='hover' href='exams.php?type=$type&id=$id'>exams</a>";
        echo "<a  class='hover' href='classes.php?type=$type&id=$id'>classes</a>";
        echo "<a  class='hover' href='setting.php?type=$type&id=$id'>settings</a>";
        echo "<a  class='hover' href='../login/login.php'>log out</a>";
      ?>
    </div>

    <div>
      <center>
        <table id="classes">
          <?php
            $id = $_GET['id'];

            $sql = "SELECT EID,KID,topic,date FROM exam natural join (SELECT KID FROM take WHERE UID=$id) as t;";

            //creates connection to database
            $connection = new mysqli('localhost', 'root', '', 'kursplaner');

            //gets the result of the DB for the sql comand
            $result = $connection->query($sql);

            while ($datensatz = $result->fetch_assoc()) {

              $sql1 = "SELECT subject FROM class WHERE KID=".$datensatz['KID'].";";

              $result1 = $connection->query($sql1);

              $datensatz1 = $result1->fetch_assoc();

              //prints out the
              echo "<tr><th><a href=class.php?id=".$datensatz['EID'].">".$datensatz1['subject']."</a></br>".$datensatz['date']."</th></tr>";

            }
            $connection->close();
          ?>
        </table>
      </center>
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
    </script>
  </body>
</html>
