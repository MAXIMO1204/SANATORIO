<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Médico</title>
    <style>
        body {
            background: linear-gradient(rgba(33, 66, 39, 0.486), rgba(33, 66, 39, 0.486)), url(img/fondo.jpg);
            font-family: Arial, sans-serif; /* Fuente del cuerpo del documento */
            
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

        input[type="text"],
        input[type="file"] {
            width: calc(100% - 22px); /* Ancho completo menos el padding y borde */
            padding: 10px; /* Espaciado interno */
            margin-bottom: 15px; /* Margen inferior */
            border: 1px solid #ccc; /* Borde */
            border-radius: 5px; /* Bordes redondeados */
            box-sizing: border-box; /* Incluye el borde y el padding en el ancho y alto */
        }

        button {
            background-color: #07ac96; /* Color de fondo del botón */
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
            background-color: #218838; /* Color de fondo al pasar el cursor */
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>CENTRO MEDICO GRIERSON</h1>
        <h2>Formulario para agregar un nuevo médico</h2>
        <form id="form-staff-medico" method="POST" action="crud.php" enctype="multipart/form-data">
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" id="nombre" required>
            <label for="especialidad">Especialidad:</label>
            <input type="text" name="especialidad" id="especialidad" required>
            <label for="atencion">Atención:</label>
            <input type="text" name="atencion" id="atencion" required>
            <label for="imagen">Imagen:</label>
            <input type="file" name="imagen" id="imagen" required>
            <button type="submit" name="accion" value="crear">Guardar</button>
        </form>
    </div>
</body>
</html>
