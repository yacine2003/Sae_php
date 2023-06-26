<?php
	require_once '../../include/config.php';
	$page_title = "Quiz";
	include COMMON_PATH . '/head.php';
	include COMMON_PATH . '/header.php';

	if (!isset($_SESSION['user_id']) || $_SESSION['user_type']!=='user') {
		header("Location: ".url_for('index.php'));
	}

	if (!isset($_GET['id'])) {
		header("Location: ".url_for('content/user/index.php'));
	}else if(isset($_GET['id'])){
		Quiz::define_db_conn($db_conn);
		$quiz = Quiz::select_by_id($_GET['id']);
		$questions = json_decode($quiz->questions);
	}
?>
<?php
	$questions_handlers = [
		'text'=>'text_question',
		'radio'=>'radio_question',
		'checkbox'=>'checkbox_question'
	];

	function text_question($question){
		$question_node = "";
		$question_node.="<p class=\"question-text\">".$question->text."</p>";
		$question_node.="<input type=\"text\" name=\"".$question->name."\">";
		return $question_node;
	}
	function radio_question($question){
		$question_node = "";
		$question_node.="<p class=\"question-text\">".$question->text."</p>";
		foreach ($question->choices as $choice) {
			$question_node.="<div class=\"flex justify-start align-center input-wrapper\">";
			$question_node.="<input type=\"radio\" name=\"".$question->name."\" value=\"".$choice."\" id=\"".$choice."\" >";
			$question_node.="<label for=\"".$choice."\" >".$choice."</label>";
			$question_node.="</div>";
		}
		return $question_node;
	}
	function checkbox_question($question){
		$question_node = "";
		$question_node.="<p class=\"question-text\">".$question->text."</p>";
		foreach ($question->choices as $choice) {
			$question_node.="<div class=\"flex justify-start align-center input-wrapper\">";
			$question_node.="<input type=\"checkbox\" name=\"".$question->name."[]\" value=\"".$choice."\" id=\"".$choice."\" >";
			$question_node.="<label for=\"".$choice."\" >".$choice."</label>";
			$question_node.="</div>";
		}
		return $question_node;
	}

	$answers_handlers = [
		'text'=>'text_answer',
		'radio'=>'radio_answer',
		'checkbox'=>'checkbox_answer'
	];

	function text_answer($question,$answer_input){
		global $question_correct,$score;
		if ($answer_input==NULL) { return;}
		if ($answer_input==$question->answer) {
			$question_correct++;
			$score+=$question->score;
		}
	}
	function radio_answer($question,$answer_input){
		global $question_correct,$score;
		if ($answer_input==NULL) { return;}
		if ($answer_input==$question->answer) {
			$question_correct++;
			$score+=$question->score;
		}
	}
	function checkbox_answer($question,$answer_input){
		global $question_correct,$score;
		if ($answer_input==NULL) { return;}
		$error = false;
		$answers = explode("|", $question->answer);
		foreach ($answer_input as $selected_option) {
			if (!in_array($selected_option, answers)) {
				$error = true;
			}
		}
		if (!$error) {
			$question_correct++;
			$score+=$question->score;
		}
	}
?>
<?php
	if ($_SERVER['REQUEST_METHOD']=="POST") {
		$questions_total = 0;
		$question_correct = 0;
		$score_max = 0;
		$score = 0;
		foreach ($questions as $question) {
			$questions_total++;
			$score_max+=$question->score;
			$answer_input = $_POST[$question->name] ?? NULL;
			$answers_handlers[$question->type]($question,$answer_input);
		}
		$quiz_results = "Réponses correctes:" . $question_correct . "/" . $questions_total ."<br/>Votre score: " . $score . "/" . $score_max ."<br/>";
	}

?>
<main>
	<section>
		<div class="container">
			<h1 class="text-center"><?php echo $quiz->title; ?></h1>
			<?php
				if (!isset($quiz_results)) {
			?>
			<form action="<?php echo url_for('content/user/quiz.php?id='.$_GET['id']); ?>" method="POST">
			<?php
				
				foreach ($questions as $question) {
					echo $questions_handlers[$question->type]($question);
				}
			?>
				<button type="submit" class="submit-button">Repondre</button>
			</form>
			<?php
				}else{
					echo "<p>".$quiz_results."</p>";
				}
			?>
		</div>
	</section>
</main>

<?php
	include COMMON_PATH . '/footer.php';
?>