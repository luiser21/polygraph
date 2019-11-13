<?php
 /** @param string $url
 * @param string $post_fields .. or array
 * @param array $headers
 * @return type
 */
function cUrlGetData($url, $post_fields = null, $headers = null) {
    $ch = curl_init();
    $timeout = 5;
    curl_setopt($ch, CURLOPT_URL, $url);
    if ($post_fields && !empty($post_fields)) {
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
    }
    if ($headers && !empty($headers)) {
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    }
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    $data = curl_exec($ch);
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }
    curl_close($ch);
    return $data;
}


//$url = "http://localhost/carLub/recibePost.php";
$url = "https://app.infovotantes.co/InfoVotantesWS/InfoServices/Servicios/consultarLugar";
$post_fields = 'luis=GANE&postvars2=val2';

$headers = array();
//$headers = array('Content-Type' => 'application/x-www-form-urlencoded', 'charset' => 'utf-8');
$dat = cUrlGetData($url, $post_fields, $headers);
print_r($dat);

?>