<?php

class Media_Item {
	public $id;
	public $name;
	public $reviews;
	public $year;
	public $runtime;
	public $mpaa;
	public $instances;
	public $imdb_id;
	public $poster_url;

	public function __construct($data = null){
		if($data){
//			print_r($data);
			$this->id = $data['id'];
			$this->name = $data['name'];
			$this->reviews = $data['reviews'];
			$this->year = $data['year'];
			$this->runtime = $data['runtime'];
			$this->mpaa = $data['mpaa'];
			$this->instances = $data['instances'];
			$this->imdb_id = $data['imdb_id'];
			$this->poster_url = $data['poster_url'];
		}
	}
}
