<?php
include_once('header.php');
include_once('messages.php');

function get_extended_date($ad_id){

    global $conn;
    $id_ad = mysqli_real_escape_string($conn, $ad_id);
    $get_new_date_timestamp = "SELECT DATE_ADD((select expiration_date from ads where id_ad=$id_ad), INTERVAL 30 DAY)";
    $new_timestamp=$conn->query($get_new_date_timestamp);
    return $new_timestamp->fetch_array()[0];
}

function extend_expiration_date($ad_id)
{
    global $conn;
    $id_ad = mysqli_real_escape_string($conn, $ad_id);
    $new_exp_date=get_extended_date($id_ad);
    $update_exp_date = "UPDATE ads SET expiration_date='$new_exp_date' WHERE id_ad=$id_ad";
    if ($conn->query($update_exp_date)) {
        return true;
    } else {
        echo display_error("Error while extending expiration date.");
        return false;
    }
}

$id = isset($_GET['id']) ? $_GET['id'] : '';
if(extend_expiration_date($id)){
    header("Location: my_ads.php");
    die();
}else{
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit;
}
