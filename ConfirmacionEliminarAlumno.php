<?php
session_start();
if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    header("Location: LoginSecretarias.php");
    exit();
}
$inactive_time = 1800;

if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $inactive_time)) {
    // Si ha pasado demasiado tiempo, cerrar sesión
    session_unset();
    session_destroy();
    header("Location: LoginSecretarias.php");
    exit();
}
// Actualizar la marca de tiempo de la última actividad
$_SESSION['last_activity'] = time();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>confirmacion eliminar</title> 
</head>
<body>
<?php
$matriculalumno = isset($_GET['Matricula_Alumno']) ? filter_var($_GET['Matricula_Alumno'], FILTER_SANITIZE_STRING) : '';
$carrera = isset($_GET['Clave']) ? filter_var($_GET['Clave'], FILTER_SANITIZE_STRING) : '';
$semestre = isset($_GET['Semestre']) ? filter_var($_GET['Semestre'], FILTER_SANITIZE_STRING) : '';
$grupo = isset($_GET['Grupo']) ? filter_var($_GET['Grupo'], FILTER_SANITIZE_STRING) : '';


include('funciones.php');
$registros = consultarAlumnosWhereMatricula($matriculalumno);
?>
<div class="">
    <h4>¿Estás seguro de eliminar al alumno?</h4>
    <form method="POST" action="ListaAlumnos.php" name="">
        <input class="controls" type="hidden" id="carrera" name="carrera" value="<?php echo $carrera ?> ">
        <input class="controls" type="hidden" id="semestre" name="semestre" value="<?php echo $semestre ?> ">
        <input class="controls" type="hidden" id="grupo" name="grupo" value="<?php echo $grupo ?> ">
        <input class="bontons" type="submit" value="Regresar">
    </form>
    <form method="post" action="EliminarAlumno.php">
        <input type="hidden" name="matricula" value="<?php echo $registros['Matricula'];?>">
        <input class="bontons" type="submit" value="Eliminar">
    </form>
</div>
</body>
</html>
