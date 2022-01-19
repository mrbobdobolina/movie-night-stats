<?php

require_once("../common.php");

include('inc/credentials.php');

restrict_page_to_admin();

include('template/header.php');

?>
<h1 class="display-6 text-center">Scribe's List</h1>
<div class="text-center mb-5">Because you were too lazy to write it out.</div>

<div class="row">
	<div class="col-12 col-sm-4 col-lg-2 mb-3">
		<div class="card">
			<div class="card-header">Attendees</div>
			<div class="card-body">
				<?php

				foreach(getListOfViewers() as $viewer){
					echo '<div class="form-check">';

					echo '<input id="attendees['.$viewer['id'].']" type="checkbox" class="check-attendee form-check-input" value="'.$viewer['name'].'"> ';
					echo '<label for="attendees['.$viewer['id'].']" class="form-check-label">'.$viewer['name'].'</label>';

					echo '</div>';
				}

				?>
			</div>
		</div>
	</div>
	<div class="col-12 col-sm-8 col-lg mb-3">
		<div class="card">
			<div class="card-header">Films</div>
			<div class="card-body">
				<?php

				for($i = 0; $i < 12; $i++){
					echo '<div class="row">';
					echo '  <div class="col-12 mb-1">';
					echo '     <div class="input-group">';


					echo '<div class="input-group-text justify-content-center" style="width:3em;">'.($i+1).'</div>';
					echo '<input class="input-film form-control form-control-sm">';


					echo '    </div>';
					echo '  </div>';
					echo '</div>';
				}

				?>
			</div>
		</div>
	</div>
	<div class="col mb-3 col-lg">
		<div class="card">
			<div class="card-header">Export</div>
			<div class="card-body">
				<div class="row">
					<div class="col mb-3">
						<textarea id="scribe-export" class="form-control" rows="13" readonly></textarea>
					</div>
				</div>
				<div class="row justify-content-end">
					<div class="col-4">
						<button class="btn btn-primary form-control" onclick="copy_export_to_clipboard()">Copy</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>

// Set all the Attendee checkboxs to trigger some code when clicked
$('.check-attendee').on("click", function(){
	regenerate_attendee_list();
})

// Set the film boxes to trigger when key pressed
$('.input-film').on('change', regenerate_export_text);
$('.input-film').on('keypress', regenerate_export_text);
$('.input-film').on('keydown', regenerate_export_text);
$('.input-film').on('keyup', regenerate_export_text);

// Stores the possible patterns for attendees based on number of attendees
var $att_patterns = {
	0: [
		[0,  0,  0,  0,  0,  0,  0,  0,  0,  0,  0,  0]
	],
	1: [
		[1,  1,  1,  1,  1,  1,  1,  1,  1,  1,  1,  1]
	],
	2: [
		[1,  2,  1,  2,  1,  2,  1,  2,  1,  2,  1,  2],
		[1,  1,  2,  2,  1,  1,  2,  2,  1,  1,  2,  2],
		[1,  1,  1,  2,  2,  2,  1,  1,  1,  2,  2,  2],
		[1,  1,  1,  1,  1,  1,  2,  2,  2,  2,  2,  2]
	],
	3: [
		[1,  2,  3,  1,  2,  3,  1,  2,  3,  1,  2,  3],
		[1,  1,  2,  2,  3,  3,  1,  1,  2,  2,  3,  3],
		[1,  1,  1,  1,  2,  2,  2,  2,  3,  3,  3,  3]
	],
	4: [
		[1,  2,  3,  4,  1,  2,  3,  4,  1,  2,  3,  4],
		[1,  1,  1,  2,  2,  2,  3,  3,  3,  4,  4,  4]
	],
	5: [
		[1,  2,  3,  4,  5,  1,  2,  3,  4,  5,  1,  2],
		[1,  1,  2,  2,  3,  3,  4,  4,  5,  5,  1,  2]
	],
	6: [
		[1,  2,  3,  4,  5,  6,  1,  2,  3,  4,  5,  6],
		[1,  1,  2,  2,  3,  3,  4,  4,  5,  5,  6,  6]
	],
	7: [
		[1,  2,  3,  4,  5,  6,  7,  1,  2,  3,  4,  5]
	],
	8: [
		[1,  2,  3,  4,  5,  6,  7,  8,  1,  2,  3,  4]
	],
	9: [
		[1,  2,  3,  4,  5,  6,  7,  8,  9,  1,  2,  3]
	],
	10: [
		[1,  2,  3,  4,  5,  6,  7,  8,  9, 10,  1,  2]
	],
	11: [
		[1,  2,  3,  4,  5,  6,  7,  8,  9, 10, 11,  1]
	],
	12: [
		[1,  2,  3,  4,  5,  6,  7,  8,  9, 10, 11, 12]
	]
}

