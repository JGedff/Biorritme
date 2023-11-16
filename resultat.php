<?php

    include 'biorritme.php';
    //Instanciem un objecte Biorritme
    //Li demanem a l'objecte que calculi el biorritme
    //Li demanem a l'objecte que enregistri les noves dades a l'arxiu json
    $data = "";
    $name = "";

    if (isset($_GET["datanaixement"])) {
        $data = $_GET["datanaixement"];
    }

    if (isset($_GET["nomusuari"])) {
        $name = $_GET["nomusuari"];
    }

    $object = new Biorritme($data, $name);

    $object->calcularBiorritmes();

    $object->saveCalculBiorritmeToJson();

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>
<div class="container">
<h2><?php echo $object->getNom(); ?> - <?php echo date("Y-m-d"); ?></h2>
    <h3>Els teus resultats són:</h3>
    <div class="container" style="margin-top: 50px;">
        <div class="row">
            <div class="col-sm-3 text-left">
                <strong>Biorritme físic:</strong>
            </div>
            <div class="col-sm-9">
                <div class="progress" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                    <div class="progress-bar bg-info text-dark" <?php echo "style='width: " . $object->getPercentatjeFisic() . "%'"; ?>> <?php echo $object->getPercentatjeFisic() . "%"; ?> </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-3 text-left">
                <strong>Biorritme emotiu:</strong>
            </div>
            <div class="col-sm-9">
                <div class="progress" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                    <div class="progress-bar bg-info text-dark" <?php echo "style='width: " . $object->getPercentatjeEmotiu() . "%'"; ?>> <?php echo $object->getPercentatjeEmotiu() . "%"; ?> </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-3 text-left">
                <strong>Biorritme intel·lectual:</strong>
            </div>
            <div class="col-sm-9">
                <div class="progress" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                    <div class="progress-bar bg-info text-dark" <?php echo "style='width: " . $object->getPercentatjeIntelectual() . "%'"; ?>> <?php echo $object->getPercentatjeIntelectual() . "%" ?> </div>
                </div>
            </div>
        </div>
        <div class="row">
        
            <h4  style="margin-top: 20px;"> Històric de dades</h4>

            <div class="col-sm-3 text-left">
                <strong>Dades:</strong>
            </div>
            <div class="col-sm-9">
                <?php echo $object->tableCalculBiorritmeJsonFile(); ?>
            </div>
        </div>
        </div>
        
    </div>
</div>
</body>
</html>