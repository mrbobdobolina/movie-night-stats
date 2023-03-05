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
	public $error_spins;
	public $theme;
	public $attendees;
	public $selection_method;
	public $runtime;
	public $notes;
	/**
	 * @var mixed
	 */
	public $viewer_list;

	public function __construct(){
		return $this;
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
	
	public function attendees(){
		$viewers = [];
		
		foreach(explode(',',$this->attendees) as $viewer_id){
			$viewer_id = trim($viewer_id);
			$viewers[] = $this->viewer_list->get_by_id($viewer_id);
		}
		
		return $viewers;
	}
}
