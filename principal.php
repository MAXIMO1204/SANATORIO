<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
        integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
         integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous"> 
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>   
    <link rel="stylesheet" href="estilo.css">
    <link rel="stylesheet" href="botones-crud.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="shortcut icon" href="/clinica/img/nosotros.png" type="icon" />
    
    <title>CENTRO MEDICO GRIERSON</title>
           
    
</head>

<body>

    <!-- MENU -->
<div class="contenedor-header">
    <header>
        <strong><span style="text-transform: uppercase;font-size: 24px;" class="txtRojo">CENTRO MEDICO GRIERSON</span></strong>
        <nav id="nav">
            <a style="font-weight: bold; text-transform: uppercase;" href="#inicio" onclick="seleccionar(event)">Inicio</a>
            <a style="font-weight: bold; text-transform: uppercase;" href="#nosotros" onclick="seleccionar(event)">Nosotros</a>
            <a style="font-weight: bold; text-transform: uppercase;" href="#servicios" onclick="seleccionar(event)">Servicios</a>
            <a style="font-weight: bold; text-transform: uppercase;" href="#especialidades" onclick="seleccionar(event)">Especialidades</a>
            <a style="font-weight: bold; text-transform: uppercase;" href="#staff" onclick="seleccionar(event)">Staff Médico</a>
            <a style="font-weight: bold; text-transform: uppercase;" href="#about" onclick="seleccionar(event)">Novedades</a>
            <a style="font-weight: bold; text-transform: uppercase;" href="#contacto" onclick="seleccionar(event)">Contacto</a>
        </nav>

        <ul style="list-style-type: none; padding: 0; margin: 0; display: flex; align-items: center;">
            <li style="margin-right: 20px; font-size: 14px;">
                <?php if (isset($_SESSION['administrador'])) : ?>
                    <span style="font-weight: bold; text-transform: uppercase; font-size: 14px; margin-right: 10px;">
                        <?php echo htmlspecialchars($_SESSION['administrador']); ?>
                    </span>
                    <a href="php/salir.php" style="font-weight: bold; text-transform: uppercase; font-size: 14px; 
                    color: red; text-decoration: none;">Salir</a>
                <?php elseif (isset($_SESSION['usuario'])) : ?>
                    <span style="font-weight: bold; text-transform: uppercase; font-size: 14px; margin-right: 10px;">
                        <?php echo htmlspecialchars($_SESSION['usuario']); ?>
                    </span>
                    <a href="php/salir.php" style="font-weight: bold; text-transform: uppercase; font-size: 14px; 
                    color: red; text-decoration: none;">Salir</a>
                <?php else : ?>
                    <a href="login.php" style="font-weight: bold; text-transform: uppercase; font-size: 14px; 
                    color: #07ac96; text-decoration: none;">Login</a>
                <?php endif; ?>
            </li>
        </ul>

          <!-- Icono del menu responsive -->
          <div id="icono-nav" class="nav-responsive" onclick="mostrarOcultarMenu()">
                <i class="fa-solid fa-bars"></i>
            </div>
    </header>
</div>

    <!-- SECCION INICIO -->
    <section id="inicio" class="inicio" style="background: linear-gradient(
               rgba(33, 66, 39, 0.5),
               rgba(33, 66, 39, 0.5)
           ), url('img/fondo.jpg') center center/cover no-repeat; animation: backgroundZoom 20s ease-in-out infinite alternate;">
    <div class="contenido-seccion">
        <div class="info">
            <h2>UN CENTRO MÉDICO COMPROMETIDO CON TU SALUD Y BIENESTAR</h2>
        </div>
    </div>
</section>


    <!-- SECCION NOSOTROS -->
<!-- SECCION NOSOTROS -->
<section id="nosotros" class="nosotros">
    <div class="nosotros-intro"><br><br><br><br>
        <h2>CONOCE NUESTRO CENTRO MEDICO</h2>
        <p>En nuestro Centro Medico, nos dedicamos a proporcionar un servicio de salud integral con la más alta calidad y tecnología.</p>
    </div>

    <div id="carouselExample" class="carousel slide">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="/clinica/img/clinica1.jpg" class="d-block w-100" alt="Imagen de la clínica 1">
        </div>
        <div class="carousel-item">
            <img src="/clinica/img/clinica2.jpg" class="d-block w-100" alt="Imagen de la clínica 2">
        </div>
        <div class="carousel-item">
            <img src="/clinica/img/clinica3.jpg" class="d-block w-100" alt="Imagen de la clínica 2">
        </div>
        
        
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>


