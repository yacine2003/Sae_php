<?php
	require_once '../../include/config.php';
	$page_title = "Utilisateur";
	include COMMON_PATH . '/head.php';
	include COMMON_PATH . '/header.php';

	if (!isset($_SESSION['user_id']) || $_SESSION['user_type']!=='user') {
		header("Location: ".url_for('index.php'));
	}
?>
<main>
	<section>
		<div class="container">
			<h1 class="text-center">Quizs</h1>
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
						<a href="<?php echo url_for('content/user/quiz.php?id='.$quiz->id); ?>">Commencer le Quiz</a>
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