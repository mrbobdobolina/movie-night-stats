<?php /** @noinspection PhpUnnecessaryCurlyVarSyntaxInspection */
/** @noinspection SpellCheckingInspection */

class Event_Item {

	public $id;
	public $date;
	public $wedges;
	public $viewers;
	public $winner;
	public $spinner;
	public $scribe;
	public $winning_wedge;
	public $format;
	public $error_spin;
	public $theme;
	public $attendees;
	public $selection_method;
	public $runtime;
	public $notes;
	/**
	 * @var mixed
	 */
	public $viewer_list;

	public function __construct($data = null, $viewer_list = null){
		if($viewer_list){
			$this->viewer_list = $viewer_list;
		}
        if($data){

			$this->id = $data['id'];
			$this->date = new Event_Date($data['date']);
			$this->wedges = [];
			$this->viewers = [];

			for($i = 1; $i <= 12; $i++){
				$this->wedges[$i] = [
					'media' => new Media_Item([
						'id'   => $data['wedge_'.$i.'_media_id'],
						'name' => $data['wedge_'.$i.'_media_name'],
						'reviews' => new Media_Reviews([
							'tomatometer'   => $data['wedge_'.$i.'_media_review_tomatometer'],
							'rtaudience'    => $data['wedge_'.$i.'_media_review_rtaudience'],
							'imdb'          => $data['wedge_'.$i.'_media_review_imdb'],
							'metacritic'    => $data['wedge_'.$i.'_media_review_metacritic'],
							'metauserscore' => $data['wedge_'.$i.'_media_review_metauserscore']
						]),
						'year'    => $data['wedge_'.$i.'_media_year'],
						'runtime' => $data['wedge_'.$i.'_media_runtime'],
						'mpaa'    => $data['wedge_'.$i.'_media_mpaa'],
						'instances' => [
							'first' => $data['wedge_'.$i.'_instance_first'],
							'last'  => $data['wedge_'.$i.'_instance_last']
						],
						'imdb_id'    => $data['wedge_'.$i.'_imdb_id'],
						'poster_url' => $data['wedge_'.$i.'_poster_url']
					]),
					'viewer' => new Viewer_Item([
						'id'    => $data['wedge_'.$i.'_viewer_id'],
						'name'  => $data['wedge_'.$i.'_viewer_name'],
						'color' => $data['wedge_'.$i.'_viewer_color']
					])
				];
			}

			$this->winner['media'] = new Media_Item([
				'id'   => $data['winner_media_id'],
				'name' => $data['winner_media_name'],
				'reviews' => new Media_Reviews([
					'tomatometer'   => $data['winner_media_review_tomatometer'],
					'rtaudience'    => $data['winner_media_review_rtaudience'],
					'imdb'          => $data['winner_media_review_imdb'],
					'metacritic'    => $data['winner_media_review_metacritic'],
					'metauserscore' => $data['winner_media_review_metauserscore']
				]),
				'year'    => $data['winner_media_year'],
				'runtime' => $data['winner_media_runtime'],
				'mpaa'    => $data['winner_media_mpaa'],
				'instances' => [
					'first' => $data['winner_media_instance_first'],
					'last'  => $data['winner_media_instance_last']
				],
				'imdb_id'    => $data['winner_media_imdb_id'],
				'poster_url' => $data['winner_media_poster_url']
			]);

			$this->spinner = new Viewer_Item([
				'id'    => $data['spinner_viewer_id'],
				'name'  => $data['spinner_viewer_name'],
				'color' => $data['spinner_viewer_color']
			]);
			$this->winner['viewer'] = new Viewer_Item([
				'id'    => $data['winner_viewer_id'],
				'name'  => $data['winner_viewer_name'],
				'color' => $data['winner_viewer_color']
			]);
			$this->scribe = new Viewer_Item([
				'id'    => $data['scribe_viewer_id'],
				'name'  => $data['scribe_viewer_name'],
				'color' => $data['scribe_viewer_color']
			]);

			$this->winning_wedge = $data['winning_wedge'];
			$this->format = new stdClass();
			$this->format->name = $data['format'];
			$this->error_spin = $data['error_spin'];
			$this->theme = $data['theme'];
			$this->attendees = $data['attendees'];
			$this->selection_method = $data['selection_method'];
			$this->runtime = $data['runtime'];
			$this->notes = $data['notes'];
        }
    }

	
	public function average_year(){
		$count = 0;
		$total = 0;
		
		foreach($this->wedges as $wedge){
			if($wedge['media']->year !== null){
				$count++;
				$total += $wedge['media']->year;
			}
		}
		
		return round(($total/$count), 0);
	}
	
	public function average_rating(){
		$count = 0;
		$total = 0;
		
		foreach($this->wedges as $wedge){
			if($wedge['media']->reviews->average() != NULL){
				$count++;
				$total += $wedge['media']->reviews->average();
			}
		}
		
		return ($count) ? round(($total/$count), 1) : NULL;
	}
}
