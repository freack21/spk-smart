// $(document).ready(function () {
//     // Menghancurkan DataTable yang sudah ada (jika ada)
//     $(".dataTable").each(function () {
//         if ($.fn.DataTable.isDataTable(this)) {
//             $(this).DataTable().destroy();
//         }
//     });

//     // Inisialisasi DataTable baru
//     $(".dataTable").dataTable({
//         paging: true,
//         searching: false,
//         ordering: true,
//         info: false,
//         lengthChange: true,
//         columnDefs: [
//             {
//                 targets: 0,
//                 orderable: false,
//                 className: "centerAligned",
//                 render: function (data, type, row, meta) {
//                     return meta.row + 1;
//                 },
//             },
//         ],
//         order: [[0, "asc"]],
//     });

//     // // Inisialisasi DataTable baru
//     // $(".dataTable").DataTable({
//     //     jQueryUI: true,
//     //     bPaginate: true,
//     //     bSearch: false,
//     //     bFilter: false,
//     //     bInfo: false,
//     //     sPaginationType: "input",
//     //     bLengthChange: true,
//     //     order: [[0, "asc"]],
//     //     columns: [
//     //         {
//     //             data: null,
//     //             render: function (data, type, row, meta) {
//     //                 return meta.row + 1;
//     //             },
//     //             orderable: false,
//     //             searchable: false,
//     //         },
//     //         // Tambahkan kolom-kolom lainnya sesuai kebutuhan
//     //     ],
//     // });
// });

// $(document).ready(function () {
//     const oTable = $(".dataTable").dataTable({
//         columnDefs: [
//             {
//                 targets: 0,
//                 orderable: false,
//             },
//         ],
//         order: [[0, "asc"]], // Ganti 1 dengan indeks kolom yang ingin diurutkan secara default
//     });

//     $.fn.dataTable.ColReorder(oTable);
// });
