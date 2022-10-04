
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

