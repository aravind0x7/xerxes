<?php
session_start();
require_once 'includes/auth_validate.php';
require_once './config/config.php';
$del_id = filter_input(INPUT_POST, 'del_id');
$del_ids = filter_input(INPUT_POST, 'del_ids');

if ($del_id && $_SERVER['REQUEST_METHOD'] == 'POST')
{
    if($_SESSION['admin_type']!='super'){
        $_SESSION['failure'] = "You don't have permission to perform this action";
        header('location: list_cc.php');
        exit;

    }
    $cc_info_id = $del_id;
    $db->where('id', $cc_info_id);
    $status = $db->delete('cc_info');

    if ($status)
    {
        $_SESSION['info'] = "CC info deleted successfully!";
        header('location: list_cc.php');
        exit;
    }
    else
    {
        $_SESSION['failure'] = "Unable to delete CC info";
        header('location: list_cc.php');
        exit;

    }
}
if ($del_ids && $_SERVER['REQUEST_METHOD'] == 'POST'){
    $status = false;
    if($_SESSION['admin_type']!='super'){
        $_SESSION['failure'] = "You don't have permission to perform this action";
        header('location: list_cc.php');
        exit;

    }
    foreach (explode(":", $del_ids) as $del_id) {
        $db->where('id', $del_id);
        $status = $db->delete('cc_info');
    }

    if ($status)
    {
        $_SESSION['info'] = "CC info deleted successfully!";
        header('location: list_cc.php');
        exit;
    }
    else
    {
        $_SESSION['failure'] = "Unable to delete CC info";
        header('location: list_cc.php');
        exit;

    }
}