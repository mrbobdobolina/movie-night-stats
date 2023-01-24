<?php

class Viewer_List {
	public $viewers;

	public function __construct(){
		$this->viewers = [];
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
