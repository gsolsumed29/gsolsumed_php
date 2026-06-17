<?php
class DocumentosData {
	public static $tablename = "factura";
	//co_cli cli_des rif saldo
	public function __construct(){
		$this->responsive_id = '';
		$this->id = '0';
		$this->dato1 = '0';
		$this->dato2 = '0';
		$this->dato3 = '0';

		$this->co_cli = '0';
		$this->cli_des = '0';
		$this->rif = '0';
		$this->saldo = '0';
		$this->nro_doc = '0';
		$this->fec_emis = '0';
		$this->tipo_doc = '0';


	}

public static function getDataFacturas($s) {
    $hoy = getdate();
    $anio = $hoy['year'];
    
    // Manejo de estatus basado en el parámetro $s
    $estatus = "";
    if($s == 1){
        $estatus = "AND c.numcon = '' ";
    } else if($s == 2){
        $estatus = "AND c.numcon <> '' ";
    }

    $sql = "
        SELECT
            c.fact_num AS fact_num,      
            cl.cli_des,
            cl.email, -- Lo agregamos para el reenvío de correo
            CONVERT(VARCHAR, c.fec_emis, 103) AS fec_emis,
            CONVERT(VARCHAR, c.fec_emis, 103) AS fec_venc,          
            c.tot_neto/c.tasa as saldo_usd,
            c.numcon,
            u.url,
            c.anulada
            
        FROM 
            factura c 
            INNER JOIN clientes cl ON c.co_cli = cl.co_cli
            LEFT JOIN jm_facturacion_url u ON c.fact_num = u.fact_num 
            AND u.tipo_doc = 'FACT' 
        WHERE 
            c.fact_num < 5000000
            AND YEAR(c.fec_emis) = " . intval($anio) . "            
            AND c.aux01 <> '1'       
            $estatus
        ORDER BY          
            c.fact_num ASC
    ";

    $query = Executor::doitAr($sql);
    $array = array();

    if (count($query) >= 1) {
        foreach ($query as $r) {
            $data = new DocumentosData();          
            $data->fact_num = $r['fact_num'];      
            $data->cli_des = trim($r['cli_des']);
            $data->email = trim($r['email']); 
            $data->saldo_usd = (float)$r['saldo_usd'];          
            $data->fec_emis = $r['fec_emis'];
            $data->fec_venc = $r['fec_venc'];
            $data->status = intval($s); // El estatus ahora refleja el parámetro recibido
            $data->anulada = trim($r['anulada']);

            if($s == 2){
                $data->num_control = trim($r['numcon']);
                // Asignamos la URL traída de la base de datos
                $data->url_fiscal = !empty($r['url']) ? trim($r['url']) : "";
            } else {
                $data->num_control = "";
                $data->url_fiscal = "";
            }
            $data->fec_venc = $r['fec_venc'];

            $array[] = $data;
        }
    }

    return $array;
}

public static function getDataNotas($s) {
    $hoy = getdate();
    $anio = $hoy['year'];
    // echo $s;
    // Manejo de estatus basado en el parámetro $s
    $estatus = "";
    if($s == 1){
        $estatus = "AND c.numcon = '' ";
    } else if($s == 2){
        $estatus = "AND c.numcon <> '' ";
    }




    
     
    $sql = "
        SELECT
            c.fact_num AS fact_num,      
            cl.cli_des,
            cl.email,   
            v.email as email_vendedor, -- Correo del vendedor para reenvío
            v.ven_des,
            CONVERT(VARCHAR, c.fec_emis, 103) AS fec_emis,
			CONVERT(VARCHAR, c.fec_emis, 103) AS fec_venc,          
            c.tot_neto/c.tasa as saldo_usd,
            c.numcon,  c.anulada
        FROM 
            factura c 
            INNER JOIN clientes cl ON c.co_cli = cl.co_cli
            INNER JOIN vendedor v ON v.co_ven = c.co_ven
          
        WHERE 
			c.fact_num >= 5000000
            AND YEAR(c.fec_emis) = " . intval($anio) . "            
            AND c.aux01 <> '1'       
            $estatus
        ORDER BY          
            c.fact_num ASC
    ";
	//echo  $sql;
    $query = Executor::doitAr($sql);
    $array = array();

    if (count($query) >= 1) {
        foreach ($query as $r) {
            $data = new DocumentosData();          
            $data->fact_num = $r['fact_num'];      
            $data->cli_des = trim($r['cli_des']);         
            $data->email = trim($r['email']); // Agregar el correo del cliente
            $data->email_vendedor = trim($r['email_vendedor']); // Agregar el correo del cliente
            $data->saldo_usd = (float)$r['saldo_usd'];          
            $data->anulada = trim($r['anulada']);
            $data->fec_emis = $r['fec_emis'];
            $data->fec_venc = $r['fec_venc']; // 1 o 6
            $data->status = 1;
            // Solo retornamos el num_control si $s es igual a 2
            if($s == 2){
                $data->num_control = trim($r['numcon']);
            } else {
                $data->num_control = ""; // Opcional: vacío para documentos pendientes
            }

            $array[] = $data;
        }
    }

    return $array;
}


public static function getDataNotasDevolciones($s) {
    $hoy = getdate();
    $anio = $hoy['year'];
    
    // 1. Manejo de estatus de conciliación (siguiendo tu estándar anterior)
    $estatus = "";
    if($s == 1){
        $estatus = "AND c.numcon = '' ";
    } else if($s == 2){
        $estatus = "AND c.numcon <> '' ";
    }






    // 2. SQL simplificado apuntando a dev_cli (Devoluciones/Notas de Crédito)
    $sql = "
        SELECT DISTINCT
            c.nc_num AS fact_num,      
            cl.cli_des,
             c.fact_num as fact_num_nc,
            CONVERT(VARCHAR, c.fec_emis, 103) AS fec_emis,
            CONVERT(VARCHAR, c.fec_emis, 103) AS fec_venc,          
            c.tot_neto / CASE WHEN c.tasa <= 0 THEN 1 ELSE c.tasa END as saldo_usd,
            rd.num_doc AS fact_afectada,
            c.numcon,
            u.url  ,
            c.anulada

        FROM 
            dev_cli c 
            INNER JOIN clientes cl ON c.co_cli = cl.co_cli
            INNER JOIN reng_dvc rd ON rd.fact_num = c.fact_num
            LEFT JOIN jm_facturacion_url u ON c.nc_num = u.fact_num 
            AND u.tipo_doc = 'DEV' 
        WHERE 
            c.nc_num < 5000000 
            AND YEAR(c.fec_emis) = " . intval($anio) . "            
            AND c.campo2 <> '1' 
            $estatus
        ORDER BY          
            c.nc_num ASC
    ";
   //echo $sql;
    $query = Executor::doitAr($sql);
    $array = array();

    if (count($query) >= 1) {
        foreach ($query as $r) {
            $data = new DocumentosData();          
            $data->fact_num = $r['fact_num'];   
            $data->fact_num_nc = $r['fact_num_nc'];      
            $data->cli_des = $r['cli_des'];  
            $data->fact_afectada = $r['fact_afectada'];                 
            $data->saldo_usd = (float)$r['saldo_usd'];          
            $data->fec_emis = $r['fec_emis'];
            $data->fec_venc = $r['fec_venc']; 
            $data->status = 1; // Documento activo
            $data->anulada = trim($r['anulada']);
            if($s == 2){
                $data->num_control = trim($r['numcon']);
                // Asignamos la URL traída de la base de datos
                $data->url_fiscal = !empty($r['url']) ? trim($r['url']) : "";
            } else {
                $data->num_control = "";
                $data->url_fiscal = "";
            }
            $array[] = $data;
        }
    }

    return $array;
}

public static function getDataNCRAdministrativas($s) {
    
        $estatus = "";
            if($s == 1){
                $estatus = "AND d.numcon = '' ";
            } else if($s == 2){
                $estatus = "AND d.numcon <> '' ";
            }


		$sql = "
			select 
			d.nro_doc as fact_num, 
			c.cli_des,		
			CONVERT(VARCHAR, d.fec_emis, 103) AS fec_emis,
			CONVERT(VARCHAR, d.fec_emis, 103) AS fec_venc,
			d.monto_net/d.tasa as saldo_usd,
            d.nro_orig as fact_afectada	,
            d.numcon,
            u.url     ,
            d.anulado as anulada
			
			from 
				docum_cc d 
			inner 
				join clientes c  on c.co_cli = d.co_cli
                LEFT JOIN jm_facturacion_url u ON d.nro_doc = u.fact_num 
                AND u.tipo_doc = 'N/CR' AND u.aut = 0
			where
				d.tipo_doc = 'N/CR'
				and d.aut = 0 
				and d.nro_doc < 5000000 
                AND CAST(d.aux01 AS INT) <> 1  
                $estatus
			ORDER BY d.fec_emis ASC
		";
		//echo  $sql;
			$query = Executor::doitAr($sql);
			$array = array();

			if (count($query) >= 1) {
				foreach ($query as $r) {
					$data = new DocumentosData();          
					$data->fact_num = trim($r['fact_num']);      
					$data->cli_des = trim($r['cli_des']); 
                    $data->fact_afectada = trim($r['fact_afectada']);                    
					$data->saldo_usd = (float)$r['saldo_usd'];          
				
					$data->fec_emis = $r['fec_emis'];
					$data->fec_venc = $r['fec_venc']; // 1 o 6
					$data->status = 1;
                    $data->anulada = trim($r['anulada']);
                    if($s == 2){
                        $data->num_control = trim($r['numcon']);
                        // Asignamos la URL traída de la base de datos
                        $data->url_fiscal = !empty($r['url']) ? trim($r['url']) : "";
                    } else {
                        $data->num_control = "";
                        $data->url_fiscal = "";
                    }
					$array[] = $data;
				}
			}

			return $array;
	
}


public static function getDataFacturasDocumentosNotas($tipo_documento) {

		$sql = "
			select 
			d.co_cli,
			c.cli_des,
			d.fec_emis,
			

			d.nro_doc as fact_num, 
			d.tasa,
			
			d.monto_imp as monto_iva, 
			d.monto_bru as subtotal, 
			d.monto_otr as exento,
			d.monto_net as monto_total,
			(d.monto_bru - d.monto_otr) as monto_base_imponible,
			d.tipo_doc,
			c.campo3 as email, 
			d.nro_orig -- PARA PRUEBA DOCUMENTO
			from docum_cc d 
			inner join clientes c  on c.co_cli = d.co_cli
			where  (d.tipo_doc = 'N/CR' or d.tipo_doc = 'N/DB')
			and d.aut = 0 
			and d.nro_doc < 5000000 
			and  d.anulado=0 
			ORDER BY d.fec_emis ASC
		";
		//echo $sql;
		$query = Executor::doitAr($sql);
	
		if (count($query) >= 1) {
			$array = array();
			foreach ($query as $cnt => $r) {
				$array[$cnt] = new FacturaData();
				$array[$cnt]->responsive_id = "";
				$array[$cnt]->co_cli = $r['co_cli'];
				$array[$cnt]->fact_num = $r['fact_num'];
				$array[$cnt]->cli_des = $r['cli_des'];
				$array[$cnt]->fec_emis = $r['fec_emis'];
				$array[$cnt]->saldo_bs = (float)$r['monto_total'];
				$array[$cnt]->tasa = (float)$r['tasa'];
				$array[$cnt]->iva = 1;
				$array[$cnt]->email =trim($r['email']);
				$array[$cnt]->nro_orig =trim($r['nro_orig']);
				$array[$cnt]->tipo_doc = $r['tipo_doc'];

				if($r['tipo_doc']=='N/CR'){
					$t = 3;
				}else{
					$t = 4;
				}
				$array[$cnt]->tipo_doc_n = intval($t);				
			
			}
			return $array;
		}
		return array();
}


