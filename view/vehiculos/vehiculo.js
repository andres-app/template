var tabla;

function init(){
        // Configuración para guardar o editar
    $("#mnt_form").on("submit",function(e){
        guardaryeditar(e);
    });
}

function guardaryeditar(e){
    e.preventDefault();
    var formData = new FormData($("#mnt_form")[0]);
    $.ajax({
        url:"../../controller/vehiculo.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(datos){
            console.log(datos);
            if(datos == 1){
                $("#vehiculo_id").val('');
                $("#mnt_form")[0].reset();
                $("#listado_table").DataTable().ajax.reload();
                $("#mnt_modal").modal('hide');
                Swal.fire({
                    title: "TEMPLATE",
                    html: "Se registró con éxito.",
                    icon: "success",
                    confirmButtonColor: "#5156be",
                });
            }else if(datos == 0){
                Swal.fire({
                    title: "Vehículo",
                    html: "Registro ya existe, por favor validar.",
                    icon: "error",
                    confirmButtonColor: "#5156be",
                });
            }else if(datos == 2){
                $("#vehiculo_id").val('');
                $("#mnt_form")[0].reset();
                $("#listado_table").DataTable().ajax.reload();
                $("#mnt_modal").modal('hide');
                Swal.fire({
                    title: "Vehículo",
                    html: "Se actualizó con éxito.",
                    icon: "success",
                    confirmButtonColor: "#5156be",
                });
            }
        }
    });
}

$(document).ready(function(){ 
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
        "ajax":{
            url: '../../controller/vehiculo.php?op=listar',
            type : "GET",
            dataType : "json",
            error:function(e){
                console.log(e.responseText);
            }
        },
        "bDestroy": true,
        "responsive": true,
        "bInfo":true,
        "iDisplayLength": 10,
        "autoWidth": false,
        "language": {
            "sProcessing":     "Procesando...",
            "sLengthMenu":     "Mostrar _MENU_ registros",
            "sZeroRecords":    "No se encontraron resultados",
            "sEmptyTable":     "Ningún dato disponible en esta tabla",
            "sInfo":           "Mostrando un total de _TOTAL_ registros",
            "sInfoEmpty":      "Mostrando un total de 0 registros",
            "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix":    "",
            "sSearch":         "Buscar:",
            "sUrl":            "",
            "sInfoThousands":  ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst":    "Primero",
                "sLast":     "Último",
                "sNext":     "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        }
    });
});

// Mostrar el modal para crear un nuevo proceso
$("#btnnuevo").on("click", function() {
    $("#vehiculo_id").val('');
    $("#mnt_form")[0].reset();
    $("#myModalLabel").html('Nuevo Registro');
    $("#mnt_modal").modal('show');
});

function editar(vehiculo_id){
    $("#myModalLabel").html('Editar Registro');
    $.post("../../controller/vehiculo.php?op=mostrar",{vehiculo_id:vehiculo_id},function(data){
        data=JSON.parse(data);
        $("#vehiculo_id").val(data.vehiculo_id);
        $("#vehiculo_placa").val(data.vehiculo_placa);
        $("#vehiculo_marca").val(data.vehiculo_marca);
        $("#vehiculo_modelo").val(data.vehiculo_modelo);
        $("#vehiculo_anio").val(data.vehiculo_anio);
        $("#mnt_modal").modal('show');
    });
}


init();
