<?php include('common.php');?>
<?php
 $all_films = get_all_films($pdo);
 $dataTables = TRUE;
?>
<?php include('template/header.php');?>
  <body>

<main>

  <?php include('template/nav.php');?>

  <div class="container">
    <?php //update_attendance($pdo); ?>
  </div>

<?php include('template/footer.php');?>
