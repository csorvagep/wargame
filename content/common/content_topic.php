<div id="content">
  <h3>
    <?=$topic['name'];?>
  </h3>
  <?
foreach ($msg as $h)
{
	echo "<p id=\"warn\">$h</p>";
}
?>
  <p><a href="/forum">Vissza a fórumba</a></p>
  <div id="topic">
    <?php topic($topic_id,$page); ?>
  </div>
  <div id="topic_text">
    <form action="<?=$_SERVER['REQUEST_URI'];?>" method="post" name="addcom">
      <textarea name="msg"></textarea>
      <input type="submit" value="Elküld" name="eset" id="sub" />
    </form>
    <div id="topic_header">
      <ul>
        <li>
          <input type="button" value="bold" id="button_bold" onclick="insertTag('[b]','[/b]')" />
        </li>
        <li>
          <input type="button" id="button_italic" value="italic" onclick="insertTag('[i]','[/i]')" />
        </li>
        <li>
          <div id="emo"> <img src="/images/smile/smile.png" />
            <ul id="smile">
              <li><a href=":-)"><img src="/images/smile/smile.png" /></a></li>
              <li><a href=":-D"><img src="/images/smile/laugh.png" /></a></li>
              <li><a href=":-("><img src="/images/smile/sad.png" /></a></li>
              <li><a href=":-P"><img src="/images/smile/tongue.png" /></a></li>
              <li><a href=";-)"><img src="/images/smile/wink.png" /></a></li>
              <li><a href=":-o"><img src="/images/smile/surprised.png" /></a></li>
              <li><a href=":-$"><img src="/images/smile/embarassed.png" /></a></li>
              <li><a href=":\'("><img src="/images/smile/cry.png" /></a></li>
              <li><a href=":-/"><img src="/images/smile/undecided.png" /></a></li>
              <li><a href="(a)"><img src="/images/smile/angel.png" /></a></li>
              <li><a href="(h)"><img src="/images/smile/cool.png" /></a></li>
              <li><a href="(y)"><img src="/images/smile/yell.png" /></a></li>
            </ul>
          </div>
        </li>
        <li>
          <div id="link">
            <p>link</p>
            <div id="link_div">
              <form id="addlink">
                <p>Hivatkozás:</p>
                <input type="text" name="ref" value="http://" />
                <p>Szöveg:</p>
                <input type="text" name="link" />
                <input type="submit" value="Ok" />
              </form>
            </div>
          </div>
        </li>
      </ul>
    </div>
  </div>
</div>
