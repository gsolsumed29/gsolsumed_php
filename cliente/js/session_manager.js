 $(document).ready(function() {
    // Esta variable la inyectamos desde PHP en el siguiente paso.
    // Por ahora, la definimos aquí para que el script no falle.
    let sessionTimeout = <?php echo isset($remaining_time) ? $remaining_time : 3600; ?>;
    const warningTime = 300; // 5 minutos en segundos
    let warningTimer;
    let expirationTimer;
    let countdownInterval;

    const $modal = $('#sessionWarningModal');
    const $countdown = $('#countdown');

    function startSessionTimer() {
        // Limpiamos cualquier temporizador existente para evitar duplicados
        clearTimeout(warningTimer);
        clearTimeout(expirationTimer);
        clearInterval(countdownInterval);

        const timeUntilWarning = (sessionTimeout - warningTime) * 1000; // en milisegundos

        if (timeUntilWarning > 0) {
            // Programamos el aviso
            warningTimer = setTimeout(showWarning, timeUntilWarning);
            
            // Programamos la expiración real (por si el usuario no hace nada)
            expirationTimer = setTimeout(forceLogout, sessionTimeout * 1000);
        }
    }

    function showWarning() {
        // Mostramos el modal
        const modal = new bootstrap.Modal(document.getElementById('sessionWarningModal'));
        modal.show();

        // Iniciamos la cuenta regresiva en el modal
        let timeLeft = warningTime; // 5 minutos
        updateCountdown(timeLeft);

        countdownInterval = setInterval(() => {
            timeLeft--;
            updateCountdown(timeLeft);
            if (timeLeft <= 0) {
                clearInterval(countdownInterval);
                forceLogout();
            }
        }, 1000);
    }

    function updateCountdown(seconds) {
        const minutes = Math.floor(seconds / 60);
        const secs = seconds % 60;
        $countdown.text(`${minutes}:${secs < 10 ? '0' : ''}${secs}`);
    }

    function renewSession() {
        $.ajax({
            url: 'renew_session.php',
            type: 'POST',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    // Ocultamos el modal
                    bootstrap.Modal.getInstance(document.getElementById('sessionWarningModal')).hide();
                    
                    // Reiniciamos el temporizador con el nuevo valor
                    sessionTimeout = response.new_lifetime;
                    startSessionTimer();
                } else {
                    // Si algo sale mal, forzamos el logout
                    forceLogout();
                }
            },
            error: function() {
                alert('Error de comunicación. Tu sesión no pudo ser renovada.');
                forceLogout();
            }
        });
    }

    function forceLogout() {
        clearInterval(countdownInterval);
        alert('Tu sesión ha expirado. Serás redirigido a la página de inicio de sesión.');
        window.location.href = 'logout.php'; // Asegúrate de tener una página de logout
    }

    // --- Event Listeners ---
    $('#renewSessionBtn').on('click', function() {
        renewSession();
    });

    $('#logoutBtn').on('click', function() {
        // El usuario decide cerrar sesión manualmente
        window.location.href = 'logout.php';
    });

    // --- Inicialización ---
    // Iniciamos el temporizador cuando la página está lista
    startSessionTimer();
});