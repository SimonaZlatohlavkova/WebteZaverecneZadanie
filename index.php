<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>School Portal</title>
    </head>
    <body>
        <div class="container">
            <h1>Welcome To School Portal</h1>
            <div class="rectangle">
                <p class="rect-heading">Authentication</p>
                <div class="rectangle-content">
                    <form>
                        <label for="username">
                            <input id="email-input" type="email" placeholder="Email">
                        </label>
                        <label class="form-label" for="password">
                            <input id="password-input"  type="password" placeholder="Password">
                        </label>
                        <button id="sign-in-button" type="button"> Sign In</button>
                    </form>

                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
        <script src="scripts/login.js"></script>
    </body>
</html>