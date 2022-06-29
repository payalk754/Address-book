<?php
require_once('./includes/functions.inc.php');

if(!isset($_GET['id'])) {
    echo "How the hell you came here??";
    die();
}

$id = $_GET['id'];

$query ="SELECT * FROM contacts WHERE id = $id";
$rows = db_select($query);
if($rows===false) {
    $error = db_error();
    dd($error);
} else if(empty($rows)) {
    dd("How the hell you got this id?");

}

$image_name = $rows[0]['image_name'];
$query = "DELETE FROM contacts WHERE id = $id";
$result = db_query($query);

if($result) {
    unlink("images/users/$image_name");
    redirect('index.php?op=delete&status=success');
} else {
    redirect('index.php?op=delete&status=err');
}