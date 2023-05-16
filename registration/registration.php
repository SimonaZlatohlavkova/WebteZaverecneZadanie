<?php
session_start();

if (isset($_SESSION['login']) && $_SESSION['login']) {
    header("location: ../index.php");
    exit;
}
if ($_SESSION["role"] == "student") {
    header("Location: studentMenu.php");
    exit();
}
if ($_SESSION["role"] == "teacher") {
    header("Location: teacherMenu.php");
    exit();
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$language = $_SESSION['lang'] ?? 'SK';
require_once "config.php";

$nameErr = $emailErr = $passwordErr = $surnameErr = $loginErr = $usernameForm = "";
$name = $email = $passwordForm = $surname = $login = $success = $usernameErr = "";
$errors = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $form_valid = true;

    if (empty($_POST["name"])) {
        $nameErr = "Meno musí byť vyplnené";
        $form_valid = false;
    } else {
        $name = test_input($_POST["name"]);
        // check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-ZÁáÄäČčĎďÉéÍíĹĺĽľŇňÓóÔôÖöŔŕŘřŠšŤťÚúÝýŽž]{2,30}$/", $name)) {
            $nameErr = "Meno môže obsahovať iba písmená";
            $form_valid = false;
        }
    }

    if (empty($_POST["surname"])) {
        $surnameErr = "Priezvisko musí byť vyplnené";
        $form_valid = false;
    } else {
        $surname = test_input($_POST["surname"]);
        // check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-ZÁáÄäČčĎďÉéÍíĹĺĽľŇňÓóÔôÖöŔŕŘřŠšŤťÚúÝýŽž ]{2,30}$/", $surname)) {
            $surnameErr = "Priezvisko môže obsahovať iba písmená";
            $form_valid = false;
        }
    }

    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
        $form_valid = false;
    } else {
        $email = test_input($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Nesprávny tvar emailu";
            $form_valid = false;
        }
    }


    if (empty($_POST["password"])) {
        $passwordErr = "Heslo je povinné";
        $form_valid = false;
    } else {
        $passwordForm = test_input($_POST["password"]);
        if (!preg_match("/^[a-zA-ZÁáÄäČčĎďÉéÍíĹĺĽľŇňÓóÔôÖöŔŕŘřŠšŤťÚúÝýŽž\d]{8,64}$/u", $passwordForm)) {
            $passwordErr = "Heslo musí obsahovať aspoň 8 znakov";
            $form_valid = false;
        }
    }

    if (empty($_POST["usernameForm"])) {
        $usernameErr = "Používateľské meno je povinné";
        $form_valid = false;
    } else {
        $usernameForm = test_input($_POST["usernameForm"]);
        if (!preg_match("/^[a-zA-ZÁáÄäČčĎďÉéÍíĹĺĽľŇňÓóÔôÖöŔŕŘřŠšŤťÚúÝýŽž\d]{6,20}$/u", $usernameForm)) {
            $usernameErr = "Používateľské meno musí obsahovať aspoň 6 znakov";
            $form_valid = false;
        }
    }

    // Check if the "Ste učiteľ?" checkbox is selected
    $isTeacher = isset($_POST["teacher"]);

    // Set the role based on the checkbox selection
    $role = $isTeacher ? "teacher" : "student";

    if ($form_valid === true) {

        try {
            $db = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }

        $query = "SELECT * from users";
        $stmt = $db->query($query);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($results as $result) {
            if ($result['email'] === $email) {
                $loginErr = "Požívateľ s týmto e-mailom už existuje!";
                if ($language === "SK") {
                ?>
                <div class="toast show" style="position: absolute; top:1rem; z-index: 100; right:1rem ">
                    <div class="toast-header" style="background: #980019; color: white">
                        <strong class="mr-auto text">POZOR!</strong>
                        <button type="button" class="btn-close" style="color: white;" data-bs-dismiss="toast"></button>
                    </div>
                    <div class="toast-body">
                        <p>Požívateľ s týmto e-mailom už existuje!</p>
                    </div>
                </div>
                <?php
                }
                if ($language === "EN") {
                    ?>
                    <div class="toast show" style="position: absolute; top:1rem; z-index: 100; right:1rem ">
                        <div class="toast-header" style="background: #980019; color: white">
                            <strong class="mr-auto text">ATTENTION!</strong>
                            <button type="button" class="btn-close" style="color: white;" data-bs-dismiss="toast"></button>
                        </div>
                        <div class="toast-body">
                            <p>User with this e-mail already exists!</p>
                        </div>
                    </div>
                    <?php


                }
                $form_valid = false;
            }
            if ($result['username'] === $usernameForm) {

                $loginErr = "Požívateľ s týmto užívateľským menom už existuje!";
                if ($language === "SK") {
                ?>
                <div class="toast show" style="position: absolute; top:1rem; z-index: 100; right:1rem ">
                    <div class="toast-header" style="background: #980019; color: white">
                        <strong class="mr-auto text">POZOR!</strong>
                        <button type="button" class="btn-close" style="color: white;" data-bs-dismiss="toast"></button>
                    </div>
                    <div class="toast-body">
                        <p>Požívateľ s týmto užívateľským menom už existuje!</p>
                    </div>
                </div>
                <?php }
                if ($language === "EN") {
                    ?>
                    <div class="toast show" style="position: absolute; top:1rem; z-index: 100; right:1rem ">
                        <div class="toast-header" style="background: #980019; color: white">
                            <strong class="mr-auto text">ATTENTION!</strong>
                            <button type="button" class="btn-close" style="color: white;" data-bs-dismiss="toast"></button>
                        </div>
                        <div class="toast-body">
                            <p>User with this username already exists!</p>
                        </div>
                    </div>
                <?php }
                $form_valid = false;
            }
        }
        if ($form_valid === true) {

            $hashed_password = password_hash($passwordForm, PASSWORD_BCRYPT);
            $sql = "INSERT INTO users (first_name, last_name, username, email, password, role) VALUES (?,?,?,?,?,?)";
            $statement = $db->prepare($sql);
            $statement->execute([$name, $surname, $usernameForm, $email, $hashed_password, $role]);
            $success = "true";
            $nameErr = $emailErr = $passwordErr = $surnameErr = $loginErr = $usernameForm = "";
            $name = $email = $passwordForm = $surname = $login = $success = $usernameErr = "";
            if ($language === "SK") {
            ?>
            <div class="toast show" style="position: absolute; top:1rem; z-index: 100; right:1rem ">
                <div class="toast-header" style="background: #00ab08; color: white">
                    <strong class="mr-auto text">Registrácia</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
                </div>
                <div class="toast-body">
                    <p>Registrácia prebehla úspešne!</p>
                </div>
            </div>
            <?php
            }

            if ($language === "EN") {
                ?>
                <div class="toast show" style="position: absolute; top:1rem; z-index: 100; right:1rem ">
                    <div class="toast-header" style="background: #00ab08; color: white">
                        <strong class="mr-auto text">Registration</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
                    </div>
                    <div class="toast-body">
                        <p>Your Account was created!</p>
                    </div>
                </div>
                <?php
            }
        }
    }
}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>