<div class="nosotros-info">
    <!-- Reseña Histórica -->
    <div class="historical-review">
        <h2>Historia del Centro Médico</h2>
        <p>Nuestro centro médico fue fundado en 1990 con el objetivo de proporcionar atención médica de alta calidad a la comunidad. Desde nuestros inicios, hemos estado comprometidos con la excelencia en el cuidado de la salud, incorporando las últimas tecnologías y técnicas médicas. A lo largo de los años, hemos crecido y evolucionado, convirtiéndonos en un referente en el sector de la salud gracias a nuestro enfoque en el bienestar del paciente y la mejora continua de nuestros servicios.</p>
        
        <div class="inspiration">
            <h3>Inspiración: Cecilia Grierson</h3>
            <p>Cecilia Grierson (1859-1934) fue la primera mujer en recibir un título de médico en Argentina y una pionera en el campo de la medicina. Su dedicación y esfuerzo en un momento en que las mujeres enfrentaban enormes barreras en el ámbito médico, la convirtieron en una figura inspiradora para la fundación de nuestro centro médico. Su legado de compromiso con la salud y la igualdad en el acceso a la atención médica nos impulsa a seguir sus pasos y a brindar un cuidado de calidad a todos nuestros pacientes.</p>
            <img src="/clinica/img/cecilia-grierson.jpg" alt="Cecilia Grierson" class="cecilia-photo">
        </div>
    </div>

    
    <!-- Información de Servicios -->
    <div class="info-item">
        <h3>Vocación de Servicio</h3>
        <p>Nos esforzamos por brindar soluciones integrales de salud a quienes confían en nosotros.</p>
    </div>
    <div class="info-item">
        <h3>Especialidades y Tecnología</h3>
        <p>Contamos con una amplia variedad de especialidades médicas y equipamiento de última generación.</p>
    </div>
    <div class="info-item">
    <h3>Medicina Preventiva</h3>
    <p>Nos enfocamos en la medicina preventiva para detectar posibles problemas de salud antes de que se conviertan en enfermedades graves.</p>
        </div>
        <div class="info-item">
            <h3>Atención Integral</h3>
            <p>Ofrecemos atención integral que incluye no solo el tratamiento de enfermedades, sino también la promoción de un estilo de vida saludable.</p>
        </div>
        <div class="info-item">
            <h3>Compromiso Social</h3>
            <p>Estamos comprometidos con nuestra comunidad y participamos en iniciativas sociales y programas de salud pública para contribuir al bienestar general.</p>
        </div>

    <div class="info-item">
        <h3>Servicios Destacados</h3>
        <p>Desde tratamientos de ortodoncia hasta fisioterapia, ofrecemos servicios con la mejor calidad y precio.</p>
    </div>
    <div class="info-item">
        <h3>Atención Personalizada</h3>
        <p>Nos enorgullecemos de brindar atención personalizada a cada uno de nuestros pacientes, adaptándonos a sus necesidades individuales.</p>
    </div>
    <div class="info-item">
        <h3>Equipo Multidisciplinario</h3>
        <p>Contamos con un equipo de profesionales altamente capacitados en diversas especialidades, trabajando en conjunto para ofrecer el mejor cuidado.</p>
    </div>
    <div class="info-item">
        <h3>Compromiso con la Innovación</h3>
        <p>Invertimos en la última tecnología y metodologías avanzadas para garantizar tratamientos efectivos y seguros.</p>
    </div>
    <div class="info-item">
        <h3>Facilidades de Pago</h3>
        <p>Ofrecemos múltiples opciones de pago y financiamiento para que nuestros servicios sean accesibles a todos.</p>
    </div>
    <div class="info-item">
        <h3>Accesibilidad y Ubicación</h3>
        <p>Nuestra clínica está estratégicamente ubicada para ofrecer comodidad y fácil acceso a nuestros pacientes.</p>
    </div>
    <div class="info-item">
        <h3>Apoyo Continuo</h3>
        <p>Brindamos apoyo continuo a nuestros pacientes, asegurando que reciban seguimiento y cuidados post-tratamiento adecuados.</p>
    </div>
