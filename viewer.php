<?php include('common.php');?>
<?php
// Check if the GET variable exists
if (isset($_GET['v'])) {
    // Sanitize the value (for example, using filter_var for a string)
    $person = $_GET['v'];
} else {
    if($_GET['v'] == NULL){
      header('Location: viewers.php');
    exit;
    }
}
 $viewer_data = get_cast_member($pdo, $person);
 $viewer_data = get_cast_list($pdo);
 $viewer_picks = get_cast_picks($pdo, $person);
 $viewer_attendance = get_cast_atnd($pdo, $person);
 $pick_details = get_pick_details($pdo, $person);
 $count = get_event_count($pdo);
 $stats = get_cast_stats($pdo, $person);
 $spinner_stats = get_cast_wheel($pdo, $person);
 $service_colors = get_service_colors($pdo);
 $unwatched_films = get_unwatched_films($pdo, $person);

 $dataTables = TRUE;

 $film_years = [];

?>
<?php include('template/header.php');?>
<script src="assets/echarts-5.6.0/echarts.min.js"></script>
<style>
	.card-header{
		background-color: #<?php echo $viewer_data[$person]['color'];?> ;
		color: white;
	}
</style>

  <body>

<main>

  <?php include('template/nav.php');?>

  <?php //print_r($unwatched_films); ?>

  <div class="container">
    <div class="row">
      <div class="col-12">
	       <h1 class="alert text-white text-center fw-bold" style="background-color:#<?php echo $viewer_data[$person]['color'];?>"><?php echo $viewer_data[$person]['name'];?></h1>
      </div>
    </div>
    <div class="row">
      <div class="col-12 col-md-6 col-lg-4">
		    <div class="row row-cols-1">
			    <div class="col mb-3">
				    <div class="card">
					    <div class="card-header h3">
                Info
              </div>
              <ul class="list-group list-group-flush">
                <li class="list-group-item">
                  <div class="row">
                    <div class="col fw-bold">Name:</div>
                    <div class="col"><?php echo $viewer_data[$person]['name'];?></div>
                  </div>
                </li>
						<li class="list-group-item">
							<div class="row">
								<div class="col fw-bold">Attendance:</div>
								<div class="col"><?php echo $viewer_data[$person]['attendance'];?></div>
							</div>
						</li>
						<li class="list-group-item">
							<div class="row">
								<div class="col fw-bold">First Seen:</div>
								<div class="col"><?php echo substr($viewer_attendance[0],0,10); ?></div>
							</div>
						</li>
						<li class="list-group-item">
							<div class="row">
								<div class="col fw-bold">Last Seen:</div>
								<div class="col"><?php echo substr($viewer_attendance[count($viewer_attendance)-1],0,10); ?></div>
							</div>
						</li>
					</ul>
				</div>
			</div>


			<div class="col mb-3">
				<div class="card">
					<div class="card-header h3">
						Picks
					</div>
					<ul class="list-group list-group-flush">
						<li class="list-group-item">
							<div class="row">
								<div class="col fw-bold">Total:</div>
								<div class="col"><?php echo $viewer_picks['total_films'];?></div>
							</div>
						</li>
						<li class="list-group-item">
							<div class="row">
								<div class="col fw-bold">Unique:</div>
								<div class="col"><?php echo $viewer_picks['unique_films'];?></div>
							</div>
						</li>
						<li class="list-group-item">
							<div class="row">
								<div class="col fw-bold">% Unique:</div>
								<div class="col">
									<?php echo round(($viewer_picks['unique_films']/$viewer_picks['total_films'])*100,2);?>%
								</div>
							</div>
						</li>
						<li class="list-group-item">
							<div class="row">
								<div class="col fw-bold">Average Year:</div>
								<div class="col">2003</div>
							</div>
						</li>
					</ul>
				</div>
			</div>


			<div class="col mb-3">
				<div class="card">
					<div class="card-header h3">
						Wins
					</div>
					<ul class="list-group list-group-flush">
						<li class="list-group-item">
							<div class="row">
								<div class="col fw-bold">Total:</div>
								<div class="col"><?php echo $stats['wins']; ?></div>
							</div>
						</li>
						<li class="list-group-item">
							<div class="row">
								<div class="col fw-bold">% / Total Events:</div>
								<div class="col">
									<?php echo round(($stats['wins']/$count)*100,2); ?>%
								</div>
							</div>
						</li>
						<li class="list-group-item">
							<div class="row">
								<div class="col fw-bold">% / Attendance:</div>
								<div class="col">
									<?php echo round(($stats['wins']/$viewer_data[$person]['attendance'])*100,2); ?>%
								</div>
							</div>
						</li>
					</ul>
				</div>
			</div>


			<div class="col mb-3">
				<div class="card">
					<div class="card-header h3">
						Streaks
					</div>
					<ul class="list-group list-group-flush">
						<li class="list-group-item">
							<div class="row">
								<div class="col fw-bold">Longest Win:</div>
								<div class="col">	</div>
							</div>
						</li>
						<li class="list-group-item">
							<div class="row">
								<div class="col fw-bold">Longest Win with Viewer Choice:</div>
								<div class="col"></div>
							</div>
						</li>
						<li class="list-group-item">
							<div class="row">
								<div class="col fw-bold">Longest Win when Attending:</div>
								<div class="col">	</div>
							</div>
						</li>
						<li class="list-group-item">
							<div class="row">
								<div class="col fw-bold">Longest Lose:</div>
								<div class="col"></div>
							</div>
						</li>
						<li class="list-group-item">
							<div class="row">
								<div class="col fw-bold">Longest Lose with Viewer Choice:</div>
								<div class="col"></div>
							</div>
						</li>
						<li class="list-group-item">
							<div class="row">
								<div class="col fw-bold">Longest Lose when Attending:</div>
								<div class="col"></div>
							</div>
						</li>
					</ul>
				</div>
			</div>


			<div class="col mb-3">
				<div class="card">
										<div class="card-header h3">
						Stats
					</div>
					<ul class="list-group list-group-flush">
						<li class="list-group-item">
							<div class="row">
								<div class="col fw-bold">Scribe:</div>
								<div class="col"><?php echo $stats['scribe']; ?></div>
							</div>
						</li>
						<li class="list-group-item">
							<div class="row">
								<div class="col fw-bold">All Picks:</div>
								<div class="col"><?php //echo $stats['wins']; ?></div>
							</div>
						</li>
						<li class="list-group-item">
							<div class="row">
								<div class="col fw-bold">Total Spins:</div>
								<div class="col"><?php echo $stats['spins']; ?></div>
							</div>
						</li>
						<li class="list-group-item">
							<div class="row">
								<div class="col fw-bold">Error Spins:</div>
								<div class="col"><?php //echo $stats['wins']; ?></div>
							</div>
						</li>
					</ul>
				</div>
			</div>


		</div>
	</div>
	<div class="col-12 col-md-6 col-lg-4">
		<div class="row row-cols-1">


			<div class="col mb-3">
				<div class="card">
					<div class="card-header h3">
						Spun Numbers
					</div>
					<ul class="list-group list-group-flush">
						<li class="list-group-item">

							<div class="chart">
								<div id="spunNumbers" style="width:100%;height:200px;"></div>
                <script type="text/javascript">
                  // Initialize the echarts instance based on the prepared dom
                  var myChart = echarts.init(document.getElementById('spunNumbers'));

                  // Specify the configuration items and data for the chart
                  var option = {
                    grid: {
                    top: 20,    // Distance from the top
                    bottom: 20, // Distance from the bottom
                    left: 20,   // Distance from the left
                    right: 20   // Distance from the right
                },
                    color: ["#<?php echo $viewer_data[$person]['color'];?>"],
                    title: {
                      text: ''
                    },
                    tooltip: {},

                    xAxis: {
                      data: ['<?php $keys = array_keys($spinner_stats['numbers']);
                      echo implode("','",$keys); ?>'],
                      axisLabel: {
                        interval: 0
                      }
                    },
                    yAxis: {},
                    series: [
                      {
                        name: 'selection method',
                        type: 'bar',
                        data: [<?php echo implode(",",$spinner_stats['numbers']); ?>]
                      }
                    ]
                  };

            // Display the chart using the configuration items and data just specified.
            myChart.setOption(option);
          </script>
							</div>
						</li>
					</ul>
				</div>
			</div>


			<div class="col mb-3">
				<div class="card">
					<div class="card-header h3">
						Spun People
					</div>
          <div id="spunCast" style="width:100%;height:400px;"></div>
          <script type="text/javascript">
            // Initialize the echarts instance based on the prepared dom
            var myChart2 = echarts.init(document.getElementById('spunCast'));

            // Specify the configuration items and data for the chart
            var option2 = {
              grid: {
              top: 20,    // Distance from the top
              bottom: 20, // Distance from the bottom
              left: 20,   // Distance from the left
              right: 20   // Distance from the right
            },
            tooltip: {
              trigger: 'item'
              },
              legend: {
              top: '5%',
              left: 'center'
              },
              series: [
              {
                name: 'Spun People',
                type: 'pie',
                radius: ['30%', '75%'],
                avoidLabelOverlap: true,
                padAngle: 1,
                itemStyle: {
                  borderRadius: 8
                },
                label: {
                  show: false,
                  position: 'center'
                },
                emphasis: {
                  label: {
                    show: true,
                    fontSize: 20,
                    fontWeight: 'bold'
                  }
                },
                labelLine: {
                  show: false
                },
                data: [
                  <?php foreach($spinner_stats['people'] as $key => $value):?>
                  { value: <?php echo $value;?>, name: '<?php echo $viewer_data[$key]['name'];?>', itemStyle: { color: '#<?php echo $viewer_data[$key]['color'];?>'} },
                  <?php endforeach; ?>
                ]
              }
              ]
            };

      // Display the chart using the configuration items and data just specified.
      myChart2.setOption(option2);
    </script>
				</div>
			</div>


			<div class="col mb-3">
				<div class="card">
					<div class="card-header h3">
						Spun Methods
					</div>
          <div id="spinMethods"  style="width:100%; height:200px;"></div>
          <script type="text/javascript">
            // Initialize the echarts instance based on the prepared dom
            var myChart3 = echarts.init(document.getElementById('spinMethods'));

            // Specify the configuration items and data for the chart
            var option3 = {
              grid: {
              top: 30,    // Distance from the top
              bottom: 30, // Distance from the bottom
              left: '26%',   // Distance from the left
              right: 25   // Distance from the right
          },
              color: ["#<?php echo $viewer_data[$person]['color'];?>"],
              title: {
                text: ''
              },
              tooltip: {},

              yAxis: {
                data: ['<?php $keys = array_keys($spinner_stats['methods']);
                echo implode("','",$keys); ?>'],
                axisLabel: {
                  interval: 0
                }
              },
              xAxis: {},
              series: [
                {
                  name: 'selection method',
                  type: 'bar',
                  data: [<?php echo implode(",",$spinner_stats['methods']); ?>],
                  barWidth: '80%',
                  barCategoryGap: '5%',
                }
              ]
            };

      // Display the chart using the configuration items and data just specified.
      myChart3.setOption(option3);
    </script>
				</div>
			</div>


			<div class="col mb-3">
				<div class="card">
					<div class="card-header h3">
						Winning Services
					</div>
          <div id="winningService"  style="width:100%; height:300px;"></div>
          <script type="text/javascript">
            // Initialize the echarts instance based on the prepared dom
            var myChart4 = echarts.init(document.getElementById('winningService'));

            // Specify the configuration items and data for the chart
            var option4 = {
              grid: {
              top: 30,    // Distance from the top
              bottom: 60, // Distance from the bottom
              left: 30,   // Distance from the left
              right: 20   // Distance from the right
          },
              title: {
                text: ''
              },
              tooltip: {},

              xAxis: {
                data: ['<?php $keys = array_keys($spinner_stats['services']);
                echo implode("','",$keys); ?>'],
                axisLabel: {
                  interval: 0,
                  rotate: 50,
                }
              },
              yAxis: {},
              series: [
                {
                  name: 'winning service',
                  type: 'bar',
                  data: [
                    <?php foreach($spinner_stats['services'] as $key => $value):?>
                    { value: <?php echo $value;?>, name: '<?php echo $key;?>', itemStyle: { color: '<?php echo $service_colors[$key];?>'} },
                    <?php endforeach; ?>
                  ],
                  barWidth: '80%',
                  barCategoryGap: '5%',
                }
              ]
            };

          // Display the chart using the configuration items and data just specified.
          myChart4.setOption(option4);
          </script>
				</div>
			</div>
		</div>
	</div>

	<div class="col-12 col-lg-4">
		<div class="row row-cols-1">


			<div class="col mb-3">
				<div class="card">
					<div class="card-header h3">
						Unwatched Picks
					</div>
					<div class="card-body">


						<table id="movies" class="table table-striped">
							<thead>
								<tr>
									<td><strong>Movie Title</strong></td>
									<td><strong>Times on Wheel</strong></td>
								</tr>
							</thead>
							<tbody>
                <?php foreach($unwatched_films as $film):?>
                  <?php if($film['wins'] == 0):?>
                  <tr>
  									<td><?php echo $film['name']; ?></td>
  									<td><?php echo $film['pick_count']; ?></td>
  								</tr>
                  <?php endif; ?>
                <?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>


		</div>
	</div>
</div>

  </div>
  <script>
  new DataTable('#movies', {
    lengthMenu:[
      [25, 50, 100, -1],
      [25, 50, 100, 'All']
    ],
    order: [
      [1, 'desc']
    ],
    "bLengthChange": false,
  });
</script>
<?php include('template/footer.php');?>
