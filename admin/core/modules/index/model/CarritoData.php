<?php
class CarritoData {
	protected $cart_contents = array();
     // co_art art_des prec_vta1 qty
    public function __construct(){
        // obtengo la matriz del carrito de compras de la sesión
        $this->cart_contents = !empty($_SESSION['cart_contents'])?$_SESSION['cart_contents']:NULL;
		if ($this->cart_contents === NULL){
			// establesco algunos valores base
			$this->cart_contents = array('cart_total' => 0, 'total_items' => 0);
		}
    }
  
    /**
	 * Cart Contents: Devuelve toda la matriz del carrito.
	 * @param	bool
	 * @return	array
	 */
	public function contents(){
		// Reorganizo la mas nueva al principio
		$cart = array_reverse($this->cart_contents);

		// Elimino estos valores
		unset($cart['total_items']);
		unset($cart['cart_total']);
		$c= count($cart);
		if($c>6){

			$cart =array_slice($cart,0,NUM_ITEMS_BY_PAGE_CART);
			//var_dump($cart);
			return $cart;
		}else{
			return $cart;
		}
	
	}
	public function contents_total(){
		// Reorganizo la mas nueva al principio
		$cart = array_reverse($this->cart_contents);

		// Elimino estos valores
		unset($cart['total_items']);
		unset($cart['cart_total']);
		
			return $cart;
		
	
	}
	public function contents_filtrado($offset){
		// Reorganizo la mas nueva al principio
		$cart = array_reverse($this->cart_contents);

		// Elimino estos valores
		unset($cart['total_items']);
		unset($cart['cart_total']);
		$c= count($cart);
	
			$cart =array_slice($cart,$offset,NUM_ITEMS_BY_PAGE_CART);
			//var_dump($cart);
		
			return $cart;
	
	
	}
    
    /**
	 * Get cart item: Devuelve los detalles de un artículo de carrito específico
	 * @param	string	$row_id
	 * @return	array
	 */
	public function get_item($row_id){
		return (in_array($row_id, array('total_items', 'cart_total'), TRUE) OR ! isset($this->cart_contents[$row_id]))
			? FALSE
			: $this->cart_contents[$row_id];
	}
    
    /**
	 * Total Items: Retorna la cantidad de items
	 * @return	int
	 */
	public function total_items(){
		return $this->cart_contents['total_items'];
	}
    
    /**
	 * Cart Total: Retorna la cantidad en moneda de esos items por el precio
	 * @return	int
	 */
	public function total(){
		return $this->cart_contents['cart_total'];
	}
    
    /**
	 *Inserta artículos en el carrito y los guardamos en la sesiónn
	 * @param	array
	 * @return	bool
	 */
	public function insert($item = array()){
		  // co_art art_des prec_vta1 qty
		if(!is_array($item) OR count($item) === 0){
			return FALSE;
		}else{
            if(!isset($item['co_art'], $item['art_des'], $item['prec_vta1'], $item['qty'])){
                return FALSE;
            }else{
               
                $item['qty'] = (float) $item['qty'];
                if($item['qty'] == 0){
                    return FALSE;
                }               
				
               	$item['prec_vta1'] = (float) $item['prec_vta1'];
			
				//var_dump($numero);
                // creo un identificador único para el artículo que se inserta en el carrito
                $rowid = md5($item['co_art']);
                // obtengo la cantidad si ya está allí y lo  agréguelo
                $old_qty = isset($this->cart_contents[$rowid]['qty']) ? (int) $this->cart_contents[$rowid]['qty'] : 0;
				$old_iva = isset($this->cart_contents[$rowid]['iva']) ? (int) $this->cart_contents[$rowid]['iva'] : 0;
                // vuelvo a crear la entrada con un identificador único y una cantidad actualizada
                $item['rowid'] = $rowid;
                $item['qty'] += $old_qty;
				$item['iva'] += $old_iva;
                $this->cart_contents[$rowid] = $item;
                
                //  Guardo el artículo del carrito
                if($this->save_cart()){
                    return isset($rowid) ? $rowid : TRUE;
                }else{
                    return FALSE;
                }
            }
        }
	}
    
