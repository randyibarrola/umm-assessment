<?php

/**
 * CurlService
 * Handles Curls requests
 */
class CurlService
{
    public static function request($url, $method = 'GET', array $data = array())
    {
        # Prepare request
        $ch = curl_init( $url );

        if ($method == 'POST') {
            curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode($data) );
            curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        }

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch);
        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($statusCode === 404) {
            return 'Not Found';
        }

        return json_decode($result);
    }
}