</div>


    <div class="mapa">
        <h3>Ubicación</h3>
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3560.8593771833557!2d-65.23673592477931!3d-26.81260587670689!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94225c56f217c955%3A0xbfafd4c61740d400!2sAv.%20Manuel%20Belgrano%202606%2C%20T4000%20San%20Miguel%20de%20Tucum%C3%A1n%2C%20Tucum%C3%A1n!5e0!3m2!1ses-419!2sar!4v1724297817221!5m2!1ses-419!2sar" width="800" height="600" style="border:0;"
            allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
     
       
    </div>
    



</section>



    <section id="servicios" class="servicios">
        <br><br><br><br>
    <h2>SERVICIOS</h2>
    <div class="main">
        <div class="card">
            <div class="front">
                <img src="/clinica/img/1.png" alt="Cirugía Ambulatoria">
                <h1 style="font-weight: bold; text-transform: uppercase;text-align: center; font-size: 20px">Cirugía Ambulatoria</h1>
            </div>
            <div class="back">
                <p>Ponemos a tu disposición los procedimientos quirúrgicos sin necesidad de un internamiento prolongado.</p>
            </div>
        </div>

        <div class="card">
            <div class="front">
                <img src="/clinica/img/2.png" alt="Quirófano">
                <h1 style="font-weight: bold; text-transform: uppercase;text-align: center; font-size: 20px">Quirófano</h1>
            </div>
            <div class="back">
                <p>Quirófano altamente equipado para realizar distintos procedimientos de manera segura y eficaz.</p>
            </div>
        </div>

        <div class="card">
            <div class="front">
                <img src="/clinica/img/3.png" alt="Rayos X">
                <h1 style="font-weight: bold; text-transform: uppercase;text-align: center; font-size: 20px">Rayos X</h1>
            </div>
            <div class="back">
                <p>Contamos con el personal especializado y el equipo de alta calidad para ofrecerte el mejor servicio de Rayos X.</p>
            </div>
        </div>

        <div class="card">
            <div class="front">
                <img src="/clinica/img/4.png" alt="Ecografías Urología">
                <h1 style="font-weight: bold; text-transform: uppercase;text-align: center; font-size: 20px">Ecografías Urología</h1>
            </div>
            <div class="back">
                <p>Te proporcionamos el mejor servicio de ultrasonido para detectar algún problema de tu sistema urológico.</p>
            </div>
        </div>

        <div class="card">
            <div class="front">
                <img src="/clinica/img/5.png" alt="Farmacia">
                <h1 style="font-weight: bold; text-transform: uppercase;text-align: center; font-size: 20px">Farmacia</h1>
            </div>
            <div class="back">
                <p>Para brindarte un servicio completo contamos con Farmacia, en donde encontraras medicamentos de alta especialidad y de la mejor calidad.</p>
            </div>
        </div>

        <div class="card">
            <div class="front">
                <img src="/clinica/img/6.png" alt="Laboratorio">
                <h1 style="font-weight: bold; text-transform: uppercase;text-align: center; font-size: 20px">Laboratorio</h1>
            </div>
            <div class="back">
                <p>A través de nuestro personal capacitado y el equipo clínico, realizamos diagnósticos y resultados confiables y oportunos.</p>
            </div>
        </div>

        <div class="card">
            <div class="front">
                <img src="/clinica/img/7.png" alt="Convenio con empresas">
                <h1 style="font-weight: bold; text-transform: uppercase;text-align: center; font-size: 20px">Convenio con empresas</h1>
            </div>
            <div class="back">
                <p>Nos interesa que tú y tu personal gocen de salud. Por eso contamos con servicios para empresas. Contáctanos para más información.</p>
            </div>
        </div>

        <div class="card">
            <div class="front">
                <img src="/clinica/img/8.png" alt="Prueba de COVID Nasal">
                <h1 style="font-weight: bold; text-transform: uppercase;text-align: center; font-size: 20px">Prueba de COVID Nasal</h1>
            </div>
            <div class="back">
                <p>Prueba de detección de COVID-19. Se introduce un hisopo en la nariz para tomar la muestra que se enviará a análisis.</p>
            </div>
        </div>
    </div>
</section>


