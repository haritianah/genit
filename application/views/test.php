<p>UNIVERSITE D'ANTANANARIVO</p>
<p>DOMAINE ARTS, LETTRES ET SCIENCES HUMAINES</p>

<P align="center">MENTION PSYCHOLOGIE SOCIALE ET INTERCULTURELLE</P>
<P align="center">ANNEE UNIVERSITAIRE <?= $_SESSION['annee_etude']-1 ?> - <?= $_SESSION['annee_etude'] ?></P>

<h1>Liste ?? ??</h1>

<?php foreach ($idDes as $etudiant): ?>
    <?php
    $countSessionExpire = $this->model_fiche->get_sessionExpire($etudiant);
    if ($des == 'EXP' && $countSessionExpire!=0){
        echo "<li> $etudiant->nom $etudiant->prenom </li>";
        $count++;
    }elseif ($des!= 'EXP' && $countSessionExpire==0){
        echo "<li> $etudiant->nom $etudiant->prenom </li>";
        $count++;
    }
    ?>
<?php endforeach; ?>

<p>Arrêté la présente liste à <?= $count ?> (<?= trim(convertir($count)) ?>) étudiants</p>
