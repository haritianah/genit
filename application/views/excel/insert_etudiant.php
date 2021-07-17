<?php
$result = array();
$countError = 0;
foreach ($object->getWorksheetIterator() as $worksheet) {
    $highRow = $worksheet->getHighestRow();
    $row  = isset($firstline) ? 2 : 1;
    for ($row; $row <= $highRow ; $row++){
        $id = $worksheet->getCell('A'.$row)->getValue();
        $nom = $worksheet->getCell('B'.$row)->getValue();
        $prenom = $worksheet->getCell('C'.$row)->getValue();
        $sexe = $worksheet->getCell('D'.$row)->getValue();
        //Date
        $getDate = $worksheet->getCell('E'.$row)->getValue();
        $date = date('d/M/Y',PHPExcel_Shared_Date::ExcelToPHP($getDate));
        $dateQuery = date('y-m-d',PHPExcel_Shared_Date::ExcelToPHP($getDate));
        //
        $lieu = $worksheet->getCell('F'.$row)->getValue();
        $adresse = $worksheet->getCell('G'.$row)->getValue();
        $phone = $worksheet->getCell('H'.$row)->getValue();
        //PARSE
        echo '<tr class="result">';
            echo "<td>$id</td>";
            echo "<td>$nom</td>";
            echo "<td>$prenom</td>";
            echo "<td>$sexe</td>";
            echo "<td>$date</td>";
            echo "<td>$lieu</td>";
            echo "<td>$adresse</td>";
            echo "<td>$phone</td>";
        echo '</tr>';
        //INSERT
        $data['id'] = $id;
        $data['nom'] = $nom;
        $data['prenom'] = $prenom;
        $data['sexe'] = $sexe;
        $data['date'] = $dateQuery;
        $data['lieu'] = $lieu;
        $data['adresse'] = $adresse;
        $data['phone'] = $phone;
        $result[$id] = $this->model_etudiants->insert($data);
        if ($result[$id]!='OK') $countError++;
    }
}
if ($countError!=0){
    ob_start();
    echo "<div class='alert alert-danger'>";
    foreach ($result as $key=>$errors) {
        if (is_array($errors)){
            foreach ($errors as $error) {
                echo "<p>[$key]: $error</p>";
            }
        }
    }
    $errorList = ob_get_clean();
}
//
?>
<script>
    $('#error').html("");
    <?php if($countError!=0): ?>
    $('#error').html("<?= $errorList ?>");
    <?php endif; ?>
</script>
