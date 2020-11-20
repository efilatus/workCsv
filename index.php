<?php

//создает POST запрос на создание нераборанного

require 'exception.php';
require 'read_csv.php';

$token = json_decode(file_get_contents('save_token_key.json'), true);
$access_token = $token['access_token'];

$way = '/api/v4/leads/unsorted/forms';
$link = 'https://bordo.amocrm.ru' . $way;

$headers = [
    'Content-Type:application/json',
	'Authorization: Bearer ' . $access_token,
];

$file = 'Book2.csv';
$csvArray = ReadCsv($file);

foreach($csvArray as $key => $array) {
    $data[] = [
        'source_name' => 'text',
        'source_uid' => 'a1fee7c0fc436088e64ba2e8822ba2b3',
        'pipeline_id' => 3717283,
        '_embedded' => [
            'leads' => [[
                'name' => $array['lead'],
            ]],
            'contacts' => [[
                'name' => $array['contact'],
                "custom_fields_values" => [[
                    "field_id" => 446081,
                    "values" => [[
                        "value" => $array['phone'],
                    ]] 
                ]]
            ]]
        ],
        'metadata' => [
            'ip' => '123.222.2.22',
            'form_id' => 'test',
            'form_sent_at' => time(),
            'form_name' => 'Тестовая форма',
            'form_page' => 'https://example.com',
            'referer' => 'https://example.com'
        ],
    ];
}

$curl = curl_init();
curl_setopt($curl,CURLOPT_URL, $link);
curl_setopt($curl,CURLOPT_HTTPHEADER, $headers);
curl_setopt($curl,CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($curl,CURLOPT_POSTFIELDS, json_encode($data));
$out = curl_exec($curl);
$code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
curl_close($curl);

ExeptionCode($code);

echo "Успешно создано $key";
