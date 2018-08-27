<?
/*допустим мы из сессии получаем идентификатор пользователя, 
который хочет совершить перевод.

идентификатор пользователя, которому этот перевод назначен,
получается одним из двух путей:
1. На странице присутствует список с пользователями данной системы
2. Отправитель может указать номер телефона получателя, 
по которому можно совершить перевод 
(обуславливается такой метод тем, 
что пользователь, регистрируясь на сайте привязывает к своей странице номер телефона. 
Номер телефона уникален и пользователь имеет к нему доступ для подтверждения перевода).

Сумма перевода получается из соответствующего поля формы перевода.
*/
/*
session_start();
$userOne = $_SESSION['userOne'];
$userTwo = $_POST['number'];
$summForTransaction = $_POST['sum'];


public static function logFile($textLog) {
$file = '/logFile.txt';
$text = '=======================\n';
$text .= print_r($textLog);//Выводим переданную переменную
$text .= '\n'. date('Y-m-d H:i:s') .'\n'; //Добавим актуальную дату после текста или дампа массива
$fOpen = fopen($file,'a');
fwrite($fOpen, $text);
fclose($fOpen);
}

//Вызываем метод

$text = 'Это текст для логов';
logFile($text);
?>
*/
session_start();

	if(isset($_POST['enter'])){
		$login = $_POST['login-field'];
		$password = $_POST["password-field"];
		
		$result = functionForEnter($login, $password);
		while($row = mysqli_fetch_assoc($result)){
			$_SESSION['personalAccountFrom'] = $row['idUser'];
			$_SESSION['login'] = $row['login'];
			$_SESSION['balans'] = $row['amountOnTheAccount']; 
			header("Location:index.php");
		}	
		
	}
	if(isset($_POST['reg'])){
		$login = $_POST['login-field'];
		$password = $_POST["password-field"];
		$fio = $_POST["fio-field"];
		functionForRegistration($login, $password, $fio);
		
	}

	function functionForRegistration($login,$password,$fio){
		$password = MD5($password);
		$sql = "INSERT INTO `user`(`FIO`, `amountOnTheAccount`, `login`, `password`) VALUES ('%s', 1000,'%s','%s')";
		$link = dbConection();
		$query = sprintf($sql,mysqli_escape_string($link, $fio),
						mysqli_escape_string($link, $login),
						mysqli_escape_string($link, $password));
		
		$result = mysqli_query($link, $query);
		mysqli_close($link);
	}

	function functionForEnter($login, $password) {
		$password = MD5($password);
		$sql= "SELECT * FROM `user` WHERE `login` = '$login' and `password` = '$password'";
		$link = dbConection();
		$query = sprintf($sql,
						mysqli_escape_string($link, $login),
						mysqli_escape_string($link, $password));
		$result = mysqli_query($link, $query);
		mysqli_close($link);
		return $result;		
	}

	//устанавливает соединение с бд
	function dbConection(){
	    $server = 'localhost';
	    $user = 'root';
	    $password = '';
		$database = 'forTestTask';
		$dblink = mysqli_connect($server, $user, $password);
		$selected = mysqli_select_db($dblink, $database);
	    return $dblink;
	}
?>