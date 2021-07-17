<table border=1 class="table table-bordered table-hover" align="left">
    <thead>
    <tr id="titre">
        <th >ID</th>
        <th >Nom</th>
        <th >Prenom</th>
        <th>Nom Matiere</th>
        <th>Note <span style="color: red;">Modifiable</span></th>
        <th>Note Originale</th>
        <th>Session</th>
        <th >Année d'étude</th>
    </tR>
    </thead>

<?php

foreach ($notes as $note) {
    echo "<tr>";
    echo "<td>$note->id_etudiant</td>";
    echo "<td>$note->nom</td>";
    echo "<td>$note->prenom</td>";
    echo "<td>$nomat</td>";
    echo "<td onkeyup='updateNote(this,{$note->code_note})' contenteditable>$note->notes</td>";
    echo "<td>$note->noteO</td>";
    echo "<td>$note->session</td>";
    echo "<td>$note->annee</td>";
}