    public static function getDataNDBAdministrativas($s) {
            
            $estatus = "";
                if($s == 1){
                    $estatus = "AND d.numcon = '' ";
                } else if($s == 2){
                    $estatus = "AND d.numcon <> '' ";
                }


                
        

            $sql = "
                select 
                d.nro_doc as fact_num, 
                c.cli_des,		
                CONVERT(VARCHAR, d.fec_emis, 103) AS fec_emis,
                CONVERT(VARCHAR, d.fec_emis, 103) AS fec_venc,
                d.monto_net/d.tasa as saldo_usd,			
                d.nro_orig as fact_afectada,
                d.numcon,
                u.url ,
                d.anulado as anulada
                from 
                    docum_cc d 
                inner 
                    join clientes c  on c.co_cli = d.co_cli
                    LEFT JOIN jm_facturacion_url u ON d.nro_doc = u.fact_num 
                    AND u.tipo_doc = 'N/DB' AND u.aut = 0
                where
                    d.tipo_doc = 'N/DB'
                    and d.aut = 0 
                    and d.nro_doc < 5000000 
                    AND CAST(d.aux01 AS INT) <> 1
                    $estatus
                ORDER BY d.fec_emis ASC
            ";
                //echo  $sql;
                $query = Executor::doitAr($sql);
                $array = array();

                if (count($query) >= 1) {
                    foreach ($query as $r) {
                        $data = new DocumentosData();          
                        $data->fact_num = $r['fact_num'];      
                        $data->cli_des = $r['cli_des']; 
                        $data->fact_afectada = trim($r['fact_afectada']);                      
                        $data->saldo_usd = (float)$r['saldo_usd'];          
                    
                        $data->fec_emis = $r['fec_emis'];
                        $data->fec_venc = $r['fec_venc']; // 1 o 6
                        $data->status = 1;
                        $data->anulada = trim($r['anulada']);
                        if($s == 2){
                            $data->num_control = trim($r['numcon']);
                            // Asignamos la URL traída de la base de datos
                            $data->url_fiscal = !empty($r['url']) ? trim($r['url']) : "";
                        } else {
                            $data->num_control = "";
                            $data->url_fiscal = "";
                        }
                        $array[] = $data;
                    }
                }

                return $array;
        
    }

   



