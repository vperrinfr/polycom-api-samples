<?php
$php_gs_host = "";
$php_string = "";
$php_speed = "";
$php_type = "";
$operation = "";

if (!empty($_REQUEST['gs_host'])) { $php_gs_host = $_REQUEST['gs_host']; }
if (!empty($_REQUEST['string'])) { $php_string = $_REQUEST['string']; }
if (!empty($_REQUEST['speed'])) { $php_speed = $_REQUEST['speed']; }
if (!empty($_REQUEST['type'])) { $php_type = $_REQUEST['type']; }
if (!empty($_REQUEST['op'])) { $operation = $_REQUEST['op']; }
?>

<html>
<head>
<title>Group Series Dialer</title>
</head>
<body bgcolor="white">
<img src='http://www.polycom.com/etc/designs/www/images/polycom_logo.png'>
<br/>
<div style="background-color:#175e92; color: #175e92;font-size: 5px;">&nbsp;</div>
<div style="color: black; font-size: 34px; font-family:verdana">
Group Series Dialer</div>
<br />
<form action='' method='post'>
<table style="color:black; font-family:verdana">
<tr><td align='right'>Group Series IP address:</td><td><input type='text' name='gs_host' value='<?php echo $php_gs_host; ?>'></td></tr>
<tr><td align='right'>Dial String:</td><td><input type='text' name='string' value='<?php echo $php_string; ?>'></td></tr>
<tr><td align='right'>Call Speed:</td><td><input type='text' name='speed' value='<?php echo $php_speed; ?>'> Hint: Enter 0, 384, 512 or 1024</td></tr>
<tr><td align='right'>Call Type:</td><td><input type='text' name='type' value='<?php echo $php_type; ?>'> Hint: Enter AUTO, SIP or H323 </td></tr>
<tr><td>&nbsp;</td><td><input type='submit' name='op' value='Call'></td></tr>
</table>
</form>

<?php

if ($operation == "Call")
{
         do_put($php_gs_host,$php_string,$php_speed,$php_type);
}

function do_put($host, $string, $speed, $type)
{

   if (!empty($host) && !empty($string) && !empty($type))
   {
      $put_body="";
	  $dial ="address=$string&dialType=$type&rate=$speed";
	  
      $ch = curl_init();
      $url = "https://$host/rest/conferences";
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
      curl_setopt($ch, CURLOPT_POSTFIELDS, $dial);
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded', 'Content-Length: '.strlen($dial)));
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
      $response_body = curl_exec($ch);
      $info = curl_getinfo($ch);
      $error = curl_error($ch);
      if (curl_errno($ch))
      {
         $error_msg = curl_error($ch);
      }
      curl_close($ch);

      if ($info['http_code'] == 201)
      {
         echo "Call successful.";
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
         echo "error: [".$info['http_code']."]: $error_msg: $response_body";
      }
   }
   else
   {
      echo "Provide IP address, Dial String, Speed or Call type";
   }
}
?>

</body>
</html>
