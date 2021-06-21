function createCookiePower(){
  var user = $('#username');
  var password = $('#password');
  document.cookie = "username="+user+" "+password+"; language";
}
