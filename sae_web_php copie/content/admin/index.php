<?php
	require_once '../../include/config.php';
	$page_title = "Admin";
	include COMMON_PATH . '/head.php';
	include COMMON_PATH . '/admin_header.php';

	if (!isset($_SESSION['user_id']) || $_SESSION['user_type']!=='admin') {
		header("Location: ".url_for('index.php'));
	}
?>
<main>
	<section>
		<div class="container">
			<h1 class="text-center">Bonjour Admin</h1><br>
			<p>Ici vous pouvez gérer les utilisateurs ainsi que les quizs.</p>
		</div>
	</section>
</main>

<?php
	include COMMON_PATH . '/footer.php';
?>