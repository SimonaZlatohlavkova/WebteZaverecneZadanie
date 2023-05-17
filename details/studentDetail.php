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

$id = $_GET['id'];
require_once "config.php";


try {
    $db = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo $e->getMessage();
}


$query = "SELECT u.id, u.first_name, u.last_name,
            COUNT(sq.id) AS generated_questions,
            SUM(CASE WHEN sq.answer IS NOT NULL THEN 1 ELSE 0 END) AS answered_questions,
            SUM(COALESCE(sq.correct, 0)) AS total_points
            FROM users u
            LEFT JOIN studentQuestions sq ON sq.student_name = CONCAT(u.first_name, ' ', u.last_name)
            WHERE u.role = 'student'
            GROUP BY u.id, u.first_name, u.last_name
            ORDER BY u.last_name ASC";

$stmt = $db->query($query);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
//var_dump($results);


$language = $_SESSION['lang'] ?? 'SK';

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
    <link href="studentsDetailStyle.css" rel="stylesheet"/>
    <link href="../menu/teacherMenu.css" rel="stylesheet"/>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
            integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
            crossorigin="anonymous"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/98d99917c7.js" crossorigin="anonymous"></script>


    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.13.3/css/jquery.dataTables.min.css">
    <script rel="script" type="text/javascript" src="//cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"></script>

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
            <h3><b>Prehľad študentov a úloh</b></h3>
            <table id="tableSK" class="table table-striped table-bordered table-hover table-sm">
                <thead>
                <tr style="background-color: #57b0f8; color:white; font-weight: bolder">
                    <th>Id</th>
                    <th>Meno a Priezvisko</th>
                    <th>Počet vygenerovaných úloh</th>
                    <th>Počet odovzdaných úloh</th>
                    <th>Počet získaných bodov</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if (isset($results)) {

                    foreach ($results as $result) {?>
                       <tr>
                                    <td><?= $result["id"] ?></td>
                                    <td><a href="workDetail.php?id=<?= $result['id'] ?>" class="Detail"><?= $result["first_name"] . ' ' . $result["last_name"] ?></td>
                                    <td><?= $result["generated_questions"] ?></td>
                                    <td><?= $result["answered_questions"] ?></td>
                                    <td><?=$result["total_points"] ?></td>

                                </tr>
                        <?php
                    }
                }
                ?>
                </tbody>
            </table>
            </div>
            <button id="download-csv" type="button" class="btn btn-primary">Stiahnuť CSV</button>
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
                <a href="../informations/informations.php">User guide</a><br>
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
            <h3><b>Students and assignmets</b></h3>
            <div class="table-responsive">
            <table id="tableEN" class="table table-striped table-bordered table-hover table-sm">
                <thead>
                <tr style="background-color: #57b0f8; color:white; font-weight: bolder">
                    <th>Id</th>
                    <th>Name and surname</th>
                    <th>Number of assignments</th>
                    <th>Number of submited assignmetns</th>
                    <th>Points</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if (isset($results)) {

                    foreach ($results as $result) {?>
                        <tr>
                            <td><?= $result["id"] ?></td>
                            <td><a href="workDetail.php?id=<?= $result['id'] ?>" class="Detail"><?= $result["first_name"] . ' ' . $result["last_name"] ?></td>
                            <td><?= $result["generated_questions"] ?></td>
                            <td><?= $result["answered_questions"] ?></td>
                            <td><?=$result["total_points"] ?></td>

                        </tr>
                        <?php
                    }
                }
                ?>
                </tbody>
            </table>
            </div>
            <button id="download-csv" type="button" class="btn btn-primary">Download CSV</button>
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
