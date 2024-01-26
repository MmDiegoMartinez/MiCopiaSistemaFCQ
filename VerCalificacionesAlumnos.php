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
    <title>Datos </title>
    <script>
    // Utiliza el historial del navegador para reemplazar la URL actual con la de SeleccionarCarreraXSemestre.php
    window.history.replaceState({}, document.title, "BuscarAlumno.php");
</script>
    <style>
        table {
            width: 700px;
            border-collapse: collapse;
            margin: 20px;
            font-family: Arial, sans-serif;
        }

        th,
        td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #e0e0e0;
        }
    </style>
</head>
<body>
<nav>
        <h1><img src="iconos/FCQ_logo.png" width="80">Perfil Académico</h1>
        <ul>
            <li><a href="IndexSecretarias.php"><img src="iconos//homelogo.png" width="20px"><br>Home</a></li>
            <li><a href="BuscarAlumno.php"><img src="iconos//back.png" width="20px"><br>Atras</a></li>
        </ul>
    </nav>
<?php
    // Obtener matricula y ciclo escolar del formulario POST
    $numero_matricula = isset($_POST['matricula']) ? filter_var($_POST['matricula'], FILTER_SANITIZE_STRING) : '';
    $ciclo_escolar = isset($_POST['ciclo_escolar']) ? filter_var($_POST['ciclo_escolar'], FILTER_SANITIZE_STRING) : '';
    include('funciones.php');
    mostrarInformacionAlumno($numero_matricula, $ciclo_escolar);
    ?>
    <form method="post" action="PdfKardexAlumno.php">
        <input type="hidden" name="matricula" value="<?php echo $numero_matricula; ?>">
        <input type="hidden" name="ciclo_escolar" value="<?php echo $ciclo_escolar; ?>">
        <p>Instrucción: Al presionar "Generar PDF", el sistema procesará el Kardex y estará listo para descargar.</p>
        <button type="submit">Generar PDF</button>
    </form>
</body>
</html>
