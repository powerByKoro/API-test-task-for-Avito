# Api_For_test_task_Avito
 
Тестовое задание для стажировки в Авито

Список заданий:

1)Создать API получения данных о балансе пользователя

2)Создать API для пополнения баланса пользователя в рублях

3)Создать API для списания с баланса пользователя в рублях

4)Создать API для обмена средствами между двумя пользователями

Дополнительные задания:

1)При указании параметра ?currency = ... конвертировать баланс пользователя в указанную валюту
2) Получения списка всех покупок пользователя с описанием и временем покупки (или списания за услугу)

---------

1. Для получения данных о балансе пользователя необходимо отправить GET запрос на адрес http://api-test-task-for-avito/users/{id}
вместо {id} указать id пользователя.

2. Для пополнения баланса пользователя необходимо отправить POST запрос на адрес http://api-test-task-for-avito/users/increase
в теле запроса указать парметры id, balance соответственно айди пользователя и сумму для пополнения. 

3. Для пополнения списания с баланса пользователя необходимо отправить POST запрос на адрес http://api-test-task-for-avito/users/decrease
в теле запроса указать парметры id, balance, description соответственно айди пользователя, сумму для списания и описание операции за что списались средства. 
Параметр описание является обязательным.

4. Для обмена деньгами между пользователями необходимо отправить POST запрос на адрес http://api-test-task-for-avito/users/trade
в теле запроса указать параметры first_user_id, second_user_id, sum соответственно от кого пересылаются деньги, кому пересылаются деньги и сумма.
Деньги идут от first_user_id к second_user_id!

Доп задания.
1. Для получения данных о балансе пользователя в валюте необходимо отправить GET запрос на адрес http://api-test-task-for-avito/users/{id}
   с параметром ?currency = ... вместо параметра {id} указать id пользователя, вместо ?currency = ... указать код валюты, например ?currency = USD .
Данные о курсе валют предоставляет API сайта https://exchangeratesapi.io/ .
2. Для получения списка всех покупок пользователя с описанием и временем покупки (или списания за услугу) необходимо отправить
GET запрос на адрес http://api-test-task-for-avito/users/{id}/description , вместо параметра {id} указать id пользователя

В СИСТЕМЕ ЕСТЬ ТОЛЬКО ДВА ПОЛЬЗОВАТЕЛЯ С id 1 И 2. 

ВСЕ ОТВЕТЫ ПРИХОДЯТ В JSON ФОРМАТЕ С СООТВЕТСТВУЮЩИМИ КОДАМИ И СТАТУСАМИ.
