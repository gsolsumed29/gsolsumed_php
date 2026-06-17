<?php
class FuncionesData {
	public static $tablename = "users";
	
	public function __construct(){
		$this->id = '0';
		$this->cuenta = "";
	}


	public static function getMedia($co_art){
		$archivo =$co_art.'.webp';
		$ruta= "../admin/storage/producto/".$archivo;
		//echo $ruta;
		if(file_exists($ruta)) {
    		$media= "../admin/storage/producto/".$archivo;
		}else{
			$media= "../admin/storage/producto/paquete.webp";

		}
		
		return $media;
	}

	public static function validarFacturasDiasVencidos($co_cli){
		// Validar cuantos dias vencidos tiene una factura, si las tiene
	
		$sql = "SELECT 
            co_cli, 
            MAX(DATEDIFF(DAY, fec_venc, CURRENT_TIMESTAMP)) AS dia_venc
        FROM docum_cc 
        WHERE saldo > 0 
          AND tipo_doc = 'FACT' 
          AND co_cli = '$co_cli'  
        GROUP BY co_cli
        HAVING MAX(DATEDIFF(DAY, fec_venc, CURRENT_TIMESTAMP)) > 0";

		//echo $sql;	
		$query = Executor::doitAr($sql);
		$e=count($query);
		if($e>=1){

			$array = array();
			$cnt = 0;	
			foreach($query as $r) {			
				
				$array[$cnt] = new FacturaData();  				
				$array[$cnt]->dato1 = $r['co_cli'];
				$array[$cnt]->dato2 = $r['dia_venc'];	

			$cnt++;
			}
			//var_dump($array);
			
			return $array;

		}else{

			$array = array();
			return $array;

		}
	}

	public static function validarFacturas($co_cli){
		// validaciones del pedido
	
		$sql = "SELECT 
           d.co_cli, 
           SUM(d.saldo / d.tasa) AS saldo_convertido,
           MAX(c.mont_cre) AS limite_credito
        FROM docum_cc d
        INNER JOIN clientes c ON d.co_cli = c.co_cli
        WHERE d.tipo_doc = 'FACT' 
          AND d.saldo > 0 
          AND d.co_cli = '$co_cli'  -- Cambiado de IN a = para un solo valor
        GROUP BY d.co_cli";
		
		//echo $sql;	
		$query = Executor::doitAr($sql);
		$e=count($query);
		if($e>=1){

			$array = array();
			$cnt = 0;	
			foreach($query as $r) {			
				
				$array[$cnt] = new FacturaData();  				
				$array[$cnt]->dato1 = (float)$r['saldo_convertido'];
				$array[$cnt]->dato2 = (float)$r['limite_credito'];	

			$cnt++;
			}
			//var_dump($array);
			
			return $array;

		}else{

			$array = array();
			return $array;

		}
	}

	public static function validarDiasFacturas($co_cli){
		// validaciones del pedido
	
		$sql = "select d.co_cli, CASE WHEN  max(datediff(day, fec_emis, GETDATE())) >  MAX(c.plaz_pag) THEN 0 ELSE 1 END resp,
		MAX(c.plaz_pag) plaz_pag , max(datediff(day, fec_emis, GETDATE())) dias_moro
		from docum_cc d inner join clientes c on d.co_cli = c.co_cli
		where d.tipo_doc = 'FACT' AND d.saldo > 0 and d.co_cli in ('$co_cli')
		group by d.co_cli";
		//echo $sql;	
		$query = Executor::doitAr($sql);
		$e=count($query);
		if($e>=1){

			$array = array();
			$cnt = 0;	
			foreach($query as $r) {			
				
				$array[$cnt] = new FacturaData();  				
				$array[$cnt]->dato1 = $r['resp'];	
				$array[$cnt]->dato2 = $r['plaz_pag'];		
				$array[$cnt]->dato3 = $r['dias_moro'];			

			$cnt++;
			}
			//var_dump($array);
			
			return $array;

		}else{

			$array = array();
			return $array;

		}
	}

	
	
public static function foundValorArray($tabla, $key, $valor, $clase) {
    
    $resultados = array();
    
    // Verificar si $valor contiene comas
    if (strpos($valor, ',') !== false) {
        // Separar los valores por comas, trim y filtrar vacíos
        $valores = array_filter(array_map('trim', explode(',', $valor)));
    } else {
        $valores = array($valor);
    }
    
    if (!empty($valores)) {
        // Crear marcadores de posición para la consulta IN
        $placeholders = implode(',', array_fill(0, count($valores), '?'));
        
        // Modificamos la consulta para incluir el campo de referencia
        $sql = "SELECT COUNT(c.".$key.") cuenta, c.".$key." as referencia 
                FROM ".$tabla." c 
                WHERE c.".$key." IN (".$placeholders.") 
                GROUP BY c.".$key;
        
        // Pasar los valores como parámetros para prevenir SQL injection
        $query = Executor::doitArr($sql, array_values($valores));
        
        if (count($query) >= 1) {
            $cnt = 0;
            foreach ($query as $r) {
                $array[$cnt] = new $clase();
                $array[$cnt]->id = $r['cuenta'];
                $array[$cnt]->referencia = $r['referencia']; // Añadimos el campo referencia
                $cnt++;
            }
            return $array;
        }
    }
    
    return array();
}

