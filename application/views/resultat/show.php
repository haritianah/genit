<h1 class="mask">Affichage Résultats <?php echo isset($niveau) ? $niveau : "" ?></h1>
<?php
    !isset($niveau) ? $this->app->niveau('resultat','show') : true;
?>
<?php if (!empty($niveau) && empty($des)): ?>

<table class="table table-bordered">
    <tr>
        <th>ID</th>
        <th>NOM</th>
        <th>PRENOMS</th>
        <th>RESULTAT ANNUEL</th>
        <th>MATIERES A REPECHER</th>
    </tr>
<?php
    foreach ($etudiants as $etudiant){
        $decision = $this->model_etudiants->get_decision($etudiant->id_etudiant,$niveau)->decision;
        $countSessionExpire = $this->model_fiche->get_sessionExpire($etudiant);
        $obj_matRat = $this->model_etudiants->get_matiereRat($etudiant->id_etudiant);
        $matiereRat = array();
        //Compteur
        if ($decision=='AJN'){
            if ($countSessionExpire==0){
                $countRef++;
            }else{
                $countExp++;
            }
        }elseif ($decision=='ADMAJN'){
            $countRat++;
        }elseif ($decision=='ADMIS'){
            $countAdm++;
        }
        //Matiere a repecher
        foreach ($obj_matRat as $matRat) {
            array_push($matiereRat,$matRat->nom_matiere);
        }
        if ($countSessionExpire !=0){
            $plainMatiereRat = "SESSION EXPIREE";
        }else{
            $plainMatiereRat = implode(";",$matiereRat);
            if (empty($plainMatiereRat)){
                $plainMatiereRat = 'AUCUNE';
            }
        }
        echo "<tr>";
            echo "<td> {$etudiant->id_etudiant} </td>";
            echo "<td> {$etudiant->nom} </td>";
            echo "<td> {$etudiant->prenom} </td>";
            echo "<td> {$this->model_fiche->get_textDecision($decision,$niveau)} </td>";
            echo "<td> $plainMatiereRat </td>";
        echo "</tr>";
    }
?>
</table>
    <div class="table-bordered">
        <p><a href="<?= base_url("resultat/show/$niveau/ADMIS") ?>">Admis : <?= $countAdm ?></a><a href="<?= base_url("resultat/pdf/$niveau/ADMIS") ?>">
                <button class="btn btn-dark mask"> PDF</button></a></p>
        <p><a href="<?= base_url("resultat/show/$niveau/ADMAJN") ?>">Admis sous réserve : <?= $countRat ?></a><a href="<?= base_url("resultat/pdf/$niveau/ADMAJN") ?>">
                <button class="btn btn-dark mask"> PDF</button></a></p>
        <p><a href="<?= base_url("resultat/show/$niveau/AJN") ?>">Refusé(s) : <?= $countRef ?></a><a href="<?= base_url("resultat/pdf/$niveau/AJN") ?>">
                <button class="btn btn-dark mask"> PDF</button></a></p>
        <p><a href="<?= base_url("resultat/show/$niveau/EXP") ?>">Session(s) expirée(s): <?= $countExp ?></a><a href="<?= base_url("resultat/pdf/$niveau/EXP") ?>">
                <button class="btn btn-dark mask"> PDF</button></a></p>
    </div>
    <table class='table'>
        <tr>
            <td></td>
            <TD>Antananarivo, le......</TD>
        </tr>
        <tr>
            <td>Les membres du jury</td>
            <td>Le président du jury</td>
        </tr>

    </table>
<!--Résultat par décision -->
<?php elseif(!empty($des)): $count =0; ?>
    <h2 align="center">Liste des étudiants <?= $text ?></h2>
<ol>
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
</ol>
    <br>
<p>Arrêté la présente liste à <?= $count ?> (<?= trim(convertir($count)) ?>) étudiant(s)</p>
<?php endif;  ?>
