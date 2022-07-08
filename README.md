# Api_For_test_task_Avito
 
API для выполнения тестового задания Avito

Задачи: 
Разработать API для получения баланса определенного пользователя и конвертация в валюту при указании параметров,
Пополнение счета определенного пользователя
Списание со счета определенного пользователя
Перевод денег от пользователя к пользователю

Используется composer для автозагрузки классов.

1) Просмотр баланса пользователя .
Для просмотра баланса определенного пользователя необходимо отправить GET запрос на URL http://test/users/{id} вместо параметра id подставить нужное значение для пользователя.
Сервер вернет json с полями status, code, msg, data. В поле status содержится значение ответа true/false, в code указан код ответа сервера, в msg сообщение об успехе или неуспехе,
в  data указан баланс пользователя в рублях.

2) Для просмотра баланса определенного пользователя С ПАРАМЕТРАМИ (конвертация баланса пользователя в доллары, евро или фунты стерлингов) необходимо отправить GET запрос на URL http://test/users/{id}?currency={интересующая вас валюта (необходимо указать код валюты, например USD) } вместо параметра id подставить нужное значение для пользователя.
Сервер вернет json с полями status, code, msg, data. В поле status содержится значение ответа true/false, в code указан код ответа сервера, в msg сообщение об успехе или неуспехе,
в  data указан баланс пользователя в выбранной валюте.

3)Для пополнения счета определенного пользователя необходимо отправить POST запрос на URL http://test/users/increase, в теле запроса указать параметры id, balance , соответвтвенно id пользователя и сумму для пополнения в рублях.
Сервер вернет json с полями status, code, msg. В поле status содержится значение ответа true/false, в code указан код ответа сервера, в msg сообщение об успехе или неуспехе.

4)Для списания со счета определенного пользователя необходимо отправить POST запрос на URL http://test/users/decrease, в теле запроса указать параметры id, balance , соответвтвенно id пользователя и сумму для списания в рублях.
Сервер вернет json с полями status, code, msg. В поле status содержится значение ответа true/false, в code указан код ответа сервера, в msg сообщение об успехе или неуспехе.