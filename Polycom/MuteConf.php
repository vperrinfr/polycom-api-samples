<?php
$php_dma_host = "";
$php_username = "";
$php_password = "";
$php_room_id = "";
$conf_id = "";
$operation = "";
$chair_ids = array();

if (!empty($_REQUEST['dma_host'])) { $php_dma_host = $_REQUEST['dma_host']; }
if (!empty($_REQUEST['username'])) { $php_username = $_REQUEST['username']; }
if (!empty($_REQUEST['password'])) { $php_password = $_REQUEST['password']; }
if (!empty($_REQUEST['room_id'])) { $php_room_id = $_REQUEST['room_id']; }
if (!empty($_REQUEST['chair_passcode'])) { $php_chair_passcode = $_REQUEST['chair_passcode']; }
if (!empty($_REQUEST['conf_passcode'])) { $php_conf_passcode = $_REQUEST['conf_passcode']; }
if (!empty($_REQUEST['op'])) { $operation = $_REQUEST['op']; }
?>

<html>
<head>
<title>Polycom Conference Management (Vigilante)</title>
</head>
<body bgcolor="white">
<img src='http://www.polycom.com/etc/designs/www/images/polycom_logo.png'>
<br/>
<div style="background-color:#175e92; color: #175e92;font-size: 5px;">&nbsp;</div>
<div style="color: black; font-size: 34px; font-family:verdana">
Polycom Conference Management (Vigilante)</div>
<br />
<form action='' method='post'>
<table style="color: black; width=100%">
<tr>
<td>

<table style="color:black; font-family:verdana">
<tr style="vertical-align:top">
<td>
<table>
<tr><td align='right'>DMA Host:</td><td><input type='text' name='dma_host' value='<?php echo $php_dma_host; ?>'></td></tr>
<tr><td align='right'>Username:</td><td><input type='text' name='username' value='<?php echo $php_username; ?>'></td></tr>
<tr><td align='right'>Password:</td><td><input type='password' name='password' value='<?php echo $php_password; ?>'></td></tr>
<tr><td align='right'>VMR ID:</td><td><input type='text' name='room_id' value='<?php echo $php_room_id; ?>'></td></tr>
<tr><td>&nbsp;</td><td><input type='submit' name='op' value='List Participants'></td></tr>
<tr><td>&nbsp;</td><td><input type='submit' name='op' value='Begin Recording'></td></tr>
<tr><td>&nbsp;</td><td><input type='submit' name='op' value='Lock Conference'></td></tr>
<tr><td>&nbsp;</td><td><input type='submit' name='op' value='Show me the speaker'></td></tr>
<tr><td>&nbsp;</td><td><input type='submit' name='op' value='Mute the spoilsport'></td></tr>


</table>
</td>
<td>
<table>
<tr><td>&nbsp;</td><td><input type='submit' name='op' value='Mute Conf (with chairperson)'> Mute all participants except Chairpersons</td></tr>
<tr><td>&nbsp;</td><td><input type='submit' name='op' value='Mute Conf (by selection)'> Mute all participants except all selected</td></tr>
<tr><td>&nbsp;</td><td><input type='submit' name='op' value='Mute one participant'> Mute the selected participant</td></tr>
<tr><td>&nbsp;</td><td><input type='submit' name='op' value='Unmute one participant'> Unmute the selected participant</td></tr>
<tr><td>&nbsp;</td><td><input type='submit' name='op' value='Unmute Conf'> Unmute all participants</td></tr>

<tr><td>&nbsp;</td><td><input type='submit' name='op' value='End Recording'></td></tr>
<tr><td>&nbsp;</td><td><input type='submit' name='op' value='Unlock Conference'></td></tr>
<tr><td>&nbsp;</td><td><input type='submit' name='op' value='Disconnect someone'> Disconnect the selected participant</td></tr>


</table>
</td>
</tr>
</table>


<?php


if ($operation == "Begin Recording")
{
$response_body = do_get_conf_id($php_dma_host,$php_username,$php_password,$php_room_id);
   if (!empty($response_body))
   {
      $xml = new SimpleXMLElement($response_body);
	  foreach($xml->xpath('//ns4:plcm-conference-list') as $event) {
	  $conf_id = $event->xpath('ns3:plcm-conference')[0]->xpath('ns3:conference-identifier')[0];
	}
	
	do_record($php_dma_host,$php_username,$php_password,$conf_id);
   }
}

