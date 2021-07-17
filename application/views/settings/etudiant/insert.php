<h1>INSERER ETUDIANT</h1>
<form action="" enctype="multipart/form-data" id="form">
    <input type="file" name="file" id="file" accept=".xlsx,.xls">
    <div class="form-check">
        <input class="form-check-input" type="checkbox" id="firstrow" name="firstline">
        <label class="form-check-label" for="defaultCheck1">
            Titre en première ligne
        </label>
    </div>
    <button type="submit" class="btn btn-primary">Importer</button>
</form>
<div class="alert alert-info">Veuillez mettre le fichier excel sous le même format que le tableau suivant</div>
<table class="table table-inverse" id="table">
    <tr>
        <th>ID</th>
        <th>Nom</th>
        <th>Prénom</th>
        <th>Sexe</th>
        <th>Date de naissance</th>
        <th>Lieu de naissance</th>
        <th>Adresse</th>
        <th>Telephone</th>
    </tr>
</table>
<div id="error"></div>
<script>
    $(document).ready(function () {
       $('#form').submit(function (e) {
           e.preventDefault();
           var fd = new FormData(this);
           $.ajax({
               url : "<?= base_url('ajax/insert_etudiant') ?>",
               method : 'POST',
               contentType : false,
               processData : false,
               data : fd,
               success : function (data) {
                   $('.result').remove();
                   $('#table').append(data);
               },
               error : function () {
                   alert('ERROR');
               }
           });
       })
    });
</script>
