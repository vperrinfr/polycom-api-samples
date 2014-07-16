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

	// Button listeners
	var mute = document.getElementById('mute');
	mute.addEventListener('click', f_mute, false);
	
	var unmute = document.getElementById('unmute');
	unmute.addEventListener('click', f_unmute, false);
	
	var save_b = document.getElementById('save');
	save_b.addEventListener('click', f_save, false);
	
	var retrieve_b = document.getElementById('retrieve');
	retrieve_b.addEventListener('click', f_retrieve, false);
	
	var participants_b = document.getElementById('participants');
	participants_b.addEventListener('click', f_participants, false);
	
	var your_vmr = document.getElementById('vmr');
	your_vmr.addEventListener('click', f_your_vmr, false);
	
	var begin = document.getElementById('begin');
	begin.addEventListener('click', f_do_record, false);
	var stop = document.getElementById('stop');
	stop.addEventListener('click', f_stop_record, false);
	
	var lock = document.getElementById('lock');
	lock.addEventListener('click', f_lock, false);
	var unlock = document.getElementById('unlock');
	unlock.addEventListener('click', f_unlock, false);
	
	var mute_chair = document.getElementById('mute_chair');
	mute_chair.addEventListener('click', f_mute_chair, false);
	var unmute_all = document.getElementById('unmute_all');
	unmute_all.addEventListener('click', f_unmute_all, false);
	  
	function f_mute( event )
	{
	  if ( event.preventDefault ) event.preventDefault();
	  event.returnValue = false;
	var i=0;
		while(document.getElementById("check_list"+i))
		{
			if(document.getElementById("check_list"+i).checked)
		{console.log("check_list"+i + document.getElementById("check_list"+i).value);
		mute_part(dma, login, pass, conf_id_public, document.getElementById("check_list"+i).value);
		
		}
		i++;
		}
	}
	
	function f_unmute( event )
	{
	  if ( event.preventDefault ) event.preventDefault();
	  event.returnValue = false;
	var i=0;
		while(document.getElementById("check_list"+i))
		{
			if(document.getElementById("check_list"+i).checked)
		{console.log("check_list"+i + document.getElementById("check_list"+i).value);
		unmute_part(dma, login, pass, conf_id_public, document.getElementById("check_list"+i).value);
		
		}
		i++;
		}
	}

	function f_do_record(event)
	{
	  if ( event.preventDefault ) event.preventDefault();
	  event.returnValue = false;
	
		do_record(dma, login, pass, conf_id_public);
		
	}
	
	function f_save(event)
	{
	  if ( event.preventDefault ) event.preventDefault();
	  event.returnValue = false;
	  save();
		
	}
	
	function f_retrieve(event)
	{
	  if ( event.preventDefault ) event.preventDefault();
	  event.returnValue = false;
	  retrieve();
		
	}
	
	function f_mute_chair(event)
	{
	  if ( event.preventDefault ) event.preventDefault();
	  event.returnValue = false;
	  do_mute_chair(dma, login, pass, conf_id_public);
	}
	
	function f_unmute_all(event)
	{
	  if ( event.preventDefault ) event.preventDefault();
	  event.returnValue = false;
	  do_unmute_all(dma, login, pass, conf_id_public);
		
	}
	
	
	
	function f_your_vmr(event)
	{
	  if ( event.preventDefault ) event.preventDefault();
	  event.returnValue = false;
	  vmr();
		
	}
	
	function f_participants(event)
	{
	  if ( event.preventDefault ) event.preventDefault();
	  event.returnValue = false;
	  init();
		
	}
		
	
	function f_lock(event)
	{
	  if ( event.preventDefault ) event.preventDefault();
	  event.returnValue = false;
		lock(dma, login, pass, conf_id_public);
	}
	
	function f_unlock(event)
	{
	  if ( event.preventDefault ) event.preventDefault();
	  event.returnValue = false;
	
		unlock(dma, login, pass, conf_id_public);
		
	}
		
	
	function f_stop_record(event)
	{
	  if ( event.preventDefault ) event.preventDefault();
	  event.returnValue = false;
		stop_record(dma, login, pass, conf_id_public);
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
  
function list_part(dma, user, password, conf_id) {
  
  message_vmr = document.getElementById("message_vmr");
  message = document.getElementById("message");
  message.innerHTML="";
  message_vmr.innerHTML="";
  
  url_init="https://" + dma + ":8443";
  url = url_init + "/api/rest/conferences/" + conf_id + "/participants";
  console.log(url);

	var xhr = new XMLHttpRequest();
	xhr.open('GET',url);
	auth = make_base_auth(user,password);
		xhr.setRequestHeader("Authorization", auth);
	xhr.send();
  
  xhr.onreadystatechange = function() {
    if (xhr.readyState === 4) {
        if (xhr.status === 200) {
		
			var items = xhr.responseXML.getElementsByTagName("plcm-participant");
			var name = "";
			
			var html_code = "<div class=\"row\"> <div class=\"col-md-6\"> <table class=\"table table-striped\">";
			var first_row = "<thead><tr><th align='left'>Participant</th><th align='right'>Audio Muted</th><th align='right'>Chairperson</th><th align='right'>Speaker</th><th align='right'>Select</th></tr></thead><tbody>"
			var last_row = "</tbody></table></div></div>";
			
			
			for (var n = 0; n < items.length; n++) 
			{
			if(name=="")
				{
					name = "<tr><td align='left'>" + items[n].getElementsByTagName("display-name")[0].childNodes[0].nodeValue + "</td><td align='center'>" + items[n].getElementsByTagName("audio-mute")[0].childNodes[0].nodeValue + "</td><td align='center'>" + items[n].getElementsByTagName("chairperson")[0].childNodes[0].nodeValue +"</td><td align='center'>" + items[n].getElementsByTagName("speaker")[0].childNodes[0].nodeValue +"</td><td align='center'><input type=\"checkbox\" id=\"check_list"+n+"\" name=\"check_list"+n+"\" value=\""+ items[n].getElementsByTagName("participant-identifier")[0].childNodes[0].nodeValue + "\"></td></tr>";
				}
				else
				{
					name = name + "<tr><td align='left'>" + items[n].getElementsByTagName("display-name")[0].childNodes[0].nodeValue + "</td><td align='center'>" + items[n].getElementsByTagName("audio-mute")[0].childNodes[0].nodeValue + "</td><td align='center'>" + items[n].getElementsByTagName("chairperson")[0].childNodes[0].nodeValue +"</td><td align='center'>" + items[n].getElementsByTagName("speaker")[0].childNodes[0].nodeValue +"</td><td align='center'><input type=\"checkbox\" id=\"check_list"+n+"\" name=\"check_list"+n+"\" value=\"" + items[n].getElementsByTagName("participant-identifier")[0].childNodes[0].nodeValue + "\"></td></tr>";
				}
				
			}
			console.log(html_code + first_row + name + last_row);
		list_participants.innerHTML = html_code + first_row + name + last_row;
		console.log(list_participants);
		
		} else 
		{
            console.error("Something went wrong!");
        }
    }
};
}

function vmr() {
  
  dma = document.getElementById('dma').value;
  login = document.getElementById('login').value;
  pass = document.getElementById('password').value;
  room_id = document.getElementById("room_id");
  message = document.getElementById("message");
  
   if(dma && login && pass)
 {
	message.innerHTML="";
  
  url_init="https://" + dma + ":8443";
  url = url_init + "/api/rest/conferences/";
  console.log(url);

	var xhr = new XMLHttpRequest();
	xhr.open('GET',url);
	auth = make_base_auth(login,pass);
		xhr.setRequestHeader("Authorization", auth);
	xhr.send();
  
  xhr.onreadystatechange = function() {
    if (xhr.readyState === 4) {
        if (xhr.status === 200) {
		
		console.log(xhr.responseXML);
		var items = xhr.responseXML.querySelectorAll("conference-room-identifier");
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
				message_vmr.innerHTML="<div class=\"alert alert-success\" role=\"alert\">Your VMR: " + name + " </div>";
				}
		
		
		
		} else 
		{
            message_vmr.innerHTML="<div class=\"alert alert-danger\" role=\"alert\">Have you trusted the DMA certificate? Click <a href=\""+ url_init + "/dma7000\">here</a></div>";
        }
    }
};
}
 else
 {
message.innerHTML="<div class=\"alert alert-danger\" role=\"alert\">Fill in all fields</div>"; 
} 

}

