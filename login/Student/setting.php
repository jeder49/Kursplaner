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
        echo "<a  class='hover' href='../login.php'>log out</a>";
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
                    <?php
                    echo "<input type='text' name='name' placeholder='".$datensatz['nickname']."'/>";
                    ?>
                  </li>
                  <li>
                    <input type="text" name="password" placeholder="password" id="password"/>
                  </li>
                  <li>
                    <?php
                      if($datensatz['email']!=""){
                        echo "<input type='text' name='email' placeholder='".$datensatz['email']."'/>";
                      }else{
                        echo "<input type='text' name='email' placeholder='email'/>";
                      }
                    ?>
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

                  <?php
                    if(isset($_COOKIE['theme'])){
                      if($_COOKIE['theme']=='white'){
                        echo "<input type='checkbox' name='theme'>";
                      }else{
                        echo "<input type='checkbox' name='theme' checked>";
                      }
                    }else {
                      echo "<input type='checkbox' name='theme'>";
                    }
                  ?>
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
        <input onclick="pressed()" type="submit" name="sub" />
      </center>
    <form>
    <center>

      <script>
        function createHash(string){
          var hash = 0;

          //(already prevent in Line 19)
          if (string.length == 0) return hash;

          //
          for (i = 0; i < string.length; i++) {
            //get character by position
            char = string.charCodeAt(i);

            //to explain
            hash = ((hash << 5) - hash) + char;

            //to explain
            hash = hash & hash;
          }
          return hash;
        }
        function pressed(){
          //gets password
          var passwordIn = document.getElementById('password').value;

          //password as hash
          var password = createHash(passwordIn);

          document.cookie = "password="+password;
        }
      </script>

      <?php
        if(array_key_exists('sub', $_POST)) {
          $connection = new mysqli('localhost', 'root', '', 'kursplaner');
          $name = $_POST['name'];
          if(isset($_COOKIE['password'])){
            $password = $_COOKIE['password'];
          }else{
            $password="";
          }
          $email = $_POST['email'];
          $id = $_GET['id'];

          $sql = "UPDATE user SET";
          if($_POST['name']!=""){
            $sql = $sql." username = $name";
          }
          if($_POST['password']!=""){
            $sql = $sql." password = $password";
          }
          if($_POST['email']!=""){
            $sql = $sql." email = $email";
          }
          $sql = $sql." WHERE UID = $id";

          $connection->query($sql);
          $connection->close();
          if(isset($_POST['theme'])){
            setcookie('theme','dark');
          } else{
            setcookie('theme','white',time()+ 60 * 60 * 24 * 30,'../');
          }
        }
        //$connection->close();
      ?>
    </center>
  </body>
</html>
