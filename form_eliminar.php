<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Médico</title>
    <style>
        body {
            font-family: Arial, sans-serif; /* Fuente del cuerpo del documento */
            background: linear-gradient(rgba(33, 66, 39, 0.486), rgba(33, 66, 39, 0.486)), url(img/fondo.jpg);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh; /* Altura completa de la ventana */
            margin: 0; /* Sin margen */
        }

        .form-container {
            background-color: white; /* Color de fondo del formulario */
            padding: 20px; /* Espaciado interno */
            border-radius: 10px; /* Bordes redondeados */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Sombra */
            max-width: 400px; /* Anchura máxima */
            width: 100%; /* Anchura completa */
            text-align: center; /* Alineación centrada del texto */
        }

        h1 {
            margin-bottom: 10px; /* Margen inferior */
            font-size: 24px; /* Tamaño de la fuente */
            color: #333; /* Color del texto */
        }

        h2 {
            margin-bottom: 20px; /* Margen inferior */
            font-size: 18px; /* Tamaño de la fuente */
            color: #666; /* Color del texto */
        }

        label {
            display: block; /* Los label se muestran como bloques */
            margin-bottom: 8px; /* Margen inferior */
            font-weight: bold; /* Negrita */
        }

        input[type="text"] {
            width: calc(100% - 22px); /* Ancho completo menos el padding y borde */
            padding: 10px; /* Espaciado interno */
            margin-bottom: 15px; /* Margen inferior */
            border: 1px solid #ccc; /* Borde */
            border-radius: 5px; /* Bordes redondeados */
            box-sizing: border-box; /* Incluye el borde y el padding en el ancho y alto */
        }

        button {
            background-color: #dc3545; /* Color de fondo del botón */
            border: none; /* Sin borde */
            color: white; /* Color del texto */
            padding: 10px 20px; /* Espaciado interno (arriba/abajo y derecha/izquierda) */
            text-align: center; /* Alinea el texto en el centro */
            text-decoration: none; /* Sin subrayado */
            display: inline-block; /* El botón se comporta como un elemento en línea */
            font-size: 16px; /* Tamaño de fuente */
            margin-top: 10px; /* Margen superior */
            cursor: pointer; /* Muestra un cursor de mano al pasar sobre el botón */
            border-radius: 5px; /* Bordes redondeados */
            transition: background-color 0.3s ease; /* Transición suave para el color de fondo */
        }

        button:hover {
            background-color: #c82333; /* Color de fondo al pasar el cursor */
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>Eliminar Médico</h1>
        <h2>Ingrese una palabra clave para buscar un médico</h2>
        <form id="form-eliminar-medico" method="POST" action="">
            <label for="keyword">Palabra clave (nombre o especialidad):</label>
            <input type="text" name="keyword" id="keyword" required>
            <button type="submit" name="buscar">Buscar</button>
        </form>

    <?php

$servername = "localhost";
$username = "root";
$password = "maximo2213";
$dbname = "medicos";
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['buscar'])) {
        $keyword = $_POST['keyword'];

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM staff_medico WHERE nombre LIKE '%$keyword%' OR especialidad LIKE '%$keyword%'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<form method='POST' action='crud.php'>
                        <input type='hidden' name='id' value='".$row['id']."'>
                        <p>¿Estás seguro de que deseas eliminar al Dr./Dra. ".$row['nombre']." (".$row['especialidad'].")?</p>
                        <button type='submit' name='accion' value='eliminar_confirmado'>Eliminar</button>
                    </form>";
            }
        } else {
            echo "No se encontraron resultados.";
        }

        $conn->close();
    }
    ?>
</body>
</html>
