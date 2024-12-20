<?php
// Datos de conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "maximo2213";
$dbname = "medicos";

// Crear conexión a la base de datos
$conn = new mysqli($servername, $username, $password, $dbname); // Crea una nueva conexión usando MySQLi

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error); // Termina el script si la conexión falla y muestra el mensaje de error
}

// Inicializar variables
$mensaje = ''; // Variable para almacenar mensajes de estado
$accion = isset($_POST['accion']) ? $_POST['accion'] : null; // Verifica si se ha enviado la variable 'accion' en el formulario y la asigna a $accion

// Verificar si se envió una solicitud POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') { 
    // Obtener los datos enviados desde el formulario
    $id = isset($_POST['id']) ? $_POST['id'] : null; // isset() verifica si 'id' está definido en $_POST; si no, asigna null
    $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : null;
    $especialidad = isset($_POST['especialidad']) ? $_POST['especialidad'] : null;
    $atencion = isset($_POST['atencion']) ? $_POST['atencion'] : null;
    $imagen = isset($_FILES['imagen']['name']) ? $_FILES['imagen']['name'] : null; // Verifica si existe 'imagen' en $_FILES, que contiene archivos subidos

    // Acción de crear un nuevo registro
    if ($accion === 'crear') {
        // Sentencia SQL para insertar un nuevo registro en la tabla 'staff_medico'
        $sql = "INSERT INTO staff_medico (nombre, especialidad, atencion, imagen) VALUES ('$nombre', '$especialidad', '$atencion', '$imagen')";
        
        // move_uploaded_file() mueve el archivo subido a la carpeta indicada (aquí, 'img/')
        if (move_uploaded_file($_FILES['imagen']['tmp_name'], "img/$imagen") && $conn->query($sql) === TRUE) {
            $mensaje = "Registro agregado correctamente"; // Mensaje de éxito
        } else {
            $mensaje = "Error al agregar el registro: " . $conn->error; // Muestra mensaje de error si algo falla
        }
    }
    // Acción de editar un registro existente
    elseif ($accion === 'editar') {
        // Actualizar con nueva imagen si se proporciona una, o solo actualizar datos
        if ($imagen) {
            $sql = "UPDATE staff_medico SET nombre='$nombre', especialidad='$especialidad', atencion='$atencion', imagen='$imagen' WHERE id=$id";
            // Mover nueva imagen si hay una en $_FILES usando move_uploaded_file()
            move_uploaded_file($_FILES['imagen']['tmp_name'], "img/$imagen"); 
        } else {
            $sql = "UPDATE staff_medico SET nombre='$nombre', especialidad='$especialidad', atencion='$atencion' WHERE id=$id";
        }
        // Ejecuta la consulta SQL para actualizar los datos
        if ($conn->query($sql) === TRUE) {
            $mensaje = "Registro actualizado correctamente"; // Mensaje de éxito
        } else {
            $mensaje = "Error al actualizar el registro: " . $conn->error; // Mensaje de error en caso de fallo
        }
    }
    // Acción de eliminar un registro existente
    elseif ($accion === 'eliminar_confirmado') {
        // Sentencia SQL para eliminar registro en 'staff_medico' según el ID
        $sql = "DELETE FROM staff_medico WHERE id=$id";
        // Ejecuta la consulta de eliminación
        if ($conn->query($sql) === TRUE) {
            $mensaje = "Registro eliminado correctamente"; // Mensaje de éxito
        } else {
            $mensaje = "Error al eliminar el registro: " . $conn->error; // Mensaje de error en caso de fallo
        }
    }

    // Generar el mensaje para mostrar con SweetAlert (una alerta visual)
    echo '<!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Procesar Acción</title>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
    <body>
        <script>
            window.onload = function() {
                Swal.fire({
                    title: "Acción Completada",
                    text: "' . $mensaje . '", // Muestra el mensaje de estado de la acción
                    icon: "success", // Tipo de alerta (éxito)
                    confirmButtonText: "OK"
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "principal.php"; 
                    }
                });
            }
        </script>
    </body>
    </html>';
}

// Cerrar la conexión a la base de datos
$conn->close(); // Cierra la conexión de MySQL
?>
