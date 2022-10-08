<?php

function connection()
{

    $hostname = "localhost";
    $dbuserid = "jckim2";
    $dbpasswd = "wncks4545!";
    $dbname = "jckim2";


    $mysqli = new mysqli($hostname, $dbuserid, $dbpasswd, $dbname);

    if ($mysqli->connect_errno) {
        die('Connect Error: ' . $mysqli->connect_error);
    }
    return $mysqli;
}

function Sqlexe($conn, $sql)
{
    if ($result = $conn->query($sql)) {

        echo "<script>alert('성공했습니다.');
        location.href=\"index.php\"
        </script>";
    } else {
        echo "<script>
        alert('에러가 발생했습니다. 관리자에게 문의 주세요. (010-2856-4221)');
        </script>";
        error_log(mysqli_error($conn));
    }

    return $result;
}
function SqlexeUpdate($conn, $sql)
{
    if ($result = $conn->query($sql)) {

        echo "<script>alert('성공했습니다.');
        location.href=\"index.php\";
        </script>";
    } else {
        echo "<script>
        alert('에러가 발생했습니다. 관리자에게 문의 주세요. (010-2856-4221)');
        </script>";
        error_log(mysqli_error($conn));
    }

    return $result;
}
function SqlexeMember($conn, $sql)
{
    if ($result = $conn->query($sql)) {

        echo "<script>alert('계정 생성 ! 이메일을 확인하여 계정을 활성해주세요 !');
        location.href='../index.php'
        </script>";
    } else {
        // echo "<script>
        // alert('에러가 발생했습니다. 관리자에게 문의 주세요. (010-2856-4221)');
        // location.href='../index.php'
        // </script>";
        
        echo(mysqli_error($conn));

        error_log(mysqli_error($conn));
    }

    return $result;
}
