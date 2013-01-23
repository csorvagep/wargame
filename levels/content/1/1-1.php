<?
    if(isset($_POST['email']) && $_POST['email'] != "web.elek@somemail.net")
    {
?>
<span style="color: yellowgreen;">You have one new message:</span>
<div class="mailform">
	<p>
		<b>From:</b> Webmaster
		<br />
		<b>Sent:</b><? echo date(" l, F d, Y g:i A"); ?>
		<br />
		<b>To:</b> <? echo htmlspecialchars($_POST['email']); ?>
		<br />
		<b>Subject:</b> Admin password
	</p>
	<h4>Hi</h4>
	<p>
		Your very secret password is: <b>elek123</b>
	</p>
	<p>
		Webmater
	</p>
</div>
<?
}
else
{
?>
<form action="<?=$_SERVER['REQUEST_URI']; ?>" method="post">
	<p style="text-align:center;">
		<input type="hidden" name="email" value="web.elek@somemail.net" />
		<input type="submit" value="Password reminder!" />
	</p>
</form>
<?
}
?>