    public function setFacturaNotaCreditoAdmin($fact_num, $numero_control,$tipo_doc) {
        try {
            // Iniciar transacción 

                // Construir la consulta SQL para cada lote
                $sql = "UPDATE docum_cc  SET numcon = '$numero_control' WHERE nro_doc  = '$fact_num' and  aut = 0 and tipo_doc = 'N/CR' and anulado =0 and nro_doc < 5000000  ";

                //echo $sql;
                // Ejecutar la consulta
                $result = Executor::doitEx($sql);
				
        
           
        } catch (Exception $e) {
            // En caso de excepción, hacer rollback
         
            //return ['success' => false, 'message' => 'Error al registrar lotes: ' . $e->getMessage()];
        }
    }

    public function setFacturaNotaDebitoAdmin($fact_num, $numero_control,$tipo_doc) {
        try {
            // Iniciar transacción 

                // Construir la consulta SQL para cada lote
                $sql = "UPDATE docum_cc  SET numcon = '$numero_control' WHERE nro_doc  = '$fact_num' and  aut = 0 and tipo_doc = 'N/DB' and anulado =0 and nro_doc < 5000000  ";

                //echo $sql;
                // Ejecutar la consulta
                $result = Executor::doitEx($sql);
				
        
           
        } catch (Exception $e) {
            // En caso de excepción, hacer rollback
         
            //return ['success' => false, 'message' => 'Error al registrar lotes: ' . $e->getMessage()];
        }
    }

