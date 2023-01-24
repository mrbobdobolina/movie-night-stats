<?php /** @noinspection PhpUnnecessaryCurlyVarSyntaxInspection */
/** @noinspection SpellCheckingInspection */

include(ROOT.'/inc/Event_Date.php');
include(ROOT.'/inc/Event_Item.php');
include(ROOT.'/inc/Media_Item.php');
include(ROOT.'/inc/Media_Reviews.php');
include(ROOT.'/inc/Viewer_Item.php');
include(ROOT.'/inc/Viewer_List.php');

class Event_List {
	private $events;
	private $viewer_list;

	public function __construct(){
		$this->viewer_list = new Viewer_List();
		$this->viewer_list->init();
	}

	public function init(){
		$query = "SELECT `week`.`id`,`week`.`date`,\n";

		for($i = 1; $i <= 12; $i++){
			$query .= "`week`.`wheel_{$i}` AS `wedge_{$i}_media_id`,";
			$query .= "`wedge_{$i}`.`name` AS `wedge_{$i}_media_name`,";
			$query .= "`wedge_{$i}`.`tomatometer` AS `wedge_{$i}_media_review_tomatometer`,";
			$query .= "`wedge_{$i}`.`rt_audience` AS `wedge_{$i}_media_review_rtaudience`,";
			$query .= "`wedge_{$i}`.`imdb` AS `wedge_{$i}_media_review_imdb`,";
			$query .= "`wedge_{$i}`.`metacritic` AS `wedge_{$i}_media_review_metacritic`,";
			$query .= "`wedge_{$i}`.`meta_userscore` AS `wedge_{$i}_media_review_metauserscore`,";
			$query .= "`wedge_{$i}`.`year` AS `wedge_{$i}_media_year`,";
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
		for($i = 1; $i <= 12; $i++){
			$query .= "`week`.`moviegoer_{$i}` AS `wedge_{$i}_viewer_id`,";
			$query .= "`viewer_{$i}`.`name` AS `wedge_{$i}_viewer_name`,";
			$query .= "`viewer_{$i}`.`color` AS `wedge_{$i}_viewer_color`,";
			$query .= "\n";
		}
		$query .= "\n";

		$query .= "
`week`.`winning_film` AS `winner_media_id`,
`wedge_win`.`name` AS `winner_media_name`,
`wedge_win`.`tomatometer` AS `winner_media_review_tomatometer`,
`wedge_win`.`rt_audience` AS `winner_media_review_rtaudience`,
`wedge_win`.`imdb` AS `winner_media_review_imdb`,
`wedge_win`.`metacritic` AS `winner_media_review_metacritic`,
`wedge_win`.`meta_userscore` AS `winner_media_review_metauserscore`,
`wedge_win`.`year` AS `winner_media_year`,
`wedge_win`.`runtime` AS `winner_media_runtime`,
`wedge_win`.`mpaa` AS `winner_media_mpaa`,
`wedge_win`.`first_instance` AS `winner_media_instance_first`,
`wedge_win`.`last_instance` AS `winner_media_instance_last`,
`wedge_win`.`imdb_id` AS `winner_media_imdb_id`,
`wedge_win`.`poster_url` AS `winner_media_poster_url`,


`week`.`spinner` AS `spinner_viewer_id`, `week`.`winning_moviegoer` AS `winner_viewer_id`, `week`.`scribe` AS `scribe_viewer_id`,
`viewer_spin`.`name` AS `spinner_viewer_name`, `viewer_win`.`name` AS `winner_viewer_name`, `viewer_scribe`.`name` AS `scribe_viewer_name`,
`viewer_spin`.`color` AS `spinner_viewer_color`, `viewer_win`.`color` AS `winner_viewer_color`, `viewer_scribe`.`color` AS `scribe_viewer_color`,




`week`.`winning_wedge`,`week`.`format`,`week`.`error_spin`,`week`.`theme`,`week`.`attendees`,`week`.`selection_method`,`week`.`runtime`,`week`.`notes`

FROM `week`
";

		for($i = 1; $i <= 12; $i++){
			$query .= "LEFT JOIN `films` AS `wedge_{$i}`  ON `week`.`wheel_{$i}` =`wedge_{$i}`.`id` ";
			$query .= "LEFT JOIN `viewers` AS `viewer_{$i}`  ON `week`.`moviegoer_{$i}` =`viewer_{$i}`.`id` ";
		}

		$query .= "


LEFT JOIN `films` AS `wedge_win` ON `week`.`winning_film`=`wedge_win`.`id`


LEFT JOIN `viewers` AS `viewer_spin` ON `week`.`spinner`=`viewer_spin`.`id`
LEFT JOIN `viewers` AS `viewer_win`  ON `week`.`winning_moviegoer`=`viewer_win`.`id`
LEFT JOIN `viewers` AS `viewer_scribe`  ON `week`.`scribe`=`viewer_scribe`.`id`


ORDER BY `date` DESC";

//        echo $query;
		$data = db($query);
		$this->events = [];
		foreach($data as $thing){
			$this->events[] = new Event_Item($thing, $this->viewer_list);
//			print_r($test);
		}
	}

	public function events(){
		return $this->events;
	}



	public function sum_watchtime(){
		$watchtime = 0;
		foreach($this->events() as $event){
			$watchtime += $event->runtime;
		}

		return $watchtime;
	}
}
