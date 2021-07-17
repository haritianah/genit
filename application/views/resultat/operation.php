<h1>Calcul des résultats</h1>
<?php
if (isset($semestre)){
    ?>
    <h2 align="center">Résultat <?= $semestre ?></h2>
    <div class="container">
        <table border="1" class="table">
            <tr>
              <th colspan="3" class="text-center">Etudiant</th>
              <th colspan="<?= in_array($semestre,get_semestre_pair()) ? 4 : 2 ?>" class="text-center">Résultats</th>
            </tr>
            <tr>
                <td>ID</td>
                <td>Nom</td>
                <td>Prénoms</td>
                <td>Crédits validés</td>
                <td>Résultat</td>
                <?php
                if (in_array($semestre,get_semestre_pair())){
                echo "<td>Crédit Total</td>";
                echo "<td>Résultat annuel</td>";
                }
                ?>

            </tr>
    <?php
    //SEMESTRE IMPAIR | SANS CALCUL
    if (in_array($semestre,get_semestre_impair())):
        $sumCredtSemestre = $this->model_fiche->get_sumCredtBySemestre($semestre);
        $limitSemestre = limit($sumCredtSemestre);
        foreach ($etudiants as $etudiant) {
            $sumCredtAcq = $this->model_fiche->get_sumCredtEtudBySemestre($etudiant->id_etudiant,$semestre);
            //Résultat semestre
            $resultat = $sumCredtAcq == $sumCredtSemestre ? "Admis" : 'Sous réserve';
            echo "<tr>";
                echo "<td>$etudiant->id_etudiant </td>";
                echo "<td>$etudiant->nom </td>";
                echo "<td>$etudiant->prenom </td>";
                echo "<td>$sumCredtAcq/$sumCredtSemestre </td>";
                echo "<td>$resultat </td>";
            echo "</tr>";
        }
    endif;

    //SEMESTRE PAIR | AVEC CALCUL
    if (in_array($semestre,get_semestre_pair())):
        $sumCredtSemestre = $this->model_fiche->get_sumCredtBySemestre($semestre);
        $limitSemestre = limit($sumCredtSemestre);
        foreach ($etudiants as $etudiant) {
            $sumCredtAcq = $this->model_fiche->get_sumCredtEtudBySemestre($etudiant->id_etudiant,$semestre);
            $sumCredtAcqNiv = $this->model_fiche->get_sumCredtEtudByNiv($etudiant->id_etudiant,$niveau);
            $sumCredtEtdGlob = $this->model_fiche->get_sumCredtEtud($etudiant->id_etudiant);
            $sumCredtGlob = $this->model_fiche->get_sumCredt($niveau);
            //
            $countSessExpire = $this->model_fiche->get_sessionExpire($etudiant);
            //Résultat semestre
            if ($sumCredtAcq < $limitSemestre ||$sumCredtAcqNiv < $limitNiv || $countSessExpire != 0){
                $resultat= "Refusé(e)";
            }elseif ($sumCredtAcq >= $limitSemestre && $sumCredtAcq < $sumCredtSemestre){
                $resultat = "Sous réserve";
            }else{
                $resultat = "Admis";
            }
            //Décision
            if ($niveau =='L3' || $niveau =='M2'){
                $decision = $sumCredtEtdGlob == $sumCredtGlob ? "ADMIS" : "AJN";
            }else{
                if ($sumCredtAcqNiv < $limitNiv || $countSessExpire != 0){
                    $decision = 'AJN';
                }elseif($sumCredtAcqNiv >= $limitNiv && $sumCredtAcqNiv < $sumCredtNiv){
                    $decision = 'ADMAJN';
                }else{
                    $decision = 'ADMIS';
                }
            }
            $textdecision = $this->model_fiche->get_textDecision($decision,$niveau);
            //Insert décision
            $this->model_fiche->insertDecision($etudiant,$niveau,$decision);
            //Reset Session Expire
            $this->model_fiche->resetSessExpire($etudiant->id_etudiant);
            //Session Expire | M2 finissant
            if ($decision == "AJN" && $countSessExpire != 0){
                $this->db->set('old','t');
                $this->db->where('id_etudiant',$etudiant->id_etudiant);
                $this->db->update('etudiant');
            }
            if ($etudiant->niveau == "M2" && $decision == "ADMIS"){
                $this->db->set('old','t');
                $this->db->where('id_etudiant',$etudiant->id_etudiant);
                $this->db->update('etudiant');
            }
            echo "<tr>";
                echo "<td>$etudiant->id_etudiant($etudiant->etat) </td>";
                echo "<td>$etudiant->nom </td>";
                echo "<td>$etudiant->prenom </td>";
                echo "<td>$sumCredtAcq/$sumCredtSemestre </td>";
                echo "<td>$resultat</td>";
                echo "<td>$sumCredtAcqNiv/$sumCredtNiv</td>";
                echo "<td>$textdecision</td>";
            echo "</tr>";
        }
    endif;
    ?>
        </table>
    </div>
    <?php
}else{
    // SHOW NIVEAU AND SEMSTRE
    if (!isset($niveau)):
        $this->app->niveau('resultat/operation','index');
    else:
        $this->app->semestre("resultat/operation/calc",$semestres);
    endif;
}

