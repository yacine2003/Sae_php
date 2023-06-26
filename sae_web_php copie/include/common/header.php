<body>
	<header id="header">
		<div class="container">
			<div class="flex align-center justify-between header-wrapper">
				<div id="header-logo">
					<a href="<?php echo url_for('index.php'); ?>"><img src=""></a>
				</div>
				<nav id="main-nav-bar">
					<ul class="flex align-center justify-end nav-links">
						<?php
							if (!isset($_SESSION['user_id'])) {
						?>
						<li class="nav-link"><a href="<?php echo url_for('signup.php'); ?>">S'inscrire</a></li>
						<li class="nav-link"><a href="<?php echo url_for('login.php'); ?>">Se Connecter</a></li>
						<?php
							}else if(isset($_SESSION['user_id']) && $_SESSION['user_type']=="user"){
						?>
						<li class="nav-link"><a href="<?php echo url_for('content/user/index.php'); ?>">Quizs</a></li>
						<li class="nav-link"><a href="<?php echo url_for('logout.php'); ?>">Se Déconnecter</a></li>
						<?php
							}
						?>
					</ul>
				</nav>
			</div>
		</div>
	</header>