<section id="especialidades" class="especialidades">
    <h2>ESPECIALIDADES</h2>

    <div class="especialidades-container">
        <div class="especialidad-item">
            <div class="especialidad-icono">
                <img src="/clinica/img/30.png" alt="Medicina General">
            </div>
            <div class="especialidad-info">
                <h3>Medicina General</h3>
                <p>Nuestros médicos generales se encargan de la prevención, detección, tratamiento de enfermedades generales.</p>
            </div>
        </div>
        <div class="especialidad-item">
            <div class="especialidad-icono">
                <img src="/clinica/img/31.png" alt="Pediatría">
            </div>
            <div class="especialidad-info">
                <h3>Pediatría</h3>
                <p>Nuestros pediatras son especialistas en el cuidado de la salud de los más pequeños, desde el nacimiento hasta los 18 años.</p>
            </div>
        </div>
        <div class="especialidad-item">
            <div class="especialidad-icono">
                <img src="/clinica/img/32.png" alt="Ginecología">
            </div>
            <div class="especialidad-info">
                <h3>Ginecología</h3>
                <p>Nuestros ginecólogos son especialistas en el cuidado de la salud de la mujer, la prevención, el diagnóstico y el tratamiento de enfermedades.</p>
            </div>
        </div>
        <div class="especialidad-item">
            <div class="especialidad-icono">
                <img src="/clinica/img/33.png" alt="Traumatología">
            </div>
            <div class="especialidad-info">
                <h3>Traumatología</h3>
                <p>Estos especialistas se encargan del diagnóstico, tratamiento de lesiones y enfermedades músculo-esqueléticas.</p>
            </div>
        </div>
        <div class="especialidad-item">
            <div class="especialidad-icono">
                <img src="/clinica/img/34.png" alt="Urología">
            </div>
            <div class="especialidad-info">
                <h3>Urología</h3>
                <p>Nuestros urólogos son especialistas en el diagnóstico y tratamiento de enfermedades del riñon y sistema urinario en hombres y mujeres.</p>
            </div>
        </div>
        <div class="especialidad-item">
            <div class="especialidad-icono">
                <img src="/clinica/img/35.png" alt="Cirugía General">
            </div>
            <div class="especialidad-info">
                <h3>Cirugía General</h3>
                <p>Nuestros cirujanos generales son especialistas en el manejo quirúrgico de distintas enfermedades, incluyendo las del sistema digestivo.</p>
            </div>
        </div>

        <div class="especialidad-item">
            <div class="especialidad-icono">
                <img src="/clinica/img/41.png" alt="Cardiología">
            </div>
            <div class="especialidad-info">
                <h3>Cardiología</h3>
                <p>Los cardiólogos se especializan en el diagnóstico y tratamiento de enfermedades del corazón y del sistema circulatorio.</p>
            </div>
        </div>
        <div class="especialidad-item">
            <div class="especialidad-icono">
                <img src="/clinica/img/42.png" alt="Dermatología">
            </div>
            <div class="especialidad-info">
                <h3>Dermatología</h3>
                <p>Los dermatólogos se especializan en el diagnóstico y tratamiento de enfermedades de la piel, cabello y uñas.</p>
            </div>
        </div>
    </div>
</section>




<!--Staff Medico -->


    <section id="staff"class="staff"><br><br><br>
        <div class="title-cards">
            <h2>STAFF MEDICO</h2>
        </div>
   

<div class="container-card">
        
            
            <!-- Medicos cargados desde la base de datos -->
<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "maximo2213";
$dbname = "medicos";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$sql = "SELECT id, nombre, especialidad, atencion, imagen FROM staff_medico";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='card1'>
                <figure><img src='/clinica/img/" . $row['imagen'] . "'></figure>
                <div class='contenido-card'>
                    <h2>" . $row['nombre'] . "</h2>
                    <h3>" . $row['especialidad'] . "</h3>
                    <p>Atencion</p>
                    <p>" . $row['atencion'] . "</p>";

        // Mostrar el botón o mensaje de error según si el usuario ha iniciado sesión
        if (isset($_SESSION['usuario'])) {
            echo "<button type='button' class='boton-reservar' onclick=\"redirigirTurno('"
            . htmlspecialchars($row['nombre'], ENT_QUOTES) . "', '"
            . htmlspecialchars($row['especialidad'], ENT_QUOTES) . "', '"
            . htmlspecialchars($row['atencion'], ENT_QUOTES) . "')\">Reservar Turno</button>";
        } else {
            echo "<div class='mensaje-error' id='mensaje-error' style='font-weight: bold; text-transform: uppercase; 
            font-size: 14px; color: red; text-decoration: none;'>Debe iniciar sesión para reservar un turno.</div>";
        }

        echo "</div></div>";
    }
} else {
    echo "No se encontraron médicos.";
}

