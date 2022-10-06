<?php require_once("./view/top.php");
require_once("./lib/sql.php");
require_once("./lib/print.php");
ini_set('display_errors', '0');

$conn = connection();
$bid = $_GET['bid'];

$result = $conn->query("select * from board where bid=" . $bid) or die("query error => " . $conn->error);
$rs = $result->fetch_object();

$resultL = $conn->query("select count(*) as cnt from recommend where type='like' and bid=" . $bid) or die("query error => " . $conn->error); //해당 게시물에 추천이나 반대가 몇개인지 확인
$rsL = $resultL->fetch_object();
$resultH = $conn->query("select count(*) as cnt from recommend where type='hate' and bid=" . $bid) or die("query error => " . $conn->error); //해당 게시물에 추천이나 반대가 몇개인지 확인
$rsH = $resultH->fetch_object();
$resultF = $conn->query("select * from board LEFT JOIN file_table ON board.bid = file_table.bid");
$rsF = $resultF->fetch_object();

$query = "select * from memo where status=1 and bid=" . $rs->bid . " order by memoid asc";
$memo_result = $conn->query($query) or die("query error => " . $conn->error);
while ($mrs = $memo_result->fetch_object()) {
    $memoArray[] = $mrs;
}


$sql = "update board set views=views+1 where bid=$bid";
$conn->query($sql);
?>

<div bottom=0; class="article">
    <div>
        <div class="ListType">
            <h1>자유게시판</h1>
        </div>
        <div height="800px" class="blog-post">
            <h2 style="border-bottom:1px solid gray" class="blog-post-title"><?php echo $rs->subject; ?></h2>
            <p class="blog-post-meta">조회수:<?= $rs->views ?></p>
            <p class="blog-post-meta"><?php echo $rs->regdate; ?> by <a href="#"><?php echo $rs->userid; ?></a></p>
            <div style="text-align:center;">
                <button type="button" class="btn btn-lg btn-primary" id="like_button">추천<?= $rsL->cnt ?></button>
                <button type="button" class="btn btn-lg btn-warning" id="hate_button">반대<?= $rsH->cnt ?></button>
            </div>
            <hr>
            <p>
                <?php echo $rs->content; ?>
            </p>
            <div>
                파일 : <a style="text-decoration: underline; color:blue; font-size:small;"
                
                href="./data/<?php echo $rsF->filename;?>" download><?php echo $rsF->filename; ?></a>
            </div>
        </div>
    </div>

    <div style="display: grid;
    grid-template-columns: 1fr 4fr;" class="blog-pagination" aria-label="Pagination">
        <div>
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
        </div>
        <div style="margin-top:20px; ">
            <form style="width:200px;" class="row g-3">
                <div class="col-md-10">
                    <textarea class="form-control" placeholder="댓글을 입력해주세요." id="memo" style="height: 60px"></textarea>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-secondary" id="memo_button">댓글등록</button>
                </div>
            </form>
        </div>
        <div style="width:500%;" margin-top:20px; id="memo_place">
            <?php
            foreach ($memoArray as $ma) {
            ?>
                <div class="commentBox" style="width:100%; margin-top:20px;">
                    <div class="commentBox2" style="width:100%">
                        <div class="commentBox3" style="width:100%">
                            <div class="commentBox4" style="width:100%">
                                <p class="commentBox5" style="width:100%"><?php echo $ma->memo; ?></p>
                                <p style="font-size:6%" class="commenBox6"><small class="text-muted"><?php echo $ma->userid; ?> / <?php echo $ma->regdate; ?></small></p>
                                <p style="text-align:right"><a class="btn" href="javascript:;" onclick="memo_del('<?php echo $ma->memoid ?>')">Delete</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>



        <script>
            $("#like_button").click(function() {

                if (!confirm('추천하시겠습니까?')) {
                    return false;
                }

                var data = {
                    type: 'like',
                    bid: <?php echo $bid; ?>
                };
                $.ajax({
                    async: false,
                    type: 'post',
                    url: 'like_hate.php',
                    data: data,
                    dataType: 'json',
                    error: function() {},
                    success: function(return_data) {
                        if (return_data.result == "member") {
                            alert('로그인 하십시오.');
                            return;
                        } else if (return_data.result == "check") {
                            alert('이미 추천이나 반대를 하셨습니다.');
                            return;
                        } else if (return_data.result == "no") {
                            alert('다시한번 시도해주십시오.');
                            return;
                        } else {
                            // $("#like").text(return_data.cnt);
                            $(function() {
                                alert("추천했습니다");
                                window.location.reload();
                            });
                        }
                    }
                });
            });

            $("#hate_button").click(function() {

                if (!confirm('반대하시겠습니까?')) {
                    return false;
                }

                var data = {
                    type: 'hate',
                    bid: <?php echo $bid; ?>
                };
                $.ajax({
                    async: false,
                    type: 'post',
                    url: 'like_hate.php',
                    data: data,
                    dataType: 'json',
                    error: function() {},
                    success: function(return_data) {
                        if (return_data.result == "member") {
                            alert('로그인 하십시오.');
                            return;
                        } else if (return_data.result == "check") {
                            alert('이미 추천이나 반대를 하셨습니다.');
                            return;
                        } else if (return_data.result == "no") {
                            alert('다시한번 시도해주십시오.');
                            return;
                        } else {
                            // $("#hate").text(return_data.cnt);
                            $(function() {
                                alert("반대하셨습니다.");
                                window.location.reload();
                            });
                        }
                    }
                });
            });




            $("#memo_button").click(function() { //댓글을 등록하면 함수 실행

                var data = {
                    memo: $('#memo').val(), //댓글의 내용 밸류값
                    bid: <?php echo $bid; ?> //bid GET
                };
                $.ajax({ //ajax 실행
                    async: false, //ajax는 기본적으로 동기화 이기때문에 비동기화 처리
                    type: 'post', //post형식으로 보낸다
                    url: 'memo_write.php', //memo_write.php로
                    data: data,
                    dataType: 'html', //문서 타입은 html
                    error: function() {},
                    success: function(return_data) { //성공한다면 return_data에 memo_write.php의 리턴 데이터를 받는다
                        if (return_data == "member") { //만약 그 member라는 데이터를 리턴 받았으면 로그인이 안되어 있는 것
                            alert('로그인 하십시오.');
                            return;
                        } else {
                            $("#memo_place").append(return_data); //로그인이 되어 있다면 memo_place에게 데이터를 돌려준다
                        }
                    }
                });
            });

            function memo_del(memoid) {

                if (!confirm('삭제하시겠습니까?')) {
                    return false;
                }

                var data = {
                    memoid: memoid
                };
                $.ajax({
                    async: false,
                    type: 'post',
                    url: 'memo_delete.php',
                    data: data,
                    dataType: 'json',
                    error: function() {},
                    success: function(return_data) {
                        if (return_data.result == "member") {
                            alert('로그인 하십시오.');
                            return;
                        } else if (return_data.result == "my") {
                            alert('본인이 작성한 글만 삭제할 수 있습니다.');
                            return;
                        } else if (return_data.result == "no") {
                            alert('삭제하지 못했습니다. 관리자에게 문의하십시오.');
                            return;
                        } else {
                            $(function() {
                                alert("삭제했습니다");
                                window.location.reload();
                            });
                        }
                    }
                });

            }
        </script>

        <?php require_once("./view/bottom.php"); ?>