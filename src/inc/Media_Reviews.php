<?php /** @noinspection SpellCheckingInspection */

class Media_Reviews {
	public $tomatometer;
	public $rtaudience;
	public $imdb;
	public $metacritic;
	public $metauserscore;

	public function average(): ?float {
		$count = 0;
		$total = 0;

		if ($this->tomatometer != NULL) {
			$count++;
			$total += $this->tomatometer;
		}
		if ($this->rtaudience != NULL) {
			$count++;
			$total += $this->rtaudience;
		}
		if ($this->imdb != NULL) {
			$count++;
			$total += $this->imdb;
		}
		if ($this->metacritic != NULL) {
			$count++;
			$total += $this->metacritic;
		}
		if ($this->metauserscore != NULL) {
			$count++;
			$total += $this->metauserscore;
		}

		return ( $count ) ? round(( $total / $count ), 1) : NULL;

	}
}