    /**
	 * Actualizo el carrito
	 * @param	array
	 * @return	bool
	 */
	public function update($item = array()){
		if (!is_array($item) OR count($item) === 0){
			return FALSE;
		}else{
			if (!isset($item['rowid'], $this->cart_contents[$item['rowid']])){
				return FALSE;
			}else{
				
				if(isset($item['qty'])){
					$item['qty'] = (float) $item['qty'];
					//elimino el artículo del carrito, si la cantidad es cero
					if ($item['qty'] == 0){
						unset($this->cart_contents[$item['rowid']]);
						return TRUE;
					}
				}
				
			
				$keys = array_intersect(array_keys($this->cart_contents[$item['rowid']]), array_keys($item));
				
				if(isset($item['price'])){
					$item['price'] = (float) $item['price'];
				}
			
				foreach(array_diff($keys, array('id', 'name')) as $key){
					$this->cart_contents[$item['rowid']][$key] = $item[$key];
				}
			
				$this->save_cart();
				return TRUE;
			}
		}
	}
    
    /**
	 * Save the cart array to the session
	 * @return	bool
	 */
	protected function save_cart(){
		$this->cart_contents['total_items'] = $this->cart_contents['cart_total'] = 0;
		foreach ($this->cart_contents as $key => $val){
			// make sure the array contains the proper indexes
			if(!is_array($val) OR !isset($val['prec_vta1'], $val['qty'])){
				continue;
			}
	 
			$this->cart_contents['cart_total'] += ($val['prec_vta1'] * $val['qty']);
			$this->cart_contents['total_items'] += $val['qty'];
			$this->cart_contents[$key]['subtotal'] = ($this->cart_contents[$key]['prec_vta1'] * $this->cart_contents[$key]['qty']);
		}
		
		// if cart empty, delete it from the session
		if(count($this->cart_contents) <= 2){
			unset($_SESSION['cart_contents']);
			return FALSE;
		}else{
			$_SESSION['cart_contents'] = $this->cart_contents;
			return TRUE;
		}
    }
    
    /**
	 * Remove Item: Removes an item from the cart
	 * @param	int
	 * @return	bool
	 */
	 public function remove($row_id){
		// unset & save
		unset($this->cart_contents[$row_id]);
		$this->save_cart();
		return TRUE;
	 }
     
    /**
	 * Destroy the cart: Empties the cart and destroy the session
	 * @return	void
	 */
	public function destroy(){

		$this->cart_contents = array('cart_total' => 0, 'total_items' => 0);	



		$_SESSION['cliente_des']="0";
		$_SESSION['tipo_precio']="0";
		$_SESSION['cliente_facturacion']="0";
		$_SESSION['cliente_forma']="0";

		
		unset($_SESSION['cart_contents']);
	}


	public function getAllDatos(){	
		$cart = array_reverse($_SESSION['cart_contents']);
		unset($cart['total_items']);
		unset($cart['cart_total']);
			
		//var_dump($cart);
		$e=count($cart);

		if($e>=1){
			$array = array();
			$cnt = 0;	
			foreach ($cart as $r){
			$array[$cnt] = new ArticuloData(); 
			$array[$cnt]->responsive_id ='';
			$array[$cnt]->co_art = $r['co_art'];
			$array[$cnt]->art_des = $r['art_des'];
			$array[$cnt]->prec_vta1 = $r['prec_vta1'];
			$array[$cnt]->qty = $r['qty'];
			$array[$cnt]->impuesto = $r['iva'];
			$cnt++;
			}
		return $array;
	}else{

			$array = array();
			return $array;
	}
	}


}
?>