<?

$TITLE = "Calculator";
require("../content/common/site_rheader.php");
?>
<div id="content">
  <h2>World's fastest enterprise calculator</h2>
  <form action="8_feldolgoz.php" method="get">
    <p>
      <input type="hidden" name="command" value="bc">
      <input type="text" name="elso">
      <select name="lista1" size="1">
        <option value="+"> + </option>
        <option value="-"> - </option>
        <option value="*"> * </option>
        <option value="/"> / </option>
        <option value="%"> % </option>
      </select>
      <input type="text" name="masodik">
    </p>
    <p>
      <input type="submit" name="gomb1" value="Calculate">
    </p>
  </form>
</div>
<?
require("../content/common/site_rfooter.php");
?>