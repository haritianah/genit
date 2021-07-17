<h1>Liste matière</h1>
<?php !isset($niveau) ? $this->app->niveau('settings/matiere/list') : false ?>

<?php if (!empty($niveau)): ?>
<h2 align="center"><?= $niveau; ?></h2>
<div class="container">
    <table class="table table-bordered">
    <?php
    foreach ($unites as $unite){
        $matieres = $this->model_matiere->get_matiere($unite->id_unite);
        echo '<tr>';
            echo "<th><span class='psi-color'>{$unite->num_unite}:</span> {$unite->nom_unite}</th>";
            echo "<th style='text-align: center'>Crédits</th>";
            echo "<th style='text-align: center'>Volume horaire</th>";
            echo "<th style='text-align: center'>Modifier</th>";
        echo '</tr>';
        foreach ($matieres as $matiere) {
            $href = base_url('settings/matiere/edit/').$matiere->id_matiere;
            echo '<tr>';
                echo "<td>{$matiere->id_matiere}: {$matiere->nom_matiere}</td>";
                echo "<td style='text-align: center'>{$matiere->credit}</td>";
                echo "<td style='text-align: center'>{$matiere->vol_hor}</td>";
                echo "<td align='center'><a href='$href' class='ion-edit psi-color'></a></td>";
            echo '</tr>';
        }
    }
    ?>
    </table>
</div>
<?php endif; ?>