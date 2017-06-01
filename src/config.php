<?php
/*
 * Учетная записать для отлаки
 */
define("DEMO_LOGIN", "petr-test");
define("DEMO_PASS", "petr-test*12");
define("DEMO_HOST", "fix-reg.tensor.ru");

/*
 * Учетная запись для работы
 */
define("LOGIN", "ВВЕДИТЕ ВАШ ЛОГИН");
define("PASS", "ВВЕДИТЕ ВАШ ПАРОЛЬ");
define("HOST", "reg.tensor.ru");

/*
 * Версия протокола
 */
define("JSONRPC", "2.0");
define("PROTOCOL", "2");

/*
 * Название файла для записи X-SBISSessionID
 */
define("FILE_SESSION_ID", "session_id.txt");

/*
 * Дальше не трогать
 * Если в index.php определили переменную DEMO как 1, то скрипт работает с демо-сервером
 */

if (DEMO) {
    $login = DEMO_LOGIN;
    $pass = DEMO_PASS;
    $host = DEMO_HOST;
} else {
    $login = LOGIN;
    $pass = PASS;
    $host = HOST;
}

define("SBIS_LOGIN", $login);
define("SBIS_PASS", $pass);
define("SBIS_HOST", $host);