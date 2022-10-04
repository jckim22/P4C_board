<?php require_once("./view/top.php");
require_once("./lib/sql.php");
require_once("./lib/print.php");

$conn = connection();
$bid = $_GET['bid'];

$sql = "update board set views=views+1 where bid=$bid";
$conn->query($sql);
?>

<div class="article">
    <div class="ListType">
        <h1>자유게시판</h1>
    </div>
    <div class="blog-post">
        <h2 style="border-bottom:1px solid gray" class="blog-post-title"><?php echo $rs->subject; ?></h2>
        <p class="blog-post-meta">조회수:<?= $rs->views ?></p>
        <p class="blog-post-meta"><?php echo $rs->regdate; ?> by <a href="#"><?php echo $rs->userid; ?></a></p>

        <hr>
        <p>
            <?php echo $rs->content; ?>
        </p>
        <hr>
    </div>

    <nav class="blog-pagination" aria-label="Pagination">
        <a class="btn" href="/index.php">목록</a>
        <?php
        if ($_SESSION['UID']) {

        ?>
            <a class="btn" href="/update.php?bid=<?php echo $rs->bid; ?>">수정</a>
            <form action="delete_process.php" method='post' onsubmit="
                        if(!confirm('sure?')){
                                return false; 
                        }
                        ">
                <input type="hidden" name='bid' value="<?= $bid ?>">
                <input type="submit" value="삭제">
            </form>

        <?php
        }
        ?>
    </nav>

</div>


</body>

</html>
<?php require_once("./view/bottom.php"); ?>