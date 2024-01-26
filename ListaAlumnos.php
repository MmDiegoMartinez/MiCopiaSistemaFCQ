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
    <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate, max-age=0">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title>Lista alumnos</title>
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
<script>
    // Utiliza el historial del navegador para reemplazar la URL actual con la de SeleccionarCarreraXSemestre.php
    window.history.replaceState({}, document.title, "SeleccionarCarreraXSemestre.php");
</script>

</head>

<body>
    <nav>
        <h1><img src="iconos/FCQ_logo.png" width="80">Selector de Carreras y Grupos</h1>
        <ul>
            <li><a href="IndexSecretarias.php"><img src="iconos//homelogo.png" width="20px"><br>Home</a></li>
            <li><a href="SeleccionarCarreraXSemestre.php"><img src="iconos//back.png" width="20px"><br>Atras</a></li>
        </ul>
    </nav>
    <?php
        // Verificar si se ha enviado el formulario
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            include('funciones.php');

            // Recibe los parametros del formulario de SeleccionarCarreraXSemestre.php
            $carrera = isset($_POST['carrera']) ? filter_var($_POST['carrera'], FILTER_SANITIZE_STRING) : '';
            $semestre = isset($_POST['semestre']) ? filter_var($_POST['semestre'], FILTER_SANITIZE_STRING) : '';
            $grupo = isset($_POST['grupo']) ? filter_var($_POST['grupo'], FILTER_SANITIZE_STRING) : '';
            
            
        }
         //echo "<td>" . htmlspecialchars($value["Matricula"]) . "</td>";
        ?>  
    <p>Lista de los alumnos del <?php echo htmlspecialchars($semestre); ?> <?php echo htmlspecialchars($grupo); ?></p>
    <table>
        <tr>
            <td>Matricula</td>
            <td>Nombre</td>
            <td>Apellidos</td>
            <td>Sexo</td>
            <td>Teléfono</td>
            <td>Correo</td>
            <td>Grupo</td>
            <td>Semestre</td>
            <td>Editar</td>
            <td>Eliminar</td>
        </tr>

        <?php
        // Verificar si se ha enviado el formulario
        
            // Consultar alumnos
            $registros = consultarAlumnos($carrera, $semestre, $grupo);

            foreach ($registros as $value) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($value["Matricula"]) . "</td>";
                echo "<td>" . htmlspecialchars($value["Nombre"]) . "</td>";
                echo "<td>" . htmlspecialchars($value["Apellido"]) . "</td>";
                echo "<td>" . htmlspecialchars($value["Sexo"]) . "</td>";
                echo "<td>" . htmlspecialchars($value["Telefono"]) . "</td>";
                echo "<td>" . htmlspecialchars($value["Correo"]) . "</td>";
                echo "<td>" . htmlspecialchars($value["Semestre"]) . "</td>";
                echo "<td>" . htmlspecialchars($value["Grupo"]) . "</td>";
                echo "<td>";
                echo "<a href='EditarAlumnos.php?Matricula_Alumno=" . htmlspecialchars($value['Matricula']) . "&Semestre=" . htmlspecialchars($value['Semestre']) . "&Grupo=" . htmlspecialchars($value['Grupo']) . "&Clave=" . htmlspecialchars($value['Clave']) .  "'>";
                echo "<img src='iconos/editar.png' width='32' height='32'></a>";
                echo "</td>";
            
                echo "<td>";
                echo "<a href='ConfirmacionEliminarAlumno.php?Matricula_Alumno=" . htmlspecialchars($value['Matricula']) . "&Semestre=" . htmlspecialchars($value['Semestre']) . "&Grupo=" . htmlspecialchars($value['Grupo']) . "&Clave=" . htmlspecialchars($value['Clave']) . "'>";
                echo "<img src='iconos/eliminar.png' width='32' height='32'></a>";
                echo "</td>";
            
                echo "</tr>";
            }

        ?>  
    </table>
    
</body>
</html>
