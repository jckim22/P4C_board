<?php
require_once(".././lib/sql.php");
require_once(".././lib/print.php");
$conn = connection();


require_once(".././view/sighupTop.php");

?>
<script>
function check() {
    
    form = document.sendmail;
    if (form.form_user.value == '') {
        alert('받는사람의 메일 주소를 입력해주세요.');
        form.form_user.focus();
        return false;
    }

    /*if ( form.subject.value == '' ) {
        alert('메일 제목을 입력해주세요.');
    form.subject.focus();
    return false;
    }*/

    form.submit();
}
</script>
<form name='sendmail' action='sendmail.php' method='post'>

    <table width='500' border='0' cellpadding='0' cellspacing='0' style='border:1px solid #999999;'>
        <tr height='30'>
            <td align='center' colspan='2' style='border-bottom:1px solid #999999;'>
                이메일 인증 후 회원가입이 진행됩니다.
                (관리자 : 010-2856-4221)
            </td>
        </tr>
        <tr height='30'>
            <td width='100' align='right' style='border-bottom:1px solid #999999;'>
                받는 사람 : &nbsp; &nbsp;
            </td>
            <td style='border-bottom:1px solid #999999;'>
                <input type='text' name='form_user'>
            </td>
        </tr>
        <!--<tr height='30'>
        <td align='right' style='border-bottom:1px solid #999999;'>
            제목 :  &nbsp; &nbsp;
        </td>
        <td style='border-bottom:1px solid #999999;'>
            <input type='text' name='subject'>
        </td>
    </tr>
    <tr height='30'>
        <td align='right'>
            내용 :  &nbsp; &nbsp;
        </td>
        <td>
            <textarea name='content' style='width:380px; height:100px;'>메일 테스트</textarea>
        </td>
    </tr>-->
    </table>

    <table width='500' border='0' cellpadding='0' cellspacing='0'>
        <tr height='50'>
            <td align='center'>
                <input type='button' value='메일인증하기' onclick='check()'>
            </td>
        </tr>
    </table>
</form>

<?php
require_once(".././view/bottom.php");
?>