<link rel="stylesheet" href="style.css">
<?php require_once("./view/top.php");
require_once("./lib/print.php");
require_once("./lib/sql.php");

$conn = connection();

unset($rsc);

$pageNumber  = $_GET['pageNumber'] ?? 1; //현재 페이지, 없으면 1
if ($pageNumber < 1) $pageNumber = 1; //페이지 넘버가 1보다 작으면 1이되게 한다 (이전을 눌렀을 때 -값이 되는 것을 대비)
$pageCount  = $_GET['pageCount'] ?? 8; //페이지당 몇개씩 보여줄지, 없으면 10
$startLimit = ($pageNumber - 1) * $pageCount; //쿼리의 limit 시작 부분
$firstPageNumber  = $_GET['firstPageNumber'] ?? 1; //페이지의 첫 넘버를 설정 없으면 1

$sql = "select b.*, if((now() - regdate)<=86400,1,0) as newid
,(select count(*) from memo m where m.status=1 and m.bid=b.bid) as memocnt
,(select m.regdate from memo m where m.status=1 and m.bid=b.bid order by m.memoid desc limit 1) as memodate
,(select count(*) from file_table f where f.status=1 and f.bid=b.bid) as filecnt
from board b where 1=1";
$sql .= " and status=1";
$order = " order by bid desc";
$limit = " limit $startLimit, $pageCount";
$query = $sql . $order . $limit;
$rsc = get_Table($conn, $query);
if (isset($_GET['search_keyword'])) {

    unset($rsc);

    $search_keyword = $_GET['search_keyword'];
    $search_where = " and (subject like '%" . $search_keyword . "%' or content like '%" . $search_keyword . "%')";
    $sql = "select b.*, if((now() - regdate)<=86400,1,0) as newid
    ,(select count(*) from memo m where m.status=1 and m.bid=b.bid) as memocnt
    ,(select m.regdate from memo m where m.status=1 and m.bid=b.bid order by m.memoid desc limit 1) as memodate
    ,(select count(*) from file_table f where f.status=1 and f.bid=b.bid) as filecnt
    from board b where 1=1";
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
if (isset($_GET['search_keyword'])) {
    $sqlcnt .= $search_where;
}
$countresult = $conn->query($sqlcnt) or die("query error => " . $conn->error);
$rscnt = $countresult->fetch_object();
$totalCount = $rscnt->cnt; //전체 게시물 갯수를 구한다.
$totalPage = ceil($totalCount / $pageCount); //전체 페이지를 구한다.

if ($firstPageNumber < 1) $firstPageNumber = 1;
$lastPageNumber = $firstPageNumber + $pageCount - 1; //페이징 나오는 부분에서 레인지를 정한다.
if ($lastPageNumber > $totalPage) $lastPageNumber = $totalPage;

if ($firstPageNumber > $totalPage) {
    echo "<script>alert('더 이상 페이지가 없습니다.');history.back();</script>";
    exit;
}

?>

<div class="article">
    <div class="ListType">
        <h1>공지사항</h1>
    </div>
    <div role="region" aria-label="data table" tabindex="0" class="primary">
        <table id="products" style=border:1>
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
                $idNumber = $totalCount - ($pageNumber - 1) * $pageCount; //id넘버는 총 개수에서 페이지넘버 -1를 페이지 게시물 수에 곱한 값을 뺀 것과 같다

                foreach ($rsc as $r) {
                    $subject = $r->subject;
                    if (isset($_GET['search_keyword'])) {
                        $subject = str_replace($search_keyword, "<span style='color:red;'>" . $search_keyword . "</span>", $r->subject);
                    }
                ?>
                    <tr>
                        <th><?= $idNumber--; ?></th>
                        <td> <a href="/view.php?bid=<?php echo $r->bid; ?>"><?php echo $subject ?></a>
                            <?php if ($r->filecnt) { ?>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-card-image" viewBox="0 0 16 16">
                                    <path d="M6.002 5.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z" />
                                    <path d="M1.5 2A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13zm13 1a.5.5 0 0 1 .5.5v6l-3.775-1.947a.5.5 0 0 0-.577.093l-3.71 3.71-2.66-1.772a.5.5 0 0 0-.63.062L1.002 12v.54A.505.505 0 0 1 1 12.5v-9a.5.5 0 0 1 .5-.5h13z" />
                                </svg>
                            <?php } ?>
                            <?php if ($r->memocnt) { ?>
                                <span <?php if ((time() - strtotime($r->memodate)) <= 86400) {
                                            echo "style='color:red;'";
                                        } ?>>
                                    [<?php echo $r->memocnt; ?>]
                                </span>
                            <?php } ?>
                            <?php if ($r->newid) { ?>
                                <span style="color:blue;" class="badge bg-danger">New</span>
                            <?php } ?>
                        </td>
                        <td><?= $r->userid; ?></td>
                        <td><?= $r->regdate ?></td>
                        <td><?= $r->views ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <div class="page">
            <div aria-label="Page navigation example">
                <ul>
                    <li>
                        <a href="<?php echo $_SERVER['PHP_SELF'] ?>?pageNumber=<?php echo $firstPageNumber - $pageCount; ?>&firstPageNumber=<?php echo $firstPageNumber - $pageCount;
                                                                                                                                            if (isset($_GET['search_keyword'])) { ?>&search_keyword=<?php echo $search_keyword;
                                                                                                                                                                                                } ?>">이전</a>
                    </li>
                    <?php
                    for ($i = $firstPageNumber; $i <= $lastPageNumber; $i++) { //첫 페이지 넘버가 라스트 페이지 넘버가 될 때까지 반복
                    ?>
                        <li <?php if ($pageNumber == $i) {
                                echo "active";
                            } ?>><a href="<?php echo $_SERVER['PHP_SELF'] ?>?pageNumber=<?php echo $i; ?>&firstPageNumber=<?php echo $firstPageNumber;
                                                                                                                            if (isset($_GET['search_keyword'])) { ?>&search_keyword=<?php echo $search_keyword;
                                                                                                                                                                                            } ?>"><?php echo $i; ?></a></li>
                    <?php
                    }
                    ?>
                    <li>
                        <a href="<?php echo $_SERVER['PHP_SELF'] ?>?pageNumber=<?php echo $firstPageNumber + $pageCount; ?>&firstPageNumber=<?php echo $firstPageNumber + $pageCount;
                                                                                                                                            if (isset($_GET['search_keyword'])) { ?>&search_keyword=<?php echo $search_keyword;
                                                                                                                                                                                                } ?>">다음</a>
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
            <input type="text" style="width : 50%;" name="search_keyword" id="search_keyword" placeholder="제목과 내용에서 검색합니다." value="<?php if (isset($_GET['search_keyword'])) {
                                                                                                                                        echo $search_keyword;
                                                                                                                                    } ?>" aria-label="Recipient's username" aria-describedby="button-addon2">
            <button class="btn" type="submit" id="button-addon2">검색</button>
        </div>
    </form>
    < </div>

    </div>
    <?php require_once("./view/bottom.php") ?>