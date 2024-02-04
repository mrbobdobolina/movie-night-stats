<?php

class Media_Item {
	public int $id;
	public string $name;
	public Media_Reviews $reviews;
	public int|null $year;
	public int|null $runtime;
	public string|null $mpaa;
	public array $instances;
	public string|null $imdb_id;
	public string|null $poster_url;
	public string|null $type;

	public function __construct() {
		$this->reviews = new Media_Reviews();

		$this->type = '';

		return $this;
	}

	public function poster_url_or_bust() {
		if ($this->poster_url) {
			return $this->poster_url;
		}
		return "https://via.placeholder.com/400x600/333/fff?text=" . str_replace(" ", "+", $this->name);
	}
}
