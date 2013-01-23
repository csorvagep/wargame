<div class="topic_message">
  <div class="topic_image"><img src="/images/avatar/<?=$avatar;?>" class="topic_avatar" />
    <p class="topic_name">
      <?=$username;?>
    </p>
  </div>
  <div class="topic_head">
    <p>
      <? if($uid) { ?><a href="/user/<?=$uid;?>"><? } echo $username; if($uid) { ?></a><? }?> | <?=date("Y.m.d. H:i", $time);?> |<? if(isadmin()){ ?>
      <a href="/forum/<?=$tp;?>?torol=<?=$id;?>&page=<?=$oldal;?>" style="color:#d60100" onclick="return confirm('Ez az üzenet törlődni fog!!!')">Törlés</a>  |
      <? } ?>
      <a href="#" onclick="valasz('<?=$username;?>',<?=$i;?>); return false;">Válasz</a> #
      <?=$i;?>
    </p>
  </div>
  <div class="topic_content">
    <p>
      <?=trim(bb_decode($msg));?>
    </p>
  </div>
</div>