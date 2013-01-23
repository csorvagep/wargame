<?

/* Gathering data for statistics */

/* Gather the users to the $users array */
$users = array();
$sql = "SELECT user_id, username
    FROM `users`,
        (SELECT COUNT(id) AS c, user_id AS u FROM levelstat GROUP BY user_id HAVING c > 0) s
    WHERE s.u=users.user_id AND admin = 0";
if(!$result = $mysqli->query($sql))
	throw new Exception("SQL Error: " . $mysqli->error);
while($row = $result->fetch_row())
{
	$users[$row[0]]["username"] = $row[1];
	$users[$row[0]]["user_id"] = $row[0];
	$users[$row[0]]["score"] = 0;
	$users[$row[0]]["time"] = 0;
	$users[$row[0]]["levels"] = 0;
}

/* Gather the number of the finished levels */
$sql = "SELECT users.user_id, COUNT(levelstat.id) FROM levelstat INNER JOIN users ON users.user_id = levelstat.user_id WHERE levelstat.finish <> 0 AND users.admin = 0 GROUP BY users.user_id";
if(!$result = $mysqli->query($sql))
	throw new Exception("SQL Error: " . $mysqli->error);
while($row = $result->fetch_row())
{
	$users[$row[0]]["score"] += $row[1];
	$users[$row[0]]["levels"] += $row[1];
}

/* Gather the positions */
$sql = "SELECT level FROM levels";
if(!$result = $mysqli->query($sql))
	throw new Exception("SQL Error: " . $mysqli->error);

while($row = $result->fetch_row())
{
	$sql2 = sprintf("SELECT users.user_id, levelstat.finish
                     FROM levelstat
                        INNER JOIN users
                        ON users.user_id = levelstat.user_id
                     WHERE levelstat.level = '%s'
                        AND levelstat.finish <> 0
                        AND admin = 0
                     ORDER BY levelstat.finish ASC
                     LIMIT 25", $row[0]);
	if(!$result2 = $mysqli->query($sql2))
		throw new Exception("SQL Error: " . $mysqli->error);

	$i = 0;
	while($row2 = $result2->fetch_row())
	{
		$pont = 5 - floor($i / 5);
		$users[$row2[0]]["score"] += $pont;
		$i++;
	}

	$sql2 = sprintf("SELECT users.user_id, (levelstat.finish-levelstat.start) AS t
                    FROM levelstat
                        INNER JOIN users
                        ON users.user_id=levelstat.user_id
                    WHERE levelstat.finish <> 0
                        AND levelstat.level = '%s'
                        AND users.admin = 0
                    ORDER BY t ASC", $row[0]);
	if(!$result2 = $mysqli->query($sql2))
		throw new Exception("SQL Error: " . $mysqli->error);

	$row2 = $result2->fetch_row();
	if($row2)
	{
		$users[intval($row2[0])]["score"] += 1;
	}

}

/* Extra score for the fastest solution */
$sql = "SELECT users.user_id, SUM(levelstat.finish-levelstat.start) FROM levelstat INNER JOIN users ON users.user_id = levelstat.user_id WHERE finish <> 0 AND users.admin = 0 GROUP BY user_id";
if(!$result = $mysqli->query($sql))
	throw new Exception("SQL Error: " . $mysqli->error);
while($row = $result->fetch_row())
{
	$users[$row[0]]["time"] += $row[1];
}

/* Gather extra score */
$sql = "SELECT user_id, COUNT(id) FROM levelstat WHERE level = '9-9' GROUP BY user_id";
if(!$result = $mysqli->query($sql))
	throw new Exception("SQL Error: " . $mysqli->error);
while($row = $result->fetch_row())
{
	$users[$row[0]]["score"] += $row[1];
}

// Obtain a list of columns
foreach($users as $key => $row)
{
	$score[$key] = $row['score'];
	$time[$key] = $row['time'];
	$levels[$key] = $row['levels'];
}

// Sort the data with volume descending, edition ascending
// Add $data as the last parameter, to sort by the common key
array_multisort($score, SORT_DESC, $levels, SORT_DESC, $time, SORT_ASC, $users);

$CSS = array();
$CSS[] = "style/stat.css";
$SCRIPT = array();

$TITLE = "Statisztika";

require ("content/common/site_header.php");
require ("content/common/site_menu.php");
?>
<div id="content">
	<h2>Statisztika</h2>
	<p>
		Felhasználók száma: <strong> <? $sql = "SELECT COUNT(*) FROM users WHERE admin = 0";
		$eredmeny = $mysqli->query($sql);
		$sor = $eredmeny->fetch_row();
		echo $sor[0];
		?> </strong>
		<br />
		Elfogadott megoldások: <strong>
		<?
		$sum_level = 0;
		$cnt = 0;
		foreach($users as $elem)
		{
			$sum_level += $elem['levels'];
			$cnt++;
		}
		echo $sum_level;
		?></strong>
		<br />
		Átlagosan megoldott feladatok száma: <strong> <?=round($sum_level / $cnt, 2); ?> </strong>
		<br />
	</p>
	<div id="top10">
		<h4>Top 50</h4>
		<table>
			<tr>
				<td></td>
				<td>Játékos</td>
				<td>Feladatok</td>
				<td>Idő</td>
				<td>Pont</td>
			</tr>
			<?
			$i = 0;
			foreach($users as $elem)
			{
				if($i < 50)
				{
					if($i++ % 2)
						echo "<tr>";
					else
						echo "<tr class=\"even-row\">";
					echo "<td>$i</td>";
					echo "<td><a href='/user/{$elem['user_id']}'>{$elem['username']}</a></td>";
					echo "<td>{$elem['levels']}</td>";
					echo "<td>" . get_interval_string($elem['time']) . "</td>";
					echo "<td>{$elem['score']}</td>";
					echo "</tr>";
				}
			}
			?>
		</table>
	</div>
	<div id="levels">
		<h4>Megoldási idők</h4>
		<table>
			<tr>
				<td>Level</td>
				<td>Átlag idő</td>
				<td>Megoldások</td>
			</tr>
			<? $sql = "SELECT levelstat.level, ROUND(AVG(levelstat.finish-levelstat.start)), COUNT(levelstat.id) AS cnt FROM levelstat INNER JOIN users ON levelstat.user_id = users.user_id WHERE levelstat.finish <> 0 AND users.admin = 0 GROUP BY level ORDER BY cnt DESC";
				$eredmeny = $mysqli->query($sql);
				$i = 0;
				while($sor = $eredmeny->fetch_row())
				{
					if($i % 2)
						echo "<tr>";
					else
						echo "<tr class=\"even-row\">";
					echo "<td>{$sor[0]}</td>";
					echo "<td>" . get_interval_string($sor[1]) . "</td>";
					echo "<td>{$sor[2]}</td>";
					echo "</tr>";
					$i++;
				}
			?>
		</table>
	</div>
</div>
<?
require ("content/common/site_footer.php");
?>