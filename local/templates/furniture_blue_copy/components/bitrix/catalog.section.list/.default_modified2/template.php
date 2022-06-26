<?php
/*
 * Шаблон компоненты catalog.section.list
 * Файл /local/templates/.default/components/bitrix/catalog.section.list/.default/template.php
 */

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);

// Редактировать или удалить раздел с морды сайта
$strSectionEdit = CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'SECTION_EDIT');
$strSectionDelete = CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'SECTION_DELETE');
$arSectionDeleteParams = array('CONFIRM' => GetMessage('CT_BCSL_ELEMENT_DELETE_CONFIRM'));

?>

<ul class="blo-top">
    <li id="<?php echo $this->GetEditAreaId($arResult['SECTION']['ID']); ?>">
        <a href="/task/">Корень каталога</a></li>
  <?php foreach ($arResult['SECTIONS'] as $arSection): ?>
    <?php
    $this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], $strSectionEdit);
    $this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], $strSectionDelete, $arSectionDeleteParams);
    ?>
      <li id="<?php echo $this->GetEditAreaId($arSection['ID']); ?>">
          <a href="<?php echo $arSection['SECTION_PAGE_URL']; ?>">
            <?php echo $arSection['NAME']; ?>
            <?php if ($arParams['COUNT_ELEMENTS']): /* показывать кол-во элементов в разделе? */ ?>
                <span>(<?php echo $arSection['ELEMENT_CNT']; ?>)</span>
            <?php endif; ?>
          </a>
      </li>
  <?php endforeach; ?>
</ul>