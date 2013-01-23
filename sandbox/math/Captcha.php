<?php
header('Content-Type: image/png');
$Captcha;
$ID = isset($_GET["ID"]) ? intval($_GET["ID"]) : 479;

$Num = abs(-14 - $ID);
if($Num < 10)
{
    $Num += 75;
}
$Num = $Num + "";

$Num_1 = substr($Num, 0, 1);
$Num_2 = substr($Num, 1, 1);

if(isset($_GET["ID"]) && $ID == 479)
{
    $Captcha = imagecreatefrompng("16192bbfc0e673bbf2c7e1a0e2d703b1482765d0.png");
} else
{
    $Width = 306;
    $Height = 60;

    $Captcha = ImageCreate($Width, $Height);

    $White = ImageColorAllocate($Captcha, 255, 255, 255);
    $Black = ImageColorAllocate($Captcha, 0, 0, 0);
    $Grey = ImageColorAllocate($Captcha, 204, 204, 204);
    ImageFill($Captcha, 0, 0, $White);
    ImageString($Captcha, 5, 120, 20, "$Num_1 + $Num_2", $Black);
}

imagepng($Captcha);
imagedestroy($Captcha);
?>
