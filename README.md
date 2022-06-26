
## Задача Bitrix:

1.	Установить VM bitrix/или хостинг
2.	Установить сам битрикс
3.	Создать инфоблок сотрудники
      a.	Все поля инфоблока должны соответствовать полученным данным Rest Api: https://reqres.in/api/users?page=1%20%D0%B8%20https://reqres.in/api/users?page=2
4.	Создать страницу(что должно быть на странице):
      a.	Создать кнопку(Загрузить сотрудников), при нажатии которой, делается запрос к сервису по ссылке https://reqres.in/api/users?page=1 и https://reqres.in/api/users?page=2
      b.	Что должно у вас получиться, после нажатия на кнопку(Загрузить сотрудников):
      i.	Создаются разделы по запросу из Api(страница 1 и страница 2)
      ii.	Каждый элемент из Api, в своем разделе, то есть страница
      iii.	1 элемент 1 сотрудник
      c.	Создать кнопку(получить список сотрудников)
      i.	После нажатия на кнопку должно получиться следующее
1.	Вывести список сотрудников
2.	При нажатии на сотрудника вывести всю информацию о сотруднике(то есть все поля полученные из JSON API)

При выполнении задания использовать компоненты битрикса для вывода, но для записи данных использовать ядро D7

## Решение:
/task/index.php  - страница отображения каталога сотрудников
/local/templates/furniture_blue_copy/components/mylab/json.processing - компонент для записи данных json в инфоблок Сотрудники
/local/php_interface/migrations/Version20220626051234.php - миграция sprint.migration для инфоблока Сотрудники

<b><h3>шаблоны вывода данных:</h3></b>
шаблоны вывода данных:
/local/templates/furniture_blue_copy/components/bitrix/catalog
/local/templates/furniture_blue_copy/components/bitrix/catalog.section.list




