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
  var conf_id_public = "";
  var list_participants="";
  var message = "";
  var speaker="";

	// Button listeners
	
	var save_b = document.getElementById('save');
	save_b.addEventListener('click', f_save, false);
	
	var retrieve_b = document.getElementById('retrieve');
	retrieve_b.addEventListener('click', f_retrieve, false);
	
	var participants_b = document.getElementById('participants');
	participants_b.addEventListener('click', f_participants, false);

	var participants_list_b = document.getElementById('participants_list');
	participants_list_b.addEventListener('click', f_participants_list, false);
	
	var excel_b = document.getElementById('to_excel');
	excel_b.addEventListener('click', f_excel, false);
	
	function f_save(event)
	{
	  if ( event.preventDefault ) event.preventDefault();
	  event.returnValue = false;
	  save();
		
	}
	
	function f_excel(event)
	{
	  if ( event.preventDefault ) event.preventDefault();
	  event.returnValue = false;
	  to_excel();
		
	}
	
	function f_retrieve(event)
	{
	  if ( event.preventDefault ) event.preventDefault();
	  event.returnValue = false;
	  retrieve();
		
	}
		
	function f_participants(event)
	{
	  if ( event.preventDefault ) event.preventDefault();
	  event.returnValue = false;
	  init();
		
	}
	function f_participants_list(event)
	{
	  if ( event.preventDefault ) event.preventDefault();
	  event.returnValue = false;
	  room_to_find();
		
	}	
	
  
  /*---------------
	Code to encode the authentication string
	----------------*/
function make_base_auth(user, password) {
  var tok = user + ':' + password;
  var hash = Base64.encode(tok);
  return "Basic " + hash;
}

if (typeof String.prototype.startsWith != 'function') {
  // see below for better implementation!
  String.prototype.startsWith = function (str){
    return this.indexOf(str) == 0;
  };
}
  
function to_excel(reservation)
{
	var A = [["Meeting Name","Start Time","End Time","Participants"]];
	dma = document.getElementById('dma').value;
	login = document.getElementById('login').value;
	pass = document.getElementById('password').value;
	list_participants = document.getElementById("list_participants");
	message = document.getElementById("message");
	message_vmr = document.getElementById("message_vmr");
	message_vmr.innerHTML = "";
	message.innerHTML = "";
	
	if(dma && login && pass )
 {
 
  url_init="https://" + dma + ":8443";
  url = url_init + "/api/rest/reservations?start-time=2014-05-01T13:00:00.000-06:00&end-time=2014-12-03T13:00:00.000-06:00";
  
	var xhr = new XMLHttpRequest();
	xhr.open('GET',url);
	auth = make_base_auth(login,pass);
	xhr.setRequestHeader("Authorization", auth);
	xhr.send();
  
  xhr.onreadystatechange = function() {
    if (xhr.readyState === 4) {
        if (xhr.status === 200) {
		
			var items = xhr.responseXML.querySelectorAll("plcm-reservation");
			var name = "";
			var html_code = "";
			var csvRows = [];
			
			if(items.length == 0)
			{
				message.innerHTML = "</p><div class=\"alert alert-danger\" role=\"alert\">No reservation.</div></p>";
			}
			else
			{
				
				var html_end = "";
				console.log("Debut" + A);
				for (var n = 0; n < items.length; n++)
				{
				name = "";
				var parti = items[n].querySelectorAll(" plcm-reserved-participant");
					for (var x = 0; x < parti.length; x++)
					{
						if(name=="")
						{
							name = parti[x].getElementsByTagName("participant-name")[0].childNodes[0].nodeValue;
						}
						else
						{
							name = name + " - " + parti[x].getElementsByTagName("participant-name")[0].childNodes[0].nodeValue;
						}
					}
					A.push([items[n].getElementsByTagName("name")[0].childNodes[0].nodeValue, items[n].getElementsByTagName("start-time")[0].childNodes[0].nodeValue, items[n].getElementsByTagName("end-time")[0].childNodes[0].nodeValue,name]);
					console.log(A);
					
				}
				for(var i=0, l=A.length; i<l; ++i)
					{
						csvRows.push(A[i].join(','));
					}
				
					var csvString = csvRows.join("\r\n");
					var a         = document.createElement('a');
					a.href     = 'data:application/csv;charset=utf-8,' + encodeURIComponent(csvString);
					a.target      = '_blank';
					a.download    = 'myFile.csv';

					document.body.appendChild(a);
					a.click();
					
					message.innerHTML = "</p><div class=\"alert alert-danger\" role=\"alert\">Export done...</div></p>";
			}
        } else 
		{
            message_vmr.innerHTML="<div class=\"alert alert-danger\" role=\"alert\">Have you trusted the RM certificate? Click <a href=\""+ url_init + "/dma7000\">here</a></div>";
			console.error("Something went wrong!" + xhr.status + " " +xhr.readyState);
        }
    }
};
}
  
 
 else
 {
message.innerHTML="<div class=\"alert alert-danger\" role=\"alert\">Fill in all fields</div>"; 
} 

}  
   
