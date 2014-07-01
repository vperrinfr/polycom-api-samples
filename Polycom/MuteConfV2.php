<?php
$php_dma_host = "";
$php_username = "";
$php_password = "";


$mcu_url = "";
$mcu_ip = "";
$mcu_token = "";
$mcu_token_user = "";

$php_username_rmx = "";
$php_password_rmx = "";

$php_room_id = "";
$conf_id = "";
$operation = "";
$chair_ids = array();

if (!empty($_REQUEST['dma_host'])) { $php_dma_host = $_REQUEST['dma_host']; }
if (!empty($_REQUEST['username'])) { $php_username = $_REQUEST['username']; }
if (!empty($_REQUEST['password'])) { $php_password = $_REQUEST['password']; }
if (!empty($_REQUEST['username_rmx'])) { $php_username_rmx = $_REQUEST['username_rmx']; }
if (!empty($_REQUEST['password_rmx'])) { $php_password_rmx = $_REQUEST['password_rmx']; }
if (!empty($_REQUEST['room_id'])) { $php_room_id = $_REQUEST['room_id']; }
if (!empty($_REQUEST['chair_passcode'])) { $php_chair_passcode = $_REQUEST['chair_passcode']; }
if (!empty($_REQUEST['conf_passcode'])) { $php_conf_passcode = $_REQUEST['conf_passcode']; }
if (!empty($_REQUEST['op'])) { $operation = $_REQUEST['op']; }
?>

<html>
<head>
<title>Polycom Conference Management V2(Vigilante)</title>
</head>
<body bgcolor="white">
<img src='http://www.polycom.com/etc/designs/www/images/polycom_logo.png'>
<br/>
<div style="background-color:#175e92; color: #175e92;font-size: 5px;">&nbsp;</div>
<div style="color: black; font-size: 34px; font-family:verdana">
Polycom Conference Management V2(Vigilante)</div>
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
<tr><td align='right'>DMA Admin Username:</td><td><input type='text' name='username' value='<?php echo $php_username; ?>'></td></tr>
<tr><td align='right'>DMA Admin Password:</td><td><input type='password' name='password' value='<?php echo $php_password; ?>'></td></tr>
<tr><td align='right'>RMX Admin Username:</td><td><input type='text' name='username_rmx' value='<?php echo $php_username_rmx; ?>'></td></tr>
<tr><td align='right'>RMX Admin Password:</td><td><input type='password' name='password_rmx' value='<?php echo $php_password_rmx; ?>'></td></tr>
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
	  
	  foreach($xml->xpath('//ns4:plcm-conference-list') as $value){
	  
		foreach($value->xpath('ns3:plcm-conference')[0]->link as $value2)
		{
		$temp =  $value2->attributes()->href;
		if (preg_match('/mcu/',$temp))
		$mcu_url =  $value2->attributes()->href;
		}
	  }

   }
	  
      do_mute_speaker($php_dma_host,$php_username,$php_password,$conf_id, $chair_ids[0]);
	  $response_body_mcu  = retrieve_IP_MCU($php_dma_host, $php_username, $php_password, $mcu_url);
	  //echo htmlspecialchars($response_body_mcu); 
	  if (!empty($response_body_mcu))
     {
		$xml = new SimpleXMLElement($response_body_mcu);
		$mcu_ip = $xml->xpath('ns11:management-ip')[0];
	  }
	  
	  $response_body_rmx = retrieve_rmx_token($mcu_ip, $php_username_rmx, $php_password_rmx,$php_room_id,"");
	  //echo htmlspecialchars($response_body_rmx); 
	  if (!empty($response_body_rmx))
		{
			echo "Good";
		}
}
sleep(2);
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
   <tr style="color:red; font-family:verdana; border-style:solid">
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
   <tr style="color:red; font-family:verdana; border-style:solid">
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



