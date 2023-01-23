<?php /** @noinspection PhpUnnecessaryCurlyVarSyntaxInspection */
/** @noinspection SpellCheckingInspection */

class Event_Item {

	public $id;
	public $date;
	public $wedges;
	public $viewers;
	public $winner_media;
	public $winner_viewer;
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

	public function __construct($data = null){
        if($data){

			$this->id = $data['id'];
			$this->date = new Event_Date($data['date']);
			$this->wedges = [];
			$this->viewers = [];

			for($i = 1; $i <= 12; $i++){
				$this->wedges[$i] = new Media_Item([
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
					'mpaa'    => $data['wedge_'.$i.'_media_mpaa']
				]);

				$this->viewers[$i] = new Viewer_Item([
					'id'    => $data['wedge_'.$i.'_viewer_id'],
					'name'  => $data['wedge_'.$i.'_viewer_name'],
					'color' => $data['wedge_'.$i.'_viewer_color']
				]);
			}

			$this->winner_media = new Media_Item([
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
				'mpaa'    => $data['winner_media_mpaa']
			]);

			$this->spinner = new Viewer_Item([
				'id'    => $data['spinner_viewer_id'],
				'name'  => $data['spinner_viewer_name'],
				'color' => $data['spinner_viewer_color']
			]);
			$this->winner_viewer = new Viewer_Item([
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
			$this->format = $data['format'];
			$this->error_spin = $data['error_spin'];
			$this->theme = $data['theme'];
			$this->attendees = $data['attendees'];
			$this->selection_method = $data['selection_method'];
			$this->runtime = $data['runtime'];
			$this->notes = $data['notes'];
        }
    }

}