function mute_part(dma, user, password, conf_id, part) {
  message_vmr = document.getElementById("message_vmr");
  message = document.getElementById("message");
  message.innerHTML="";
  message_vmr.innerHTML="";
  
  url_init="https://" + dma + ":8443";
  url = url_init + "/api/rest/conferences/" + conf_id + "/participants/" + part + "/mute-audio";
  console.log(url);

	var xhr = new XMLHttpRequest();
	xhr.open('POST',url);
	
	auth = make_base_auth(user,password);
	
	xhr.setRequestHeader("Authorization", auth);
	xhr.withCredentials = true;
	xhr.send();
  
  xhr.onreadystatechange = function() {
    if (xhr.readyState === 4) {
        if (xhr.status === 204) {
		
		list_part(dma, user, password, conf_id);
		message = document.getElementById("message");
		message.innerHTML = "<div class=\"alert alert-success\" role=\"alert\">Well done! You successfully muted someone.</div>";
		} else 
		{
            console.error("Something went wrong!");
        }
    }
};
}

function unmute_part(dma, user, password, conf_id, part) {
  message_vmr = document.getElementById("message_vmr");
  message = document.getElementById("message");
  message.innerHTML="";
  message_vmr.innerHTML="";
  
  url_init="https://" + dma + ":8443";
  url = url_init + "/api/rest/conferences/" + conf_id + "/participants/" + part + "/unmute-audio";
  console.log(url);

	var xhr = new XMLHttpRequest();
	xhr.open('POST',url);
	
	auth = make_base_auth(user,password);
	
	xhr.setRequestHeader("Authorization", auth);
	xhr.withCredentials = true;
	xhr.send();
  
  xhr.onreadystatechange = function() {
    if (xhr.readyState === 4) {
        if (xhr.status === 204) {
		
		list_part(dma, user, password, conf_id);
		message = document.getElementById("message");
		message.innerHTML = "<div class=\"alert alert-success\" role=\"alert\">Well done! You successfully unmuted someone.</div>";
		} else 
		{
            console.error("Something went wrong!");
        }
    }
};
}

