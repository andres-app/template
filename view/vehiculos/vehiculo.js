// Variable global para la tabla del DataTable
var tabla;

// Función de inicialización
function init() {
    // Configuración del evento submit para el formulario de creación o edición
    $("#mnt_form").on("submit", function(e) {
        guardaryeditar(e); // Llamar a la función para guardar o editar un registro
    });
}

// Configuración del DataTable cuando el documento esté listo
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
            url: '../../controller/vehiculo.php?op=listar', // URL del controlador PHP para listar los vehículos
            type: "GET",         // Método de la petición
            dataType: "json",     // Tipo de datos esperados
            error: function(e) {  // Manejo de errores
                console.log(e.responseText); // Imprime el error en la consola
            }
        },
        "bDestroy": true,        // Permite destruir el DataTable y volver a inicializarlo
        "responsive": true,      // Hace que la tabla sea responsiva
        "bInfo": true,           // Muestra información sobre el DataTable (cantidad de registros, etc.)
        "iDisplayLength": 10,    // Define el número de registros a mostrar por página
        "autoWidth": false,      // Desactiva el ajuste automático del ancho de las columnas

        // Configuraciones de idioma para traducir los textos a español
        "language": {
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningún dato disponible en esta tabla",
            "sInfo": "Mostrando un total de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando un total de 0 registros",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix": "",
            "sSearch": "Buscar:",
            "sUrl": "",
            "sInfoThousands": ",",
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

// Evento para mostrar el modal al crear un nuevo registro
$("#btnnuevo").on("click", function() {
    $("#vehiculo_id").val('');   // Limpia el campo de ID de vehículo
    $("#mnt_form")[0].reset();   // Resetea el formulario
    $("#myModalLabel").html('Nuevo Registro'); // Cambia el título del modal
    $("#mnt_modal").modal('show'); // Muestra el modal de registro
});

// Llamada a la función de inicialización
init();
