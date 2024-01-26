

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
    <title>Página Principal de Secretarias</title>
</head>
<body>
    <nav>
        <h1><img src="iconos/FCQ_logo.png" width="80">Menu de Operaciones</h1>
        <ul>
            <li><a href="#"><img src="iconos//homelogo.png" width="20px"><br>Home</a></li>
            <li><a href="Logout.php"><img src="iconos//cerrarsesion.png" width="20px"><br>Cerrar sesión</a></li>
        </ul>
    </nav>

    <?php echo "<font color='black' face='Courier New' size=5>Hola $_SESSION[user_name] $_SESSION[user_apell]    </font>" ?>
    <div class="contenedor">
    <div class="parte">Ingresar alumno<br><br>
            <div class="parte2"><a href="AgregarAlumnos.php"><img src="iconos/ingresaralumno.png" width="110"></a></div>
        </div>
        <div class="parte">Editar alumno<br><br>
            <div class="parte2"><a href="SeleccionarCarreraXSemestre.php"><img src="iconos/editar_alumno.png" width="100"></a></div>
        </div>
        <div class="parte">Calificaciones de Alumnos<br><br>
            <div class="parte2"><a href="ElegirKardex.php"><img src="iconos/calificacionesalumno.png" width="135"></a></div>
        </div>
        <div class="parte">Laboratorios<br><br>
        <div class="parte2"><a href="ListaLaboratorios.php"><img src="iconos/laboratorios.png" width="100"></a></div>
        </div>
        <div class="parte">Editar Calificaciones<br><br>
        <div class="parte2"><a href="BuscarcalificacionesMaterias.php"><img src="iconos/Editarcali.png" width="100"></a></div>
        </div>
        </div>
    </div>

</body>
</html>