if ($operation == "End Recording")
{
$response_body = do_get_conf_id($php_dma_host,$php_username,$php_password,$php_room_id);
   if (!empty($response_body))
   {
      $xml = new SimpleXMLElement($response_body);
	  foreach($xml->xpath('//ns4:plcm-conference-list') as $event) {
	  $conf_id = $event->xpath('ns3:plcm-conference')[0]->xpath('ns3:conference-identifier')[0];
	}
	do_unrecord($php_dma_host,$php_username,$php_password,$conf_id);
   }

}

if ($operation == "Lock Conference")
{
$response_body = do_get_conf_id($php_dma_host,$php_username,$php_password,$php_room_id);
   if (!empty($response_body))
   {
      $xml = new SimpleXMLElement($response_body);
	  foreach($xml->xpath('//ns4:plcm-conference-list') as $event) {
	  $conf_id = $event->xpath('ns3:plcm-conference')[0]->xpath('ns3:conference-identifier')[0];
	}
	do_lock($php_dma_host,$php_username,$php_password,$conf_id);
   }

}

if ($operation == "Unlock Conference")
{
$response_body = do_get_conf_id($php_dma_host,$php_username,$php_password,$php_room_id);
   if (!empty($response_body))
   {
      $xml = new SimpleXMLElement($response_body);
	  foreach($xml->xpath('//ns4:plcm-conference-list') as $event) {
	  $conf_id = $event->xpath('ns3:plcm-conference')[0]->xpath('ns3:conference-identifier')[0];
	}
	do_unlock($php_dma_host,$php_username,$php_password,$conf_id);
   }

}

if ($operation == "Disconnect someone")
{

if(!empty($_POST['check_list'])) {
    foreach($_POST['check_list'] as $check) {
            
			array_push($chair_ids,(string)$check);
    }
	
$response_body = do_get_conf_id($php_dma_host,$php_username,$php_password,$php_room_id);
   if (!empty($response_body))
   {
      $xml = new SimpleXMLElement($response_body);
	  foreach($xml->xpath('//ns4:plcm-conference-list') as $event) {
	  $conf_id = $event->xpath('ns3:plcm-conference')[0]->xpath('ns3:conference-identifier')[0];
	}
	do_disconnect($php_dma_host,$php_username,$php_password,$conf_id, $chair_ids[0]);
   }

sleep(5);
$response_body_list = do_get_list($php_dma_host,$php_username,$php_password,$conf_id);
  
   $xml = new SimpleXMLElement($response_body_list);
   $list = $xml->xpath('//ns3:plcm-participant-list')[0];
    ?>
   <table style="color:black; font-family:verdana; border-style:solid">
   <tr>
		<td align='left'>Participant</td>
		<td align='right'>Audio Muted</td>
		
		<td align='right'>Chairperson</td>
		<td align='right'>Speaker</td>
		<td align='right'>Select</td>
   </tr>
   <?php
   foreach($list->xpath('//ns2:plcm-participant') as $event) {
	  $endpoint_name = $event->xpath('ns2:display-name')[0];
	  $audio_mute = $event->xpath('ns2:audio-mute')[0];
	  $video_mute = $event->xpath('ns2:video-mute')[0];
	  $chairperson = $event->xpath('ns2:chairperson')[0];
	  $chair_id = $event->xpath('ns2:participant-identifier')[0];
	  $speaker = $event->xpath('ns2:speaker')[0];
   ?>  

   <tr>
		<td align='left'><?php echo $endpoint_name; ?></td>
		<td align='center'><?php echo $audio_mute; ?></td>
		<td align='center'><?php echo $chairperson; ?></td>
		<td align='center'><?php echo $speaker; ?></td>
		<td align='center'><input type="checkbox" name="check_list[]" value=<?php echo $chair_id; ?>></td>
   </tr>

	<?php  
	}
    ?> 
	</table>
	<?php 
}
}




