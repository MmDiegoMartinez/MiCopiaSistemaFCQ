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
        <h1><img src="iconos/FCQ_logo.png" width="80">Lista Alumnos</h1>
        <ul>
            <li><a href="IndexSecretarias.php"><img src="iconos//homelogo.png" width="20px"><br>Home</a></li>
            <li><a href="BuscarcalificacionesMaterias.php"><img src="iconos//back.png" width="20px"><br>Atras</a></li>
        </ul>
    </nav>
    <?php
       
            

            $cicloEscolar= isset($_GET['Ciclo_Escolar']) ? filter_var($_GET['Ciclo_Escolar'], FILTER_SANITIZE_STRING) : '';
            $semestre= isset($_GET['Semestre']) ? filter_var($_GET['Semestre'], FILTER_SANITIZE_STRING) : '';
            $grupo= isset($_GET['Grupo']) ? filter_var($_GET['Grupo'], FILTER_SANITIZE_STRING) : '';
            $claveMateria= isset($_GET['Clave_Materia']) ? filter_var($_GET['Clave_Materia'], FILTER_SANITIZE_STRING) : '';
            $materiaNombre= isset($_GET['Materia']) ? filter_var($_GET['Materia'], FILTER_SANITIZE_STRING) : '';
            $carrera = isset($_GET['Carrera']) ? filter_var($_GET['Carrera'], FILTER_SANITIZE_STRING) : '';
            include('funciones.php');
            $resultados =  AlumnosyCalificaciones($semestre, $grupo, $claveMateria, $cicloEscolar,$carrera);
        ?>  
    <p>Lista de los alumnos de  <?php echo htmlspecialchars($semestre); ?> <?php echo htmlspecialchars($grupo); ?> y sus calificaciones de la materia  <?php echo htmlspecialchars($materiaNombre); ?> en el ciclo <?php echo htmlspecialchars($cicloEscolar); ?></p>
    <table>
        <tr>
            <td>Matricula</td>
            <td>Nombre</td>
            <td>Apellidos</td>
            <td>Calificacion</td>
            <td>Editar</td>
        </tr>
        <?php

            foreach ($resultados as $value) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($value["Matricula"]) . "</td>";
                echo "<td>" . htmlspecialchars($value["Nombre"]) . "</td>";
                echo "<td>" . htmlspecialchars($value["Apellido"]) . "</td>";
                echo "<td>" . htmlspecialchars($value["Calificacion"]) . "</td>";
                echo "<td>";
                echo "<a href='EditarCalificacion.php?Matricula_Alumno=" . htmlspecialchars($value['Matricula']) ."&Clave_Materia=" . htmlspecialchars($value['Clave_Materia']) ."&Calificacion=" .htmlspecialchars($value['Calificacion']) .
                "&Nombre=" .htmlspecialchars($value['Nombre']) ."&Apellido=" .htmlspecialchars($value["Apellido"])."&Materia=" .htmlspecialchars($value["Materia"])."&Ciclo=" .htmlspecialchars($value["Ciclo_Escolar"]) ."&Carrera=" .htmlspecialchars($carrera) .  "'>";
                echo "<img src='iconos/Editarcali.png' width='32' height='32'></a>";
                echo "</td>";
                echo "</tr>";
            }
        ?>  
    </table>
    
</body>
</html>
