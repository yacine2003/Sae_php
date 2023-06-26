$(document).ready(function(){
	/*************CREATE QUIZ FORM*******************/
	const addQuestionsBtn = $("#add-question-btn");
	const questionsWrapper = $("#questions-wrapper");
	const questionWrapper = $(".question-wrapper");
	console.log(questionWrapper.length);
	var questionNo = questionWrapper.length;
	addQuestionsBtn.on('click',function(){
		questionNo++;
		var newQuestionNode = "<div class=\"question-wrapper\" data-question-no=\""+questionNo+"\">";
		newQuestionNode += "<h2>Question "+questionNo+"</h2>";
		newQuestionNode += "<label for=\"question_name_"+questionNo+"\">Nom de la Question "+questionNo+"</label>";
		newQuestionNode += "<input type=\"text\" name=\"questions_names[]\" id=\"question_name_"+questionNo+"\">";
		newQuestionNode += "<label for=\"question_text_"+questionNo+"\">Texte  de la Question No."+questionNo+"</label>";
		newQuestionNode += "<input type=\"text\" name=\"questions_texts[]\" id=\"question_text_"+questionNo+"\">";
		newQuestionNode += "<label for=\"question_answer_"+questionNo+"\">Reponse de la Question No."+questionNo+"</label>";
		newQuestionNode += "<p>Si le type de réponse sera checkbox, separez les options par \"|\"</p>";
		newQuestionNode += "<input type=\"text\" name=\"questions_answers[]\" id=\"question_answer_"+questionNo+"\">";
		newQuestionNode += "<label for=\"question_score_"+questionNo+"\">Score de la Question No."+questionNo+"</label>";
		newQuestionNode += "<input type=\"number\" name=\"questions_scores[]\" id=\"question_score_"+questionNo+"\" min=\"1\">";
		newQuestionNode += "<label for=\"question_type_"+questionNo+"\">Type de la Question No."+questionNo+"</label>";
		newQuestionNode += "<select name=\"questions_types[]\" class=\"question_type_select\" id=\"question_type_"+questionNo+"\">";
		newQuestionNode += "<option value=\"text\">Text</option>";
		newQuestionNode += "<option value=\"radio\">Radio</option>";
		newQuestionNode += "<option value=\"checkbox\">Checkbox</option>";
		newQuestionNode += "</select>";
		newQuestionNode += "<div id=\"choices-input-wrapper-"+questionNo+"\"></div>";
		newQuestionNode += "</div>";
		
		questionsWrapper.append(newQuestionNode);
		$(".question_type_select").on('change',setQuestionType);
		
	})
	$(".question_type_select").on('change',setQuestionType);
	function setQuestionType(){
		console.log('add')
		const questionNode = $(this).parent();
		const questionNo = $(this).parent().attr('data-question-no');
		const selectedQuestionType = $(this).val();
		const choicesInputWrapper = $("#choices-input-wrapper-"+questionNo);

		if (selectedQuestionType=='radio' || selectedQuestionType=='checkbox') {
			choicesInput = "<label for=\"question_choices_"+questionNo+"\">Options de la Question No."+questionNo+"</label>";
			choicesInput += "<p>Séparez les options avec \"|\"</p>";
			choicesInput += "<input type=\"text\" name=\"question_"+questionNo+"_choices\" id=\"question_choices_"+questionNo+"\" placeholder=\"option1|option2|option3|.....\">";
			choicesInputWrapper.html(choicesInput);
		}else if(selectedQuestionType=='text'){
			choicesInputWrapper.html('');
		}
		questionNode.append(choicesInputWrapper);
	}
})