<form method="GET" action="<?php $PHP_SELF ?>">
<input type=checkbox name="test[]" value="0"/>
<input type=checkbox name="test[]" value="1"/>
<input type=checkbox name="test[]" value="16"/>
<input type="submit" value="Test-It"></td>
</form>

<?php
	print_r($_GET);
?>