<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="index.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Lexend+Mega&display=swap" rel="stylesheet">
    <script
            src="https://code.jquery.com/jquery-3.5.1.min.js"
            integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
            crossorigin="anonymous"></script>
    <title>My TODO List</title>
</head>
<body>

<?php

include('config.php');
include('todolist.php');

$app = new TodoList(date('Ymd'));

$todolist = $app->getTodos();
$reqMethod = $_SERVER['REQUEST_METHOD'];


switch ($reqMethod) {
    case 'POST':
        $app->add();
        $status = "YENİ KAYIT EKLENDİ";
        break;


    case 'GET':
        if (isset($_GET["delete"]) && isset($_GET['id'])) {
            if (!empty($_GET['id'])) {
                $status = $_GET['id'] . " NUMARALI KAYIT SİLİNDİ";
                $app->delete($_GET['id']);
            }
        } else if (isset($_GET["update"]) && isset($_GET['id'])) {
            if (!empty($_GET['id'])) {
                $status = $_GET['id'] . " NUMARALI KAYIT GÜNCELLENDİ";
                $wanted_sval = "sval_" . $_GET['id'];
                $value = "";
                if (isset($_GET[$wanted_sval]))
                    $value = $_GET[$wanted_sval];

                if ($value != "")
                    $app->update($_GET['id'], $value);
            }

        } else {
            $status = "";
        }
        break;
}

$todolist = $app->getTodos();
?>

<h1 id="welcome">TO-DO LIST</h1>

<div class="container">
    <form action="index.php" method="post" autocomplete="off">


        <input type="text" class="form-control" id="text" placeholder="Yapılacakları ekleyiniz..." name="mytodo"/>

        <input type="hidden" name="hid_val" value="add">
        <input type="submit" id="ekle" class="btn btn-default" value="EKLE">
    </form>

    <ul>
        <?php
        foreach ($todolist as $k => $v) {

            echo '<li style="list-style-type: square" ><!--<div style="display:inline-block">' . $v . '</div> --><form autocomplete="off" action="index.php"  style="display:inline-block" >
            
            <input type="text" name="sval_' . ($k + 1) . '" value="' . $v . '"/>
            
            <input type="hidden" value="' . ($k + 1) . '" name="id" />
            <button id="sil" class="btn btn-default btn-xs btn btn-danger"  type="submit" value="sil" name="delete" >
             <span class="fa fa-close" style="font-size:15px"></span></button>
             
            <!--<input id="sil" class="btn btn-default btn-xs" style="background-color: slategrey" type="submit" value="sil" name="delete"/>-->
            <input id="güncelle" class="btn btn-default btn-xs btn btn-success" type="submit" value="güncelle" name="update" />
          
            <!--<input   type="button" class="btn btn-default btn-xs glyphicon glyphicon-pencil" /> -->
            
            </form>
            <button id="yapıldı" class="btn btn-default btn-xs yap" value="yapılmadı"  name="done"  >
             <span class="glyphicon glyphicon-pencil" style="font-size:15px"></span></button>
            </li>';
        }
        ?>
    </ul>
</div>

</body>

<script>

    $('.yap').click(function () {
        var htmlString = $(this).html();

        if (htmlString != "Yapıldı")
            $(this).text("Yapıldı");
        else
            $(this).html("<span class='glyphicon glyphicon-pencil' style='font-size:15px'></span>");


        //$(this).removeClass('fa-phone-square').addClass('fa-check');
    })
</script>
</html>


<style>


</style>
