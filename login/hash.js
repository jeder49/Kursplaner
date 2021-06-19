function doHashThing(){
    var user = document.getElementById('username').value;
    var password = document.getElementById('password').value;
    alert("false");
    if(user = "" || password=""){
      alert("false");
      return false;
      document.getElementById("message").innerHTML = "enter username and password!";
    }else{
      var output = $get('login.php',check(user,password));
      alert(output);
      if(output != true){
        document.getElementById('message').innerHTML = "username or password is wrong or both, you never know ;)";
      }
    }
}
