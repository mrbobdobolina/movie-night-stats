<?php require_once("header.php"); ?>

  <div class="album py-5 bg-light">
    <div class="container">
			<p class="display-6 text-center mb-5">Changelog</p>

      <div class="row ">
		
				<ul>
					<h5>January 8, 2022 (Version 3.1.4)</h5>
					<li>Fixed a lot of bugs behind the scenes. </li>
					<h5>January 6, 2022 (Version 3.1.3)</h5>
					<li>Fixed typo in changelog. </li>
					<h5>December 31, 2021 (Version 3.1.2)</h5>
					<li>Chance of flurries. </li>
					<h5>December 30, 2021 (Version 3.1.1)</h5>
					<li>Minor DB adjustments. </li>
					<li>Speed up load times on Movies page... I think. </li>
					<li>Fixed issue where tooltip animations prevented tooltips from reappearing on Viewer table header. </li>
					<li>Fixed bug were all non-watched movies were listed as "one-hit-wonders"</li>
					<h5>December 27, 2021 (Version 3.1.0)</h5>
					<li>Added tooltips to viewer's table. They work most of the time.</li>
					<h5>December 26, 2021 (Version 3.0.0)</h5>
					<li>Added average viewer rating to viewer table.</li>
					<li>Added highest rated film to years page.</li>
					<li>Added lowest rated film to years page.</li>
					<li>Cleaned up code to calculate movie ratings.</li>
					<h5>December 23, 2021 (Version 2.9.2)</h5>
					<li>Fixed typos and some glaring issues.</li>
					<h5>December 18, 2021 (Version 2.9.1)</h5>
					<li>Fixed bug where data was accidentally displayed, unformatted, at the bottom of the viewers page.</li>
					<h5>December 17, 2021 (Version 2.9.0)</h5>
					<li>Added viewer stat to calculate how long each viewer has spent watching.</li>
					<li>Changed viewer table header to include icons, rather than text, in an attempt to make everything more confusing and make space for more columns.</li>
					<li>Modified column headers on Movies page to prevent First & Last Dates from creating line-breaks creating a cleaner and more condensed table.</li>
					<li>Bolded dates on changelog for better readability</li>
					<li>Swapped individual spinner charts to use css charts.</li>
					<h5>December 14, 2021 (Version 2.8.0)</h5>
					<li>Added chart to services to show minutes watched with each service.</li>
					<li>Added minutes watched by service chart to Years tab.</li>
					<li>Added Digital d12 to database so it's ready to be used.</li>
					<li>Modified db to track spinner uses.</li>
					<li>Changed wheel page to sort by uses.</li>
					<li>Changed "wheel" to "spinner" in navbar</li>
					<h5>December 13, 2021 (Version 2.7.2)</h5>
					<li>Fixed bug where fireworks prevented logo from being a clickable link.</li>
					<h5>December 12, 2021 (Version 2.7.1)</h5>
					<li>Fixed issue where nav bar extended past the screen on mobile.</li>
					<li>Modified nav bar text for simplicity.</li>
					<h5>December 12, 2021 (Version 2.7.0)</h5>
					<li>Added Yearly Stats.</li>
					<li>Fixed bug where yearly stats displayed years that haven't happened yet.</li>
					<h5>December 11, 2021 (Version 2.6.3)</h5>
					<li>Updated site with new and consistent font.</li>
					<li>Fixed something I should have fixed 100 weeks ago.</li>
					<li>Added celebratory fireworks to each page.</li>
					<li>Fixed bugs from adding fireworks to each page.</li>
					<h5>December 9, 2021 (Version 2.6.2)</h5>
					<li>Fixed bug in admin interface.</li>
					<li>Fixed typo in changelog.</li>
					<li>Fixed formatting on changelog page to take up the whole page.</li>
					<li>Added many MAPP numbers to the movie list.</li>
					<h5>November 26, 2021 (Version 2.6.1)</h5>
					<li>Fixed a bug with a table where sorting by last spin didn't work as intended.</li>
					<h5>November 26, 2021 (Version 2.6.0)</h5>
					<li>Added Dry Spell calculator.</li>
					<li>Removed "scribe" and "err" from viewers table to make room fro dry spell.</li>
					<li>Added terms and definitions to viewers page.</li>
					<li>Added service choice chart to viewers page.</li>
					<h5>November 18, 2021 (Version 2.5.2)</h5>
					<li>Added a fun attendance visual mode.</li>
					<h5>November 11, 2021 (Version 2.5.1)</h5>
					<li>Added Column and Bar charts to Viewers & Viewer Page to better display spun numbers and spun people.</li>
					<li>Now sort viewers by attendance on Viewer page.</li>
					<h5>October 22, 2021 (Version 2.5.0)</h5>
					<li>Added secret fireworks for special events.</li>
					<li>Added runtime to extended information.</li>
					<h5>September 30, 2021 (Version 2.3.2)</h5>
					<li>Changed some backend DB thingies</li>
					<li>Corrected some film information</li>
					<li>Added Longest Winning Streak column to viewers table</li>
					<li>Remove "min" from movies table to allow it to sort properly while I consider options</li>
					<h5>September 17, 2021 (Version 2.3.1)</h5>
					<li>Fixed version number.</li>
					<h5>September 17, 2021 (Version 2.2.3)</h5>
					<li>Added runtime to movie list.</li>
					<li>Added preliminary calculations for total watch time.</li>
					<li>Reworked the watch time calculations for improved accuracy.</li>
					<h5>September 16, 2021 (Version 2.2.2)</h5>
					<li>No update, just wanted to say hi.</li>
					<h5>August 19, 2021 (Version 2.2.2)</h5>
					<li>Fixed bug where user attendance was counted incorrectly for some users.</li>
					<li>Re-added "One Hit Wonder" counter to the bottom of the Movies Page.</li>
					<h5>August 5, 2021 (Version 2.2.1)</h5>
					<li>Added a new chart to show how much we've used different selection methods.</li>
					<li>Fixed header image so it's clickable.</li>
					<li>Updated Version Number</li>
					<li>Added Version Number to Change Log</li>
					<br />
					<h5>July 29, 2021 (Version 2.2)</h5>
					<li>Fixed a bug on event log which showed two % signs.</li>
					<li>Added last pick to table</li>
					<li>Renamed table columns</li>
					<li>Added Service Stats</li>
					<li>Added an Expand All toggle button. Need to find a place for this to live.</li>
					<li>Saved you a click. You're welcome.</li>
					<li>Added table sorting order for viewers page.</li>
					<li>Fixed some typos in movie names.</li>
					<br />
					<h5>June 1, 2021 (Version 2.1.3)</h5>
					<li>Footer now displays site version number</li>
					<li>Viewer Details now lists movies sorted by how many times they have put it on the wheel</li>			
					<br />
					<h5>March 27, 2021</h5>
					<li>Added changelog</li>
				</ul>
				
      </div>
    </div>
  </div>

</main>

<footer class="text-muted py-5">
  <div class="container">
								Version <?php echoVersionNumber(); ?> <a href="changelog.php">Changelog</a>
   </div>
</footer>


    <script src="bootstrap5/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
		


      
  </body>
</html>
