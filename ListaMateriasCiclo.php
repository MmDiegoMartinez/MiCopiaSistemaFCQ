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
    <title>Lista Materias</title>
    <script>
    // Utiliza el historial del navegador para reemplazar la URL actual con la de SeleccionarCarreraXSemestre.php
    window.history.replaceState({}, document.title, "BuscarMaterias.php");
</script>
    <style>
    table {
        width: 700px;
        border-collapse: collapse;
        margin: 20px;
        font-family: Arial, sans-serif;
    }

    th, td {
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
        <h1><img src="iconos/FCQ_logo.png" width="80"></h1>
        <ul>
            <li><a href="IndexSecretarias.php"><img src="iconos//homelogo.png" width="20px"><br>Home</a></li>
            <li><a href="BuscarMaterias.php"><img src="iconos//back.png" width="20px"><br>Atras</a></li>
        </ul>
    </nav>

    <p>Instrucción: Al pulsar el ícono PDF, obtén la lista de alumnos con calificaciones en la materia seleccionada.</p>
<?php
// Verificar si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recibir el ciclo escolar seleccionado
    $cicloEscolar = filter_input(INPUT_POST, 'ciclo_escolar', FILTER_SANITIZE_STRING);
    $semestre = filter_input(INPUT_POST, 'semestre', FILTER_SANITIZE_STRING);
    $grupo = filter_input(INPUT_POST, 'grupo', FILTER_SANITIZE_STRING);
    $carrera = filter_input(INPUT_POST, 'carrera', FILTER_SANITIZE_STRING);

    include('funciones.php');
    $consultaMaterias = mostrarMateriasPorCicloyGradosCarrera($semestre, $grupo, $cicloEscolar, $carrera);
    echo "<table border='1'>
            <tr>
                <th>Materia</th>
                <th>Imprimir</th>
            </tr>";

            foreach ($consultaMaterias as $rowMaterias) {
                echo "<tr>
                        <td>{$rowMaterias['Nombre']}</td>
                        <td>
                            <a href='PdfKardexPorMateria.php?Clave_Materia={$rowMaterias['Clave']}&Ciclo_Escolar=$cicloEscolar&Semestre=$semestre&Grupo=$grupo&Materia={$rowMaterias['Nombre']}'>
                            <img src='iconos/pdf.png' width='32' height='32' alt='Imprimir'>
                            </a>
                        </td>
                    </tr>";
            }

        echo "</table>";
}
?>
    

</body>
</html>
