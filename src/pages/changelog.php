<?php

require_once('../common.php');

template('header');

//Array('date' => "", 'version' => '', 'details' => Array("")),
$changes = Array(
	Array('date'=>"January 14, 2023", 'version' => 'Version 4.0.3', 'details' => Array("Fixed bug where error spin wasn't added to DB correctly.","Fixed graphical issue where all 12 movies were tied for most requests.","Added viewer chart for spun methods.")),
	Array('date'=>"October 27, 2022", 'version' => 'Version 4.0.1', 'details' => Array("Cleanded up redundant code.", "Fixed issue collective movie rating when less than 12 films were present.","We discovered a lost movie night and added data.")),
	Array('date'=>"October 23, 2022", 'version' => 'Version 4.0.0', 'details' => Array("Bug fixes.", "Removed unneeded column from viewers page", "fixed issue on the backend", "updated version number", "added really dumb stats","Lots of other stuff probably.")),
		Array('date'=>"April 23, 2022", 'version' => 'Version 3.9.0', 'details' => Array("Bug fixes.", "Improvements to viewers and viewer pages.")),
	Array('date'=>"April 18, 2022", 'version' => 'Version 3.8.0', 'details' => Array("Bug fixes.", "Improvements","Added filterable table to Services page.")),
	Array('date'=>"March 6, 2022", 'version' => 'Version 3.7.0', 'details' => Array("Bug fixes.","Weather manipulations.","General improvements.")),
	Array('date'=>"February 17, 2022", 'version' => 'Version 3.6.1', 'details' => Array("Bug fixes on admin pages.")),
	Array('date'=>"February 6, 2022", 'version' => 'Version 3.6.0', 'details' => Array("Tweaked some admin code to make adding movies easier","Fixed missing spaces","Updated One Hit Wonder counter to ignore viewer choices","Viewers page should work better on mobile now")),
	Array('date'=>"February 5, 2022", 'version' => 'Version 3.5.0', 'details' => Array("Added hero section to home page.","Added Poster View", "Changed DB", "Localized snow js", "Decreased chance of flurries", "Minor bug fixes")),
	Array('date'=>"January 21, 2022", 'version' => 'Version 3.4.0', 'details' => Array("Cleand up Admin backend.", "Admin pages are now Bootstrap 5 compliant.", "Admin list generation is now written in JavaScript.", "Fixed a few divide by zero errors.")),
	Array('date'=>"January 17, 2022", 'version' => 'Version 3.3.0', 'details' => Array("Added table view for events page.","Fixed some spacing issues on viewers and viewer pages.","Added information about the wheels and dice on Spins page.", "Modified text formatting on years page for more uniform layout.")),
	Array('date'=> "January 15, 2022", 'version' => 'Version 3.2.0', 'details' => Array("I'm not sure when to update this anymore with the different branches and BTS updates.","This version includes updates to the viewer page.","Fixed spacing on some lists.","Utilized a table for unwatched picks.","Modified attendance to better accomodate more people.")),
	Array('date' => "January 8, 2022", 'version' => 'Version 3.1.4', 'details' => Array("Fixed a lot of bugs behind the scenes.","Changed formatting on changelog.")),
	Array('date' => "January 6, 2022", 'version' => 'Version 3.1.3', 'details' => Array("Fixed typo in changelog.")),
	Array('date' => "December 31, 2021", 'version' => 'Version 3.1.2', 'details' => Array("Chance of flurries.")),
	Array('date' => "December 30, 2021", 'version' => 'Version 3.1.1', 'details' => Array("Minor DB adjustments.","Speed up load times on Movies page... I think.","Fixed issue where tooltip animations prevented tooltips from reappearing on Viewer table header.", 'Fixed bug were all non-watched movies were listed as "one-hit-wonders"')),
	Array('date' => "December 27, 2021", 'version' => 'Version 3.1.0', 'details' => Array("Added tooltips to viewer's table. They work most of the time.")),
	Array('date' => "December 26, 2021", 'version' => 'Version 3.0.0', 'details' => Array("Added average viewer rating to viewer table.","Added highest rated film to years page.","Added lowest rated film to years page.","Cleaned up code to calculate movie ratings.")),
	Array('date' => "December 23, 2021", 'version' => 'Version 2.9.2', 'details' => Array("Fixed typos and some glaring issues.")),
	Array('date' => "December 18, 2021", 'version' => 'Version 2.9.1', 'details' => Array("Fixed bug where data was accidentally displayed, unformatted, at the bottom of the viewers page.")),
	Array('date' => "December 17, 2021", 'version' => 'Version 2.9.0', 'details' => Array("Added viewer stat to calculate how long each viewer has spent watching.","Changed viewer table header to include icons, rather than text, in an attempt to make everything more confusing and make space for more columns.","Modified column headers on Movies page to prevent First & Last Dates from creating line-breaks creating a cleaner and more condensed table.","Bolded dates on changelog for better readability","Swapped individual spinner charts to use css charts.")),
	Array('date' => "December 14, 2021", 'version' => 'Version 2.8.0', 'details' => Array("Added chart to services to show minutes watched with each service.","Added minutes watched by service chart to Years tab.","Added Digital d12 to database so it's ready to be used.","Modified db to track spinner uses.","Changed wheel page to sort by uses.",'Changed "wheel" to "spinner" in navbar')),
	Array('date' => "December 13, 2021", 'version' => 'Version 2.7.2', 'details' => Array("Fixed bug where fireworks prevented logo from being a clickable link.")),
	Array('date' => "December 12, 2021", 'version' => 'Version 2.7.1', 'details' => Array("Fixed issue where nav bar extended past the screen on mobile.","Modified nav bar text for simplicity.")),
	Array('date' => "December 12, 2021", 'version' => 'Version 2.7.0', 'details' => Array("Added Yearly Stats.","Fixed bug where yearly stats displayed years that haven't happened yet.")),
	Array('date' => "December 11, 2021", 'version' => 'Version 2.6.3', 'details' => Array("Updated site with new and consistent font.","Fixed something I should have fixed 100 weeks ago.","Added celebratory fireworks to each page.","Fixed bugs from adding fireworks to each page.")),
	Array('date' => "December 9, 2021 ", 'version' => 'Version 2.6.2', 'details' => Array("Fixed bug in admin interface.","Fixed typo in changelog.","Fixed formatting on changelog page to take up the whole page.","Added many MAPP numbers to the movie list.")),
	Array('date' => "November 26, 2021", 'version' => 'Version 2.6.1', 'details' => Array("Fixed a bug with a table where sorting by last spin didn't work as intended.")),
	Array('date' => "November 26, 2021", 'version' => 'Version 2.6.0', 'details' => Array("Added Dry Spell calculator.","Removed 'scribe' and 'err' from viewers table to make room fro dry spell.","Added terms and definitions to viewers page.","Added service choice chart to viewers page.")),
	Array('date' => "November 18, 2021", 'version' => 'Version 2.5.2', 'details' => Array("Added a fun attendance visual mode.")),
	Array('date' => "November 11, 2021", 'version' => 'Version 2.5.1', 'details' => Array("Added Column and Bar charts to Viewers & Viewer Page to better display spun numbers and spun people.","Now sort viewers by attendance on Viewer page.")),
	Array('date' => "October 22, 2021", 'version' => 'Version 2.5.0', 'details' => Array("Added secret fireworks for special events.","Added runtime to extended information.")),
	Array('date' => "September 30, 2021", 'version' => 'Version 2.3.2', 'details' => Array("Changed some backend DB thingies","Corrected some film information","Added Longest Winning Streak column to viewers table","Remove 'min' from movies table to allow it to sort properly while I consider options")),
	Array('date' => "September 17, 2021", 'version' => 'Version 2.3.1', 'details' => Array("Fixed version number.")),
	Array('date' => "September 17, 2021", 'version' => 'Version 2.2.3', 'details' => Array("Added runtime to movie list.","Added preliminary calculations for total watch time.","Reworked the watch time calculations for improved accuracy.")),
	Array('date' => "September 16, 2021", 'version' => 'Version 2.2.2', 'details' => Array("No update, just wanted to say hi.")),
	Array('date' => "August 19, 2021", 'version' => 'Version 2.2.2', 'details' => Array("Fixed bug where user attendance was counted incorrectly for some users.","Re-added 'One Hit Wonder' counter to the bottom of the Movies Page.")),
	Array('date' => "August 5, 2021", 'version' => 'Version 2.2.1', 'details' => Array("Added a new chart to show how much we've used different selection methods.","Fixed header image so it's clickable.","Updated Version Number","Added Version Number to Change Log")),
	Array('date' => "July 29, 2021", 'version' => 'Version 2.2', 'details' => Array("Fixed a bug on event log which showed two % signs.","Added last pick to table","Renamed table columns","Added Service Stats","Added an Expand All toggle button. Need to find a place for this to live.","Saved you a click. You're welcome.","Added table sorting order for viewers page.","Fixed some typos in movie names.")),
	Array('date' => "June 1, 2021", 'version' => 'Version 2.1.3', 'details' => Array("Footer now displays site version number","Viewer Details now lists movies sorted by how many times they have put it on the wheel")),
	Array('date' => "March 27, 2021", 'version' => '2.1.2', 'details' => Array("Added changelog"))
);
?>

<div class="album py-5 bg-light">
	<div class="container">
		<p class="display-6 text-center mb-5">Changelog</p>

		<div class="row ">
			<div class="card">
				 <div class="card-body">
					 <div id="content">
						 <ul class="timeline">
							 <?php foreach($changes as $single):?>
								 <li class="event" data-date="<?php echo $single['date'];?>">
									<h3><?php echo $single['version'];?></h3>
									<?php
										foreach($single['details'] as $detail){
											echo '<p>'.$detail.'</p>';
										}
									?>

							 <?php endforeach;?>

						 </ul>
					 </div>
				 </div>
			 </div>


		</div>
	</div>
</div>

<?php template('footer');?>
