<?php
$inactividad = 900;
// Comprobar si $_SESSION["timeout"] está establecida
if(isset($_SESSION['timeout'])){
    // Calcular el tiempo de vida de la sesión (TTL = Time To Live)
    $sessionTTL = time() - $_SESSION["timeout"];
    //echo $sessionTTL;
    
    if($sessionTTL > $inactividad){
        session_destroy();
        echo "1";
    }
    
}
?>
