<?php
class CajasData {
    public static $tablename = "jm_relacion_cajas";

    public function __construct() {
        $this->id = 0;
        $this->co_ven = "";
        $this->fecha = "";
        $this->turno = "";
        $this->estatus = 1;
        $this->monto_bs_efectivo = 0.00;
        $this->monto_bs_transf = 0.00;
        $this->monto_bs_bio = 0.00;
        $this->monto_bs_pago_movil = 0.00;
        $this->monto_usd_efectivo = 0.00;
        $this->monto_usd_zeller = 0.00;
        $this->campo1 = "";
        $this->campo2 = "";
        $this->campo3 = "";
    }

    // Método para obtener todos los registros de cajas
    public static function getAll($search = '') {
        $sql = "SELECT jmrc.id, jmrc.co_ven,
        jmrc.fecha,
        jmrc.turno,
        jmrc.estatus,
        jmrc.monto_bs_efectivo,
        jmrc.monto_bs_transf,
        jmrc.monto_bs_bio,
        jmrc.monto_bs_pago_movil,
        jmrc.monto_usd_efectivo,
        jmrc.monto_usd_zeller,
        jmrc.campo1 ,
        jmrc.campo2,
        jmrc.campo3,v.ven_des FROM " . self::$tablename . " jmrc 
                INNER JOIN jm_vendedor_cajas v ON jmrc.co_ven = v.co_ven  
                WHERE 1=1";
        
        $params = array();
        
        if (!empty($search)) {
            $sql .= " AND (jmrc.co_ven LIKE ? OR jmrc.turno LIKE ?)";
            $searchTerm = "%" . $search . "%";
            $params[] = $searchTerm;
            $params[] = $searchTerm;
        }
        
        $sql .= " ORDER BY jmrc.id DESC";
        
        $query = Executor::doitArr($sql, $params);
        $e = count($query);
        
        if ($e >= 1) {
            $array = array();
            $cnt = 0;
            
            foreach ($query as $r) {
                $array[$cnt] = new CajasData();
                $array[$cnt]->id = $r['id'];
                $array[$cnt]->co_ven = trim($r['co_ven']) . ' ' . trim($r['ven_des']);
                $array[$cnt]->fecha = $r['fecha'];
                $array[$cnt]->turno = trim($r['turno']);
                $array[$cnt]->estatus = $r['estatus'];
                $array[$cnt]->monto_bs_efectivo = (float)$r['monto_bs_efectivo'];
                $array[$cnt]->monto_bs_transf = (float)$r['monto_bs_transf'];
                $array[$cnt]->monto_bs_bio = (float)$r['monto_bs_bio'];
                $array[$cnt]->monto_bs_pago_movil = (float)$r['monto_bs_pago_movil'];
                $array[$cnt]->monto_usd_efectivo = (float)$r['monto_usd_efectivo'];
                $array[$cnt]->monto_usd_zeller = (float)$r['monto_usd_zeller'];
                $array[$cnt]->campo1 =(float)$r['campo1'];
                $array[$cnt]->campo2 = (float)$r['campo2'];
                $array[$cnt]->campo3 = trim($r['campo3']);
                $cnt++;
            }
            
            return $array;
        } else {
            return array();
        }
    }