$conn->close();
?>
<script>
// Función para mostrar u ocultar los botones de "Reservar Turno" y mostrar un mensaje cuando no están disponibles
document.addEventListener('DOMContentLoaded', function() {
   // Obtener la fecha actual
var today = new Date();
// Obtener el día de la semana (0 = Domingo, 1 = Lunes, ..., 6 = Sábado)
var dayOfWeek = today.getDay();


    // Obtener todos los botones de "Reservar Turno"
    var buttons = document.querySelectorAll('.boton-reservar');

    // Si el día es sábado (6) o domingo (0), ocultar los botones y mostrar un mensaje
    if (dayOfWeek === 0 || dayOfWeek === 6) {
        buttons.forEach(function(button) {
            // Ocultar el botón
            button.style.display = 'none';
            
            // Crear el mensaje de error
            var errorMessage = document.createElement('div');
            errorMessage.className = 'mensaje-error';
            errorMessage.id = 'mensaje-error';
            errorMessage.style.fontWeight = 'bold';
            errorMessage.style.textTransform = 'uppercase';
            errorMessage.style.fontSize = '14px';
            errorMessage.style.color = '#07ac96';
            errorMessage.style.textDecoration = 'none';
            errorMessage.innerText = 'Turnos disponibles los días hábiles.';

            // Insertar el mensaje de error después del botón
            button.parentNode.insertBefore(errorMessage, button.nextSibling);
        });
    }
});
</script>




<script>
function redirigirTurno(nombre, especialidad, atencion) {
    const encodedNombre = encodeURIComponent(nombre);
    const encodedEspecialidad = encodeURIComponent(especialidad);
    const encodedAtencion = encodeURIComponent(atencion);
    const url = `turnos.php?nombre=${encodedNombre}&especialidad=${encodedEspecialidad}&atencion=${encodedAtencion}`;
    window.location.href = url;
}
</script>




</div>

   
    
<?php if (isset($_SESSION['administrador'])) : ?>
    <div class="crud-buttons">
        <button class="button-enabled" onclick="window.location.href='form_agregar.php'">Agregar Médico</button>
        <button class="button-enabled" onclick="window.location.href='form_editar.php'">Editar Médico</button>
        <button class="button-enabled" onclick="window.location.href='form_eliminar.php'">Eliminar Médico</button>
        <button class="button-enabled" onclick="window.location.href='form_filtrar_imprimir.php'">Filtrar e Imprimir Turnos</button>
    </div>
<?php else : ?>
    <div class="crud-buttons hidden">
        <button class="button-disabled" disabled>Agregar Médico</button>
        <button class="button-disabled" disabled>Editar Médico</button>
        <button class="button-disabled" disabled>Eliminar Médico</button>
        <button class="button-disabled" disabled>Filtrar e Imprimir Turnos</button>
    </div>
