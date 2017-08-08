<?php
//    echo 'reached';
    // enable curl
    $ch = curl_init();
    // set url
    $url = 'https://westus.api.cognitive.microsoft.com/luis/v2.0/apps/7f1039db-636e-4703-a617-bdf0a0665302?subscription-key=9a75ae39184a4ae9842dc1f134ca212f&timezoneOffset=0&verbose=true&q=';
    $query = $_POST['login_email'];
    $url = $url . str_replace(' ', '%20', $query);

   // echo "reached here";
    
    // set curl options
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

    $output = curl_exec($ch); 
    curl_close($ch);

    //var_dump(json_decode($output,true));
    $obj = json_decode($output,true);

//    print $obj['entities'][0]['type'];    

    $res = count($obj['entities']);

  //  echo $res;
    //echo 'reached';

    if($res < 3)
	echo 'Insufficient Data to Book Flight'. '<br><br><br><br>';
    else
	echo 'Flight Booked. See below for details.' . '<br><br><br><br>';

    for($i=0;$i<$res;$i++){
    if($obj['entities'][$i]['type'] == 'Location::toLocation')
	echo 'Destination: ' . $obj['entities'][$i]['entity'] . "<br>\r\n";
    else if($obj['entities'][$i]['type'] == 'builtin.datetimeV2.date')
	echo 'Flight Date: ' . $obj['entities'][$i]['entity'];
    else if($obj['entities'][$i]['type'] == 'Location::fromLocation')
	echo 'Source: ' . $obj['entities'][$i]['entity'] . "<br>\r\n";
    }
?>
