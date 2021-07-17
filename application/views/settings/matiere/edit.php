<h1>Modifier Unité/Matière</h1>
<div class="container">
    <!-- Unites -->
    <table class="table table-bordered">
        <tr>
            <th colspan="4" class="text-uppercase text-center">Unité</th>
        </tr>
        <tr>
            <th>Numéro</th>
            <th>Nom</th>
            <th>Semestre</th>
            <th>Niveau</th>
        </tr>
        <tr>
            <td><input type="text" name="num" id="num" value="<?= $unite->num_unite ?>"></td>
            <td><input type="text" name="nom" id="nom" value="<?= $unite->nom_unite ?>"></td>
            <td><input type="text" name="semesmtre" id="semestre" value="<?= $unite->semestre ?>"></td>
            <td><input type="text" name="niveau" id="niveau" value="<?= $unite->niveau_unite ?>"></td>
        </tr>
        <tr>
            <td colspan="2"><button class="btn btn-primary btn-block" onclick="editUnit()">Modifier</button></td>
            <td colspan="2"><button class="btn btn-danger btn-block" onclick="supUnit()">Supprimer</button></td>
        </tr>
    </table>
    <br>
    <hr>
    <br>

    <!-- Matière -->
    <table class="table table-bordered">
        <tr>
            <th colspan="4" class="text-uppercase text-center">Matière</th>
        </tr>
        <tr>
            <th>Numéro unité</th>
            <th>Nom</th>
            <th>Volume horaire</th>
            <th>Crédit</th>
        </tr>
        <tr>
            <td><input type="text" name="numUnit" id="numUnit" value="<?= $unite->num_unite ?>"></td>
            <td><input type="text" name="nomMat" id="nomMat" value="<?= $matiere->nom_matiere ?>"></td>
            <td><input type="text" name="vol" id="vol" value="<?= $matiere->vol_hor ?>"></td>
            <td><input type="number" name="credit" id="credit" value="<?= $matiere->credit ?>"></td>
        </tr>
        <tr>
            <td colspan="2"><button class="btn btn-primary btn-block" onclick="editMat()">Modifier</button></td>
            <td colspan="2"><button class="btn btn-danger btn-block" onclick="supMat()">Supprimer</button></td>
        </tr>
    </table>
</div>

<script>
    function editUnit() {
        var num = $('#num').val();
        var numO = "<?= $unite->num_unite ?>";
        var nom = $('#nom').val();
        var semestre = $('#semestre').val();
        var niveau = $('#niveau').val();
        $.ajax({
            url: "<?= base_url('ajax/edit_unit') ?>",
            method: 'POST',
            data: {'num':num,'numO':numO,'nom':nom,'semestre':semestre,'niveau':niveau},
            dataType: 'text',
            success: function (data) {
                alert(data);
            },
            error: function(){
                alert('error');
            }
        });
    }
    function supUnit() {
        var conf = confirm('Supprimer l\'unité?');
        if (conf==true){
            var idunit = <?= $unite->id_unite ?>;
            $.ajax({
                url: "<?= base_url('ajax/delete_unit') ?>",
                method: 'POST',
                data: {'idunit':idunit},
                dataType: 'text',
                success: function (data) {
                    alert(data);
                },
                error: function () {
                    alert('Error');
                }

            })
        }
    }
    //
    function editMat() {
        var num = $('#numUnit').val();
        var nom = $('#nomMat').val();
        var vol = $('#vol').val();
        var credit = $('#credit').val();
        var mat = <?= $matiere->id_matiere ?>;
        $.ajax({
            url: "<?= base_url('ajax/edit_matiere') ?>",
            method: 'POST',
            data: {'num':num,'nom':nom,'vol':vol,'credit':credit,'mat':mat},
            dataType: 'text',
            success: function (data) {
                alert(data);
            },
            error: function(){
                alert('error');
            }
        });
    }
    function supMat() {
        var conf = confirm('Supprimer la matière?');
        if (conf==true){
            var mat = <?= $matiere->id_matiere ?>;
            var idunit = <?= $unite->id_unite ?>;
            $.ajax({
                url: "<?= base_url('ajax/delete_matiere') ?>",
                method: 'POST',
                data: {'mat':mat,'idunit':idunit},
                dataType: 'text',
                success: function (data) {
                    alert(data);
                },
                error: function(){
                    alert('error');
                }
            });
        }
    }
</script>