<?php //header("Cache-Control: public, max-age=3600");
include('common.php');?>
<?php
 $cast_list = get_cast_list($pdo);
 $event_count = get_event_count($pdo);
 $dataTables = TRUE;
 $viewer_picks = get_viewer_films($pdo);
 $attendees = get_atnd_cast($pdo);
?>
<?php include('template/header.php');?>
  <body>

<main>

  <?php include('template/nav.php');?>


  <div class="container">

    <table id="cast" class="table table-striped space-mono-regular">
		<thead>
			<tr>
        <th></th>
				<th>Name</th>
				<th>Atnd</th>
				<th class="text-end">
					<div data-bs-toggle="tooltip" data-bs-animation='false' data-bs-placement="right" title="The number of events a viewer has been to.">
						%
					</div>
				</th>
				<th class="text-end">
					<div data-bs-toggle="tooltip" data-bs-animation='false' data-bs-placement="right" title="The number of unique movies a user has put on the wheel.">
						<i class="fas fa-fingerprint"></i></i>
					</div>
				</th>
				<th class="text-end">
					<div data-bs-toggle="tooltip" data-bs-animation='false' data-bs-placement="right" title="The number of total movies a user has put on the wheel.">
						<i class="fas fa-film"></i>
					</div>
				</th>
				<th class="text-end">
					<div data-bs-toggle="tooltip" data-bs-animation='false' data-bs-placement="right" title="% of Unique movies a user has put on the wheel.">
						<i class="fas fa-fingerprint"></i> %
					</div>
				</th>
				<th>
					<div data-bs-toggle="tooltip" data-bs-animation='false' data-bs-placement="right" title="The number of times a viewer's movie has been picked for movie night.">
						<i class="fas fa-trophy"></i>
					</div>
				</th>
				<th>
					<div data-bs-toggle="tooltip" data-bs-animation='false' data-bs-placement="right" title="The percent of movie nights a viewer has won.">
						<i class="fas fa-trophy"></i> %
					</div>
				</th>
				<th>
					<div data-bs-toggle="tooltip" data-bs-animation='false' data-bs-placement="right" title=" The percentage of attended movie nights that a viewers movie has won.">
						<i class="fas fa-trophy" ></i>/Atnd
					</div>
				</th>
				<th>
					<div data-bs-toggle="tooltip" data-bs-animation='false' data-bs-placement="right" title="Streak: The most consecutive events that a viewer has had their movie watched, ignoring viewer choice nights.">
						<i class="fas fa-repeat"></i> <i class="fas fa-trophy"></i>
					</div>
				</th>
				<th>
					<div data-bs-toggle="tooltip" data-bs-animation='false' data-bs-placement="right" title="The longest a viewer has gone without winning (only counting attended events.)">
						<i class="fas fa-cactus"></i>
					</div>
				</th>
				<th aria-sort="ascending">
					Last Spin
				</th>
				<th>
					<div data-bs-toggle="tooltip" data-bs-animation='false' data-bs-placement="right" title="The number of times a user has spun a wheel or rolled a die.">
						<i class="fas fa-sync"></i>
					</div>
				</th>
			</tr>
		</thead>
		<tbody>
      <?php foreach($cast_list as $member): ?>
				<tr>
          <td style="background-color:#<?php echo $member['color'];?>;" class="fw-bold text-white"></td>
					<td class="fw-bold"><a href="viewer.php?v=<?php echo$member['id']; ?>"><?php echo $member['name'];?></a></td>
					<td id="viewer_atnd_<?php echo$member['id']; ?>" class="text-end"><?php echo $member['attendance'];?></td>
					<td class="text-end"><?php echo round(($member['attendance']/$event_count)*100); ?>%</td>
					<td class="text-end"><?php echo $viewer_picks[$member['id']]['unique_films'];?></td>
					<td class="text-end"><?php echo $viewer_picks[$member['id']]['total_films'];?></td>
					<td class="text-end"><?php echo round(($viewer_picks[$member['id']]['unique_films']/$viewer_picks[$member['id']]['total_films'])*100); ?>%</td>
					<td id="viewer_wins_<?php echo$member['id']; ?>" class="text-end"></td>
					<td id="viewer_win_percent_<?php echo$member['id']; ?>" class="text-end"></td>
					<td id="viewer_win_per_atnd_<?php echo$member['id']; ?>" class="text-end"></td>
					<td id="winning_streak_<?php echo$member['id']; ?>" class="text-end"></td>
					<td id="loser_streak_<?php echo$member['id']; ?>" class="text-end"></td>
					<td id="last_spin_<?php echo$member['id']; ?>" class="text-end"></td>
					<td id="viewer_spins_<?php echo$member['id']; ?>" class="text-end"></td>
				</tr>
      <?php endforeach; ?>

					</tbody>
	</table>

  <div >
	<div class="card p-3 mt-3">
		<div class="">
			<div class="">
				<ul>
					<li><strong>Name:</strong> Name. Name of viewer. What we call them.</li>
					<li><strong>Atnd:</strong> Attendance. The number of events a viewer has been to.</li>
					<li><strong>%</strong> Attendance Percentage. The percent of total movie nights a viewer has been in attendance.</li>
					<li><strong><i class="fas fa-fingerprint"></i></strong> Unique Movies. The number of unique movies a user has put on the wheel.</li>
					<li><strong><i class="fal fa-ballot-check"></i></strong> Total Movies. The number of total movies a user has put on the wheel.</li>
					<li><strong><i class="fas fa-fingerprint"></i>%</strong> % of Unique movies a user has put on the wheel.</li>
					<li><strong><i class="fas fa-trophy"></i></strong> Wins: The number of times a viewer's movie has been picked for movie night.</li>
					<li><strong><i class="fas fa-trophy"></i> %:</strong> The percent of movie nights a viewer has won.</li>
					<li><strong><i class="fas fa-trophy"></i>/Atnd:</strong> The percentage of attended movie nights that a viewers movie has won.</li>
					<li><strong><i class="fas fa-repeat"></i> <i class="fas fa-trophy"></i></strong> Streak: The most consecutive events that a viewer has had their movie watched, ignoring viewer choice nights.</li>
					<li><strong><i class="fas fa-cactus"></i></strong> Dry: The longest a viewer has gone without winning (only counting attended events.)</li>
					<li><strong>Last Spin:</strong> The date if a viewers last spin/roll. Used to determine who is up next.</li>
					<li><strong><i class="fas fa-sync"></i></strong> Spins: The number of times a user has spun a wheel or rolled a die.</li>
        </ul>
        <ul>
          (Temporarily?) Depreciated Columns
					<li><strong><i class="far fa-stopwatch"></i></strong> The number of minutes viewer has spent watching films.</li>
					<li><strong><i class="fas fa-star-half-alt"></i>%</strong> Average Moving Rating across all picked films.</li>
				</ul>
			</div>
		</div>
	</div>