	public static function foundValor($tabla,$key,$valor,$clase){
	
		$sql = "SELECT COUNT(c.".$key.") as  cuenta FROM ".$tabla." c WHERE c.".$key."='".$valor."'";
		//echo $sql;	
		$query = Executor::doitAr($sql);
		$e=count($query);
		if($e>=1){

			$array = array();
			$cnt = 0;	
			foreach($query as $r) {
			
				$array[$cnt] = new $clase();  				
				$array[$cnt]->id = $r['cuenta'];
						
			$cnt++;
			}
			//var_dump($array);
			
			return $array;

		}else{

			$array = array();
			return $array;

		}
	}


	public static function foundValorComparacion($co_art_prov){
	
		$sql = "SELECT COUNT(c.co_art_prov) cuenta , c.co_art, c.co_prov FROM jm_precios_prov c WHERE c.co_art_prov='".$co_art_prov."' group by c.co_art,c.co_prov";
		//	echo $sql;	
		$query = Executor::doitAr($sql);
		$e=count($query);
		if($e>=1){

			$array = array();
			$cnt = 0;	
			foreach($query as $r) {
			
				$array[$cnt] = new FuncionesData();  				
				$array[$cnt]->id = $r['cuenta'];
				$array[$cnt]->co_art = $r['co_art'];	
				$array[$cnt]->co_prov = $r['co_prov'];
			$cnt++;
			}
			//var_dump($array);
			
			return $array;

		}else{

			$array = array();
			return $array;

		}
	}


	public static function foundValorxValor($tabla,$key,$valor,$key2,$valor2,$clase){
	
		$sql = "SELECT COUNT(c.".$key.") cuenta FROM ".$tabla." c WHERE c.".$key."='".$valor."' AND c.".$key2."=".$valor2."";
		//echo $sql;	
		$query = Executor::doitAr($sql);
		$e=count($query);
		if($e>=1){

			$array = array();
			$cnt = 0;	
			foreach($query as $r) {
			
				$array[$cnt] = new $clase();  				
				$array[$cnt]->id = $r['cuenta'];
						
			$cnt++;
			}
			//var_dump($array);
			
			return $array;

		}else{

			$array = array();
			return $array;

		}
	}


	
	public static function foundMailCliente($valor){
	
		$sql = "SELECT c.id as cuenta FROM jm_users c WHERE CAST(c.bio AS VARCHAR(MAX))='".$valor."'";
		//echo $sql;	
		$query = Executor::doitAr($sql);
		$e=count($query);
		if($e>=1){

			$array = array();
			$cnt = 0;	
			foreach($query as $r) {
			
				$array[$cnt] = new UserData();  				
				$array[$cnt]->id = $r['cuenta'];
						
			$cnt++;
			}
			//var_dump($array);
			
			return $array;

		}else{

			$array = array();
			return $array;

		}
	}

	public  function radomCodigo(){
		$alphabet = "0123456789ABCDEFGHIJKLMNOPQSTUWXYZabcdefghijqlmnopqrstuvwxyz";
		$pass = array(); //recuerde que debe declarar $pass como un array
		$alphaLength = strlen($alphabet) - 1; //poner la longitud -1 en caché
		for ($i = 0; $i < 8; $i++) {
			$n = rand(0, $alphaLength);
			$pass[] = $alphabet[$n];
		}
		return implode($pass); //convertir el array en una cadena
	}	

	public   function radomPassword(){
		$alphabet = "0123456789ABCDEFGHIJKLMNOPQSTUWXYZabcdefghijqlmnopqrstuvwxyz";
		$pass = array(); //recuerde que debe declarar $pass como un array
		$alphaLength = strlen($alphabet) - 1; //poner la longitud -1 en caché
		for ($i = 0; $i < 8; $i++) {
			$n = rand(0, $alphaLength);
			$pass[] = $alphabet[$n];
		}
		return implode($pass); //convertir el array en una cadena
	}	

	
	public  function numeroEtiqueta(){
		$alphabet = "0123456789";
		$pass = array(); //recuerde que debe declarar $pass como un array
		$alphaLength = strlen($alphabet) - 1; //poner la longitud -1 en caché
		for ($i = 0; $i < 8; $i++) {
			$n = rand(0, $alphaLength);
			$pass[] = $alphabet[$n];
		}
		return implode($pass); //convertir el array en una cadena
	}	


