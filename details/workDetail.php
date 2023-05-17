<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION["login"]) || !$_SESSION["login"]) {
    header("Location: ../index.php");
    exit();
}

if (isset($_SESSION["role"]) && $_SESSION["role"] == "student") {
    header("Location: studentMenu.php");
    exit();
}

$language = $_SESSION['lang'] ?? 'SK';
require_once "config.php";

$id = $_GET['id'];


try {
    $db = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo $e->getMessage();
}


$sql = "SELECT email FROM users WHERE id = :id";

// Prepare the statement and bind the ID parameter
$stmt = $db->prepare($sql);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);

// Execute the statement
$stmt->execute();

// Fetch the email from the result
$email = $stmt->fetchColumn();


$sql = "SELECT first_name FROM users WHERE id = :id";
$stmt = $db->prepare($sql);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);

// Execute the statement
$stmt->execute();
$name = $stmt->fetchColumn();

$sql = "SELECT last_name FROM users WHERE id = :id";
$stmt = $db->prepare($sql);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);

// Execute the statement
$stmt->execute();
$lastName = $stmt->fetchColumn();

$sql = "SELECT * FROM studentQuestions WHERE student_mail = :email";

// Prepare the statement and bind the email parameter
$stmt = $db->prepare($sql);
$stmt->bindParam(':email', $email, PDO::PARAM_STR);

// Execute the statement
$stmt->execute();

// Fetch all rows from the result
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Prehľad študentov</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="../css/styles.css" type="text/css" rel="stylesheet">
    <link href="../css/menu.css" rel="stylesheet"/>
    <link href="../menu/teacherMenu.css" rel="stylesheet"/>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
            integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
            crossorigin="anonymous"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/98d99917c7.js" crossorigin="anonymous"></script>
    <link href="studentsDetailStyle.css" rel="stylesheet"/>



    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.13.3/css/jquery.dataTables.min.css">
    <script rel="script" type="text/javascript" src="//cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"></script>

</head>
<body>


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
                <a href="../informations/informations.php" class="nav-link"><span class="nav-link-span active"><span
                                class="u-nav">User guide</span></span></a>
                <a href="../details/studentDetail.php" class="nav-link"><span class="nav-link-span active"><span
                                class="u-nav">Students</span></span></a>
                <a href="../latexHandling/latexIndex.php" class="nav-link"><span class="nav-link-span active"><span
                                class="u-nav">Assignments</span></span></a>
                <a href="../controllers/logout-controller.php" class="nav-link"><span class="nav-link-span active"><span
                                class="u-nav">Log out</span></span></a>
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
                <a href="../informations/informations.php">User giude</a><br>
            </nav>
            <nav id="navSmallHref">
                <a href="../details/studentDetail.php">Students</a><br>
            </nav>

            <nav id="navSmallHref">
                <a href="../latexHandling/latexIndex.php">Assignments</a><br>
            </nav>
            <nav id="navSmallHref">
                <a href="../controllers/logout-controller.php">Log out</a><br>
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
        <div class="tableDiv">
            <div class="table-responsive">
                <h3><b>Assignments- <?= $name." ". $lastName ?>  </b></h3>
                <table id="tableEN" class="table table-striped table-bordered table-hover table-sm">
                    <thead>
                    <tr style="background-color: #57b0f8; color:white; font-weight: bolder">
                        <th>Assignment</th>
                        <th>Correct answer</th>
                        <th>Students answer</th>
                        <th>Correct</th>
                        <th>Achieved points</th>
                        <th>Max points</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($rows as $row) {
                        $questionName = isset($row['question_name']) ? $row['question_name'] : '';
                        $solution = isset($row['solution']) ? $row['solution'] : '-';
                        $answer = isset($row['answer']) ? $row['answer'] : '-';
                        $correct = '';
                        if ($row['correct'] === null) {
                            $correct = '-';
                        } elseif ($row['correct'] == 0) {
                            $correct = '<i class="fa-solid fa-xmark" style="color: #c70d00; font-size: large"></i>';
                        } elseif ($row['correct'] == 1) {
                            $correct = '<i class="fa-solid fa-check" style="color: #129900; font-size: large"></i>';
                        }
                        $points = isset($row['points']) ? $row['points'] : '';
                        $maxPoints = isset($row['maxPoints']) ? $row['maxPoints'] : '';
                        ?>
                        <tr>
                            <td><?= $questionName ?></td>
                            <td><?= $solution ?></td>
                            <td><?= $answer ?></td>
                            <td style=" text-align: center;
  vertical-align: middle;"><?= $correct ?></td>
                            <td style=" text-align: center;
  vertical-align: middle;"><?= $points ?></td>
                            <td style=" text-align: center;
  vertical-align: middle;"><?= $maxPoints ?></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('#tableEN').DataTable({
                language: {
                    "sProcessing": "Processing...",
                    "sLengthMenu": "Show _MENU_ entries",
                    "sZeroRecords": "No matching records found",
                    "sInfo": "Showing _START_ to _END_ of _TOTAL_ entries",
                    "sInfoEmpty": "Showing 0 to 0 of 0 entries",
                    "sInfoFiltered": "(filtered from _MAX_ total entries)",
                    "sInfoPostFix": "",
                    "sSearch": "Search:",
                    "sUrl": "",
                    "oPaginate": {
                        "sFirst": "First",
                        "sPrevious": "Previous",
                        "sNext": "Next",
                        "sLast": "Last"
                    }
                },
                // Add more DataTable options as needed
            });
        });


    </script>

