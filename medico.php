<?php
session_start();

// Verificar si el médico está autenticado en la sesión
if (!isset($_SESSION['medico'])) {
    die("No se ha iniciado sesión como médico. Variable de sesión 'medico' no está definida.");
}

$nombreMedico = htmlspecialchars($_SESSION['medico']); // Obtener el nombre del médico desde la sesión
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel del Médico</title>
    <link rel="stylesheet" href="styles.css"> 
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="/clinica/img/nosotros.png" alt="Logo del Centro Médico" class="logo">
            <h1>Centro Médico Grierson</h1>
        </div>

        <h2>Bienvenido/a, <?php echo $nombreMedico; ?>.</h2>
        <h2>¿Qué acción desea realizar?</h2>

        <div class="actions">
            <button class="action-button" onclick="window.location.href='listado-pacientes-medico.php'">IMPRIMIR LISTADO DE TURNOS</button>
            <button class="action-button" onclick="window.location.href='agregar-historia.php'">AGREGAR HISTORIA CLINICA</button>
            <button class="action-button" onclick="window.location.href='buscar-historia.php'">BUSCAR HISTORIA CLINICA</button>
            <button class="action-button" onclick="window.location.href='eliminar-historia.php'">ELIMINAR HISTORIA CLINICA</button>
        </div>

        <!-- Botón de salir -->
        <button class="logout-button" onclick="window.location.href='php/salir.php'">SALIR</button> <!-- Botón para cerrar sesión -->
    </div>
</body>
</html>

<style>
    .container {
        max-width: 600px;
        margin: 0 auto;
        padding: 20px;
        text-align: center;
        border: 1px solid #ddd;
        border-radius: 8px;
        background-color: #f9f9f9;
    }

    .header {
        margin-bottom: 20px;
    }

    .header h1 {
        margin: 0;
        color: #07ac96;
    }

    .header .logo {
        width: 100px;
        margin-bottom: 10px;
    }

    .actions {
        margin-top: 20px;
        display: grid;
        grid-template-columns: repeat(2, 150px); /* Dos columnas de 150px cada una */
        grid-template-rows: repeat(2, 150px); /* Dos filas de 150px cada una */
        gap: 20px; /* Espacio entre los botones */
        justify-content: center; /* Centra el grid horizontalmente */
    }

    .action-button {
        width: 150px; /* Ancho fijo */
        height: 150px; /* Alto fijo, cuadrado */
        background-color: #07ac96;
        color: #fff;
        border: none;
        border-radius: 5px;
        font-size: 14px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
    }

    .action-button:hover {
        background-color: #0056b3; /* Color azul oscuro en hover */
    }

    .logout-button {
        margin-top: 20px;
        width: 150px;
        height: 50px;
        background-color: #07ac96;
        color: #fff;
        border: none;
        border-radius: 5px;
        font-size: 16px;
        cursor: pointer;
    }

    .logout-button:hover {
        background-color: #dc3545; /* Cambia a rojo al hacer hover */
    }
</style>