    public function setFacturaDevolucion($fact_num, $numero_control,$tipo_doc) {
        try {
            // Iniciar transacción 

             
				  $sql = "UPDATE dev_cli  SET numcon = '$numero_control' WHERE nc_num  = '$fact_num'";

               //echo $sql;
                // Ejecutar la consulta
                $result = Executor::doitEx($sql);
        
           
        } catch (Exception $e) {
            // En caso de excepción, hacer rollback
         
            //return ['success' => false, 'message' => 'Error al registrar lotes: ' . $e->getMessage()];
        }
    }

     public function setFacturaDocum($fact_num, $numero_control,$tipo_doc,$urlConsulta=null,$campo_factura_telefono=null) {
        try {
            // Iniciar transacción

                // Construir la consulta SQL para cada lote
                $sql = "UPDATE docum_cc  SET numcon = '$numero_control' WHERE nro_doc  = '$fact_num' and  tipo_doc ='$tipo_doc'";

                //echo $sql;
                // Ejecutar la consulta
                $result = Executor::doitEx($sql);

				if ($campo_factura_telefono !== null) {
					$sql = "UPDATE factura  SET numcon = '$numero_control',  telefono = '$campo_factura_telefono' WHERE fact_num  = '$fact_num'";
				} else {
					$sql = "UPDATE factura  SET numcon = '$numero_control' WHERE fact_num  = '$fact_num'";
				}
                //echo $sql;

                // Ejecutar la consulta
                $result = Executor::doitEx($sql);
        
           
        } catch (Exception $e) {
            // En caso de excepción, hacer rollback
         
            //return ['success' => false, 'message' => 'Error al registrar lotes: ' . $e->getMessage()];
        }
    }


    
    public function addDocumentoURL($fact_num,$tipo_doc,$url,$aut) {

        try {
            // Iniciar transacción 

                $sql = "INSERT INTO jm_facturacion_url ( fact_num, url, tipo_doc, aut, estatus
                         ) VALUES ( ?, ?, ?, ?, ? )";
        
        $params = array(
            $fact_num,
            $url,
            $tipo_doc,
            $aut,
            1    
        );
        
        $result = Executor::doitArr($sql, $params);
        return !empty($result);
           
        } catch (Exception $e) {
            // En caso de excepción, hacer rollback
         
            //return ['success' => false, 'message' => 'Error al registrar lotes: ' . $e->getMessage()];
        }
    }




    
