<h2 align="center"><?= ucfirst($session) ?></h2>
<table border=1 class="table table-bordered">
    <tr>
        <th>Id</th>
        <th>Numéro</th>
        <th>Nom</th>
        <th>Prénom</th>
        <th>Niveau</th>
        <th>Notes</th>
    </tr>
    <?php
    //INSERT RESULT
if (isset($insert) && $insert==1):
    foreach ($liste as $etudiant):
        $note = $notes[$etudiant->id_etudiant];
            echo "<tr>";
            echo "<td> $etudiant->id_etudiant </td>";
            echo "<td>$etudiant->num_etudiant $etudiant->etat </td>";
            echo "<td> $etudiant->nom </td>";
            echo "<td> $etudiant->prenom </td>";
            echo "<td> $etudiant->niveau </td>";
            echo "<td> $note </td>";
            echo "</tr>";
    endforeach;
    exit();
endif;

    //Retrieve etudiant
    //SESSION Normale
if ($session == "normale"){
    foreach ($etudiants as $etudiant):
        $resmat = $this->model_note->get_resmatByMatiere($etudiant->id_etudiant,$idmat);
        $resmat= !empty($resmat) ? $resmat->resultat : NULL;
        if (($etudiant->niveau == $niveau && ($resmat == NULL || $resmat=="AJN")) || ($etudiant->niveau == $niveau2 && $resmat=="AJN")):
            echo "<tr>";
            echo "<td> $etudiant->id_etudiant </td>";
            echo "<td>$etudiant->num_etudiant $etudiant->etat </td>";
            echo "<td> $etudiant->nom </td>";
            echo "<td> $etudiant->prenom </td>";
            echo "<td> $etudiant->niveau </td>";
            echo "<td> <input type='number' step='0.01' onkeydown='doNothing()' name='note$etudiant->id_etudiant' id=$etudiant->id_etudiant> </td>";
            echo "</tr>";
        endif;
    endforeach;
}
    //SESSION Rattrapage
if ($session == "rattrapage"){
    foreach ($etudiants as $etudiant):
        $resmat = $this->model_note->get_resmatByMatiere($etudiant->id_etudiant,$idmat);
        $resmat= !empty($resmat) ? $resmat->resultat : NULL;
        //Chek isset note normale
        $obj_noteNormale = $this->model_note->get_noteParam(array('id_etudiant'=>$etudiant->id_etudiant,'annee_etude'=>$etudiant->annee_etude,
                                                            'session'=>'normale','id_matiere'=>$idmat), false);
        //COunt note Elim Normale
        $param =array('id_etudiant'=>$etudiant->id_etudiant,'id_matiere'=>$idmat,'session'=>"normale",'annee_etude'=>$etudiant->annee_etude,'notes<='=>4,'notes>'=>0);
        $countElimNormale=$this->model_note->get_noteParam($param, false)->num_rows();
//        debug($etudiant->id_etudiant." ".$countElimNormale);
        if ($resmat!= NULL && $resmat =="AJN" && $obj_noteNormale->num_rows()!=0 && $countElimNormale==0):
            echo "<tr>";
            echo "<td> $etudiant->id_etudiant </td>";
            echo "<td>$etudiant->num_etudiant $etudiant->etat </td>";
            echo "<td> $etudiant->nom </td>";
            echo "<td> $etudiant->prenom </td>";
            echo "<td> $etudiant->niveau </td>";
            echo "<td> <input type='number' step='0.01' onkeydown='doNothing()' name='note$etudiant->id_etudiant' id=$etudiant->id_etudiant> </td>";
            echo "<tr>";
        endif;
    endforeach;
}
    ?>