<?php
ini_set('display_errors', '0');
session_start();
require_once("./lib/sql.php");
require_once("./lib/print.php");
$conn = connection();

$pageNumber  = $_GET['pageNumber'] ?? 1; //현재 페이지, 없으면 1
if ($pageNumber < 1) $pageNumber = 1;
$pageCount  = $_GET['pageCount'] ?? 5; //페이지당 몇개씩 보여줄지, 없으면 10
$startLimit = ($pageNumber - 1) * $pageCount; //쿼리의 limit 시작 부분
$firstPageNumber  = $_GET['firstPageNumber'] ?? 1;

$sql = "select * from board";

$rsc = get_table($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nanum+Pen+Script&family=Noto+Serif+KR&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php
        if (isset($_GET['bid'])) {

            $rs = get_table_row($conn);
            echo $rs->userid;
        ?> 님의 게시글<?php
                } else {
                    ?>
            Jckim2-main

        <?php
                }
        ?>

    </title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>
</head>

<body style="font-family: 'Nanum Pen Script', cursive;
font-family: 'Noto Serif KR', serif;">
    <header text align=center>
        <h1>
            <a href="index.php">Jckim2</a>
        </h1>
    </header>
    <nav>
        <?php
        if (!isset($_SESSION['UID'])) {
        ?>
            <span><a href="./member/signin.php">sign in</a></span>
            /
            <span><a href="./member/signup.php">sign up</a></span>


        <?php
        } else {
        ?>
            <?php
            echo "<span class='welcome'>" . $_SESSION['UID'] . "(" . $_SESSION['UNAME'] . ") 님! 반갑습니다! </span>"
            ?>
            /
            <span><a href="./member/logout.php">logout</a></span>
        <?php
        }
        ?>
    </nav>
    <div class="con">
        <div class="aside">
            <p>LIST</p>
            <ol style="color:white">
                <li><a style="color:white" href="index.php">공지사항</a></li>
                <li><a style="color:white" href="index.php?id=2">자유게시판</a></li>
            </ol>
        </div>