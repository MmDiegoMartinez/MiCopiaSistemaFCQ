<?php

include('funciones.php');

// Verificar si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario de login y filtrar 
    $numEmp = isset($_POST['NumEmp']) ? filter_var($_POST['NumEmp'], FILTER_SANITIZE_STRING) : '';
    $password = isset($_POST['Password']) ? filter_var($_POST['Password'], FILTER_SANITIZE_STRING) : '';

    // Verificar que los campos no estén vacíos
    if (empty($numEmp) || empty($password)) {
        $mensaje_error = "Por favor, completa todos los campos.";
    } else {
        // Consultar el login
        $usuario_valido = consultarLoginProfesores($numEmp, $password);

        if ($usuario_valido) {
            session_start();
            session_regenerate_id(); // Genera un nuevo ID de sesión para mayor seguridad
            $_SESSION = array(); // Limpia todas las variables de sesión

          
            $_SESSION['user_id'] = $usuario_valido['NumEmp'];
            $_SESSION['user_name'] = $usuario_valido['Nombre'];

            header("Location: IndexProfesores.php");
            exit();
        } else {
            // Las credenciales son incorrectas, muestra un mensaje de error
            $mensaje_error = "Número de empleado o contraseña incorrectos";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login de Profesores</title>
</head>
<body>
    <h2>Login de Profesores</h2>
    
    <?php if (isset($mensaje_error)): ?>
        <p style="color: red;"><?php echo $mensaje_error; ?></p>
    <?php endif; ?>

    <form action="LoginProfesores.php" method="post">
        <label for="NumEmp">Número de empleado:</label>
        <input type="text" id="NumEmp" name="NumEmp" required>
        <br>
        <label for="Password">Contraseña:</label>
        <input type="password" id="Password" name="Password" required>
        <br>
        <input type="submit" value="Iniciar sesión">
    </form>
</body>
</html>
