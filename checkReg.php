<?
/*
Пусть для примера каждому новому зарегистрировавшемуся пользователю 
на баланс автоматически записывается 1000 единиц.
ТК суть задания сводилась к написанию функции для перевода средств между счетами, логированию операций
я решил опустить этап "загрузки" денег на аккаунт пользователя.
Так же для осуществления перевода необходимо знать идентификатор счета пользователя получателя.
Идентификатор выступает в роли номера личного счета.

При попытке перевода осуществляется проверка введенной суммы на возможность к переводу
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