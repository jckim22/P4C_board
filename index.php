<link rel="stylesheet" href="style.css">
<?php require_once("./view/top.php");
require_once("./lib/print.php");
require_once("./lib/sql.php");

$conn = connection();

unset($rsc);

$pageNumber  = $_GET['pageNumber']??1;//현재 페이지, 없으면 1
if($pageNumber < 1) $pageNumber = 1;
$pageCount  = $_GET['pageCount']??8;//페이지당 몇개씩 보여줄지, 없으면 10
$startLimit = ($pageNumber-1)*$pageCount;//쿼리의 limit 시작 부분
$firstPageNumber  = $_GET['firstPageNumber']??1;

$sql = "select * from board where 1=1";
$sql .= " and status=1";
$order = " order by bid desc";
$limit = " limit $startLimit, $pageCount";
$query = $sql . $order . $limit;
$rsc=get_Table($conn,$query);
if (isset($_GET['search_keyword'])) {

    unset($rsc);

    $search_keyword = $_GET['search_keyword'];
    $search_where = " and (subject like '%" . $search_keyword . "%' or content like '%" . $search_keyword . "%')";
    $sql = "select * from board where 1=1";
    $sql .= " and status=1";
    $sql .= $search_where;
    $order = " order by bid desc";
    $limit = " limit $startLimit, $pageCount";
    $query = $sql . $order . $limit;
    $result = $conn->query($query) or die("query error => " . $conn->error);
    while ($rs = $result->fetch_object()) {
        $rsc[] = $rs;
    }
}

//전체게시물 수 구하기
$sqlcnt = "select count(*) as cnt from board where 1=1";
$sqlcnt .= " and status=1";
if (isset($_GET['search_keyword'])) {$sqlcnt .= $search_where;}
$countresult = $conn->query($sqlcnt) or die("query error => ".$conn->error);
$rscnt = $countresult->fetch_object();
$totalCount = $rscnt->cnt;//전체 게시물 갯수를 구한다.
$totalPage = ceil($totalCount/$pageCount);//전체 페이지를 구한다.

if($firstPageNumber < 1) $firstPageNumber = 1;
$lastPageNumber = $firstPageNumber + $pageCount - 1;//페이징 나오는 부분에서 레인지를 정한다.
if($lastPageNumber > $totalPage) $lastPageNumber = $totalPage;

if($firstPageNumber > $totalPage) {
    echo "<script>alert('더 이상 페이지가 없습니다.');history.back();</script>";
    exit;
}

?>

<div class="article">
    <div class="ListType">
        <h1>공지사항</h1>
    </div>
    <div role="region" aria-label="data table" tabindex="0" class="primary">
        <table id="products" style= border:1>
            <thead>
                <tr>
                    <th class="pin">번호</th>
                    <th>제목</th>
                    <th>글쓴이</th>
                    <th>작성일</th>
                    <th>조회수</th>
                </tr>
            </thead>

            <tbody>
                <?php
                $idNumber = $totalCount - ($pageNumber-1)*$pageCount;

                foreach ($rsc as $r) {
                    $subject = $r->subject;
                    if (isset($_GET['search_keyword'])) {
                        $subject = str_replace($search_keyword, "<span style='color:red;'>" . $search_keyword . "</span>", $r->subject);
                    }
                ?>
                    <tr>
                        <th><?= $idNumber--; ?></th>
                        <td><a href="/view.php?bid=<?php echo $r->bid; ?>"><?php echo $subject ?></a></td>
                        <td><?= $r->userid; ?></td>
                        <td><?= $r->regdate ?></td>
                        <td><?= $r->views ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <div class ="page">
    <div aria-label="Page navigation example">
        <ul>
            <li>
                <a href="<?php echo $_SERVER['PHP_SELF'] ?>?pageNumber=<?php echo $firstPageNumber - $pageCount; ?>&firstPageNumber=<?php echo $firstPageNumber - $pageCount; if (isset($_GET['search_keyword'])) {?>&search_keyword=<?php echo $search_keyword; }?>">이전</a>
            </li>
            <?php
            for ($i = $firstPageNumber; $i <= $lastPageNumber; $i++) {
            ?>
                <li <?php if ($pageNumber == $i) {
                                            echo "active";
                                        } ?>><a href="<?php echo $_SERVER['PHP_SELF'] ?>?pageNumber=<?php echo $i; ?>&firstPageNumber=<?php echo $firstPageNumber;if (isset($_GET['search_keyword'])) {?>&search_keyword=<?php echo $search_keyword; } ?>"><?php echo $i; ?></a></li>
            <?php
            }
            ?>
            <li>
                <a href="<?php echo $_SERVER['PHP_SELF'] ?>?pageNumber=<?php echo $firstPageNumber + $pageCount; ?>&firstPageNumber=<?php echo $firstPageNumber + $pageCount;if (isset($_GET['search_keyword'])) {?>&search_keyword=<?php echo $search_keyword; } ?>">다음</a>
            </li>
        </ul>
    </div>
    </div>
<!-- <div class = pageHelper></div> -->
        <p style="text-align:right;">
            <?php
            if (isset($_SESSION['UID'])) {
            ?>
        <div class="write-up" style="float:right;padding:20px;">
            <a href="write.php"><button type="button">글쓰기</button></a>
            <a href="./member/logout.php"><button type="button">로그아웃</button></a>
        </div>
    <?php
            } else {
    ?>
        <div class="write-up" style="float:right;padding:20px;">
            <a href="./member/signin.php"><button type="button">로그인</button></a>
            <a href="./member/signup.php"><button type="button">회원가입</button></a>
        </div>
    <?php
            }
    ?>
    <form method="get" action="<?php echo $_SERVER["PHP_SELF"] ?>">
            <div style="padding-left: 220px; margin:auto;width:50%;">
                <input type="text" style="width : 50%;" name="search_keyword" id="search_keyword" placeholder="제목과 내용에서 검색합니다." value="<?php if (isset($_GET['search_keyword'])) {                                                                                                                             echo $search_keyword;
} ?>" aria-label="Recipient's username" aria-describedby="button-addon2">
                <button class="btn" type="submit" id="button-addon2">검색</button>
            </div>
        </form>
        <
    </div>

</div>
<?php require_once("./view/bottom.php") ?>