<?php
$php_dma_host = "";
$php_username = "polycom\\vperrin";
$php_password = "WXC098poi";
$php_room_id = "76331969";
$conf_id = "";
$operation = "";
$chair_ids = array();

function startsWith($haystack, $needle) {
    return substr($haystack, 0, strlen($needle)) === $needle;
}

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

<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Polycom Conference Management App">
    <meta name="author" content="Vincent Perrin">
    <link rel="icon" href="http://www.polycom.co.uk/etc/polycom/www/global/images/favicon.ico">

<title>Polycom Conference Management (Vigilante)</title>
    <!-- Bootstrap core CSS -->
    <link href="./css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap theme -->
    <link href="./css/bootstrap-theme.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="theme.css" rel="stylesheet">
</head>
<body role="document" >

  <!-- Fixed navbar -->
    <div class="navbar navbar-default" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <a class="navbar-brand" href="#">Polycom Conference Management (Vigilante)</a>
        </div>
      </div>
    </div>

<div class="container theme-showcase" role="main">

<form action='' method='post' >
<div class="form-group">
DMA Host:<input type='text' name='dma_host' class="form-control" placeholder="IP address" value='<?php echo $php_dma_host; ?>'>
Username:<input type='text' name='username' class="form-control" placeholder="domain\username" value='<?php echo $php_username; ?>'>
Password:<input type='password' name='password' class="form-control" placeholder="" value='<?php echo $php_password; ?>'>
VMR ID:<input type='text' name='room_id' class="form-control" placeholder="Start wih 76 or 86" value='<?php echo $php_room_id; ?>'>
</div>
<p>
<div class="btn-group">
<input type='submit' name='op' value='List Participants' class="btn btn-info">
</div>
</p>
<p>
<div class="btn-group">
<input type='submit' name='op' value='Begin Recording' class="btn btn-success">
<input type='submit' name='op' value='End Recording' class="btn btn-success">
</div>
<div class="btn-group">
<input type='submit' name='op' value='Lock Conference' class="btn btn-success">
<input type='submit' name='op' value='Unlock Conference' class="btn btn-success">
</div>
</p>
<div class="btn-group">
<input type='submit' name='op' value='Disconnect someone' class="btn btn-danger">
</div>
</p>
<div class="btn-group">
<input type='submit' name='op' value='Show me the speaker' class="btn btn-primary">
<input type='submit' name='op' value='Mute the spoilsport' class="btn btn-danger">
</div>
</p>
<div class="btn-group">
<input type='submit' name='op' value='Mute one participant' class="btn btn-warning">
<input type='submit' name='op' value='Mute Conf (with chairperson)' class="btn btn-warning"> 
<input type='submit' name='op' value='Mute Conf (by selection)' class="btn btn-warning"> 
</div>
</p>
<div class="btn-group">
<input type='submit' name='op' value='Unmute one participant'class="btn btn-warning">
<input type='submit' name='op' value='Unmute Conf' class="btn btn-warning">
</div>
</p>


<?php

if ($operation == "Begin Recording")
{
// To remove the VMR prefix
	if(startsWith($php_room_id,"76"))
	{
		
		$php_room_id = substr($php_room_id,2);
	}
	if(startsWith($php_room_id,"86"))
	{
		
		$php_room_id = substr($php_room_id,2);
	}
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
// To remove the VMR prefix
	if(startsWith($php_room_id,"76"))
	{
		
		$php_room_id = substr($php_room_id,2);
	}
	if(startsWith($php_room_id,"86"))
	{
		
		$php_room_id = substr($php_room_id,2);
	}
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
// To remove the VMR prefix
	if(startsWith($php_room_id,"76"))
	{
		
		$php_room_id = substr($php_room_id,2);
	}
	if(startsWith($php_room_id,"86"))
	{
		
		$php_room_id = substr($php_room_id,2);
	}
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
// To remove the VMR prefix
	if(startsWith($php_room_id,"76"))
	{
		
		$php_room_id = substr($php_room_id,2);
	}
	if(startsWith($php_room_id,"86"))
	{
		
		$php_room_id = substr($php_room_id,2);
	}
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
 echo "TOTO 1 ";
// To remove the VMR prefix
	if(startsWith($php_room_id,"76"))
	{
		
		$php_room_id = substr($php_room_id,2);
	}
	if(startsWith($php_room_id,"86"))
	{
		
		$php_room_id = substr($php_room_id,2);
	}
	
if(!empty($_POST['check_list'])) {
    echo "TOTO";
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
   <div class="row">
   <div class="col-md-6">
   <table class="table table-striped">
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
	</div>
	</div>
	<?php 
}
}




