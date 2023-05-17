const uploadButton = document.getElementById('upload-button');
uploadButton.addEventListener('click', () => {

    const fileInput = document.getElementById('file-input').files[0];
    const pointsFile = document.getElementById('pointsFile').value;
    const dateFromFile = document.getElementById('dateFromFile').value;
    const dateToFile = document.getElementById('dateToFile').value;
    var valid=false;
    if (!fileInput) {
        document.getElementById('file-input').style.borderColor = "red";
        console.log('No file selected');
        valid=false;

    } else {
        document.getElementById('file-input').style.borderColor = "inherit";
        valid=true;
    }
    console.log(pointsFile)
    if (!pointsFile || pointsFile==="") {
        document.getElementById('pointsFile').style.borderColor = "red";
        console.log('No points selected');
        valid=false;

    } else {
        var pattern = /^\d*\.?\d+$|^\d+$/;

        if (pattern.test(pointsFile)) {
            console.log("Value matches the pattern.");
            document.getElementById('pointsFile').style.borderColor = "inherit";
            valid=true;
        } else {
            document.getElementById('pointsFile').style.borderColor = "red";
            console.log("Value does not match the pattern.");
            valid=false;
        }

    }
    if (valid===true) {
        const formData = new FormData();
        formData.append('latexFile', fileInput);
        formData.append('points', pointsFile);
        formData.append('dateFrom', dateFromFile);
        formData.append('dateTo', dateToFile);

        axios.post('php/upload.php', formData)
            .then((response) => {
                console.log(response.data);
            })
            .catch((error) => console.log(error));
    }
});

const uploadImageButton = document.getElementById('upload-image-button');
uploadImageButton.addEventListener('click', () => {

    const imageInput = document.getElementById('image-input').files[0];

    if (!imageInput) {
        console.log('No image selected');
        return;
    }

    const formData = new FormData();
    formData.append('image', imageInput);

    axios.post('php/upload.php', formData)
        .then((response) => {
            console.log(response.data);
        })
        .catch((error) => console.log(error));
});