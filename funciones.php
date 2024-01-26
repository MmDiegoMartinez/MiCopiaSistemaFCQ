<?php

//Conexion a la base de datos//

function conectarDB() {
    // Detalles de conexión
    $host = 'localhost';
    $usuario = 'root';
    $password = '';
    $dbname = 'mydb';

    try {
        $conexion = new PDO("mysql:host={$host};dbname={$dbname}", $usuario, $password);
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

        return $conexion;
    } catch (PDOException $e) {
        echo "Error de conexión: " . $e->getMessage();
        return null;
    }
}




function consultarLoginSecretarias($numEmp, $password) {
    $conexion = conectarDB();

    try {
        // Consulta preparada para evitar la inyección SQL

        $consulta = $conexion->prepare("SELECT * FROM secretarias WHERE NumEmp = :numEmp");
        $consulta = $conexion->prepare("SELECT *FROM secretarias WHERE NumEmp = :numEmp");

        $consulta->bindParam(':numEmp', $numEmp, PDO::PARAM_STR);
        $consulta->execute();

        $usuario = $consulta->fetch(PDO::FETCH_ASSOC);

       
        if ($usuario && $password === $usuario['Password']) {
            return $usuario;
        } else {
            return false;
        }
    } catch (PDOException $e) {
       
        error_log("Error de base de datos: " . $e->getMessage(), 0);
        return false;
    } finally {
        
        $conexion = null;
    }
}



function consultarLoginProfesores($numEmp, $password) {
    $conexion = conectarDB();

    try {
        // Consulta preparada para evitar la inyección SQL
        $consulta = $conexion->prepare("SELECT * FROM profesores WHERE Num_Emp = :numEmp");
        $consulta->bindParam(':numEmp', $numEmp, PDO::PARAM_STR);
        $consulta->execute();

        $usuario = $consulta->fetch(PDO::FETCH_ASSOC);

       
        if ($usuario && $password === $usuario['Password']) {
            return $usuario;
        } else {
            return false;
        }
    } catch (PDOException $e) {
       
        error_log("Error de base de datos: " . $e->getMessage(), 0);
        return false;
    } finally {
        
        $conexion = null;
    }
}

function insertarAlumno($matricula, $nombre, $apellidos, $sexo, $telefono, $correo, $semestre, $grupo) {
    $conexion = conectarDB();

    if ($conexion) {
        try {
            // Consulta de inserción
            $sql = "INSERT INTO alumnos (Matricula, Nombre, Apellido, Sexo, Telefono, Correo, Semestre, Grupo)
                    VALUES (:matricula, :nombre, :apellido, :sexo, :telefono, :correo, :semestre, :grupo)";

            $consulta = $conexion->prepare($sql);
            $consulta->bindParam(':matricula', $matricula, PDO::PARAM_INT);
            $consulta->bindParam(':nombre', $nombre, PDO::PARAM_STR);
            $consulta->bindParam(':apellido', $apellidos, PDO::PARAM_STR);
            $consulta->bindParam(':sexo', $sexo, PDO::PARAM_STR);
            $consulta->bindParam(':telefono', $telefono, PDO::PARAM_STR);
            $consulta->bindParam(':correo', $correo, PDO::PARAM_STR);
            $consulta->bindParam(':semestre', $semestre, PDO::PARAM_INT);
            $consulta->bindParam(':grupo', $grupo, PDO::PARAM_STR);

            $consulta->execute();

            $filas = $consulta->rowCount();

            if ($filas > 0) {
                return "Alumno Agregado";
            } else {
                return "Hubo un Error al Agregar Alumno!!!";
            }
        } catch (PDOException $e) {
            return "<br>No se pudo completar el ingreso. La matrícula ya está asignada a otro estudiante.<br> Error de base de datos: " . $e->getMessage();
        } finally {
            // Cerrar la conexión
            $conexion = null;
        }
    } else {
        return "Error al conectar a la base de datos";
    }
}
function consultarAlumnos($carrera, $semestre, $grupo) {
    $conexion = conectarDB();

    try {
        // Consulta SQL
        $sql = "SELECT a.*, f.Clave
                FROM alumnos a
                INNER JOIN cursar c ON a.Matricula = c.Matricula_Alumno
                INNER JOIN materias m ON c.Clave_Materia = m.Clave
                INNER JOIN formacion f ON m.ClaveFormacion = f.Clave
                WHERE f.Clave = :carrera AND a.Semestre = :semestre AND a.Grupo = :grupo";

        // Preparar la declaración
        $statement = $conexion->prepare($sql);
        // Asociar valores a los marcadores de posición
        $statement->bindParam(':carrera', $carrera, PDO::PARAM_STR);
        $statement->bindParam(':semestre', $semestre, PDO::PARAM_STR);
        $statement->bindParam(':grupo', $grupo, PDO::PARAM_STR);
        // Ejecutar la consulta
        $statement->execute();
        // Obtener los resultados
        $registros = $statement->fetchAll();

        return $registros;
    } catch (PDOException $e) {
        error_log("Error de base de datos: " . $e->getMessage(), 0);
        return false;
    } finally {
        // Cerrar la conexión
        $conexion = null;
    }
}


