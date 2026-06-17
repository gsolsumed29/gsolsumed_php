<?php
class LlamadasData {
    public static $tablename = "jm_llamadas_clientes";

    public function __construct() {
        $this->id = 0;
        $this->co_cli = "";
        $this->des_cli = "";
        $this->responsable = ""; // NUEVO
        $this->fecha_hora_llamada = "";
        $this->fecha_posible_respuesta = null;
        $this->fecha_seguimiento = null; // NUEVO
        $this->tipo_requerimiento = "";
        $this->estado_llamada = ""; // NUEVO
        $this->numero_contactado = ""; // NUEVO
        $this->requiere_seguimiento = 0; // NUEVO
        $this->monto_comprometido = 0; // NUEVO
        $this->observacion = "";
        $this->dato_extra1 = "";
        $this->dato_extra2 = "";
        $this->dato_extra3 = "";
        $this->estatus = 1;
        $this->co_ven = "";
        $this->fecha_registro = "";
    }

    // Método para obtener todos los registros de llamadas
    public static function getAll($search = '') {
        $sql = "SELECT l.*, v.ven_des 
                FROM " . self::$tablename . " l
                LEFT JOIN vendedor v ON l.co_ven = v.co_ven  
                WHERE 1=1";
        
        $params = array();
        
        if (!empty($search)) {
            $sql .= " AND (l.co_cli LIKE ? OR l.des_cli LIKE ? OR l.tipo_requerimiento LIKE ? OR l.observacion LIKE ?)";
            $searchTerm = "%" . $search . "%";
            $params[] = $searchTerm;
            $params[] = $searchTerm;
            $params[] = $searchTerm;
            $params[] = $searchTerm;
        }
        
        $sql .= " ORDER BY l.fecha_hora_llamada DESC";
        
        $query = Executor::doitArr($sql, $params);
        
        if (!empty($query)) {
            $array = array();
            $cnt = 0;
            
            foreach ($query as $r) {
                $array[$cnt] = new LlamadasData();
                $array[$cnt]->id = $r['id'];
                $array[$cnt]->co_cli = trim($r['co_cli']);
                $array[$cnt]->des_cli = trim($r['des_cli']);
                $array[$cnt]->responsable = isset($r['responsable']) ? trim($r['responsable']) : '';
                $array[$cnt]->fecha_hora_llamada = $r['fecha_hora_llamada'];
                $array[$cnt]->fecha_posible_respuesta = $r['fecha_posible_respuesta'];
                $array[$cnt]->fecha_seguimiento = isset($r['fecha_seguimiento']) ? $r['fecha_seguimiento'] : null;
                $array[$cnt]->tipo_requerimiento = trim($r['tipo_requerimiento']);
                $array[$cnt]->estado_llamada = isset($r['estado_llamada']) ? trim($r['estado_llamada']) : '';
                $array[$cnt]->numero_contactado = isset($r['numero_contactado']) ? trim($r['numero_contactado']) : '';
                $array[$cnt]->requiere_seguimiento = isset($r['requiere_seguimiento']) ? (int)$r['requiere_seguimiento'] : 0;
                $array[$cnt]->monto_comprometido = isset($r['monto_comprometido']) ? (float)$r['monto_comprometido'] : 0;
                $array[$cnt]->observacion = $r['observacion'];
                $array[$cnt]->dato_extra1 = trim($r['dato_extra1']);
                $array[$cnt]->dato_extra2 = trim($r['dato_extra2']);
                $array[$cnt]->dato_extra3 = trim($r['dato_extra3']);
                $array[$cnt]->estatus = $r['estatus'];
                $array[$cnt]->co_ven = trim($r['co_ven']);
                $array[$cnt]->ven_des = trim($r['ven_des']);
                $array[$cnt]->fecha_registro = $r['fecha_registro'];
                $cnt++;
            }
            
            return $array;
        } else {
            return array();
        }
    }

    // Método para obtener todos los vendedores
    public static function getDataVendedores() {
        $sql = "SELECT co_ven, ven_des, direc2 as clave FROM vendedor ORDER BY ven_des";
        
        $query = Executor::doitArr($sql);
        
        if (!empty($query)) {
            $array = array();
            $cnt = 0;
            
            foreach ($query as $r) {
                $array[$cnt] = new stdClass();
                $array[$cnt]->co_ven = trim($r['co_ven']);
                $array[$cnt]->ven_des = trim($r['ven_des']);
                $array[$cnt]->clave = trim($r['clave']);
                $cnt++;
            }
            
            return $array;
        } else {
            return array();
        }
    }