function do_mute_chair(dma, user, password, conf_id) {

 message_vmr = document.getElementById("message_vmr");
  message = document.getElementById("message");
  message.innerHTML="";
  message_vmr.innerHTML="";
  
  url_init="https://" + dma + ":8443";
  url = url_init + "/api/rest/conferences/" + conf_id + "/mute-all-audio-except-chair";
  console.log(url);

	var xhr = new XMLHttpRequest();
	xhr.open('POST',url);
	
	auth = make_base_auth(user,password);
	
	xhr.setRequestHeader("Authorization", auth);
	xhr.withCredentials = true;
	xhr.send();
  
  xhr.onreadystatechange = function() {
    if (xhr.readyState === 4) {
        if (xhr.status === 204) {
		
		list_part(dma, user, password, conf_id);
		message = document.getElementById("message");
		message.innerHTML = "<div class=\"alert alert-success\" role=\"alert\">Well done! You have successfully muted all participants except chairpersons.</div>";
		} else 
		{
            console.error("Something went wrong!");
        }
    }
};
}

function do_unmute_all(dma, user, password, conf_id) {

 message_vmr = document.getElementById("message_vmr");
  message = document.getElementById("message");
  message.innerHTML="";
  message_vmr.innerHTML="";
  
  url_init="https://" + dma + ":8443";
  url = url_init + "/api/rest/conferences/" + conf_id + "/unmute-all";
  console.log(url);

	var xhr = new XMLHttpRequest();
	xhr.open('POST',url);
	
	auth = make_base_auth(user,password);
	
	xhr.setRequestHeader("Authorization", auth);
	xhr.withCredentials = true;
	xhr.send();
  
  xhr.onreadystatechange = function() {
    if (xhr.readyState === 4) {
        if (xhr.status === 204) {
		
		list_part(dma, user, password, conf_id);
		message = document.getElementById("message");
		message.innerHTML = "<div class=\"alert alert-success\" role=\"alert\">Well done! You have successfully unmuted all participants.</div>";
		} else 
		{
            console.error("Something went wrong!");
        }
    }
};
}

