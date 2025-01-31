<?php include('common.php');?>
<?php
$dataTables = TRUE;
$service_colors = get_service_colors($pdo);
//$service_wins = get_service_wins($pdo);
$service_wins_and_time = get_service_win_and_time($pdo);

?>
<?php include('template/header.php');?>
<script src="assets/echarts-5.6.0/echarts.min.js"></script>
  <body>

<main>

  <?php include('template/nav.php');?>

  <?php //print_r($service_wins_and_time);
  ?>

  <div class="container px-4">
    <div class="row">
      <div class="card p-0">
        <div class="card-header pt-3">
          <h2>Services We've Watched</h2>
        </div>
        <div class="card-body">
          <div id="watchCount" style="width: 100%; height: 400px;"></div>

        </div>
      </div>
    </div>

    <div class="row mt-3">
      <div class="card p-0">
        <div class="card-header pt-3">
          <h2>Minutes Watched On Service</h2>
        </div>
        <div class="card-body">
          <div id="watchRuntime" style="width: 100%; height: 400px;"></div>

        <p class="mt-4 mx-4">It might be worth noting that HBO Go, HBO Now, HBO Max, and Max are all listed as separate streaming services, though they could, in theory, all be combined. Part of this is due to the way in which the data is saved in our database. One argument for separating them is to keep an accurate historical record of which services are used. This also helps counter any issues that might arise from services combining or disappearing all together.</p>
        </div>
      </div>
    </div>

    <script>
        // Initialize two charts
        var myChart0 = echarts.init(document.getElementById('watchCount'));
        var myChart1 = echarts.init(document.getElementById('watchRuntime'));

        // Data source dynamically passed from PHP with colors
        const sourceData = [
            <?php foreach($service_wins_and_time as $service): ?>
            {
                service: '<?php echo $service['format']; ?>',
                count: <?php echo $service['count']; ?>,
                runtime: <?php echo $service['total_runtime']; ?>,
                color: '<?php echo $service_colors[$service['format']] ?? "#cccccc"; ?>'
            },
            <?php endforeach; ?>
        ];

        // Option for chart 1: Sort by "count"
        const optionCount = {
          grid: {
          top: 30,    // Distance from the top
          bottom: 80, // Distance from the bottom
          left: 40,   // Distance from the left
          right: 40   // Distance from the right
      },
            title: { },
            legend: {},
            tooltip: {},
            dataset: {
                source: sourceData,

            },
            xAxis: { type: 'category',
            axisLabel: {
      rotate: 45,
      interval: 0
    } },
            yAxis: { type: 'value' },
            series: [
                {
                    type: 'bar',
                    encode: { x: 'service', y: 'count' }, // Map dimensions explicitly
                    itemStyle: {
                        color: function (params) {
                            return params.data.color; // Use the color defined in the dataset
                        }
                    }
                }
            ]
        };

        // Option for chart 2: Sort by "runtime"
        const optionRuntime = {
          grid: {
          top: 30,    // Distance from the top
          bottom: 80, // Distance from the bottom
          left: 40,   // Distance from the left
          right: 40   // Distance from the right
      },
            title: {  },
            legend: {},
            tooltip: {},
            dataset: {
                source: sourceData,
            },
            xAxis: { type: 'category',
            axisLabel: {
      rotate: 45,
      interval: 0
    } },
            yAxis: { type: 'value' },
            series: [
                {
                    type: 'bar',
                    encode: { x: 'service', y: 'runtime' }, // Map dimensions explicitly
                    itemStyle: {
                        color: function (params) {
                            return params.data.color; // Use the color defined in the dataset
                        }
                    }
                }
            ]
        };

        // Set options for both charts
        myChart0.setOption(optionCount);
        myChart1.setOption(optionRuntime);
    </script>

    <div class="row mt-3 justify-content-center">
      <div class="card col-8 p-0">
        <div class="card-header pt-3">
          <h2>Movies Watched On</h2>
        </div>
        <div class="card-body">
          <div class="col-6 mx-auto mb-3">
            <select id="servicelist" class="form-control form-select">
              <option value="" disabled selected>All Services</option>
              <?php foreach($service_colors as $service => $value):?>
                <option value="<?php echo $service; ?>"><?php echo $service; ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <table class="dynamicTable table">
    				<thead>
    				<tr>
    					<th>Date</th>
    					<th>Movie Title</th>
    					<th>Service</th>
    				</tr>
    				</thead>
    				<tbody>
    				<?php
    				$all_winners = get_winning_films_and_services($pdo);
    				foreach ($all_winners as $a_winner):?>
    					<tr>
    						<td><?php echo $a_winner['date']; ?></td>
    						<td><?php echo $a_winner['winning_film_name']; ?></td>
    						<td><?php echo $a_winner['format']; ?></td>
    					</tr>
    				<?php endforeach; ?>
    				</tbody>
    				<!-- // Table body END -->
    			</table>
        </div>
      </div>
    </div>
  </div>

  <script>
    $("#servicelist").on("change",
       function(){
           var a = $(this).find("option:selected").html();

           $("table tr td").each(
               function(){
                   if($(this).html() != a){
                       $(this).parent().hide();
                   }
                   else{
                       $(this).parent().show();
                   }
               });
           });
    </script>

<?php include('template/footer.php');?>
