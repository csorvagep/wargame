<html>
<head>
<title>PHPMailer - SMTP advanced test with authentication</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>

<?php

require_once('class.phpmailer.php');

$mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch

$mail->IsSMTP(); // telling the class to use SMTP

try {
  $mail->SMTPDebug  = 1;                     // enables SMTP debug information (for testing)
  $mail->SMTPAuth   = true;                  // enable SMTP authentication
  $mail->Host       = "mail.sch.bme.hu"; // sets the SMTP server
  $mail->Port       = 25;                    // set the SMTP port for the GMAIL server
  $mail->Username   = "csorvagep@sch.bme.hu"; // SMTP account username
  $mail->Password   = "";        // SMTP account password
  $mail->AddReplyTo('chimera@sch.bme.hu', 'Chimera');
  $mail->CharSet	= "utf-8";
  $mail->AddAddress('csorvagep@gmail.com', 'Csorvási Gábor');
  $mail->SetFrom('chimera@sch.bme.hu', 'Chimera');
  $mail->Subject = 'PHPMailer Test Subject via mail(), advanced';
  $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically
  $mail->MsgHTML(file_get_contents('contents.html'));
  $mail->Send();
  echo "Message Sent OK</p>\n";
} catch (phpmailerException $e) {
  echo $e->errorMessage(); //Pretty error messages from PHPMailer
} catch (Exception $e) {
  echo $e->getMessage(); //Boring error messages from anything else!
}
?>

</body>
</html>
