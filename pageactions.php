<?php

  function doAction( $vars ) {
    if($_SERVER['REQUEST_METHOD'] === 'GET'){
      $actiondisplay = '_'.$vars['action'].'_form.php';
      if( $vars['action'] === NULL ) {
        $actiondisplay = DEFAULT_VIEW;
      };
      require( $actiondisplay );
    } elseif($_SERVER['REQUEST_METHOD'] === 'POST'){
      switch( $vars['action'] ) {
        case "forgetpassword":
          doActionForgetPassword();
          break;
        case "updatephone":
          doActionUpdatePhone( $vars );
          break;
        case "login":
        default:
          doActionLogin();
      };
    };
  };

  function doActionLogin() {
    $login = SCGQuery( "UserOnlineControl", "Login" );

    #$login['ResponseCode'] = "200";

    if($login['ResponseCode'] === "200"){
      echo "Login successful<br />";
      #Check if phone number exists
      $user = AptiloCCSQuery ( "viewUser" );
      #If phone number exists
      if( !$user['errors']['PhoneNumberDoesNotExist'] ){
        # Redirect to default page
        #echo $user['phonenumber'];
      } else { #If phone number does not exist
        # Prompt for phone number
        require('_updatephone_form.php');
      };
    } else {
      echo "<div id='errors'>",$login['ReplyMessage'],"</div>";
      require('_login_form.php');
    };
  };

  function doActionForgetPassword() {
    $forgetpassword = AptiloCCSQuery( "viewUser" );

    #echo json_encode($forgetpassword)."<br />";
    #echo $password['password'];

    if( !$forgetpassword['errors']['UserDoesNotExist'] and !$forgetpassword['errors']['PhoneNumberDoesNotExist']){
      changePassword();
      $forgetpassword = AptiloCCSQuery( "viewUser" );
      sendPassword( $forgetpassword['pwd'], $forgetpassword['phonenumber'] );
    } else {
      showErrors( $forgetpassword['errors'] );
      require('_forgetpassword_form.php');
    };
  };

  function doActionUpdatePhone( $vars ){
    $updatephone = AptiloCCSQuery( "modifyUser", array('phonenumber' => $vars['phone']));
    changePassword();
    $user = AptiloCCSQuery ( "viewUser" );
    sendPassword( $user['pwd'], $user['phonenumber'] );
    #echo $user['pwd'], $user['phonenumber'];
  };

  function getAction( $vars ) {
    return $vars['action'];
  };

?>
