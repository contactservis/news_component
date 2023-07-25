<?php 
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
?>
<? foreach($arResult['ITEMS'] as $new){?>
    <div class="tabcontent-new">
        <h3><?=$new['NAME']?></h3>
        <p><?=FormatDate("d F Y", MakeTimeStamp($element['ACTIVE_FROM']))?></p>
        <p><?=$new['PREVIEW_TEXT']?></p>
    </div>
<?}?>