function do_record(dma, user, password, conf_id) {

 message_vmr = document.getElementById("message_vmr");
  message = document.getElementById("message");
  message.innerHTML="";
  message_vmr.innerHTML="";
  
  url_init="https://" + dma + ":8443";
  url = url_init + "/api/rest/conferences/" + conf_id + "/start-recording";
  console.log(url);

	var xhr = new XMLHttpRequest();
	xhr.open('POST',url);
	
	auth = make_base_auth(user,password);
	
	xhr.setRequestHeader("Authorization", auth);
	xhr.withCredentials = true;
	xhr.send();
  
  xhr.onreadystatechange = function() {
    if (xhr.readyState === 4) {
        if (xhr.status === 204) {
		
		list_part(dma, user, password, conf_id);
		message = document.getElementById("message");
		message.innerHTML = "<div class=\"alert alert-success\" role=\"alert\">Well done! You have successfully started the recording.</div>";
		} else 
		{
            console.error("Something went wrong!");
        }
    }
};
}

function stop_record(dma, user, password, conf_id) {
   message_vmr = document.getElementById("message_vmr");
  message = document.getElementById("message");
  message.innerHTML="";
  message_vmr.innerHTML="";
  
  url_init="https://" + dma + ":8443";
  url = url_init + "/api/rest/conferences/" + conf_id + "/stop-recording";
  console.log(url);

	var xhr = new XMLHttpRequest();
	xhr.open('POST',url);
	
	auth = make_base_auth(user,password);
	xhr.setRequestHeader("Content-type",application/vnd.plcm.plcm-conference-mute-all-except-request+xml);
	xhr.setRequestHeader("Authorization", auth);
	xhr.withCredentials = true;
	xhr.send();
  
  xhr.onreadystatechange = function() {
    if (xhr.readyState === 4) {
        if (xhr.status === 204) {
		
		list_part(dma, user, password, conf_id);
		message = document.getElementById("message");
		message.innerHTML = "<div class=\"alert alert-success\" role=\"alert\">Well done! You have successfully stopped the recording.</div>";
		} else 
		{
            console.error("Something went wrong!");
        }
    }
};
}

 
function lock(dma, user, password, conf_id) {
  message_vmr = document.getElementById("message_vmr");
  message = document.getElementById("message");
  message.innerHTML="";
  message_vmr.innerHTML="";
  
  url_init="https://" + dma + ":8443";
  url = url_init + "/api/rest/conferences/" + conf_id + "/lock-conference";
  console.log(url);

	var xhr = new XMLHttpRequest();
	xhr.open('POST',url);
	
	auth = make_base_auth(user,password);
	
	xhr.setRequestHeader("Authorization", auth);
	xhr.withCredentials = true;
	xhr.send();
  
  xhr.onreadystatechange = function() {
    if (xhr.readyState === 4) {
        if (xhr.status === 204) {
		
		list_part(dma, user, password, conf_id);
		message = document.getElementById("message");
		message.innerHTML = "<div class=\"alert alert-success\" role=\"alert\">Well done! You have successfully locked the conference.</div>";
		} else 
		{
            console.error("Something went wrong!");
        }
    }
};
}


