<?php
namespace App\Util;

use App\Core\Logger\Logger;
use ErrorException;

/**
 * Class UtilHttpRequest
 * @package App\Util
 */
class UtilHttpRequest
{

    public static function getToken(): string
    {

        $clientId = env('CLIENT_ID');
        $token = env('ACCESS_TOKEN');
        $bearer = $clientId . ':' . $token;

        return base64_encode($bearer);
    }

    private static array $methodList = array(
        'GET',
        'POST',
    );

    /**
     * @param string $method
     * @param string $endpoint
     * @param string|null $token
     * @param array|object|null $data
     * @return array|object|bool
     * @throws ErrorException
     */
    public static function request(
        string $method,
        string $endpoint,
        string $token = null,
        array|object $data = null
    ): array|object|bool
    {
        if (!self::checkMethod($method)) {
            return false;
        }

        $protocol = 'http';
        if ((env('APP_ENV') === 'production') || (env('APP_ENV') === 'develop')) {
            $protocol = 'https';
        }

        $opts = array(
            $protocol => array(
                'method' => $method,
                'header' => array(
                    'Content-Type: application/json',
                    "Authorization: Bearer " . $token,
                ),
            )
        );

        if ($data !== null) {
            $opts[$protocol]['header']['content'] = json_encode($data);
        }

        $contents = @file_get_contents($endpoint, false, stream_context_create($opts));

        if ($contents === false) {
            $error = error_get_last();
            if($error) {
                throw new ErrorException($error['message'], $error['type']);
            }
            return false;
        }

        return json_decode($contents);

    }

    /**
     * @throws ErrorException
     */
    public static function cUrlRequest(
        string $method,
        string $endpoint,
        string $token = null,
        array|object $data = null
    ): bool|string
    {
        if (!self::checkMethod($method)) {
            return false;
        }

        //---CURL初期化
        $ch = curl_init($endpoint);

        $options = [
            CURLOPT_URL => $endpoint,
            CURLOPT_RETURNTRANSFER => true, // 返り値を文字列に変更
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_HTTPHEADER => array(
                'Content-Type:application/json' ,
                'Authorization: Bearer '. $token
            ),
        ];

        if ($data) {
            $options[CURLOPT_CUSTOMREQUEST] = "POST";
            $options[CURLOPT_POST] = 1;
            $options[CURLOPT_POSTFIELDS] = json_encode($data);
        }

        if (env('APP_ENV') === 'local') {
            $options[CURLOPT_SSL_VERIFYHOST] = 0;   // don't verify ssl
            $options[CURLOPT_SSL_VERIFYPEER] = false;
        }

        $options[CURLOPT_SSL_VERIFYHOST] = 0;   // don't verify ssl
        $options[CURLOPT_SSL_VERIFYPEER] = false;

        curl_setopt_array($ch, $options);

        //---接続実行
        $result = curl_exec($ch);

        //---接続エラー時
        if (curl_errno($ch)) {
            throw new ErrorException(curl_error($ch));
        }

        //---接続を閉じる
        curl_close($ch);

        $json = json_decode($result);  // JSONを配列に
        if (!$json || !isset($json->code) || !isset($json->message)) {
            return false;
        }

        return $result;
    }

    private static function checkMethod($method): bool
    {
        if (!is_string($method) or !in_array(strtoupper($method), self::$methodList)) {
            Logger::errorThrowable('request method '. $method . 'is undefined.');
            return false;
        }
        return true;
    }
}