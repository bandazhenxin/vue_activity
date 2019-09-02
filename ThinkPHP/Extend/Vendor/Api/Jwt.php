<?php
class Jwt{
    private static $header = array(
        'alg' => 'HS256',
        'typ' => 'JWT'
    );

    private static $key = '123456';

    /**
     * 获取token
     * @param array $payload
     * @return bool|string
     */
    public static function getToken(array $payload){
        if(is_array($payload)){
            $base64header  = self::base64UrlEncode(json_encode(self::$header,JSON_UNESCAPED_UNICODE));
            $base64payload = self::base64UrlEncode(json_encode($payload,JSON_UNESCAPED_UNICODE));
            $token         = $base64header.'.'.$base64payload.'.'.self::signature($base64header.'.'.$base64payload,self::$key,self::$header['alg']);
            return $token;
        }else{
            return false;
        }
    }

    /**
     * token验证
     * @param $Token
     * @return bool|mix|mixed|string
     */
    public static function verifyToken($Token){
        if(!is_string($Token)) return false;
        $tokens = explode('.', $Token);
        if (count($tokens) != 3) return false;

        list($base64header, $base64payload, $sign) = $tokens;

        //获取jwt算法
        $base64decodeheader = json_decode(self::base64UrlDecode($base64header), JSON_OBJECT_AS_ARRAY);
        if (empty($base64decodeheader['alg']))
            return false;

        //签名验证
        if (self::signature($base64header . '.' . $base64payload, self::$key, $base64decodeheader['alg']) !== $sign)
            return false;

        $payload = json_decode(self::base64UrlDecode($base64payload), JSON_OBJECT_AS_ARRAY);

        //签发时间大于当前服务器时间验证失败
        if (isset($payload['iat']) && $payload['iat'] > time())
            return false;

        //过期时间小宇当前服务器时间验证失败
        if (isset($payload['exp']) && $payload['exp'] < time())
            return false;

        //该nbf时间之前不接收处理该Token
        if (isset($payload['nbf']) && $payload['nbf'] > time())
            return false;

        return $payload;
    }

    /**
     * base64UrlEncode编码实现
     * @param $input
     * @return mixed
     * @throws Exception
     */
    private static function base64UrlEncode($input){
        if(!is_string($input))
            throw new Exception('$input params must be string');

        return str_replace('=', '', strtr(base64_encode($input), '+/', '-_'));
    }

    /**
     * base64UrlEncode解码实现
     * @param $input
     * @return bool|string
     * @throws Exception
     */
    private static function base64UrlDecode($input){
        if(!is_string($input))
            throw new Exception('$input params must be string');

        $remainder = strlen($input) % 4;
        if ($remainder) {
            $addlen = 4 - $remainder;
            $input .= str_repeat('=', $addlen);
        }
        return base64_decode(strtr($input, '-_', '+/'));
    }

    /**
     * HMACSHA256签名
     * @param $input
     * @param $key
     * @param string $alg
     * @return mixed
     * @throws Exception
     */
    private static function signature($input, $key, $alg = 'HS256'){
        if(!is_string($input) || !is_string($key))
            throw new Exception('params must be string');

        $alg_config = array(
            'HS256' => 'sha256'
        );
        return self::base64UrlEncode(hash_hmac($alg_config[$alg], $input, $key,true));
    }
}