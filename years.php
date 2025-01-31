<?php include('common.php');?>
<?php include('template/header.php');?>
<script src="assets/echarts-5.6.0/echarts.min.js"></script>
  <?php
  $year_data_1 = get_year_data($pdo);
  $week_data = get_day_of_week_summary($pdo);
  $attend = get_yearly_attend($pdo);
  $yearly_formats = get_yearly_format($pdo);
  $cast = get_cast_list($pdo);
  ?>

  <body>

<main>

  <?php include('template/nav.php');?>
  <?php //print_r($cast); ?>

  <?php
  $years = [];
  $count = [];
  $runtime = [];
  foreach($year_data_1 as $year){
    $years[] = $year['year'];
    $count[] = $year['event_count'];
    $runtime[] = $year['total_runtime'];
  }
  ?>

  <div class="container">
    <div class="row gx-3 justify-content-center">
        <div class="col-lg-4 col-xl-4 col-xxl-4">
            <div class="card shadow-lg rounded-4 border-0 mb-2">
              <div class="card-header pt-3 rounded-top-4">
                <h5 class="">Showings by Year </h5>
              </div>
              <div class="card-body p-0">
                <div id="spy" style="width:100%;height:200px;"></div>
                <script type="text/javascript">
                  // Initialize the echarts instance based on the prepared dom
                  var spyChart = echarts.init(document.getElementById('spy'));

                  // Specify the configuration items and data for the chart
                  var spyoption = {
                    grid: {
                    top: "10%",    // Distance from the top
                    bottom: "15%", // Distance from the bottom
                    left: "10%",   // Distance from the left
                    right: "10%"   // Distance from the right
                },
                    color: [ "#c1232b", "#27727b", "#fcce10", "#e87c25", "#9bca63", "#60c0dd"
                  ],
                    title: {
                      text: ''
                    },
                    tooltip: {},

                    xAxis: {
                      data: ['<?php echo implode("', '", $years); ?>'],
                      axisLabel: {
                        interval: 0
                      }
                    },
                    yAxis: {},
                    series: [
                      {
                        name: '',
                        type: 'bar',
                        data: [<?php echo implode(", ", $count); ?>],
                        colorBy: 'data',
                        barCategoryGap: '5%'
                      }
                    ]
                  };

            // Display the chart using the configuration items and data just specified.
            spyChart.setOption(spyoption);
          </script>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-xl-4 col-xxl-4">
            <div class="card shadow-lg rounded-4 border-0 mb-5">
              <div class="card-header pt-3 rounded-top-4">
                <h5 class="">Minutes Watched by Year </h5>
              </div>
              <div class="card-body p-0">
                <div id="rt" style="width:100%;height:200px;"></div>
                <script type="text/javascript">
                  // Initialize the echarts instance based on the prepared dom
                  var rtChart = echarts.init(document.getElementById('rt'));

                  // Specify the configuration items and data for the chart
                  var rtoption = {
                    grid: {
                    top: "10%",    // Distance from the top
                    bottom: "15%", // Distance from the bottom
                    left: "10%",   // Distance from the left
                    right: "10%"   // Distance from the right
                },
                    color: [ "#c1232b", "#27727b", "#fcce10", "#e87c25", "#9bca63", "#60c0dd"
                  ],
                    title: {
                      text: ''
                    },
                    tooltip: {},

                    xAxis: {
                      data: ['<?php echo implode("', '", $years); ?>'],
                      axisLabel: {
                        interval: 0
                      }
                    },
                    yAxis: {},
                    series: [
                      {
                        name: '',
                        type: 'bar',
                        data: [<?php echo implode(", ", $runtime); ?>],
                        colorBy: 'data',
                        barCategoryGap: '5%'
                      }
                    ]
                  };

            // Display the chart using the configuration items and data just specified.
            rtChart.setOption(rtoption);
          </script>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-xl-4 col-xxl-4">
            <div class="card shadow-lg rounded-4 border-0 mb-5">
              <div class="card-header pt-3 rounded-top-4">
                <h5 class="">Attendance by Year </h5>
              </div>
              <div class="card-body p-0">
                <div id="at" style="width:100%;height:200px;"></div>
                <script type="text/javascript">
                  // Initialize the echarts instance based on the prepared dom
                  var atChart = echarts.init(document.getElementById('at'));

                  // Specify the configuration items and data for the chart
                  var atoption = {
                    grid: {
                    top: "10%",    // Distance from the top
                    bottom: "15%", // Distance from the bottom
                    left: "10%",   // Distance from the left
                    right: "10%"   // Distance from the right
                },
                    color: [ "#c1232b", "#27727b", "#fcce10", "#e87c25", "#9bca63", "#60c0dd"
                  ],
                    title: {
                      text: ''
                    },
                    tooltip: {},

                    xAxis: {
                      data: ['<?php echo implode("', '", $years); ?>'],
                      axisLabel: {
                        interval: 0
                      }
                    },
                    yAxis: {},
                    series: [
                      {
                        name: '',
                        type: 'bar',
                        data: [<?php echo implode(", ", $attend); ?>],
                        colorBy: 'data',
                        barCategoryGap: '5%'
                      }
                    ]
                  };

            // Display the chart using the configuration items and data just specified.
            atChart.setOption(atoption);
          </script>
              </div>
            </div>
          </div>

        </div>

        <div class="row gx-3 justify-content-center">
          <div class="col-lg-12 col-xl-12 col-xxl-12">
            <div class="card shadow-lg rounded-4 border-0 mb-3">
              <div class="card-header pt-3 rounded-top-4">
                <h5 class="">Events by Day of Week</h5>
              </div>
              <div class="card-body p-0">
                <div id="wkd" style="width:100%;height:200px;"></div>
                <script type="text/javascript">
                  // Initialize the echarts instance based on the prepared dom
                  var wkdChart = echarts.init(document.getElementById('wkd'));

                  // Specify the configuration items and data for the chart
                  var wkdoption = {
                    grid: {
                    top: "10%",    // Distance from the top
                    bottom: "15%", // Distance from the bottom
                    left: "5%",   // Distance from the left
                    right: "5%"   // Distance from the right
                },
                    color: [ "#c1232b", "#27727b", "#fcce10", "#e87c25", "#9bca63", "#60c0dd"
                  ],
                    title: {
                      text: ''
                    },
                    tooltip: {},

                    xAxis: {
                      data: ['<?php $day_names = array_keys($week_data);
                      echo implode("', '", $day_names); ?>'],
                      axisLabel: {
                        interval: 0
                      }
                    },
                    yAxis: {},
                    series: [
                      {
                        name: '',
                        type: 'bar',
                        data: [<?php echo implode(", ", $week_data); ?>],
                        colorBy: 'data',
                        barCategoryGap: '5%'
                      }
                    ]
                  };

            // Display the chart using the configuration items and data just specified.
            wkdChart.setOption(wkdoption);
          </script>
              </div>
            </div>
          </div>
        </div>

    </div>
    <?php
    $yearly_counts['winner'] = get_yearly_category_counts($pdo, 'winning_moviegoer');
    $yearly_counts['spinner'] = get_yearly_category_counts($pdo, 'spinner');
    $yearly_counts['wedge'] = get_yearly_category_counts($pdo, 'winning_wedge');
    $yearly_counts['selection'] = get_yearly_category_counts($pdo, 'selection_method');
    $yearly_counts['format'] = get_yearly_category_counts($pdo, 'format');
    ?>

    <div class="container mt-5">
      <div class="row gx-3 justify-content-center">
        <?php foreach(array_reverse($yearly_formats, true) as $key => $value):?>

          <div class="card p-0 mt-4">
            <div class="card-header pt-3 text-center text-bg-dark">
              <h2><?php echo $key; ?> Stats</h2>
            </div>
            <div class="card-body">
              <div class="row gx-2 gy-2 justify-content-center">
                <?php $coming_soon = Array('winner' => 'Most Wins', 'spinner' => 'Most Spins',  'selection' => 'Top Selection Method', 'wedge' => 'Most Spun Number', 'format' => 'Top Service');

                $movie_data = get_movie_data_for_years($pdo, $key);
                //print_r($movie_data);
                $rankings = [];
                $movie_names = [];
                foreach($movie_data as $film){
                  $movie_names[$film['id']] = $film['name'];
                  $avg = calculate_average([$film['tomatometer'],$film['rt_audience'],$film['imdb']]);
                  if($avg != 0){
                    $rankings[$film['id']] = $avg;
                  }
                }
                $top_film_score = max($rankings);
                $top_film = array_search($top_film_score, $rankings);
                $bottom_film_score = min($rankings);
                $bottom_film = array_search($bottom_film_score, $rankings);
                 ?>
              <?php foreach($coming_soon as $query => $name):?>
                <div class="col-4">
                  <div class="card">
                    <div class="card-header">
                      <h5 class="pt-2"><?php echo $name;?></h5>

                    </div>
                    <div class="card-body">
                      <?php

                      if (array_key_first($yearly_counts[$query][$key]) === 0) {
                          unset($yearly_counts[$query][$key][0]);
                      }
                      //print_r($yearly_counts[$query][$key]);
                      $max_value = max($yearly_counts[$query][$key]);
                      $winners = array_keys($yearly_counts[$query][$key], $max_value);

                      if($max_value > 1){
                        $win_text = "wins";
                      } else {
                        $win_text = "win";
                      }
                      if($query == 'winner' OR $query == 'spinner'){
                        if(count($winners) > 1){
                          echo "It's a ".count($winners)."-tie between ".implode(" and ",array_map(fn($id) => $cast[$id]['name'] ?? $id, $winners)). ' with '.$max_value.' '.  $win_text.'!';
                        } else {
                          echo $cast[$winners[0]]['name'].' with '.$max_value.' '.  $win_text.'!';
                        }
                      } elseif($query == "format" OR $query == 'wedge' OR $query == 'selection') {
                        if(count($winners) > 1){
                          echo "It's a ".count($winners)."-tie between ".implode(" and ",$winners). ' with '.$max_value.' '.  $win_text.'!';
                        } else {
                          echo $winners[0].' with '.$max_value.' '.  $win_text.'!';
                        }
                      }
                      //print_r($winners);
                      ?>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>
              <div class="col-4">
                <div class="card">
                  <div class="card-header">
                    <h5 class="pt-2">Top Rated Film</h5>

                  </div>
                  <div class="card-body">
                    <?php echo $movie_names[$top_film];?> -
                    <?php echo $top_film_score;?>%
                  </div>
                </div>
              </div>

              <div class="col-4">
                <div class="card">
                  <div class="card-header">
                    <h5 class="pt-2">Worst Rated Film</h5>

                  </div>
                  <div class="card-body">
                    <?php echo $movie_names[$bottom_film];?> -
                    <?php echo $bottom_film_score;?>%
                  </div>
                </div>
              </div>

              <?php $requests = count_showings($pdo, $key);
              //print_r($requests);
              $top_request = max($requests);
              $top_request_key = array_search($top_request, $requests);

              if($top_request > 1){
                $wins = "times";
              } else {
                $wins = "time";
              }
              //print_r($requests); ?>
              <div class="col-4">
                <div class="card">
                  <div class="card-header">
                    <h5 class="pt-2">Most Requested Film</h5>

                  </div>
                  <div class="card-body">
                    <?php echo get_film_name($pdo, $top_request_key);?> was requested <?php echo $top_request; ?> <?php echo $wins; ?>.
                  </div>
                </div>
              </div>

              </div>

              <div class="card mt-3">
                <?php $yearly_minutes_watched = yearly_minutes_watched($pdo, $key);
                $service_colors =  get_service_colors($pdo);
                $data_string = [];
                foreach($yearly_minutes_watched as $k => $v){
                  $data_string[] = "{ value: $v, itemStyle: { color: '$service_colors[$k]'} }";
                }
                //print_r($yearly_minutes_watched); ?>
                  <div class="card-header pt-2">
                    <h5 class="pt-2">Minutes Watched Per Service in <?php echo $key; ?></h5>
                  </div>
                  <div class="card-body">
                    <div id="ymw<?php echo $key; ?>" style="width:100%;height:400px;"></div>
                    <script type="text/javascript">
                      // Initialize the echarts instance based on the prepared dom
                      var ymw<?php echo $key; ?>Chart = echarts.init(document.getElementById('ymw<?php echo $key; ?>'));

                      // Specify the configuration items and data for the chart
                      var ymw<?php echo $key; ?>option = {
                        grid: {
                        top: "10%",    // Distance from the top
                        bottom: "15%", // Distance from the bottom
                        left: "5%",   // Distance from the left
                        right: "5%"   // Distance from the right
                    },

                        title: {
                          text: ''
                        },
                        tooltip: {},

                        xAxis: {
                          data: ['<?php $names = array_keys($yearly_minutes_watched);
                          echo implode("', '", $names); ?>'],
                          axisLabel: {
                            interval: 0
                          }
                        },
                        yAxis: {},
                        series: [
                          {
                            name: '',
                            type: 'bar',
                            data: [<?php echo implode(", ", $data_string); ?>],
                            colorBy: 'data',
                            barCategoryGap: '5%'
                          }
                        ]
                      };

                // Display the chart using the configuration items and data just specified.
                ymw<?php echo $key; ?>Chart.setOption(ymw<?php echo $key; ?>option);
              </script>
                  </div>
                </div>

            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>

<?php include('template/footer.php');?>