	public static function GetSubConsulta($co_cli){
		// validaciones del pedido
	
		$sql = "SELECT jc.*,p.*,m.*,e.*,c.* from jm_clientes jc 
		INNER JOIN jm_parroquias p ON jc.id_parroquia = p.id_parroquia
		INNER JOIN jm_municipios m ON p.id_municipio = m.id_municipio
		INNER JOIN jm_estados e ON m.id_estado = e.id_estado
		INNER JOIN jm_ciudades c ON jc.id_ciudad = c.id_ciudad
		WHERE jc.co_cli = '$co_cli'";
		
		//echo $sql;	
		$query = Executor::doitAr($sql);
		$e=count($query);
		if($e>=1){

			$array = array();
			$cnt = 0;	
			foreach($query as $r) {			
				
			$array[$cnt] = new FuncionesData(); 	
				
			$array[$cnt]->id_estado = $r['id_estado'];	
			$array[$cnt]->estado = $r['estado'];		
			$array[$cnt]->id_municipio = $r['id_municipio'];	
			$array[$cnt]->municipio = $r['municipio'];	
			$array[$cnt]->id_parroquia = $r['id_parroquia'];			
			$array[$cnt]->parroquia = $r['parroquia'];

			$array[$cnt]->id_ciudad = $r['id_ciudad'];			
			$array[$cnt]->ciudad = $r['ciudad'];

			$array[$cnt]->lat = $r['lat'];	
			$array[$cnt]->lon = $r['lon'];	
			$array[$cnt]->media = $r['media'];	
			$array[$cnt]->responsable =  trim($r['responsable']);
			$array[$cnt]->fechaNacimientoResponsable = $r['fechaNacimientoResponsable'];	
			$array[$cnt]->empresaAniversario = $r['empresaAniversario'];	
			$array[$cnt]->fechaNacimientoPropietario = $r['fechaNacimientoPropietario'];	
			$array[$cnt]->responsableCompras = $r['responsableCompras'];
			$array[$cnt]->fechaNacimientoResponsableCompras = $r['fechaNacimientoResponsableCompras'];



			$cnt++;
			}
			//var_dump($array);
			
			return $array;

		}else{

			$array = array();
			return $array;

		}
	}

	public static function getAllLogica_condicional($idPreguntaOrigen,$idPreguntaCondicional){
		// validaciones del pedido
	
		$sql = "SELECT * FROM jm_visitas_logica_condicional  WHERE id_pregunta_origen = '$idPreguntaOrigen';";
		
		//echo $sql;	
		$query = Executor::doitAr($sql);
		$e=count($query);
		if($e>=1){

			$array = array();
			$cnt = 0;	
			foreach($query as $r) {			
				
			$array[$cnt] = new FuncionesData(); 	
				
			$array[$cnt]->tipo = $r['tipo'];	
            $array[$cnt]->pregunta_observada = $r['pregunta_observada'];
            $array[$cnt]->valor_esperado = $r['valor_esperado'];
         


			$cnt++;
			}
			//var_dump($array);
			
			return $array;

		}else{

			$array = array();
			return $array;

		}
	}


	public static function foundValorDespacho($tabla,$key,$valor,$clase){
	
		$sql = "SELECT COUNT(c.".$key.") cuenta FROM ".$tabla." c WHERE c.".$key."=".$valor." and campo7='' and campo8=''" ;
		//echo $sql;	
		$query = Executor::doitAr($sql);
		$e=count($query);
		if($e>=1){

			$array = array();
			$cnt = 0;	
			foreach($query as $r) {
			
				$array[$cnt] = new $clase();  				
				$array[$cnt]->id = $r['cuenta'];
						
			$cnt++;
			}
			//var_dump($array);
			
			return $array;

		}else{

			$array = array();
			return $array;

		}
	}


	public static function getRetencionesFactura($nro_doc){
	
		$sql = "select nro_che AS nro_ret from docum_cc where nro_doc ='$nro_doc' and  tipo_doc = 'AJNM' AND campo8 = 'IVA'" ;
		//echo $sql;	
		$query = Executor::doitAr($sql);
		$e=count($query);
		if($e>=1){

			$array = array();
			$cnt = 0;	
			foreach($query as $r) {
			
				$array[$cnt] = new FuncionesData();  				
				$array[$cnt]->numero_retencion =  trim($r['nro_ret']);
						
			$cnt++;
			}
			//var_dump($array);
			
			return $array;

		}else{
			$cnt = 0;	
			$array[$cnt] = new FuncionesData();  				
				$array[$cnt]->numero_retencion = '0';
			
			return $array;

		}
	}

