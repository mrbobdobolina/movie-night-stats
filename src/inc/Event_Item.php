<?php

class Event_Item {
    public function __construct($data = null){
        if($data){
            print_r($data);

			for($i = 1; $i <= 12; $i++){
				new Media_Item([
					'id'   => $data['wedge_'.$i.'_media_id'],
					'name' => $data['wedge_'.$i.'_media_name'],
					'reviews' => [
						'tomatometer'   => $data['wedge_'.$i.'_media_review_tomatometer'],
						'rtaudience'    => $data['wedge_'.$i.'_media_review_rtaudience'],
						'imdb'          => $data['wedge_'.$i.'_media_review_imdb'],
						'metacritic'    => $data['wedge_'.$i.'_media_review_metacritic'],
						'metauserscore' => $data['wedge_'.$i.'_media_review_metauserscore']
					],
					'year'    => $data['wedge_'.$i.'_media_year'],
					'runtime' => $data['wedge_'.$i.'_media_runtime'],
					'mpaa'    => $data['wedge_'.$i.'_media_mpaa']
				]);
				new Viewer_Item([
					'id'    => $data['wedge_'.$i.'_viewer_id'],
					'name'  => $data['wedge_'.$i.'_viewer_name'],
					'color' => $data['wedge_'.$i.'_viewer_color']
				]);
			}

			new Media_Item([
				'id'   => $data['winner_media_id'],
				'name' => $data['winner_media_name'],
				'reviews' => [
					'tomatometer'   => $data['winner_media_review_tomatometer'],
					'rtaudience'    => $data['winner_media_review_rtaudience'],
					'imdb'          => $data['winner_media_review_imdb'],
					'metacritic'    => $data['winner_media_review_metacritic'],
					'metauserscore' => $data['winner_media_review_metauserscore']
				],
				'year'    => $data['winner_media_year'],
				'runtime' => $data['winner_media_runtime'],
				'mpaa'    => $data['winner_media_mpaa']
			]);

			new Viewer_Item([
				'id'    => $data['spinner_viewer_id'],
				'name'  => $data['spinner_viewer_name'],
				'color' => $data['spinner_viewer_color']
			]);
			new Viewer_Item([
				'id'    => $data['winner_viewer_id'],
				'name'  => $data['winner_viewer_name'],
				'color' => $data['winner_viewer_color']
			]);
			new Viewer_Item([
				'id'    => $data['scribe_viewer_id'],
				'name'  => $data['scribe_viewer_name'],
				'color' => $data['scribe_viewer_color']
			]);
        }
    }
}