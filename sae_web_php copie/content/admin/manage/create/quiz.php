<?php
	require_once '../../../../include/config.php';
	$page_title = "Nouveau Quiz";
	include COMMON_PATH . '/head.php';
	include COMMON_PATH . '/admin_header.php';

	if (!isset($_SESSION['user_id']) || $_SESSION['user_type']!=='admin') {
		header("Location: ".url_for('index.php'));
	}
?>

<?php
	if ($_SERVER['REQUEST_METHOD']=="POST") {
		$quiz_inputs =[];
		$quiz_inputs['title'] = $_POST['quiz_title'] ?? "";

		$questions = [];
		if (isset($_POST['questions_names'])) {
			$num_questions = count($_POST['questions_names']);
		}
		for ($i=0; $i <$num_questions ; $i++) { 
			$question =[
				'name'=>$_POST['questions_names'][$i],
				'type'=>$_POST['questions_types'][$i],
				'text'=>$_POST['questions_texts'][$i],
				'answer'=>$_POST['questions_answers'][$i],
				'score'=>$_POST['questions_scores'][$i]
			];

			if ($_POST['questions_types'][$i]=='radio' || $_POST['questions_types'][$i]=='checkbox') {
				$choices_array = explode("|", $_POST['question_'.($i+1).'_choices']);
				$question['choices'] = $choices_array;
			}
			$questions[] = $question;
		}
		$quiz_inputs['questions'] = json_encode($questions);
		
		Quiz::define_db_conn($db_conn);
		$quiz = new Quiz($quiz_inputs);
		$quiz->create(); 

		header("Location: ".url_for('content/admin/manage/quizes.php'));
	}
?>
<main>
	<section>
		<div class="container">
				<h1 class="text-center">Ajouter un Nouveau Quiz</h1>
				<form action="<?php echo url_for('content/admin/manage/create/quiz.php'); ?>" method="POST">
					<label for="quiz_title">Titre du Quiz</label>
					<input type="text" name="quiz_title" id="quiz_title" required>
					<button type="button" id="add-question-btn">Ajouter Question</button>
					<div id="questions-wrapper">
						
					</div>
					<div class="flex justify-between align-center">
						<a href="<?php echo url_for('content/admin/manage/quizes.php'); ?>">Retour</a>
						<button type="submit" class="submit-button">Ajouter</button>
					</div>
				</form>
			
		</div>
	</section>
</main>

<?php
	include COMMON_PATH . '/footer.php';
?>