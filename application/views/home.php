<h1>GESTION DES ETUDIANTS ET DES NOTES INFORMATISEE TRANSITOIRE (G.E.N.I.T)</h1>
<?php
if(!isset($niveau)):
$this->app->niveau("home","liste");
else:
//    debug($list);
	$admincon= app::adminCon(9);
	$niv2= get_niv2($niveau);
	$rang = 1;
 ?>
 <p class="alert alert-info">Cliquez sur l'ID pour afficher la fiche</p>
<div id="divse">
<table class="table table-bordered listetud" id="expTable">
<tr class="titreet">
	<th>ID</th>
	<th>Num</th>
	<th>Etat</th>
	<th>Nom</th>
	<th>Prenom</th>
	<th>Sexe</th>
	<th>Naissance</th>
	<th>Adresse</th>
	<th>Telephone</th>
	<th>Niveau</th>
	<?php
	if($admincon){
		echo "<th>Modifier</th>";
	}
	?>
</tr>
<?php foreach ($list as $etudiant):?>
	<?php

	if($etudiant->naissance=="0000-00-00"){
		$aniv=0;
	}else{
		$aniv= date_format( date_create($etudiant->naissance),'d-M-Y') ;
	}
	if($etudiant->etat=='Rat' || $etudiant->niveau==$niveau):
        //fill idArray
        if ($etudiant->niveau==$niveau) {
            $idArray[$etudiant->id_etudiant]['Id']= $etudiant->id_etudiant;
            $idArray[$etudiant->id_etudiant]['href']=base_url("fiche/original/").$etudiant->id_etudiant ;
            $href = base_url("fiche/original/").$etudiant->id_etudiant;
        }else{
            $idArray[$etudiant->id_etudiant]['Id']= $etudiant->id_etudiant;
            $idArray[$etudiant->id_etudiant]['href']=base_url("fiche/recherche/").$etudiant->id_etudiant.'/'.$niveau ;
            $href= base_url("fiche/recherche/").$etudiant->id_etudiant.'/'.$niveau ;
        }
	 ?>
	<tr>
		<td><a href="<?= $href ?>" <?php affichecolor($etudiant->inscrit) ?>><?= $etudiant->id_etudiant?></td>
			<td><?= $rang ?> |<?php $rang++; #$etudiant->num_etudiant ?></td>
			<td><?php
			if ($etudiant->etat =="Red") {
				echo "Rd";
			}elseif ($etudiant->etat=='Rat') {
				echo "Rt";
			}else{
				echo $etudiant->etat;
			}
			 ?></td>
			<td class="paire"><?= $etudiant->nom?></td>
			<td><?= $etudiant->prenom?></td>
			<td class="paire"><?= $etudiant->sexe?></td>
			<td><?= $aniv?></td>
			<td class="paire"><?= $etudiant->adresse?></td>
			<td><?= $etudiant->telephone?></td>
			<td class="paire"><?= $etudiant->niveau?></a></td>
			<?php
			if($admincon){
			?>
			<td><a href="<?= base_url() ?>settings/etudiant/update/<?= $etudiant->id_etudiant ?>">MAJ</a></td>
			<?php
			}
			?>
	</tr>
<?php endif;
endforeach;
    unset($_SESSION['idArray']);
	$this->session->set_userdata('idArray',$idArray);
?>
<?php endif; ?>
</table>
    <div class="box-search">
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
    </div>
