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
    public $type;

    public function __construct(){
        $this->reviews = new Media_Reviews();

        $this->type = '';
	}
	
	public function poster_url_or_bust() {
		if($this->poster_url){
			return $this->poster_url;
		}
		return "https://via.placeholder.com/400x600/333/fff?text=".str_replace(" ","+",$this->name);
	}
}
