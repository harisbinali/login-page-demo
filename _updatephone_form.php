<?php
  if( $login['ResponseCode'] === "200" ) {
    echo '<form method="POST">';
    echo '  <label for="phone">Your phone number needs to be updated</label>';
    echo '	<input type="text" name="phone" id="phone" class="input" required="required" /><br />';
    echo '  <input type="hidden" name="username" id="username" value="'.sanitize($_POST['username']).'"/><br />';
    echo '  <input type="hidden" name="action" id="action" value="updatephone" />';
    echo '	<input type="submit" value="Update Phone Number" class="button"><br />';
    echo '</form>';
  };
?>
