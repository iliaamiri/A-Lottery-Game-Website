<?php include "../configuration.php";
$witcher = new witcher();
$witcher->requireController("login");
$user = new \Controller\login();
if ($user->is_login() == 1 ){
$user = new \Model\user();
$permission = $user->user_get_permission(1);
if ($permission['Admin'] == 1 ){
    if (!empty($_FILES)){
        $upload = new \Model\upload();
        $check = array("php");
        var_dump($upload->Upload($check,"landpage.".rand().".index","witcher/view/landpages",$_FILES['file']));
    }
}
else{
    die();
}
}
