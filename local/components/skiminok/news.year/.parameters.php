<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if (!CModule::IncludeModule("iblock")) return;

$arTypesEx 			= CIBlockParameters::GetIBlockTypes(["-" => " "]);
$db_iblock 			= CIBlock::GetList(
	["SORT" => "ASC"],
	[
		"SITE_ID" 	=> $_REQUEST["site"],
		"TYPE" 		=> ($arCurrentValues["IBLOCK_TYPE"] != "-" ? $arCurrentValues["IBLOCK_TYPE"] : "")
	]
);
$rsProp 			= CIBlockProperty::GetList(
	["sort" => "asc", "name" => "asc"],
	[
		"ACTIVE" 	=> "Y",
		"IBLOCK_ID" => (isset($arCurrentValues["IBLOCK_ID"]) ? $arCurrentValues["IBLOCK_ID"] : $arCurrentValues["ID"])
	]
);
$arSorts 			= ["ASC" => GetMessage("T_IBLOCK_DESC_ASC"), "DESC" => GetMessage("T_IBLOCK_DESC_DESC")];
$arSortFields 		= [
	"ID" 			=> GetMessage("T_IBLOCK_DESC_FID"),
	"NAME" 			=> GetMessage("T_IBLOCK_DESC_FNAME"),
	"ACTIVE_FROM" 	=> GetMessage("T_IBLOCK_DESC_FACT"),
	"SORT" 			=> GetMessage("T_IBLOCK_DESC_FSORT"),
	"TIMESTAMP_X" 	=> GetMessage("T_IBLOCK_DESC_FTSAMP")
];
$arIBlocks 			= [];
$arProperty_LNS 	= [];

while ($arRes = $db_iblock->Fetch()) {
	$arIBlocks[$arRes["ID"]] = "[".$arRes["ID"]."] ".$arRes["NAME"];
}

while ($arr = $rsProp->Fetch()) {
	$arProperty[$arr["CODE"]] = "[".$arr["CODE"]."] ".$arr["NAME"];

	if (in_array($arr["PROPERTY_TYPE"], ["L", "N", "S"])) {
		$arProperty_LNS[$arr["CODE"]] = "[".$arr["CODE"]."] ".$arr["NAME"];
	}
}

$arComponentParameters = [
	"PARAMETERS" => [
		"IBLOCK_TYPE" => [
			"PARENT" 			=> "BASE",
			"NAME" 				=> GetMessage("IBLOCK_TYPE"),
			"TYPE" 				=> "LIST",
			"VALUES" 			=> $arTypesEx,
			"DEFAULT" 			=> "news",
			"REFRESH" 			=> "Y",
		],
		"IBLOCK_ID" => [
			"PARENT" 			=> "BASE",
			"NAME" 				=> GetMessage("IBLOCK_IBLOCK"),
			"TYPE" 				=> "LIST",
			"VALUES" 			=> $arIBlocks,
			"DEFAULT" 			=> '',
			"ADDITIONAL_VALUES" => "Y",
			"REFRESH" 			=> "Y",
		],
		"PAGE_COUNT" => [
			"PARENT" 			=> "BASE",
			"NAME" 				=> GetMessage("PAGE_COUNT"),
			"TYPE" 				=> "INTEGER",
			"DEFAULT" 			=> '5',
		],
	]
];