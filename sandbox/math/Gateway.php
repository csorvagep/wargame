<?php
$OK = -1;

if(!empty($_POST))
{
    $ID = isset($_POST["CaptchaID"]) ? intval($_POST["CaptchaID"]) : 479;

    $Num = abs(-14 - $ID);
    if($Num < 10)
    {
        $Num += 75;
    }
    $Num = $Num + "";

    $Num_1 = substr($Num, 0, 1);
    $Num_2 = substr($Num, 1, 1);

    if(intval($_POST["Captcha"]) == (intval($Num_1) + intval($Num_2)))
    {
        $OK = 1;
    } else
	{
		$OK = 0;
	}
}

if($OK == 1)
{
    // Kész a feladat
	die("W4RG3ME");
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
        <meta http-equiv="Content-language" content="en" />
        <title>Secure Gateway</title>
    </head>
    <body style="background-color: #000; color: #fff;">
        <div style="width: 306px; margin: 20% auto;">
<?php if(!$OK){ echo("            <div style=\"text-align: center;\"><p style=\"color: #f00; \">Hmm. No, that doesn’t seem to be correct.</p></div>");} ?>
            <img src="Captcha.php?ID=479" alt="" /> <br />
            <div style="text-align: center">
                <form method="POST" action="Gateway.php">
                    <label for="Captcha">Results of the above calculation:</label> <br />
                    <input type="text" name="Captcha" value=""></input> <br />
                    <input type="hidden" name="CaptchaID" value="479"></input><br />
                    <input type="submit" value="Enter"></input>
                </form>
            </div>
        </div>
    </body>
</html>