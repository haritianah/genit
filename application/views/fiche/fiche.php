<div class="bodi">
<?php $niveau = empty($niveau) ? $etudiant->niveau : $niveau; ?>
<b><p align="center" class="line nivprint" style="font-size:40px !important"><?= $niveau ?></p></b>
<h1>FICHE INDIVIDUELLE DE RESULTATS</h1><br>
<!-- Inof étudiant -->
<div align="center" class="infoetudiant">
    <p><b><?= $sexe ?></b></p>
    <?php
    $idArray = !isset($_SESSION['idArray']) ? array($id_etudiant=>array('id'=>$id_etudiant, 'href'=>base_url('fiche/original/').urlencode($id_etudiant))) : $_SESSION['idArray'];
    $date_n=date_create($etudiant->naissance);
    ?>
	<p align="center" class="line">Né(e) le : <?= date_format($date_n, 'd-M-Y') ?> à <?= $etudiant->lieu ?></p><br>
	<p class="line">NINE: <?= $etudiant->id_etudiant ?> <span class="mask">(<?= $etudiant->etat ?>)</span></p><br>
</div>
<!-- Navigation /masked -->
<div id="mask">
	<div class="form-search">
		<form action="" method="get">
			<select name="sel">
				<option>Selectionner Id</option>
			</select>
			<input type="submit" name="btn" value="Chercher">
		</form>
		<a href="delibnote.php?niv=niv" target="_blank"><button type="button" class="btn btn-primary">Corriger Notes</button></a>
		<a href=<?= base_url("fiche/recherche/".$etudiant->id_etudiant."/".get_nivAnte($niveau)) ?> target="_blank"><button type="button" class="btn btn-primary">Fiche antérieure</button></a>
		<form action="" method="get">
			<input type="hidden" name="id_etudiant" >
			<a href="<?= $this->model_fiche->get_nextHref($idArray,$etudiant->id_etudiant) ?>"><input type="button" name="btnSuiv" value="Suivant" class="btn btn-primary"></a>
			<a href="<?= $this->model_fiche->get_prevHref($idArray,$etudiant->id_etudiant) ?>"><input type="button" name="btnPrec" value="Précédent" class="btn btn-primary"></a>
		</form>
	</div>
</div>
<!-- Légendes -->
<div class="legend" align="left" style="width:80% margin-top:20px">
	<p><span>NV</span>: Non Validé<?php echo ". "; ?></p>
	<p style="padding-left:3px;"><span>VP:</span> Validé Passable<?php echo ". "; ?></p>
	<p style="padding-left:3px;"><span>VAB</span>: Validé Assez Bien<?php echo ". "; ?></p>
	<p style="padding-left:3px;"><span>VB</span>: Validé Bien<?php echo ". "; ?></p>
	<p style="padding-left:3px;"><span>VTB</span>: Validé Très Bien<?php echo ". "; ?></p>
</div>
<!-- Début Fiche -->
<!-- foreach semestre -->
    <?php
    foreach ($semestres as $obj_semestre):
    $semestre = $obj_semestre->semestre;
    $semestre= substr($semestre,1);
    $divSmstr = $semestre % 2;
    ?>
<div id="bulsem<?= $countsem ?>">
	<b><h2 class="sem">SEMESTRE <?= $semestre ?></h2></b>
<table class="bulletin" border=1>
<tr>
	<td rowspan="2" height="40" width="80" style="height:30.0pt;width:60pt" align="center">ENSEIGNEMENTS</td>
	<td rowspan="2">Vol Hor</td>
	<td rowspan="2">Crédits</td>
	<td rowspan=2>Coef</td>
	<td colspan="4"  width="349" style="border-left:none;width:262pt" align="center">SESSION NORMALE</td>
  <td colspan="4" width="320" style="border-left:none;width:240pt" align="center">SESSION RATTRAPAGE</td>
</tr>
<tr>
  <td height="20"  style="height:15.0pt;border-top:none;border-left:
  none">Notes</td>
  <td  style="border-top:none;border-left:none" align="center">MOYENNE UE</td>
  <td  style="border-top:none;border-left:none">Crédits acquis</td>
  <td  style="border-top:none;border-left:none">Mention</td>
  <td  style="border-top:none;border-left:none">Notes</td>
  <td  style="border-top:none;border-left:none" align="center">MOYENNE UE</td>
  <td  style="border-top:none;border-left:none">Crédits acquis</td>
  <td  style="border-top:none;border-left:none">Mention</td>
