var tabla;

function init() {
    // Configuración para guardar o editar
    $("#mnt_form").on("submit", function(e) {
        guardaryeditar(e);
    });
}

function guardaryeditar(e) {
    e.preventDefault();
    var formData = new FormData($("#mnt_form")[0]);
    $.ajax({
        url: "../../controller/proceso.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(datos) {
            console.log(datos);
            if (datos == 1) {
                $("#proceso_id").val('');  // Limpiar el campo de ID
                $("#mnt_form")[0].reset();  // Limpiar el formulario
                $("#listado_table").DataTable().ajax.reload();  // Recargar la tabla
                $("#mnt_modal").modal('hide');  // Ocultar el modal
                Swal.fire({
                    title: "TEMPLATE",
                    html: "Proceso registrado con éxito.",
                    icon: "success",
                    confirmButtonColor: "#5156be",
                });
            } else if (datos == 0) {
                Swal.fire({
                    title: "TEMPLATE",
                    html: "El proceso ya existe, por favor verificar.",
                    icon: "error",
                    confirmButtonColor: "#5156be",
                });
            } else if (datos == 2) {
                $("#proceso_id").val('');
                $("#mnt_form")[0].reset();
                $("#listado_table").DataTable().ajax.reload();
                $("#mnt_modal").modal('hide');
                Swal.fire({
                    title: "TEMPLATE",
                    html: "Proceso actualizado con éxito.",
                    icon: "success",
                    confirmButtonColor: "#5156be",
                });
            }
        }
    });
}

$(document).ready(function() {
    tabla = $("#listado_table").DataTable({
        "aProcessing": true,
        "aServerSide": true,
        dom: 'Bfrtip',
        "searching": true,
        lengthChange: false,
        colReorder: true,
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
        ],
        "ajax": {
            url: '../../controller/proceso.php?op=listar',
            type: "GET",
            dataType: "json",
            error: function(e) {
                console.log(e.responseText);  // Capturar cualquier error de respuesta
            }
        },
        "bDestroy": true,
        "responsive": true,
        "bInfo": true,
        "iDisplayLength": 10,
        "autoWidth": false,
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

// Mostrar el modal para crear un nuevo proceso
$("#btnnuevo").on("click", function() {
    $("#proceso_id").val('');
    $("#mnt_form")[0].reset();
    $("#myModalLabel").html('Nuevo Registro');
    $("#mnt_modal").modal('show');
});

// Función para editar un proceso existente
function editar(proceso_id) {
    $.post("../../controller/proceso.php?op=mostrar", { proceso_id: proceso_id }, function(data) {
        data = JSON.parse(data);
        $("#proceso_id").val(data.proceso_id);
        $("#nombre").val(data.nombre);  // Nombre del proceso
        $("#descripcion").val(data.descripcion);  // Descripción del proceso
        $("#fecha_inicio").val(data.fecha_inicio);  // Fecha de creación
        $("#myModalLabel").html('Editar Registro');
        $("#mnt_modal").modal('show');
    });
}

// Función para eliminar un proceso
function eliminar(proceso_id) {
    Swal.fire({
        title: "¿Está seguro de eliminar el proceso?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "No"
    }).then((result) => {
        if (result.isConfirmed) {
            $.post("../../controller/proceso.php?op=eliminar", { proceso_id: proceso_id }, function(data) {
                $("#listado_table").DataTable().ajax.reload();
                Swal.fire("Eliminado", "El proceso ha sido eliminado con éxito.", "success");
            });
        }
    });
}

init();  // Inicializar el script
