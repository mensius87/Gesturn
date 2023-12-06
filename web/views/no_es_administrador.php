
 <?php
 if ($_SESSION['Administrador'] == 0) {
    echo'<script type="text/javascript">
            alert("No tienes privilegios de administrador");
            window.location.href="../../index.php";
        </script>';
 }
 ?>