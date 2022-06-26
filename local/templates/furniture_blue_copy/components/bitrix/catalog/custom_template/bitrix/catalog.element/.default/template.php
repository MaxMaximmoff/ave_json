<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<div class="catalog-detail">
    <div class="catalog-item">
      <?
      $width = 0;
      if ($arParams['DETAIL_SHOW_PICTURE'] != 'N' && (is_array($arResult["PREVIEW_PICTURE"]) || is_array($arResult["DETAIL_PICTURE"]))):
        ?>
          <div class="catalog-item-image">
            <?
            if (is_array($arResult["DETAIL_PICTURE"])):
              $width = $arResult["DETAIL_PICTURE"]["WIDTH"];
              ?>
                <img src="<?= $arResult["DETAIL_PICTURE"]["SRC"] ?>" width="<?= $arResult["DETAIL_PICTURE"]["WIDTH"] ?>"
                     height="<?= $arResult["DETAIL_PICTURE"]["HEIGHT"] ?>" alt="<?= $arResult["NAME"] ?>"
                     title="<?= $arResult["NAME"] ?>"/>
            <?
            elseif (is_array($arResult["PREVIEW_PICTURE"])):
              $width = $arResult["PREVIEW_PICTURE"]["WIDTH"];
              ?>
                <img src="<?= $arResult["PREVIEW_PICTURE"]["SRC"] ?>"
                     width="<?= $arResult["PREVIEW_PICTURE"]["WIDTH"] ?>"
                     height="<?= $arResult["PREVIEW_PICTURE"]["HEIGHT"] ?>" alt="<?= $arResult["NAME"] ?>"
                     title="<?= $arResult["NAME"] ?>"/>
            <?
            endif;
            ?>
          </div>
          <div class="catalog-item-properties">
              <div class="catalog-item-property">
                  <ul>
                      <li><?= $arResult["PROPERTIES"]["FIRST_NAME"]["NAME"] . " - " . $arResult["PROPERTIES"]["FIRST_NAME"]["VALUE"]; ?></li>
                      <li><?= $arResult["PROPERTIES"]["LAST_NAME"]["NAME"] . " - " . $arResult["PROPERTIES"]["LAST_NAME"]["VALUE"]; ?></li>
                      <li><?= $arResult["PROPERTIES"]["EMAIL"]["NAME"] . " - " . $arResult["PROPERTIES"]["EMAIL"]["VALUE"]; ?></li>
                  </ul>
              </div>
          </div>
      <?
      endif;

      if (is_array($arResult["SECTION"])):
        ?>
          <br/><a href="<?= $arResult["SECTION"]["SECTION_PAGE_URL"] ?>">&larr; <?= GetMessage("CATALOG_BACK") ?></a>
      <?
      elseif (is_array($arResult['IBLOCK'])):
        ?>
          <br/><a href="<?= $arResult["IBLOCK"]["LIST_PAGE_URL"] ?>">&larr; <?= GetMessage("CATALOG_BACK") ?></a>
      <?
      endif;
      ?>
    </div>
</div>