//Ocupada para ConfirmacionEliminarAlumno.php y EditarAlumnos.php
/*function consultarAlumnosWhereMatricula($matriculalumno) {
    $conexion = conectarDB();

    try {
        // Consulta SQL
        $statement = $conexion->prepare("SELECT * FROM alumnos WHERE Matricula = :matricula");
        $statement->bindParam(':matricula', $matriculalumno, PDO::PARAM_INT);
        $statement->execute();
        $registros = $statement->fetch();

        return $registros;
    } catch (PDOException $e) {
        error_log("Error de base de datos: " . $e->getMessage(), 0);
        return false;
    } finally {
        // Cerrar la conexión
        $conexion = null;
    }
}*/
function consultarAlumnosWhereMatricula($matriculalumno) {
    $conexion = conectarDB();

    try {
        // Consulta SQL
        $statement = $conexion->prepare("SELECT * FROM alumnos WHERE Matricula = :matricula");
        $statement->bindParam(':matricula', $matriculalumno, PDO::PARAM_INT);
        $statement->execute();
        $registros = $statement->fetch();

        // Devolver un array vacío si no hay resultados
        return $registros ? $registros : [];
    } catch (PDOException $e) {
        error_log("Error de base de datos: " . $e->getMessage(), 0);
        return [];  // Devolver un array vacío en caso de error
    } finally {
        // Cerrar la conexión
        $conexion = null;
    }
}
function consultarLaboratoriosWhereMatricula($idLaboratorio) {
    $conexion = conectarDB();
    try {
        // Consulta SQL
        $statement = $conexion->prepare("SELECT *FROM laboratorios WHERE IdLaboratorios = :id");
        $statement->bindParam(':id',$idLaboratorio, PDO::PARAM_STR);
        $statement->execute();
        $registros = $statement->fetch();
        // Devolver un array vacío si no hay resultados
        return $registros ? $registros : [];
    } catch (PDOException $e) {
        error_log("Error de base de datos: " . $e->getMessage(), 0);
        return [];  // Devolver un array vacío en caso de error
    } finally {
        // Cerrar la conexión
        $conexion = null;
    }
}


function eliminarAlumnosWhereMatricula($matriculalumno) {
    $conexion = conectarDB();

    try {
        $sql = "DELETE FROM alumnos WHERE Matricula = :Matricula";
		$sql = $conexion->prepare($sql);
		$sql -> bindParam(':Matricula', $matriculalumno,PDO::PARAM_STR);
		$qryExecute = $sql->execute();
		if($qryExecute){
            header("refresh:1;url=IndexSecretarias.php");
            exit("Operación exitosa. Redirigiendo en 1 segundo...");
		}
		else{
            header("refresh:1;url=IndexSecretarias.php");
            exit("Ha ocurrido un error. Redirigiendo en un segundo...");
        }
        return $registros;
    } catch (PDOException $e) {
        error_log("Error de base de datos: " . $e->getMessage(), 0);
        return false;
    } finally {
        // Cerrar la conexión
        $conexion = null;
    }
}

function actualizarAlumnos($matricula, $nombre, $apellido, $telefono, $correo, $grupo1, $semestre1 ){
    $conexion = conectarDB();
   
    try {
        // Utilizar sentencias preparadas para una mejor seguridad
        $sql = "UPDATE alumnos SET Matricula = :matricula, Nombre = :nombre, Apellido = :apell, Telefono = :tel, Correo = :email, Semestre = :semestre, Grupo = :grupo WHERE Matricula = :matricula1";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':matricula', $matricula, PDO::PARAM_STR);
        $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $stmt->bindParam(':apell', $apellido, PDO::PARAM_STR);
        $stmt->bindParam(':tel', $telefono, PDO::PARAM_STR);
        $stmt->bindParam(':email', $correo, PDO::PARAM_STR);
        $stmt->bindParam(':semestre', $semestre1, PDO::PARAM_STR);
        $stmt->bindParam(':grupo', $grupo1, PDO::PARAM_STR);
        $stmt->bindParam(':matricula1', $matricula, PDO::PARAM_STR);

        // Ejecutar la consulta
        $qryExecute = $stmt->execute();

        if ($qryExecute) {
            header("refresh:1;url=IndexSecretarias.php");
            exit("Datos Actualizados. Redirigiendo en 1 segundos...");
        } else {
            $errorInfo = $stmt->errorInfo();
             // Registrar o mostrar detalles del error
            error_log("Fail: " . $errorInfo[2], 0);
            echo "Error al ejecutar la consulta de actualización: " . $errorInfo[2];
            exit();
        }
    } catch (PDOException $e) {
        // Manejar excepciones
        echo "Error: " . $e->getMessage();
    } finally {
        // Cerrar la conexión
        $conexion = null;
    }
}

