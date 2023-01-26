<?php

class Viewer_List {
	public $viewers;
	public $event_list;

	public function __construct($event_list = null){
		$this->viewers = [];
		$this->event_list = $event_list;
	}
	
	public function init(){
		$query = "SELECT `id`,`name`,`color`,`attendance` FROM `viewers`";
		
		$data = db($query);
		
		$this->viewers = [];
		foreach($data as $viewer){
			$this->viewers[$viewer['id']] = new Viewer_Item([
				'id'    => $viewer['id'],
				'name'  => $viewer['name'],
				'color' => $viewer['color'],
				'attendance' => $viewer['attendance']
			]);
		}
	}
	
	public function get_by_id($viewer_id){
		return $this->viewers[$viewer_id];
	}
}