if ($operation == "Mute one participant")
{
if(!empty($_POST['check_list'])) {
    foreach($_POST['check_list'] as $check) {
            
			array_push($chair_ids,(string)$check);
    }
	
	$response_body = do_get_conf_id($php_dma_host,$php_username,$php_password,$php_room_id);
   if (!empty($response_body))
   {
      $xml = new SimpleXMLElement($response_body);
	  foreach($xml->xpath('//ns4:plcm-conference-list') as $event) {
	  $conf_id = $event->xpath('ns3:plcm-conference')[0]->xpath('ns3:conference-identifier')[0];
	}
   }
	  
      do_mute_speaker($php_dma_host,$php_username,$php_password,$conf_id, $chair_ids[0]);
}
sleep(5);
$response_body_list = do_get_list($php_dma_host,$php_username,$php_password,$conf_id);
  
   $xml = new SimpleXMLElement($response_body_list);
   $list = $xml->xpath('//ns3:plcm-participant-list')[0];
    ?>
   <table style="color:black; font-family:verdana; border-style:solid">
   <tr>
		<td align='left'>Participant</td>
		<td align='right'>Audio Muted</td>
		
		<td align='right'>Chairperson</td>
		<td align='right'>Speaker</td>
		<td align='right'>Select</td>
   </tr>
   <?php
   foreach($list->xpath('//ns2:plcm-participant') as $event) {
	  $endpoint_name = $event->xpath('ns2:display-name')[0];
	  $audio_mute = $event->xpath('ns2:audio-mute')[0];
	  $video_mute = $event->xpath('ns2:video-mute')[0];
	  $chairperson = $event->xpath('ns2:chairperson')[0];
	  $chair_id = $event->xpath('ns2:participant-identifier')[0];
	  
	  
	  
	  if ((string)$chairperson=="true"){
		array_push($chair_ids,(string)$chair_id);
	  }
	  
	  $speaker = $event->xpath('ns2:speaker')[0];
   ?>  

   <tr>
		<td align='left'><?php echo $endpoint_name; ?></td>
		<td align='center'><?php echo $audio_mute; ?></td>
		<td align='center'><?php echo $chairperson; ?></td>
		<td align='center'><?php echo $speaker; ?></td>
		<td align='center'><input type="checkbox" name="check_list[]" value=<?php echo $chair_id; ?>></td>
   </tr>

	<?php  
	}
    ?> 
	</table>
	<?php 
}

if ($operation == "Unmute one participant")
{
if(!empty($_POST['check_list'])) {
    foreach($_POST['check_list'] as $check) {
           array_push($chair_ids,(string)$check);
    }
	
	$response_body = do_get_conf_id($php_dma_host,$php_username,$php_password,$php_room_id);
   if (!empty($response_body))
   {
      $xml = new SimpleXMLElement($response_body);
	  foreach($xml->xpath('//ns4:plcm-conference-list') as $event) {
	  $conf_id = $event->xpath('ns3:plcm-conference')[0]->xpath('ns3:conference-identifier')[0];
	}
   }
	
      do_unmute_speaker($php_dma_host,$php_username,$php_password,$conf_id, $chair_ids[0]);
	  sleep(5);
}

$response_body_list = do_get_list($php_dma_host,$php_username,$php_password,$conf_id);
  
   $xml = new SimpleXMLElement($response_body_list);
   $list = $xml->xpath('//ns3:plcm-participant-list')[0];
    ?>
   <table style="color:black; font-family:verdana; border-style:solid">
   <tr>
		<td align='left'>Participant</td>
		<td align='right'>Audio Muted</td>
		
		<td align='right'>Chairperson</td>
		<td align='right'>Speaker</td>
		<td align='right'>Select</td>
   </tr>
   <?php
   foreach($list->xpath('//ns2:plcm-participant') as $event) {
	  $endpoint_name = $event->xpath('ns2:display-name')[0];
	  $audio_mute = $event->xpath('ns2:audio-mute')[0];
	  $video_mute = $event->xpath('ns2:video-mute')[0];
	  $chairperson = $event->xpath('ns2:chairperson')[0];
	  $chair_id = $event->xpath('ns2:participant-identifier')[0];
	  
	  
	  
	  if ((string)$chairperson=="true"){
		array_push($chair_ids,(string)$chair_id);
	  }
	  
	  $speaker = $event->xpath('ns2:speaker')[0];
   ?>  

   <tr>
		<td align='left'><?php echo $endpoint_name; ?></td>
		<td align='center'><?php echo $audio_mute; ?></td>
		<td align='center'><?php echo $chairperson; ?></td>
		<td align='center'><?php echo $speaker; ?></td>
		<td align='center'><input type="checkbox" name="check_list[]" value=<?php echo $chair_id; ?>></td>
   </tr>

	<?php  
	}
    ?> 
	</table>
	<?php 
}


