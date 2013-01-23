<div id="pagelist">

    <? if($page != 1) { ?>
    <div class="pageno<?=$page==1?" actual":"";?>">	
        <a href="<?=($link."?page=".($page-1));?>">&lt;&lt; Előző</a>
    </div>
	<? } ?>
    
    <? for($i=1;$i<=$sum_page;$i++) { ?>
    <div class="pageno<?=$page==$i?" actual":"";?>">
		<? if($page != $i) { ?>
        <a href="<?=$link."?page=".$i;?>"><? } ?>
			<? echo $i; if($page != $i) { ?></a><? } ?>
    </div>
    <? } ?>
    
    <? if($page != $sum_page) { ?>
    <div class="pageno<?=$page==$sum_page?" actual":"";?>">
        <a href="<?=($link."?page=".($page+1));?>">Következő &gt;&gt;</a>
    </div>
	<? } ?>

</div>