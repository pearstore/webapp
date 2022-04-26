<?php require_once('_function.php'); ?>
<?php

session_start();

$_MYSQL_CONNECTION = mysqli_connect("pearshop_db","pearshop","itsstuttgart","pearstore_database");

// Register User 
if(isset($_POST['form_type']) && $_POST['form_type'] == "user_register" && isset($_POST['vname']) && isset($_POST['nname']) && isset($_POST['mail']) && isset($_POST['passwd']) && isset($_POST['passwd2']) && isset($_POST['address']) && $_POST['passwd'] == $_POST['passwd2']){
    $registerSuccess = registerUser($_POST['vname'], $_POST['nname'], $_POST['mail'], $_POST['passwd'], $_POST['address'], $_POST['ort'], $_POST['zip']);
}

// Login User
if(isset($_POST['form_type']) && $_POST['form_type'] == "user_login" && isset($_POST['mail']) && isset($_POST['passwd'])){
    $loginSuccess = loginUser($_POST['mail'], $_POST['passwd']);
}

// Logout User
if(isset($_POST['form_type']) && $_POST['form_type'] == "user_logout"){
    logoutUser();
}

$USER = getUserbySession();

?>