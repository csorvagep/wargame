<tr class="forum_content">
  <td width="5%" class="forum_edit"><img src="/images/kitty.png" border="0" /></td>
  <td width="45%" class="forum_name"><p><a href="/forum/<?=$topic_id;?>"><?=$name;?></a></p></td>
  <td width="10%" class="forum_hsz"><p><?=$sum;?> db</p></td>
  <td width="20%" class="forum_own"><p><? if($last_uid) { ?><a href="/user/<?=$last_uid;?>"><? } echo $last_user; if($last_uid) { ?></a><? } ?><br /><?=date("Y.m.d. H:i",$last_time);?></p></td>
  <td width="20%" class="forum_own"><p><a href="/user/<?=$owner_id;?>"><?=$owner;?></a><br /><?=date("Y.m.d. H:i",$time);?></p></td>
</tr>
