<?
session_start();
//счет отправителя
$personalAccountFrom = (int) $_SESSION['personalAccountFrom'];
//баланс пользователя
$balans = (float) $_SESSION['balans'];
//счет получателя
$personalAccountTo = (int) $_POST['personalAccountTo'];
//сумма перевода
$amountForTransaction = (float) $_POST['sum'];

//подключаемся к бд
include('checkReg.php');
$link = dbConection();

//Списываем со счета клиента сумму перевода
$forOldBalans = $balans - $amountForTransaction;
$sql1 = "UPDATE `user` SET `amountOnTheAccount`= $forOldBalans WHERE `idUser` = $personalAccountFrom";

$query1 = mysqli_real_escape_string($link, $sql1);
$result1 = mysqli_query($link, $query1);
$_SESSION['balans'] = $forOldBalans;

//Прибавляем на счет адресату сумму перевода
$forNewBalans = $balans + $amountForTransaction;
$sql2 = "UPDATE `user` SET `amountOnTheAccount`= `amountOnTheAccount` + $amountForTransaction WHERE `idUser` = $personalAccountTo";

$query2 = mysqli_real_escape_string($link, $sql2);
$result2 = mysqli_query($link, $query2);

//закрываем соединение
mysqli_close($link);
logFile($personalAccountFrom, $personalAccountTo, $amountForTransaction);
header("Location:index.php");

//Функция для сохранения данных об операции в файл на сервере
function logFile($user1, $user2, $sum) {
    $file = 'logFile.txt';
    $text = '======================='."\r\n";
    $text .= 'Со счета '.$user1."\r\n".'Переведена сумма '.$sum."\r\n".'на счет '.$user2."\r\n".'Дата операции:'.date('Y-m-d H:i:s') ."\r\n";

    $fOpen = fopen($file,'a');
    fwrite($fOpen, $text);
    fclose($fOpen);
}
?>