
const downloadButtonSK = document.getElementById("download-csv-sk");
if (downloadButtonSK != null) {
    downloadButtonSK.addEventListener("click", function () {
        exportTableToCSV("tableSK", "Prehľad študentov.csv");
    });

}

const downloadButtonEN = document.getElementById("download-csv-en");
if (downloadButtonEN != null) {
    downloadButtonEN.addEventListener("click", function () {
        exportTableToCSV("tableEN", "Students.csv");
    });
}

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
    const csvContent = '\uFEFF' + csv.join('\n');
    const csvFile = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });

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





