if ($operation == "Mute Conf (by selection)")
{
if(!empty($_POST['check_list'])) {
    foreach($_POST['check_list'] as $check) {
            echo $check; 
			array_push($chair_ids,(string)$check);
    }
	
	$response_body = do_get_conf_id($php_dma_host,$php_username,$php_password,$php_room_id);
   if (!empty($response_body))
   {
      $xml = new SimpleXMLElement($response_body);
	  foreach($xml->xpath('//ns4:plcm-conference-list') as $event) {
	  $conf_id = $event->xpath('ns3:plcm-conference')[0]->xpath('ns3:conference-identifier')[0];
	}
   }
   
   $my_body = "<mute:plcm-conference-mute-all-except-request xmlns:mute=\"urn:com:polycom:api:rest:plcm-conference-mute-all-except-request\"> <mute:excluded-participant-identifier>";

	
		foreach ($chair_ids as &$value) {
			$my_body = $my_body . "<mute:excluded-participant-identifier>" . $value . "</mute:excluded-participant-identifier>";
		}
			$my_body = $my_body . "</mute:excluded-participant-identifier></mute:plcm-conference-mute-all-except-request>";	
	  
      do_mute_all($php_dma_host,$php_username,$php_password,$conf_id, $my_body);
	sleep(5);
}

$response_body_list = do_get_list($php_dma_host,$php_username,$php_password,$conf_id);
  
   $xml = new SimpleXMLElement($response_body_list);
   $list = $xml->xpath('//ns3:plcm-participant-list')[0];
    ?>
   <table style="color:black; font-family:verdana; border-style:solid">
   <tr>
		<td align='left'>Participant</td>
		<td align='right'>Audio Muted</td>
		
		<td align='right'>Chairperson</td>
		<td align='right'>Speaker</td>
		<td align='right'>Select</td>
   </tr>
   <?php
   foreach($list->xpath('//ns2:plcm-participant') as $event) {
	  $endpoint_name = $event->xpath('ns2:display-name')[0];
	  $audio_mute = $event->xpath('ns2:audio-mute')[0];
	  $video_mute = $event->xpath('ns2:video-mute')[0];
	  $chairperson = $event->xpath('ns2:chairperson')[0];
	  $chair_id = $event->xpath('ns2:participant-identifier')[0];
	  
	  
	  
	  if ((string)$chairperson=="true"){
		array_push($chair_ids,(string)$chair_id);
	  }
	  
	  $speaker = $event->xpath('ns2:speaker')[0];
   ?>  

   <tr>
		<td align='left'><?php echo $endpoint_name; ?></td>
		<td align='center'><?php echo $audio_mute; ?></td>
		<td align='center'><?php echo $chairperson; ?></td>
		<td align='center'><?php echo $speaker; ?></td>
		<td align='center'><input type="checkbox" name="check_list[]" value=<?php echo $chair_id; ?>></td>
   </tr>

	<?php  
	}
    ?> 
	</table>
	<?php 
}

if ($operation == "List Participants")
{
   $response_body = do_get_conf_id($php_dma_host,$php_username,$php_password,$php_room_id);
   if (!empty($response_body))
   {
      $xml = new SimpleXMLElement($response_body);
	  foreach($xml->xpath('//ns4:plcm-conference-list') as $event) {
	  $conf_id = $event->xpath('ns3:plcm-conference')[0]->xpath('ns3:conference-identifier')[0];
	}
   }
   
   $response_body_list = do_get_list($php_dma_host,$php_username,$php_password,$conf_id);
  
   $xml = new SimpleXMLElement($response_body_list);
   $list = $xml->xpath('//ns3:plcm-participant-list')[0];
    ?>
   <table style="color:black; font-family:verdana; border-style:solid">
   <tr style="color:red; font-family:verdana; border-style:solid">
		<td align='left'>Participant</td>
		<td align='right'>Audio Muted</td>
		
		<td align='right'>Chairperson</td>
		<td align='right'>Speaker</td>
		<td align='right'>Select</td>
   </tr>
   <?php
   foreach($list->xpath('//ns2:plcm-participant') as $event) {
	  $endpoint_name = $event->xpath('ns2:display-name')[0];
	  $audio_mute = $event->xpath('ns2:audio-mute')[0];
	  $video_mute = $event->xpath('ns2:video-mute')[0];
	  $chairperson = $event->xpath('ns2:chairperson')[0];
	  $chair_id = $event->xpath('ns2:participant-identifier')[0];
	  
	  
	  
	  if ((string)$chairperson=="true"){
		array_push($chair_ids,(string)$chair_id);
	  }
	  
	  $speaker = $event->xpath('ns2:speaker')[0];
   ?>  

   <tr>
		<td align='left'><?php echo $endpoint_name; ?></td>
		<td align='center'><?php echo $audio_mute; ?></td>
		<td align='center'><?php echo $chairperson; ?></td>
		<td align='center'><?php echo $speaker; ?></td>
		<td align='center'><input type="checkbox" name="check_list[]" value=<?php echo $chair_id; ?>></td>
   </tr>

	<?php  
	}
    ?> 
	</table>
	<?php 
}

