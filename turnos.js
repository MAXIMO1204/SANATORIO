function redirigirTurno(nombre, especialidad, atencion) {
    // Codifica los parámetros de la URL para que se puedan usar en una dirección web sin problemas de caracteres especiales
    const encodedNombre = encodeURIComponent(nombre); // Codifica el nombre
    const encodedEspecialidad = encodeURIComponent(especialidad); // Codifica la especialidad
    const encodedAtencion = encodeURIComponent(atencion); // Codifica la atención

    // Construye la URL con los parámetros codificados para redireccionar
    const url = `turnos.php?nombre=${encodedNombre}&especialidad=${encodedEspecialidad}&atencion=${encodedAtencion}`;

    // Abre la URL construida en una nueva pestaña usando window.open con el parámetro '_blank'
    window.open(url, '_blank');
}

// Espera a que todo el contenido de la página se haya cargado antes de ejecutar el código dentro de la función
document.addEventListener('DOMContentLoaded', function() {
    // Selecciona todos los elementos con la clase 'label-field' para manipularlos cuando el campo observaciones esté en foco
    const labels = document.querySelectorAll('.label-field');
    const observaciones = document.getElementById('observaciones'); // Selecciona el campo de observaciones por su ID

    // Agrega un evento al campo 'observaciones' que se ejecuta cuando este campo recibe el foco
    observaciones.addEventListener('focus', function() {
        // Para cada elemento en 'labels', agrega la clase 'inactive' si el elemento no es el label de 'observaciones'
        labels.forEach(label => {
            if (label.getAttribute('for') !== 'observaciones') {
                label.classList.add('inactive'); // Añade la clase 'inactive' a las etiquetas que no están en foco
            }
        });
        // Añade la clase 'active' solo al label que precede al campo 'observaciones'
        observaciones.previousElementSibling.classList.add('active');
    });

    // Agrega un evento al campo 'observaciones' que se ejecuta cuando pierde el foco
    observaciones.addEventListener('blur', function() {
        // Remueve las clases 'inactive' y 'active' de todos los labels
        labels.forEach(label => {
            label.classList.remove('inactive', 'active');
        });
    });
});


