<?

auth();

$CSS = array();
$CSS[] = "style/about.css";
$SCRIPT = array();

$TITLE = "About Us";

require ("content/common/site_header.php");
require ("content/common/site_menu.php");
?>

<div id="content">
	<h1>About Us</h1>
	<img src="/images/logo_front.png" style="width: 130px; margin: 5px;" id="logo" />
	<h2>Who are we?</h2>
	<p class="first-line">
		We are members of the IT department in the Simonyi Károly College For Advanced Studies at BUTE. We are responsible for the security of our system, and deal with security issues in general.
		We organize workshops and lectures for people interested. We take parts at events we think we should and do what we think we should.
	</p>
	<h2>This game was brought to you by:</h2>
	<table id="list">
		<tr>
			<td>Name</td>
			<td>Nickname</td>
			<td>Position</td>
			<td>Jobs</td>
		</tr>
		<tr>
			<td>Csorvási Gábor</td>
			<td>CsorvaGep</td>
			<td>Member</td>
			<td>Main developer, missions, admin, other.</td>
		</tr>
		<tr class="even-row">
			<td>Rajtmár Ákos</td>
			<td>westerneer</td>
			<td>Member</td>
			<td>Missions, coordination, contact.</td>
		</tr>
		<tr>
			<td>Molnár Marcell</td>
			<td>Husi</td>
			<td>Team Leader</td>
			<td>Missions, coordination, contact, other</td>
		</tr>
		<tr class="even-row">
			<td>Kvanduk Bíborka</td>
			<td>Bibi</td>
			<td>Member</td>
			<td>Coordination, support, other.</td>
		</tr>
		<tr>
			<td>Máté Péter</td>
			<td>Mpeti</td>
			<td>Member</td>
			<td>Missions, debug, testing.</td>
		</tr>
		<tr class="even-row">
			<td>Bene Máté</td>
			<td>Máté</td>
			<td>Newbie</td>
			<td>Missions, testing</td>
		</tr>
		<tr>
			<td>Ács-Kurucz Gábor</td>
			<td>AKG</td>
			<td>Member</td>
			<td>Debug, testing, missions.</td>
		</tr>
		<tr class="even-row">
			<td>Kiss Dani</td>
			<td>Segal</td>
			<td>Member</td>
			<td>Missions, debug.</td>
		</tr>
		<tr>
			<td>Ládi Gergő</td>
			<td>Battleguard</td>
			<td>Member</td>
			<td>Missions, debug.</td>
		</tr>
		<tr class="even-row">
			<td>Kalmár Balázs</td>
			<td>Choy</td>
			<td>Member</td>
			<td>Missions, debug, admin.</td>
		</tr>
	</table>
	<p>
		<br />
		In association with Kancellar.hu who provided us with necessary hardware and technical help.
	</p>
	<img src="/images/logo_simonyi.png" style="height: 110px; background-color: white;" /><img src="/images/logo.png" style="height: 110px; background-color: white;" />

</div>
<?
require ("content/common/site_footer.php");
?>
