<?
$TITLE = "Result";
require("../content/common/site_rheader.php");
?>
<div id="content">
<h2>Result</h2>
<pre>
<?
$command = explode(" ", $_REQUEST["command"]);
if(count($command) < 2)
	$cmd = $command[0];
else
	list($cmd, $param) = explode(" ", $_REQUEST["command"]);

$param1 = $_REQUEST["elso"];
$op = $_REQUEST["lista1"];
$param2 = $_REQUEST["masodik"];

switch ($cmd)
{
	case "date":
		system("date");
	break;

	case "ls":
		require("ls.txt");
	break;

	case "cat":
		if(!isset($param))
			$param = "";
		switch ($param)
		{
			case "8_calc.php":
				echo "cat: calc.php: Permission denied";
			break;
			
			case "index.php":
				echo "cat: index.php: Permission denied";
			break;
			
			case "8_feldolgoz.php":
				echo "cat: feldolgoz.php: Permission denied";
			break;

			case "/etc/passwd":
				require("passwd");
			break;

			case "/etc/shadow":
				require("shadow");
			break;
			
			default:
				echo "cat {$param}: No such file or directory";
			break;
		}
	break;

    case "bc":
		echo "<b>The result of the equation:</b><br />";
		switch($op)
		{
			case "+":
				echo $param1+$param2;
				//system("echo \"$param1 + $param2\" | bc");
			break;

			case "-":
				echo $param1-$param2;
				//system("echo \"$param1 - $param2\" | bc");
			break;

			case "*":
				echo $param1*$param2;
				//system("echo \"$param1 * $param2\" | bc");
			break;

			case "%":
				echo $param1%$param2;
				//system("echo \"$param1 % $param2\" | bc");
			break;

			case "/":
				echo (int)$param1/$param2;
				//system("echo \"$param1 / $param2\" | bc -l");
			break;
		}
	break;
	
	default:
		echo "bash: ".$cmd.": not found\n";
	break;
}
?>
</pre>
</div>
<?
require("../content/common/site_rfooter.php");
?>