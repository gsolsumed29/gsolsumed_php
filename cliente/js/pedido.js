
        $(document).ready(function() {
            // Datos Mock
           
           if ($('#pedido-workspace').length) {
            const products = [
                { id: 1, name: "Laptop Pro", brand: "Dell", model: "XPS", cost: 800, price: 1200, img: "https://picsum.photos/seed/p1/200/120" },
                { id: 2, name: "Mouse MX", brand: "Logitech", model: "Master", cost: 45, price: 99, img: "https://picsum.photos/seed/p2/200/120" },
                { id: 3, name: "Monitor 4K", brand: "Samsung", model: "G7", cost: 400, price: 650, img: "https://picsum.photos/seed/p3/200/120" },
                { id: 4, name: "Teclado K2", brand: "Keychron", model: "RGB", cost: 60, price: 90, img: "https://picsum.photos/seed/p4/200/120" },
                { id: 5, name: "Tablet Pro", brand: "Wacom", model: "Intuos", cost: 200, price: 350, img: "https://picsum.photos/seed/p5/200/120" },
                { id: 6, name: "Auriculares", brand: "Sony", model: "XM4", cost: 180, price: 300, img: "https://picsum.photos/seed/p6/200/120" }
            ];

            let cart = [];

            // Llenar Filtros
            const brands = [...new Set(products.map(p => p.brand))];
            brands.forEach(b => $('#brand').append(`<option value="${b}">${b}</option>`));

            // Render Grid
            function renderGrid() {
                const s = $('#search').val().toLowerCase();
                const b = $('#brand').val();
                const c = $('#cost').val();

                const filtered = products.filter(p => 
                    p.name.toLowerCase().includes(s) && 
                    (b === "" || p.brand === b) && 
                    (c === "" || p.cost <= c)
                );

                $('#grid').empty();
                filtered.forEach(p => {
                    $('#grid').append(`
                        <div class="p-card" onclick="addToCart(${p.id})">
                            <div class="add-btn"><i class="fa-solid fa-plus"></i></div>
                            <img src="${p.img}" class="p-img">
                            <div class="p-name">${p.name}</div>
                            <div style="font-size:0.8rem; color:#888;">${p.brand} ${p.model}</div>
                            <div style="display:flex; justify-content:space-between; align-items:center; margin-top:5px;">
                                <div class="p-price">$${p.price}</div>
                                <div class="p-cost">Costo: $${p.cost}</div>
                            </div>
                        </div>
                    `);
                });
            }

            // Event Listeners
            $('#search, #brand, #cost').on('input change', renderGrid);

            // Cart Logic
            window.addToCart = function(id) {
                const p = products.find(x => x.id === id);
                const exist = cart.find(x => x.id === id);
                if(exist) exist.qty++; else cart.push({...p, qty: 1});
                renderCart();
            };

            window.removeFromCart = function(idx) {
                cart.splice(idx, 1);
                renderCart();
            };

            window.changeQty = function(idx, delta) {
                cart[idx].qty += delta;
                if(cart[idx].qty <= 0) removeFromCart(idx);
                else renderCart();
            };

            function renderCart() {
                $('#cart-list').empty();
                let tot = 0, cst = 0;

                if(cart.length === 0) {
                    $('#cart-list').html(`<div style="text-align:center; color:#aaa; margin-top:50px;"><i class="fa-solid fa-basket-shopping" style="font-size:3rem; opacity:0.3;"></i><p>Selecciona productos</p></div>`);
                } else {
                    cart.forEach((item, idx) => {
                        const lineTot = item.price * item.qty;
                        const lineCost = item.cost * item.qty;
                        tot += lineTot; cst += lineCost;

                        $('#cart-list').append(`
                            <div class="cart-item">
                                <div class="ci-info">
                                    <h4>${item.name}</h4>
                                    <span>$${item.price} c/u</span>
                                </div>
                                <div class="ci-qty">
                                    <div class="qty-btn" onclick="changeQty(${idx}, -1)">-</div>
                                    <span>${item.qty}</span>
                                    <div class="qty-btn" onclick="changeQty(${idx}, 1)">+</div>
                                    <i class="fa-solid fa-trash" style="color:#ccc; cursor:pointer; margin-left:10px;" onclick="removeFromCart(${idx})"></i>
                                </div>
                            </div>
                        `);
                    });
                }

                $('#sub').text('$' + tot.toLocaleString());
                $('#cst').text('$' + cst.toLocaleString());
                $('#prf').text('$' + (tot - cst).toLocaleString());
                $('#tot').text('$' + tot.toLocaleString());
            }

            // Guardar
            window.guardarPedido = function() {
                const cust = $('#customer').val();
                if(!cust || !cart.length) { alert("Ingresa cliente y productos"); return; }

                const newOrder = {
                    id: Date.now(),
                    customer: cust,
                    total: parseFloat($('#tot').text().replace('$','').replace(/,/g, '')),
                    profit: parseFloat($('#prf').text().replace('$','').replace(/,/g, '')),
                    linesCount: cart.reduce((a,b)=>a+b.qty,0),
                    date: new Date().toLocaleDateString(),
                    status: 'quote'
                };

                // Guardar en LocalStorage
                let existing = JSON.parse(localStorage.getItem('erp_orders')) || [];
                existing.unshift(newOrder);
                localStorage.setItem('erp_orders', JSON.stringify(existing));

                alert("Pedido Guardado. Redirigiendo...");
                window.location.href = 'index.php?view=dashboard';
            };

            renderGrid();
          }
        });
