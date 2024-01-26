

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


include('funciones.php');

$listamaterias = consultarmaterias();

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insertar Laboratorio</title>
</head>
<body>
    <nav>
        <h1><img src="iconos/FCQ_logo.png" width="80">Ingresar Alumnos</h1>
        <ul>
            <li><a href="IndexSecretarias.php"><img src="iconos//homelogo.png" width="20px"><br>Home</a></li>
        </ul>
    </nav>
    <div id="contenedor">
    <form method="POST" action="">
        <label for="IdLaboratorios">Número de Lab:</label><br>
        <input type="number" id="IdLaboratorios" name="IdLaboratorios"  required><br>
        <br>
        <label for="nombre">Nombre de Lab:</label><br>
        <input type="text" id="nombre" name="nombre" required><br>
        <label for="jefe">Numero de Empleado del Encargado:</label><br>
        <input type="number" id="jefe" name="jefe" required><br>
        <label for="materia">Asigna su signatura Principal:</label><br>
        <select id="materia" name="materia" required>
                <?php
                    while ($row = $listamaterias->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='{$row['Nombre']}'>{$row['Nombre']}</option>";
                    }
                ?></select>
        <input type="submit" value="Enviar">
    </form>
</div>
</body>
</html>


<?php



// Verificar si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario de login y filtrar
    
        $idLab = isset($_POST['IdLaboratorios']) ? filter_var($_POST['IdLaboratorios'], FILTER_SANITIZE_STRING) : '';
        $nombreLab = isset($_POST['nombre']) ? filter_var($_POST['nombre'], FILTER_SANITIZE_STRING) : '';
		$jefeLab = isset($_POST['jefe']) ? filter_var($_POST['jefe'], FILTER_SANITIZE_STRING) : '';
        $nombreMateria = isset($_POST['materia']) ? filter_var($_POST['materia'], FILTER_SANITIZE_STRING) : '';

        $mensaje = insertarLaboratorios($idLab, $nombreLab, $jefeLab, $nombreMateria);
        echo $mensaje;
   
}

?>