if ($operation == "Mute Conf (with chairperson)")
{
   $response_body = do_get_conf_id($php_dma_host,$php_username,$php_password,$php_room_id);
   if (!empty($response_body))
   {
      $xml = new SimpleXMLElement($response_body);
	  foreach($xml->xpath('//ns4:plcm-conference-list') as $event) {
	  $conf_id = $event->xpath('ns3:plcm-conference')[0]->xpath('ns3:conference-identifier')[0];
	}
   }
   
   $response_body_list = do_get_list($php_dma_host,$php_username,$php_password,$conf_id);
  
   $xml = new SimpleXMLElement($response_body_list);
   $list = $xml->xpath('//ns3:plcm-participant-list')[0];
    ?>
   <table style="color:black; font-family:verdana; border-style:solid">
   <tr style="color:black; font-family:verdana; border-style:solid">
		<td align='left'>Participant</td>
		<td align='right'>Audio Muted</td>
		<td align='right'>Chairperson</td>
		<td align='right'>Speaker</td>
   </tr>
   <?php
   foreach($list->xpath('//ns2:plcm-participant') as $event) {
	  $endpoint_name = $event->xpath('ns2:display-name')[0];
	  $audio_mute = $event->xpath('ns2:audio-mute')[0];
	  $video_mute = $event->xpath('ns2:video-mute')[0];
	  $chairperson = $event->xpath('ns2:chairperson')[0];
	  $chair_id = $event->xpath('ns2:participant-identifier')[0];  
	  if ((string)$chairperson=="true"){
		array_push($chair_ids,(string)$chair_id);
	  }
	  $speaker = $event->xpath('ns2:speaker')[0];
   ?>  
   <tr>
		<td align='left'><?php echo $endpoint_name; ?></td>
		<td align='center'><?php echo $audio_mute; ?></td>
		<td align='center'><?php echo $chairperson; ?></td>
		<td align='center'><?php echo $speaker; ?></td>
		
   </tr>
	<?php  
	}
    ?> 
	</table>
	<?php 

	$my_body = "<mute:plcm-conference-mute-all-except-request xmlns:mute=\"urn:com:polycom:api:rest:plcm-conference-mute-all-except-request\"> <mute:excluded-participant-identifier>";

	
		foreach ($chair_ids as &$value) {
			$my_body = $my_body . "<mute:excluded-participant-identifier>" . $value . "</mute:excluded-participant-identifier>";
		}
			$my_body = $my_body . "</mute:excluded-participant-identifier></mute:plcm-conference-mute-all-except-request>";	
	  
      do_mute_all($php_dma_host,$php_username,$php_password,$conf_id, $my_body);
}

