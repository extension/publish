<?php
//utils

//rm_startsWith
if ( ! function_exists('rm_startsWith') ){
    function rm_startsWith($haystack, $needle)
    {
        $length = strlen($needle);
        return (substr($haystack, 0, $length) === $needle);
    }
}


//rm_endsWith
if ( ! function_exists('rm_endsWith') ){
    function rm_endsWith($haystack, $needle)
    {
        $length = strlen($needle);
        if ($length == 0) {
            return true;
        }
    
        return (substr($haystack, -$length) === $needle);
    }
}

if ( ! function_exists('rebelmouse_request') ){
    function rebelmouse_request ($endpoint, $params = array()) {
        $API_BASE_URL = "https://www.rebelmouse.com/res/";
        $url = $API_BASE_URL . $endpoint . '?' . http_build_query($params);

        $data = file_get_contents($url);
        $resp = json_decode($data, TRUE);

        return $resp;
    }
}
?>
