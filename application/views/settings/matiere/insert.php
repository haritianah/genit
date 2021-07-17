<h1>Insérer une matière <?= $niveau ?></h1>

<?php empty($niveau) ? $this->app->niveau('settings/matiere/insert') : false ?>
<?php if (!empty($niveau)): ?>
    <div class="container">
        <form action="<?= base_url('settings/matiere/q_insertMat') ?>" method="POST" class="form-inline">
            <div class="form-group">
                <select name="num" id="num" class="selectpicker form-control" data-live-search="true" title="Selectionner unité" data-width="100%">
                    <?php foreach ($unites as $unite): ?>
                        <option value="<?= $unite->num_unite ?>"><b><?= $unite->num_unite ?></b>: <?= $unite->nom_unite ?> (<?= $unite->semestre ?>)</option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group col-md-3">
                <input type="text" name="mat" id="mat" class="form-control" placeholder="Nom">
            </div>
            <div class="form-group col-md-3">
                <input type="text" name="volhor" id="vol" class="form-control" placeholder="Volume Horaire">
            </div>
            <div class="form-group col-md-3">
                <input type="number" name="cred" id="cred" class="form-control" placeholder="Crédit">
            </div>
            <br>
            <br>
            <br>
            <button type="submit" class="btn btn-block btn-primary">Insérer</button>
            <br>
            <br>
        </form>
        <div align="center">
            <a href="#">Insérer une unité</a>
        </div>
    </div>
<?php
//debug($unites);
endif;