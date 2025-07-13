<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title><?= $this->renderSection('title') ?> &mdash; Narria</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="<?=base_url('assets')?>/modules/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?=base_url('assets')?>/modules/fontawesome/css/all.min.css">

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="<?=base_url('assets')?>/modules/datatables/datatables.min.css">
  
  <?= $this->renderSection('style')?>

  <!-- Template CSS -->
  <link rel="stylesheet" href="<?=base_url('assets')?>/css/style.css">
  <link rel="stylesheet" href="<?=base_url('assets')?>/css/components.css">

  <style>
    body{
      background-color:rgb(251, 251, 251);
    }
  </style>
</head>

<body>
  <div id="app">  
    <div class="main-wrapper main-wrapper-1">