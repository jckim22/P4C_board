// $("#memo_button").click(function () {

//     var data = {
//         memo: $('#memo').val(),
//         bid: <? php echo $bid; ?>
//     };
// $.ajax({
//     async: false,
//     type: 'post',
//     url: 'memo_write.php',
//     data: data,
//     dataType: 'html',
//     error: function () { },
//     success: function (return_data) {
//         if (return_data == "member") {
//             alert('로그인 하십시오.');
//             return;
//         } else {
//             $("#memo_place").append(return_data);
//         }
//     }
// });
// });

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
        error: function () { },
        success: function (return_data) {
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
                $("#memo_" + memoid).hide();
            }
        }
    });

}

// $("#like_button").click(function () {

//     if (!confirm('추천하시겠습니까?')) {
//         return false;
//     }

//     var data = {
//         type: 'like',
//         bid: <? php echo $bid;?>
//       };
// $.ajax({
//     async: false,
//     type: 'post',
//     url: 'like_hate.php',
//     data: data,
//     dataType: 'json',
//     error: function () { },
//     success: function (return_data) {
//         if (return_data.result == "member") {
//             alert('로그인 하십시오.');
//             return;
//         } else if (return_data.result == "check") {
//             alert('이미 추천이나 반대를 하셨습니다.');
//             return;
//         } else if (return_data.result == "no") {
//             alert('다시한번 시도해주십시오.');
//             return;
//         } else {
//             $("#like").text(return_data.cnt);
//         }
//     }
// });
//   });

// $("#hate_button").click(function () {

//     if (!confirm('반대하시겠습니까?')) {
//         return false;
//     }

//     var data = {
//         type: 'hate',
//         bid: <? php echo $bid;?>
//       };
// $.ajax({
//     async: false,
//     type: 'post',
//     url: 'like_hate.php',
//     data: data,
//     dataType: 'json',
//     error: function () { },
//     success: function (return_data) {
//         if (return_data.result == "member") {
//             alert('로그인 하십시오.');
//             return;
//         } else if (return_data.result == "check") {
//             alert('이미 추천이나 반대를 하셨습니다.');
//             return;
//         } else if (return_data.result == "no") {
//             alert('다시한번 시도해주십시오.');
//             return;
//         } else {
//             $("#hate").text(return_data.cnt);
//         }
//     }
// });
//   });