function obtenerCiclosEscolares() {
    $conexion = conectarDB();

    try {
        $consultaCiclos = $conexion->prepare("SELECT DISTINCT Ciclo_Escolar FROM cursar");
        $consultaCiclos->execute();
        return $consultaCiclos;
    } catch (PDOException $e) {
        error_log("Error de base de datos: " . $e->getMessage(), 0);
        return false;
    } finally {
        // Cerrar la conexión
        $conexion = null;
    }
}
//Obtener todos los semestres
function obtenerSemestre() {
    $conexion = conectarDB();

    try {
        $consultaSemestres = $conexion->prepare("SELECT DISTINCT Semestre FROM alumnos;");
        $consultaSemestres->execute();
        return $consultaSemestres;
    } catch (PDOException $e) {
        error_log("Error de base de datos: " . $e->getMessage(), 0);
        return false;
    } finally {
        // Cerrar la conexión
        $conexion = null;
    }
}
//Obtener todos los grupos
function obtenerGrupo() {
    $conexion = conectarDB();

    try {
        $consultaGrupos = $conexion->prepare("SELECT DISTINCT Grupo FROM alumnos;");
        $consultaGrupos->execute();
        return $consultaGrupos;
    } catch (PDOException $e) {
        error_log("Error de base de datos: " . $e->getMessage(), 0);
        return false;
    } finally {
        // Cerrar la conexión
        $conexion = null;
    }
}


