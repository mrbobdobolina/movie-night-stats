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
    <table id="movies" class="table table-hover">
      <thead>
        <tr class="table-dark">
          <td><i class="fa-solid fa-star"></i></td>
          <td><i class="fa-solid fa-photo-film-music"></i></td>
          <td>Title</td>
          <td>Runtime</td>
          <td>Year</td>
          <td>MPAA#</td>
          <td><i class="fa-solid fa-trophy"></i></td>
          <td><i class="fa-solid fa-arrows-spin"></i></td>
          <td><i class="fa-solid fa-triangle fa-rotate-180"></i></td>
          <td>First Date</td>
          <td>Last Date</td>
        </tr>
      </thead>
      <tbody>
        <?php foreach($all_films as $film):?>
        <tr>
          <?php if($film['ohw'] == 1):?>
            <td data-order="1"><i class="fa-solid fa-star"></i></td>
          <?php else:?>
            <td data-order="0"></td>
          <?php endif;?>
          <td><i class="fa-solid fa-<?php echo $film['type']; ?>"></i></td>
          <td><a class="link-dark" href="movie.php?m=<?php echo $film['id']; ?>"><?php echo $film['name']; ?></a></td>
          <td><?php echo $film['runtime']; ?></td>
          <td><?php echo $film['year']; ?></td>
          <td><?php echo $film['MPAA']; ?></td>
          <td><?php echo $film['wins']; ?></td>
          <td><?php echo $film['x_on_wheel']; ?></td>
          <td><?php echo $film['wedges']; ?></td>
          <td><?php echo $film['first_instance']; ?></td>
          <td><?php echo $film['last_instance']; ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <script>
  new DataTable('#movies', {
    lengthMenu:[
      [50, 100, 200, 500, -1],
      [50, 100, 200, 500, 'All']
    ],
    order: [
      [2, 'asc']
    ]
  });
</script>
<?php include('template/footer.php');?>
