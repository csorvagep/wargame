<?php


if( !auth())
    tovabb("/login");

if(isset($PARAM) && is_numeric($PARAM))
{
    $user_id = $PARAM;
    if( !user_exists($user_id))
        throw new Exception("Nem létező felhasználó!");
}
else
{
    tovabb("/fooldal");
}

$CSS = array();
$CSS[] = "style/user.css";
$SCRIPT = array();

$TITLE = empty($user) ? htmlspecialchars("Felhasználónév") : get_uname_by_id($user_id);

require ("content/common/site_header.php");
require ("content/common/site_menu.php");

require ("content/common/level_round.php");
switch($level_round)
{
    case 1:
        $total_level = 10;
        break;

    case 2:
        $total_level = 20;
        break;

    case 3:
        $total_level = 30;
        break;

    default:
        $total_level = 10;
        break;
}
?>
<div id="content">
<p class="warn">
  <?
$user = array("username" => "", "avatar" => "", "level" => "", "full_name" => "", "sex" => "", "koli" => "", "szoba" => "", "ido" => "", "min" => "", "levelmin" => "", "max" => "", "levelmax" => "", "hint" => "", "lactive" => "", "msg" => "", );
$tmp = user_data($user_id);
if($tmp)
    $user = $tmp;
?>
</p>
  <div id="user_div">
    <div id="user_pic">
      <img src="/images/avatar/<?=$user["avatar"]; ?>" />
    </div>
    <div id="user_data">
      <p id="user_name">
        <?=empty($user) ? htmlspecialchars("<Felhasználónév>") : $user['username']; ?>
      </p>
      <p class="descrip">Megoldott feladatok:
        <? echo $user['level']."/".$total_level; ?>
      </p>
    </div>
    <table>
      <tbody>
        <tr>
          <td><p>Becenév:</p></td>
          <td class="user_values"><p><? echo empty($user) ? htmlspecialchars("<Teljes Név>") : $user['full_name']; ?></p></td>
        </tr>
        <tr class="even-row">
          <td><p>Nem:</p></td>
          <td class="user_values"><p><? echo empty($user)?htmlspecialchars("<Nem>"):($user['sex']?"Nő":"Férfi");?></p></td>
        </tr>
        <tr>
          <td><p>Kollégista:</p></td>
          <td class="user_values"><p><? echo empty($user)?htmlspecialchars("<Nem>"):($user['koli']?"Igen - szoba: {$user['szoba']}":"Nem");?></p></td>
        </tr>
        <tr class="even-row">
          <td><p>Eddig megoldással töltött idő:</p></td>
          <td class="user_values"><p><? echo empty($user) ? htmlspecialchars("<Idő>") : ($user['ido'] ? get_interval_string($user['ido']) : "Nem kezdte még el."); ?></p></td>
        </tr>
        <tr>
          <td><p>Leggyorsabban megoldott feladat:</p></td>
          <td class="user_values"><p><? echo empty($user) ? htmlspecialchars("<Level>") : ($user['min'] ? get_interval_string($user['min']) : "Nem kezdte még el."); ?></p></td>
        </tr>
        <tr class="even-row">
          <td><p>Leglassabban megoldott feladat:</p></td>
          <td class="user_values"><p><? echo empty($user) ? htmlspecialchars("<Level>") : ($user['max'] ? get_interval_string($user['max']) : "Nem kezdte még el."); ?></p></td>
        </tr>
        <tr>
          <td><p>Legutoljára aktív:</p></td>
          <td class="user_values"><p><? echo empty($user) ? htmlspecialchars("<Utolsó belépés>") : ($user['lactive'] ? date("Y. m. d. H:i", $user['lactive']) : "Nem lépett még be."); ?></p></td>
        </tr>
        <tr class="even-row">
          <td><p>Fórum hozzászólások:</p></td>
          <td class="user_values"><p><? echo empty($user) ? htmlspecialchars("<Hozzászólások>") : $user['msg'] . " db"; ?></p></td>
        </tr>
      </tbody>
    </table>
    <?
        if($_SESSION['id'] == $PARAM)
            echo "<p><a href=\"/settings\">Szerkesztés</a></p>";
			?>
  </div>
</div>
<?php
require ("content/common/site_footer.php");
?>