<?php endif; ?>


           

        </div>


    </section>




    <!-- SECCION NOVEDADES -->


    <section id="about" class="about"><BR><BR><BR><BR><BR>
    <h2 style="font-weight: bold; text-transform: uppercase;text-align: center; font-size: 30px">NOVEDADES</h2>
        <div class="post-filter container">
            <span class="filter-item active-filter" data-filter="all">TODOS</span>
            <span class="filter-item" data-filter="tech">SERVICIOS</span>
            <span class="filter-item" data-filter="food">ESPECIALISTAS</span>
            <span class="filter-item" data-filter="news">TURNOS</span>

        </div>
        <BR>
        <div class="post container">
    <!-- Post 1 -->
    <div class="post-box tech">
        <img src="/clinica/img/5.png" alt="" class="post-img">
        <h2 class="category">SERVICIOS</h2><BR>
        <strong>
            <h1 class="category">AMPLIACIÓN DE FARMACIA</h1>
        </strong>
        <span class="post-date">25 SET 2023</span>
        <p class="post-description">Las autoridades del Centro Médico Grierson han anunciado recientemente la ampliación
             de los horarios de atención de la farmacia, que entraron en vigencia a partir del jueves primero de junio. 
             Esta medida tiene como objetivo brindar un mejor servicio y accesibilidad a los pacientes, permitiendo una
              atención más eficiente durante todo el día.</p>
    </div>
    <!-- Post 2 -->
    <div class="post-box food">
        <img src="/clinica/img/fondo.jpg" alt="" class="post-img">
        <h2 class="category">ESPECIALISTAS</h2><BR>
        <strong>
            <h1 class="category">INCORPORACIÓN DE NUEVA ESPECIALIDAD MÉDICA</h1>
        </strong>
        <span class="post-date">12 SEP 2023</span>
        <p class="post-description">El Centro Médico Grierson se complace en anunciar la incorporación del Médico Clínico
             Agustín Barros a nuestro equipo. Con una vasta experiencia en la Medicina Interna, el Dr. Barros aportará un
              valioso conocimiento para el tratamiento y cuidado integral de nuestros pacientes. 
              Le damos la bienvenida con entusiasmo y le deseamos mucho éxito en su nuevo rol.</p>
    </div>
    <!-- Post 3 -->
    <div class="post-box food">
        <img src="/clinica/img/fondo.jpg" alt="" class="post-img">
        <h2 class="category">ESPECIALISTAS</h2><BR>
        <strong>
            <h1 class="category">POSGRADO EN CARDIOLOGÍA</h1>
        </strong>
        <span class="post-date">12 AGO 2023</span>
        <p class="post-description">La Comunidad del Centro Médico Grierson felicita al Dr. Mario Luis Ortiz por completar 
            con éxito su Posgrado en Cardiología en Estados Unidos. Este programa incluyó nuevas técnicas avanzadas, como 
            ergometrías, ecocardiogramas y cardioversiones. Su formación especializada contribuirá significativamente a la
             calidad de nuestros servicios cardiológicos.</p>
    </div>
    <!-- Post 4 -->
    <div class="post-box news">
        <img src="/clinica/img/img7.jpg" alt="" class="post-img">
        <h2 class="category">TURNOS</h2><BR>
        <strong>
            <h1 class="category">NUEVA INTERFAZ DE GESTIÓN DE TURNOS</h1>
        </strong>
        <span class="post-date">29 AGO 2023</span>
        <p class="post-description">Hemos implementado una nueva interfaz de gestión de turnos gracias al esfuerzo conjunto
             de nuestro Departamento de Sistemas. Este nuevo sistema permitirá a los pacientes reservar turnos para nuestras 
             especialidades de manera más eficiente y desde la comodidad de su hogar, mejorando la experiencia y la accesibilidad 
             al servicio.</p>
    </div>
    <!-- Post 5 -->
    <div class="post-box news">
        <img src="/clinica/img/img7.jpg" alt="" class="post-img">
        <h2 class="category">TURNOS</h2><BR>
        <strong>
            <h1 class="category">ACTUALIZACIÓN EN LA RESERVA DE TURNOS</h1>
        </strong>
        <span class="post-date">15 JUN 2023</span>
        <p class="post-description">Nuestra plataforma de reservas ha sido actualizada para ofrecer una experiencia más 
            intuitiva y rápida. Ahora es más fácil seleccionar el especialista que necesitas y asegurar tu turno sin complicaciones, 
            optimizando el tiempo de espera y mejorando la organización del centro.</p>
    </div>
    <!-- Post 6 -->
    <div class="post-box tech">
        <img src="/clinica/img/1.png" alt="" class="post-img">
        <h2 class="category">SERVICIOS</h2><BR>
        <strong>
            <h1 class="category">MEJORAS EN EL SISTEMA DE IMÁGENES</h1>
        </strong>
        <span class="post-date">10 JUL 2023</span>
        <p class="post-description">El Centro Médico Grierson ha actualizado su sistema de imágenes médicas,
             lo que permitirá una visualización más clara y detallada de los estudios realizados. Esta mejora tecnológica 
             contribuirá a diagnósticos más precisos y a un mejor seguimiento del estado de salud de nuestros pacientes.</p>
    </div>
    <!-- Post 7 -->
    <div class="post-box tech">
        <img src="/clinica/img/1.png" alt="" class="post-img">
        <h2 class="category">SERVICIOS</h2><BR>
        <strong>
            <h1 class="category">NUEVO EQUIPO DE RESONANCIA MAGNÉTICA</h1>
        </strong>
        <span class="post-date">22 JUL 2023</span>
        <p class="post-description">Hemos adquirido un nuevo equipo de resonancia magnética que ofrecerá imágenes de 
            alta resolución y mayor rapidez en los estudios. Este avance permitirá realizar evaluaciones más completas 
            y precisas para nuestros pacientes.</p>
    </div>
    <!-- Post 8 -->
    <div class="post-box news">
        <img src="/clinica/img/img7.jpg" alt="" class="post-img">
        <h2 class="category">TURNOS</h2><BR>
        <strong>
            <h1 class="category">INCREMENTO EN LA CAPACIDAD DE ATENCIÓN</h1>
        </strong>
        <span class="post-date">05 AGO 2023</span>
        <p class="post-description">Gracias a la expansión de nuestras instalaciones y la incorporación de nuevo personal,
             hemos incrementado nuestra capacidad de atención. Esto permitirá reducir los tiempos de espera y ofrecer un 
             servicio más ágil y eficiente a todos nuestros pacientes.</p>
    </div>
    <!-- Post 9-->
    <div class="post-box food">
        <img src="/clinica/img/fondo.jpg" alt="" class="post-img">
        <h2 class="category">ESPECIALISTAS</h2><BR>
        <strong>
            <h1 class="category">NUEVO ESPECIALISTA EN NEUROLOGÍA</h1>
        </strong>
        <span class="post-date">20 JUN 2023</span>
        <p class="post-description">Nos complace anunciar la incorporación del Dr. Javier López, un destacado neurólogo 
            con experiencia en el diagnóstico y tratamiento de trastornos neurológicos. Su llegada fortalecerá nuestro 
            equipo y mejorará la atención en el área de neurología.</p>
    </div>
    <!-- Post 10 -->
    <div class="post-box news">
        <img src="/clinica/img/img7.jpg" alt="" class="post-img">
        <h2 class="category">TURNOS</h2><BR>
        <strong>
            <h1 class="category">OPTIMIZACIÓN DEL SISTEMA DE TURNOS</h1>
        </strong>
        <span class="post-date">11 SEP 2023</span>
        <p class="post-description">Hemos optimizado nuestro sistema de gestión de turnos para ofrecer una experiencia más 
            fluida y menos congestionada. Esta mejora permitirá a los pacientes acceder a citas con mayor facilidad y con menos 
            tiempo de espera.</p>
    </div>
    <!-- Post 11 -->
    <div class="post-box food">
        <img src="/clinica/img/fondo.jpg" alt="" class="post-img">
        <h2 class="category">ESPECIALISTAS</h2><BR>
        <strong>
            <h1 class="category">INTRODUCCIÓN DE NUEVAS ESPECIALIDADES</h1>
        </strong>
        <span class="post-date">30 JUL 2023</span>
        <p class="post-description">El Centro Médico Grierson ha introducido nuevas especialidades para ampliar nuestra
             gama de servicios. Ahora contamos con expertos en áreas adicionales como endocrinología y gastroenterología, 
             lo que permitirá ofrecer una atención más integral a nuestros pacientes.</p>
    </div>
    <!-- Post 12 -->
    <div class="post-box tech">
        <img src="/clinica/img/1.png" alt="" class="post-img">
        <h2 class="category">SERVICIOS</h2><BR>
        <strong>
            <h1 class="category">ACTUALIZACIÓN DEL SOFTWARE DE GESTIÓN</h1>
        </strong>
        <span class="post-date">25 JUN 2023</span>
        <p class="post-description">Hemos actualizado nuestro software de gestión para mejorar la administración de 
            nuestros servicios. Esta nueva versión ofrece características mejoradas que facilitan la coordinación y gestión 
            de los pacientes, optimizando así el flujo de trabajo en el centro.</p>
    </div>
