<!--parameter: table, KID-->
<html>
  <head>
    <!--definds -->
    <meta charset="UTF-8">

    <!---->
    <link rel="stylesheet" href="startAdmin_style.css">

    <title>
      <?php
        $table = $_GET['table'];
        $kid = $_GET['kid'];
        echo $table.' - add';
      ?>
    </title>
  </head>
  <body>
    <?php
      //if button is pressed
      if(array_key_exists('button1', $_POST)) {
        insert();
      }
      //called when button is pressed
      function insert(){
        //looks if it is getting the right parameter
        if($table == 'exam'){

          $date = $_POST['date'];
          $topic = $_POST['topic'];
          if(isdate($date)){
            $sql = 
          }
        }
        elseif ($table=='homework') {

        }
        elseif ($table=='mates') {

        }

      }
      function isdate($date){
        if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$date)) {
          return true;
        } else {
          return false;
        }
      }
    ?>

    <form method="post">

      <?php
        if($table == 'exam'){
          echo '<input type="text" name="date"/>';
          echo '<input type="text" name="topic"/>';
        }
        elseif ($table=='homework') {
          echo '<input type="text" name="discription"/>';
        }
        elseif ($table=='mates') {
          echo '<input type="text" name="name"/>';
        }

      ?>
      <input type="submit" value="do it" name="button1"/><br/>
    </form>
  </body>
</html>
