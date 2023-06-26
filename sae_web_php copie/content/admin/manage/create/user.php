<?php
	require_once '../../../../include/config.php';
	$page_title = "Utilisateurs";
	include COMMON_PATH . '/head.php';
	include COMMON_PATH . '/admin_header.php';

	if (!isset($_SESSION['user_id']) || $_SESSION['user_type']!=='admin') {
		header("Location: ".url_for('index.php'));
	}
?>

<?php
	if ($_SERVER['REQUEST_METHOD']=="POST") {
		User::define_db_conn($db_conn);
		$new_user = [];
		$new_user['first_name'] = $_POST['first_name'] ?? "";
		$new_user['last_name'] = $_POST['last_name'] ?? "";
		$new_user['username'] = $_POST['username'] ?? "";
		$new_user['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
		$new_user['user_type'] = $_POST['user_type'] ?? "";;

		$user = new User($new_user);
		$user->create();

		header("Location: ".url_for('content/admin/manage/users.php'));
	}
?>
<main>
	<section>
		<div class="container">
			<div class="user-form-wrapper">
				<h1 class="text-center">Ajouter un Utilisateur</h1>
				<form action="<?php echo url_for('content/admin/manage/create/user.php'); ?>" method="POST">
					<label>Nom</label>
					<input type="text" name="first_name" id="first_name" required>
					<label>Prénom</label>
					<input type="text" name="last_name" id="last_name" required>
					<label for="username">Nom d'Utilisateur</label>
					<input type="text" name="username" id="username" required>
					<label for="password">Mot de Passe</label>
					<input type="password" name="password" id="password" required>
					<label>Type d'Utilisateur</label>
					<select name="user_type" id="user_type" required>
						<option value="admin">Administrateur</option>
						<option value="user">Utilisateur</option>
					</select>
					<div class="flex justify-between align-center">
						<a href="<?php echo url_for('content/admin/manage/users.php'); ?>">Retour</a>
						<button type="submit" class="submit-button">Ajouter</button>
					</div>
				</form>
			</div>
			
		</div>
	</section>
</main>

<?php
	include COMMON_PATH . '/footer.php';
?>