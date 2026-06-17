<?php

class Session {
    private $started = false;

    public function __construct() {
        $this->start();
    }

    /**
     * Inicia la sesión si no está activa
     */
    private function start() {
        if (session_status() == PHP_SESSION_NONE && !$this->started) {
            session_start();
            $this->started = true;
            
            // Configuración de seguridad básica
            $this->setSecurityHeaders();
        }
    }

    /**
     * Configura headers de seguridad para la cookie de sesión
     */
    private function setSecurityHeaders() {
        if (!$this->started) return;

        $params = session_get_cookie_params();
        session_set_cookie_params([
            'lifetime' => $params['lifetime'],
            'path' => $params['path'],
            'domain' => $params['domain'],
            'secure' => true, // Solo HTTPS
            'httponly' => true, // No accesible por JavaScript
            'samesite' => 'Strict' // Protección CSRF
        ]);
    }

    /**
     * Método mágico para obtener variables de sesión
     */
    public function __get($key) {
        if (!$this->has($key)) {
            throw new Exception("SESSION ERROR: El parámetro <b>$key</b> que intentas llamar no existe!");
        }
        return $_SESSION[$key];
    }

    /**
     * Método mágico para establecer variables de sesión
     */
    public function __set($key, $value) {
        $this->set($key, $value);
    }

    /**
     * Verifica si una variable de sesión existe
     */
    public function has($key) {
        return isset($_SESSION[$key]);
    }

    /**
     * Establece una variable de sesión
     */
    public function set($key, $value, $expiry = null) {
        if ($expiry) {
            // Variable con expiración
            $_SESSION[$key] = [
                'value' => $value,
                'expires_at' => time() + $expiry
            ];
        } else {
            $_SESSION[$key] = $value;
        }
    }

    /**
     * Elimina una variable de sesión
     */
    public function remove($key) {
        if ($this->has($key)) {
            unset($_SESSION[$key]);
            return true;
        }
        return false;
    }

    /**
     * Obtiene el user_id o valor por defecto si no existe
     */
    public function getUID($default = null) {
        return $this->has('user_id') ? $_SESSION['user_id'] : $default;
    }

    /**
     * Obtiene una variable con valor por defecto si no existe
     */
    public function get($key, $default = null) {
        return $this->has($key) ? $_SESSION[$key] : $default;
    }

    /**
     * Obtiene y elimina una variable (flash data)
     */
    public function flash($key, $default = null) {
        $value = $this->get($key, $default);
        $this->remove($key);
        return $value;
    }

    /**
     * Verifica si una variable con expiración sigue siendo válida
     */
    public function isValid($key) {
        if (!$this->has($key)) return false;

        $value = $_SESSION[$key];
        
        // Si tiene expiración, verificar
        if (is_array($value) && isset($value['expires_at'])) {
            if (time() > $value['expires_at']) {
                $this->remove($key);
                return false;
            }
            return true;
        }

        return true;
    }

    /**
     * Obtiene el tiempo restante para variables con expiración
     */
    public function getTimeRemaining($key) {
        if (!$this->isValid($key)) return 0;

        $value = $_SESSION[$key];
        if (is_array($value) && isset($value['expires_at'])) {
            return max(0, $value['expires_at'] - time());
        }

        return null; // No tiene expiración configurada
    }

    /**
     * Regenera el ID de sesión (protección contra fixation)
     */
    public function regenerate() {
        session_regenerate_id(true);
    }

    /**
     * Destruye la sesión completamente
     */
    public function destroy() {
        if ($this->started) {
            session_unset();
            session_destroy();
            session_write_close();
            $this->started = false;
        }
    }

    /**
     * Obtiene todas las variables de sesión
     */
    public function all() {
        return $_SESSION;
    }

    /**
     * Limpia todas las variables de sesión
     */
    public function clear() {
        session_unset();
    }

    /**
     * Obtiene el ID de sesión actual
     */
    public function getId() {
        return session_id();
    }

    /**
     * Método para debug: muestra información de la sesión
     */
    public function debug() {
        echo "<pre>";
        echo "Session ID: " . $this->getId() . "\n";
        echo "Session Data:\n";
        print_r($this->all());
        echo "</pre>";
    }
}

// Ejemplo de uso
/*
$session = new Session();

// Establecer variables
$session->user_id = 123;
$session->set('username', 'john_doe', 3600); // Expira en 1 hora

// Obtener variables
echo $session->user_id; // 123
echo $session->get('username'); // john_doe

// Verificar expiración
if ($session->isValid('username')) {
    echo "La sesión es válida. Tiempo restante: " . $session->getTimeRemaining('username') . " segundos";
}

// Flash data (para mensajes de una sola vez)
$session->set('success_message', 'Operación completada');
$message = $session->flash('success_message'); // Obtiene y elimina

// Destruir sesión
// $session->destroy();
*/
?>