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
<meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate, max-age=0">
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Expires" content="0">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Alumnos</title>
</head>

<body>
<nav>
        <h1><img src="iconos/FCQ_logo.png" width="80">Editar Alumnos</h1>
        <ul>
            <li><a href="IndexSecretarias.php"><img src="iconos//homelogo.png" width="20px"><br>Home</a></li>
        </ul>
    </nav>
<?php 
    $matriculalumno = isset($_GET['Matricula_Alumno']) ? filter_var($_GET['Matricula_Alumno'], FILTER_SANITIZE_STRING) : '';
    $carrera = isset($_GET['Clave']) ? filter_var($_GET['Clave'], FILTER_SANITIZE_STRING) : '';
    $semestre = isset($_GET['Semestre']) ? filter_var($_GET['Semestre'], FILTER_SANITIZE_STRING) : '';
    $grupo = isset($_GET['Grupo']) ? filter_var($_GET['Grupo'], FILTER_SANITIZE_STRING) : '';


    include('funciones.php');
    $registros = consultarAlumnosWhereMatricula($matriculalumno);
?>

<form method="POST" action="Actualizaralumnos.php">
    <label for="matricula">Matrícula:</label><br>
    <input type="number" id="matricula" name="matricula" min="100000" max="999999" value="<?php echo $registros['Matricula'];?>" placeholder="Ingrese nueva matricula" required><br>
    <br>
    <label for="nombre">Nombre:</label><br>
    <input class="controls" type="text" id="nombre" name="nombre" value="<?php echo $registros['Nombre'];?>" placeholder="Ingrese nuevo nombre" required> </input>
    <label for="apellidos">Apellidos:</label><br>
    <input type="text" id="apellidos" name="apellidos" value="<?php echo $registros['Apellido'];?>" placeholder="Ingrese nuevo apellido" required><br>

    <label for="telefono">Teléfono:</label><br>
    <input type="number" id="telefono" name="telefono" value="<?php echo $registros['Telefono'];?>" placeholder="Ingrese nuevo telefono celular" required><br>
    <label for="correo">Correo:</label><br>
    <input type="email" id="correo" name="correo" value="<?php echo $registros['Correo'];?>" placeholder="Ingrese nuevo correo" required><br>
    <label for="grupo">Grupo:</label><br>
    <input type="text" id="grupo1" name="grupo1" value="<?php echo $registros['Grupo'];?>" placeholder="Ingrese nuevo grupo" required><br>
    <label for="semestre">Semestre:</label><br>
    <input type="number" id="semestre1" name="semestre1" min="1" max="12" value="<?php echo $registros['Semestre'];?>" placeholder="Ingrese nuevo semestre" required><br>
    <input type="submit" value="Editar">
</form>
<form method="get" action="ListaAlumnos.php">
        <input type="hidden" name="carrera" value="<?php echo $carrera;?>">
        <input type="hidden" name="semestre" value="<?php echo $semestre;?>">
        <input type="hidden" name="grupo" value="<?php echo  $grupo;?>">
        <input class="bontons" type="submit" value="Regresar">
    </form>
    <p>No deje campos vacíos</p>

</body>
</html>

