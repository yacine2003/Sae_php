<?php
	require_once 'include/config.php';
	$page_title = "Se Connecter";
	include COMMON_PATH . '/head.php';
	include COMMON_PATH . '/header.php';
?>
<?php
	if ($_SERVER['REQUEST_METHOD']=="POST") {
		User::define_db_conn($db_conn);
		$login_creds = [];
		$login_creds['username'] = $_POST['username'] ?? "";
		$login_creds['password'] = $_POST['password'] ?? "";

		if (User::check_user_exists($login_creds)) {
			if (User::check_user_password($login_creds)) {
				$user = User::select_by_username($login_creds);
				$_SESSION['user_id'] = $user->id;
				$_SESSION['user_type'] = $user->user_type;
 				if ($_SESSION['user_type']=='admin') {
 					header("Location: ".url_for('content/admin/index.php'));
 				}else if($_SESSION['user_type']=='user'){
 					header("Location: ".url_for('content/user/index.php'));
 				}
			}else{
				$error = "Le mot de passe saisi est incorrect";
			}
		}else{
			$error = "Cet utilisateur n'existe pas";
		}
	}
?>
<main>
	<section>
		<div class="user-form-wrapper">
			<form action="login.php" method="POST">
				<label for="username">Nom d'Utilisateur</label>
				<input type="text" name="username" id="username" required>
				<label for="password">Mot de Passe</label>
				<input type="password" name="password" id="password" required>
				<?php
					if (isset($error)) {
						echo $error;
					}
				?>
				<button type="submit" class="submit-button">Se Connnecter</button>
			</form>
		</div>
	</section>
</main>

<?php
	include COMMON_PATH . '/footer.php';
?>