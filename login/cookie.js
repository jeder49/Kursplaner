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

function createCookiePower(){
  var user = $('#username');
  var password = createHash($('#password'));
  document.cookie = "username="+user+" "+password;

}

createCookiePower();
