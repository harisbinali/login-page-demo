<form method="POST">
  <label for="phone">Your phone number needs to be updated</label>
	<input type="text" name="phone" id="phone" class="input" required="required" /><br />
  <input type="hidden" name="username" id="username" value="<?php echo sanitize($_POST['username']); ?>"/><br />
  <input type="hidden" name="action" id="action" value="updatephone" />
	<input type="submit" value="Update Phone Number" class="button"><br />
</form>