function mostrarInformacionAlumno($numero_matricula, $ciclo_escolar) {
    $conexion = conectarDB();

    try {
        // Consulta SQL con las variables
        $sql = "SELECT a.Matricula, a.Nombre, a.Apellido, a.Semestre, a.Grupo, m.Clave, m.Nombre as Materia, c.Calificacion, f.Nombre as Carrera 
                FROM alumnos a 
                INNER JOIN cursar c ON a.Matricula = c.Matricula_Alumno 
                INNER JOIN materias m ON c.Clave_Materia = m.Clave 
                INNER JOIN formacion f ON m.ClaveFormacion = f.Clave 
                WHERE a.Matricula = :matricula AND c.Ciclo_Escolar = :ciclo_escolar";

        $statement = $conexion->prepare($sql);
        $statement->bindParam(':matricula', $numero_matricula, PDO::PARAM_INT);
        $statement->bindParam(':ciclo_escolar', $ciclo_escolar, PDO::PARAM_STR);
        $statement->execute();
        $resultado = $statement->fetchAll(PDO::FETCH_ASSOC);

        if ($resultado) {
            // Obtener información del alumno
            $fila_alumno = $resultado[0];

            // Mostrar tabla 1 con información del alumno
            echo "<h2>Información del Alumno</h2>";
            echo "<table>";
            echo "<tr><th>Matrícula</th><td>{$fila_alumno['Matricula']}</td></tr>";
            echo "<tr><th>Nombre</th><td>{$fila_alumno['Nombre']} {$fila_alumno['Apellido']}</td></tr>";
            echo "<tr><th>Carrera</th><td>{$fila_alumno['Carrera']}</td></tr>";
            echo "<tr><th>Ciclo Escolar</th><td>{$ciclo_escolar}</td></tr>";
            echo "<tr><th>Semestre</th><td>{$fila_alumno['Semestre']}</td></tr>";
            echo "<tr><th>Grupo</th><td>{$fila_alumno['Grupo']}</td></tr>";
            echo "</table>";

            // Mostrar tabla 2 con información de materias y calificaciones
            echo "<h2>Calificaciones</h2>";
            echo "<table>";
            echo "<tr><th>Clave de Materia</th><th>Nombre de Materia</th><th>Calificación</th></tr>";

            // Mostrar información de cada materia
            foreach ($resultado as $fila_materia) {
                echo "<tr><td>{$fila_materia['Clave']}</td><td>{$fila_materia['Materia']}</td><td>{$fila_materia['Calificacion']}</td></tr>";
            }

            echo "</table>";
        } else {
            echo "<p>Sin coincidencias.</p>";
        }
    } catch (PDOException $e) {
        // Manejar la excepción aquí, si es necesario
        echo "Error: " . $e->getMessage();
    } finally {
        // Cerrar la conexión a la base de datos
        $conexion = null;
    }
}
//Generar Kardex del alumno
function generarPDFKardex($numero_matricula, $ciclo_escolar) {
    // Obtener información del alumno y sus calificaciones
    $conexion = conectarDB();
    $sql = "SELECT a.Matricula, a.Nombre, a.Apellido, a.Semestre, a.Grupo, m.Clave, m.Nombre as Materia, c.Calificacion, f.Nombre as Carrera 
                FROM alumnos a 
                INNER JOIN cursar c ON a.Matricula = c.Matricula_Alumno 
                INNER JOIN materias m ON c.Clave_Materia = m.Clave 
                INNER JOIN formacion f ON m.ClaveFormacion = f.Clave 
                WHERE a.Matricula = :matricula AND c.Ciclo_Escolar = :ciclo_escolar";

        $statement = $conexion->prepare($sql);
        $statement->bindParam(':matricula', $numero_matricula, PDO::PARAM_INT);
        $statement->bindParam(':ciclo_escolar', $ciclo_escolar, PDO::PARAM_STR);
        $statement->execute();
        $resultado = $statement->fetchAll(PDO::FETCH_ASSOC);

    if (!$resultado) {
        echo "<p>No se encontraron calificaciones para el alumno.</p>";
        return;
    }
    // Obtener datos del director
    $sqlDirector = "SELECT Nombre,Apellido, formacion_academica FROM admin WHERE Cargo = 'Director'";
    $stmtDirector = $conexion->prepare($sqlDirector);
    $stmtDirector->execute();
    $director = $stmtDirector->fetch(PDO::FETCH_ASSOC);

    // Obtener datos del coordinador académico
    $sqlCoordinador = "SELECT Nombre,Apellido, formacion_academica FROM admin WHERE Cargo = 'Coordinador Académico'";
    $stmtCoordinador = $conexion->prepare($sqlCoordinador);
    $stmtCoordinador->execute();
    $coordinador = $stmtCoordinador->fetch(PDO::FETCH_ASSOC);

    $pdf = new TCPDF();
    $pdf->SetAutoPageBreak(true, 15);
    $pdf->AddPage();
    // Agregar contenido al PDF (puedes personalizar esto según tus necesidades)
    $pdf->SetFont('Helvetica', '', 11);
    // Logo de la UABJO en el lado izquierdo superior
    $pdf->Image('iconos/UBAJOLOGOCONFONDO.jpg', 10, 7, 20, '', 'JPG');
    // Logo de la FCQ en el lado derecho superior
    $pdf->Image('iconos/FCQLOGOCONFONDO.jpg', 180, 7, 20, '', 'JPG');
    // Título de la Universidad en el centro
    $pdf->Cell(0, 10, "UNIVERSIDAD AUTÓNOMA \"BENITO JUÁREZ\" DE OAXACA", 0, 1, 'C');
    $pdf->Image('iconos/Adorno.png', 45, 18, 120, '', 'PNG');

    // Subtítulo de la Facultad centrado y más pequeño
    $pdf->SetFont('Helvetica', 'B', 10);
    
    $pdf->Cell(0, 8, "FACULTAD DE CIENCIAS QUÍMICAS", 0, 1, 'C');

    $pdf->Cell(0, 7, "Kardex de Calificaciones", 0, 1, 'C');

    // Agregar espacio antes de la foto
    $pdf->Cell(0, 5, "", 0, 1);

// Definir el tamaño del cuadro para la foto infantil
    $tamano_cuadro_ancho = 25;
    $tamano_cuadro_alto = 30;

    $posicion_x = 10;
    $posicion_y = $pdf->GetY();

    // Dibujar el rectángulo para la foto infantil
    $pdf->Rect($posicion_x, $posicion_y, $tamano_cuadro_ancho, $tamano_cuadro_alto, 'D');

    // Calcular la posición Y para la información (más arriba, pero sin superponerse con el cuadro)
    $posicion_y_info = max($posicion_y, $pdf->GetY() - 10);

    $pdf->SetY($posicion_y_info);

    // Configurar la posición X para los datos del alumno
    $posicion_x_datos_alumno = $posicion_x + $tamano_cuadro_ancho + 10;

    $pdf->SetX($posicion_x_datos_alumno);

    $pdf->SetFont('Helvetica', '', 10);
    $fila_alumno = $resultado[0];

    $pdf->Cell(0, 5, "", 0, 10);

    // Agregar datos del alumno al lado del rectángulo
    $pdf->Cell(20, 5, "Matrícula:", 0, 0, 'B');
    $pdf->Cell(42, 5, $fila_alumno['Matricula'], 0, 0);
    $pdf->Cell(23, 5, "Nombre:", 0, 0, 'B');
    $pdf->Cell(60, 5, $fila_alumno['Nombre'] . ' ' . $fila_alumno['Apellido'], 0, 1);

    // Configurar la posición X para las siguientes celdas
    $pdf->SetX($posicion_x_datos_alumno);

    $pdf->Cell(20, 5, "Carrera:", 0, 0, 'B');
    $pdf->Cell(42, 5, $fila_alumno['Carrera'], 0, 0);
    $pdf->Cell(23, 5, "Ciclo Escolar:", 0, 0, 'B');
    $pdf->Cell(60, 5, $ciclo_escolar, 0, 1);

    // Configurar la posición X para las siguientes celdas
    $pdf->SetX($posicion_x_datos_alumno);

    $pdf->Cell(20, 5, "Semestre:", 0, 0, 'B');
    $pdf->Cell(42, 5, $fila_alumno['Semestre'], 0, 0);
    $pdf->Cell(23, 5, "Grupo:", 0, 0, 'B');
    $pdf->Cell(60, 5, $fila_alumno['Grupo'], 0, 1);

    $pdf->Cell(0, 7, "", 0, 1); // Agregar espacio

    // Tabla de calificaciones
    $pdf->Cell(0, 10, "", 0, 1); // Agregar espacio
    $pdf->SetFont('Helvetica', 'B', 10);
    $pdf->Cell(60, 7, "Clave de Materia", 1);
    $pdf->Cell(60, 7, "Nombre de Materia", 1);//1 ES PARA MARGEN DE LAS TABLAS
    $pdf->Cell(60, 7, "Calificación", 1);
    $pdf->Ln();

    $pdf->SetFont('Helvetica', 8);
    // Detalles de las calificaciones
    foreach ($resultado as $fila_materia) {
        $pdf->Cell(60, 5, $fila_materia['Clave'], 1);
        $pdf->Cell(60, 5, $fila_materia['Materia'], 1);
        $pdf->Cell(60, 5, $fila_materia['Calificacion'], 1);
        $pdf->Ln();
    }
    // Espacios para firmas
    $pdf->Ln(10);
    $pdf->Cell(120, 5, "        ___________________________", 0, 0);
    $pdf->Cell(80, 5, " ___________________________", 0, 1);
    $pdf->Cell(125, 5, "                Coordinador Académico ", 0, 0);
    $pdf->Cell(80, 5, "                    Director", 0, 1);
    $pdf->Cell(115, 5, "       {$coordinador['formacion_academica']} {$coordinador['Nombre']} {$coordinador['Apellido']}", 0, 0);
    $pdf->Cell(80, 5, "{$director['formacion_academica']} {$director['Nombre']} {$director['Apellido']}", 0, 1);
    // Mostrar el PDF en el navegador
    ob_end_clean(); // Limpiar cualquier salida de buffer anterior
    $pdf->Output("Kardex_Alumno_$numero_matricula.pdf", 'I');
    exit;
}