    // Método para buscar clientes
    public static function getClientes($search = '') {
        $sql = "SELECT co_cli, cli_des, rif, responsable, telefonos 
                FROM clientes 
                WHERE 1=1";
        
        $params = array();
        
        if (!empty($search)) {
            $sql .= " AND (co_cli LIKE ? OR cli_des LIKE ? OR rif LIKE ?)";
            $searchTerm = "%" . $search . "%";
            $params[] = $searchTerm;
            $params[] = $searchTerm;
            $params[] = $searchTerm;
        }
        
        $sql .= " ORDER BY cli_des";
        
        $query = Executor::doitArr($sql, $params);
        
        if (!empty($query)) {
            $array = array();
            $cnt = 0;
            
            foreach ($query as $r) {
                $array[$cnt] = new stdClass();
                $array[$cnt]->co_cli = trim($r['co_cli']);
                $array[$cnt]->des_cli = trim($r['cli_des']);
                $array[$cnt]->rif = trim($r['rif']);
                $array[$cnt]->responsable = isset($r['responsable']) ? trim($r['responsable']) : '';
                $array[$cnt]->telefonos = isset($r['telefonos']) ? trim($r['telefonos']) : '';
                $cnt++;
            }
            
            return $array;
        } else {
            return array();
        }
    }

    // Método para obtener vendedor por cliente
    public static function getVendedorByCliente($co_cli) {
        $sql = "SELECT co_ven FROM clientes WHERE co_cli = ?";
        $params = array($co_cli);
        $query = Executor::doitArr($sql, $params);
        
        if (!empty($query)) {
            return trim($query[0]['co_ven']);
        }
        return '';
    }

    // Método para obtener llamadas por cliente
    public static function getLlamadasByCliente($co_cli) {
        $sql = "SELECT * FROM " . self::$tablename . " 
                WHERE co_cli = ? 
                ORDER BY fecha_hora_llamada DESC";
        $params = array($co_cli);
        $query = Executor::doitArr($sql, $params);
        
        if (!empty($query)) {
            $array = array();
            $cnt = 0;
            
            foreach ($query as $r) {
                $array[$cnt] = new LlamadasData();
                $array[$cnt]->id = $r['id'];
                $array[$cnt]->co_cli = trim($r['co_cli']);
                $array[$cnt]->des_cli = trim($r['des_cli']);
                $array[$cnt]->fecha_hora_llamada = $r['fecha_hora_llamada'];
                $array[$cnt]->fecha_posible_respuesta = $r['fecha_posible_respuesta'];
                $array[$cnt]->tipo_requerimiento = trim($r['tipo_requerimiento']);
                $array[$cnt]->observacion = $r['observacion'];
                $array[$cnt]->estado_llamada = isset($r['estado_llamada']) ? trim($r['estado_llamada']) : '';
                $array[$cnt]->co_ven = trim($r['co_ven']);
                $cnt++;
            }
            
            return $array;
        } else {
            return array();
        }
    }

    // Método para obtener un registro por su ID
    public static function getById($id) {
        $sql = "SELECT l.*, v.ven_des 
                FROM " . self::$tablename . " l
                LEFT JOIN vendedor v ON l.co_ven = v.co_ven 
                WHERE l.id = ?";
        
        $params = array($id);
        $query = Executor::doitArr($sql, $params);
        
        if (!empty($query)) {
            $r = $query[0];
            $llamada = new LlamadasData();
            $llamada->id = $r['id'];
            $llamada->co_cli = trim($r['co_cli']);
            $llamada->des_cli = trim($r['des_cli']);
            $llamada->responsable = isset($r['responsable']) ? trim($r['responsable']) : '';
            $llamada->fecha_hora_llamada = $r['fecha_hora_llamada'];
            $llamada->fecha_posible_respuesta = $r['fecha_posible_respuesta'];
            $llamada->fecha_seguimiento = isset($r['fecha_seguimiento']) ? $r['fecha_seguimiento'] : null;
            $llamada->tipo_requerimiento = trim($r['tipo_requerimiento']);
            $llamada->estado_llamada = isset($r['estado_llamada']) ? trim($r['estado_llamada']) : '';
            $llamada->numero_contactado = isset($r['numero_contactado']) ? trim($r['numero_contactado']) : '';
            $llamada->requiere_seguimiento = isset($r['requiere_seguimiento']) ? (int)$r['requiere_seguimiento'] : 0;
            $llamada->monto_comprometido = isset($r['monto_comprometido']) ? (float)$r['monto_comprometido'] : 0;
            $llamada->observacion = $r['observacion'];
            $llamada->dato_extra1 = isset($r['dato_extra1']) ? trim($r['dato_extra1']) : '';
            $llamada->dato_extra2 = isset($r['dato_extra2']) ? trim($r['dato_extra2']) : '';
            $llamada->dato_extra3 = isset($r['dato_extra3']) ? trim($r['dato_extra3']) : '';
            $llamada->estatus = $r['estatus'];
            $llamada->co_ven = trim($r['co_ven']);
            $llamada->ven_des = isset($r['ven_des']) ? trim($r['ven_des']) : '';
            $llamada->fecha_registro = $r['fecha_registro'];
            
            return $llamada;
        } else {
            return null;
        }
    }

