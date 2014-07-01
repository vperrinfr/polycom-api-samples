(function(){
  var form = document.querySelector('form');
  var form2 = document.getElementById('myForm2');
  
  var room_id = document.getElementById("room_id");
  var chair_pass = document.getElementById('chair_pass');
  var conf_pass = document.getElementById('conf_pass');
  var dma = "";
  var login = "";
  var pass = "";
  var url_init="";
  var auth = "";
  var room = "";
  var etag = "";
  
  function log(str) {
    logarea.value=str+"\n"+logarea.value;
  }
  
  form.addEventListener('submit', function(ev) {

  dma = document.getElementById('dma').value;
  login = document.getElementById('login').value;
  pass = document.getElementById('password').value;
  
  url_init="https://" + dma + ":8443";
  var url = url_init + '/api/rest/conference-rooms?username=admin';
  console.log(url);
var xhr = new XMLHttpRequest();
xhr.open('GET',url);

auth = make_base_auth(login,pass);
console.log("Pas Function " + auth);
xhr.setRequestHeader("Authorization", auth);
xhr.send();
  
  xhr.onreadystatechange = function() {
    if (xhr.readyState === 4) {
        if (xhr.status === 200) {
            
			xmlDoc=xhr.responseText;
			var dp = new DOMParser();
			var zDom = dp.parseFromString(xmlDoc, "text/xml");
			console.log("Etag " + 	xmlDoc);	
	
	room = zDom.querySelector('conference-room-identifier').textContent;
	room_id.innerHTML=room;
	etag = zDom.querySelector("entity-tag").textContent;
	chair_pass.innerHTML=zDom.querySelector("chairperson-code").textContent;
	conf_pass.innerHTML=zDom.querySelector("conference-code").textContent;
	
	console.log("Etag " + 	etag);	
        } else {
            console.error("Something went wrong!");
        }
    }
};

function make_base_auth(user, password) {
  var tok = user + ':' + password;
  console.log(tok);
  var hash = Base64.encode(tok);
  console.log(hash);
  return "Basic " + hash;
}
  
  });

form2.addEventListener('submit', function(ev) {

var conf_id = room;
var url_final_vmr = url_init + '/api/rest/conference-rooms/' + conf_id;
var chair_pass_new = document.getElementById("chair_pass_new").value;
var conf_pass_new = document.getElementById("conf_pass_new").value;


var XML_Message = 
		"<plcm-conference-room xmlns=\"urn:com:polycom:api:rest:plcm-conference-room\">\r\n" +
			"<owner-domain>LOCAL</owner-domain>\r\n" +
			"<owner-username>" + login + "</owner-username>\r\n" +
		    "<duration-in-minutes>-1</duration-in-minutes>\r\n" +
			"<conference-room-identifier>" + conf_id +"</conference-room-identifier>\r\n" +
			"<conference-template-name>Custom template (AVC &amp; SVC)</conference-template-name>\r\n" +
			"<max-participants>10</max-participants>\r\n" +
			"<mcu-pool-order-name>Factory Pool Order</mcu-pool-order-name>\r\n" +
			"<chairperson-required>false</chairperson-required>\r\n" +
			"<chairperson-code>" + chair_pass_new + "</chairperson-code>\r\n" +
			"<conference-code>"+ conf_pass_new + "</conference-code>\r\n" + 
			"<entity-tag>" + etag + "</entity-tag>\r\n" +
			"<auto-dial-out>false</auto-dial-out>\r\n" +
		"</plcm-conference-room>\r\n";

		console.log(XML_Message);
		console.log("URL" + url_final_vmr);
		
		var req = new XMLHttpRequest();
		req.open('PUT', url_final_vmr);
		req.setRequestHeader("Content-Type","application/vnd.plcm.plcm-conference-room+xml");
console.log("Autho " + auth);
req.setRequestHeader('Authorization', auth);
req.withCredentials = true;
req.send(XML_Message);

 req.onreadystatechange = function() {
    if (req.readyState === 4) {
        if (req.status === 200) {
            
			xmlDoc=req.responseText;
						
        } else {
            console.error("Something went wrong!");
			Update_good.innerHTML="Update DONE...";
        }
    }
};


});

})();