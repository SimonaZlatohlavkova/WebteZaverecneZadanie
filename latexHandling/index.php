<?php


?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>LaTeX file upload</title>
    </head>
    <body>
        <div class="container">
            <h1>Upload LaTeX file here</h1>
            <div class="rectangle">
                <div class="rectangle-content">
                    <form>
                        <label for="file-input">
                            <input id="file-input" type="file" name="latexFile" accept=".tex" multiple="false">
                        </label>
                        <button id="upload-button" type="button"> Upload</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="container">
            <h1>Upload images for the LaTeX file here</h1>
            <div class="rectangle">
                <div class="rectangle-content">
                    <form>
                        <label for="image-input">
                            <input id="image-input" type="file" name="latexImage" multiple="false">
                        </label>
                        <button id="upload-image-button" type="button"> Upload</button>
                    </form>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
        <script src="js/upload.js"></script>
    </body>
</html>