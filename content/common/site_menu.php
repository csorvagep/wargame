<div id="menu">
	<?php
	if($_SESSION['status'])
	{

	?>
	<p class="list">
		<a href="/level_list">Missions</a>
	</p>

<!--	<p class="list"><a href="/settings">Settings</a></p>
	<p class="list"><a href="/forum">Fórum</a></p> -->

	<?php
    }
    else
    {
	?>
	<p class="list">
		<a href="/login">Login</a>
	</p>
	<!--<p class="separator">
		<a href="/signup">Regisztráció</a>
	</p>--><?php
    }
?>
	<p class="separator">
		<a href="/users">Scoreboard</a>
	</p>
	<!--<p class="list">
		<a href="/stat">Statistics</a>
	</p>-->
	<p class="list">
		<a href="/rules">Rules</a>
	</p>
	<p class="list">
		<a href="/about-us">About Us</a>
	</p>
<!--	<p class="list">
		<a href="/links">Links</a>
</p>-->

	<?php if($_SESSION['status']) {
	?>
	<p class="separator" id="kilep">
		<a href="/logoff">Sign Out</a>
	</p>
	<?php } ?>
</div>
