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
    var user = document.getElementById('username').value;
    var passwordIn = document.getElementById('password').value;
    var password = createHash(passwordIn);

    if(user == "" || password == ""){
      alert(false);
      document.getElementById("message").innerHTML = "enter username and password!";
    }


    //todo: call php function and get result
//------------------------------------------------------------------------------
    jQuery.ajax({
      type: "POST",
      url: 'login.php',
      dataType: 'json',
      data: {functionname: 'check', arguments: [user, password]},
      success:function(data) {
        alert(data);
      }
    });
    //window.location.href = 'login.php';
//------------------------------------------------------------------------------
}