function retrieve_IP_MCU($host, $username, $password, $url)
{
	  $ch = curl_init();
            
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


function retrieve_rmx_token($host, $username, $password,$php_room_id,$who)
{

	$xml_body = " <TRANS_MCU> <TRANS_COMMON_PARAMS> <MCU_TOKEN>-1</MCU_TOKEN>  <MCU_USER_TOKEN>-1</MCU_USER_TOKEN>  </TRANS_COMMON_PARAMS>  <ACTION>  <LOGIN>  <MCU_IP>  <IP>$host</IP>  <LISTEN_PORT>80</LISTEN_PORT>  </MCU_IP>  <USER_NAME>$username</USER_NAME>  <PASSWORD>$password</PASSWORD>  <STATION_NAME>se200</STATION_NAME>  </LOGIN>  </ACTION> </TRANS_MCU>";
      
      $url = "http://$host";
	  $ch_rmx = curl_init();
      curl_setopt($ch_rmx, CURLOPT_CUSTOMREQUEST, "POST");
      curl_setopt($ch_rmx, CURLOPT_URL, $url);
	  curl_setopt($ch_rmx, CURLOPT_POSTFIELDS, $xml_body);
      curl_setopt($ch_rmx, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
      curl_setopt($ch_rmx, CURLOPT_RETURNTRANSFER, TRUE);
      curl_setopt($ch_rmx, CURLOPT_SSL_VERIFYPEER, FALSE);
      $response_body = curl_exec($ch_rmx);
      $info = curl_getinfo($ch_rmx);
      $error = curl_error($ch_rmx);

      if (curl_errno($ch_rmx))
      {
         $error_msg = curl_error($ch_rmx);
      }
      //curl_close($ch_rmx);

      if ($info['http_code'] == 200)
      {
		
		$xml = new SimpleXMLElement($response_body);
		$mcu_token =  $xml->ACTION[0]->LOGIN[0]->MCU_TOKEN;
		
		$xml_body = "<TRANS_CONF_LIST><TRANS_COMMON_PARAMS><MCU_TOKEN>$mcu_token</MCU_TOKEN><MCU_USER_TOKEN>$mcu_token</MCU_USER_TOKEN><MESSAGE_ID>0</MESSAGE_ID></TRANS_COMMON_PARAMS><ACTION><GET_LS><OBJ_TOKEN>-1</OBJ_TOKEN></GET_LS></ACTION></TRANS_CONF_LIST>";

	  curl_setopt($ch_rmx, CURLOPT_POSTFIELDS, $xml_body);
      curl_setopt($ch_rmx, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
      curl_setopt($ch_rmx, CURLOPT_RETURNTRANSFER, TRUE);
      curl_setopt($ch_rmx, CURLOPT_SSL_VERIFYPEER, FALSE);
      $response_body = curl_exec($ch_rmx);
      $info = curl_getinfo($ch_rmx);
      $error = curl_error($ch_rmx);

      if (curl_errno($ch_rmx))
      {
         $error_msg = curl_error($ch_rmx);
      }
      

      if ($info['http_code'] == 200)
      {
         //return $response_body;
		 $xml = new SimpleXMLElement($response_body);
		$conf_list=  $xml->ACTION[0]->GET_LS[0]->CONF_SUMMARY_LS[0];
		
	  foreach($conf_list->CONF_SUMMARY as $conf) {
	  $name_conf = $conf->NAME;
	  $id_conf = $conf->ID;
	  //echo $name_conf." ";
	  $findme = "dma".$php_room_id;
	  $pos = strpos($name_conf, $findme);
	  if ($pos !== false) {
	  	  
		  if($who != ""){
	  $xml_body = "<TRANS_CONF_2> <TRANS_COMMON_PARAMS> <MCU_TOKEN>$mcu_token</MCU_TOKEN> <MCU_USER_TOKEN>$mcu_token</MCU_USER_TOKEN> <SYNC/> </TRANS_COMMON_PARAMS> <ACTION> <SET_MESSAGE_OVERLAY>	<ID>$id_conf</ID><MESSAGE_OVERLAY> <ON>true</ON> <MESSAGE_TEXT>The vigilante has muted $who</MESSAGE_TEXT> <MESSAGE_FONT_SIZE_INT>20</MESSAGE_FONT_SIZE_INT>		 <MESSAGE_COLOR>white_font_on_red_background</MESSAGE_COLOR> <NUM_OF_REPETITIONS>2</NUM_OF_REPETITIONS>	 <MESSAGE_DISPLAY_SPEED>slow</MESSAGE_DISPLAY_SPEED>		 <MESSAGE_DISPLAY_POSITION_INT>50</MESSAGE_DISPLAY_POSITION_INT> <MESSAGE_TRANSPARENCE>40</MESSAGE_TRANSPARENCE> </MESSAGE_OVERLAY>	</SET_MESSAGE_OVERLAY>	</ACTION> </TRANS_CONF_2> ";
	  }
	  else
	  {
	  $xml_body = "<TRANS_CONF_2> <TRANS_COMMON_PARAMS> <MCU_TOKEN>$mcu_token</MCU_TOKEN> <MCU_USER_TOKEN>$mcu_token</MCU_USER_TOKEN> <SYNC/> </TRANS_COMMON_PARAMS> <ACTION> <SET_MESSAGE_OVERLAY>	<ID>$id_conf</ID><MESSAGE_OVERLAY> <ON>true</ON> <MESSAGE_TEXT>The vigilante has muted someone.</MESSAGE_TEXT> <MESSAGE_FONT_SIZE_INT>20</MESSAGE_FONT_SIZE_INT>		 <MESSAGE_COLOR>white_font_on_red_background</MESSAGE_COLOR> <NUM_OF_REPETITIONS>2</NUM_OF_REPETITIONS>	 <MESSAGE_DISPLAY_SPEED>slow</MESSAGE_DISPLAY_SPEED>		 <MESSAGE_DISPLAY_POSITION_INT>50</MESSAGE_DISPLAY_POSITION_INT> <MESSAGE_TRANSPARENCE>40</MESSAGE_TRANSPARENCE> </MESSAGE_OVERLAY>	</SET_MESSAGE_OVERLAY>	</ACTION> </TRANS_CONF_2> ";
	  }
	  
	  curl_setopt($ch_rmx, CURLOPT_POSTFIELDS, $xml_body);
      curl_setopt($ch_rmx, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
      curl_setopt($ch_rmx, CURLOPT_RETURNTRANSFER, TRUE);
      curl_setopt($ch_rmx, CURLOPT_SSL_VERIFYPEER, FALSE);
      $response_body = curl_exec($ch_rmx);
      $info = curl_getinfo($ch_rmx);
      $error = curl_error($ch_rmx);

      if (curl_errno($ch_rmx))
      {
         $error_msg = curl_error($ch_rmx);
      }
      
      if ($info['http_code'] == 200)
      {
	  echo "Message sent";
	  }
	  
	  
	  
	  
	  }// End if POS 
	  else {
	  echo "no the good";
	  }
	}
		
		
      }
      else if ($info['http_code'] == 403)
      {
         echo "Username/password valid, but not permitted.";
      }
	 
      }// If 200
      else if ($info['http_code'] == 403)
      {
         echo "Username/password valid, but not permitted.";
      }
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
	foreach($xml->xpath('//ns4:plcm-conference-list') as $value){
	  
		foreach($value->xpath('ns3:plcm-conference')[0]->link as $value2)
		{
		$temp =  $value2->attributes()->href;
		if (preg_match('/mcu/',$temp))
		$mcu_url =  $value2->attributes()->href;
		}
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
		
		$response_body_mcu  = retrieve_IP_MCU($php_dma_host, $php_username, $php_password, $mcu_url);
		
	  if (!empty($response_body_mcu))
     {
		$xml = new SimpleXMLElement($response_body_mcu);
		$mcu_ip = $xml->xpath('ns11:management-ip')[0];
	  }
	  
	  $response_body_rmx = retrieve_rmx_token($mcu_ip, $php_username_rmx, $php_password_rmx,$php_room_id,$who_speaks);
	  if (!empty($response_body_rmx))
		{
			echo "Good";
		}
		
		
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