<?php

require 'exception.php';

$subdomain = 'bordo';
$link = 'https://'. $subdomain .'.amocrm.ru/oauth2/access_token';

$user = json_decode(file_get_contents('user_token.json'));

$data = [
	'client_id' => $user->client_id,
	'client_secret' => $user->client_secret,
	'grant_type' => 'authorization_code',
	'code' => '***',
	'redirect_uri' => $user->redirect_uri,
];

$curl = curl_init(); 
curl_setopt($curl,CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-oAuth-client/1.0');
curl_setopt($curl,CURLOPT_URL, $link);
curl_setopt($curl,CURLOPT_HTTPHEADER,['Content-Type:application/json']);
curl_setopt($curl,CURLOPT_HEADER, false);
curl_setopt($curl,CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($curl,CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, 1);
curl_setopt($curl,CURLOPT_SSL_VERIFYHOST, 2);
$out = curl_exec($curl); 
$code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
curl_close($curl);

ExeptionCode($code);

file_put_contents('save_token_key.json', $out);
