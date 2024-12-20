<?php
// Conectar a la base de datos
$mysqli = new mysqli("localhost", "root", "maximo2213", "centro_medico");

if ($mysqli->connect_error) {
    die("Error de conexión: " . $mysqli->connect_error);
}

$dni = $_GET['dni'];

if ($dni) {
    // Consultar si el paciente ya tiene un turno registrado
    $sql = "SELECT nombre, domicilio, telefono, email FROM turnos WHERE dni = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $dni);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $patient = $result->fetch_assoc();
        echo json_encode(['exists' => true, 'nombre' => $patient['nombre'], 'domicilio' => $patient['domicilio'], 'telefono' => $patient['telefono'], 'email' => $patient['email']]);
    } else {
        echo json_encode(['exists' => false]);
    }

    $stmt->close();
}

$mysqli->close();
?>
