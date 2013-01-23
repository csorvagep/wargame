<?
$users = array();
$sql = "SELECT users.user_id, username, SUM(finish-start) as s, COUNT(level) as c
	FROM levelstat INNER JOIN users ON users.user_id = levelstat.user_id
	WHERE admin = 0 and finish > 0
	GROUP BY users.user_id
	ORDER BY c desc, s asc";
$result = $mysqli->query($sql);
while($arr = $result->fetch_row())
{
	$users[$arr[0]]["username"] = $arr[1];
	$users[$arr[0]]["time"] = $arr[2];
	$users[$arr[0]]["level"] = $arr[3];	
}

// // Obtain a list of columns
// foreach($users as $key => $row)
// {
	// $time[$key] = $row['time'];
	// $levels[$key] = $row['level'];
// }
// 
// // Sort the data with volume descending, edition ascending
// // Add $data as the last parameter, to sort by the common key
// array_multisort($levels, SORT_DESC, $time, SORT_ASC, $users);
// 

$CSS = array();
$CSS[] = "style/stat.css";
$SCRIPT = array();

$TITLE = "Users";

require ("content/common/site_header.php");
require ("content/common/site_menu.php");
?>
<div id="content">
	<table style="width: 650px; margin: 0 auto;">
		<tr>
			<td width="5%"></td><td width="55%">Username</td><td width="20%">Completed Missions</td><td width="20%">Total Time</td>
		</tr>
		<?
		$i=0;
		foreach($users as $elem)
		{
			if($i % 2)
				$cat = " class='even-row'";
			else
				$cat = "";

			echo "<tr{$cat}>";
			echo "<td>" . ($i + 1) . "</td>";
			echo "<td>{$elem['username']}</td>";
			echo "<td style='text-align:center;'>{$elem['level']}</td>";
			echo "<td style='text-align:center;'>" . get_interval_string($elem['time']) . "</td>";
			echo "</tr>";
			$i++;
		}
	?>
</table>

</div>
<?
require ("content/common/site_footer.php");
?>