<?php include('common.php');?>
<?php include('template/header.php');?>
  <?php
  $showing_data = get_all_showing_data($pdo);
  $relevant_films = get_film_names($pdo);
  $cast_list = get_cast_list($pdo);
  ?>

  <body>

<main>

  <?php include('template/nav.php');?>
  <?php //print_r(get_film_names($pdo)); ?>

  <div class="container">
    <div class="row gx-3 gy-3 justify-content-center">

      <?php foreach(array_reverse($showing_data) as $event):?>
        <div class="col-4">
          <div class="card">
            <div class="card-header pt-3 pb-0 text-center text-light" style="background-color: #<?php echo $cast_list[$event['winning_moviegoer']]['color']; ?>">
              <h4>Showing <?php echo numberToRomanRepresentation($event['event_number']);?></h4>
              <p><?php $date = new DateTime($event['date']);
              echo $date->format('F j, Y')?></p>
            </div>
            <div class="card-body">
              <table class="table table-hover">
                  <?php for($i = 1; $i <= 12; $i++):?>
                    <tr class="<?php if($i == $event["winning_wedge"]):?>fw-bold<?php endif;?>"
                      <?php if($i == $event["winning_wedge"]){
                        echo 'style="--bs-table-bg:#'.$cast_list[$event['winning_moviegoer']]['color'].'; --bs-table-color:#fff"';}?> >
                      <td><?php echo $i;?></td>
                      <td><?php if($event['moviegoer_'.$i] != 0):?>
                      <?php echo $cast_list[$event['moviegoer_'.$i]]['name'];?>
                      <?php endif;?>
                      </td>
                      <td><?php if($event['wheel_'.$i] != 0):?>
                        <?php echo $relevant_films[$event['wheel_'.$i]];?>
                      <?php endif;?></td>
                    </tr>
                  <?php endfor; ?>
              </table>
              <table class="table p-3 text-center">
                <thead>
                  <tr>
                    <td><strong>Spinner</strong></td>
                    <td><strong>Selection Method</strong></td>
                    <td><strong>Format</strong></td>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td><?php
                    if($event['spinner'] != 0){
                      echo $cast_list[$event['spinner']]['name'];
                      }?></td>
                    <td><?php echo $event['selection_method'];?></td>
                    <td><?php echo $event['format'];?></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>

        </div>
      <?php endforeach;?>

      </div>
  </div>

    </div>

  </div>

<?php include('template/footer.php');?>
