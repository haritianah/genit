<?php
?>
<div class="jumbotron">
	<h2><span class="bg-info"><?= count($etudiantToDel) ?></span> étudiants</h2>
</div>
<form action="" method="post">
	<table class="table table-dark">
		<thead>
			<tr>
				<th><input type="checkbox" name="all" id="checkAll"></th>
				<th>ID</th>
				<th>Nom</th>
				<th>Prénoms</th>
				<th>Sexe</th>
				<th>Niveau</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($etudiantToDel as $item): ?>
			<tr>
				<td><input type="checkbox" class="checkitem" name="select[<?= $item->id_etudiant ?>]"></td>
				<td><?= $item->id_etudiant ?></td>
				<td><?= $item->nom ?></td>
				<td><?= $item->prenom ?></td>
				<td><?= $item->sexe ?></td>
				<td><?= $item->niveau ?></td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	<div class="container">
		<input type="submit" value="Supprimer">
	</div>
</form>
<script>
$("#checkAll").click(function(){
    $('input:checkbox').not(this).prop('checked', this.checked);
});
$('.checkitem').change(function(){
	if($(this).prop("checked")===false){
		$('#checkAll').prop("checked",false)
	}
	if($('.checkitem:checked').length == $('input:checkbox').length -1){
		$('#checkAll').prop("checked",true)
	}
})
</script>