if ($operation == "Unmute Conf")
{
   $response_body = do_get_conf_id($php_dma_host,$php_username,$php_password,$php_room_id);
   if (!empty($response_body))
   {
      $xml = new SimpleXMLElement($response_body);
	  foreach($xml->xpath('//ns4:plcm-conference-list') as $event) {
	  $conf_id = $event->xpath('ns3:plcm-conference')[0]->xpath('ns3:conference-identifier')[0];
	}
	do_unmute_all($php_dma_host,$php_username,$php_password,$conf_id);
	sleep(5);
   }

   $response_body_list = do_get_list($php_dma_host,$php_username,$php_password,$conf_id);
  
   $xml = new SimpleXMLElement($response_body_list);
   $list = $xml->xpath('//ns3:plcm-participant-list')[0];
    ?>
   <table style="color:black; font-family:verdana; border-style:solid">
   <tr style="color:black; font-family:verdana; border-style:solid">
		<td align='left'>Participant</td>
		<td align='right'>Audio Muted</td>
		
		<td align='right'>Chairperson</td>
		<td align='right'>Speaker</td>
   </tr>
   <?php
   foreach($list->xpath('//ns2:plcm-participant') as $event) {
	  $endpoint_name = $event->xpath('ns2:display-name')[0];
	  $audio_mute = $event->xpath('ns2:audio-mute')[0];
	  $video_mute = $event->xpath('ns2:video-mute')[0];
	  $chairperson = $event->xpath('ns2:chairperson')[0];
	  $chair_id = $event->xpath('ns2:participant-identifier')[0];
	  
	  	  
	  if ((string)$chairperson=="true"){
		array_push($chair_ids,(string)$chair_id);
	  }
	  
	  $speaker = $event->xpath('ns2:speaker')[0];
   ?>  

   <tr>
		<td align='left'><?php echo $endpoint_name; ?></td>
		<td align='center'><?php echo $audio_mute; ?></td>
		
		<td align='center'><?php echo $chairperson; ?></td>
		<td align='center'><?php echo $speaker; ?></td>
   </tr>

	<?php  
	}
    ?> 
	</table>
	<?php 

      
}

function do_get_conf_id($host, $username, $password, $room_id)
{
   if (!empty($host) && !empty($username) && !empty($password) && !empty($room_id))
   {
      $ch = curl_init();
      $url = "https://$host:8443/api/rest/conferences/?conference-room-identifier=$room_id";
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
      curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
      $response_body = curl_exec($ch);
      $info = curl_getinfo($ch);
      $error = curl_error($ch);
      if (curl_errno($ch))
      {
         $error_msg = curl_error($ch);
      }
      curl_close($ch);

      if ($info['http_code'] == 200)
      { 
		 return $response_body;
      }
      else if ($info['http_code'] == 401)
      {
         echo "Username/password not valid.";
      }
      else if ($info['http_code'] == 403)
      {
         echo "Username/password valid, but not permitted.";
      }
      else if ($info['http_code'] == 404)
      {
         echo "Conference room [$room_id] not found.";
      }
      else
      {
         echo "[".$info['http_code']."]: $response_body";
      }
   }
   else
   {
      echo "Please provide host, username, password, and room ID.";
   }
}


function do_get_list($host, $username, $password, $conf_id)
{

      $ch = curl_init();
      $url = "https://$host:8443/api/rest/conferences/$conf_id/participants";
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
      curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
      $response_body = curl_exec($ch);
      $info = curl_getinfo($ch);
      $error = curl_error($ch);
      if (curl_errno($ch))
      {
         $error_msg = curl_error($ch);
      }
      curl_close($ch);

      if ($info['http_code'] == 200)
      { 
		 return $response_body;
      }
      else if ($info['http_code'] == 401)
      {
         echo "Username/password not valid.";
      }
      else if ($info['http_code'] == 403)
      {
         echo "Username/password valid, but not permitted.";
      }
      else if ($info['http_code'] == 404)
      {
         echo "Conference room [$room_id] not found.";
      }
      else
      {
         echo "[".$info['http_code']."]: $response_body";
      }
   
   
}


function do_mute_all($host, $username, $password, $room_id, $xml_body)
{

	
      $ch = curl_init();
      $url = "https://$host:8443/api/rest/conferences/$room_id/mute-all-except";
	 
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
      curl_setopt($ch, CURLOPT_URL, $url);
	  curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_body);
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/vnd.plcm.plcm-conference-mute-all-except-request+xml', 'Content-Length: '.strlen($xml_body)));
      curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
      curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
      $response_body = curl_exec($ch);
      $info = curl_getinfo($ch);
      $error = curl_error($ch);

      if (curl_errno($ch))
      {
         $error_msg = curl_error($ch);
      }
      curl_close($ch);

      if ($info['http_code'] == 204)
      {
         echo "";
      }
      else if ($info['http_code'] == 403)
      {
         echo "Username/password valid, but not permitted.";
      }
      
   
}

