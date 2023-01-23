<?php /** @noinspection SpellCheckingInspection */

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
	
	public function average(): ?float {
		$count = 0;
		$total = 0;
		
		if($this->tomatometer != NULL){
			$count++;
			$total += $this->tomatometer;
		}
		if($this->rtaudience != NULL){
			$count++;
			$total += $this->rtaudience;
		}
		if($this->imdb != NULL){
			$count++;
			$total += $this->imdb;
		}
		if($this->metacritic != NULL){
			$count++;
			$total += $this->metacritic;
		}
		if($this->metauserscore != NULL){
			$count++;
			$total += $this->metauserscore;
		}
		
		return ($count) ? round(($total / $count), 1) : NULL;

	}
}
