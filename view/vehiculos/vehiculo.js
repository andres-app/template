// Variable global para la tabla del DataTable
var tabla;

/**
 * Función de inicialización principal.
 * Se configura el evento 'submit' para el formulario de creación o edición de vehículos.
 */
function init() {
    // Configuración del evento submit para el formulario de creación o edición
    $("#mnt_form").on("submit", function(e) {
        guardaryeditar(e); // Llamar a la función para guardar o editar un registro
    });
}

/**
 * Función para guardar o editar un vehículo.
 * Se envían los datos del formulario mediante AJAX al controlador PHP.
 *
 * @param {Event} e - Evento de envío del formulario.
 */
function guardaryeditar(e) {
    e.preventDefault(); // Evitar el comportamiento por defecto del formulario

    var formData = new FormData($("#mnt_form")[0]); // Crear un objeto FormData con los datos del formulario

    // Enviar los datos mediante AJAX
    $.ajax({
        url: "../../controller/vehiculo.php?op=insertar", // URL del controlador para insertar el vehículo
        type: "POST", // Método de envío de datos
        data: formData, // Datos del formulario
        contentType: false, // No establecer ningún tipo de contenido para los datos
        processData: false, // No procesar los datos automáticamente (para permitir el uso de FormData)
        success: function(datos) {
            // Mostrar un mensaje de éxito usando SweetAlert
            Swal.fire('Registro', 'Vehículo registrado correctamente', 'success');
            // Recargar el DataTable para mostrar el nuevo registro
            tabla.ajax.reload();
            // Cerrar el modal de registro
            $("#mnt_modal").modal("hide");
        },
        error: function(e) {
            // Mostrar un mensaje de error en caso de que falle la inserción
            Swal.fire('Error', 'No se pudo registrar el vehículo', 'error');
        }
    });
}

/**
 * Configuración del DataTable para listar los vehículos registrados.
 * Se configura la tabla con opciones de exportación y búsqueda.
 */
$(document).ready(function() { 
    // Inicialización del DataTable con configuraciones personalizadas
    tabla = $("#listado_table").DataTable({
        "aProcessing": true,     // Activa el procesamiento en el lado del cliente
        "aServerSide": true,     // Activa el procesamiento en el lado del servidor
        dom: 'Bfrtip',           // Define los elementos de la interfaz del DataTable (Botones, filtro, etc.)
        "searching": true,       // Habilita la búsqueda en la tabla
        lengthChange: false,     // Deshabilita la opción para cambiar la cantidad de registros por página
        colReorder: true,        // Habilita la reordenación de columnas
        buttons: [               // Botones de exportación
            'copyHtml5',         // Copiar a portapapeles
            'excelHtml5',        // Exportar a Excel
            'csvHtml5',          // Exportar a CSV
            'pdfHtml5'           // Exportar a PDF
        ],
        "ajax": {
            url: '../../controller/vehiculo.php?op=listar', // URL del controlador para listar los vehículos
            type: "GET",         // Método de la petición
            dataType: "json",    // Tipo de datos esperados
            error: function(e) {  // Manejo de errores
                Swal.fire('Error', 'No se pudo cargar la lista de vehículos', 'error');
            }
        },
        "bDestroy": true,        // Permite destruir el DataTable y volver a inicializarlo
        "responsive": true,      // Hace que la tabla sea responsiva
        "bInfo": true,           // Muestra información sobre el DataTable (cantidad de registros, etc.)
        "iDisplayLength": 10,    // Define el número de registros a mostrar por página
        "autoWidth": false,      // Desactiva el ajuste automático del ancho de las columnas
        "order": [[ 0, "desc" ]],  // Ordena por la primera columna (ID) en forma descendente
        "columnDefs": [
            { 
                "targets": [0],  // Especifica que la primera columna (ID) se ocultará
                "visible": false,  // Hace la columna ID invisible
                "searchable": false // Impide que la columna ID sea parte de la búsqueda
            }
        ],

        // Configuraciones de idioma para traducir los textos a español
        "language": {
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningún dato disponible en esta tabla",
            "sInfo": "Mostrando un total de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando un total de 0 registros",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sSearch": "Buscar:",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        }
    });
});


/**
 * Evento para mostrar el modal cuando se hace clic en el botón "Nuevo Registro".
 * Se limpia el formulario y se prepara el modal para la creación de un nuevo vehículo.
 */
$("#btnnuevo").on("click", function() {
    $("#vehiculo_id").val('');   // Limpiar el campo de ID del vehículo
    $("#mnt_form")[0].reset();   // Resetea el formulario
    $("#myModalLabel").html('Nuevo Registro'); // Cambia el título del modal
    $("#mnt_modal").modal('show'); // Muestra el modal de registro
});

// Llamada a la función de inicialización
init();
