# daily-records
Приложение для создания записей.
Есть форма для ввода данных (имя и время записи) и кнопка отправки формы (а также текущее время, для удобства).
Дата записи определяется автоматически следующим образом: если отправка формы произведена во временном диапазоне от 00 до 05 часов - дата текущего дня, в противном случае (от 06 до 23 часов) - дата следующего дня.
Для проверки количества записей на определённую дату выполняется запрос к базе данных на выборку количества строк записей на соответствующую дату.
После успешной записи выводится соответствующее сообщение, в противном случае - сообщение об исчерпанном числе попыток для выполнения записи.
