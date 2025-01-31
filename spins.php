<?php include('common.php');?>
<?php

?>
<?php include('template/header.php');?>
<script src="assets/echarts-5.6.0/echarts.min.js"></script>
  <body>

<main>

  <?php include('template/nav.php');?>

  <?php $selection_methods = get_spinner_histogram($pdo);
  $methods = Array();
  $data = Array();
  foreach($selection_methods as $method){
    $methods[] = $method['name'];
    $data[] = $method['uses'];
  }

  $spin_numbers = get_spin_numbers($pdo, TRUE);

  $numbers = array_fill_keys(range(1, 12), 0);
  $errors = array_fill_keys(range(1, 12), 0);
  foreach($spin_numbers as $num){
    $numbers[$num['winning_wedge']]++;
    if(isset($num['error_spin'])){
      $error = explode(",", $num['error_spin']);
      foreach($error as $err){
        if($err > 0){
          $errors[$err]++;
        }
      }
    }
  }

  //print_r($errors);
  //print_r($numbers);
  ?>

  <div class="container px-4">
    <div class="row">
      <div class="card p-0">
        <div class="card-header pt-3">
          <h2>How We Chose Our Movies</h2>
        </div>
        <div class="card-body">
          <div id="spinMethod" style="width:100%;height:500px;"></div>
          <script type="text/javascript">
            // Initialize the echarts instance based on the prepared dom
            var myChart = echarts.init(document.getElementById('spinMethod'));

            // Specify the configuration items and data for the chart
            var option = {
              grid: {
              top: 30,    // Distance from the top
              bottom: 40, // Distance from the bottom
              left: 40,   // Distance from the left
              right: 40   // Distance from the right
          },
              color: ["#EA2F1C"],
              title: {
                text: ''
              },
              tooltip: {},

              xAxis: {
                data: ['<?php echo implode("','",$methods); ?>'],
                axisLabel: {
                  interval: 0
                }
              },
              yAxis: {},
              series: [
                {
                  name: 'selection method',
                  type: 'bar',
                  data: [<?php echo implode(",",$data); ?>]
                }
              ]
            };

      // Display the chart using the configuration items and data just specified.
      myChart.setOption(option);
    </script>
        <p class="mt-4 mx-4">One of the halmark features of movie night is that the movie is chosen at random. This option can be overruled if someone makes a good pitch to watch a specific film and everyone else agrees. If the suggested film is contentested, it can only be watched if it is chosen randomly. The chart above depicts the ways in which we pick which film to watch.</p>
        </div>
      </div>
    </div>

    <div class="row mt-3">
      <div class="card p-0">
        <div class="card-header pt-3">
          <h2>The Numbers</h2>
        </div>
        <div class="card-body">
          <div id="numbers" style="width:100%;height:500px;"></div>
          <script type="text/javascript">
      // Initialize the echarts instance based on the prepared dom
      var myChart2 = echarts.init(document.getElementById('numbers'));

      // Specify the configuration items and data for the chart
      option = {
        tooltip: {
          trigger: 'axis',
          axisPointer: {
            // Use axis to trigger tooltip
            type: 'shadow' // 'shadow' as default; can also be 'line' or 'shadow'
          }
        },
        legend: {},
        grid: {
          left: '3%',
          right: '4%',
          bottom: '3%',
          containLabel: true
        },
        xAxis: {
          type: 'value'
        },
        yAxis: {
          type: 'category',
          data: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'],
          inverse: true
        },
        series: [
          {
            name: 'Picked Numbers',
            type: 'bar',
            stack: 'total',
            label: {
              show: true
            },
            emphasis: {
              focus: 'series'
            },
            data: [<?php echo implode(',',$numbers); ?>]
          },
          {
            name: 'Error Spins',
            type: 'bar',
            stack: 'total',
            label: {
              show: true
            },
            emphasis: {
              focus: 'series'
            },
            color: ["#EA2F1C"],
            data: [<?php echo implode(',',$errors); ?>]
          }
        ]
      };

      // Display the chart using the configuration items and data just specified.
      myChart2.setOption(option);
    </script>
          <p class="mt-4 mx-4">This chart shows the number of times each number has been randomly selected or picked using one of our selection devices. </p>
          <p class="mt-4 mx-4">In many ways this graph is completely meaningless, because the numbers are chosen using different methods. (In this graph we have removed Viewer Choice from the list since it is often listed as film one and skews the random number spread.) </p>
          <p class="mt-4 mx-4">We should note that an Error Spin occurs when a movie is put on the wheel and wins, but there is no means by which the film could can be watched. (This typically only occurs when a film has recently left a streaming service. Typically films are vetted for streaming or viewing before put on the wheel.)</p>
        </div>
      </div>
    </div>
  </div>

    <div class="container text-center mt-4">
      <div class="card p-0 mt-3 pb-3">
        <div class="card-header pt-3">
          <h2 class="text-start ps-2">The Biased Truth</h2>
        </div>
        <div class="card-body">
      <p class="mt-4 mx-4 text-start">Despite our best efforts most things that select items randomly have some sort of bias. By keeping track of our (albiet small) dataset, we hope to mititgate bias in our selections by removing or improving methods that appear to have bias results.</p>



    <?php $spinners_raw_info = get_spinner_data($pdo);

    $spinner_data = Array();
    foreach($spinners_raw_info as $week){
      if(!isset($spinner_data[$week['selection_method']])){
        $spinner_data[$week['selection_method']] = array_fill_keys(range(1, 12), 0);
        $spinner_data[$week['selection_method']][$week['winning_wedge']] = 1;
      } else {
        $spinner_data[$week['selection_method']][$week['winning_wedge']]++;
      }
    }
    //print_r($spinner_data);
    ?>

    <div class="container text-center">
      <div class="row gx-3 row-cols-4">
        <?php $counter = 0; ?>
        <?php foreach($spinner_data as $key => $data):?>
          <?php $counter++; ?>
        <div class="col mt-4">
          <div class="card">
            <div class="card-header pt-3">
              <h2><?php echo $key; ?></h2>
            </div>
            <div class="card-body">
              <div id="m<?php echo $counter ?>" style="width:100%;height:300px;"></div>
              <script type="text/javascript">
          // Initialize the echarts instance based on the prepared dom
          var mc<?php echo $counter ?> = echarts.init(document.getElementById('m<?php echo $counter ?>'));

          // Specify the configuration items and data for the chart
          option = {

      tooltip: {
        trigger: 'axis',
        axisPointer: {
          // Use axis to trigger tooltip
          type: 'shadow' // 'shadow' as default; can also be 'line' or 'shadow'
        }
      },
      legend: {
         show: false
      },
      grid: {
        top: '2%',
        left: '3%',
        right: '4%',
        bottom: '3%',
        containLabel: true
      },
      xAxis: {
        type: 'value'
      },
      yAxis: {
        type: 'category',
        data: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'],
        inverse: true
      },
      series: [
        {
          name: 'Picked Numbers',
          type: 'bar',
          stack: 'total',
          label: {
            show: true
          },
          emphasis: {
            focus: 'series'
          },
          data: [<?php echo implode(',',$data); ?>]
        }
      ]
    };

          // Display the chart using the configuration items and data just specified.
          mc<?php echo $counter ?>.setOption(option);
        </script>
              <?php //print_r($data); ?>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
      </div>
    </div>
    </div>
