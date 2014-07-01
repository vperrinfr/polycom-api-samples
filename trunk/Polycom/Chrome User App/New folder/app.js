(function(){
  
  /*---------------
	Variables
	----------------*/
  
  var dma = "";
  var login = "";
  var pass = "";
  var url_init="";
  var auth = "";
  var user = "";
  var etag = "";
  var room_id = "";
  var url = "";

    /*---------------
	Code to encode the authentication string
	----------------*/
function make_base_auth(user, password) {
  var tok = user + ':' + password;
  var hash = Base64.encode(tok);
  return "Basic " + hash;
}

/*---------------
Code to list all users
----------------*/

// End of the code to list all users

/*---------------
Code to create the user
----------------*/
  
// End of the code to create an user
  
})();