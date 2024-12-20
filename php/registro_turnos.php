<?php
header('Content-Type: application/json');

// Conéctate a la base de datos (ajusta según tu configuración)
$servername = "localhost";
$username = "root";
$password = "maximo2213";
$dbname = "centro_medico";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica la conexión
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Error de conexión a la base de datos']);
    exit;
}

// Función para obtener horarios ocupados
function getOccupiedTimes($conn, $medico, $dia) {
    $query = "SELECT hora FROM turnos WHERE medico = ? AND dia = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $medico, $dia);
    $stmt->execute();
    $result = $stmt->get_result();
    $occupiedTimes = [];
    
    while ($row = $result->fetch_assoc()) {
        $occupiedTimes[] = $row['hora'];
    }
    
    return $occupiedTimes;
}

// Manejar solicitud GET para obtener horarios ocupados
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['medico']) && isset($_GET['dia'])) {
    $medico = $_GET['medico'];
    $dia = $_GET['dia'];

    error_log("Día recibido en el servidor: $dia");  // Agrega este log para verificar

    $occupiedTimes = getOccupiedTimes($conn, $medico, $dia);

    echo json_encode($occupiedTimes);
    exit;
}

// Recoge los datos del formulario
$nombre = $_POST['nombre'];
$especialidad = $_POST['especialidad'];
$medico = $_POST['medico'];
$dia = $_POST['dia'];
$hora = $_POST['hora'];
$dni = $_POST['dni'];
$domicilio = $_POST['domicilio'];
$telefono = $_POST['telefono'];
$email = $_POST['email'];
$observaciones = $_POST['observaciones'];

// Verifica si ya existe un turno para el mismo médico, día y hora
$sql_verificar = "SELECT * FROM turnos WHERE especialidad = ? AND medico = ? AND dia = ? AND hora = ?";
$stmt_verificar = $conn->prepare($sql_verificar);
$stmt_verificar->bind_param("ssss", $especialidad, $medico, $dia, $hora);
$stmt_verificar->execute();
$result_verificar = $stmt_verificar->get_result();

if ($result_verificar->num_rows > 0) {
    echo json_encode(['success' => false, 'message' => 'El turno para el médico, día y hora seleccionados ya está ocupado.']);
} else {
    // Inserta el turno en la base de datos
    $sql = "INSERT INTO turnos (nombre, especialidad, medico, dia, hora, dni, domicilio, telefono, email, observaciones)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssss", $nombre, $especialidad, $medico, $dia, $hora, $dni, $domicilio, $telefono, $email, $observaciones);

    if ($stmt->execute() === TRUE) {
        echo json_encode(['success' => true, 'dni' => $dni]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al guardar el turno: ' . $conn->error]);
    }
}

$conn->close();
?>

