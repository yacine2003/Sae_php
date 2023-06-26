<?php
	require_once '../../../../include/config.php';
	$page_title = "Supprimer Utilisateur";
	include COMMON_PATH . '/head.php';
	include COMMON_PATH . '/admin_header.php';

	if (!isset($_SESSION['user_id']) || $_SESSION['user_type']!=='admin') {
		header("Location: ".url_for('index.php'));
	}

	if (!isset($_GET['id'])) {
		header("Location: ".url_for('content/admin/manage/users.php'));
	}else if(isset($_GET['id'])){
		User::define_db_conn($db_conn);
		$user = User::select_by_id($_GET['id']);
	}
?>

<?php
	if ($_SERVER['REQUEST_METHOD']=="POST") {
		$user->delete();
		header("Location: ".url_for('content/admin/manage/users.php'));
	}

?>
<main>
	<section>
		<div class="container">
			<div class="user-form-wrapper">
				<h1 class="text-center">Supprimer <?php echo $user->username; ?></h1>
				<form action="<?php echo url_for('content/admin/manage/delete/user.php?id='.$user->id); ?>" method="POST">
					<div class="flex justify-between align-center">
						<a href="<?php echo url_for('content/admin/manage/users.php'); ?>">Retour</a>
						<button type="submit" class="submit-button">Supprimer</button>
					</div>
				</form>
			</div>
			
		</div>
	</section>
</main>

<?php
	include COMMON_PATH . '/footer.php';
?>