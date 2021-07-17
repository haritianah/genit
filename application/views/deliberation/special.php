<h1>LISTE NOTES 10.01</h1><BR><BR>

<table class="table table-responsive-md">
	<tr>
		<th>ID</th>
		<th>NOM</th>
		<th>PRENOM</th>
		<th>MATIERE</th>
	</tr>
	<?php
	foreach ($results as $result) {
		echo "<tr>";
			echo "<td>".$result->id_etudiant."</td>";
			echo "<td>".$result->nom."</td>";
			echo "<td>".$result->prenom."</td>";
			echo "<td>".$result->nom_matiere."</td>";
		echo "</tr>";
		}
	?>
</table>
