<?php
// Obtener la carrera seleccionada desde la solicitud GET
$carreraSeleccionada = $_GET['carrera'];

// Realizar la consulta en la base de datos para obtener los semestres y grupos de la carrera seleccionada
try {
    include 'funciones.php';
    $conexion = conectarDB();

    $consulta = $conexion->prepare("SELECT DISTINCT a.Semestre, a.Grupo FROM alumnos a INNER JOIN cursar c ON a.Matricula = c.Matricula_Alumno INNER JOIN materias m ON c.Clave_Materia = m.Clave INNER JOIN formacion f ON m.ClaveFormacion = f.Clave WHERE f.Clave = :carrera");
    $consulta->bindParam(':carrera', $carreraSeleccionada, PDO::PARAM_STR);
    $consulta->execute();

    $resultados = $consulta->fetchAll(PDO::FETCH_ASSOC);

    // Crear un array asociativo con los semestres y grupos
    $datos = array(
        'semestres' => array(),
        'grupos' => array()
    );

    foreach ($resultados as $row) {
        // Verificar si el semestre ya se ha agregado al array
        if (!in_array($row['Semestre'], $datos['semestres'])) {
            $datos['semestres'][] = $row['Semestre'];
        }

        // Verificar si el grupo ya se ha agregado al array
        if (!in_array($row['Grupo'], $datos['grupos'])) {
            $datos['grupos'][] = $row['Grupo'];
        }
    }

    // Devolver los datos en formato JSON
    echo json_encode($datos);
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}
?>