</div>
    <div class="container text-start mt-3">
      <div class="row">
        <div class="card mt-5 pb-3 px-0">
          <div class="card-header pt-3">
            <h2 class="">Details on the Wheels, Dice, and Spinners</h2>
          </div>
          <div class="card-body">
        <p class="mt-3 mx-2 text-start">Below we share a little detailed information about the methods we use to select our films to watch.</p>

        <div class="card mb-3">
          <div class="row">
            <div class="col-md-3">
              <img src="images/wheels/wheel_v2.jpg" class="img-fluid rounded-start" alt="...">
            </div>
            <div class="col-md-9">
              <div class="card-body">
                <h5 class="card-title">Wheel Version 2</h5>
                <p class="card-text">Wheel version 2 was build using a piece of plywood. It was used for 17 spins before it was found to be weighted and most likely to land on the number 8. While it may be possible to reblance the wheel at some point, no efforts have been made at this time.</p>
              </div>
            </div>
          </div>
        </div>

        <div class="card mb-3">
          <div class="row">
            <div class="col-md-3">
              <img src="images/wheels/wheel_v3.jpg" class="img-fluid rounded-start" alt="...">
            </div>
            <div class="col-md-9">
              <div class="card-body">
                <h5 class="card-title">Wheel Version 3</h5>
                <p class="card-text">Wheel version 3 was designed using particleboard, which should have a more uniform density than plywood. It used a similar flipper and axel to the other two. It was designed to be 18 inches in diameter. The wheel is heavy and does not sit level as it rotates. The balance was fine-tuned using tacks along the perimeter, though the level of balance is still debated. Wheel 3 broke while an attempt was made to update the spinning mechanism. It has not been repaired.</p>
              </div>
            </div>
          </div>
        </div>

        <div class="card mb-3">
          <div class="row">
            <div class="col-md-3">
              <img src="images/wheels/d12.jpg" class="img-fluid rounded-start" alt="...">
            </div>
            <div class="col-md-9">
              <div class="card-body">
                <h5 class="card-title">D12 (Die or Dice)</h5>
                <p class="card-text">A single 12-sided die is often used. There is no single die designated for rolling. Dice rolled include a large 5" foam die and smaller normal dice. The only requirements for dice is that they be 12-sided and not knowingly weighted.</p>
              </div>
            </div>
          </div>
        </div>

        <div class="card mb-3">
          <div class="row">
            <div class="col-md-3">
              <img src="images/wheels/bobbot.jpg" class="img-fluid rounded-start" alt="...">
            </div>
            <div class="col-md-9">
              <div class="card-body">
                <h5 class="card-title">Bobbot</h5>
                <p class="card-text">Bobbot was (is?) a Discord Bot built by TV to allow users to spin electronically. The bot has been offline since July 2020.</p>
              </div>
            </div>
          </div>
        </div>

        <div class="card mb-3">
          <div class="row">
            <div class="col-md-3">
              <img src="images/wheels/viewerchoice.jpg" class="img-fluid rounded-start" alt="...">
            </div>
            <div class="col-md-9">
              <div class="card-body">
                <h5 class="card-title">Viewer Choice</h5>
                <p class="card-text">Occasionally we decide it's better not to leave things up to chance. Typically this means only one person is present for movie night or everyone attending wants to watch the same thing.</p>
              </div>
            </div>
          </div>
        </div>

        <div class="card mb-3">
          <div class="row">
            <div class="col-md-3">
              <img src="images/wheels/wheelofsus.jpg" class="img-fluid rounded-start" alt="...">
            </div>
            <div class="col-md-9">
              <div class="card-body">
                <h5 class="card-title">wheelofsus</h5>
                <p class="card-text">Originally created for specialized games of Among Us, wheelofsus is a propriatary interactive virtual wheel that can be customized for many different events.</p>
              </div>
            </div>
          </div>
        </div>

        <div class="card mb-3">
          <div class="row">
            <div class="col-md-3">
              <img src="images/wheels/random_org.jpg" class="img-fluid rounded-start" alt="...">
            </div>
            <div class="col-md-9">
              <div class="card-body">
                <h5 class="card-title">Random.org</h5>
                <p class="card-text">Random.org offers several different features for choosing items randomly.</p>
              </div>
            </div>
          </div>
        </div>

        <div class="card mb-3">
          <div class="row">
            <div class="col-md-3">
              <img src="images/wheels/pye_spinner.jpg" class="img-fluid rounded-start" alt="...">
            </div>
            <div class="col-md-9">
              <div class="card-body">
                <h5 class="card-title">PYE Spinner Die</h5>
                <p class="card-text">This spinning die is from <a href="https://www.pyegames.com/">PYE Games</a>.</p>
              </div>
            </div>
          </div>
        </div>

        <div class="card mb-3">
          <div class="row">
            <div class="col-md-3">
              <img src="images/wheels/dd12.jpg" class="img-fluid rounded-start" alt="...">
            </div>
            <div class="col-md-9">
              <div class="card-body">
                <h5 class="card-title">Digital D12</h5>
                <p class="card-text">Movie Night Stats' unofficial-official D12 created for use in case of emergency.</p>
              </div>
            </div>
          </div>
        </div>

    </div>

  </div>

</div>

  </div>
<?php include('template/footer.php');?>