function unlock(dma, user, password, conf_id) {
  message_vmr = document.getElementById("message_vmr");
  message = document.getElementById("message");
  message.innerHTML="";
  message_vmr.innerHTML="";
  
  url_init="https://" + dma + ":8443";
  url = url_init + "/api/rest/conferences/" + conf_id + "/unlock-conference";
  console.log(url);

	var xhr = new XMLHttpRequest();
	xhr.open('POST',url);
	
	auth = make_base_auth(user,password);
	
	xhr.setRequestHeader("Authorization", auth);
	xhr.withCredentials = true;
	xhr.send();
  
  xhr.onreadystatechange = function() {
    if (xhr.readyState === 4) {
        if (xhr.status === 204) {
		
		list_part(dma, user, password, conf_id);
		message = document.getElementById("message");
		message.innerHTML = "<div class=\"alert alert-success\" role=\"alert\">Well done! You have successfully unlocked the conference.</div>";
		} else 
		{
            console.error("Something went wrong!");
        }
    }
};
}

function save()
{

dma = document.getElementById('dma').value;
 login = document.getElementById('login').value;
 pass = document.getElementById('password').value;
 room_id = document.getElementById("room_id").value;
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
		 chrome.storage.sync.set({'room_id_save': room_id}, function() {
          // Notify that we saved.
          console.log('Settings saved - room_id_save');
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
	  chrome.storage.sync.get('room_id_save', function(value) {
      document.getElementById('room_id').value = value.room_id_save;
	  });
	message.innerHTML = "<div class=\"alert alert-success\" role=\"alert\">Well done! Your settings have been retrieved. </div>";


}
	
function init() {
 
 dma = document.getElementById('dma').value;
 login = document.getElementById('login').value;
 pass = document.getElementById('password').value;
 room_id = document.getElementById("room_id").value;
 list_participants = document.getElementById("list_participants");
 message = document.getElementById("message");
 message_vmr = document.getElementById("message_vmr");
 message_vmr.innerHTML = "";
 message.innerHTML = "";
 
 if(dma && login && pass && room_id)
 {
 
 
 if(room_id.startsWith("76"))
 {
	var room_id = room_id.substr(2);
 }
 if(room_id.startsWith("86"))
 {
	var room_id = room_id.substr(2);
 }
 
 
  url_init="https://" + dma + ":8443";
  url = url_init + '/api/rest/conferences/?conference-room-identifier=' + room_id;
  
	var xhr = new XMLHttpRequest();
	xhr.open('GET',url);
	auth = make_base_auth(login,pass);
	xhr.setRequestHeader("Authorization", auth);
	xhr.send();
  
  xhr.onreadystatechange = function() {
    if (xhr.readyState === 4) {
        if (xhr.status === 200) {
		
			var items = xhr.responseXML.querySelectorAll("conference-identifier");
			var name = "";
			
			if(items.length == 0)
			{
				message.innerHTML = "</p><div class=\"alert alert-danger\" role=\"alert\">No on-going meeting.</div></p>";
			}
			
			for (var n = 0; n < items.length; n++) {
				if(name=="")
				{
					name = items[n].textContent;
				}
				else
				{
					name = name + ", " + items[n].textContent;
				}
				list_part(dma, login, pass, name);
				conf_id_public = name;
				console.log("conf_id_public" + conf_id_public);
				}
        } else 
		{
            message_vmr.innerHTML="<div class=\"alert alert-danger\" role=\"alert\">Have you trusted the DMA certificate? Click <a href=\""+ url_init + "/dma7000\">here</a></div>";
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