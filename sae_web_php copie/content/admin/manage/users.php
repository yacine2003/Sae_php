<?php
	require_once '../../../include/config.php';
	$page_title = "Utilisateurs";
	include COMMON_PATH . '/head.php';
	include COMMON_PATH . '/admin_header.php';

	if (!isset($_SESSION['user_id']) || $_SESSION['user_type']!=='admin') {
		header("Location: ".url_for('index.php'));
	}
?>
<main>
	<section>
		<div class="container">
			<h1>Utilisateurs</h1>
			<a href="<?php echo url_for('content/admin/manage/create/user.php'); ?>">Ajouter Utilisateur</a>
			<div class="cards-rows"> 
				<?php
					User::define_db_conn($db_conn);
					$users = User::select_all();
					foreach ($users as $user) {
				?>
				<div class="flex justify-between align-center card-row">
					<div class="
					card-row-title"><?php echo $user->username; ?></div>
					<div class="manage-buttons">
						<a href="<?php echo url_for('content/admin/manage/delete/user.php?id='.$user->id); ?>">Supprimer</a>
					</div>
				</div>
				<?php
					}
				?>
			</div>
		</div>
	</section>
</main>

<?php
	include COMMON_PATH . '/footer.php';
?>