<?php
ini_set('display_errors', '0');
session_start();
require_once(".././lib/sql.php");
require_once(".././lib/print.php");
$conn = connection();
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
        Jckim2-회원가입

    </title>
    <link rel="stylesheet" href="../style.css">
    <script src="../script.js"></script>
</head>

<body style="font-family: 'Nanum Pen Script', cursive;
font-family: 'Noto Serif KR', serif;">
    <header align=center>
        <h1>
            <a href="../index.php">Jckim2</a>
        </h1>
    </header>
    <nav>
        <span><a href="signin.php">sign in</a></span>
        /
        <span><a href="signup.php">sign up</a></span>
    </nav>
    <div class="con">
        <div class="aside">
            <p>LIST</p>
            <ol style="color:white">
                <li style="color:white"><a href="index.php">공지사항</a></li>
                <li style="color:white"><a href="index.php?id=2">자유게시판</a></li>
            </ol>
        </div>