function room_to_find()
{
			console.log(document.getElementById("checklist").value);	
			list_part(document.getElementById("checklist").value);	
}
  
function list_part(room_find) {
 dma = document.getElementById('dma').value;
 login = document.getElementById('login').value;
 pass = document.getElementById('password').value;
 list_participants = document.getElementById("list_participants");
 message = document.getElementById("message");
 message_vmr = document.getElementById("message_vmr");
 message_vmr.innerHTML = "";
 message.innerHTML = "";
 
 if(dma && login && pass )
 {
 
  url_init="https://" + dma + ":8443";
  url = url_init + "/api/rest/reservations?start-time=2014-05-01T13:00:00.000-06:00&end-time=2014-12-03T13:00:00.000-06:00";
  
	var xhr = new XMLHttpRequest();
	xhr.open('GET',url);
	auth = make_base_auth(login,pass);
	xhr.setRequestHeader("Authorization", auth);
	xhr.send();
  
  xhr.onreadystatechange = function() {
    if (xhr.readyState === 4) {
        if (xhr.status === 200) {
		
			var items = xhr.responseXML.querySelectorAll("plcm-reservation");
			var name = "";
			
			if(items.length == 0)
			{
				message.innerHTML = "</p><div class=\"alert alert-danger\" role=\"alert\">No reservation.</div></p>";
			}
			else
			{		
				var html_end = "";
				for (var n = 0; n < items.length; n++)
				{
				
				message.innerHTML = "</p><div class=\"alert alert-danger\" role=\"alert\">You have these scheduled conferences involving " + room_find + ". </div></p>";
				
				var html_code="";
				var OK="0";
				var parti = items[n].querySelectorAll(" plcm-reserved-participant");
				html_code = "<div class=\"panel panel-default\"><div class=\"panel-heading\">";
				html_code = html_code + "<strong>" +items[n].getElementsByTagName("name")[0].childNodes[0].nodeValue + "</strong></div><div class=\"panel-body\"><p>";
				html_code = html_code + "<strong>Dial-in number for the conference: </strong>"  + items[n].getElementsByTagName("dial-in-number")[0].childNodes[0].nodeValue + "</p><p><strong>Number of participants: </strong>"  + parti.length + "</p></div><ul class=\"list-group\">";
				
					for (var x = 0; x < parti.length; x++)
					{
						
						if ((parti[x].getElementsByTagName("participant-name")[0].childNodes[0].nodeValue == " " + room_find) || (parti[x].getElementsByTagName("participant-name")[0].childNodes[0].nodeValue == room_find))
						{
							OK = "1";
							//console.log("GOOD");
							html_code = html_code + "<li class=\"list-group-item\"><mark>" + parti[x].getElementsByTagName("participant-name")[0].childNodes[0].nodeValue + "</mark></li>";
						}
						else
						{
							console.log("Not GOOD " + parti[x].getElementsByTagName("participant-name")[0].childNodes[0].nodeValue + " " +room_find);
							html_code = html_code + "<li class=\"list-group-item\">" + parti[x].getElementsByTagName("participant-name")[0].childNodes[0].nodeValue + "</li>";
						}
					}
					html_code = html_code + "</ul></div>"
					if(OK == "1")
					{
						html_end = html_end + html_code;
					}
				}
				
				list_participants.innerHTML = html_end;
			}
        } else 
		{
            message_vmr.innerHTML="<div class=\"alert alert-danger\" role=\"alert\">Have you trusted the RM certificate? Click <a href=\""+ url_init + "/dma7000\">here</a></div>";
			console.error("Something went wrong!" + xhr.status + " " +xhr.readyState);
        }
    }
};
}
  
 
 else
 {
message.innerHTML="<div class=\"alert alert-danger\" role=\"alert\">Fill in all fields</div>"; 
} 
}



