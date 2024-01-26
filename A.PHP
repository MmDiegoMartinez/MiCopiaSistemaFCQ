
<?php

include('funciones.php');

// Verificar si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario de login y filtrar
    
        $idLab = isset($_POST['IdLaboratorios']) ? filter_var($_POST['IdLaboratorios'], FILTER_SANITIZE_STRING) : '';
        $nombreLab = isset($_POST['nombre']) ? filter_var($_POST['nombre'], FILTER_SANITIZE_STRING) : '';
		$jefeLab = isset($_POST['jefe']) ? filter_var($_POST['jefe'], FILTER_SANITIZE_STRING) : '';
        echo "IdLaboratorios: " . $idLab . "<br>";
echo "Nombre: " . $nombreLab . "<br>";
echo "Jefe: " . $jefeLab . "<br>";

        //$mensaje = insertarLaboratorios($idLab, $nombreLab, $jefeLab);
        //echo $mensaje;
   
}

?>