function consultarLaboratorios() {
    $conexion = conectarDB();

    try {
        // Consulta SQL
        $query = "SELECT DISTINCT L.*, P.Nombre AS NombreProfesor, P.Apellidos AS ApellidosProfesor, M.Clave AS ClaveMateria, M.Nombre AS NombreMateria 
        FROM profesores P 
        INNER JOIN prof_lab PL ON P.Num_Emp = PL.Num_Emp 
        INNER JOIN laboratorios L ON PL.IdLaboratorio = L.IdLaboratorios 
        INNER JOIN materias M ON L.IdLaboratorios = M.IdLaboratorio;
        ";
        // Preparar la declaración
        $statement = $conexion->prepare($query);
        // Ejecutar la consulta
        $statement->execute();
        // Obtener los resultados
        $registros = $statement->fetchAll();

        return $registros;
    } catch (PDOException $e) {
        error_log("Error de base de datos: " . $e->getMessage(), 0);
        return false;
    } finally {
        // Cerrar la conexión
        $conexion = null;
    }
}
function consultarLaboratorios1() {
    $conexion = conectarDB();

    try {
        // Consulta SQL
        $query = "SELECT * FROM laboratorios;";
        // Preparar la declaración
        $statement = $conexion->prepare($query);
        // Ejecutar la consulta
        $statement->execute();
        // Obtener los resultados
        $registros1 = $statement->fetchAll();

        return $registros1;
    } catch (PDOException $e) {
        error_log("Error de base de datos: " . $e->getMessage(), 0);
        return false;
    } finally {
        // Cerrar la conexión
        $conexion = null;
    }
}

//AQUI EMPIEZA OTRO

