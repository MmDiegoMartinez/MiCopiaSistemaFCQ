

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
    <title>Ingresando Alumnos</title>
</head>
<body>
    <nav>
        <h1><img src="iconos/FCQ_logo.png" width="80">Ingresar Alumnos</h1>
        <ul>
            <li><a href="IndexSecretarias.php"><img src="iconos//homelogo.png" width="20px"><br>Home</a></li>
        </ul>
    </nav>
    <div id="contenedor">
        <p>Complete todos los campos y envíe el formulario.</p>
    <form method="POST" action="AgregarAlumnos.php">
        <label for="matricula">Matrícula:</label><br>
        <input type="number" id="matricula" name="matricula" min="100000" max="999999" required><br>
        <br>
        <label for="nombre">Nombre:</label><br>
        <input type="text" id="nombre" name="nombre" required><br>
        <label for="apellidos">Apellidos:</label><br>
        <input type="text" id="apellidos" name="apellidos" required><br>

        <input type="radio" id="sexo1_femenino" name="sexo1" value="Femenino"> Mujer
        <input type="radio" id="sexo1_masculino" name="sexo1" value="Masculino" required> Hombre


        <label for="telefono">Teléfono:</label><br>
        <input type="number" id="telefono" name="telefono" required><br>
        <label for="correo">Correo:</label><br>
        <input type="email" id="correo" name="correo" required><br>
        <label for="grupo">Grupo:</label><br>
        <input type="text" id="grupo" name="grupo" required><br>
        <label for="semestre">Semestre:</label><br>
        <input type="number" id="semestre" name="semestre" min="1" max="12" required><br>
        <input type="submit" value="Enviar">
    </form>
</div>


</body>
</html>


<?php

include('funciones.php');

// Verificar si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario de login y filtrar
    
        $matricula = isset($_POST['matricula']) ? filter_var($_POST['matricula'], FILTER_SANITIZE_STRING) : '';
        $nombre = isset($_POST['nombre']) ? filter_var($_POST['nombre'], FILTER_SANITIZE_STRING) : '';
		$apellidos = isset($_POST['apellidos']) ? filter_var($_POST['apellidos'], FILTER_SANITIZE_STRING) : '';
		$telefono = isset($_POST['telefono']) ? filter_var($_POST['telefono'], FILTER_SANITIZE_STRING) : '';
		$correo = isset($_POST['correo']) ? filter_var($_POST['correo'], FILTER_SANITIZE_STRING) : '';
        $grupo = isset($_POST['grupo']) ? filter_var($_POST['grupo'], FILTER_SANITIZE_STRING) : '';
        $semestre =isset($_POST['semestre']) ? filter_var($_POST['semestre'], FILTER_SANITIZE_STRING) : '';
		//Determinar Que Opción Se Eligió En Los Radio
		
        if (isset($_REQUEST['sexo1'])) {
            if ($_REQUEST['sexo1'] == "Masculino") {
                $sexo = 'Hombre';
            } else if ($_REQUEST['sexo1'] == "Femenino") {
                $sexo = 'Mujer';
            }
        }       

        $mensaje = insertarAlumno($matricula, $nombre, $apellidos, $sexo, $telefono, $correo, $semestre, $grupo);
        echo $mensaje;
   
}

?>