if ($operation == "Mute one participant")
{

// To remove the VMR prefix
	if(startsWith($php_room_id,"76"))
	{
		
		$php_room_id = substr($php_room_id,2);
	}
	if(startsWith($php_room_id,"86"))
	{
		
		$php_room_id = substr($php_room_id,2);
	}

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
   <div class="row">
   <div class="col-md-6">
   <table class="table table-striped">
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
	</div>
	</div>
	<?php 
}

if ($operation == "Unmute one participant")
{

// To remove the VMR prefix
	if(startsWith($php_room_id,"76"))
	{
		
		$php_room_id = substr($php_room_id,2);
	}
	if(startsWith($php_room_id,"86"))
	{
		
		$php_room_id = substr($php_room_id,2);
	}

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
   <div class="row">
   <div class="col-md-6">
   <table class="table table-striped">
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
	</div>
	</div>
	<?php 
}


if ($operation == "Mute Conf (by selection)")
{

// To remove the VMR prefix
	if(startsWith($php_room_id,"76"))
	{
		
		$php_room_id = substr($php_room_id,2);
	}
	if(startsWith($php_room_id,"86"))
	{
		
		$php_room_id = substr($php_room_id,2);
	}

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
   <div class="row">
   <div class="col-md-6">
   <table class="table table-striped">
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
	</div>
	</div>
	<?php 
}

if ($operation == "List Participants")
{
	
	// To remove the VMR prefix
	if(startsWith($php_room_id,"76"))
	{
		
		$php_room_id = substr($php_room_id,2);
	}
	if(startsWith($php_room_id,"86"))
	{
		
		$php_room_id = substr($php_room_id,2);
	}


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
	 
	 
   <div class="row">
   <div class="col-md-6">
   <table class="table table-striped">
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
	</div>
	</div>
	<?php 
}



if ($operation == "Mute Conf (with chairperson)")
{

// To remove the VMR prefix
	if(startsWith($php_room_id,"76"))
	{
		
		$php_room_id = substr($php_room_id,2);
	}

	if(startsWith($php_room_id,"86"))
	{
		
		$php_room_id = substr($php_room_id,2);
	}
	
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
   <div class="row">
   <div class="col-md-6">
   <table class="table table-striped">
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
	</div>
	</div>
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

// To remove the VMR prefix
	if(startsWith($php_room_id,"76"))
	{
		
		$php_room_id = substr($php_room_id,2);
	}
	if(startsWith($php_room_id,"86"))
	{
		
		$php_room_id = substr($php_room_id,2);
	}

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
   <div class="row">
   <div class="col-md-6">
   <table class="table table-striped">
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
	</div>
	</div>
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

// To remove the VMR prefix
	if(startsWith($php_room_id,"76"))
	{
		
		$php_room_id = substr($php_room_id,2);
	}
	if(startsWith($php_room_id,"86"))
	{
		
		$php_room_id = substr($php_room_id,2);
	}

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

// To remove the VMR prefix
	
	if(startsWith($php_room_id,"76"))
	{
		
		$php_room_id = substr($php_room_id,2);
	}
	if(startsWith($php_room_id,"86"))
	{
		
		$php_room_id = substr($php_room_id,2);
	}

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

</form>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="./js/bootstrap.min.js"></script>
</body>
</html>