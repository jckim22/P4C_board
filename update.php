<?php
require_once("./view/top.php");
$conn=connection();

if (!$_SESSION['UID']) {
    echo "<script>alert('회원 전용 게시판입니다.');history.back();</script>";
    exit;
}
$bid=$_GET["bid"];

if(isset($bid)){//bid가 있다는건 수정이라는 의미다.

    $result = $conn->query("select * from board where bid=".$bid) or die("query error => ".$conn->error);
    $rs = $result->fetch_object();

    if($rs->userid!=$_SESSION['UID']){
        echo "<script>alert('본인 글이 아니면 수정할 수 없습니다.');history.back();</script>";
        exit;
    }

}
?>




<div class="article">
    <div class="ListType">
        <h1>자유게시판</h1>
    </div>
    <div class="blog-post">
        <form method="post" action="update_process.php">
            <div class="title-input">
                <label for="exampleFormControlInput1" class="form-label">제목</label>
                <input type="text" name="subject" class="form-control" id="exampleFormControlInput1" placeholder="제목을 입력하세요."
                value="<?=$rs->subject;?>"
                >
            </div>
            <div class="text-input">
                <label for="exampleFormControlTextarea1" class="form-label">내용</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" name="content" rows="3" value="<?=$rs->content;?>"></textarea>
            </div>
            <input type="hidden" name="bid" value="<?php echo $bid;?>">
            <div style="text-align:right">
                <button type="submit">수정</button>
                <a href="index.php"><button type="button">취소</button></a>
            </div>
        </form>
    </div>
</div>




<?php require_once("./view/bottom.php") ?>