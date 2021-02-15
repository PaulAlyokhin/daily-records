<?php
session_start();
$session_id = session_id();
$server = 'localhost';
$username = 'root';
$password = 'root';
$db = "daily-records";
$connect = mysqli_connect($server, $username, $password);
$c = mysqli_select_db($connect, $db);
if(!$c) echo "<h2>Нет соединения с БД!</h2>";
?>

<script>
    function clock(){
        let date = new Date(),
            hours = (date.getHours() < 10) ? '0' + date.getHours() : date.getHours(),
            minutes = (date.getMinutes() < 10) ? '0' + date.getMinutes() : date.getMinutes(),
            seconds = (date.getSeconds() < 10) ? '0' + date.getSeconds() : date.getSeconds();
        document.getElementById('clock').innerText = hours + ':' + minutes + ':' + seconds;
    }
    setInterval(clock, 1000);
</script>
<form action="index.php" method="post">
    <p>Текущее время: <span id="clock"></span></p>
    <p>
        Ваше имя: <input type="text" name="user-name" required>
    </p>
    <p>
        Время записи: <input type="time" name="time" min="<?= date("y-m-d"); ?>" required>
    </p>
    <input type="submit" name="form-submit" value="Записаться">
</form>

<?php

if(isset($_POST['form-submit'])) {
    if(intval(date("H")) >= 00 && intval(date("H")) <= 05) { // Промежуток времени с 00 до 05 часов
        $date = date("y-m-d"); // Запись на текущий день
    }
    else { // Промежуток времени с 06 до 23 часов
        $date = date("Y-m-d", strtotime("+1 day")); // Запись на следующий день
    }

    $query = "SELECT COUNT(*) FROM `records` WHERE `session_id` = '" . $session_id . "' AND DATE(`datetime`) = '" . $date . "'";
    $result = mysqli_query($connect, $query);
    $row = mysqli_fetch_row($result);

    if(intval($row[0]) < 2) {
        $query = "INSERT INTO `records` VALUES (null, '" . $session_id . "', '" . $_POST['user-name'] . "', '" . $date . " " . $_POST['time'] . "')";
        mysqli_query($connect, $query);
        echo $_POST['user-name'] . ", Вы успешно записались на " . $date . ", " . $_POST['time'];
    }
    else echo "<h2>Вы уже использовали все попытки записи!</h2>";
}