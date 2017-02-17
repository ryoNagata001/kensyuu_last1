<?php
session_start();
if($_POST['token'] != session_id()){
    echo "正規のルートから編集を行ってください";
    exit;
}
$new_content = $_POST['new_content'];
$comment_id = $_POST['comment_id'];
$string = str_replace(array(" ", "　"), "", $new_content);
$string = preg_replace('/\n|\r|\r\n/', '', $string);
var_dump($string);
if($string == "" ){
    echo "何か入力してください";
    exit;
}
if($new_content == ""){
    echo "何か記入してください";
    exit;
}
try{
    require_once('../pdo.php');
}catch(PDOException $e){
    var_dump($e->getMessage());
    exit;
}

$stmt = $db->prepare("update comments set content = :content where id = :id");
$stmt->execute([
    ':content'=>$new_content,
    ':id'=>$comment_id
]);

echo "編集しました<br>";
echo '<a href="../threads/show_all.php">スレッド一覧に戻る</a>';
