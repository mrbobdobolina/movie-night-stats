<?php /** @noinspection PhpUnnecessaryCurlyVarSyntaxInspection */
/** @noinspection SpellCheckingInspection */

include( ROOT . '/inc/Event_Date.php' );
include( ROOT . '/inc/Event_Item.php' );
include( ROOT . '/inc/Media_Item.php' );
include( ROOT . '/inc/Media_Reviews.php' );
include( ROOT . '/inc/Spinner_List.php' );
include( ROOT . '/inc/Spinner_Item.php' );
include( ROOT . '/inc/Viewer_Item.php' );
include( ROOT . '/inc/Viewer_List.php' );

class Event_List {
	public array $events;
	private Viewer_List $viewer_list;

	public function __construct($viewer_list = NULL) {
		$this->viewer_list = $viewer_list;
	}

	public function init() {
		// Header info in the week table
		$query = "SELECT `week`.`id`,`week`.`date`,\n";

		// Loop over every wedge
		for ($i = 1; $i <= 12; $i++) {
			// Grab the movie on this wedge and any info in the `films` table
			$query .= "`week`.`wheel_{$i}` AS `wedge_{$i}_media_id`,";
			$query .= "`wedge_{$i}`.`name` AS `wedge_{$i}_media_name`,";
			$query .= "`wedge_{$i}`.`tomatometer` AS `wedge_{$i}_media_review_tomatometer`,";
			$query .= "`wedge_{$i}`.`rt_audience` AS `wedge_{$i}_media_review_rtaudience`,";
			$query .= "`wedge_{$i}`.`imdb` AS `wedge_{$i}_media_review_imdb`,";
			$query .= "`wedge_{$i}`.`metacritic` AS `wedge_{$i}_media_review_metacritic`,";
			$query .= "`wedge_{$i}`.`meta_userscore` AS `wedge_{$i}_media_review_metauserscore`,";
			$query .= "`wedge_{$i}`.`year` AS `wedge_{$i}_media_year`,";
			$query .= "`wedge_{$i}`.`type` AS `wedge_{$i}_media_type`,";
			$query .= "`wedge_{$i}`.`runtime` AS `wedge_{$i}_media_runtime`,";
			$query .= "`wedge_{$i}`.`mpaa` AS `wedge_{$i}_media_mpaa`,";
			$query .= "`wedge_{$i}`.`mpaa` AS `wedge_{$i}_media_mpaa`,";
			$query .= "`wedge_{$i}`.`first_instance` AS `wedge_{$i}_instance_first`,";
			$query .= "`wedge_{$i}`.`last_instance` AS `wedge_{$i}_instance_last`,";
			$query .= "`wedge_{$i}`.`imdb_id` AS `wedge_{$i}_imdb_id`,";
			$query .= "`wedge_{$i}`.`poster_url` AS `wedge_{$i}_poster_url`,";

			// Grab the viewer for this wedge and any info in the `viewers` table
			$query .= "`week`.`moviegoer_{$i}` AS `wedge_{$i}_viewer_id`,";
			$query .= "`viewer_{$i}`.`name` AS `wedge_{$i}_viewer_name`,";
			$query .= "`viewer_{$i}`.`color` AS `wedge_{$i}_viewer_color`,";
		}

		// Grab the selection method and extra info from the `spinners` table
		$query .= "`week`.`selection_method` AS `spinner_name`,";
		$query .= "`spinners`.`id` AS `spinner_id`,";
		for ($i = 1; $i <= 12; $i++) {
			$query .= "`spinners`.`wedge_{$i}` AS `spinner_color_{$i}`,";
		}

		// Grab the winning movie and info from the `films` table
		$query .= "`week`.`winning_film` AS `winner_media_id`,";
		$query .= "`wedge_win`.`name` AS `winner_media_name`,";
		$query .= "`wedge_win`.`tomatometer` AS `winner_media_review_tomatometer`,";
		$query .= "`wedge_win`.`rt_audience` AS `winner_media_review_rtaudience`,";
		$query .= "`wedge_win`.`imdb` AS `winner_media_review_imdb`,";
		$query .= "`wedge_win`.`metacritic` AS `winner_media_review_metacritic`,";
		$query .= "`wedge_win`.`meta_userscore` AS `winner_media_review_metauserscore`,";
		$query .= "`wedge_win`.`year` AS `winner_media_year`,";
		$query .= "`wedge_win`.`type` AS `winner_media_type`,";
		$query .= "`wedge_win`.`runtime` AS `winner_media_runtime`,";
		$query .= "`wedge_win`.`mpaa` AS `winner_media_mpaa`,";
		$query .= "`wedge_win`.`first_instance` AS `winner_media_instance_first`,";
		$query .= "`wedge_win`.`last_instance` AS `winner_media_instance_last`,";
		$query .= "`wedge_win`.`imdb_id` AS `winner_media_imdb_id`,";
		$query .= "`wedge_win`.`poster_url` AS `winner_media_poster_url`,";

		// Grab the spinner and info from the `viewers` table
		$query .= "`week`.`spinner` AS `spinner_viewer_id`,";
		$query .= "`viewer_spin`.`name` AS `spinner_viewer_name`,";
		$query .= "`viewer_spin`.`color` AS `spinner_viewer_color`,";

		// Grab the winning viewer and info from the `viewers` table
		$query .= "`week`.`winning_moviegoer` AS `winner_viewer_id`,";
		$query .= "`viewer_win`.`name` AS `winner_viewer_name`,";
		$query .= "`viewer_win`.`color` AS `winner_viewer_color`,";

		// Grab the scribe and info from the `viewers` table
		$query .= "`week`.`scribe` AS `scribe_viewer_id`,";
		$query .= "`viewer_scribe`.`name` AS `scribe_viewer_name`,";
		$query .= "`viewer_scribe`.`color` AS `scribe_viewer_color`,";

		// Grab other data
		$query .= "`week`.`winning_wedge`,";
		$query .= "`week`.`format`,";
		$query .= "`week`.`error_spin`,";
		$query .= "`week`.`theme`,";
		$query .= "`week`.`attendees`,";
		$query .= "`week`.`runtime`,";
		$query .= "`week`.`notes`";
		$query .= " FROM `week` ";

		// Join wedge films and viewers
		for ($i = 1; $i <= 12; $i++) {
			$query .= "LEFT JOIN `films` AS `wedge_{$i}`  ON `week`.`wheel_{$i}` =`wedge_{$i}`.`id` ";
			$query .= "LEFT JOIN `viewers` AS `viewer_{$i}`  ON `week`.`moviegoer_{$i}` =`viewer_{$i}`.`id` ";
		}

		// Join Winning Film
		$query .= "LEFT JOIN `films` AS `wedge_win` ON `week`.`winning_film`=`wedge_win`.`id`";

		// Join Spinner
		$query .= "LEFT JOIN `viewers` AS `viewer_spin` ON `week`.`spinner`=`viewer_spin`.`id`";

		// Join Winner
		$query .= "LEFT JOIN `viewers` AS `viewer_win`  ON `week`.`winning_moviegoer`=`viewer_win`.`id`";

		// Join Scribe
		$query .= "LEFT JOIN `viewers` AS `viewer_scribe`  ON `week`.`scribe`=`viewer_scribe`.`id`";

		// Join Selection Method
		$query .= "LEFT JOIN `spinners` AS `spinners`  ON `week`.`selection_method`=`spinners`.`name`";


		$query .= "ORDER BY `date` DESC";

//        echo $query;
		$data = db($query);


		$this->events = [];

		foreach ($data as $thing) {
			$event = new Event_Item();

			$event->viewer_list = $this->viewer_list;
			$event->id = $thing['id'];

			$event->date->date = $thing['date'];

			$event->wedges = [];
			$event->viewers = [];

			$event->error_spins = strlen($thing['error_spin']) ? explode(', ', $thing['error_spin']) : [];

			for ($i = 1; $i <= 12; $i++) {

				$media = new Media_Item();

				$media->id = $thing['wedge_' . $i . '_media_id'];
				$media->name = $thing['wedge_' . $i . '_media_name'];
				$media->year = $thing['wedge_' . $i . '_media_year'];
				$media->type = $thing['wedge_' . $i . '_media_type'];
				$media->runtime = $thing['wedge_' . $i . '_media_runtime'];
				$media->mpaa = $thing['wedge_' . $i . '_media_mpaa'];
				$media->imdb_id = $thing['wedge_' . $i . '_imdb_id'];
				$media->poster_url = $thing['wedge_' . $i . '_poster_url'];
				$media->instances = [
					'first' => $thing['wedge_' . $i . '_instance_first'],
					'last'  => $thing['wedge_' . $i . '_instance_last'],
				];
				$media->reviews->tomatometer = $thing['wedge_' . $i . '_media_review_tomatometer'];
				$media->reviews->rtaudience = $thing['wedge_' . $i . '_media_review_rtaudience'];
				$media->reviews->imdb = $thing['wedge_' . $i . '_media_review_imdb'];
				$media->reviews->metacritic = $thing['wedge_' . $i . '_media_review_metacritic'];
				$media->reviews->metauserscore = $thing['wedge_' . $i . '_media_review_metauserscore'];

				$event->wedges[$i] = [
					'media'         => $media,
					'viewer'        => new Viewer_Item(),
					'is_winner'     => ( $i == $thing['winning_wedge'] ),
					'is_error_spin' => in_array($i, $event->error_spins),
				];

				$event->wedges[$i]['viewer']->id = $thing['wedge_' . $i . '_viewer_id'];
				$event->wedges[$i]['viewer']->name = $thing['wedge_' . $i . '_viewer_name'];
				$event->wedges[$i]['viewer']->color = $thing['wedge_' . $i . '_viewer_color'];
			}

			$winner_media = new Media_Item();

			$winner_media->id = $thing['winner_media_id'];
			$winner_media->name = $thing['winner_media_name'];
			$winner_media->year = $thing['winner_media_year'];
			$winner_media->type = $thing['winner_media_type'];
			$winner_media->runtime = $thing['winner_media_runtime'];
			$winner_media->mpaa = $thing['winner_media_mpaa'];
			$winner_media->imdb_id = $thing['winner_media_imdb_id'];
			$winner_media->poster_url = $thing['winner_media_poster_url'];

			$winner_media->instances = [
				'first' => $thing['winner_media_instance_first'],
				'last'  => $thing['winner_media_instance_last'],
			];
			$winner_media->reviews->tomatometer = $thing['winner_media_review_tomatometer'];
			$winner_media->reviews->rtaudience = $thing['winner_media_review_rtaudience'];
			$winner_media->reviews->imdb = $thing['winner_media_review_imdb'];
			$winner_media->reviews->metacritic = $thing['winner_media_review_metacritic'];
			$winner_media->reviews->metauserscore = $thing['winner_media_review_metauserscore'];

			$event->winner['media'] = $winner_media;


			$event->winner['viewer']->id = $thing['winner_viewer_id'];
			$event->winner['viewer']->name = $thing['winner_viewer_name'];
			$event->winner['viewer']->color = $thing['winner_viewer_color'];



			$event->spinner->id = $thing['spinner_viewer_id'];
			$event->spinner->name = $thing['spinner_viewer_name'];
			$event->spinner->color = $thing['spinner_viewer_color'];

			$event->scribe->id = $thing['scribe_viewer_id'];
			$event->scribe->name = $thing['scribe_viewer_name'];
			$event->scribe->color = $thing['scribe_viewer_color'];

			$event->winning_wedge = $thing['winning_wedge'];

			$event->format->name = $thing['format'];

			$event->selection_method->id = $thing['spinner_id'];
			$event->selection_method->name = $thing['spinner_name'];

			for ($i = 1; $i <= 12; $i++) {
				if ($thing['spinner_color_' . $i] !== NULL) {
					$event->selection_method->wedges[$i] = $thing['spinner_color_' . $i];
				}
			}

			$event->theme = $thing['theme'];
			$event->attendees = $thing['attendees'];
			$event->runtime = $thing['runtime'];
			$event->notes = $thing['notes'];


//			$this->events[] = new Event_Item($thing, $this->viewer_list);
			$this->events[] = $event;
		}
	}

	public function sum_watchtime() {
		$watchtime = 0;
		foreach ($this->events() as $event) {
			$watchtime += $event->runtime;
		}

		return $watchtime;
	}

	public function events() {
		return $this->events;
	}


}