//Lista para seleccionarlas carreras disponibles asi como su gardo y grupo
function obtenerCarrerasygrupos() {
    $conexion = conectarDB();

    try {
        // Consulta SQL
        $sql = "SELECT Clave, Nombre FROM formacion";

        // Preparar la declaración
        $statement = $conexion->query($sql);

        // Obtener los resultados
        $carreras = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $carreras;
    } catch (PDOException $e) {
        error_log("Error de base de datos: " . $e->getMessage(), 0);
        return false;
    } finally {
        // Cerrar la conexión
        $conexion = null;
    }
}
//lISTA DE MATERIAS POR CICLO GRADO Y GRUPO SE OCUPA EN ListaMaterias.php para vesion 1, y version 2 para ListaMateriasCicloEditarCalificacion.php
//Version 1 esta no es necesaria ya que esta la version 2 activa pero lo dejo comentado por si sirve despues
/*function mostrarMateriasPorCicloyGrados($semestre,$grupo,$cicloEscolar) {
    $conexion = conectarDB();

    try {
        // Consulta para obtener las materias del ciclo escolar
        $sql = "SELECT DISTINCT M.Clave, M.Nombre 
        FROM CURSAR C 
        INNER JOIN MATERIAS M ON C.Clave_Materia = M.Clave 
        INNER JOIN ALUMNOS A ON C.Matricula_Alumno = A.Matricula 
        WHERE A.Semestre = :semestre AND A.Grupo = :grupo AND C.Ciclo_Escolar = :ciclo";

        $statement = $conexion->prepare($sql);
        $statement->bindParam(':semestre', $semestre, PDO::PARAM_STR);
        $statement->bindParam(':grupo', $grupo, PDO::PARAM_STR);
        $statement->bindParam(':ciclo', $cicloEscolar, PDO::PARAM_STR);
        $statement->execute();
        $consultaMaterias = $statement->fetchAll(PDO::FETCH_ASSOC);

        // Imprimir el título y la tabla de materias
        echo "<h2>Materias del Ciclo: $cicloEscolar del $semestre $grupo </h2>";
        return $consultaMaterias;
    } catch (PDOException $e) {
        // Manejar la excepción aquí, si es necesario
        echo "Error: " . $e->getMessage();
    } finally {
        // Cerrar la conexión a la base de datos
        $conexion = null;
    }
}*/
//vercion 2
function mostrarMateriasPorCicloyGradosCarrera($semestre, $grupo, $cicloEscolar, $carrera) {
    $conexion = conectarDB();

    try {
        // Consulta para obtener las materias del ciclo escolar
        $sql = "SELECT DISTINCT M.Clave, M.Nombre 
        FROM CURSAR C 
        INNER JOIN MATERIAS M ON C.Clave_Materia = M.Clave 
        INNER JOIN ALUMNOS A ON C.Matricula_Alumno = A.Matricula 
        WHERE A.Semestre = :semestre AND A.Grupo = :grupo AND C.Ciclo_Escolar = :ciclo AND M.ClaveFormacion = :clave ";

        $statement = $conexion->prepare($sql);
        $statement->bindParam(':semestre', $semestre, PDO::PARAM_STR);
        $statement->bindParam(':grupo', $grupo, PDO::PARAM_STR);
        $statement->bindParam(':ciclo', $cicloEscolar, PDO::PARAM_STR);
        $statement->bindParam(':clave',  $carrera, PDO::PARAM_STR);
        $statement->execute();
        $consultaMaterias = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $consultaMaterias;
    } catch (PDOException $e) {
        // Manejar la excepción aquí, si es necesario
        echo "Error: " . $e->getMessage();
    } finally {
        // Cerrar la conexión a la base de datos
        $conexion = null;
    }
}
//Genera las calificaciones por materia, funcion ocupada en PdfKardexPorMateria.php
function generarPDFCalificacionesMateria($clave_materia, $ciclo_escolar, $semestre, $grupo, $nombre_materia) {
    // Obtener información del alumno y sus calificaciones
    $conexion = conectarDB();
    $sql = "SELECT A.Matricula, A.Nombre, A.Apellido, C.Calificacion 
            FROM CURSAR C 
            INNER JOIN ALUMNOS A ON C.Matricula_Alumno = A.Matricula 
            INNER JOIN MATERIAS M ON C.Clave_Materia = M.Clave 
            WHERE A.Semestre = :semestre AND A.Grupo = :grupo 
                AND M.Clave = :clave_materia AND C.Ciclo_Escolar = :ciclo_escolar
            ORDER BY A.Apellido ASC;";

    $statement = $conexion->prepare($sql);
    $statement->bindParam(':semestre', $semestre, PDO::PARAM_STR);
    $statement->bindParam(':grupo', $grupo, PDO::PARAM_STR);
    $statement->bindParam(':clave_materia', $clave_materia, PDO::PARAM_STR);
    $statement->bindParam(':ciclo_escolar', $ciclo_escolar, PDO::PARAM_STR);
    $statement->execute();
    $resultado = $statement->fetchAll(PDO::FETCH_ASSOC);

    if (!$resultado) {
        echo "<p>No se encontraron calificaciones para la materia seleccionada.</p>";
        return;
    }

    $pdf = new TCPDF();
    $pdf->SetAutoPageBreak(true, 15);
    $pdf->AddPage();

    $pdf->SetFont('Helvetica', '', 11);
    // Logo de la UABJO en el lado izquierdo superior
    $pdf->Image('iconos/UBAJOLOGOCONFONDO.jpg', 10, 7, 20, '', 'JPG');
    // Logo de la FCQ en el lado derecho superior
    $pdf->Image('iconos/FCQLOGOCONFONDO.jpg', 180, 7, 20, '', 'JPG');
    // Título de la Universidad en el centro
    $pdf->Cell(0, 10, "UNIVERSIDAD AUTÓNOMA \"BENITO JUÁREZ\" DE OAXACA", 0, 1, 'C');
    $pdf->Image('iconos/Adorno.png', 45, 18, 120, '', 'PNG');

    // Subtítulo de la Facultad centrado y más pequeño
    $pdf->SetFont('Helvetica', 'B', 10);
    $pdf->Cell(0, 8, "FACULTAD DE CIENCIAS QUÍMICAS", 0, 1, 'C');

    $pdf->Cell(0, 7, "$nombre_materia, Calificaciones $semestre $grupo Ciclo Escolar: $ciclo_escolar", 0, 1, 'C');

    // Agregar espacio antes de la tabla
    $pdf->Cell(0, 5, "", 0, 1);

    // Calcular la posición x para centrar la tabla horizontalmente
    $tableWidth = 40 + 60 + 40; // Suma de los anchos de las celdas
    $tableX = ($pdf->getPageWidth() - $tableWidth) / 2;

    // Tabla de calificaciones
    $pdf->SetFont('Helvetica', 'B', 10);
    $pdf->SetXY($tableX, $pdf->GetY()); // Establecer posición x
    $pdf->Cell(40, 7, "Matrícula", 1);
    $pdf->Cell(60, 7, "Nombre", 1);
    $pdf->Cell(40, 7, "Calificación", 1);
    $pdf->Ln();

    $pdf->SetFont('Helvetica', '', 8);
    // Detalles de las calificaciones
    foreach ($resultado as $fila) {
        $pdf->SetX($tableX); // Establecer posición x para cada fila
        $pdf->Cell(40, 5, $fila['Matricula'], 1);
        $pdf->Cell(60, 5, $fila['Apellido']. ' ' . $fila['Nombre'] , 1);
        $pdf->Cell(40, 5, $fila['Calificacion'], 1);
        $pdf->Ln();
    }

    // Espacios para firmas
    $pdf->Ln(20);
    $pdf->Cell(75, 5, " ", 0, 0);
    $pdf->Cell(80, 5, " ___________________________", 0, 1);
    $pdf->Cell(95, 5, " ", 0, 0);
    $pdf->Cell(80, 5, "Firma", 0, 1);

    // Obtener la fecha y hora actual
    $fecha_actual = date("d/m/Y H:i:s");

    // Agregar el mensaje al final del PDF
    $pdf->Ln(5);
    $pdf->Cell(40, 10, "Generado el $fecha_actual.", 0, 1, 'C');

    // Mostrar el PDF en el navegador
    ob_end_clean(); // Limpiar cualquier salida de buffer anterior
    $pdf->Output("Calificaciones_Materia_$clave_materia.pdf", 'I');
    exit;
}
///////////////////////////////////////////////////////////////////////////////////////////////////////
//Se usa en ListaCalificacionesEditar.php
function AlumnosyCalificaciones($semestre, $grupo, $claveMateria, $cicloEscolar,$carrera) {
    $conexion = conectarDB();

    try {
        // Consulta para obtener informacion del alumno y sus calificaciones 
        $sql = "SELECT A.Matricula, A.Nombre as Nombre, A.Apellido, C.Calificacion, C.Clave_Materia, M.Nombre AS Materia, C.Ciclo_Escolar
                        FROM CURSAR C 
                        INNER JOIN ALUMNOS A ON C.Matricula_Alumno = A.Matricula 
                        INNER JOIN MATERIAS M ON C.Clave_Materia = M.Clave 
                        WHERE A.Semestre = :semestre AND A.Grupo = :grupo 
                            AND M.Clave = :clave_materia AND C.Ciclo_Escolar = :ciclo_escolar AND M.ClaveFormacion = :clave
                        ORDER BY A.Apellido ASC;";

                $statement = $conexion->prepare($sql);
                $statement->bindParam(':semestre', $semestre, PDO::PARAM_STR);
                $statement->bindParam(':grupo', $grupo, PDO::PARAM_STR);
                $statement->bindParam(':clave_materia', $claveMateria, PDO::PARAM_STR);
                $statement->bindParam(':ciclo_escolar', $cicloEscolar, PDO::PARAM_STR);
                $statement->bindParam(':clave', $carrera, PDO::PARAM_STR);
                $statement->execute();

                if ($statement->rowCount() > 0) {
                    // La consulta ha devuelto resultados
                    $resultados = $statement->fetchAll(PDO::FETCH_ASSOC);
                    return $resultados;
                } else {
                    // La consulta no devolvió ningún resultado
                    echo "No se encontraron resultados.";
                }
    } catch (PDOException $e) {
        // Manejar la excepción aquí, si es necesario
        echo "Error: " . $e->getMessage();
    } finally {
        // Cerrar la conexión a la base de datos
        $conexion = null;
    }
}

