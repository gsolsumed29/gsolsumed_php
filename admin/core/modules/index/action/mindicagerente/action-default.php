<?php
// api/get_manager_dashboard.php

header("Content-Type: application/json; charset=UTF-8");
// Asegúrate de incluir tu archivo de conexión o lógica de DB
// require_once '../core/autoload.php'; 
 $conn = new mysqli("localhost", "usuario", "password", "base_de_datos");

if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Error de conexión DB"]);
    exit;
}

// --- 1. RECIBIR FILTROS ---
 $year = isset($_GET['year']) ? intval($_GET['year']) : date("Y");
 $month = isset($_GET['month']) ? intval($_GET['month']) : 0;
 $day = isset($_GET['day']) ? $_GET['day'] : 0;

 $datos = new GerenciaData(); 
 $result = $datos->mgetAllDatosFacturacion($year,$month,$day);
 


// --- 3. CALCULAR TOTALES (WIDGETS SUPERIORES) ---
 $totalSales = 0;
 $totalOrders = 0;
 $newClients = 0;

// Ajustamos las consultas según el filtro
// Ventas Totales
 $sqlSales = "SELECT IFNULL(SUM(monto),0) as ventas FROM ventas WHERE $whereClause";
 $resSales = $conn->query($sqlSales);
if($row = $resSales->fetch_assoc()) $totalSales = $row['ventas'];



// Pedidos Totales (Asumimos tabla 'pedidos')
 $sqlOrders = "SELECT COUNT(*) as total FROM pedidos WHERE $whereClause"; 
// NOTA: Ajusta la columna de fecha en 'pedidos' si es diferente (ej: fecha_pedido)
 $resOrders = $conn->query($sqlOrders);
if($row = $resOrders->fetch_assoc()) $totalOrders = $row['total'];

// Clientes Nuevos (Registros recientes)
 $sqlClients = "SELECT COUNT(*) as total FROM clientes WHERE fecha_registro >= CURDATE() - INTERVAL 1 MONTH";
// Nota: Clientes nuevos suele ser "último mes" sin importar el filtro de ventas, pero puedes cambiarlo si deseas.
 $resClients = $conn->query($sqlClients);
if($row = $resClients->fetch_assoc()) $newClients = $row['total'];


// --- 4. CALCULAR DATOS DEL GRÁFICO (VENTAS POR MES) ---
 $chartData = [];
// El gráfico muestra los 12 meses del AÑO seleccionado
 $sqlChart = "SELECT MONTH(fecha_venta) as mes, SUM(monto) as total FROM ventas WHERE YEAR(fecha_venta) = $year GROUP BY mes ORDER BY mes ASC";

 $chartQuery = $conn->query($sqlChart);
if($chartQuery){
    while($row = $chartQuery->fetch_assoc()){
        $chartData[] = [
            "mes" => $row['mes'],
            "valor" => floatval($row['total'])
        ];
    }
}


// --- 5. OBTENER ÚLTIMAS TRANSACCIONES (TABLA) ---
 $transactions = [];
// Limitamos a 5 y ordenamos por fecha DESC filtrado por el periodo seleccionado
 $sqlTrans = "SELECT p.id, c.nombre as cliente, p.total as monto, p.estado FROM pedidos p LEFT JOIN clientes c ON p.id_cliente = c.id WHERE $whereClause ORDER BY p.id DESC LIMIT 5";

 $transQuery = $conn->query($sqlTrans);
if($transQuery){
    while($row = $transQuery->fetch_assoc()){
        $transactions[] = [
            "id" => $row['id'],
            "cliente" => $row['cliente'],
            "monto" => "Bs. " . number_format($row['monto'], 0, ',', '.'),
            "estado" => $row['estado']
        ];
    }
}

 $response = [
    "status" => "success",
    "filters_applied" => ["year" => $year, "month" => $month, "day" => $day], // Para debug
    "data" => [
        "total_sales" => $totalSales,
        "total_orders" => $totalOrders,
        "new_clients" => $newClients,
        "chart_data" => $chartData,
        "transactions" => $transactions
    ]
];

echo json_encode($response);
 $conn->close();
?>