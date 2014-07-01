// Copyright 2014 Vincent Perrin
// Use of this source code is governed by a BSD-style license 


function main() {
	console.log("In Main");
	document.querySelector("#button1").addEventListener('click', meetnow, false);
	document.querySelector("#button2").addEventListener('click', schedule, false);
	document.querySelector("#button3").addEventListener('click', user, false);
	document.querySelector("#button4").addEventListener('click', settings, false);
	document.querySelector("#ButtonSetupeConfirm").addEventListener('click', confirm, false);
	document.querySelector("#ButtonScheduleConfirm").addEventListener('click', confirm_schedule, false);
	//document.querySelector("#ButtoncreateConfirm").addEventListener('click', confirm_create, false);
	
	
	var cloudaxis_url = "";
	var login = "";
	var pass = "";
	var X_CA_UserName = "";
	var X_CA_Token = "";
	var meeting_name = "";
	var start_time = "";
	var start_date = "";
	var end_time = "";
	var start_meeting = "";
	var end_meeting = "";
	var conference_id = "";
	var meeting_url = "";
	 
	function meetnow(e) {
	console.log("Meet Now"); 
	
	cloudaxis_url = document.getElementById('cloudaxis_url').value;
	login = document.getElementById('login').value;
	pass = document.getElementById('password').value;
	cloudaxis_url_bkp = localStorage.getItem( 'CAX_url_save' );
	login_bkp = localStorage.getItem( 'login_save' );
	pass_bkp = localStorage.getItem( 'pass_save' );
	
	if (!cloudaxis_url_bkp && !login_bkp && !pass_bkp )
		{
			console.log("No backup");
		
			if (!cloudaxis_url && !login && !pass ) 
			{
			console.log("Enter Values in Settings");
			document.querySelector("#menu").style.display='none'
			document.querySelector("#setup_div").style.display='inline'
			}
			else
			{
				make_auth_meetnow(cloudaxis_url,login,pass);
			}
		}
		else
		{
			make_auth_meetnow(cloudaxis_url_bkp,login_bkp,pass_bkp);
		}
	}
  
	function schedule(e) {
		console.log("Schedule Meeting");  
	document.querySelector("#menu").style.display='none'
	document.querySelector("#schedule_div").style.display='inline'
	
	//make_auth_schedule(cloudaxis_url,login,pass);
	}
	
	function confirm_schedule(e) {
	console.log("confirm_schedule");
	cloudaxis_url = document.getElementById('cloudaxis_url').value;
	login = document.getElementById('login').value;
	pass = document.getElementById('password').value;
	cloudaxis_url_bkp = localStorage.getItem( 'CAX_url_save' );
	login_bkp = localStorage.getItem( 'login_save' );
	pass_bkp = localStorage.getItem( 'pass_save' );
	
	meeting_name = document.getElementById('meeting_name').value;
	start_date = document.getElementById('start_date').value;
	start_time = document.getElementById('start_time').value;
	end_time = document.getElementById('end_time').value;
		
	start_meeting = start_date + "T" + start_time + ":00.000+0000";
	end_meeting = start_date + "T" + end_time + ":00.000+0000";
	
	if (!cloudaxis_url_bkp && !login_bkp && !pass_bkp )
		{
			console.log("No backup");
		
			if (!cloudaxis_url && !login && !pass ) 
			{
			console.log("Enter Values in Settings");
			document.querySelector("#menu").style.display='none'
			document.querySelector("#setup_div").style.display='inline'
			}
			else
			{
				make_auth_schedule(cloudaxis_url,login,pass);
			}
		}
		else
		{
			make_auth_schedule(cloudaxis_url_bkp,login_bkp,pass_bkp);
			
		}
		}
  
	function user(e) {
		console.log("Create User");
		document.querySelector("#menu").style.display='none'
		document.querySelector("#createuser_div").style.display='inline'
	}
  
	function settings(e) {
	console.log("Settings");
	document.querySelector("#menu").style.display='none'
	document.querySelector("#setup_div").style.display='inline'
	cloudaxis_url_bkp = localStorage.getItem( 'CAX_url_save' );
	login_bkp = localStorage.getItem( 'login_save' );
	pass_bkp = localStorage.getItem( 'pass_save' );
	
	cloudaxis_url = document.getElementById('cloudaxis_url').value;
	login = document.getElementById('login').value;
	pass = document.getElementById('password').value;
	
	if (!cloudaxis_url_bkp && !login_bkp && !pass_bkp )
		{
			console.log("Empty Backup");
		}
		else
		{
		
		console.log("Backup");
		document.getElementById('cloudaxis_url').value = cloudaxis_url_bkp;
		document.getElementById('login').value = login_bkp;
		document.getElementById('password').value = pass_bkp;
		}
	}
  
	function confirm(e) {
	console.log("Confirmation");
	document.querySelector("#menu").style.display='inline'
	document.querySelector("#setup_div").style.display='none'
	
	// Get a value saved in a form.
        var CAX_url_save = document.getElementById('cloudaxis_url').value;
		var login_save = document.getElementById('login').value;
		var pass_save = document.getElementById('password').value;
        // Check that there's some code there.
        if (!CAX_url_save && !login_save && !pass_save) {
          console.log('Error: No value specified');
          return;
        }
        // Save it using the Chrome extension storage API.
       		
		localStorage.setItem('CAX_url_save', CAX_url_save);
		localStorage.setItem('login_save', login_save);
		localStorage.setItem('pass_save', pass_save);
	
	
	}

	function post_meetnow()
	{
		console.log("post_meetnow");
			
		
			
			//auth = make_auth(cloudaxis_url,login,pass);
			var today = new Date();
			
			startdate = today.toISOString();
			startdate = startdate.substring(startdate.length-1,startdate) + "+0000";
			console.log(startdate);
			var data = "{" +
			    "\"name\":\"" + "Meet Now from Chrome "+ "\",\n" +
			        "\"description\":\"Ad-hoc Meeting\",\n" +
			        "\"startTime\":\"" + startdate + "\",\n" +
			        "\"endTime\":\""+ "" +"\",\n" +
			        "\"createdBy\":{\"userName\":\"" + X_CA_UserName + "\"},\n" +
				    "\"type\":\"AD_HOC\",\n" +
			    "\"allowMultipleChairperson\": false,\n" +
			    "\"authRequired\": true,\n" +
			    "\"userParticipants\":" + "[{\"userName\":\"" + X_CA_UserName + "\",\"email\":\"vp@p.com\"}]" + "\n"+
			 "}";

				console.log(data);
				url_init="https://" + cloudaxis_url + "/wsp/conferences";
				console.log("URL: " + url_init);
				console.log("X_CA_UserName " + X_CA_UserName);
				console.log("X_CA_Token " + X_CA_Token);
				
				var req = new XMLHttpRequest();
				req.open('POST', url_init);
				req.setRequestHeader("Content-Type","application/vnd.com.polycom.cloudAxis.conference+json");
				req.setRequestHeader ("X-CA-UserName", X_CA_UserName);    
				req.setRequestHeader ("X-CA-Token", X_CA_Token);
				req.withCredentials = false;
				req.send(data);

		 req.onreadystatechange = function() {
			if (req.readyState === 4) {
				if (req.status === 201) {
					
					var jsonResponse = JSON.parse(req.responseText);
					console.log("Url Conf ID" + jsonResponse.self);
					conference_id = jsonResponse.self;
					f_conference_id();
								
				} else {
					console.error("Something went wrong!");
					
				}
			}
			
		}
	  } // End of Post
	
	function make_auth_meetnow(cloudaxis_url,login,pass)
	{
		console.log("Retrieve make_auth_meetnow");
		
		
		
		
		url_init="https://" + cloudaxis_url + "/wsp/auth/login";
		console.log(url_init);
		var data = "{" +
		  		"\"userName\":\"" + login + "\"," +
		  		"\"password\":\"" + pass + "\"" +
		  		"}";
		console.log(data);
		var req = new XMLHttpRequest();
		req.open('POST', url_init);
		req.setRequestHeader("Content-Type","application/vnd.com.polycom.cloudaxis.userauth+json");
		req.withCredentials = false;
		req.send(data);

		req.onreadystatechange = function() {
			if (req.readyState === 4) {
				if (req.status === 200) {
					
					console.error("GOOD !!");
					var jsonResponse = JSON.parse(req.responseText);
					//console.log("Auth" + req.responseText);
					console.log(jsonResponse.userName);
					console.log(jsonResponse.tokenId);
					X_CA_UserName = jsonResponse.userName;
					X_CA_Token = jsonResponse.tokenId;
					post_meetnow();			
				} else {
					console.error("Something went wrong!");	
				}
			}		
		}
	}
	
	function make_auth_schedule(cloudaxis_url,login,pass)
	{
		console.log("Retrieve make_auth_schedule");
		url_init="https://" + cloudaxis_url + "/wsp/auth/login";
		console.log(url_init);
		var data = "{" +
		  		"\"userName\":\"" + login + "\"," +
		  		"\"password\":\"" + pass + "\"" +
		  		"}";
		console.log(data);
		var req = new XMLHttpRequest();
		req.open('POST', url_init);
		req.setRequestHeader("Content-Type","application/vnd.com.polycom.cloudaxis.userauth+json");
		req.withCredentials = false;
		req.send(data);

		req.onreadystatechange = function() {
			if (req.readyState === 4) {
				if (req.status === 200) {
					
					console.error("GOOD !!");
					var jsonResponse = JSON.parse(req.responseText);
					//console.log("Auth" + req.responseText);
					console.log(jsonResponse.userName);
					console.log(jsonResponse.tokenId);
					X_CA_UserName = jsonResponse.userName;
					X_CA_Token = jsonResponse.tokenId;
					post_schedule();	
					
				} else {
					console.error("Something went wrong!");	
				}
			}		
		}
	}
	
	function post_schedule()
	{
		console.log("post_schedule");
			
			
			var data = "{" +
			    "\"name\":\"" + meeting_name + "\",\n" +
			        "\"description\":\"Ad-hoc Meeting\",\n" +
			        "\"startTime\":\"" + start_meeting + "\",\n" +
			        "\"endTime\":\""+ end_meeting +"\",\n" +
			        "\"createdBy\":{\"userName\":\"" + X_CA_UserName + "\"},\n" +
				    "\"type\":\"SCHEDULED\",\n" +
			    "\"allowMultipleChairperson\": false,\n" +
			    "\"authRequired\": true,\n" +
			    "\"userParticipants\":" + "[{\"userName\":\"" + X_CA_UserName + "\",\"email\":\"vp@p.com\"}]" + "\n"+
			 "}";
				console.log(data);
				url_init="https://" + cloudaxis_url + "/wsp/conferences";
				console.log("URL: " + url_init);
				console.log("X_CA_UserName " + X_CA_UserName);
				console.log("X_CA_Token " + X_CA_Token);
				
				var req = new XMLHttpRequest();
				req.open('POST', url_init);
				req.setRequestHeader("Content-Type","application/vnd.com.polycom.cloudAxis.conference+json");
				req.setRequestHeader ("X-CA-UserName", X_CA_UserName);    
				req.setRequestHeader ("X-CA-Token", X_CA_Token);
				req.withCredentials = false;
				req.send(data);

		 req.onreadystatechange = function() {
			if (req.readyState === 4) {
				if (req.status === 201) {
					
					var jsonResponse = JSON.parse(req.responseText);
					console.log("Url Conf ID" + jsonResponse.self);
					conference_id = jsonResponse.self;
					f_conference_id();
								
				} else {
					console.error("Something went wrong!");
					console.log(req.responseText);
				}
			}	
		}
	  } // End of Post
	
	
	// ID for Meetnow
	function f_conference_id()
	{
	console.log("conference_id");
	conference_id = conference_id + "/join"
	console.log("URL Conf " + conference_id);
  
	var xhr = new XMLHttpRequest();
	xhr.open('GET',conference_id);
	xhr.setRequestHeader ("X-CA-UserName", X_CA_UserName);    
	xhr.setRequestHeader ("X-CA-Token", X_CA_Token);	
	xhr.send();
  
  xhr.onreadystatechange = function() {
    if (xhr.readyState === 4) {
        if (xhr.status === 200) {
		
		meeting_url = xhr.responseText;
		console.log("meeting_url: " + meeting_url);
		document.querySelector("#menu").style.display='none'
		document.querySelector("#schedule_div").style.display='none'
		document.getElementById('myAnchor').innerHTML=meeting_url;
		document.getElementById('myAnchor').href=meeting_url;
		document.getElementById('myAnchor').target="_blank";
		document.querySelector("#meetnow_div").style.display='inline'
		
        } else 
		{
            console.error("Something went wrong!");
        }
    }
	console.log("Nom : " + name);
	};
	}
}	  
	  
document.addEventListener('DOMContentLoaded', main);