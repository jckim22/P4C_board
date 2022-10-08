<?php
ini_set('display_errors', '0');
session_start();
require_once(".././lib/sql.php");
require_once(".././lib/print.php");
$conn = connection();


if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash'])){
    
    $email = $_GET['email']; 
    $hash = $_GET['hash']; 
            
    $search = $conn->query("SELECT email, hash, active FROM members WHERE email='".$email."' AND hash='".$hash."' AND active='0'") or die(mysqli_error($conn)); 
    $match  = mysqli_num_rows($search);
            
    if($match > 0){
        
        $conn->query("UPDATE members SET active='1' WHERE email='".$email."' AND hash='".$hash."' AND active='0'") or die(mysqli_error($conn));
        echo "<script>alert('계정이 활성화 되었습니다 ! 로그인 후 이용해주세요 !(관리자 jckim2).'); location.href='../index.php'</script>";
    }else{
        
        echo "<script>alert('이미 활성화 되어있는 계정이거나 유효하지 않는 URL입니다. !(관리자 jckim2).'); location.href='../index.php'</script>";
    }
    
}else{
    echo "<script>alert('이미 활성화 되어있는 계정이거나 유효하지 않는 URL입니다. !(관리자 jckim2).'); location.href='../index.php'</script>";

}

?>