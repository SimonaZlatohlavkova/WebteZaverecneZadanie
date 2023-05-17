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


try{
    $db = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e){
    ECHO $e->getMessage();
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
        <link href="../menu/teacherMenu.css" rel="stylesheet" />

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
              integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
        <script src="https://kit.fontawesome.com/98d99917c7.js" crossorigin="anonymous"></script>


        <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.13.3/css/jquery.dataTables.min.css">
        <script rel="script" type="text/javascript" src="//cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"></script>

    </head>
    <body>
        <header id="nav-wrapper">
            <nav id="nav">
                <div class="nav left">
                    <span class="gradient skew"><h1 class="logo un-skew"><a id="logoID">Školský portál  </a></h1></span>
                    <button id="menu" class="btn-nav"><span class="fas fa-bars"></span></button>
                </div>
                <div class="nav right">
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




        <div class="container">
            <table id="table" class="table table-striped table-bordered table-hover table-sm">
                <thead>
                <tr>
                    <th>Ais Id</th>
                    <th>Meno a Priezvisko</th>
                    <th>Pocet vygenerovanych uloh</th>
                    <th>Pocet odovzdanych uloh</th>
                    <th>Pocet ziskanych bodov</th>
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
            <button id="download-csv" type="button">Stiahnuť CSV</button>
        </div>
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
