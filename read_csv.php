<?php 

function ReadCsv($fileCsv) {
    $row = 0;
    $array = [];
    $lead = 0; //сделка
    $phone = 1; //телефон
    $contact = 2; //контакт

    if (($handle = fopen($fileCsv, "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $array[$row]["lead"] = $data[$lead];
            $array[$row]["phone"] = $data[$phone];
            $array[$row]["contact"] = $data[$contact];
            $row++;
        }
        fclose($handle);
    }

    array_shift($array);

    $count = count($array);

    for ($i = 0; $i <= $count; $i++) {
        for ($j = 0; $j <= $count; $j++) {
            if ($array[$i] != null && $i != $j) {
                if ($array[$i]['phone'] == $array[$j]['phone']){
                    unset($array[$j]);
                }
            }

        }
    }
    
    return $array;
}

