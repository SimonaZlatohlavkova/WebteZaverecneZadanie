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


require_once "config.php";

$id = $_GET['id'];


try{
    $db = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e){
    ECHO $e->getMessage();
}


$sql = "SELECT email FROM users WHERE id = :id";

// Prepare the statement and bind the ID parameter
$stmt = $db->prepare($sql);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);

// Execute the statement
$stmt->execute();

// Fetch the email from the result
$email = $stmt->fetchColumn();


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
    <table id="tableSK" class="table table-striped table-bordered table-hover table-sm">
        <thead>
        <tr>
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
                $correct = '&#10060;';
            } elseif ($row['correct'] == 1) {
                $correct = '&#10004;';
            }
            $points = isset($row['points']) ? $row['points'] : '';
            $maxPoints = isset($row['maxPoints']) ? $row['maxPoints'] : '';
            ?>
            <tr>
                <td><?= $questionName ?></td>
                <td><?= $solution ?></td>
                <td><?= $answer ?></td>
                <td><?= $correct ?></td>
                <td><?= $points ?></td>
                <td><?= $maxPoints ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
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
