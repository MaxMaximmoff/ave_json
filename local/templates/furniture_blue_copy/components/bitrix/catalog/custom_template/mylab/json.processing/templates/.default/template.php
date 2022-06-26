<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
  die();
}

use Bitrix\Main\Localization\Loc;
?>


<div class="catalog-item">
    <form action="" method="POST">
        <!--        <div><input type="submit" class="btn btn-lg btn-primary" name="getEmployees" value="-->
      <? //= Loc::getMessage("MYLAB.JSON.PROCESSING.GET.EMPLOYEES") ?><!--"></div>-->
        <div>
            <button type="submit" class="btn btn-lg btn-primary" name="getEmployees" value="yes">
          <?= Loc::getMessage("MYLAB.JSON.PROCESSING.GET.EMPLOYEES") ?></div>
    </form>
    <form action="" method="POST">
        <div>
            <button type="submit" class="btn btn-lg btn-primary" name="getEmployeesList" value="yes">
          <?= Loc::getMessage("MYLAB.JSON.PROCESSING.GET.LIST") ?></div>
    </form>
</div>






