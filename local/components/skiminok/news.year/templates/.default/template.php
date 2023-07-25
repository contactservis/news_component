<?php 
/* 
 * шаблон компоненнта новостей с вкладками
*/
?>
<style>
body {font-family: Arial;}

/* Style the tab */
.tab {
    overflow: hidden;
    border: 1px solid #ccc;
    background-color: #f1f1f1;
}

/* Style the buttons inside the tab */
.tab button {
    background-color: inherit;
    float: left;
    border: none;
    outline: none;
    cursor: pointer;
    padding: 14px 16px;
    transition: 0.3s;
    font-size: 17px;
}

/* Change background color of buttons on hover */
.tab button:hover {
    background-color: #ddd;
}

/* Create an active/current tablink class */
.tab button.active {
    background-color: #ccc;
}

/* Style the tab content */
.container-news:first-of-type {
        display: block !important;
   }
.tabcontent {
    display: none;
    padding: 6px 12px;
    border: 1px solid #ccc;
    border-top: none;
}

</style>
<div class="tab">
    <? foreach($arResult['ITEMS'] as $key => $item) {?>
        <button class="tablinks active" onclick="openTab(event, <?=$key?>)"><?=$key?></button>
    <?}?>
</div>
<div class="container-news">
<? foreach($arResult['ITEMS'] as $key => $item) {?>
    <div id="<?=$key?>" class="tabcontent" <? if($key == '2023') echo 'style="display:block;"' ?>>
        <? foreach($item[0] as $new){?>
            <div class="tabcontent-new">
                <h3><?=$new['NAME']?></h3>
                <p><?=FormatDate("d F Y", MakeTimeStamp($element['ACTIVE_FROM']))?></p>
                <p><?=$new['PREVIEW_TEXT']?></p>
            </div>
        <?}?>
    </div>
<?}?>
</div>
<pre><?print_r($arResult['ITEMS'])?></pre>