//se usa en EditarCalificacion.php
function AlumnosyCalificaciones2($matriculalumno) {
    $conexion = conectarDB();

    try {
        // Consulta para obtener informacion del alumno y sus calificaciones 
        $statement = $conexion->prepare("SELECT c.Matricula_Alumno,c.Clave_Materia,c.calificacion,a.Semestre,a.Grupo 
        FROM alumnos a INNER JOIN cursar c ON a.Matricula = c.Matricula_Alumno WHERE c.Matricula_Alumno = :matricula;");
        $statement->bindParam(':matricula', $matriculalumno, PDO::PARAM_STR);
        $statement->execute();
        if ($statement->rowCount() > 0) {
            $registros = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $registros;
        } else {
            // La consulta no devolvió ningún resultado
            echo "No se encontraron resultados.";
        }
    } catch (PDOException $e) {
        // Manejar la excepción aquí, si es necesario
        echo "Error: " . $e->getMessage();
    } finally {
        // Cerrar la conexión a la base de datos
        $conexion = null;
    }
}


function ActualizarCalificaciones($calificacion,$claveMateria,$matricula){
    $conexion = conectarDB();

    try {
        $sql = "UPDATE cursar SET Calificacion = :calificacion WHERE Clave_Materia = :clave AND Matricula_Alumno = :matricula";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':calificacion', $calificacion, PDO::PARAM_STR);
        $stmt->bindParam(':clave', $claveMateria, PDO::PARAM_STR);
        $stmt->bindParam(':matricula', $matricula, PDO::PARAM_STR);

        // Ejecutar la consulta
        $qryExecute = $stmt->execute();

        if ($qryExecute) {
            header("refresh:1;url=IndexSecretarias.php");
            exit("Datos Actualizados. Redirigiendo en 1 segundos...");
        } else {
            $errorInfo = $stmt->errorInfo();
            // Registrar o mostrar detalles del error
            error_log("Fail: " . $errorInfo[2], 0);
            echo "Error al ejecutar la consulta de actualización: " . $errorInfo[2];
            exit();
        }
    } catch (PDOException $e) {
        // Manejar la excepción aquí, si es necesario
        echo "Error: " . $e->getMessage();
    } finally {
        // Cerrar la conexión a la base de datos
        $conexion = null;
    }
}