    // Método para insertar un nuevo registro
    public function add() {
        // Formatear fecha_hora_llamada para SQL Server (Y-m-d H:i:s)
        $fecha_hora = date('Y-m-d H:i:s', strtotime($this->fecha_hora_llamada));
        
        $sql = "INSERT INTO " . self::$tablename . " (
            co_cli, des_cli, responsable, fecha_hora_llamada, 
            fecha_posible_respuesta, fecha_seguimiento, tipo_requerimiento,
            estado_llamada, numero_contactado, requiere_seguimiento, monto_comprometido,
            observacion, dato_extra1, dato_extra2, dato_extra3,
            estatus, co_ven, fecha_registro
        ) VALUES (
            ?, ?, ?, ?,
            ?, ?, ?,
            ?, ?, ?, ?,
            ?, ?, ?, ?,
            ?, ?, GETDATE()
        )";
        
        // Manejar fecha_posible_respuesta (puede ser null)
        $fecha_respuesta = !empty($this->fecha_posible_respuesta) ? date('Y-m-d', strtotime($this->fecha_posible_respuesta)) : null;
        
        // Manejar fecha_seguimiento (puede ser null)
        $fecha_seg = !empty($this->fecha_seguimiento) ? date('Y-m-d', strtotime($this->fecha_seguimiento)) : null;
        
        // Manejar monto_comprometido
        $monto = !empty($this->monto_comprometido) ? (float)$this->monto_comprometido : null;
        
        $params = array(
            $this->co_cli,
            $this->des_cli,
            $this->responsable,
            $fecha_hora,
            $fecha_respuesta,
            $fecha_seg,
            $this->tipo_requerimiento,
            $this->estado_llamada,
            $this->numero_contactado,
            $this->requiere_seguimiento,
            $monto,
            $this->observacion,
            $this->dato_extra1,
            $this->dato_extra2,
            $this->dato_extra3,
            $this->estatus,
            $this->co_ven
        );
        