public static function getDataRetencionesIVA($s) {
    $estatus = ($s == 1) ? "AND d.numcon = '' " : "AND d.numcon <> '' ";

    $sql = "
        SELECT 
            d.nro_che AS comprobante_num, 
            c.cli_des,
            c.rif,      
            CONVERT(VARCHAR, d.fec_emis, 103) AS fec_emis,
            d.monto_bru AS base_imponible_bs, -- Monto en Bolívares
            d.monto_imp AS monto_retenido_bs,  -- Monto en Bolívares
            d.nro_orig AS fact_afectada,
            d.numcon,
            d.anulado AS anulada
        FROM 
            docum_cc d 
        INNER JOIN 
            clientes c ON c.co_cli = d.co_cli
        WHERE
            d.tipo_doc = 'AJNM' 
            AND d.campo8 = 'IVA'
            AND d.aut = 1 
            $estatus
        ORDER BY d.fec_emis DESC
    ";
     //echo $sql;
    $query = Executor::doitAr($sql);
    $array = array();

    foreach ($query as $r) {
        $data = new stdClass(); // Usamos objeto genérico para el JSON
        $data->nro_comprobante = trim($r['comprobante_num']);      
        $data->cli_des = trim($r['cli_des']); 
        $data->rif = trim($r['rif']); 
        $data->fec_emision = $r['fec_emis'];
        $data->base_imponible = (float)$r['base_imponible_bs'];          
        $data->monto_retencion = (float)$r['monto_retenido_bs'];          
        $data->anulada = (int)$r['anulada'];
        $data->num_control = trim($r['numcon']);
        
        $array[] = $data;
    }
    return $array;
}
    
}


/*
CREATE TABLE [dbo].[jm_facturacion_url](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[fact_num] [int] NULL,
	[url] [varchar](max) NULL,
	[tipo_doc] [varchar](50) NULL,
	[aut] [int] NULL,
	[estatus] [int] NULL,
 CONSTRAINT [PK_jm_facturacion_url] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO

*/


?>

