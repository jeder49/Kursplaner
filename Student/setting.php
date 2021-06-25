<html>
  <head>
    <!--definds -->
    <meta charset="UTF-8">

    <!--
      <link rel="stylesheet" href="setting_style_dark.css">-->
      <link rel="stylesheet" href="setting_style_white.css">
    <title>settings</title>
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
          SETTINGS:
        </h1>
      </center>
    </header>

    <div id="side-menu" class="side-nav">
			<a href="#" class="btn-close" onclick="closeSlideMenu()">&times;</a>
      <?php
        $id= $_GET['id'];
        echo "<a  class='hover' href='startStudent.php?id=$id'>Menu</a>";
			  echo "<a  class='hover' href='exams.php?id=$id'>exams</a>";
        echo "<a  class='hover' href='classes.php?id=$id'>classes</a>";
        echo "<a  class='hover' href='setting.php?id=$id'>settings</a>";
        echo "<a  class='hover' href='../login/login.php'>log out</a>";
      ?>
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

    <form method="post">
      <div>
        <center>
          <table id="classes">
            <tr>
              <td>
                Profil
                </br>

                <!--pofil picture-->

              </br>
                <?php
                  //get data about the class
                  $sql = "SELECT nickname,email,username FROM user WHERE UID=$id;";

                  //creates connection to database
                  $connection = new mysqli('localhost', 'root', '', 'kursplaner');

                  //gets the result of the DB for the sql comand
                  $result = $connection->query($sql);

                  //
                  $datensatz = $result->fetch_assoc();

                  echo $datensatz['username'];
                ?>
              </td>
              <td>
                <ul>
                  <li>
                    <input type="text" name="name" placeholder="<?php $datensatz['nickname']?>"/>
                  </li>
                  <li>
                    <input type="text" name="password" />
                  </li>
                  <li>
                    <input type="text" name="email" placeholder="<?php $datensatz['email']?>"/>
                  </li>
                </ul>
              </td>
            </tr>
            <tr>
              <td>
                Theme
              </td>
              <td>
                <label class="switch">
                  <input type="checkbox">
                  <span class="slider"></span>
                </label>
              </td>
            </tr>
            <tr>
              <td>
                  Language
              </td>
              <td>

              </td>
            </tr>
          </table>
        </center>
      </div>
      <center>
        <input type="submit" name="sub" />
      </center>
    <form>
    <center>
      <?php
        if(array_key_exists('sub', $_POST)) {
          $name = $_POST['name'];
          $password = $_POST['password'];
          $id = $_GET['id'];
        }
        $connection->close();
    ?>
    </center>
  </body>
</html>
