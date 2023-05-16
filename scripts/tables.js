$(document).ready(function () {
    $("#table").dataTable( {
        "columns": [
            { "width": "10%" },
            { "width": "25%" },
            { "width": "20%" },
            { "width": "20%" },
            { "width": "20%" },
        ],
        "order": [[ 0, "asc" ]],
        "language": {
            "lengthMenu": "Zobraziť _MENU_ riadkov",
            "zeroRecords": "Žiadne dáta",
            "info": "Strana _PAGE_ z _PAGES_",
            "infoEmpty": "Nie sú k dispozícii žiadne záznamy",
            "infoFiltered": "(filtrované z celkového počtu _MAX_ záznamov)",
            "paginate": {
                "next": "Ďalšia",
                "previous": "Predošlá"
            },
            "search": "Hľadať: "
        }
    });
});




















