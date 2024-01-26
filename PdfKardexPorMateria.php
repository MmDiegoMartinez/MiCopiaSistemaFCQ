<?php
include_once "funciones.php";
conectarDB();
require_once('tcpdf/tcpdf.php');

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    // Obtener los parámetros de la URL
    $nombre_materia = $_GET["Materia"];
    $clave_materia = $_GET["Clave_Materia"];
    $ciclo_escolar = $_GET["Ciclo_Escolar"];
    $semestre = $_GET["Semestre"];
    $grupo = $_GET["Grupo"];
    // Imprimir variables en el log de errores
    generarPDFCalificacionesMateria($clave_materia, $ciclo_escolar, $semestre, $grupo, $nombre_materia );
    exit;
}

include('funciones.php');
// Puedes agregar un formulario aquí si necesitas algún parámetro adicional

// Si no se ha enviado una fecha, muestra el formulario
?>
<!DOCTYPE html>
<html>

<head>
    <title>Calificaciones por Materia</title>
</head>

<body>
    <h1>Calificaciones por Materia</h1>
    <!-- Puedes agregar un formulario aquí si necesitas algún parámetro adicional -->
</body>

</html>

<?php
include('funciones.php');
//Generar Calificaciones por Materia
generarPDFCalificacionesMateria($clave_materia, $ciclo_escolar, $semestre, $grupo, $nombre_materia);
?>
