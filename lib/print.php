<?php
function get_table($conn, $sql)
{
    $result = $conn->query($sql) or die("query error => " . $conn->error);

    while ($rs = $result->fetch_object()) {
        $rsc[] = $rs;
    }
    // echo "<pre>";
    // print_r($rsc);
    return $rsc;
}

function get_table_row($conn)
{
    $bid = $_GET['bid'];
    $sql = "select * from board where bid = $bid";
    $result = $conn->query($sql) or die("query error => " . $conn->error);
    $rs = $result->fetch_object();
    return $rs;
}

function get_title($conn){
    $mainTitle = '공지사항';

    if(isset($_GET['id'])){
        $mainTitle = '자유게시판';
    }
    return $mainTitle;
}
?>