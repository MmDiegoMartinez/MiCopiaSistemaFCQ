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

// Realizar la consulta para obtener los ciclos escolares
include('funciones.php');
$conexion = conectarDB();
$consultaCiclos = obtenerCiclosEscolares();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generador de Kardex Escolar</title>
</head>

<body>
    <nav>
        <h1><img src="iconos/FCQ_logo.png" width="80">Generador de Kardex Escolar</h1>
        <ul>
            <li><a href="IndexSecretarias.php"><img src="iconos//homelogo.png" width="20px"><br>Home</a></li>
            <li><a href="ElegirKardex.php"><img src="iconos//back.png" width="20px"><br>Atras</a></li>
        </ul>
    </nav>
<div>
    <p>Instrucciones: Ingrese matrícula y ciclo, luego haga clic en 'Entrar' para consultar calificaciones.</p>
    <form action="VerCalificacionesAlumnos.php" method="post">
        <label for="numero">Matricula:</label>
        <input type="number" id="matricula" name="matricula" required>
        <br>
        <label for="ciclo_escolar">Ciclo Escolar:</label>
            <select id="ciclo_escolar" name="ciclo_escolar" required>
                <?php
                while ($row = $consultaCiclos->fetch(PDO::FETCH_ASSOC)) {
                    echo "<option value='{$row['Ciclo_Escolar']}'>{$row['Ciclo_Escolar']}</option>";
                }
                ?>
            </select>
        <button type="submit">Entrar</button>
    </form>
</div>
</body>
</html>