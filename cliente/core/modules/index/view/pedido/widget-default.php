<!-- Layout Principal -->
<div class="container-fluid py-3">
    
  

    <!-- Área de Trabajo -->
    <div class="workspace" id="pedido-workspace">
        
        <!-- Izquierda: Catálogo -->
        <div class="catalog-panel">
            <div class="filters-bar">
                <input type="text" id="search" class="input-box" placeholder="Buscar producto...">
                <select id="brand" class="input-box"><option value="">Todas Marcas</option></select>
                <select id="model" class="input-box"><option value="">Todos Modelos</option></select>
                <input type="number" id="cost" class="input-box" placeholder="Costo Máx.">
            </div>
            <div class="grid-container">
                <div class="product-grid" id="grid"></div>
            </div>
        </div>

        <!-- Derecha: Carrito -->
        <div class="summary-panel">
            <div class="summary-header">
                <h3 style="margin:0;">Detalle</h3>
              
            </div>
            <div class="cart-list" id="cart-list">
                <div style="text-align:center; color:#aaa; margin-top:50px;">
                    <i class="fa-solid fa-basket-shopping" style="font-size:3rem; opacity:0.3;"></i>
                    <p>Selecciona productos</p>
                </div>
            </div>
            <div class="summary-footer">
                <div class="row-total"><span>Subtotal</span><span id="sub">$0</span></div>
                <div class="row-total"><span>Costo Total</span><span id="cst" style="color:#e74c3c;">$0</span></div>
                <div class="row-total"><span>Ganancia</span><span id="prf" style="color:var(--accent); font-weight:600;">$0</span></div>
                <div class="grand-total">
                    <span>Total</span>
                    <span id="tot">$0</span>
                </div>
                <button class="btn-save" onclick="guardarPedido()">Confirmar Pedido</button>
            </div>
        </div>
    </div>
</div>