</div>


    </section>

   
      
<section  id="contacto" class="contacto">
    <div class="contenido-seccion">
        <div class="contenedor-titulo">
            <div class="info">
                <h2>CONTACTO</h2>
            </div>
        </div>
        <form id="contactoForm" action="php/enviar_mensaje.php" method="POST">
            <div class="fila">
                <div class="col">
                    <input type="email" id="correo" name="correo" placeholder="Ingrese Email" required>
                </div>
                <div class="col">
                    <input type="text" id="nombre" name="nombre" placeholder="Ingrese Nombre" required>
                </div>
            </div>
            <div class="mensaje">
                <textarea id="mensaje" name="mensaje" cols="30" rows="10" placeholder="Ingresa el Mensaje" required></textarea>
                <button type="submit">Enviar Mensaje</button>
            </div>
            <div class="fila-datos">
                <div class="col">
                    <i class="fa-solid fa-location-dot"></i>
                    Calle Belgrano 2606
                </div>
                <div class="col">
                    <i class="fa-solid fa-phone"></i>
                    3865 - 459977
                </div>
                <div class="col">
                    <i class="fa-regular fa-clock"></i>
                    Lunes a Domingo, 8:00h - 24:00h
                </div>
            </div>
        </form>
    </div>
</section>



      <!-- Remove the container if you want to extend the Footer to full width. -->