///////////////////////////////////////////////////////////////////////////////////////////////////////

//Funcion Utilizada en ActualizarLaboratorios.php
function actualizarLaboratorios($idlaboratorio, $nombreLaboratorio, $encargado){
    $conexion = conectarDB();
   
    try {
        $sql = "UPDATE laboratorios SET IdLaboratorios = :id, NomLaboratorio = :nombre, JefeNumEmp = :Emp WHERE IdLaboratorios = :id1";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':id', $idlaboratorio, PDO::PARAM_STR);
        $stmt->bindParam(':nombre', $nombreLaboratorio, PDO::PARAM_STR);
        $stmt->bindParam(':Emp', $encargado, PDO::PARAM_STR);
        $stmt->bindParam(':id1', $idlaboratorio, PDO::PARAM_STR);

        // Ejecutar la consulta
        $qryExecute = $stmt->execute();

        if ($qryExecute) {
            header("refresh:1;url=ListaLaboratorios.php");
            exit("Datos Actualizados. Redirigiendo en 1 segundos...");
        } else {
            $errorInfo = $stmt->errorInfo();
             // Registrar o mostrar detalles del error
            error_log("Fail: " . $errorInfo[2], 0);
            echo "Error al ejecutar la consulta de actualización: " . $errorInfo[2];
            exit();
        }
    } catch (PDOException $e) {
        // Manejar excepciones
        echo "Error: " . $e->getMessage();
    } finally {
        // Cerrar la conexión
        $conexion = null;
    }
}




///LO PLATICO CON ALEJANDRO
function insertarLaboratorios($idLab, $nombreLab, $jefeLab,$nombreMateria) {
    $conexion = conectarDB();

    if ($conexion) {
        try {
            // Consulta de inserción
            
            //$clavemateria = consultaridmateria($nombreMateria)
            $sql = "INSERT INTO laboratorios (IdLaboratorios, NomLaboratorio, JefeNumEmp) VALUES (:id,:nombre,:jefe)";

            $consulta = $conexion->prepare($sql);
            $consulta->bindParam(':id', $idLab, PDO::PARAM_INT);
            $consulta->bindParam(':nombre', $nombreLab, PDO::PARAM_STR);
            $consulta->bindParam(':jefe', $jefeLab, PDO::PARAM_STR);
            $consulta->execute();
            $filas = $consulta->rowCount();

            if ($filas > 0) {
                return "Laboratorio Agregado";
            } else {
                return "Hubo un Error al Agregar Laboratorio!!!";
            }


            //insertar 
            $sql = "INSERT INTO laboratorios (IdLaboratorios, NomLaboratorio, JefeNumEmp) VALUES (:id,:nombre,:jefe)";

            $consulta = $conexion->prepare($sql);
            $consulta->bindParam(':id', $idLab, PDO::PARAM_INT);
            $consulta->bindParam(':nombre', $nombreLab, PDO::PARAM_STR);
            $consulta->bindParam(':jefe', $jefeLab, PDO::PARAM_STR);
            $consulta->execute();
            $filas = $consulta->rowCount();

            if ($filas > 0) {
                return "Laboratorio Agregado";
            } else {
                return "Hubo un Error al Agregar Laboratorio!!!";
            }
        } catch (PDOException $e) {
            return "Error de base de datos: " . $e->getMessage();
        } finally {
            // Cerrar la conexión
            $conexion = null;
        }
    } else {
        return "Error al conectar a la base de datos";
    }
}

function consultarmaterias() {
    $conexion = conectarDB();

    try {
        $listamaterias = $conexion->prepare("SELECT Nombre FROM materias;");
        $listamaterias->execute();
        return $listamaterias;
    } catch (PDOException $e) {
        error_log("Error de base de datos: " . $e->getMessage(), 0);
        return false;
    } finally {
        // Cerrar la conexión
        $conexion = null;
    }
}

function consultaridmateria($ClaveMateria) {
    $conexion = conectarDB();

    try {
        $listamaterias = $conexion->prepare("SELECT Clave FROM materias WHERE Nombre = :nombre;");
        $listamaterias->bindParam(':nombre', $ClaveMateria, PDO::PARAM_STR);
        $listamaterias->execute();
        return $listamaterias;
        echo $listamaterias;
    } catch (PDOException $e) {
        error_log("Error de base de datos: " . $e->getMessage(), 0);
        return false;
    } finally {
        // Cerrar la conexión
        $conexion = null;
    }
}



?>


