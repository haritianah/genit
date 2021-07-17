<table class="table table-bordered">
    <tr>
        <td>ID</td>
        <td>NOM</td>
        <td>PRENOMS</td>
        <td>NIVEAU</td>
        <td>MATIERE</td>
        <td>RESULTAT</td>
    </tr>
    <tr>
        <td><?= $etudiant->id_etudiant ?></td>
        <td><?= $etudiant->nom ?></td>
        <td><?= $etudiant->prenom ?></td>
        <td><?= $etudiant->niveau ?></td>
        <td><?= $matiere->nom_matiere ?></td>
        <td><select name="" id="select" class="form-control">
                <option value="<?= $resultat->resultat=='AJN' ? 'AJN' : 'ACQ' ?>"><?= $resultat->resultat=='AJN' ? 'Refusé' : 'Validé' ?></option>
                <option value="<?= $resultat->resultat=='AJN' ? 'ACQ' : 'AJN' ?>"><?= $resultat->resultat=='AJN' ? 'Validé' : 'Refusé' ?></option>
            </select></td>
    </tr>
</table>
<div class="container">
    <div style="width: 30%; margin: auto">
        <button id="modButton" class="btn btn-success form-control">Modifier</button>
    </div>
</div>
<div id="query_result" class="alert-info"></div>

<script>
    $(document).ready(function () {
        $('#query_result').hide();
       $('#modButton').click(function () {
           var param = 'resultat='+$('#select').val();
           param += '&mat='+<?= $matiere->id_matiere ?>;
           param+= "&id=<?= $etudiant->id_etudiant ?>";
           $.ajax({
               url: "<?= base_url('ajax/resultat_update') ?>",
               method: "POST",
               data: param,
               success: function (data) {
                   $('#query_result').html(data);
                   $('#query_result').slideDown();
                   setTimeout(function () {$('#query_result').slideUp()},2000);
               }
           })
       })
    });
</script>