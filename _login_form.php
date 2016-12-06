<form method="POST">
  <label for="username">Username</label>
	<input type="text" name="username" id="username" class="input" required="required" /><br />
	<label for="password">Password</label>
	<input type="password" name="password" id="password" class="input" required="required" /><br />
  <input type="hidden" name="ip" id="ip" value="<?php echo $vars["ip"]; ?>"></input>
  <input type="hidden" name="mac" id="mac" value="<?php echo $vars["mac"]; ?>"></input>
	<input type="submit" value="Get Internet Access" class="button"><br />
</form>
