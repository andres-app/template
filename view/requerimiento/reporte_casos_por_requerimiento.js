$(document).ready(function() {
    let tabla = $("#reporte_casos_req_table").DataTable({
        aProcessing: true,
        aServerSide: true,
        dom: "Bfrtip",
        buttons: ["copyHtml5", "excelHtml5", "csvHtml5", "pdfHtml5"],
        ajax: {
            url: "../../controller/reporte.php?op=reporte_casos_por_requerimiento",
            type: "GET",
            dataType: "json",
            error: function() {
                Swal.fire("Error", "No se pudo cargar el análisis de casos", "error");
            }
        },
        columns: [
            { 
                data: null,
                render: function (data) {
                    return `${data.codigo_requerimiento} ${data.nombre_requerimiento}`;
                }
            },
            { data: "total_casos" }
        ],
        order: [[1, "desc"]],
        responsive: true,
        iDisplayLength: 25,
        language: {
            url: "//cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json"
        }
    });

    $("#btnRefrescar").on("click", function() {
        tabla.ajax.reload(null, false);
    });
});
