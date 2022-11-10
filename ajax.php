<?php 

$action = $_GET['action'];
include 'action_classes.php';
$crud = new Action();
if($action == 'save_book'){
    $save = $crud->save_book();
    if($save)
        echo $save;
}
if($action == 'save_borrower'){
    $save = $crud->save_borrower();
    if($save)
        echo $save;
}
if($action == 'save_borrow'){
    $save = $crud->save_borrow();
    if($save)
        echo $save;
}
if($action == 'delete_book'){
    $delete = $crud->delete_book();
    if($delete) 
    echo $delete;
}
if($action == 'delete_borrower'){
    $delete = $crud->delete_borrower();
    if($delete) 
    echo $delete;
}
if($action == 'delete_borrow'){
    $delete = $crud->delete_borrow();
    if($delete) 
    echo $delete;
}
if($action == 'login'){
    $login = $crud->login();
    if($login) 
    echo $login;
}
if($action == 'logout'){
    $logout = $crud->logout();
    if($logout) 
    echo $logout;
}

