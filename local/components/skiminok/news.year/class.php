<?php 
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Loader;
use Bitrix\Iblock\ElementTable;
use Bitrix\Main\Context;

/* 
* news_year - класс выбирает новости и ормирует массив по году 
*/
class news_year extends CBitrixComponent {

  public function onPrepareComponentParams($arParams){
    $result = array(
      "CACHE_TYPE"    => $arParams["CACHE_TYPE"],
      "IBLOCK_ID"     => $arParams["IBLOCK_ID"],
      "PAGE_COUNT"    => $arParams["PAGE_COUNT"],
    );
    return $result;
  }
  
    /**
   * getArrNews 
   *
   * @return $arNews
   */
  private function getArrNews(){
    $arNews = $this->getSortNews();
    return $arNews;
  }

  /**
   * getSortNews - метод получает все новости и сортирует их по годам и страницам
   *
   * @return void
   */
  private function getSortNews(){
    Loader::includeModule('iblock');

    $elements = ElementTable::getList([
        'select' => ['*'],
        'filter' => ['IBLOCK_ID' => $this->arParams["IBLOCK_ID"]],
    ])->fetchAll();
    
    $groupedElements = [];
    $pageCount = (int)$this->arParams["PAGE_COUNT"];
    $page = 0;
    $i = 0;
    foreach($elements as $element) {
      $date = FormatDate("Y", MakeTimeStamp($element['ACTIVE_FROM']));
      $groupedElements[$date][$page][] = $element;
      $i++;
      if($i == $pageCount) { 
        $i=0; 
        $page++;
      }
    }

    return $groupedElements;
  }

  function executeComponent(){
    $arNews = $this->getArrNews();
    /**
     * для навигации в табах используем ajax и получим только страницу со вкладки
    */
    $request = Context::getCurrent()->getRequest();
    if($request->isAjaxRequest()){
      $arrPost = $request->getPostList()->toArray();   
      $this->arResult['ITEMS'] = $arNews[$arrPost['year']][$arrPost['page']];
      $this->IncludeComponentTemplate('ajax');
      return $this->arResult;
    }else{
      $this->arResult['ITEMS'] = $arNews;
      $this->IncludeComponentTemplate();
      return $this->arResult;
    }
    
  }
}
