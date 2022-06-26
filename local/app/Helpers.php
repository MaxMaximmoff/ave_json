<?php

namespace Mylab;

use Bitrix\Main\ArgumentException;
use Bitrix\Main\LoaderException;
use Bitrix\Main\ObjectPropertyException;
use Bitrix\Main\SystemException;
use CIBlockFindTools;
use Exception;


class Helpers
{
  /**
   * Метод возвращает ID инфоблока по символьному коду
   *
   * @param $code
   *
   * @throws ArgumentException
   * @throws LoaderException
   * @throws ObjectPropertyException
   * @throws SystemException
   * @throws Exception
   *
   * @returm int/void
   */
  public static function getIBlockIdByCode($code)
  {
    if (!\Bitrix\Main\Loader::includeModule('iblock')) {
      return;
    }
    $IB = \Bitrix\Iblock\IblockTable::getList([
      'select' => ['ID'],
      'filter' => ['CODE' => $code],
      'limit' => '1',
      'cache' => ['ttl' => 3600]
    ]);
    $return = $IB->fetch();
    if (!$return) {
      throw new Exception('IBlock with code"' . $code . '" not found');
    }

    return $return['ID'];
  }

  /**
   * Метод возвращает ID секции по символьному коду
   *
   * @param $sectionCode
   * @param $iblockCode
   *
   * @throws ArgumentException
   * @throws LoaderException
   * @throws ObjectPropertyException
   * @throws SystemException
   * @throws Exception
   *
   * @returm int/bool
   */
  public static function getSectionIdByCode($sectionCode, $iblockCode)
  {

    $objFindTools = new CIBlockFindTools();

    $return = $objFindTools->GetSectionID(
      false,
      $sectionCode,
      array(
        "IBLOCK_ID" => Helpers::getIBlockIdByCode($iblockCode))
    );

    if (!$return) {
//      throw new Exception('Section with code"' . $sectionCode . '" not found');
      return false;
    }

    return intval($return);
  }

  /**
   * Метод возвращает ID элемента по символьному коду
   *
   * @param $code
   * @param $iblockCode
   *
   * @throws ArgumentException
   * @throws LoaderException
   * @throws ObjectPropertyException
   * @throws SystemException
   * @throws Exception
   *
   * @returm int/void
   */
  public static function getElementIdByCode($code, $iblockCode): int
  {

    $objFindTools = new CIBlockFindTools();

    $return = $objFindTools->GetElementID(
        false,
        $code,
        false,
        false,
        array(
          "IBLOCK_ID" => Helpers::getIBlockIdByCode($iblockCode))
      );

    if (!$return) {
      throw new Exception('Element with code"' . $code . '" not found');
    }

    return $return;
  }
}
