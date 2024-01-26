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
    <title>Lista alumnos</title>
</head>

<body>
<?php 
    $idLaboratorio = htmlspecialchars($_GET['IdLaboratorios']);
    include('funciones.php');
    $registros = consultarLaboratoriosWhereMatricula($idLaboratorio);

    

?>
<form method="POST" action="ActualizarLabotratorio.php">
        <label for="idlab">Número de Laboratorio:</label><br>
        <input type="number" id="idlab" name="idlab" value="<?php echo $registros['IdLaboratorios']; ?>" placeholder="Ingrese nuevo numero" required><br>
        <br>
        <label for="nombre">Nombre Laboratorio:</label><br>
        <input class="controls" type="text" id="nombre" name="nombre" value="<?php echo $registros['NomLaboratorio'];?>" placeholder="Ingrese nuevo nombre" required>
         <br>
        <label for="Encargado">Encargado:</label><br>
        <input type="number" id="Encargado" name="Encargado" value="<?php echo $registros['JefeNumEmp']; ?>" placeholder="Ingrese nuevo Enacargado" required>
        <label>Solo ingresar número de empleado</label><br><br>
        <input type="submit" value="Editar">
        <p>Campos vacíos implican que la base de datos se actualizará con datos vacíos. Precaución</p>
    </form>



</body>
</html>

