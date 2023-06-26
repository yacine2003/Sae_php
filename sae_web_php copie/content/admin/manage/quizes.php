<?php
	require_once '../../../include/config.php';
	$page_title = "Quizs";
	include COMMON_PATH . '/head.php';
	include COMMON_PATH . '/admin_header.php';

	if (!isset($_SESSION['user_id']) || $_SESSION['user_type']!=='admin') {
		header("Location: ".url_for('index.php'));
	}
?>
<main>
	<section>
		<div class="container">
			<h1 class="text-center">Quizes</h1>
			<a href="<?php echo url_for('content/admin/manage/create/quiz.php'); ?>">Ajouter Nouveau Quiz</a>
			<div class="cards-rows"> 
				<?php
					User::define_db_conn($db_conn);
					$quizes = Quiz::select_all();
					foreach ($quizes as $quiz) {
				?>
				<div class="flex justify-between align-center card-row">
					<div class="
					card-row-title"><?php echo $quiz->title; ?></div>
					<div class="flex align-center justify-between manage-buttons">
						<a href="<?php echo url_for('content/admin/manage/update/quiz.php?id='.$quiz->id); ?>">Modifier</a>
						<a href="<?php echo url_for('content/admin/manage/delete/quiz.php?id='.$quiz->id); ?>">Supprimer</a>
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