</tr>
<!-- Début stat  -->
    <?php
    $countsem++;
    $obj_unite = $this->model_fiche->get_unite($niveau,$obj_semestre->semestre);
    $sumCredSessN=0;
    $sumCredSessR=0;
    foreach ($obj_unite as $unite):
        $sumCredtUnit= $this->model_note->get_credt_unite($unite->id_unite);
        $idunit= $unite->id_unite;
        $obj_mat = $this->model_fiche->get_matiere($unite->id_unite,false);
        $rowspanmat= $obj_mat->num_rows() +1;
    ?>
<tr>
	<th><?= $unite->num_unite ?>: <?= $unite->nom_unite ?></th>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td rowspan=<?= $rowspanmat ?> align="center"><?= $arrNote[$idunit]['moyenneN'] ?></td>
	<td rowspan=<?= $rowspanmat ?> align="center"><?= $arrNote[$idunit]['credtN'] ?></td>
	<td rowspan=<?= $rowspanmat ?> align="center"><?= $arrNote[$idunit]['mentionN'] ?></td>
	<td></td>
	<td rowspan=<?= $rowspanmat ?> align="center"><?= $arrNote[$idunit]['moyenneR'] ?>
        <?= $arrNote[$idunit]['credtR'] != $arrNote[$idunit]['credtRO'] ? "<br><strike>".round($arrNote[$idunit]['moyenneRO'],2)."</strike>" : '' ?></td>
	<td rowspan=<?= $rowspanmat ?> align="center"><?= $arrNote[$idunit]['credtR'] ?>
        <?= $arrNote[$idunit]['credtR'] != $arrNote[$idunit]['credtRO'] ? "<br><strike>".$arrNote[$idunit]['credtRO']."</strike>" : '' ?></td>
	<td rowspan=<?= $rowspanmat ?> align="center"><?= $arrNote[$idunit]['mentionR'] ?>
        <?= $arrNote[$idunit]['credtR'] != $arrNote[$idunit]['credtRO'] ? "<br><strike>".$arrNote[$idunit]['mentionRO']."</strike>" : '' ?></td>
</tr>
    <?php
        $sumCredSessN+=$arrNote[$idunit]['credtN'];
        $sumCredSessR+=$arrNote[$idunit]['credtR'];
    ?>
<!-- Fin stat -->
<!-- Début Notes -->
   <?php foreach($obj_mat->result() as $matiere) :
        $idmat= $matiere->id_matiere;
   // Define in one tab all note
        $tabMat = $arrNote[$idunit][$idmat];
        $colorR = $tabMat['R'] != $tabMat['RO'] ? 'red' : $tabMat['colorR'];
        $codeNote = $tabMat['codeR'];
        ?>
<tr>
	<td class="tdmat"><?=$matiere->nom_matiere ?></td>
	<td align="center"><?=$matiere->vol_hor ?></td>
	<td align="center"><?=$matiere->credit ?></td>
	<TD></TD>
	<td class="a<?= $tabMat['colorN'] ?>" style="color:<?= $tabMat['colorN'] ?>"><?= $tabMat['N'] ?></td>
	<td class="a<?= $colorR ?>" style="color:<?= $colorR ?>">
        <?= $this->model_fiche->get_noteR($tabMat['colorR'],$tabMat['R'],$tabMat['RO']) ?>
        <?php if (app::adminCon(9) && $tabMat['anneeR'] == $etudiant->annee_etude):?>
		<a class="mask" href="<?= base_url('notes/update/code/').$codeNote ?>" target='_blank'><img src="<?= base_url("images/arrow.png")?>" width=10 height=10 ></a>
        <?php endif; ?>
	</td>
</tr>
   <?php
  endforeach;
endforeach;
    ?>
<!-- Fin notes -->
</table>
<!-- Fin fiche -->

<!-- Début résultat semestre -->
<?php
// Variables
    $sumCredtGlob = $this->model_fiche->get_sumCredt($niveau);
    $sumCredtNiv = $this->model_fiche->get_sumCredtByNiv($niveau);
        $limitNiv = limit($sumCredtNiv);
    $sumCredtSemstr = $this->model_fiche->get_sumCredtBySemestre($obj_semestre->semestre);
        $limitSemstr = limit($sumCredtSemstr);
    $sumCredtEtdGlob = $this->model_fiche->get_sumCredtEtud($etudiant->id_etudiant);
    $sumCredtEtdNiv = $this->model_fiche->get_sumCredtEtudByNiv($etudiant->id_etudiant,$niveau);
    $resulSemstrAnte = $this->model_fiche->get_resultAnteAjn($etudiant->id_etudiant,$obj_semestre->semestre);
    $countSessExpire = $this->model_fiche->get_sessionExpire($etudiant);
