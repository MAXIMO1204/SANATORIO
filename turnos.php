<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservar Turno</title>
    <link rel="stylesheet" href="turnos.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>
    <br><br>
    <h1>CENTRO MÉDICO GRIERSON</h1>
    <br>
    <h2>Reservas de Turno</h2>
    <br><br>

    <?php
    $nombre = isset($_GET['nombre']) ? htmlspecialchars($_GET['nombre'], ENT_QUOTES) : '';
    $especialidad = isset($_GET['especialidad']) ? htmlspecialchars($_GET['especialidad'], ENT_QUOTES) : '';
    $atencion = isset($_GET['atencion']) ? htmlspecialchars($_GET['atencion'], ENT_QUOTES) : '';

    $diasAtencion = explode(',', $atencion);
    ?>

    <form action="php/registro_turnos.php" method="POST" class="formulario__turno">
        <label for="dni" class="label-field">DNI:</label>
        <input type="text" id="dni" name="dni" required><br><br>

        <label for="nombre" class="label-field">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required><br><br>

        <label for="domicilio" class="label-field">Domicilio:</label>
        <input type="text" id="domicilio" name="domicilio" required><br><br>

        <label for="telefono" class="label-field">Teléfono:</label>
        <input type="tel" id="telefono" name="telefono" required><br><br>

        <label for="email" class="label-field">Email:</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="dia" class="label-field">Día:</label>
        <?php foreach ($diasAtencion as $dia): ?>
            <input type="text" id="dia" name="dia" value="<?php echo htmlspecialchars($dia); ?>" readonly required>
        <?php endforeach; ?><br><br>

        <label for="hora" class="label-field">Horario Preferido:</label>
        <select id="hora" name="hora" required>
            <option value="09:00">09:00</option>
            <option value="09:30">09:30</option>
            <option value="10:00">10:00</option>
            <option value="10:30">10:30</option>
            <option value="11:00">11:00</option>
            <option value="11:30">11:30</option>
            <option value="16:30">16:30</option>
            <option value="17:00">17:00</option>
            <option value="17:30">17:30</option>
            <option value="18:00">18:00</option>
            <option value="18:30">18:30</option>
            <option value="19:00">19:00</option>
            <option value="19:30">19:30</option>
        </select><br><br>

        <label for="especialidad" class="label-field">Especialidad:</label>
        <input type="text" id="especialidad" name="especialidad" value="<?php echo htmlspecialchars($especialidad); ?>" readonly><br><br>

        <label for="medico" class="label-field">Médico:</label>
        <input type="text" id="medico" name="medico" value="<?php echo htmlspecialchars($nombre); ?>" readonly><br><br>

        <label for="observaciones" class="label-field active">Observaciones:</label><br>
        <textarea id="observaciones" name="observaciones" rows="4" cols="50" required></textarea><br><br>

        <button type="submit" class="boton-reservar">Guardar e Imprimir Turno</button>
        <button type="button" id="limpiar" class="boton-limpiar">Limpiar</button>

    </form>
    <!-- Burbuja de Mensaje -->
    <div class="burbuja-mensaje">
        Por favor revise bien los datos ingresados y en caso de notar error u omisión pulse el botón LIMPIAR para volver a
        agregar datos en los campos y cuando esté todo en condiciones pulse el boton RESERVAR E IMPRIMIR TURNO.
    </div>

    <!-- Auto-complete script -->
    <script>
        document.getElementById('dni').addEventListener('blur', function() {
            var dni = this.value;

            if (dni) {
                fetch(`php/check_paciente.php?dni=${dni}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.exists) {
                            document.getElementById('nombre').value = data.nombre;
                            document.getElementById('domicilio').value = data.domicilio;
                            document.getElementById('telefono').value = data.telefono;
                            document.getElementById('email').value = data.email;

                            // Make fields readonly
                            document.getElementById('nombre').readOnly = true;
                            document.getElementById('domicilio').readOnly = true;
                            document.getElementById('telefono').readOnly = true;
                            document.getElementById('email').readOnly = true;

                            // Focus on observations field
                            document.getElementById('observaciones').focus();
                        } else {
                            // Clear fields if no patient data is found
                            document.getElementById('nombre').value = '';
                            document.getElementById('domicilio').value = '';
                            document.getElementById('telefono').value = '';
                            document.getElementById('email').value = '';
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching patient data:', error);
                    });
            }
        });

        document.getElementById('limpiar').addEventListener('click', function() {
            document.getElementById('dni').value = '';
            document.getElementById('nombre').value = '';
            document.getElementById('domicilio').value = '';
            document.getElementById('telefono').value = '';
            document.getElementById('email').value = '';
            document.getElementById('observaciones').value = '';

            // Make fields editable
            document.getElementById('nombre').readOnly = false;
            document.getElementById('domicilio').readOnly = false;
            document.getElementById('telefono').readOnly = false;
            document.getElementById('email').readOnly = false;
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
</body>

</html>


<script>
    document.querySelector('.formulario__turno').addEventListener('submit', function(event) {
        event.preventDefault();

        var formData = new FormData(this);

        fetch('php/registro_turnos.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: 'Turno reservado',
                        html: `<p>El turno ha sido reservado exitosamente.</p>
           <p><strong>Nombre:</strong> ${formData.get('nombre')}</p>
           <p><strong>Especialidad:</strong> ${formData.get('especialidad')}</p>
           <p><strong>Médico:</strong> ${formData.get('medico')}</p>
           <p><strong>Día:</strong> ${formData.get('dia')}</p>
           <p><strong>Hora:</strong> ${formData.get('hora')}</p>
           <p><strong>DNI:</strong> ${formData.get('dni')}</p>
           <p><strong>Domicilio:</strong> ${formData.get('domicilio')}</p>
           <p><strong>Teléfono:</strong> ${formData.get('telefono')}</p>
           <p><strong>Email:</strong> ${formData.get('email')}</p>
           <p><strong>Observaciones:</strong> ${formData.get('observaciones')}</p>
           <p><strong>SE RECUERDA QUE DEBERA PRESENTARSE POR MESA DE ENTRADA 15 MINUTOS PREVIOS A SU TURNO,
           CON EL MISMO IMPRESO O EN FORMATO PDF O COMO IMAGEN EN SU CELULAR
           Y CON DNI PARA VERIFICAR SUS DATOS. DESDE YA MUCHAS GRACIAS</strong></p>`,
                        icon: 'success',
                        confirmButtonText: 'Imprimir',
                        customClass: {
                            confirmButton: 'btn-confirmar',
                            htmlContainer: 'contenido-alerta'
                        },
                        preConfirm: () => {
                            // Generar el PDF
                            const {
                                jsPDF
                            } = window.jspdf;
                            const doc = new jsPDF();

                            // Define margins
                            const marginLeft = 15;
                            const marginTop = 20;
                            const lineHeight = 10;

                            // Estilizar el título
                            doc.setFontSize(16);
                            doc.setFont('Helvetica', 'bold');
                            doc.text('CENTRO MEDICO GRIERSON', doc.internal.pageSize.getWidth() / 2, marginTop, {
                                align: 'center'
                            });
                            doc.setLineWidth(0.5);
                            doc.line(marginLeft, marginTop + 2, doc.internal.pageSize.getWidth() - marginLeft, marginTop + 2);

                            // Estilizar el subtítulo
                            doc.setFontSize(14);
                            doc.text('Comprobante de Turno', doc.internal.pageSize.getWidth() / 2, marginTop + lineHeight, {
                                align: 'center'
                            });

                            // Resetear estilo para el contenido
                            doc.setFontSize(12);
                            doc.setFont('Helvetica', 'normal');

                            // Datos del formulario en mayúsculas
                            const formDataLines = [
                                `Nombre: ${formData.get('nombre').toUpperCase()}`,
                                `Especialidad: ${formData.get('especialidad').toUpperCase()}`,
                                `Médico: ${formData.get('medico').toUpperCase()}`,
                                `Día: ${formData.get('dia').toUpperCase()}`,
                                `Hora: ${formData.get('hora').toUpperCase()}`,
                                `DNI: ${formData.get('dni').toUpperCase()}`,
                                `Domicilio: ${formData.get('domicilio').toUpperCase()}`,
                                `Teléfono: ${formData.get('telefono').toUpperCase()}`,
                                `Email: ${formData.get('email')}`,
                                `Observaciones: ${formData.get('observaciones').toUpperCase()}`
                            ];

                            // Posición inicial para el contenido del formulario
                            let yPosition = marginTop + lineHeight * 3;

                            // Añadir cada línea de datos del formulario al PDF
                            formDataLines.forEach(line => {
                                doc.text(line, marginLeft, yPosition);
                                yPosition += lineHeight;
                            });

                            // Texto largo para evitar que quede cortado
                            const additionalText = "SE RECUERDA QUE DEBERÁ PRESENTARSE POR MESA DE ENTRADA 15 MINUTOS PREVIOS A SU TURNO, CON EL MISMO IMPRESO O EN FORMATO PDF O IMAGEN EN SU CELULAR Y CON DNI PARA VERIFICAR SUS DATOS. DESDE YA MUCHAS GRACIAS.".toUpperCase();
                            const additionalTextLines = doc.splitTextToSize(additionalText, doc.internal.pageSize.getWidth() - 2 * marginLeft);
                            doc.text(additionalTextLines, marginLeft, yPosition);


                            // Mostrar el PDF en una ventana nueva
                            window.open(URL.createObjectURL(doc.output('blob')), '_blank');

                            // Cerrar la ventana actual después de generar el PDF
                            window.close();
                        }
                    });


                    // Deshabilitar y marcar en rojo el horario reservado
                    document.querySelector(`#hora option[value="${formData.get('hora')}"]`).disabled = true;
                    document.querySelector(`#hora option[value="${formData.get('hora')}"]`).style.color = 'red';
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message,
                    });

                    // Marcar en rojo el horario ocupado en caso de error
                    var horaOcupada = formData.get('hora');
                    document.querySelector(`#hora option[value="${horaOcupada}"]`).disabled = true;
                    document.querySelector(`#hora option[value="${horaOcupada}"]`).style.color = 'red';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    title: 'Error',
                    text: 'Ocurrió un error al reservar el turno.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            });
    });

    document.getElementById('dia').addEventListener('change', function() {
        var medico = document.getElementById('medico').value;
        var dia = this.value;

        console.log(`Día seleccionado: ${dia}`); // Verifica que el día se está enviando correctamente

        fetch(`registro_turnos.php?medico=${encodeURIComponent(medico)}&dia=${encodeURIComponent(dia)}`)
            .then(response => response.json())
            .then(occupiedTimes => {
                console.log("Horarios ocupados recibidos:", occupiedTimes); // Verifica los horarios que devuelve el servidor
                var select = document.getElementById('hora');
                var allTimes = ['09:00', '09:30', '10:00', '10:30', '11:00', '11:30', '16:30', '17:00', '17:30',
                    '18:00', '18:30', '19:00', '19:30'
                ];

                select.innerHTML = '';

                allTimes.forEach(time => {
                    var option = document.createElement('option');
                    option.value = time;
                    option.textContent = time;
                    if (occupiedTimes.includes(time)) {
                        option.className = 'unavailable';
                        option.disabled = true;
                    } else {
                        option.className = 'available';
                    }
                    select.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Error al obtener horarios ocupados:', error);
            });
    });
</script>