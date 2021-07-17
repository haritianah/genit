<html>
<head>
	<meta charset='utf-8'>
	<link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/css/template.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url()?>/assets/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url()?>/assets/css/ionicons.min.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url()?>/assets/css/Login-Form-Clean.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url()?>/assets/css/Navigation-with-Search.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url()?>/assets/css/Navigation-with-Button.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url()?>/assets/css/Custom-File-Upload.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url()?>/assets/css/styles.css" media="screen">
    <link rel="stylesheet" type="text/css" href="<?= base_url()?>/assets/css/stylebul.css" media ="print">
    <?php if (isset($third_css)): ?>
    <?php foreach ($third_css as $third): ?>
        <link rel="stylesheet" type="text/css" href="<?= base_url()?>/assets/css/third/<?=$third ?>">
    <?php endforeach; ?>
    <?php endif; ?>
    <script src="<?= base_url()?>/assets/js/jquery-3.4.1.min.js"></script>
	<script src="<?=base_url()?>/assets/js/bootstrap.min.js"></script>
	<script src="<?=base_url()?>/assets/js/Custom-File-Upload.js"></script>
    <?php if (isset($third_js)): ?>
        <?php foreach ($third_js as $third): ?>
            <script src="<?=base_url()?>/assets/js/third/<?= $third ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>
	<link rel="icon" href="<?= base_url("images/logopsi.png")?>" type="image/png">
	<title><?= $title ?></title>
</head>
<body>
<header>
    <nav class="navbar navbar-light navbar-expand-md navigation-clean-button" style="background-color: #F1F7FC">
        <div class="container menu-container"><a class="navbar-brand psi-color" href="#" style="font-size: 24px;">PSI</a><button aria-expanded="false" data-toggle="collapse" class="navbar-toggler" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navcol-1">
                <ul class="nav navbar-nav mr-auto">
                    <li class="nav-item" role="presentation"><a class="nav-link" href="<?= base_url('home') ?>">Fiche</a></li>
                    <li class="nav-item" role="presentation"></li>
                    <li class="nav-item dropdown"><a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#">Notes</a>
                        <div class="dropdown-menu" role="menu">
                            <a class="dropdown-item" role="presentation" href="<?= base_url('notes/insert') ?>">Insérer</a>
                            <a class="dropdown-item" role="presentation" href="<?= base_url('notes/update') ?>">Modifier</a>
                            <a class="dropdown-item" role="presentation" href="<?= base_url('notes/show') ?>">Affichage</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown"><a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#">Résultats</a>
                        <div class="dropdown-menu" role="menu">
                            <a class="dropdown-item" role="presentation" href="<?= base_url('resultat/operation') ?>">Calcul</a>
                            <a class="dropdown-item" role="presentation" href="<?= base_url('resultat/update') ?>">Modification</a>
                            <a class="dropdown-item" role="presentation" href="<?= base_url('resultat/show') ?>">Affichage</a>
                            <a class="dropdown-item" role="presentation" href="#">Ancien étudiants</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown"><a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#">Paramètre</a>
                        <div class="dropdown-menu" role="menu">
                            <a class="dropdown-item" role="presentation" href="<?= base_url('settings/etudiant/insert') ?>">Etudiant</a>
                            <a class="dropdown-item" role="presentation" href="<?= base_url('settings/prof') ?>">Profésseur</a>
                            <a class="dropdown-item" role="presentation" href="<?= base_url('settings/matiere') ?>">Matière</a>
                            <a class="dropdown-item" role="presentation" href="#">Mise à jour A.U</a>
                            <a class="dropdown-item" role="presentation" href="#">Mot de passe</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown"><a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#">Délibération</a>
                        <div class="dropdown-menu" role="menu"><a class="dropdown-item" role="presentation" href="#">Fiche UE</a><a class="dropdown-item" role="presentation" href="#">Repêchage</a><a class="dropdown-item" role="presentation" href="#">Délibérer notes</a></div>
                    </li>
                </ul><span class="navbar-text actions"><a class="login" href="#">Log In</a> <a class="btn btn-light action-button psi-bg" role="button" href="#">Sign Up</a></span>
            </div>
        </div>
    </nav>
</header>
<div class="ctr">

	<div class="bodi">
		<div class="heads">
			<div class="fixed">
				<div id="univ" class="univs">
					<div class="domaine domaine2 left-box">
						<p>UNIVERSITE D'ANTANANARIVO <br> DOMAINE ARTS, LETTRES ET SCIENCES HUMAINES</P>
					</div>
					<div class="mention mention2 left-box">
						<p>ANNEE UNIVERSITAIRE <?php if(isset($_SESSION['annee_etude'])){echo $_SESSION['annee_etude'];} ?></p>
						<p>MENTION PSYCHOLOGIE SOCIALE ET &nbsp &nbsp &nbsp INTERCULTURELLE</p>
					</div>
				</div>

			</div>
		</div>
