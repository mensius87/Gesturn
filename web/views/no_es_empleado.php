<?php
if ($_SESSION['Administrador'] == 1) {
    echo'<script type="text/javascript">
            alert("Sitio solo para fichaje de empleados, estás intentando acceder como administrador");
            window.location.href="../../index.php";
        </script>';
    unset($_SESSION['Administrador']);
 }

?>