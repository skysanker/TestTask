

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<div class="mainMenu">
	<ul class="menu-main">
		
		
		
		<?
			if(isset($_SESSION['login'])){
				echo '<li>
						Привет, '.$_SESSION['login'].'
					</li>';
				echo '<li>
						Баланс: '.$_SESSION['balans'].'
					</li>';
				echo '<li>
						<a href="destroy.php"> Выход </a>
					</li>';
			} else {
				echo '<li>
					 <a href="index.php"> Пожалуйста, авторизируйтесь или зарегистрируйтесь для продолжения работы </a>
					 </li>';
			}
		?>
	</ul>
</div>
