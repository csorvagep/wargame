<?
$msg = array();

if(isset($_POST['email']))
{	
	$email = $_POST['email'];
	
	if($email != "webmester@wargame.sch.bme.hu")
	{
		require_once('content/includes/mail/class.phpmailer.php');
		try
		{
			$mail = new PHPMailer(true);
			
			$mail->IsSMTP();
			$mail->SMTPAuth   = false;
			$mail->Host       = "mail.sch.bme.hu";
			$mail->Port       = 25;
			$mail->CharSet	= "utf-8";
			$mail->AddAddress($_POST['email']);
			$mail->SetFrom('reminder@wargame.sch.bme.hu', 'Jelszó emlékeztető');
			$mail->Subject = 'Webmester jelszó emlékeztető';
			$mail->AltBody = 'Kedves Elek!\n\n A jelszavad: elek123';
			$mail->MsgHTML(file_get_contents('levels/include/2_contents.html'));
			$mail->Send();
		}
		catch(Exception $ex)
		{
			$msg[] = $ex->getMessage();
		}
	}
}
else
{
	tovabb("/level/2");
}
$TITLE = "Jelszó emlékeztető";
require("content/common/site_rheader.php");
?>
<div id="content">
<h2>Jelszó emlékeztető elküldve!</h2>
<p><a href="/level/2/">Vissza a feladathoz!</a></p>
</div>
<?
require("content/common/site_rfooter.php");
?>