<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registrácia</title>
    <!--    <link href="../css/styles.css" rel="stylesheet"/>-->
    <link href="../css/menu.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/98d99917c7.js" crossorigin="anonymous"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
            crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/98d99917c7.js" crossorigin="anonymous"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="registration.css" rel="stylesheet"/>
</head>

<body>
<?php

if ($language === "SK") {
    ?>

<header id="nav-wrapper">
    <nav id="nav">
        <div class="nav left">
            <span class="gradient skew"><h1 class="logo un-skew"><a id="logoID">Školský portál  </a></h1></span>
            <button id="menu" class="btn-nav"><span class="fas fa-bars"></span></button>
        </div>
        <div class="nav right">
            <a href="../index.php" class="nav-link"><span class="nav-link-span active"><span
                            class="u-nav">Prihlásenie</span></span></a>
            <!--            <a href="registration/registration.php" class="nav-link"><span class="nav-link-span active"><span class="u-nav">Registrácia</span></span></a>-->
        </div>
    </nav>
</header>

<input id="toggle" type="checkbox">

<label for="toggle" class="hamburger">
    <div class="top-bun"></div>
    <div class="meat"></div>
    <div class="bottom-bun"></div>
</label>

<div class="navSmall">
    <div class="navSmall-wrapperSmall">
        <nav id="navSmallHref">
            <a href="../index.php">Prihlásenie</a><br>
        </nav>
    </div>
</div>

<div class="languageDiv">
    <form method="post" action="../web/language.php">
        <div class="languageDiv">
            <button type="submit" class="ButtonLanguageDiv" name="buttonSK"><img alt="SK"
                                                                                 src="https://www.countryflagicons.com/FLAT/24/SK.png">
            </button>
            <button type="submit" class="ButtonLanguageDiv" name="buttonEN"><img alt="EN"
                                                                                 src="https://www.countryflagicons.com/FLAT/24/GB.png">
            </button>
        </div>
    </form
</div>
<div class="wholePage">

    <div class="card" style=" box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
        <div class="card-body">
            <h5 class="card-title">Registračný formulár</h5>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="form-group">
                    <label for="name">Meno:</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo $name; ?>">
                    <span class="error_msg" style="color: red;"><?php echo $nameErr; ?></span>
                </div>

                <div class="form-group">
                    <label for="surname">Priezvisko:</label>
                    <input type="text" class="form-control" id="surname" name="surname" value="<?php echo $surname; ?>">
                    <span class="error_msg" style="color: red;"><?php echo $surnameErr; ?></span>
                </div>
                <div class="form-group">
                    <label for="usernameForm">Používateľské meno:</label>
                    <input type="text" class="form-control" id="usernameForm" name="usernameForm"
                           value="<?php echo $usernameForm; ?>">
                    <span class="error_msg" style="color: red;"><?php echo $usernameErr; ?></span>
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="text" class="form-control" id="email" name="email" value="<?php echo $email; ?>">
                    <span class="error_msg" style="color: red;"><?php echo $emailErr; ?></span>
                </div>

                <div class="form-group">
                    <label for="password">Heslo:</label>
                    <input type="password" class="form-control" id="password" name="password">
                    <span class="error_msg" style="color: red;"><?php echo $passwordErr; ?></span>
                </div>
                <div class="form-group">
                    <input type="checkbox" class="form-check-input" id="teacher" name="teacher">
                    <label for="teacher">Ste učiteľ?</label>
                </div>
                <br>
                <button class="btn btn-outline-secondary" style="width: 100%;" type="button" id="showPasswordBtn">
                    <i class="fas fa-eye" aria-hidden="true"></i></button>

                <button class="btn btn-primary" style="margin-top: 1rem; width: 100%;" type="submit" value="Submit">Registrovať
                </button>

            </form>

        </div>
    </div>
</div>

<?php } ?>



