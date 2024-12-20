<?php
header('Content-Type: application/json');

// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "maximo2213";
$dbname = "centro_medico";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode([]);
    exit;
}

$medico = $_GET['medico'];
$especialidad = $_GET['especialidad'];
$dia = $_GET['dia'];

$sql = "SELECT hora FROM turnos WHERE medico = ? AND especialidad = ? AND dia = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $medico, $especialidad, $dia);
$stmt->execute();
$result = $stmt->get_result();

$horarios_ocupados = [];
while ($row = $result->fetch_assoc()) {
    $horarios_ocupados[] = $row['hora'];
}

echo json_encode($horarios_ocupados);

$conn->close();
?>
<script>
function actualizarHorariosOcupados() {
    var medico = document.getElementById('medico').value;
    var dia = document.getElementById('dia').value;  // Asegúrate de que 'dia' sea la fecha completa en formato YYYY-MM-DD

    if (medico && dia) {
        fetch(`registro_turnos.php?medico=${medico}&dia=${dia}`)
            .then(response => response.json())
            .then(data => {
                // Aquí es donde deshabilitas los horarios ocupados
                var selectHora = document.getElementById('hora');
                for (var i = 0; i < selectHora.options.length; i++) {
                    if (data.includes(selectHora.options[i].value)) {
                        selectHora.options[i].disabled = true;
                    } else {
                        selectHora.options[i].disabled = false;
                    }
                }
            })
            .catch(error => console.error('Error:', error));
    }
}
</script>