//Resultat semstre
    /*Session Normale*/
    $checkedSessN = $sumCredSessN!=$sumCredtSemstr ? 1 : 2;
    /*Session Rattrapage*/
    $checkedSessR = 0;
    if ($obj_semestre->semestre=='S6' || $obj_semestre->semestre=='S10'){
        $checkedSessR = $sumCredtEtdGlob == $sumCredtGlob ? 2 : 0;
    }else{
        if ($divSmstr==1){// Semestre impair
            $checkedSessR = $sumCredSessR==$sumCredtSemstr ? 2 : 1;
        }else{// Semestre pair
            if ($sumCredSessR < $limitSemstr || $sumCredtEtdNiv < $limitNiv || $countSessExpire!=0){
                $checkedSessR = 0;
            }elseif ($sumCredSessR >= $limitSemstr && $sumCredSessR < $sumCredtSemstr) {
                $checkedSessR = 1;
            }else{
                $checkedSessR = 2;
            }
        }
    }
//    debug($arrNote);
?>
    <br>
<div id="tableau_resultat1">
	<h2 class="semr"> RESULTATS SEMESTRE <?= $semestre ?></h2>
<table border=1 class="tabres">
	<tr>
		<th colspan=2 style="text-align:center">SESSION NORMALE</th>
		<th colspan=2 style="text-align:center">SESSION RATTRAPAGE</th>
	</tr>
	<tr>
		<td colspan=2>Crédits validés: <?= $sumCredSessN ?>/<?= $sumCredtSemstr ?></td>
		<!-- <td></td> -->
		<td colspan=2>Crédits validés: <?= $sumCredSessR ?>/<?= $sumCredtSemstr ?></td>
		<!-- <td></td> -->
	</tr>
	<tr>
		<td colspan=2>Résultat:
			Admis(e)<input type="checkbox" disabled <?= $checkedSessN==2 ? "checked" : "" ?>>
			Sous réserve<input type="checkbox" disabled <?= $checkedSessN==1 ? "checked" : "" ?>>
			Refusé(e)<input type="checkbox" disabled>
		</td>
		<!-- <td></td> -->
		<td colspan=2>Résultat:
			Admis(e)<input type="checkbox" disabled <?= $checkedSessR==2 ? "checked" : "" ?>>
			Sous réserve<input type="checkbox" disabled <?= $checkedSessR==1 ? "checked" : "" ?>>
			Refusé(e)<input type="checkbox" disabled <?= $checkedSessR==0 ? "checked" : "" ?>>
		</td>
		<!-- <td></td> -->
		<!-- If semstre impair -->
		<tr class="tanana">
			<td colspan=2><br>Antananarivo, le ...................</td>
			<td colspan=2><br>Antananarivo, le ...................</td>
		</tr>
		<tr class="jury">
			<td style="padding-left:60px">Les membres du Jury,</td>
			<td>Le Président du Jury, </td>
			<td style="padding-left:60px">Les membres du Jury,</td>
			<td>Le Président du Jury, </td>
		</tr>
</table>
</div>
</div>
    <?php
    endforeach;
    ?>
<!-- Début résultat annuel -->
<?php if ($divSmstr==0):?>
    <?php

        if ($niveau =='L3' || $niveau =='M2'){
            $decision = $sumCredtEtdGlob == $sumCredtGlob ? "ADMIS" : "AJN";
        }else{
            if ($sumCredtEtdNiv < $limitNiv || $countSessExpire != 0){
                $decision = 'AJN';
            }elseif($sumCredtEtdNiv >= $limitNiv && $sumCredtEtdNiv < $sumCredtNiv){
                $decision = 'ADMAJN';
            }else{
                $decision = 'ADMIS';
            }
        }
        //insert decision
        $this->model_fiche->insertDecision($etudiant,$niveau,$decision);
        //Session expire | M2 finissant
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

    ?>
 <table border=1 class="tabres" style="margin-top: 70px; ">
	<tr>
		<TH colspan=4 style="padding:10px"> RESULTAT ANNUEL: <?= $this->model_fiche->get_textDecision($decision,$niveau) ?>
            <?php
            if ($decision == "AJN" && $countSessExpire != 0) {
                echo "<span style='color:red;' class='ared'>(Non autorisé(e) à se réinscrire à la mention PSI)</span>";
            }
            ?>
        </TH>
	</tr>
	<tr class="jury">
		<td style="padding-left:60px">Les membres du Jury,</td>
		<td>Le Président du Jury, </td>
	</tr>
</table>
<?php endif; ?>
    <!-- Fin résultat annuel -->
<div class="doyen" align="center">
    <p>Le Doyen de la Facult&eacute des Lettres <br>et Sciences Humaines</P>
</div>
    <a class="mask" href="<?= base_url('fiche/pdf/').$etudiant->id_etudiant.'/'.$niveau ?>"><button type="button" class="btn btn-dark">PDF</button></a>
