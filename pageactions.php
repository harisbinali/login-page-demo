<?php

function doAction( $action ) {
  if($_SERVER['REQUEST_METHOD'] === 'GET'){
    $actiondisplay = '_'.$action.'_form.php';
    if( $action === "" ) {
      $actiondisplay = DEFAULT_VIEW;
    };
    require( $actiondisplay );
  } elseif($_SERVER['REQUEST_METHOD'] === 'POST'){
    switch( $action ) {
      case "forgetpassword":
        doActionForgetPassword();
        break;
      case "login":
      default:
        doActionLogin();
    };
  };
};

function doActionLogin() {
  $login = SCGQuery( "UserOnlineControl", "Login" );

  if($login['ResponseCode'] === "200"){
    echo "Login successful";
    #Check if phone number exists
    #If phone number exists
    # Redirect to default page
    #If phone number does not exist
    # Prompt for phone number
    # Generate random password and update phone number and password to user database
    # Send password to user by SMS
    # Redirect to default page
  } else {
    echo "<div id='errors'>",$login['ReplyMessage'],"</div>";
    require('_login_form.php');
  };
};

function doActionForgetPassword() {
  $forgetpassword['ResponseCode']= "201";
  $forgetpassword['ReplyMessage']= "Invalid phone number";

  $new_password = random_str(6, '0123456789');


  if($forgetpassword['ResponseCode'] === "200"){
    echo "New password is ", $new_password;
  } else {
    echo "<div id='errors'>",$forgetpassword['ReplyMessage'],"</div>";
    require('_forgetpassword_form.php');
  };
};

function getAction() {
  $action = $_GET["action"] ;

  if( $action === NULL) {
    $action = $_POST["action"];
  };

  return sanitize( $action );
};

?>
