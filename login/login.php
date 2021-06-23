<html>
  <head>
    <!--definds typ of character set-->
    <meta charset="UTF-8">

    <!--style of the html file-->
    <link rel="stylesheet" href="login_style_dark.css">
    <link rel="stylesheet" href="login_style_white.css">

    <title>login</title>
  </head>
  <body>
    <center>
      <div>
      <form>
        <!--gets username by the user-->
        <input type="text" id = "username" placeholder="username"><br/>

        <!--gets password by the user-->
        <input type="password" id = "password" placeholder="password"><br/>

        <!--checkbox if user should stay recogised
        <input type="checkbox" id="cookie">
        <label for="cookie"> stay tuned </br> (come to the darkk side we have cookies!)</label></br>
        -->

        <!--button to submit the username and password-->
        <input type="submit" onclick="doHashThing()" value="lets go!"/><br/>
      </form>
        <!--transforms the password in a hash-->
        <script>
        /*
        function getCookie(name) {
          var dc = document.cookie;
          var prefix = name + "=";
          var begin = dc.indexOf("; " + prefix);
          if (begin == -1) {
            begin = dc.indexOf(prefix);
            if (begin != 0) return null;
          }
          else
          {
              begin += 2;
              var end = document.cookie.indexOf(";", begin);
              if (end == -1) {
                end = dc.length;
              }
            }
            return decodeURI(dc.substring(begin + prefix.length, end));
          }
          */

          function deleteCookie(){
            document.cookie = "username=;expires=Thu, 01 Jan 1970 00:00:00 GMT";
            document.cookie = "password=;expires=Thu, 01 Jan 1970 00:00:00 GMT";
            document.cookie = "typ=;expires=Thu, 01 Jan 1970 00:00:00 GMT";
            document.cookie = "id=;expires=Thu, 01 Jan 1970 00:00:00 GMT";
            document.cookie = "cookie=;expires=Thu, 01 Jan 1970 00:00:00 GMT";
          }
          var cookie = document.getElementById("cookie");

          deleteCookie();
          /*
          console.log("test");
          console.log(getCookie('cookie'));

          if(cookie.checked==true){
            document.cookie = "cookie="+true;
          }

          if(getCookie('cookie')==null){
            deleteCookie();
          }else{
            document.getElementById("cookie").checked = true;
          }
          */
          //creates the hash of a string
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

            //
            function doHashThing(){
              //gets username
              var user = document.getElementById('username').value;

              //gets password
              var passwordIn = document.getElementById('password').value;

              //password as hash
              var password = createHash(passwordIn);

              //creates cookie so the webside (CookiePower!)
              document.cookie = "username="+user;

              document.cookie = "password="+password;
          }
        </script>
          <?php

            $username = "";
            //
            if(isset($_COOKIE['username'])){
              $username = $_COOKIE['username'];
              $password = $_COOKIE['password'];

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

                    //echo " user: ".$datensatz["Benutzername"].";"." password: ".$datensatz["Passwort"].";";

                    //if username and password fit it returns true
                    if($datensatz["username"] == $username && $datensatz["password"] == $password){
                      //is admin or not?
                      $id = setcookie('id',$datensatz['UID']);
                      checkRights($id,$connection);
                    }

                  }
                  echo "Password or Username is wrong but who could tell which of them ;)";
              }
              //disconnect from database
              $connection->close();

              //retuns false because no user with this password exists
              return false;
            }


            function checkRights($id,$connection){
              //looks if user is admin, teacher, student or students representitive
              $sql1 = "SELECT count(SID) FROM class WHERE SID=$id;";
              $sql2 = "SELECT count(UID) FROM teacher WHERE UID=$id;";
              $sql3 = "SELECT count(UID) FROM admin WHERE UID=$id;";

              //gets the result of the DB for the sql comand
              $result1 = $connection->query($sql1);
              $result2 = $connection->query($sql2);
              $result3 = $connection->query($sql3);


              if($result1 != false ){
                $datensatz1 = $result1->fetch_assoc();
              }
              if($result2 != false){
                $datensatz2 = $result2->fetch_assoc();
              }
              if($result3 != false ){
                $datensatz3 = $result3->fetch_assoc();
              }
              //if the user is to find in the in the class tabel a student representetive

              if ($datensatz1['count(SID)']!=0) {
                //cookie to save type of user
                setcookie('typ','student representetive');

                //
                header('Location: /kursplaner/Student/startStudent.php');
              }

              //if the user is to find in the in the teacher tabel
              else if ($datensatz2['count(UID)']!=0) {
                //cookie to save type of user
                setcookie('typ','teacher');

                //
                header('Location: /kursplaner/Student/startStudent.php');
              }

              //if the user is to find in the in the admin tabel
              else if ($datensatz3['count(UID)']!=0) {
                //cookie to save type of user
                setcookie('typ','admin');

                //
                header('Location: /kursplaner/admin/startAdmin.html');
              }
              //if the user is to find in the in any tabel
              else{
                //cookie to save type of user
                setcookie('typ','student');

                //
                header('Location: /kursplaner/Student/startStudent.php');
              }
            }
          ?>
          <p><a href="rest.html">passwort vergessen?</a></p>
      </div>
    </center>
  </body>
</html>
