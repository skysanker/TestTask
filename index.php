<?session_start();?>
<!DOCTYPE html>
<html>
  <head>
    <title>Перевод *чего-либо*</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="style.css">
  </head>
  
  <body>
  	<?	include('mainMenu.php');
  		if(isset($_SESSION['personalAccountFrom'])){
  			echo '
  			<div class="transaction">
				<form action="transaction.php" method="post">
					<label for="personalAccountTo">Номер счета адресата:</label>
					<input type="text" name="personalAccountTo" id="personalAccountTo" required>
					<label for="sum">Сумма перевода</label>
					<input type="text" name="sum" id="sum" oninput="replaces()" required>
					<input type="submit">
				</form>
  			</div>';
  		} else {
  			echo '
			  	<div class="content">

			    	<div class="aForm show">
			    		<form action="checkReg.php" method="post">
			    			<label for="login">Логин:</label>
			    			<input type="text" id="login" name="login-field" placeholder="Логин" required>
			    			<label for="password">Пароль:</label>
			    			<input type="password" id="password" name="password-field" placeholder="Пароль" required>
			    			<input type="submit" value="Войти" name="enter">
			    		</form>
			    		<button class="registration" onclick="showRegPanel(\'r\')">Регистрация</button>
			    	</div>
			    	
			    	<div class="rForm hide">
			    		<form action="checkReg.php" method="post">
			    			<label for="loginForRegistration">Придумайте логин:</label>
			    			<input type="text" id="loginForRegistration" name="login-field" placeholder="Логин" required>
			    			<label for="passwordForRegistration">Придумайте пароль:</label>
			    			<input type="password" id="passwordForRegistration" name="password-field" placeholder="Пароль" required>
			    			<label for="fioForRegistration">ФИО:</label>
			    			<input type="text" id="fioForRegistration" name="fio-field" placeholder="ФИО" required pattern="[а-яА-Я]+">
			    			<input type="submit" value="Зарегистрироваться" name="reg">
			    		</form>
			    		<button class="registration" onclick="showRegPanel(\'a\')">Войти</button>
			    	</div>
				</div>';
	}	
	?>



	<script type="text/javascript">

		function showRegPanel(param){
			var hideAuthPanel = document.getElementsByClassName("aForm")[0];
			var showRegPanel = document.getElementsByClassName("rForm")[0];

			if(param == "r"){
				hideAuthPanel.classList.remove("show");
				showRegPanel.classList.remove("hide");
				hideAuthPanel.classList.add("hide");
				showRegPanel.classList.add("show");	
			} else {
				showRegPanel.classList.remove('show');
				hideAuthPanel.classList.remove("hide");
				hideAuthPanel.classList.add("show");
				showRegPanel.classList.add('hide');
			}
		}
		<? if(isset($_SESSION['login'])){ 
			echo '
				function replaces(){
					var transactionSum = document.getElementById(\'sum\');
					var value = transactionSum.value;
						if(+value){
							value = value.replace(",",".");
							transactionSum.value = value;
						} else if(value.substring(0, 1) == 0){
							if(value.substring(0, 2) != "0."){
							value = value.replace("0","0.");
							transactionSum.value = value;
							}
						} else {
							alert(\'Для ввода доступны цифровые значения с одной точкой\');
							transactionSum.value = value.substring(0, value.length - 1);
						}

						if(value >'.$_SESSION['balans'].'){
							alert(\'Сумма должна быть меньше Вашего баланса\');
							transactionSum.value = '.$_SESSION['balans'].';
						}

				}';
		};
		?>
	</script>    
  </body>
</html>