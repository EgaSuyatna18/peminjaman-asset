<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?= $title ?></title>

    <!-- Custom fonts for this template-->
    <link href="/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="/sbadmin2/sb-admin-2.min.css" rel="stylesheet">

    <!-- bootsrap 4.6.2 -->
    <!-- <link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css"> -->

</head>

    <body class="bg-gradient-primary">

        <?= $this->renderSection('main') ?>

        <!-- Bootstrap core JavaScript-->
        <script src="/jquery/jquery.min.js"></script>
        <script src="/bootstrap/js/bootstrap.bundle.min.js"></script>

        <!-- Core plugin JavaScript-->
        <script src="/jquery-easing/jquery.easing.min.js"></script>

        <!-- Custom scripts for all pages-->
        <script src="/sbadmin2/sb-admin-2.min.js"></script>
        <?= $this->include('layouts/toast') ?>

    </body>

</html>