/**
 * Gets all the attendees that are marked as present.
 *
 * @return [object] Present Attendees
 */
function get_present_attendees(){
	$attendees = [];
	$('.check-attendee').each(($i, $check) => {
		if($($check).prop('checked')){
			$attendees.push($($check).val());
		}
	})
	return $attendees;
}


/**
 * Generate a random integer between two other integers.
 *
 * @param  [int] $min   The smallest random number allowed.
 * @param  [int] $max   The largest random number allowed.
 * @return [int]        The random number.
 */
function rand_between($min, $max){
	return Math.floor(Math.random() * ($max - $min + 1) + $min);
}

// https://stackoverflow.com/questions/2450954/how-to-randomize-shuffle-a-javascript-array
function shuffleArray(array) {
  for (let i = array.length - 1; i > 0; i--) {
    const j = Math.floor(Math.random() * (i + 1));
    [array[i], array[j]] = [array[j], array[i]];
  }
}

/**
 * Randomizes the attendees and organizes them by pattern.
 *
 * @return [undefined]
 */
var $attendee_list = [];
function regenerate_attendee_list(){
	// Get, count, and randomize the present attendees
	var $att_present = get_present_attendees();
	var $att_present_no = $att_present.length;
	shuffleArray($att_present);

	// Limit attendees to the first 12 randomly chosen
	if($att_present_no > 12){$att_present_no = 12;}

	// Pick a pattern
	var $patterns = $att_patterns[$att_present_no];
	var $pattern = $patterns[rand_between(1, $patterns.length) - 1]

	// Reset Master Attendee List
	$attendee_list = [];

	// Assign Names based on the pattern
	for (var $i = 0; $i < 12; $i++){
		if($pattern[$i] == 0){ // Zero is a blank name
			$attendee_list.push('');
		}
		else {
			// Subtract 1 from pattern to fix off by one error caused by ease of readability.
			$attendee_list.push($att_present[$pattern[$i] - 1]);
		}
	}

	// Update the List
	regenerate_export_text();
}

/**
 * Gets the value of the input for a given movie number.
 *
 * @param  [int] $number  Film ID (1-12).
 * @return [str]          The current inputted text.
 */
function get_film_by_number($number){
	var $film = $('.input-film').eq($number - 1).val();

	return ($film.length == 0) ? '' : $film + ' ';
}

/**
 * Generates the text needed for the Scribe List Export feature.
 *
 * @return [string] Text Export.
 */
function generate_scribe_export(){
	var $export = '';

	$export += (new Date()).toLocaleString('defaut', { month: 'long', day: 'numeric', year: 'numeric'}) + ' Movie List:\n';

	for(var $i = 0; $i < 12; $i++){
		$export += ($i+1)+'. '+get_film_by_number($i + 1)+'('+$attendee_list[$i]+')\n';
	}

	return $export
}

/**
 * Puts the generated scribe text in the textarea.
 *
 * @return [undefined]
 */
function regenerate_export_text(){
	$('#scribe-export').val(generate_scribe_export());
}

function copy_export_to_clipboard(){
	$('#scribe-export').focus();
	$('#scribe-export').select();
	document.execCommand('copy');
}

// Runs on page load
$(function(){
	regenerate_attendee_list();
	regenerate_export_text();
});


</script>

<?php

include('template/footer.php')

?>
