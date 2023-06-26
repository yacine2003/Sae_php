<?php
	require_once 'include/config.php';
	$page_title = "S'enregistrer";
	include COMMON_PATH . '/head.php';
	include COMMON_PATH . '/header.php';
?>
<?php
	if ($_SERVER['REQUEST_METHOD']=="POST") {
		User::define_db_conn($db_conn);
		$new_user = [];
		$new_user['first_name'] = $_POST['first_name'] ?? "";
		$new_user['last_name'] = $_POST['last_name'] ?? "";
		$new_user['username'] = $_POST['username'] ?? "";
		$new_user['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
		$new_user['user_type'] = "user";

		$user = new User($new_user);
		$user->create();

		header("Location: ".url_for('login.php'));
	}
?>
<main>
	<section>
		<div class="user-form-wrapper">
			<form action="signup.php" method="POST">
				<label>Nom</label>
				<input type="text" name="first_name" id="first_name" required>
				<label>Prénom</label>
				<input type="text" name="last_name" id="last_name" required>
				<label for="username">Nom d'Utilisateur</label>
				<input type="text" name="username" id="username" required>
				<label for="password">Mot de Passe</label>
				<input type="password" name="password" id="password" required>
				<button type="submit" class="submit-button">S'enregistrer</button>
			</form>
		</div>
	</section>
</main>

<?php
	include COMMON_PATH . '/footer.php';
?>