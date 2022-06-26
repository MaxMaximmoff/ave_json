<?php

namespace Mylab\Components;

use Bitrix\Main\Web\Json;
use Bitrix\Main\Web\HttpClient;
use Bitrix\Main\Application;
use Bitrix\Main\ArgumentException;
use Bitrix\Main\LoaderException;
use Bitrix\Main\ObjectPropertyException;
use Bitrix\Main\SystemException;
use CBitrixComponent;
use CFile;
use CIBlockElement;
use CIBlockSection;
use CModule;
use Bitrix\Main\Localization\Loc;
use Mylab\Helpers;


/**
 * Class JsonProcessingComponent
 * @package Mylab\Components
 * Компонент для обработки json
 */
class JsonProcessingComponent extends CBitrixComponent
{

  /* @var float $minPrice Цена для начисления подарка
   * @var string $elementCode Символьный код товара
   * @var string $iblockCode Символьный код инфоблока
   *
   */
  private $url1 = "https://reqres.in/api/users?page=1";
  private $url2 = "https://reqres.in/api/users?page=2";
  private $urls = array("https://reqres.in/api/users?page=1", "https://reqres.in/api/users?page=2");
  private $iblockCode = "employees";


  /**
   * Метод executeComponent
   *
   * @returm mixed/void
   * @throws ArgumentException
   * @throws LoaderException
   * @throws ObjectPropertyException
   * @throws SystemException
   */
  public function executeComponent()
  {

    CModule::IncludeModule("iblock");

    // Получаем ID инфоблока "Сотрудники" по символьному коду
    $iBlockId = Helpers::getIBlockIdByCode($this->iblockCode);

    // Получаем request
    $request = Application::getInstance()->getContext()->getRequest();

    // Если нажата кнопка "Загрузить сотрудников" пишем данные из json в инфоблок
    if ($request->isPost() && !empty($request->get('getEmployees'))) {

      // Обрабатываем все url
      foreach ($this->urls as $url) {

        // если данные из url получены
        if ($jsonData = $this->getJsonData($url)) {

          // получаем символьный код требуемого раздела инфоблока
          $sectionCode = "page" . $jsonData[0]['page'];

          // если такой уже есть, то удаляем
          if ($sectionId = Helpers::getSectionIdByCode($sectionCode, $this->iblockCode)) {

            $this->deleteIbSection($iBlockId, $sectionId);

          }

          // Создаем раздел и заполняем его данными из $jsonData
          if ($this->addIbSection($jsonData[0]['page'], $iBlockId)) {

            $sectionId = Helpers::getSectionIdByCode($sectionCode, $this->iblockCode);

            foreach ($jsonData as $employee) {
              $this->addIbElement($employee, $iBlockId, $sectionId);
            }
          }
        }
      }
    }

    $this->includeComponentTemplate();
  }




  /**
   * Добавляет элемент в инфоблок Сотрудники
   * @param array $employee массив с данными о сотруднике
   * @param int $iBlockId ID инфоблока
   * @param int $sectionId ID раздела инфоблока
   * @return bool
   * @throws ArgumentException
   * @throws LoaderException
   * @throws SystemException
   */
  public function addIbElement(array $employee, int $iBlockId, int $sectionId): bool
  {
    global $USER;
    $el = new CIBlockElement;
    $avatar = CFile::MakeFileArray($employee['avatar']);

    $PROP = array();
    $PROP['EMAIL'] = $employee['email'];
    $PROP['FIRST_NAME'] = $employee['first_name'];
    $PROP['LAST_NAME'] = $employee['last_name'];
    $PROP['AVATAR'] = $employee['avatar'];
    $PROP['PAGE'] = $employee['page'];
    $PROP['PER_PAGE'] = $employee['per_page'];
    $PROP['TOTAL'] = $employee['total'];
    $PROP['TOTAL_PAGES'] = $employee['total_pages'];
    $PROP['SUPPORT_URL'] = $employee['support_url'];
    $PROP['SUPPORT_TEXT'] = $employee['support_text'];


    $arLoadProductArray = array(
      "MODIFIED_BY" => $USER->GetID(), // элемент изменен текущим пользователем
      "IBLOCK_SECTION_ID" => $sectionId,
      "IBLOCK_ID" => $iBlockId,
      "PROPERTY_VALUES" => $PROP,
      'CODE' => 'employee' . $employee['id'],
      'XML_ID' => $employee['id'],
      "NAME" => "Сотрудник " . $employee['id'],
      "ACTIVE" => "Y",            // активен
      "PREVIEW_PICTURE" => $avatar,
      "DETAIL_PICTURE" => $avatar,
    );

    if (!$el->Add($arLoadProductArray)) {
      return false;
    }
    return true;
  }


  /**
   * Добавляет раздел в инфоблок Сотрудники
   * @param int $page номер страницы
   * @param int $iBlockId ID инфоблока
   * @return bool
   * @throws ArgumentException
   * @throws LoaderException
   * @throws SystemException
   */
  public function addIbSection(int $page, int $iBlockId): bool
  {
    global $USER;
    $bs = new CIBlockSection;
    $arFields = array(
      "MODIFIED_BY" => $USER->GetID(),
      "ACTIVE" => "Y",
      "IBLOCK_SECTION_ID" => "Y",
      "IBLOCK_ID" => $iBlockId,
      "NAME" => "Страница " . $page,
      'CODE' => 'page' . $page,
    );

    if ($bs->Add($arFields)) {
      return true;
    }
    return false;
  }


  /**
   * Возвращает массив с данными пришедшими по ссылке
   * @param String $url url получаемого json
   * @return array/bool
   * @throws ArgumentException
   * @throws LoaderException
   * @throws SystemException
   */
  public function getJsonData(string $url)
  {

    $httpClient = new HttpClient();
    $httpClient->get($url);
    $jsonData = [];

    try {
      $ar = Json::decode($httpClient->getResult());
    } catch (\Exception $e) {
      echo Loc::getMessage("MYLAB.JSON.PROCESSING.ERROR.MESSAGE1"), $e->getMessage(), "\n";
      return false;
    }

    // Записываем данные из json в массив $jsonData
    foreach ($ar['data'] as $item) {
      $jsonData[] = [
        "id" => $item['id'],
        "email" => $item['email'],
        "first_name" => $item['first_name'],
        "last_name" => $item['last_name'],
        "avatar" => $item['avatar'],
        "page" => $ar['page'],
        "per_page" => $ar['per_page'],
        "total" => $ar['total'],
        "total_pages" => $ar['total_pages'],
        "support_url" => $ar['support']['url'],
        "support_text" => $ar['support']['text'],
      ];
    }

    return $jsonData;
  }


  /**
   * Удаляет раздел инфоблока Сотрудники
   * @param int $iBlockId ID инфоблока
   * @param int $sectionId ID секции
   * @return bool
   */
  public function deleteIbSection(int $iBlockId, int $sectionId): bool
  {
    $ib_section = new CIBlockSection();
    if ($ib_section->Delete($sectionId)) {
      CIBlockSection::ReSort($iBlockId);
    } else {
//      echo 'Server Error', 'Error: ' . $ib_section->LAST_ERROR;
      return false;
    }

    return true;
  }

}

