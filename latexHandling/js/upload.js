const uploadButton = document.getElementById('upload-button');
uploadButton.addEventListener('click', () => {

    const fileInput = document.getElementById('file-input').files[0];

    if (!fileInput) {
        console.log('No file selected');
        return;
    }
    
    
    const formData = new FormData();
    formData.append('latexFile', fileInput);

    axios.post('php/upload.php', formData)
        .then((response) => {
            console.log(response.data);
        })
        .catch((error) => console.log(error));
});