function save()
{

dma = document.getElementById('dma').value;
 login = document.getElementById('login').value;
 pass = document.getElementById('password').value;

  message = document.getElementById("message");
		chrome.storage.sync.set({'dma_url_save': dma}, function() {
          // Notify that we saved.
          console.log('Settings saved - dma_url_save');
        });
		 chrome.storage.sync.set({'login_save': login}, function() {
          // Notify that we saved.
          console.log('Settings saved - login_save');
        });
		 chrome.storage.sync.set({'pass_save': pass}, function() {
          // Notify that we saved.
          console.log('Settings saved - pass_save');
        });
		 
		message.innerHTML = "<div class=\"alert alert-success\" role=\"alert\">Well done! Your settings are locally stored. </div>";


}

function retrieve()
{
     message = document.getElementById("message");
	 chrome.storage.sync.get('dma_url_save', function(value) {
      document.getElementById('dma').value = value.dma_url_save;  
	  });
	  chrome.storage.sync.get('login_save', function(value) {
      document.getElementById('login').value = value.login_save;  
	  });
	  chrome.storage.sync.get('pass_save', function(value) {
      document.getElementById('password').value = value.pass_save;  
	  });

	message.innerHTML = "<div class=\"alert alert-success\" role=\"alert\">Well done! Your settings have been retrieved. </div>";


}
	
function init() {
 
 dma = document.getElementById('dma').value;
 login = document.getElementById('login').value;
 pass = document.getElementById('password').value;
 list_participants = document.getElementById("list_participants");
 message = document.getElementById("message");
 message_vmr = document.getElementById("message_vmr");
 message_vmr.innerHTML = "";
 message.innerHTML = "";
 
 if(dma && login && pass )
 {
 
 
  url_init="https://" + dma + ":8443";
  url = url_init + "/api/rest/reservations?start-time=2014-05-01T13:00:00.000-06:00&end-time=2014-12-03T13:00:00.000-06:00";
  
	var xhr = new XMLHttpRequest();
	xhr.open('GET',url);
	auth = make_base_auth(login,pass);
	xhr.setRequestHeader("Authorization", auth);
	xhr.send();
  
  xhr.onreadystatechange = function() {
    if (xhr.readyState === 4) {
        if (xhr.status === 200) {
		
			var items = xhr.responseXML.querySelectorAll("plcm-reservation");
			var name = "";
			
			if(items.length == 0)
			{
				message.innerHTML = "</p><div class=\"alert alert-danger\" role=\"alert\">No reservation.</div></p>";
			}
			else
			{
				message.innerHTML = "</p><div class=\"alert alert-danger\" role=\"alert\">You have " + items.length+ " scheduled conferences.</div></p>";
				var html_code="";

				for (var n = 0; n < items.length; n++)
				{
				var parti = items[n].querySelectorAll(" plcm-reserved-participant");
				html_code = html_code + "<div class=\"panel panel-default\"><div class=\"panel-heading\">";
				html_code = html_code + "<strong>" +items[n].getElementsByTagName("name")[0].childNodes[0].nodeValue + "</strong></div><div class=\"panel-body\"><p>";
				html_code = html_code + "<strong>Dial-in number for the conference: </strong>"  + items[n].getElementsByTagName("dial-in-number")[0].childNodes[0].nodeValue + "</p><p><strong>Number of participants: </strong>"  + parti.length + "</p></div><ul class=\"list-group\">";
				
					for (var x = 0; x < parti.length; x++)
					{
						html_code = html_code + "<li class=\"list-group-item\">" + parti[x].getElementsByTagName("participant-name")[0].childNodes[0].nodeValue + "</li>";
					}
					html_code = html_code + "</ul></div>"
				}
				
				list_participants.innerHTML = html_code;
			}
        } else 
		{
            message_vmr.innerHTML="<div class=\"alert alert-danger\" role=\"alert\">Have you trusted the RM certificate? Click <a href=\""+ url_init + "/dma7000\">here</a></div>";
			console.error("Something went wrong!" + xhr.status + " " +xhr.readyState);
        }
    }
};
}
  
 
 else
 {
message.innerHTML="<div class=\"alert alert-danger\" role=\"alert\">Fill in all fields</div>"; 
} 
  }
})();