</div>
  </div>
<script>
  const eventData = <?php echo json_encode(get_all_showing_data($pdo)); ?>;
  const castData = <?php echo json_encode($cast_list); ?>;

  const eventCount = <?php echo $event_count; ?>;

  const attendees = <?php echo json_encode($attendees); ?>;

  const winCount = {};
  const spinCount = {};
  const winnerStreak = {};
  const loserStreak = {};
  const loserStreakMax = {};
  const lastSpin = {};

  previousWinner = "";
  currentStreak = 1;

  Object.entries(castData).forEach(([id]) => {
    loserStreak[id] = 0;
    loserStreakMax[id] = 0;
  });

  eventData.forEach((row) => {
    const winner = row.winning_moviegoer;
    if (winCount[winner]) {
      winCount[winner]++;
    } else {
      winCount[winner] = 1;
    }

    const spinner = row.spinner;
    if (spinCount[spinner]) {
      spinCount[spinner]++;
    } else {
      spinCount[spinner] = 1;
    }


    const date = row.date;
    const formattedDate = date.substring(0,10)
    $("#last_spin_"+spinner).text(formattedDate);

    if(row.selection_method != "viewer choice"){
      if(winner == previousWinner){
        currentStreak++;
        //console.log(winner, currentStreak);
      } else {
        if(winnerStreak[winner]){
          if(currentStreak > winnerStreak[winner]){
            winnerStreak[winner] = currentStreak;
            //console.log(winner, currentStreak);
            currentStreak = 1;
          } else {
            currentStreak = 1;
          }
        } else {
          winnerStreak[winner] = currentStreak;
          //console.log(winner, currentStreak);
          currentStreak = 1;
        }
      }
      previousWinner = winner;

      Object.entries(castData).forEach(([id]) => {
        if(winner == id){
          //check current losing steak, if max, add to maxVar, zero counter
          if(loserStreak[id] > loserStreakMax[id]){
            loserStreakMax[id] = loserStreak[id];
          }
          loserStreak[id] = 0;
        } else {
          //if user is attending, increase, else don't.
          hereNow = attendees[date].split(',');
          if(hereNow.includes(id)){
            console.log(hereNow, id, loserStreak[id]);
            loserStreak[id]++;
          }
        }
      });
    }

  });

  for (let key in loserStreak) {
    if (loserStreak.hasOwnProperty(key) && loserStreak[key] > loserStreakMax[key]) {
      loserStreakMax[key] = loserStreak[key];
    }
  }

  Object.entries(castData).forEach(([id]) => {
    if(winCount[id]){
      count = winCount[id];
      $("#viewer_wins_"+id).text(`${count}`);
    } else {
      $("#viewer_wins_"+id).text(`0`);
    }

    if(winCount[id]){
      count = winCount[id];
      winPercent = Math.round((count/eventCount)*100);
      $("#viewer_win_percent_"+id).text(`${winPercent}%`);
    } else {
      $("#viewer_win_percent_"+id).text(`0%`);
    }

    if(winCount[id]){
      count = winCount[id];
      attendCount = parseInt($("#viewer_atnd_" + id).text(), 10);
      winPercent = Math.round((count/attendCount)*100);

      $("#viewer_win_per_atnd_"+id).text(`${winPercent}%`);
    } else {
      $("#viewer_win_per_atnd_"+id).text(`0%`);
    }

    $("#progressBar").width( "30%" );

    if(spinCount[id]){
      count = spinCount[id];
      $("#viewer_spins_"+id).text(`${count}`);
    } else {
      $("#viewer_spins_"+id).text(`0`);
    }

    if(winnerStreak[id]){
      count = winnerStreak[id];
      $("#winning_streak_"+id).text(`${count}`);
    } else {
      $("#winning_streak_"+id).text(`0`);
    }

    $("#loser_streak_"+id).text(loserStreakMax[id]);
  });



  </script>

  <script>
  table = new DataTable('#cast', {
    lengthMenu:[
      [-1],
      ['All']
    ],
    order: [
      [2, 'desc']
    ],
    "bLengthChange": false,
    "bPaginate": false,
    "paging": false,
    "bFilter":false,
    columnDefs: [
      {
        targets: '_all', // Apply to all columns
        orderSequence: ['asc', 'desc'] // Removes the "no-sort" option
      }
    ]
  });
</script>
<?php include('template/footer.php');?>
