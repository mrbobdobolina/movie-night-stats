<?php include('common.php');?>
<?php
// Check if the GET variable exists
if (isset($_GET['m'])) {
    // Sanitize the value (for example, using filter_var for a string)
    $show_number= $_GET['m'];
} else {
    if($movie == NULL){
      header('Location: movies.php');
    exit;
  }
}
$movie = get_movie_info($pdo, $show_number);
$movie_count = count_films($pdo);

if($movie == NULL){
  header('Location: movies.php');
exit;
}

$movie_event_info = get_movie_events($pdo, $show_number);
$cast_list = get_cast_list($pdo);
//print_r($movie_event_info);
?>
<?php include('template/header.php');?>
  <body>

<main>

  <?php include('template/nav.php');?>

  <div class="container">
    <div class="row gx-5 justify-content-center">
        <div class="col-lg-12 col-xl-12 col-xxl-12">
            <!-- Project Card 1-->
            <div class="card shadow-lg rounded-4 border-0 mb-5">
              <div class="card-header pt-3 rounded-top-4">
                <h2 class="fw-bolder text-center"><?php
                  echo $movie['name']; ?>
                </h2>
                <h4 class="fst-italic text-center">
                  <?php
                  $genres = get_movie_genres($pdo, $show_number);
                  echo implode(", ", $genres);
                  //print_r($genres); ?>
                </h4>
              </div>
                <div class="card-body p-0">
                    <div class="d-flex">
                      <div class="col-md-6 py-3 ps-3">
                        <img class="img-fluid w-100" src="<?php echo $movie['poster_url'];?>" alt="...">
                      </div>
                      <div class="py-3 ps-3 pe-3 col-md-6 justify-content-center">
                        <div class="card mb-3">
                          <div class="card-header text-bg-dark h5">Film Details</div>
                          <div class="card-body fs-5">
                            <ul class="list-group">
                              <li class="list-group-item"><strong>Runtime:</strong> <?php echo $movie['runtime'];?> minutes</li>
                              <li class="list-group-item"><strong>Released:</strong> <?php echo $movie['year'];?></li>
                              <li class="list-group-item"><strong>MPAA#:</strong> <?php echo $movie['MPAA'];?></li>
                            </ul>
                          </div>
                        </div>
                        <div class="card mb-3">
                          <div class="card-header text-bg-dark h5">Film Ratings <span class="fs-6">(At time of watching.)</span></div>
                          <div class="card-body fs-5">
                            <ul class="list-group">
                              <li class="list-group-item"><strong>Rotten Tomatoes:</strong> <?php echo $movie['tomatometer'];?>%</li>
                              <li class="list-group-item"><strong>RT Audience:</strong> <?php echo $movie['rt_audience'];?>%</li>
                              <li class="list-group-item"><strong>IMDB:</strong> <?php echo $movie['imdb'];?>%</li>
                              <?php $averageRating = Array();
                              if($movie['tomatometer']){
                                $averageRating[] = $movie['tomatometer'];
                              }
                              if($movie['rt_audience']){
                                $averageRating[] = $movie['rt_audience'];
                              }
                              if($movie['imdb']){
                                $averageRating[] = $movie['imdb'];
                              }
                              ?>
                              <li class="list-group-item"><strong>Average Rating:</strong> <?php echo calculate_average([$movie['tomatometer'],$movie['rt_audience'],$movie['imdb']]); ?>%</li>
                            </ul>
                          </div>
                        </div>
                        <?php if($movie_event_info['ohw'] == TRUE): ?>
                        <div class="alert alert-warning text-center">
                          <h3><i class="fa-sharp fa-solid fa-trophy-star"></i> One Hit Wonder! <i class="fa-sharp fa-solid fa-trophy-star"></i></h3>
                          <span class="fs-6">This movie was randomly picked it's first time on the wheel.</small>
                        </div>
                        <?php endif; ?>
                        <div class="card mb-3">
                          <div class="card-header text-bg-dark h5">MNS Details</div>
                          <div class="card-body fs-5">

                            <ul class="list-group">
                              <li class="list-group-item"><strong>Number of Wins:</strong> <?php echo $movie_event_info['counts']['wins']; ?></li>
                              <li class="list-group-item"><strong>Times Place on Wheel:</strong> <?php echo $movie_event_info['counts']['wheel']; ?></li>
                              <li class="list-group-item"><strong>Number of Wedges:</strong> <?php echo $movie_event_info['counts']['wedges']; ?></li>
                              <li class="list-group-item"><strong>First Instance: <?php echo $movie['first_instance'];?></strong></li>
                              <li class="list-group-item"><strong>Last Instance: <?php echo $movie['last_instance'];?></strong></li>
                              <li class="list-group-item"><strong>Picked By:</strong>
                              <?php $pickers = get_film_pickers($pdo, $show_number); ?>
                              <table class="charts-css column data-outside show-labels">
                              <?php $total = 0;
                              foreach($pickers as $participant){
                                $total = $total + $participant['film_count'];
                              }
                              foreach($pickers as $participant):?>
                              <tr>
                                <th scope="row"><?php echo $cast_list[$participant['viewer']]['name'];?></th>
                                <td style="--size: <?php echo round($participant['film_count']/$total, 2); ?>; --color: #<?php echo $cast_list[$participant['viewer']]['color'];?>;"><span class="data"><?php echo $participant['film_count']; ?></span></td>
                              </tr>
                              <?php endforeach;?>
                              </table>
                              </li>
                            </ul>

                          </div>
                        </div>

                      </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center mt-3">
          <div class="col-6">

        </div>
    </div>

  </div>
<?php include('template/footer.php');?>
