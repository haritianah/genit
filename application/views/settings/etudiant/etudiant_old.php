<?php
if (empty($niveau)){
	$this->app->niveau('settings/etudiant/old');
}else{
	?>
		<div class="container">
			<a href="<?= base_url('settings/etudiant/deleteold') ?>"></a>
		</div>
	<table class="table table-condensed">
		<thead>
		<tr>
			<th>ID</th>
			<th>Nom</th>
			<th>Prenom</th>
			<th>Sexe</th>
			<th>Naissance</th>
			<th>Adresse</th>
			<th>Telephone</th>
			<th>Niveau</th>
			<th>Année</th>
		</tr>
		</thead>
		<tbody>
		<?php foreach ($oldEtudiants as $oldEtudiant): ?>
		<tr>
			<td><a href="<?= base_url('fiche/old/').$oldEtudiant->id_etudiant ?>"><?= $oldEtudiant->id_etudiant ?></a></td>
			<td><?= $oldEtudiant->nom ?></td>
			<td><?= $oldEtudiant->prenom ?></td>
			<td><?= $oldEtudiant->sexe ?></td>
			<td><?= $oldEtudiant->naissance ?></td>
			<td><?= $oldEtudiant->adresse ?></td>
			<td><?= $oldEtudiant->telephone ?></td>
			<td><?= $oldEtudiant->niveau ?></td>
			<td><?= $oldEtudiant->annee_etude ?></td>
		</tr>
	<?php endforeach; ?>
		</tbody>
	</table>
<?php
}