<?php

if ($language === "EN") {
    ?>

    <header id="nav-wrapper">
        <nav id="nav">
            <div class="nav left">
                <span class="gradient skew"><h1 class="logo un-skew"><a id="logoID">School portal </a></h1></span>
                <button id="menu" class="btn-nav"><span class="fas fa-bars"></span></button>
            </div>
            <div class="nav right">
                <a href="../index.php" class="nav-link"><span class="nav-link-span active"><span
                                class="u-nav">Sign in</span></span></a>
                <!--            <a href="registration/registration.php" class="nav-link"><span class="nav-link-span active"><span class="u-nav">Registrácia</span></span></a>-->
            </div>
        </nav>
    </header>

    <input id="toggle" type="checkbox">

    <label for="toggle" class="hamburger">
        <div class="top-bun"></div>
        <div class="meat"></div>
        <div class="bottom-bun"></div>
    </label>

    <div class="navSmall">
        <div class="navSmall-wrapperSmall">
            <nav id="navSmallHref">
                <a href="../index.php">Sign in</a><br>
            </nav>
        </div>
    </div>

    <div class="languageDiv">
        <form method="post" action="../web/language.php">
            <div class="languageDiv">
                <button type="submit" class="ButtonLanguageDiv" name="buttonSK"><img alt="SK"
                                                                                     src="https://www.countryflagicons.com/FLAT/24/SK.png">
                </button>
                <button type="submit" class="ButtonLanguageDiv" name="buttonEN"><img alt="EN"
                                                                                     src="https://www.countryflagicons.com/FLAT/24/GB.png">
                </button>
            </div>
        </form
    </div>
    <div class="wholePage">

        <div class="card" style=" box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
            <div class="card-body">
                <h5 class="card-title">Registration</h5>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?php echo $name; ?>">
                        <span class="error_msg" style="color: red;"><?php echo $nameErr; ?></span>
                    </div>

                    <div class="form-group">
                        <label for="surname">Surname:</label>
                        <input type="text" class="form-control" id="surname" name="surname" value="<?php echo $surname; ?>">
                        <span class="error_msg" style="color: red;"><?php echo $surnameErr; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="usernameForm">Username:</label>
                        <input type="text" class="form-control" id="usernameForm" name="usernameForm"
                               value="<?php echo $usernameForm; ?>">
                        <span class="error_msg" style="color: red;"><?php echo $usernameErr; ?></span>
                    </div>

                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="text" class="form-control" id="email" name="email" value="<?php echo $email; ?>">
                        <span class="error_msg" style="color: red;"><?php echo $emailErr; ?></span>
                    </div>

                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" class="form-control" id="password" name="password">
                        <span class="error_msg" style="color: red;"><?php echo $passwordErr; ?></span>
                    </div>
                    <div class="form-group">
                        <input type="checkbox" class="form-check-input" id="teacher" name="teacher">
                        <label for="teacher">Are you a teacher?</label>
                    </div>
                    <br>
                    <button class="btn btn-outline-secondary" style="width: 100%;" type="button" id="showPasswordBtn">
                        <i class="fas fa-eye" aria-hidden="true"></i></button>

                    <button class="btn btn-primary" style="margin-top: 1rem; width: 100%;" type="submit" value="Submit">Create account
                    </button>

                </form>

            </div>
        </div>
    </div>

<?php } ?>


<script>


    const passwordInput = document.getElementById('password');
    passwordInput.addEventListener("keydown", function (event) {
        if (event.keyCode === 13) {
            send();
        }
    });

    const showPasswordBtn = document.getElementById('showPasswordBtn');
    showPasswordBtn.addEventListener('click', function () {
        if (passwordInput.type === 'password') {
            console.log("pass")
            passwordInput.type = 'text';
            showPasswordBtn.innerHTML = '<i class="fa fa-eye-slash" aria-hidden="true"></i>';
        } else {
            console.log("text")
            passwordInput.type = 'password';
            showPasswordBtn.innerHTML = '<i class="fa fa-eye" aria-hidden="true"></i>';
        }
    })
</script>


<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"
        integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js"
        integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ"
        crossorigin="anonymous"></script>
</body>
</html>
