<?php
function async_get($ssl, $host, $port, $endpoint, $connectTimeout) {
    $cookie_str = '';

    foreach ($_COOKIE as $k => $v) {
        $cookie_str .= urlencode($k) .'='. urlencode($v) .'; ';
    }
    $sslstr = ($ssl) ? "ssl://" : "";
    $request =  "GET $endpoint HTTP/1.1\r\n";
    $request .= "Host: $host\r\n";

    if (!empty($cookie_str)) {
        $request .= 'Cookie: '. substr($cookie_str, 0, -2);
    }
//    $request .= "Connection: Close\r\n";

    $errno = null;
    $errstr = null;
    $port = $port;
    if (($fp = @fsockopen($sslstr.$host, $port, $errno, $errstr, $connectTimeout)) == false) {
        return;
    }
    echo fputs($fp,$request);
//    echo fread($fp,2048);
    fclose($fp);
}

function add($a){
    echo $a + 1;
}
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'http://localhost:9999');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
curl_setopt($ch, CURLOPT_TIMEOUT_MS, 1000000000);

var_dump(curl_exec($ch));
curl_close($ch);


add(3);
add(4);