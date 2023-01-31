<?php

class Spinner_List {
	public $spinners;
	public $event_list;
	
	public function init(){
		$query = "SELECT `id`,`name`";
		for($i = 1; $i <= 12; $i++){
			$query .= ",`wedge_".$i."`";
		}
		$query .= " FROM `spinners`";
		
		$data = db($query);
		
		$this->spinners = [];
		foreach($data as $spinner){
			$item = new Spinner_Item();
			$item->id = $spinner['id'];
			$item->name = $spinner['name'];
			$item->wedges = [];
			
			for($i = 1; $i <= 12; $i++){
				$item->wedges[$i] = [
					'color' => $spinner['wedge_'.$i]
				];
			}
			
			$this->spinners[] = $item;
		}
	}
	
	public function stats_by_spinner(): array {
		$spinner_stats = [];
		
		foreach($this->spinners as $spinner){
			
			$spinner_stats[$spinner->id] = [
				'item' => $spinner,
				'events' => [],
				'spaces' => [],
				'spin_count' => [
					'total' => [],
					'good' => [],
					'bad' => []
				]
			];
			
			
			foreach($spinner->wedges as $wedge_id => $spinner_wedge){
				$spinner_stats[$spinner->id]['spaces'][$wedge_id] = [
					'color' => $spinner_wedge['color'],
					'spins' => []
				];
				
				$spinner_stats[$spinner->id]['spin_count']['total'][$wedge_id] = 0;
				$spinner_stats[$spinner->id]['spin_count']['good'][$wedge_id] = 0;
				$spinner_stats[$spinner->id]['spin_count']['bad'][$wedge_id] = 0;
			}
		}
		
		foreach($this->event_list->events as $event){
			$spinner_stats[$event->selection_method->id]['events'][] = $event;
			
			
			
			// Good Spins
			$spinner_stats[$event->selection_method->id]['spin_count']['total'][$event->winning_wedge]++;
			$spinner_stats[$event->selection_method->id]['spin_count']['good'][$event->winning_wedge]++;
			$spinner_stats[$event->selection_method->id]['spaces'][$event->winning_wedge]['spins'][] = [
				'event' => $event,
				'good' => TRUE 
			];
			
			// Bad Spins
			foreach($event->error_spins ?? [] as $bad_spin){
				$spinner_stats[$event->selection_method->id]['spin_count']['total'][$bad_spin]++;
				$spinner_stats[$event->selection_method->id]['spin_count']['bad'][$bad_spin]++;
				
				$spinner_stats[$event->selection_method->id]['spaces'][$bad_spin]['spins'][] = [
					'event' => $event,
					'good' => FALSE 
				];
			}
		}
		
		return $spinner_stats;
	}
}
