<?php
	require_once '../../../../include/config.php';
	$page_title = "Modifier Quiz";
	include COMMON_PATH . '/head.php';
	include COMMON_PATH . '/admin_header.php';

	if (!isset($_SESSION['user_id']) || $_SESSION['user_type']!=='admin') {
		header("Location: ".url_for('index.php'));
	}

	if (!isset($_GET['id'])) {
		header("Location: ".url_for('content/admin/manage/quizes.php'));
	}else if(isset($_GET['id'])){
		Quiz::define_db_conn($db_conn);
		$quiz = Quiz::select_by_id($_GET['id']);
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
		
		$quiz->title = $quiz_inputs['title'];
		$quiz->questions = $quiz_inputs['questions'];
		$quiz->update();

		header("Location: ".url_for('content/admin/manage/quizes.php'));
	}
?>
<main>
	<section>
		<div class="container">
				<h1 class="text-center">Modifier <?php echo $quiz->title; ?></h1>
				<form action="<?php echo url_for('content/admin/manage/update/quiz.php?id='.$_GET['id']); ?>" method="POST">
					<label for="quiz_title">Titre du Quiz</label>
					<input type="text" name="quiz_title" id="quiz_title" value="<?php echo $quiz->title; ?>" required>
					<button type="button" id="add-question-btn">Ajouter Question</button>
					<div id="questions-wrapper">
						<?php
							$questions = json_decode($quiz->questions);
							for($i=1;$i<=count($questions);$i++) {
						?>
						<div class="question-wrapper" data-question-no="<?php echo $i; ?>">
							<h2>Question <?php echo $i; ?></h2>
							<label for="question_name_<?php echo $i; ?>">Nom de la Question <?php echo $i; ?></label>
							<input type="text" name="questions_names[]" id="question_name_<?php echo $i; ?>" value="<?php echo $questions[$i-1]->name; ?>">
							<label for="question_text_<?php echo $i; ?>">Texte  de la Question No.<?php echo $i;?></label>
							<input type="text" name="questions_texts[]" id="question_text_<?php echo $i; ?>" value="<?php echo $questions[$i-1]->text; ?>">
							<label for="question_answer_<?php echo $i; ?>">Reponse de la Question No.<?php echo $i; ?></label>
							<input type="text" name="questions_answers[]" id="question_answer_<?php  echo $i;?>" value="<?php echo $questions[$i-1]->answer ?>">
							<label for="question_score_<?php echo $i; ?>">Score de la Question No.<?php echo $i;?></label>
							<input type="number" name="questions_scores[]" id="question_score_<?php echo $i; ?>" min="1" value="<?php echo $questions[$i-1]->score; ?>">
							<label for="question_type_<?php echo $i; ?>">Type de la Question No.<?php echo $i; ?></label>
							<select name="questions_types[]" class="question_type_select" id="question_type_<?php echo $i; ?>">
								<option value="text" <?php if ($questions[$i-1]->type=="text") {
									echo 'selected';
								} ?>>Text</option>
								<option value="radio" <?php if ($questions[$i-1]->type=="radio") {
									echo 'selected';
								} ?>>Radio</option>
								<option value="checkbox" <?php if ($questions[$i-1]->type=="checkbox") {
									echo 'selected';
								} ?>>Checkbox</option>
							</select>
							<div id="choices-input-wrapper-<?php echo $i; ?>">
							<?php
								if ($questions[$i-1]->type=="radio" || $questions[$i-1]->type=="checkbox") {
							?>
							
								<label for="question_choices_<?php echo $i; ?>">Option de la Question No.<?php echo $i; ?></label>
								<p>Séparez les options avec "|"</p>
								<input type="text" name="question_<?php echo $i; ?>_choices" id="question_choices_<?php echo $i; ?>" placeholder="option1|option2|option3|....." value="<?php echo implode("|", $questions[$i-1]->choices); ?>">
							
							<?php
								}
							?>
							</div>
						</div>
						<?php
							}
						?>
					</div>
					<div class="flex justify-between align-center">
						<a href="<?php echo url_for('content/admin/manage/quizes.php/'); ?>">Retour</a>
						<button type="submit" class="submit-button">Actualiser</button> 
					</div>
				</form>
			
		</div>
	</section>
</main>

<?php
	include COMMON_PATH . '/footer.php';
?>