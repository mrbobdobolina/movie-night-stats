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
	public $events;
	private $viewer_list;

	public function __construct($viewer_list = NULL) {
		$this->viewer_list = $viewer_list;
	}

	public function init() {
		$query = "SELECT `week`.`id`,`week`.`date`,\n";

		for ($i = 1; $i <= 12; $i++) {
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
			$query .= "\n";
		}
		$query .= "\n";

		for ($i = 1; $i <= 12; $i++) {
			$query .= "`week`.`moviegoer_{$i}` AS `wedge_{$i}_viewer_id`,";
			$query .= "`viewer_{$i}`.`name` AS `wedge_{$i}_viewer_name`,";
			$query .= "`viewer_{$i}`.`color` AS `wedge_{$i}_viewer_color`,";
			$query .= "\n";
		}
		$query .= "\n";

		$query .= "`week`.`selection_method` AS `spinner_name`,";
		$query .= "`spinners`.`id` AS `spinner_id`,";
		for ($i = 1; $i <= 12; $i++) {
			$query .= "`spinners`.`wedge_{$i}` AS `spinner_color_{$i}`,";
		}

		$query .= "
`week`.`winning_film` AS `winner_media_id`,
`wedge_win`.`name` AS `winner_media_name`,
`wedge_win`.`tomatometer` AS `winner_media_review_tomatometer`,
`wedge_win`.`rt_audience` AS `winner_media_review_rtaudience`,
`wedge_win`.`imdb` AS `winner_media_review_imdb`,
`wedge_win`.`metacritic` AS `winner_media_review_metacritic`,
`wedge_win`.`meta_userscore` AS `winner_media_review_metauserscore`,
`wedge_win`.`year` AS `winner_media_year`,
`wedge_win`.`type` AS `winner_media_type`,
`wedge_win`.`runtime` AS `winner_media_runtime`,
`wedge_win`.`mpaa` AS `winner_media_mpaa`,
`wedge_win`.`first_instance` AS `winner_media_instance_first`,
`wedge_win`.`last_instance` AS `winner_media_instance_last`,
`wedge_win`.`imdb_id` AS `winner_media_imdb_id`,
`wedge_win`.`poster_url` AS `winner_media_poster_url`,


`week`.`spinner` AS `spinner_viewer_id`, `week`.`winning_moviegoer` AS `winner_viewer_id`, `week`.`scribe` AS `scribe_viewer_id`,
`viewer_spin`.`name` AS `spinner_viewer_name`, `viewer_win`.`name` AS `winner_viewer_name`, `viewer_scribe`.`name` AS `scribe_viewer_name`,
`viewer_spin`.`color` AS `spinner_viewer_color`, `viewer_win`.`color` AS `winner_viewer_color`, `viewer_scribe`.`color` AS `scribe_viewer_color`,




`week`.`winning_wedge`,`week`.`format`,`week`.`error_spin`,`week`.`theme`,`week`.`attendees`,`week`.`runtime`,`week`.`notes`



FROM `week`
";

		for ($i = 1; $i <= 12; $i++) {
			$query .= "LEFT JOIN `films` AS `wedge_{$i}`  ON `week`.`wheel_{$i}` =`wedge_{$i}`.`id` ";
			$query .= "LEFT JOIN `viewers` AS `viewer_{$i}`  ON `week`.`moviegoer_{$i}` =`viewer_{$i}`.`id` ";
		}

		$query .= "


LEFT JOIN `films` AS `wedge_win` ON `week`.`winning_film`=`wedge_win`.`id`


LEFT JOIN `viewers` AS `viewer_spin` ON `week`.`spinner`=`viewer_spin`.`id`
LEFT JOIN `viewers` AS `viewer_win`  ON `week`.`winning_moviegoer`=`viewer_win`.`id`
LEFT JOIN `viewers` AS `viewer_scribe`  ON `week`.`scribe`=`viewer_scribe`.`id`

LEFT JOIN `spinners` AS `spinners`  ON `week`.`selection_method`=`spinners`.`name`


ORDER BY `date` DESC";

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

				$event->wedges[$i] = [
					'media'         => new Media_Item(),
					'viewer'        => new Viewer_Item(),
					'is_winner'     => ( $i == $thing['winning_wedge'] ),
					'is_error_spin' => in_array($i, $event->error_spins),
				];

				$event->wedges[$i]['media']->id = $thing['wedge_' . $i . '_media_id'];
				$event->wedges[$i]['media']->name = $thing['wedge_' . $i . '_media_name'];
				$event->wedges[$i]['media']->year = $thing['wedge_' . $i . '_media_year'];
				$event->wedges[$i]['media']->type = $thing['wedge_' . $i . '_media_type'];
				$event->wedges[$i]['media']->runtime = $thing['wedge_' . $i . '_media_runtime'];
				$event->wedges[$i]['media']->mpaa = $thing['wedge_' . $i . '_media_mpaa'];
				$event->wedges[$i]['media']->imdb_id = $thing['wedge_' . $i . '_imdb_id'];
				$event->wedges[$i]['media']->poster_url = $thing['wedge_' . $i . '_poster_url'];

				$event->wedges[$i]['media']->instances = [
					'first' => $thing['wedge_' . $i . '_instance_first'],
					'last'  => $thing['wedge_' . $i . '_instance_last'],
				];
				$event->wedges[$i]['media']->reviews->tomatometer = $thing['wedge_' . $i . '_media_review_tomatometer'];
				$event->wedges[$i]['media']->reviews->rtaudience = $thing['wedge_' . $i . '_media_review_rtaudience'];
				$event->wedges[$i]['media']->reviews->imdb = $thing['wedge_' . $i . '_media_review_imdb'];
				$event->wedges[$i]['media']->reviews->metacritic = $thing['wedge_' . $i . '_media_review_metacritic'];
				$event->wedges[$i]['media']->reviews->metauserscore = $thing['wedge_' . $i . '_media_review_metauserscore'];


				$event->wedges[$i]['viewer']->id = $thing['wedge_' . $i . '_viewer_id'];
				$event->wedges[$i]['viewer']->name = $thing['wedge_' . $i . '_viewer_name'];
				$event->wedges[$i]['viewer']->color = $thing['wedge_' . $i . '_viewer_color'];
			}

			$event->winner['media']->id = $thing['winner_media_id'];
			$event->winner['media']->name = $thing['winner_media_name'];
			$event->winner['media']->year = $thing['winner_media_year'];
			$event->winner['media']->type = $thing['winner_media_type'];
			$event->winner['media']->runtime = $thing['winner_media_runtime'];
			$event->winner['media']->mpaa = $thing['winner_media_mpaa'];
			$event->winner['media']->imdb_id = $thing['winner_media_imdb_id'];
			$event->winner['media']->poster_url = $thing['winner_media_poster_url'];

			$event->winner['media']->instances = [
				'first' => $thing['winner_media_instance_first'],
				'last'  => $thing['winner_media_instance_last'],
			];
			$event->winner['media']->reviews->tomatometer = $thing['winner_media_review_tomatometer'];
			$event->winner['media']->reviews->rtaudience = $thing['winner_media_review_rtaudience'];
			$event->winner['media']->reviews->imdb = $thing['winner_media_review_imdb'];
			$event->winner['media']->reviews->metacritic = $thing['winner_media_review_metacritic'];
			$event->winner['media']->reviews->metauserscore = $thing['winner_media_review_metauserscore'];

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
