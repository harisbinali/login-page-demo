<?php

  function cleanInput($input) {

  $search = array(
    '@<script[^>]*?>.*?</script>@si',   // Strip out javascript
    '@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags
    '@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
    '@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments
  );

    $output = preg_replace($search, '', $input);
    return $output;
  }

  ##  function sanitize( $input ) {
  ##  return trim(htmlspecialchars($input));
  ##};

  function sanitize($input) {
    if (is_array($input)) {
        foreach($input as $var=>$val) {
            $output[$var] = sanitize($val);
        }
    }
    else {
        if (get_magic_quotes_gpc()) {
            $input = stripslashes($input);
        }
        $input  = cleanInput($input);
        $output = trim(htmlspecialchars($input));
    }
    return $output;
}

  function random_str( $length, $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ') {
    $str = '';
    $max = mb_strlen($keyspace, '8bit') - 1;
    if ($max < 2) {
        throw new Exception('$keyspace must be at least two characters long');
    }
    for ($i = 0; $i < $length; ++$i) {
        $str .= $keyspace[random_int(0, $max)];
    }
    return $str;
  };

  function validateAptiloCCSQuery( $input ) {
    switch( $input['status'] ) {
      case "200":
        if( $input['uname'] ){
          if($input['phonenumber'] === "") $res['PhoneNumberDoesNotExist'] = true;
        };
        break;
      case "408":
        $res['UserDoesNotExist'] = true;
        break;
      default:
        break;
    };

    return $res;
  };

  function sentencify( $input ) {
    return ucfirst(strtolower(preg_replace('/(?<!^)([A-Z])/', ' \\1', $input)));
  };

  function showErrors ( $errors ) {
    echo "<ul id='errors'>";
    foreach( $errors as $error_message => $true) {
      if( $true ){
        echo "<li>";
        echo sentencify( $error_message );
        echo "</li>";
      };
    }
    echo "</ul>";
  };

  function changePassword(){
    echo "Changing password... <br/>";
    $newpwd = array(
      'password' => random_str(6, '0123456789')
    );
    $changepassword = AptiloCCSQuery( "modifyUser", $newpwd);
    #$phone = $forgetpassword['phonenumber'];//"+61422222222";
    #echo json_encode($changepassword);
  };

  function sendPassword( $newpwd, $phone ){
    $sendpassword = ClicksendSMSAPIQuery( "send", $phone, CAPTIVE_PORTAL_NAME.": Your new password is ".$newpwd);
    #echo json_encode($sendpassword);
    #echo json_encode( $sendpassword["data"]["messages"][0][status] );
    echo "New password has been sent to phone number ending with ", substr( $phone, -4);
  };
?>
