<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estado de la Sesión</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f8fa;
            color: #333;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            padding: 25px;
        }
        h1 {
            color: #2c3e50;
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #eee;
            padding-bottom: 15px;
        }
        .session-info {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 25px;
            border-left: 4px solid #3498db;
        }
        .progress-container {
            margin: 25px 0;
        }
        .progress-label {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            font-weight: bold;
            color: #2c3e50;
        }
        .progress-bar {
            height: 25px;
            background-color: #ecf0f1;
            border-radius: 5px;
            overflow: hidden;
        }
        .progress {
            height: 100%;
            background: linear-gradient(90deg, #2ecc71, #3498db);
            border-radius: 5px;
            transition: width 0.5s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
        }
        .session-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 15px;
            margin-bottom: 25px;
        }
        .detail-card {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }
        .detail-card h3 {
            margin-top: 0;
            color: #2c3e50;
            border-bottom: 1px solid #ddd;
            padding-bottom: 8px;
        }
        .button {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
            display: inline-block;
            margin-right: 10px;
        }
        .button:hover {
            background-color: #2980b9;
        }
        .button.refresh {
            background-color: #2ecc71;
        }
        .button.refresh:hover {
            background-color: #27ae60;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            color: #7f8c8d;
            font-size: 14px;
        }
        .warning {
            color: #e74c3c;
            font-weight: bold;
        }
        .countdown {
            font-size: 1.2em;
            text-align: center;
            padding: 10px;
            background-color: #fef9e7;
            border-radius: 5px;
            margin: 15px 0;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Estado de la Sesión de Usuario</h1>
        
        <div class="session-info">
            <h2>Información de la Sesión Actual</h2>
            <div class="session-details">
                <div class="detail-card">
                    <h3>Datos de Usuario</h3>
                    <p><strong>Nombre:</strong> <span id="userName">Usuario Ejemplo</span></p>
                    <p><strong>Email:</strong> <span id="userEmail">usuario@ejemplo.com</span></p>
                    <p><strong>Rol:</strong> <span id="userRole">Administrador</span></p>
                </div>
                
                <div class="detail-card">
                    <h3>Estado de Sesión</h3>
                    <p><strong>ID de Sesión:</strong> <span id="sessionId"><?php echo session_id(); ?></span></p>
                    <p><strong>Tiempo Máximo:</strong> <span id="maxLifetime"><?php echo round(ini_get('session.gc_maxlifetime') / 60, 2); ?> minutos</span></p>
                    <p><strong>Cookie Lifetime:</strong> <span id="cookieLifetime"><?php echo round(ini_get('session.cookie_lifetime') / 60, 2); ?> minutos</span></p>
                </div>
            </div>
            
            <div class="progress-container">
                <div class="progress-label">
                    <span>Tiempo Restante de Sesión</span>
                    <span id="remainingTime">Cargando...</span>
                </div>
                <div class="progress-bar">
                    <div class="progress" id="sessionProgress" style="width: 75%">75%</div>
                </div>
            </div>
            
            <div class="countdown">
                La sesión expirará en: <span id="countdownTimer">--:--</span>
            </div>
            
            <div style="text-align: center;">
                <button class="button refresh" onclick="refreshSession()">Renovar Sesión</button>
                <button class="button" onclick="checkSession()">Verificar Estado</button>
            </div>
        </div>
        
        <div class="footer">
            <p>Sistema de Gestión de Sesiones | <?php echo date('Y'); ?></p>
        </div>
    </div>

    <script>
    // Tiempo máximo de vida de la sesión en segundos (por defecto 24 minutos)
    const maxLifetime = <?php echo ini_get('session.gc_maxlifetime'); ?>;
    let lastActivity = <?php echo isset($_SESSION['LAST_ACTIVITY']) ? $_SESSION['LAST_ACTIVITY'] : time(); ?>;
    
    // Función para calcular el tiempo restante
    function getRemainingTime() {
        const now = Math.floor(Date.now() / 1000);
        const elapsed = now - lastActivity;
        const remaining = maxLifetime - elapsed;
        
        return Math.max(0, remaining);
    }
    
    // Función para formatear el tiempo en minutos y segundos
    function formatTime(seconds) {
        const mins = Math.floor(seconds / 60);
        const secs = seconds % 60;
        return `${mins.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
    }
    
    // Función para actualizar la interfaz
    function updateSessionDisplay() {
        const remaining = getRemainingTime();
        const percentage = (remaining / maxLifetime) * 100;
        
        // Actualizar elementos de la interfaz
        document.getElementById('remainingTime').textContent = formatTime(remaining);
        document.getElementById('countdownTimer').textContent = formatTime(remaining);
        
        const progressBar = document.getElementById('sessionProgress');
        progressBar.style.width = `${percentage}%`;
        progressBar.textContent = `${Math.round(percentage)}%`;
        
        // Cambiar color según el tiempo restante
        if (percentage < 20) {
            progressBar.style.background = 'linear-gradient(90deg, #e74c3c, #c0392b)';
            document.getElementById('countdownTimer').className = 'warning';
        } else if (percentage < 50) {
            progressBar.style.background = 'linear-gradient(90deg, #f39c12, #e67e22)';
            document.getElementById('countdownTimer').className = '';
        } else {
            progressBar.style.background = 'linear-gradient(90deg, #2ecc71, #3498db)';
            document.getElementById('countdownTimer').className = '';
        }
    }
    
    // Función para renovar la sesión
    function refreshSession() {
        fetch('refresh_session.php')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    lastActivity = Math.floor(Date.now() / 1000);
                    updateSessionDisplay();
                    alert('Sesión renovada correctamente');
                } else {
                    alert('Error al renovar la sesión');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error de conexión al renovar la sesión');
            });
    }
    
    // Función para verificar el estado de la sesión
    function checkSession() {
        fetch('check_session.php')
            .then(response => response.json())
            .then(data => {
                if (data.active) {
                    alert(`Sesión activa. Tiempo restante: ${formatTime(data.remaining)}`);
                    lastActivity = data.last_activity;
                    updateSessionDisplay();
                } else {
                    alert('La sesión ha expirado. Será redirigido al login.');
                    window.location.href = 'login.php';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al verificar la sesión');
            });
    }
    
    // Actualizar la visualización cada segundo
    setInterval(updateSessionDisplay, 1000);
    
    // Inicializar la visualización
    updateSessionDisplay();
    </script>
</body>
</html>