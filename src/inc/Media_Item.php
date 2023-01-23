<?php

class Media_Item {
	public $id;
	public $name;
	public $reviews;
	/**
	 * @var mixed
	 */
	public $year;
	/**
	 * @var mixed
	 */
	public $runtime;
	/**
	 * @var mixed
	 */
	public $mpaa;

	public function __construct($data = null){
		if($data){
//			print_r($data);
			$this->id = $data['id'];
			$this->name = $data['name'];
			$this->reviews = $data['reviews'];
			$this->year = $data['year'];
			$this->runtime = $data['runtime'];
			$this->mpaa = $data['mpaa'];
		}
	}
}