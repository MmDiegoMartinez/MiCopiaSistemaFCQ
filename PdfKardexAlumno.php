<?php
include_once "funciones.php";
conectarDB();
require_once('tcpdf/tcpdf.php');


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $numero_matricula = $_POST["matricula"];
    $ciclo_escolar = $_POST["ciclo_escolar"];
    generarPDFKardex($numero_matricula, $ciclo_escolar);
    exit;
}

include('funciones.php');
generarPDFKardex($numero_matricula, $ciclo_escolar);

// Si no se ha enviado una fecha, muestra el formulario
?>
<!DOCTYPE html>
<html>

<head>
    <title>Kardex de Calificaciones</title>
</head>

<body>
    <h1>Kardex de Calificaciones</h1>
    <!-- Puedes agregar un formulario aquí si necesitas algún parámetro adicional -->
</body>

</html>
