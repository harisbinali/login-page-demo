<?php
  function SCGQuery( $Category, $Type ) {

    $SCG_login_params = array(
      "Vendor" => "ruckus",
      "RequestPassword" => NAC_API_PASSWORD,
      "APIVersion" => "1.0",
      "RequestCategory" => $Category,
      "RequestType" => $Type,
      "UE-IP" => $_POST["ip"],
      "UE-MAC" => $_POST["mac"]
    );

    switch($Category) {
      case "UserOnlineControl":
        switch($Type) {
          case "Login":
            $SCG_login_params["UE-Proxy"] = "0" ;
            $SCG_login_params["UE-Username"] = $_POST["username"];
            $SCG_login_params["UE-Password"] = $_POST["password"];
            break;
        };
    };


    #echo json_encode($SCG_login_params);

    $ch = curl_init( NAC_API_BASE_URI );
    # Setup request to send json via POST.
    $payload = json_encode( sanitize( $SCG_login_params ) );
    curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
    curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
    # Return response instead of printing.
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
    # Send request.
    $result = curl_exec($ch);
    curl_close($ch);

    return json_decode( $result, true);
  };

  function AptiloCCSQuery ( $method, $args = Array() ) {
    $CCS_API_params = array(
      "method" => $method,
      "login" => CCS_API_USERNAME,
      "pwd" => CCS_API_PASSWORD
    );

    switch($method) {
      case "viewUser":
        $CCS_API_params['username'] = $_POST["username"];
        break;
      case "modifyUser":
        $CCS_API_params['username'] = $_POST["username"];
        $CCS_API_params = array_merge( $CCS_API_params, $args );
        break;
      default:
        break;
    };

    $ch = curl_init( CCS_API_BASE_URI );
    $payload = http_build_query(sanitize($CCS_API_params));
    curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
    $result = curl_exec($ch);
    curl_close($ch);

    #echo $method;
    #echo json_encode($CCS_API_params)."<br/>";

    $output = [];

    parse_str( $result, $output );
    #$output['phonenumber'] = "";
    $output = sanitize($output);
    $output['errors'] = validateAptiloCCSQuery( $output );

    #if( $output['uname'] and !$output['errors']['PhoneNumberDoesNotExist'] ) $output['phonenumber'] = "+".$output['phonenumber'];

    #echo $result;
    #echo json_encode($output)."<br />";

    return $output;
  }

  function ClicksendSMSAPIQuery( $action = "send", $recipient = "", $message = "" ){
    $url = SMS_API_BASE_URI."sms/".$action;


    $SMS_auth = "Authorization: Basic ".base64_encode( SMS_API_USERNAME.":".SMS_API_PASSWORD );

    switch( $action ){
      case "send":
        $SMS_message['from'] = substr( str_replace( " ", "", CAPTIVE_PORTAL_NAME ), 0, 11 );
        $SMS_message['source'] = CAPTIVE_PORTAL_NAME;
        $SMS_message['to'] = $recipient;
        $SMS_message['body'] = $message;
        $SMS_messages = array( $SMS_message );
        $SMS_params = array( "messages" => $SMS_messages );
        break;
      default:
        break;
    };

    #echo $url;
    #echo json_encode($SMS_params);
    #echo $SMS_auth;
    $ch = curl_init( $url );
    # Setup request to send json via POST.
    $payload = json_encode( $SMS_params );
    #echo $payload;
    curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
    curl_setopt( $ch, CURLOPT_HTTPHEADER, array(
        'Content-Type:application/json',
        $SMS_auth
      ));
    # Return response instead of printing.
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
    # Send request.
    $result = curl_exec($ch);
    curl_close($ch);

    #echo $result;

    return json_decode( $result, true);
  };
?>
