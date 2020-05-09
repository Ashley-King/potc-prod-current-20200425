<?php
date_default_timezone_set('UTC');
$today = date("Y-m-d H:i:s"); 
$curl = curl_init();

$subscriber = array(
    'email' => $_POST['email'],
    'name' => $_POST['first_name'],
    'signup_ip' => $_SERVER['REMOTE_ADDR'],
    'signup_timestamp' => $today,
    'type' => 'unconfirmed',
    'fields' => array()
);
  $subscriber = json_encode($subscriber);
curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.mailerlite.com/api/v2/groups/102779702/subscribers",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => $subscriber,
  CURLOPT_HTTPHEADER => array(
    "content-type: application/json",
    "x-mailerlite-apikey: 9d1ccc3d5aeeab47125cf7f2fe048c3"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
   echo "cURL Error #:" . $err;
  
} else {
    echo $response;

  
}
?>