<?php } ?>

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
            <a href="../informations/informations.php" class="nav-link"><span class="nav-link-span active"><span
                            class="u-nav">Návod</span></span></a>
            <a href="../details/studentDetail.php" class="nav-link"><span class="nav-link-span active"><span
                            class="u-nav">Prehľad študentov</span></span></a>
            <a href="../latexHandling/latexIndex.php" class="nav-link"><span class="nav-link-span active"><span
                            class="u-nav">Príklady</span></span></a>
            <a href="../controllers/logout-controller.php" class="nav-link"><span class="nav-link-span active"><span
                            class="u-nav">Odhlásenie</span></span></a>
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
            <a href="../informations/informations.php">Návod</a><br>
        </nav>
        <nav id="navSmallHref">
            <a href="../details/studentDetail.php">Prehľad študentov</a><br>
        </nav>

        <nav id="navSmallHref">
            <a href="../latexHandling/latexIndex.php">Príklady</a><br>
        </nav>
        <nav id="navSmallHref">
            <a href="../controllers/logout-controller.php">Odhlásenie</a><br>
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
    <div class="tableDiv">
        <div class="table-responsive">
            <h3><b>Prehľad úloh - <?= $name." ". $lastName ?>  </b></h3>
            <table id="tableSK" class="table table-striped table-bordered table-hover table-sm">
                <thead>
                <tr style="background-color: #57b0f8; color:white; font-weight: bolder">
                    <th>Úloha</th>
                    <th>Správna odpoveď</th>
                    <th>Študentova odpoveď</th>
                    <th>Správnosť</th>
                    <th>Počet získaných bodov</th>
                    <th>Maximálny počet bodov</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($rows as $row) {
                    $questionName = isset($row['question_name']) ? $row['question_name'] : '';
                    $solution = isset($row['solution']) ? $row['solution'] : '-';
                    $answer = isset($row['answer']) ? $row['answer'] : '-';
                    $correct = '';
                    if ($row['correct'] === null) {
                        $correct = '-';
                    } elseif ($row['correct'] == 0) {
                        $correct = '<i class="fa-solid fa-xmark" style="color: #c70d00; font-size: large"></i>';
                    } elseif ($row['correct'] == 1) {
                        $correct = '<i class="fa-solid fa-check" style="color: #129900; font-size: large"></i>';
                    }
                    $points = isset($row['points']) ? $row['points'] : '';
                    $maxPoints = isset($row['maxPoints']) ? $row['maxPoints'] : '';
                    ?>
                    <tr>
                        <td><?= $questionName ?></td>
                        <td><?= $solution ?></td>
                        <td><?= $answer ?></td>
                        <td style=" text-align: center;
  vertical-align: middle;"><?= $correct ?></td>
                        <td style=" text-align: center;
  vertical-align: middle;"><?= $points ?></td>
                        <td style=" text-align: center;
  vertical-align: middle;"><?= $maxPoints ?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#tableSK').DataTable({
            language: {
                "sProcessing": "Spracúva sa...",
                "sLengthMenu": "Zobraziť _MENU_ záznamov",
                "sZeroRecords": "Nenašli sa žiadne záznamy",
                "sInfo": "Zobrazuje sa _START_ až _END_ z celkom _TOTAL_ záznamov",
                "sInfoEmpty": "Zobrazuje sa 0 až 0 z 0 záznamov",
                "sInfoFiltered": "(filtrované zo všetkých _MAX_ záznamov)",
                "sInfoPostFix": "",
                "sSearch": "Hľadať:",
                "sUrl": "",
                "oPaginate": {
                    "sFirst": "Prvá",
                    "sPrevious": "Predchádzajúca",
                    "sNext": "Ďalšia",
                    "sLast": "Posledná"
                }
            },
            // Add more DataTable options as needed
        });
    });
</script>

<?php } ?>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"
        integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js"
        integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ"
        crossorigin="anonymous"></script>
<script src="../scripts/tables.js"></script>
</body>
</html>
