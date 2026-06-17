<?php
class TfhkaApiData {


	  private $api_user;
    private $api_pass;
    private $base_url = 'https://emision.thefactoryhka.com.ve/api'; // URL de la API
  

    
    public function __construct($user, $pass) {
        $this->api_user = $user;
        $this->api_pass = $pass;
    }
    
    public function obtenerToken() {
        $ch = curl_init($this->base_url . '/Autenticacion');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array(
            'usuario' => $this->api_user,
            'clave' => $this->api_pass
        )));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json'
        ));
        
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($http_code == 200) {
            $data = json_decode($response);
            return $data->token ?? null;
        }
        
        throw new Exception("Error obteniendo token: " . $response);
    }
    
    public function emitirFactura($token, $documento) {
        $ch = curl_init($this->base_url . '/Emision');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($documento));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . $token
        ));
        
        $response = curl_exec($ch);
        curl_close($ch);
        
        return json_decode($response);
    }

    public function anularFactura($token, $data) {
        $url = $this->base_url . "/Anular";
        
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $token
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($http_code == 200) {
            return json_decode($response, true);
        } else {
            throw new Exception("Error en anulación. HTTP Code: " . $http_code . " - Response: " . $response);
        }
    }

    public function emitirNotaCredito($token, $documento) {
        $ch = curl_init($this->base_url . '/Emision');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($documento));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . $token
        ));
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        // Manejo de errores mejorado
        if ($httpCode != 200) {
            throw new Exception("Error en la solicitud. HTTP Code: " . $httpCode . " - Response: " . $response);
        }
        
        return json_decode($response);
    }


    
    public function descargarDocumento($token, $data) {
        $url = $this->base_url . "/DescargaArchivo";
       // echo $url;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $token
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($http_code == 200) {
            return json_decode($response, true);
        } else {
            throw new Exception("Error en descarga. HTTP Code: " . $http_code . " - Response: " . $response);
        }
    }
	
}
?>