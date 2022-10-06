<?php
require_once("./view/top.php");

if (!$_SESSION['UID']) {
    echo "<script>alert('회원 전용 게시판입니다.');history.back();</script>";
    exit;
}

?>




<div class="article">
    <div class="ListType">
        <h1>자유게시판</h1>
    </div>
    <div class="blog-post">
        <form method="post" action="write_process.php" enctype="multipart/form-data">
            <div class="title-input">
                <label for="exampleFormControlInput1" class="form-label">제목</label>
                <input type="text" name="subject" class="form-control" id="exampleFormControlInput1" placeholder="제목을 입력하세요.">
            </div>
            <div class="text-input">
                <label for="exampleFormControlTextarea1" class="form-label">내용</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" name="content" rows="3"></textarea>
            </div>
            <div>
                <input type="file" accept="*" name="upfile">
            </div>
            <div style="text-align:right">
                <button type="submit">등록</button>
                <a href="index.php"><button type="button">취소</button></a>
            </div>
        </form>
    </div>
</div>




<?php require_once("./view/bottom.php") ?>