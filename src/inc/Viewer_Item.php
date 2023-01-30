<?php

class Viewer_Item {
	public $id;
	public $name;
	public $color;

	public function __construct($data = null){
		if($data){
			$this->id = $data['id'];
			$this->name = $data['name'];
			$this->color = $data['color'];
		}
	}
}
