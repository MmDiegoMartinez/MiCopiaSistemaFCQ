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
    <title>Editar Calificaciones</title>
    <script src="funcionjavascript.js"></script>
</head>

<body>
    <nav>
        <h1><img src="iconos/FCQ_logo.png" width="80">Editar Calificaciones</h1>
        <ul>
            <li><a href="IndexSecretarias.php"><img src="iconos//homelogo.png" width="20px"><br>Home</a></li>
        </ul>
    </nav>
    <p>Selecciona carrera, semestre y grupo para ver y editar la lista de alumnos.</p>
    <form action="ListaMateriasCicloEditarCalificacion.php" method="post">
        <label for="carrera">Carrera:</label>

        <?php
        try {
            // Utiliza la función conectarDB de funciones.php
            include 'funciones.php'; // Asegúrate de incluir el archivo funciones.php
            $consultaCiclos = obtenerCiclosEscolares();
            $conexion = conectarDB();

            // Consulta para obtener las carreras
            $consulta = $conexion->query("SELECT Clave, Nombre FROM formacion");
            $consulta_alumnos = $conexion->query("SELECT a.* FROM alumnos a INNER JOIN cursar c ON a.Matricula = c.Matricula_Alumno INNER JOIN materias m ON c.Clave_Materia = m.Clave INNER JOIN formacion f ON m.ClaveFormacion = f.Clave;");
        } catch (PDOException $e) {
            echo "Error de conexión: " . $e->getMessage();
        } finally {
            // No es necesario cerrar la conexión en este punto, ya que se hará automáticamente al final del script.
        }
        ?>

    <select class="controls" id="carrera" name="carrera" required onchange="cargarGradosYGrupos()">
            <?php
            while ($row = $consulta->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value='{$row['Clave']}'>{$row['Nombre']}</option>";
            }
            ?>
        </select>

        <select class="controls" id="semestre" name="semestre" required></select>

        <select class="controls" id="grupo" name="grupo" required></select>

        <br>
        <label for="ciclo_escolar">Ciclo Escolar:</label>
            <select id="ciclo_escolar" name="ciclo_escolar" required>
                <?php
                    while ($row = $consultaCiclos->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='{$row['Ciclo_Escolar']}'>{$row['Ciclo_Escolar']}</option>";
                    }
                ?></select>

        <input type="submit" value="Enviar">
    </form>
</body>

</html>