    // Método para obtener todos los registros de cajas
    public static function getDataVendedores() {
        $sql = "SELECT co_ven, ven_des,clave FROM jm_vendedor_cajas ORDER BY co_ven";
        
        $query = Executor::doitArr($sql);
        
        if (!empty($query)) {
            $array = array();
            $cnt = 0;
            
            foreach ($query as $r) {
                $array[$cnt] = new CajasData();
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

    // Método para obtener un registro por su ID
    public static function getById($id) {
        $sql = "SELECT jmrc.id, jmrc.co_ven,
jmrc.fecha,
jmrc.turno,
jmrc.estatus,
jmrc.monto_bs_efectivo,
jmrc.monto_bs_transf,
jmrc.monto_bs_bio,
jmrc.monto_bs_pago_movil,
jmrc.monto_usd_efectivo,
jmrc.monto_usd_zeller,
jmrc.campo1 ,
jmrc.campo2,
jmrc.campo3,v.ven_des FROM " . self::$tablename . " jmrc 
                INNER JOIN jm_vendedor_cajas v ON jmrc.co_ven = v.co_ven 
                WHERE jmrc.id = ?";
        
        $params = array($id);
        $query = Executor::doitArr($sql, $params);
        
        if (!empty($query)) {
            $r = $query[0];
            $caja = new CajasData();
            $caja->id = $r['id'];
            $caja->co_ven = trim($r['co_ven']);
            $caja->ven_des = trim($r['ven_des']);
            $caja->fecha = $r['fecha'];
            $caja->turno = trim($r['turno']);
            $caja->estatus = $r['estatus'];
            $caja->monto_bs_efectivo = (float)$r['monto_bs_efectivo'];
            $caja->monto_bs_transf = (float)$r['monto_bs_transf'];
            $caja->monto_bs_bio = (float)$r['monto_bs_bio'];
            $caja->monto_bs_pago_movil = (float)$r['monto_bs_pago_movil'];
            $caja->monto_usd_efectivo = (float)$r['monto_usd_efectivo'];
            $caja->monto_usd_zeller = (float)$r['monto_usd_zeller'];
            $caja->campo1 =(float)$r['campo1'];
            $caja->campo2 = (float)$r['campo2'];
            $caja->campo3 = trim($r['campo3']);
            
            return $caja;
        } else {
            return null;
        }
    }

    // Método para insertar un nuevo registro
    public function add() {
        $sql = "INSERT INTO " . self::$tablename . " (
            co_ven, fecha, turno, estatus, 
            monto_bs_efectivo, monto_bs_transf, monto_bs_bio, monto_bs_pago_movil,
            monto_usd_efectivo, monto_usd_zeller, campo1, campo2, campo3
        ) VALUES (
            ?, CONVERT(datetime, getdate(), 121), ?, ?,
            ?, ?, ?, ?,
            ?, ?, ?, ?, ?
        )";
        
        $params = array(
            $this->co_ven,
            $this->turno,
            $this->estatus,
            $this->monto_bs_efectivo,
            $this->monto_bs_transf,
            $this->monto_bs_bio,
            $this->monto_bs_pago_movil,
            $this->monto_usd_efectivo,
            $this->monto_usd_zeller,
            $this->campo1,
            $this->campo2,
            $this->campo3
        );
        
        $result = Executor::doitArr($sql, $params);
        return !empty($result);
    }

    // Método para actualizar un registro existente
    public function update() {
        $sql = "UPDATE " . self::$tablename . " SET 
            co_ven = ?,
            fecha = CONVERT(datetime, getdate(), 121),
            turno = ?,
            estatus = ?,
            monto_bs_efectivo = ?,
            monto_bs_transf = ?,
            monto_bs_bio = ?,
            monto_bs_pago_movil = ?,
            monto_usd_efectivo = ?,
            monto_usd_zeller = ?,
            campo1 = ?,
            campo2 = ?,
            campo3 = ?
        WHERE id = ?";
        
        $params = array(
            $this->co_ven,
            $this->turno,
            $this->estatus,
            $this->monto_bs_efectivo,
            $this->monto_bs_transf,
            $this->monto_bs_bio,
            $this->monto_bs_pago_movil,
            $this->monto_usd_efectivo,
            $this->monto_usd_zeller,
            $this->campo1,
            $this->campo2,
            $this->campo3,
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

    // Método para obtener resúmenes de montos
    public static function getResumenes() {
        $sql = "SELECT 
            SUM(monto_bs_efectivo) as total_bs_efectivo,
            SUM(monto_bs_transf) as total_bs_transf,
            SUM(monto_usd_efectivo) as total_usd_efectivo,
            COUNT(*) as total_registros
        FROM " . self::$tablename . " WHERE estatus = 1";
        
        $query = Executor::doitArr($sql);
        
        if (!empty($query)) {
            $r = $query[0];
            return array(
                'total_bs_efectivo' => (float)$r['total_bs_efectivo'],
                'total_bs_transf' => (float)$r['total_bs_transf'],
                'total_usd_efectivo' => (float)$r['total_usd_efectivo'],
                'total_registros' => (int)$r['total_registros']
            );
        } else {
            return array(
                'total_bs_efectivo' => 0,
                'total_bs_transf' => 0,
                'total_usd_efectivo' => 0,
                'total_registros' => 0
            );
        }
    }

    // Método para obtener registros paginados
    public static function getPaginated($page = 1, $perPage = 10, $search = '') {
        $offset = ($page - 1) * $perPage;
        
        $sql = "SELECT * FROM " . self::$tablename . " WHERE 1=1";
        $params = array();
        
        if (!empty($search)) {
            $sql .= " AND (co_ven LIKE ? OR turno LIKE ?)";
            $searchTerm = "%" . $search . "%";
            $params[] = $searchTerm;
            $params[] = $searchTerm;
        }
        
        $sql .= " ORDER BY id DESC OFFSET ? ROWS FETCH NEXT ? ROWS ONLY";
        $params[] = $offset;
        $params[] = $perPage;
        
        $query = Executor::doitArr($sql, $params);
        
        if (!empty($query)) {
            $array = array();
            $cnt = 0;
            
            foreach ($query as $r) {
                $array[$cnt] = new CajasData();
                $array[$cnt]->id = $r['id'];
                $array[$cnt]->co_ven = trim($r['co_ven']);
                $array[$cnt]->fecha = $r['fecha'];
                $array[$cnt]->turno = trim($r['turno']);
                $array[$cnt]->estatus = $r['estatus'];
                $array[$cnt]->monto_bs_efectivo = (float)$r['monto_bs_efectivo'];
                $array[$cnt]->monto_bs_transf = (float)$r['monto_bs_transf'];
                $array[$cnt]->monto_bs_bio = (float)$r['monto_bs_bio'];
                $array[$cnt]->monto_bs_pago_movil = (float)$r['monto_bs_pago_movil'];
                $array[$cnt]->monto_usd_efectivo = (float)$r['monto_usd_efectivo'];
                $array[$cnt]->monto_usd_zeller = (float)$r['monto_usd_zeller'];
                $array[$cnt]->campo1 = trim($r['campo1']);
                $array[$cnt]->campo2 = trim($r['campo2']);
                $array[$cnt]->campo3 = trim($r['campo3']);
                $cnt++;
            }
            
            return $array;
        } else {
            return array();
        }
    }

    // Método para obtener el total de registros (para paginación)
    public static function getTotalRecords($search = '') {
        $sql = "SELECT COUNT(*) as total FROM " . self::$tablename . " WHERE 1=1";
        $params = array();
        
        if (!empty($search)) {
            $sql .= " AND (co_ven LIKE ? OR turno LIKE ?)";
            $searchTerm = "%" . $search . "%";
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

    // Método para obtener datos para combo de vendedores
    public static function getVendedores() {
        $sql = "SELECT DISTINCT co_ven FROM jm_vendedor_cajas ORDER BY co_ven";
        
        $query = Executor::doitArr($sql);
        
        if (!empty($query)) {
            $array = array();
            $cnt = 0;
            
            foreach ($query as $r) {
                $array[$cnt] = new CajasData();
                $array[$cnt]->co_ven = trim($r['co_ven']);
                $cnt++;
            }
            
            return $array;
        } else {
            return array();
        }
    }
}
?>