function do_unmute_all($host, $username, $password, $room_id)
{
      $ch = curl_init();
      $url = "https://$host:8443/api/rest/conferences/$room_id/unmute-all";
	 
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
      curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
      $response_body = curl_exec($ch);
      $info = curl_getinfo($ch);
      $error = curl_error($ch);

      if (curl_errno($ch))
      {
         $error_msg = curl_error($ch);
      }
      curl_close($ch);

      if ($info['http_code'] == 204)
      {
         echo "";
      }
      else if ($info['http_code'] == 403)
      {
         echo "Username/password valid, but not permitted.";
      }  
}

function do_mute_speaker($host, $username, $password, $room_id,$participant_id)
{
      $ch = curl_init();
      $url = "https://$host:8443/api/rest/conferences/$room_id/participants/$participant_id/mute-audio";
	 
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
      curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
      $response_body = curl_exec($ch);
      $info = curl_getinfo($ch);
      $error = curl_error($ch);
      if (curl_errno($ch))
      {
         $error_msg = curl_error($ch);
      }
      curl_close($ch);

      if ($info['http_code'] == 204)
      {
         echo "";
      }
      else if ($info['http_code'] == 403)
      {
         echo "Username/password valid, but not permitted.";
      }  
}

function do_unmute_speaker($host, $username, $password, $room_id,$participant_id)
{
      $ch = curl_init();
      $url = "https://$host:8443/api/rest/conferences/$room_id/participants/$participant_id/unmute-audio";
	 
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
      curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
      $response_body = curl_exec($ch);
      $info = curl_getinfo($ch);
      $error = curl_error($ch);
      if (curl_errno($ch))
      {
         $error_msg = curl_error($ch);
      }
      curl_close($ch);

      if ($info['http_code'] == 204)
      {
         echo "";
      }
      else if ($info['http_code'] == 403)
      {
         echo "Username/password valid, but not permitted.";
      }  
}

function do_record($host, $username, $password, $room_id)
{
      $ch = curl_init();
      $url = "https://$host:8443/api/rest/conferences/$room_id/start-recording";
	 
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
      curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
      $response_body = curl_exec($ch);
      $info = curl_getinfo($ch);
      $error = curl_error($ch);
      if (curl_errno($ch))
      {
         $error_msg = curl_error($ch);
      }
      curl_close($ch);

      if ($info['http_code'] == 204)
      {
         echo "Recording Started";
      }
      else if ($info['http_code'] == 403)
      {
         echo "Username/password valid, but not permitted.";
      }  
}

function do_unrecord($host, $username, $password, $room_id)
{
      $ch = curl_init();
      $url = "https://$host:8443/api/rest/conferences/$room_id/stop-recording";
	 
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
      curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
      $response_body = curl_exec($ch);
      $info = curl_getinfo($ch);
      $error = curl_error($ch);
      if (curl_errno($ch))
      {
         $error_msg = curl_error($ch);
      }
      curl_close($ch);

      if ($info['http_code'] == 204)
      {
         echo "Recording ended";
      }
      else if ($info['http_code'] == 403)
      {
         echo "Username/password valid, but not permitted.";
      }  
}


function do_lock($host, $username, $password, $room_id)
{
      $ch = curl_init();
      $url = "https://$host:8443/api/rest/conferences/$room_id/lock-conference";
	 
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
      curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
      $response_body = curl_exec($ch);
      $info = curl_getinfo($ch);
      $error = curl_error($ch);
      if (curl_errno($ch))
      {
         $error_msg = curl_error($ch);
      }
      curl_close($ch);

      if ($info['http_code'] == 204)
      {
         echo "Conference was locked successfully.";
      }
      else if ($info['http_code'] == 403)
      {
         echo "Username/password valid, but not permitted.";
      }  
}

function do_unlock($host, $username, $password, $room_id)
{
      $ch = curl_init();
      $url = "https://$host:8443/api/rest/conferences/$room_id/unlock-conference";
	 
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
      curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
      $response_body = curl_exec($ch);
      $info = curl_getinfo($ch);
      $error = curl_error($ch);
      if (curl_errno($ch))
      {
         $error_msg = curl_error($ch);
      }
      curl_close($ch);

      if ($info['http_code'] == 204)
      {
         echo " 	Conference was unlocked successfully.";
      }
      else if ($info['http_code'] == 403)
      {
         echo "Username/password valid, but not permitted.";
      }  
}


