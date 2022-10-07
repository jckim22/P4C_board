<?php
ini_set('display_errors', '0');
session_start();
require_once(".././lib/sql.php");
require_once(".././lib/print.php");
$conn = connection();


require_once(".././view/sighupTop.php");

?>
<div class="signup">

    <form class="signupForm" method="post" action="signin_process.php">
        <div>
            <label for="validationCustom02" class="form-label">아이디</label>
            <input type="text" class="form-control" id="userid" name="userid" placeholder="" required>
        </div>
        <div>
            <label for="validationCustom02" class="form-label">비밀번호</label>
            <input type="password" class="form-control" id="passwd" name="passwd" placeholder="" required>
        </div>
        <div class="signupBtn">
            <button type="submit">login</button>
        </div>
    </form>

</div>




<?php
require_once(".././view/bottom.php");
?>