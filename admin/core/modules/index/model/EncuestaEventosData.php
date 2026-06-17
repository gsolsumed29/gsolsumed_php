<?php
class EncuestaEventosData {
    public static $tablename = "jm_respuestas_encuesta";

    public function __construct() {
        $this->id = 0;
        $this->nombre_completo = "";
        $this->numero_contacto = "";
        $this->email = "";          // Nuevo
        $this->estado = "";         // Nuevo
        $this->ciudad = "";         // Nuevo
        $this->especialidad = "";
        $this->conoce_bialy = "";
        $this->observacion = "";    // Nuevo
        $this->fecha_creacion = "";
    }

    public function add() {
        // Agregamos los nuevos campos a la sentencia SQL
        // Usamos GETDATE() para SQL Server
        $sql = "SET NOCOUNT ON; INSERT INTO " . self::$tablename . " (
            nombre_completo, numero_contacto, email, estado, ciudad, especialidad, conoce_bialy, observacion, fecha_creacion
        ) VALUES (
            ?, ?, ?, ?, ?, ?, ?, ?, GETDATE()
        )";
        
        $params = array(
            $this->nombre_completo,
            $this->numero_contacto,
            $this->email,
            $this->estado,
            $this->ciudad,
            $this->especialidad,
            $this->conoce_bialy,
            $this->observacion
        );
        
        // Ejecución mediante tu clase Executor
        $result = Executor::doitArr($sql, $params);
        
        return true; 
    }

    public static function getAll() {
        $sql = "SELECT * FROM " . self::$tablename . " ORDER BY id DESC";
        $query = Executor::doitArr($sql);
        $array = array();
        
        if ($query) {
            foreach ($query as $r) {
                $enc = new EncuestaEventosData();
                $enc->id = $r['id'];
                $enc->nombre_completo = $r['nombre_completo'];
                $enc->numero_contacto = $r['numero_contacto'];
                $enc->email = isset($r['email']) ? $r['email'] : "";
                $enc->estado = isset($r['estado']) ? $r['estado'] : "";
                $enc->ciudad = isset($r['ciudad']) ? $r['ciudad'] : "";
                $enc->especialidad = $r['especialidad'];
                $enc->conoce_bialy = $r['conoce_bialy'];
                $enc->observacion = isset($r['observacion']) ? $r['observacion'] : "";
                $enc->fecha_creacion = $r['fecha_creacion'];
                $array[] = $enc;
            }
        }
        return $array;
    }
}
?>