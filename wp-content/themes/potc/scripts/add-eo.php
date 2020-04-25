<?php 
 $api_key = '5c43be6f-fe62-11e9-be00-06b4694bee2a';
 $list_id = 'bfda8c4a-6105-11e9-9307-06b4694bee2a';
 
 $email_address = $_POST['field_0'];
 $first_name = $_POST['field_1'];
 $last_name = null;
 $fields = (object) array('FirstName' => $first_name, 'LastName' => $last_name);
 $data = array(
   'api_key' => $api_key,
   'email_address' => $email_address,
   'fields' => $fields,
   'status' => 'PENDING',
 );
 $post_fields = json_encode($data);
 $curl = curl_init();

curl_setopt_array($curl, [
   CURLOPT_URL => "https://emailoctopus.com/api/1.5/lists/${list_id}/contacts",
   CURLINFO_HEADER_OUT => true,
   CURLOPT_RETURNTRANSFER => true,
   CURLOPT_POST => true,
   CURLOPT_POSTFIELDS => $post_fields,
   CURLOPT_HTTPHEADER => [
   'Content-Type: application/json'
   ]
   ]
   );
$result = curl_exec($curl);
echo $result;
// echo $post_fields;
// echo $postie_encode;
curl_close($curl);
die();

 ?>