

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
    <title>Lista Laboratorios</title>
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
        <h1><a href="IndexSecretarias.php"> <img src="iconos/FCQ_logo.png" width="80" alt="Logo FCQ"> </a>  Lista de Laboratorios</h1>
        <ul>
            <li><a href="IndexSecretarias.php"><img src="iconos//homelogo.png" width="20px"><br></a></li>
            <li><a href="IndexSecretarias.php"><img src="iconos//back.png" width="20px"><br></a></li>
            <li><a href="Insertarlaboratorio.php"><img src="iconos//AgreagarLaboratorios.png" width="20px"><br></a>Agregar Laboratorios</li>
        </ul>
    </nav>
    <table>
        <tr>
            <td>Numero de Laboratorio</td>
            <td>Nombre</td>
            <td>Encargado</td>
            <td>Materia</td>
            <td>Editar</td>
            
        </tr>

        <?php
        // Verificar si se ha enviado el formulario
        
            include('funciones.php');
            // Consultar laboratorios
            $registros = consultarLaboratorios();
            //$registros1 = consultarLaboratorios1();

            foreach ($registros as $value) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($value["IdLaboratorios"]) . "</td>";
                echo "<td>" . htmlspecialchars($value["NomLaboratorio"]) . "</td>";
                echo "<td>" . htmlspecialchars($value["NombreProfesor"]) ." ".htmlspecialchars($value["ApellidosProfesor"]).  "</td>";
                echo "<td>" . htmlspecialchars($value["NombreMateria"]) . "</td>";
                echo "<td>";
                echo "<a href='EditarLaboratorio.php?IdLaboratorios=" . htmlspecialchars($value['IdLaboratorios']) . "'>";
                echo "<img src='iconos/editar.png' width='32' height='32'></a>";
                echo "</td>";

               /* echo "<td>";
                echo "<a href='ConfirmacionEliminarLaboratorio.php?IdLaboratorios=" . htmlspecialchars($value['IdLaboratorios']) . "'>";
                echo "<img src='iconos/eliminar.png' width='32' height='32'></a>";
                echo "</td>";*/

                echo "</tr>";
            }
            
        
        ?>
    </table>
</body>
</html>
