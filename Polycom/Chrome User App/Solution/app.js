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
	var form = document.querySelector('form');
form.addEventListener('submit', function(ev) {
 
 dma = document.getElementById('dma').value;
 login = document.getElementById('login').value;
 pass = document.getElementById('password').value;
 room_id = document.getElementById("room_id");
 
  url_init="https://" + dma + ":8443";
  url = url_init + '/api/rest/users';
  console.log(url);
  
	var xhr = new XMLHttpRequest();
	xhr.open('GET',url);
	auth = make_base_auth(login,pass);
	
	xhr.setRequestHeader("Authorization", auth);
	xhr.send();
  
  xhr.onreadystatechange = function() {
    if (xhr.readyState === 4) {
        if (xhr.status === 200) {
		
			var items = xhr.responseXML.querySelectorAll("username");
			var name = "";
			
			for (var n = 0; n < items.length; n++) {
				if(name=="")
				{
					name = items[n].textContent;
				}
				else
				{
					name = name + ", " + items[n].textContent;
				}
				room_id.innerHTML=name;
				}
        } else 
		{
            console.error("Something went wrong!");
        }
    }
	console.log("Nom : " + name);
};


  
  });
  
  /*---------------
	Code to create the user
	----------------*/
  
  var form2 = document.getElementById('myForm2');
form2.addEventListener('submit', function(ev) {
	
	dma = document.getElementById('dma').value;
	url_init="https://" + dma + ":8443";
	var url_final_user = url_init + "/api/rest/users";
	var first_name = document.getElementById("first_name").value;
	var last_name = document.getElementById("last_name").value;
	var username = document.getElementById("username").value;
	var password = document.getElementById("password2").value;
	login = document.getElementById('login').value;
	pass = document.getElementById('password').value;
	auth = make_base_auth(login,pass);
	
var XML_Message = 
		"<plcm-user xmlns=\"urn:com:polycom:api:rest:plcm-user\">\r\n" + 
		"<username>"+ username +"</username>\r\n" +
		"<first-name>"+ first_name +"</first-name>\r\n" +
		"<last-name>"+ last_name +"</last-name>\r\n" +
		"<password>"+ password +"</password>\r\n" +
		"</plcm-user>\r\n";

		console.log(XML_Message);
		console.log("URL" + url_final_user);
		
		var req = new XMLHttpRequest();
		req.open('POST', url_final_user);
		req.setRequestHeader("Content-Type","application/vnd.plcm.plcm-user+xml");
console.log("Autho " + auth);
req.setRequestHeader('Authorization', auth);
req.withCredentials = true;
req.send(XML_Message);

 req.onreadystatechange = function() {
    if (req.readyState === 4) {
        if (req.status === 201) {
            
			Update_good.innerHTML="User Created :) ...";
						
        } else {
            console.error("Something went wrong!");
			
        }
    }
	
}
});
  
  
})();