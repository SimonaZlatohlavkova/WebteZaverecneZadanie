<?php
session_start();

if (isset($_SESSION['login']) && $_SESSION['login']) {
    header("location: index.php");
    exit;
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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
        if (!preg_match("/^[a-zA-ZÁáÄäČčĎďÉéÍíĹĺĽľŇňÓóÔôÖöŔŕŘřŠšŤťÚúÝýŽž]{2,30}$/",$name)) {
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
        if (!preg_match("/^[a-zA-ZÁáÄäČčĎďÉéÍíĹĺĽľŇňÓóÔôÖöŔŕŘřŠšŤťÚúÝýŽž ]{2,30}$/",$surname)) {
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
        if (!preg_match("/^[a-zA-ZÁáÄäČčĎďÉéÍíĹĺĽľŇňÓóÔôÖöŔŕŘřŠšŤťÚúÝýŽž\d]{8,64}$/u",$passwordForm)) {
            $passwordErr = "Heslo musí obsahovať aspoň 8 znakov";
            $form_valid = false;
        }
    }

    if (empty($_POST["usernameForm"])) {
        $usernameErr= "Používateľské meno je povinné";
        $form_valid = false;
    } else {
        $usernameForm = test_input($_POST["usernameForm"]);
        if (!preg_match("/^[a-zA-ZÁáÄäČčĎďÉéÍíĹĺĽľŇňÓóÔôÖöŔŕŘřŠšŤťÚúÝýŽž\d]{6,20}$/u",$usernameForm)) {
            $usernameErr = "Používateľské meno musí obsahovať aspoň 6 znakov";
            $form_valid = false;
        }
    }

    // Check if the "Ste učiteľ?" checkbox is selected
    $isTeacher = isset($_POST["teacher"]);

    // Set the role based on the checkbox selection
    $role = $isTeacher ? "teacher" : "student";

    if($form_valid === true){

        try{
            $db = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch(PDOException $e){
            ECHO $e->getMessage();
        }

        $query = "SELECT * from users";
        $stmt = $db->query($query);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($results as $result) {
            if ($result['email'] === $email) {
                $loginErr = "Požívateľ s týmto e-mailom už existuje!";
                $form_valid= false;
            }
            if ($result['username'] === $usernameForm) {
                $loginErr = "Požívateľ s týmto užívateľským menom už existuje!";
                $form_valid= false;
            }
        }
        if($form_valid === true){

            $hashed_password = password_hash($passwordForm, PASSWORD_BCRYPT);
            $sql = "INSERT INTO users (first_name, last_name, username, email, password, role) VALUES (?,?,?,?,?,?)";
            $statement = $db->prepare($sql);
            $statement->execute([$name, $surname, $usernameForm, $email, $hashed_password, $role]);
            $success = "Registrácia bola úspešná.";
        }
    }
}

function test_input($data) {
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="index.php">Zoznam olympionikov</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="bestAthletes.php">TOP 10</a>
                </li>
            </ul>
            <?php if ((isset($_SESSION['login'])) || isset($_SESSION['access_token'])) { ?>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item disabled">
                        <a class="nav-link"> Prihlásený ako: <?php
                            if(isset($_SESSION['name'])) {
                                echo $_SESSION['name'];
                            }
                            ?></a>
                    </li>
                </ul>
            <?php }
            else { ?>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="registration.php">Registrácia</a>
                    </li>

                </ul>
            <?php } ?>
        </div>
    </div>
</nav>


<body>
<h2>Registračný formulár</h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <label for="name">Meno:</label>
    <input type="text" id="name" name="name" value="<?php echo $name;?>">
    <span class="error_msg"><?php echo $nameErr;?></span>
    <br>

    <label for="surname">Priezvisko:</label>
    <input type="text" id="surname" name="surname" value="<?php echo $surname;?>">
    <span class="error_msg"><?php echo $surnameErr;?></span>
    <br>

    <label for="usernameForm">Používateľské meno:</label>
    <input type="text" id="usernameForm" name="usernameForm" value="<?php echo $usernameForm;?>">
    <span class="error_msg"><?php echo $usernameErr;?></span>
    <br>

    <label for="email">Email:</label>
    <input type="text" id="email" name="email" value="<?php echo $email;?>">
    <span class="error_msg"><?php echo $emailErr;?></span>
    <br>


    <label for="password">Heslo:</label>
    <input type="password" id="password" name="password">
    <span class="error_msg"><?php echo $passwordErr;?></span>
    <label class="show-password-label" for="password-show">
        <input type="checkbox" id="password-show" onclick="togglePassword()"> Zobraziť heslo
    </label>
    <br>

    <label for="teacher">Ste učiteľ?</label>
    <input type="checkbox" id="teacher" name="teacher">
    <br>



    <button class="btn btn-success" type="submit" value="Submit">Registrovať</button>

    <span class="success">
        <?php echo $success;?>
    </span>

</form>
<script>
    function togglePassword() {
        let passwordInput = document.getElementById("password");
        let showPasswordCheckbox = document.getElementById("password-show");
        if (showPasswordCheckbox.checked) {
            passwordInput.type = "text";
        } else {
            passwordInput.type = "password";
        }
    }
</script>
</body>
</html>
