<?php
  function SCGQuery( $Category, $Type ) {

    $SCG_login_params = array(
      "Vendor" => "ruckus",
      "RequestPassword" => NAC_API_PASSWORD,
      "APIVersion" => "1.0",
      "RequestCategory" => $Category,
      "RequestType" => $Type,
      "UE-IP" => sanitize($_POST["ip"]),
      "UE-MAC" => sanitize($_POST["mac"])
    );

    switch($Category) {
      case "UserOnlineControl":
        switch($Type) {
          case "Login":
            $SCG_login_params["UE-Proxy"] = "0" ;
            $SCG_login_params["UE-Username"] = sanitize($_POST["username"]);
            $SCG_login_params["UE-Password"] = sanitize($_POST["password"]);
            break;
        };
    };


    echo json_encode($SCG_login_params);

    $ch = curl_init( NAC_API_BASE_URI );
    # Setup request to send json via POST.
    $payload = json_encode( $SCG_login_params );
    curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
    curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
    # Return response instead of printing.
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
    # Send request.
    $result = curl_exec($ch);
    #curl_close($ch);

    return json_decode( $result, true);
  };
?>
