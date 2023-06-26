<body>
	<header id="header">
		<div class="container">
			<div class="flex align-center justify-between header-wrapper">
				<div id="header-logo">
					<a href="<?php echo url_for('index.php'); ?>"><img src=""></a>
				</div>
				<nav id="main-nav-bar">
					<ul class="flex align-center justify-end nav-links">
						<li class="nav-link"><a href="<?php echo url_for('content/admin/manage/users.php'); ?>">Gestion Utilisateurs</a></li>
						<li class="nav-link"><a href="<?php echo url_for('content/admin/manage/quizes.php'); ?>">Gestion Quizs</a></li>
						<li class="nav-link"><a href="<?php echo url_for('logout.php'); ?>">Se Déconnecter</a></li>
					</ul>
				</nav>
			</div>
		</div>
	</header>
