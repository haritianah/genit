<h1>STATISTIQUES</h1>
<?php !isset($niveau) ? $this->app->niveau('settings/matiere/stat') : false ?>

<?php if (!empty($niveau)): ?>
    <table class="table table-bordered">
        <tr>
            <th>Matière</th>
            <th>S.N</th>
            <th>S.R</th>
        </tr>
        <?php foreach ($matieres as $matiere):
        $check = $this->model_matiere->check_noteMatiere($matiere->id_matiere);
        ?>
        <tr>
            <td><?= $matiere->nom_matiere ?> (<?= $matiere->semestre ?>)</td>
            <td style="color: <?= isset($check['N'])? "green" : "red" ?>;"><?= isset($check['N'])? "Oui" : "Non" ?></td>
            <td style="color: <?= isset($check['R'])? "green" : "red" ?>;"><?= isset($check['R'])? "Oui" : "Non" ?></td>
        </tr>
        <?php endforeach;  ?>
    </table>
<?php endif;  ?>