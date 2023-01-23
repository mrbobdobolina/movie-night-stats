<?php

class Media_Reviews {
	private $tomatometer;
	private $rtaudience;
	private $imdb;
	private $metacritic;
	private $metauserscore;

	public function __construct($data = null){
		if($data){
			$this->tomatometer = $data['tomatometer'];
			$this->rtaudience = $data['rtaudience'];
			$this->imdb = $data['imdb'];
			$this->metacritic = $data['metacritic'];
			$this->metauserscore = $data['metauserscore'];
		}
	}
}