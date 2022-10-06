<?php
ini_set( 'display_errors', '0' );
require_once("./lib/sql.php");
require_once("./lib/print.php");
$mysqli=connection();


if (!$_SESSION['UID']) {
    echo "member";
    exit;
}

$memo  = $_POST['memo'];
$bid  = $_POST['bid'];
$memoid = $_POST['memoid'] ?? 0;

$sql = "INSERT INTO memo
(bid, pid, userid, memo, status)
VALUES(" . $bid . ", " . $memoid . ", '" . $_SESSION['UID'] . "', '" . $memo . "', 1)";
$result = $mysqli->query($sql) or die($mysqli->error);
if ($result) $last_memoid = $mysqli->insert_id;

echo "<div class=\"commentBox\" style=\"width:100%; margin-top:20px;\">
<div class=\"commenBox2\" style=\"width:100%;\">
    <div class=\"commenBox3\" style=\"width:100%;\">
    <div class=\"commenBox4\" style=\"width:100%;\">
      <p class=\"commenBox5\" style=\"width:100%;\">" . $memo . "</p>
      <p style=\"font-size:6%\" class=\"commenBox6\"><small class=\"text-muted\">" . $_SESSION['UID'] . " / now</small></p>
      <p style=\"text-align:right\"><a class=\"btn\" href=\"javascript:;\" onclick=\"memo_del('<?php echo $ma->memoid?>')\">Delete</a></p>
    </div>
  </div>
</div>
</div>";
?>