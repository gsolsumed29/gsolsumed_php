<!DOCTYPE html>
<html>
<head>
    <title>Prueba JWT</title>
</head>
<body>
    <h1>Prueba de JWT</h1>
    
    <div id="login">
        <h2>Login</h2>
        <input type="text" id="username" placeholder="Usuario" value="admin">
        <input type="password" id="password" placeholder="Contraseña" value="admin123">
        <button onclick="login()">Login</button>
    </div>
    
    <div id="result" style="margin-top: 20px;"></div>
    
    <div style="margin-top: 20px;">
        <button onclick="getProfile()">Obtener Perfil</button>
        <button onclick="getAdmin()">Acceso Admin</button>
        <button onclick="refreshToken()">Refrescar Token</button>
    </div>
    
    <script>
        let token = '';
        
        async function login() {
            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;
           // url: 'admin/index.php?action=empaquetado&tipo=1&accion=2&datos=6&c=VehiculoData&a=1&t=carga&filtro=' + loteId,
            const response = await fetch('admin/index.php?action=auth&path=login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({username, password})
            });
            
            const data = await response.json();
            if (data.success) {
                token = data.token;
                showResult('Login exitoso! Token guardado.');
            } else {
                showResult('Error: ' + data.message);
            }
        }
        
        async function getProfile() {
            const response = await fetch('api.php?path=profile', {
                headers: {
                    'Authorization': 'Bearer ' + token
                }
            });
            
            const data = await response.json();
            showResult(JSON.stringify(data, null, 2));
        }
        
        async function getAdmin() {
            const response = await fetch('api.php?path=admin', {
                headers: {
                    'Authorization': 'Bearer ' + token
                }
            });
            
            const data = await response.json();
            showResult(JSON.stringify(data, null, 2));
        }
        
        async function refreshToken() {
            const response = await fetch('api.php?path=refresh', {
                method: 'POST',
                headers: {
                    'Authorization': 'Bearer ' + token
                }
            });
            
            const data = await response.json();
            if (data.success) {
                token = data.token;
                showResult('Token refrescado!');
            } else {
                showResult('Error al refrescar token');
            }
        }
        
        function showResult(text) {
            document.getElementById('result').innerHTML = '<pre>' + text + '</pre>';
        }
    </script>
</body>
</html>