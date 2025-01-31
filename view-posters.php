<?php include('common.php');?>
<?php include('template/header.php');?>
  <?php
  //reorder_event_numbers($pdo);
  $total = get_event_count($pdo);
  // Check if the GET variable exists
  if (isset($_GET['sd'])) {
      // Sanitize the value (for example, using filter_var for a string)
      $showing_number= $_GET['sd'];
  } else {
      // Set to null if the variable doesn't exist
      $showing_number = $total;
  }
  $showing_data = get_raw_showing_data($pdo, $showing_number);
  $relevant_films = get_film_array($pdo, $showing_data);
  $cast_list = get_cast_list($pdo);
  ?>

  <body>

<main>

  <?php include('template/nav.php');?>

  <div class="container">
    <div class="row gx-5 justify-content-center">
        <div class="col-lg-11 col-xl-10 col-xxl-9">
            <!-- Project Card 1-->
            <div class="card shadow-lg rounded-4 border-0 mb-5">
              <div class="card-header pt-3 text-light rounded-top-4" style="background-color: #<?php echo $cast_list[$showing_data['winning_moviegoer']]['color']; ?>">
                <h2 class="fw-bolder text-center">
                  Event <?php
                  echo $showing_data["event_number"]; ?>
                </h2>
                <h4 class="fw-bolder text-center">
                  <?php
                  $date = new DateTime($showing_data["date"]);
                  echo $date->format("F j, Y"); ?>
                </h4>
              </div>
                <div class="card-body p-0">
                    <div class="d-flex align-items-center">
                        <div class="py-5 ps-3 pe-2 col-md-7">

                              <table class="table table-hover">
                                <tbody>
                                  <?php for($i=1; $i<=12; $i++):?>
                                  <tr class="<?php if($i == $showing_data["winning_wedge"]):?>fw-bold<?php endif;?>"
                                    <?php if($i == $showing_data["winning_wedge"]){
                                      echo 'style="--bs-table-bg:#'.$cast_list[$showing_data['winning_moviegoer']]['color'].'; --bs-table-color:#fff"';}?> >
                                    <td class="col-1 text-center">
                                    <?php if($i == $showing_data["winning_wedge"]):?>
                                      <i class="fa-solid fa-trophy pt-1"></i>
                                    <?php endif;?>
                                    </td>
                                    <td class="col-1 text-center"><?php echo $i; ?></td>
                                    <?php if($showing_data['moviegoer_'.$i]): ?>
                                      <td ><a style="color: inherit !important;" href="viewer.php?v=<?php echo $showing_data['moviegoer_'.$i]; ?>"><?php echo $cast_list[$showing_data['moviegoer_'.$i]]['name']; ?></a></td>
                                    <?php else: ?>
                                      <td class=""></td>
                                    <?php endif; ?>
                                    <?php if($showing_data['wheel_'.$i]): ?>
                                      <td class=""><a style="color: inherit !important;" href="movie.php?m=<?php echo $showing_data['wheel_'.$i]; ?>"><?php echo $relevant_films[$showing_data['wheel_'.$i]]['name']; ?></a></td>
                                    <?php else: ?>
                                      <td class=""></td>
                                    <?php endif; ?>

                                  </tr>
                                  <?php endfor; ?>

                                </tbody>
                              </table>
                        </div>
                        <div class="col-md-5 pe-3">
                          <img class="img-fluid w-100" src="<?php echo $relevant_films[$showing_data["winning_film"]]['poster_url'];?>" alt="...">
                        </div>
                    </div>
                </div>
                <div class="container w-100 mb-3">
                  <div class="btn-group w-100" role="group" aria-label="Basic example">
                    <?php if($showing_data['event_number'] != 1):?>
                    <a href="?sd=<?php echo $showing_data['event_number']-1; ?>" class="btn btn-outline-secondary w-50"><i class="fa-solid fa-arrow-left"></i> Previous Showing</a>
                    <?php endif; ?>
                    <?php if($showing_data['event_number'] != $total):?>
                    <a href="?sd=<?php echo $showing_data['event_number']+1; ?>" class="btn btn-outline-secondary w-50">Next Showing <i class="fa-solid fa-arrow-right"></i></a>
                    <?php endif; ?>
                  </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center gx-5">
          <div class="col-3 m-3 btn btn-danger">Card View</div>
          <div class="col-3 m-3 btn btn-danger">Poster View</div>
          <div class="col-3 m-3 btn btn-danger">List View</div>
        </div>
        <hr />
        <div class="row justify-content-center mt-3">
          <div class="col-6">
            <h3 class="text-center pb-3 ">"I'm Not a Nerd, You're a Nerd"</h2>
              <p class="">Movie Night Stats is a website<sup>1</sup> that chronicles "movie night" for a group of friends who enjoy watching movies together. It started out as a fun weekly get together before turning into a multi-year data gathering project and coding project before fizziling out due to busy schedules before hopefuly restarting someday. The data we track is more related to the event than it is to the actual film, making this content completely worthless if you are looking for a review, but mildly more valuable if you're looking into random numbers.</p>
              <p class="">[1] Citation Needed.</p>
            </div>
        </div>
    </div>

  </div>

<?php include('template/footer.php');?>