        $result = Executor::doitArr($sql, $params);
        return !empty($result);
    }

    // Método para actualizar un registro existente
    public function update() {
        // Formatear fecha_hora_llamada para SQL Server (Y-m-d H:i:s)
        $fecha_hora = date('Y-m-d H:i:s', strtotime($this->fecha_hora_llamada));
        
        $sql = "UPDATE " . self::$tablename . " SET 
            co_cli = ?,
            des_cli = ?,
            responsable = ?,
            fecha_hora_llamada = ?,
            fecha_posible_respuesta = ?,
            fecha_seguimiento = ?,
            tipo_requerimiento = ?,
            estado_llamada = ?,
            numero_contactado = ?,
            requiere_seguimiento = ?,
            monto_comprometido = ?,
            observacion = ?,
            dato_extra1 = ?,
            dato_extra2 = ?,
            dato_extra3 = ?,
            estatus = ?,
            co_ven = ?
        WHERE id = ?";
        
        // Manejar fecha_posible_respuesta (puede ser null)
        $fecha_respuesta = !empty($this->fecha_posible_respuesta) ? date('Y-m-d', strtotime($this->fecha_posible_respuesta)) : null;
        
        // Manejar fecha_seguimiento (puede ser null)
        $fecha_seg = !empty($this->fecha_seguimiento) ? date('Y-m-d', strtotime($this->fecha_seguimiento)) : null;
        
        // Manejar monto_comprometido
        $monto = !empty($this->monto_comprometido) ? (float)$this->monto_comprometido : null;
        
        $params = array(
            $this->co_cli,
            $this->des_cli,
            $this->responsable,
            $fecha_hora,
            $fecha_respuesta,
            $fecha_seg,
            $this->tipo_requerimiento,
            $this->dato_extra2,
            $this->dato_extra1,
            $this->requiere_seguimiento,
            $monto,
            $this->observacion,
            $this->dato_extra1,
            $this->dato_extra2,
            $this->dato_extra3,
            $this->estatus,
            $this->co_ven,
            $this->id
        );
        
        $result = Executor::doitArr($sql, $params);
        return !empty($result);
    }

    // Método para eliminar un registro
    public function delete() {
        $sql = "DELETE FROM " . self::$tablename . " WHERE id = ?";
        $params = array($this->id);
        
        $result = Executor::doitArr($sql, $params);
        return !empty($result);
    }

    // Método estático para eliminar por ID
    public static function deleteById($id) {
        $sql = "DELETE FROM " . self::$tablename . " WHERE id = ?";
        $params = array($id);
        
        $result = Executor::doitArr($sql, $params);
        return !empty($result);
    }

    // Método para obtener total de registros
    public static function getTotalRecords($search = '') {
        $sql = "SELECT COUNT(*) as total FROM " . self::$tablename . " WHERE 1=1";
        $params = array();
        
        if (!empty($search)) {
            $sql .= " AND (co_cli LIKE ? OR des_cli LIKE ? OR tipo_requerimiento LIKE ?)";
            $searchTerm = "%" . $search . "%";
            $params[] = $searchTerm;
            $params[] = $searchTerm;
            $params[] = $searchTerm;
        }
        
        $query = Executor::doitArr($sql, $params);
        
        if (!empty($query)) {
            return (int)$query[0]['total'];
        } else {
            return 0;
        }
    }

    // Método para obtener registros paginados
    public static function getPaginated($page = 1, $perPage = 10, $search = '') {
        $offset = ($page - 1) * $perPage;
        
        $sql = "SELECT l.*, v.ven_des 
                FROM " . self::$tablename . " l
                LEFT JOIN vendedor v ON l.co_ven = v.co_ven
                WHERE 1=1";
        $params = array();
        
        if (!empty($search)) {
            $sql .= " AND (l.co_cli LIKE ? OR l.des_cli LIKE ? OR l.tipo_requerimiento LIKE ?)";
            $searchTerm = "%" . $search . "%";
            $params[] = $searchTerm;
            $params[] = $searchTerm;
            $params[] = $searchTerm;
        }
        
        $sql .= " ORDER BY l.fecha_hora_llamada DESC OFFSET ? ROWS FETCH NEXT ? ROWS ONLY";
        $params[] = $offset;
        $params[] = $perPage;
        
        $query = Executor::doitArr($sql, $params);
        
        if (!empty($query)) {
            $array = array();
            $cnt = 0;
            
            foreach ($query as $r) {
                $array[$cnt] = new LlamadasData();
                $array[$cnt]->id = $r['id'];
                $array[$cnt]->co_cli = trim($r['co_cli']);
                $array[$cnt]->des_cli = trim($r['des_cli']);
                $array[$cnt]->responsable = isset($r['responsable']) ? trim($r['responsable']) : '';
                $array[$cnt]->fecha_hora_llamada = $r['fecha_hora_llamada'];
                $array[$cnt]->fecha_posible_respuesta = $r['fecha_posible_respuesta'];
                $array[$cnt]->fecha_seguimiento = isset($r['fecha_seguimiento']) ? $r['fecha_seguimiento'] : null;
                $array[$cnt]->tipo_requerimiento = trim($r['tipo_requerimiento']);
                $array[$cnt]->estado_llamada = isset($r['estado_llamada']) ? trim($r['estado_llamada']) : '';
                $array[$cnt]->numero_contactado = isset($r['numero_contactado']) ? trim($r['numero_contactado']) : '';
                $array[$cnt]->requiere_seguimiento = isset($r['requiere_seguimiento']) ? (int)$r['requiere_seguimiento'] : 0;
                $array[$cnt]->monto_comprometido = isset($r['monto_comprometido']) ? (float)$r['monto_comprometido'] : 0;
                $array[$cnt]->observacion = $r['observacion'];
                $array[$cnt]->dato_extra1 = isset($r['dato_extra1']) ? trim($r['dato_extra1']) : '';
                $array[$cnt]->dato_extra2 = isset($r['dato_extra2']) ? trim($r['dato_extra2']) : '';
                $array[$cnt]->dato_extra3 = isset($r['dato_extra3']) ? trim($r['dato_extra3']) : '';
                $array[$cnt]->estatus = $r['estatus'];
                $array[$cnt]->co_ven = trim($r['co_ven']);
                $array[$cnt]->ven_des = isset($r['ven_des']) ? trim($r['ven_des']) : '';
                $array[$cnt]->fecha_registro = $r['fecha_registro'];
                $cnt++;
            }
            
            return $array;
        } else {
            return array();
        }
    }
}
?>