<div class="container my-5">
    <!-- Footer -->
    <footer
            class="text-center text-lg-start text-dark"
            style="background-color: #ECEFF1"
            >
      <!-- Section: Social media -->
      <section
               class="d-flex justify-content-between p-4 text-white"
               style="background-color: #07ac96"
               >
        <!-- Left -->
        <div class="me-5">
          <span>CONECTATE A TODAS NUESTRAS PLATAFORMAS Y PARA VER TODAS NUESTRAS NOVEDAES</span>
        </div>
        <!-- Left -->
  
        <!-- Right -->
        <div>
          <a href="" class="text-white me-4">
            <i class="fab fa-facebook-f"></i>
          </a>
          <a href="" class="text-white me-4">
            <i class="fab fa-twitter"></i>
          </a>
          <a href="" class="text-white me-4">
            <i class="fab fa-google"></i>
          </a>
          <a href="" class="text-white me-4">
            <i class="fab fa-instagram"></i>
          </a>          
        </div>
        <!-- Right -->
      </section>
      <!-- Section: Social media -->
  
      <!-- Section: Links  -->
      <section class="">
        <div class="container text-center text-md-start mt-5">
          <!-- Grid row -->
          <div class="row mt-3">
            <!-- Grid column -->
            <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">
              <!-- Content -->
              <h6 class="text-uppercase fw-bold">CENTRO MEDICO GRIERSON</h6>
              <hr
                  class="mb-4 mt-0 d-inline-block mx-auto"
                  style="width: 60px; background-color: #7c4dff; height: 2px"
                  />
              <p>
              UN CENTRO MÉDICO COMPROMETIDO CON TU SALUD Y BIENESTAR
              </p>
            </div>
            <!-- Grid column -->
  
            
            <!-- Grid column -->
            <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
              <!-- Links -->
              <h6 class="text-uppercase fw-bold">MENU</h6>
              <hr
                  class="mb-4 mt-0 d-inline-block mx-auto"
                  style="width: 60px; background-color: #7c4dff; height: 2px"
                  />
              <p>
                <a href="#nosotros" class="text-dark">Nosotros</a>
              
              </p>
              <p>
                <a href="#servicios" class="text-dark">Servicios</a>
              
              </p>
              <p>
                <a href="#especialidades" class="text-dark">Especialidades</a>
              
              </p>
              <p>
                <a href="#about" class="text-dark">Novedades</a>
              
              </p>
             
            </div>
            <!-- Grid column -->
  
            <!-- Grid column -->
            <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
              <!-- Links -->
              <h6 class="text-uppercase fw-bold">Contacto</h6>
              <hr
                  class="mb-4 mt-0 d-inline-block mx-auto"
                  style="width: 60px; background-color: #7c4dff; height: 2px"
                  />
              <p><i class="fas fa-home mr-3"></i> BELGRANO 2606</p>
              <p><i class="fas fa-home mr-3"></i> LA COCHA (4162)- TUCUMAN</p>
              <p><i class="fas fa-envelope mr-3"></i> cmgrierson@gmail.com</p>
              <p><i class="fas fa-phone mr-3"></i> + 54 3865 - 459977</p>
          
            </div>
            <!-- Grid column -->
          </div>
          <!-- Grid row -->
        </div>
      </section>
      <!-- Section: Links  -->
  
      <!-- Copyright -->
      <div
           class="text-center p-3"
           style="background-color: rgba(0, 0, 0, 0.2)"
           >
        © 2024 Copyright
        <a class="text-dark">RAMIRO ATENCIO- DESARROLLO DE SOFTWARE</a
          >
      </div>
      <!-- Copyright -->
    </footer>
    <!-- Footer -->
  </div>
  <!-- End of .container -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"
        integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>


    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <a href="https://api.whatsapp.com/send?phone=5195508107&text=Hola%21%20Quisiera%20m%C3%A1s%20informaci%C3%B3n%20sobre%20Varela%202."
        class="float" target="_blank">
        <i class="fa fa-whatsapp my-float"></i> </a>
</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
 integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
 
<script src="app.js"></script>
<script src="main.js"></script>

<script src="turnos.js"></script>
<script src="acceso-admin.js"></script>
<script src="acceso-medico.js"></script>


</html>