	function convertirFechaSimple($fecha) {
   		 return date('d/m/Y', strtotime($fecha));
	}


		
	public static function foundValorArrayCliente($tabla, $key, $valor, $clase) {
    
		$resultados = array();
		
		// Verificar si $valor contiene comas
		if (strpos($valor, ',') !== false) {
			// Separar los valores por comas, trim y filtrar vacíos
			$valores = array_filter(array_map('trim', explode(',', $valor)));
		} else {
			$valores = array($valor);
		}
		
		if (!empty($valores)) {
			// Crear marcadores de posición para la consulta IN
			$placeholders = implode(',', array_fill(0, count($valores), '?'));
			
			// Modificamos la consulta para incluir el campo de referencia
			$sql = "SELECT COUNT(c.".$key.") cuenta, c.".$key." as referencia 
					FROM ".$tabla." c 
					WHERE c.".$key." IN (".$placeholders.") 
					GROUP BY c.".$key;
			
			// Pasar los valores como parámetros para prevenir SQL injection
			$query = Executor::doitArr($sql, array_values($valores));
			
			if (count($query) >= 1) {
				$cnt = 0;
				foreach ($query as $r) {
					$array[$cnt] = new $clase();
					$array[$cnt]->id = $r['cuenta'];
					$array[$cnt]->referencia = $r['referencia']; // Añadimos el campo referencia
					$cnt++;
				}
				return $array;
			}
		}
		
		return array();
	}
	

			// --- FUNCIÓN PARA RECONVERTIR EL NÚMERO DE FACTURA ---

		/**
		 * Convierte el número de factura entre formatos
		 * @param string $numeroOriginal Número original de factura
		 * @return string Número formateado
		 */
	public function reconvertirNumeroFactura($numeroOriginal) {
			$numeroFormateado = $numeroOriginal;
			
			// CASO 1: Si el número comienza con "NF" (ej: NF12345678)
			if (substr($numeroOriginal, 0, 2) === 'NF') {
				// Extraemos el resto del número después de "NF"
				$restoDelNumero = substr($numeroOriginal, 2);
				// Reemplazamos "NF" por "50"
				$numeroFormateado = '50' . $restoDelNumero;
			}
			// CASO 2: Si el número comienza con "5" (ej: 512345678)
			elseif (substr($numeroOriginal, 0, 1) === '5' && strlen($numeroOriginal) >= 8) {
				// Verificamos si es un número normal (sin NF)
				// En este caso, podría mantener el formato original o convertirlo
				// Dependiendo de lo que necesites
				$numeroFormateado = $numeroOriginal;
			}
			// CASO 3: Si el número ya está en formato "50" (ej: 5012345678)
			elseif (substr($numeroOriginal, 0, 2) === '50') {
				// Podríamos convertirlo a NF si es necesario
				// $restoDelNumero = substr($numeroOriginal, 2);
				// $numeroFormateado = 'NF' . $restoDelNumero;
				$numeroFormateado = $numeroOriginal; // Mantiene el formato
			}
			
			return $numeroFormateado;
	}

		// --- FUNCIÓN INVERSA (si necesitas convertir de vuelta) ---

		/**
		 * Convierte número de factura de formato "50" a formato "NF"
		 * @param string $numeroOriginal Número en formato "50xxxxxx"
		 * @return string Número en formato "NFxxxxxx"
		 */
		public function convertirANF($numeroOriginal) {
			$numeroFormateado = $numeroOriginal;
			
			// Si comienza con "50", lo convertimos a "NF"
			if (substr($numeroOriginal, 0, 2) === '50') {
				$restoDelNumero = substr($numeroOriginal, 2);
				$numeroFormateado = 'NF' . $restoDelNumero;
			}
			
			return $numeroFormateado;
		}

		/**
		 * Convierte número de factura de formato "NF" a formato "50"
		 * @param string $numeroOriginal Número en formato "NFxxxxxx"
		 * @return string Número en formato "50xxxxxx"
		 */
		public function convertirA50($numeroOriginal) {
			$numeroFormateado = $numeroOriginal;
			
			// Si comienza con "NF", lo convertimos a "50"
			if (substr($numeroOriginal, 0, 2) === 'NF') {
				$restoDelNumero = substr($numeroOriginal, 2);
				$numeroFormateado = '50' . $restoDelNumero;
			}
			
			return $numeroFormateado;
		}


	
}
?>