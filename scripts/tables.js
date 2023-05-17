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



const downloadButton = document.getElementById("download-csv");
downloadButton.addEventListener("click", function () {
   exportTableToCSV("table", "table.csv");
});

function exportTableToCSV(tableId, filename) {
    let csv = [];
    const rows = document.querySelectorAll('#' + tableId + ' tr');

    for (let i = 0; i < rows.length; i++) {
        const row = [], cols = rows[i].querySelectorAll('td, th');

        for (let j = 0; j < cols.length; j++)
            row.push(cols[j].innerText);

        csv.push(row.join(','));
    }

    // Download CSV file
    const csvFile = new Blob([csv.join('\n')], { type: 'text/csv' });

    if (window.navigator.msSaveOrOpenBlob) {
        window.navigator.msSaveOrOpenBlob(csvFile, filename);
    }
    else {
        const downloadLink = document.createElement('a');
        downloadLink.href = window.URL.createObjectURL(csvFile);
        downloadLink.download = filename;
        document.body.appendChild(downloadLink);
        downloadLink.click();
        document.body.removeChild(downloadLink);
    }
}





