function do_disconnect($host, $username, $password, $room_id,$participant_id)
{
      $ch = curl_init();
      $url = "https://$host:8443/api/rest/conferences/$room_id/participants/$participant_id/disconnect";
	 
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
      curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
      $response_body = curl_exec($ch);
      $info = curl_getinfo($ch);
      $error = curl_error($ch);
      if (curl_errno($ch))
      {
         $error_msg = curl_error($ch);
      }
      curl_close($ch);

      if ($info['http_code'] == 204)
      {
         echo "Participant disconnected.";
      }
      else if ($info['http_code'] == 403)
      {
         echo "Username/password valid, but not permitted.";
      } 
	  else if ($info['http_code'] == 403)
      {
         echo "Participant not found.";
      } 
	  else
	  {
		echo "Error" . $info['http_code'];
	  }
}

function do_display_message($host, $username, $password, $room_id,$display_text)
{
      $ch = curl_init();
      $url = "https://$host:8443/api/rest/conferences/$room_id/set-display-text/$display_text";
	 echo $url;
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
      curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
      $response_body = curl_exec($ch);
      $info = curl_getinfo($ch);
      $error = curl_error($ch);
      if (curl_errno($ch))
      {
         $error_msg = curl_error($ch);
      }
      curl_close($ch);

      if ($info['http_code'] == 204)
      {
         echo "";
      }
      else if ($info['http_code'] == 403)
      {
         echo "Username/password valid, but not permitted.";
      }  
}

?>



<?php
if ($operation == "Show me the speaker")
{
   $response_body = do_get_conf_id($php_dma_host,$php_username,$php_password,$php_room_id);
   if (!empty($response_body))
   {
      $xml = new SimpleXMLElement($response_body);
	  foreach($xml->xpath('//ns4:plcm-conference-list') as $event) {
	  $conf_id = $event->xpath('ns3:plcm-conference')[0]->xpath('ns3:conference-identifier')[0];
	}
   }
   
   $response_body_list = do_get_list($php_dma_host,$php_username,$php_password,$conf_id);
  
   $xml = new SimpleXMLElement($response_body_list);
   $list = $xml->xpath('//ns3:plcm-participant-list')[0];

   foreach($list->xpath('//ns2:plcm-participant') as $event) {
	$who_speaks = "";
	 $speaker = $event->xpath('ns2:speaker')[0];
	if ((string)$speaker=="true"){
		$who_speaks = $event->xpath('ns2:display-name')[0];
		?>  
		<table>
			<TR>
					<td align='center'>The spoilsport is <?php echo $who_speaks; ?></td>
					</tr>
			</table>
			<?php 
		
	  }

	}
}
?>

<?php
if ($operation == "Mute the spoilsport")
{
   $response_body = do_get_conf_id($php_dma_host,$php_username,$php_password,$php_room_id);
   if (!empty($response_body))
   {
      $xml = new SimpleXMLElement($response_body);
	  foreach($xml->xpath('//ns4:plcm-conference-list') as $event) {
	  $conf_id = $event->xpath('ns3:plcm-conference')[0]->xpath('ns3:conference-identifier')[0];
	}
   }
   
   $response_body_list = do_get_list($php_dma_host,$php_username,$php_password,$conf_id);
  
   $xml = new SimpleXMLElement($response_body_list);
   $list = $xml->xpath('//ns3:plcm-participant-list')[0];
   
   foreach($list->xpath('//ns2:plcm-participant') as $event) {
	$who_speaks = "";
	 $speaker = $event->xpath('ns2:speaker')[0];
	if ((string)$speaker=="true"){
		$who_speaks = $event->xpath('ns2:display-name')[0];
		$participant_id = $event->xpath('ns2:participant-identifier')[0];
		$display_text = "The spoilsport is" . $who_speaks . ", he has been muted"; 
		do_mute_speaker($php_dma_host,$php_username,$php_password, $conf_id,$participant_id);
		do_display_message($php_dma_host,$php_username,$php_password, $conf_id, $display_text);
		
		?>  
			<table>
			<TR>
				<td align='center'><?php echo $who_speaks; ?> has been muted :) </td>
			</tr>
			</table>
	<?php 
	  }
	}
}
?>

</td>
</tr>
</table>
</form>
</body>
</html>