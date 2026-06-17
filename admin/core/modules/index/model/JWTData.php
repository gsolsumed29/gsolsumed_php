<?php
class JWTData {
    private static $algorithm = 'HS256';
    private static $secret = '';
    
    /**
     * Genera un token JWT
     */
    public static function generate($payload, $expire_time = 3600) {
        // Header
        $header = [
            'alg' => self::$algorithm,
            'typ' => 'JWT'
        ];
        
        // Agregar tiempo de expiración al payload
        $payload['iat'] = time(); // issued at
        $payload['exp'] = time() + $expire_time; // expiration
        
        // Codificar header y payload
        $base64_header = self::base64UrlEncode(json_encode($header));
        $base64_payload = self::base64UrlEncode(json_encode($payload));
        
        // Crear firma
        $signature = hash_hmac('sha256', 
            $base64_header . '.' . $base64_payload, 
            self::$secret, 
            true
        );
        $base64_signature = self::base64UrlEncode($signature);
        
        // Retornar token completo
        return $base64_header . '.' . $base64_payload . '.' . $base64_signature;
    }
    
    /**
     * Valida un token JWT
     */
    public static function validate($token) {
        // Dividir token
        $parts = explode('.', $token);
        if (count($parts) != 3) {
            return false;
        }
        
        list($base64_header, $base64_payload, $base64_signature) = $parts;
        
        // Reconstruir firma para validación
        $signature = self::base64UrlDecode($base64_signature);
        $expected_signature = hash_hmac('sha256', 
            $base64_header . '.' . $base64_payload, 
            self::$secret, 
            true
        );
        
        // Verificar firma
        if (!hash_equals($signature, $expected_signature)) {
            return false;
        }
        
        // Decodificar payload para verificar expiración
        $payload = json_decode(self::base64UrlDecode($base64_payload), true);
        
        // Verificar si ha expirado
        if (isset($payload['exp']) && $payload['exp'] < time()) {
            return false;
        }
        
        return $payload;
    }
    
    /**
     * Obtener payload sin validar firma (solo decodificar)
     */
    public static function getPayload($token) {
        $parts = explode('.', $token);
        if (count($parts) != 3) {
            return null;
        }
        
        $payload = json_decode(self::base64UrlDecode($parts[1]), true);
        return $payload;
    }
    
    /**
     * Codificar a base64 URL-safe
     */
    private static function base64UrlEncode($data) {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }
    
    /**
     * Decodificar base64 URL-safe
     */
    private static function base64UrlDecode($data) {
        return base64_decode(strtr($data, '-_', '+/'));
    }
    
    /**
     * Cambiar la clave secreta
     */
    public static function setSecret($secret) {
        self::$secret = $secret;
    }
}
?>