<?php

class Event_Date {
	private $date;

	public function __construct($data){
		$this->date = $data;
	}

	public function long(): string {
		try {
			return (new DateTime($this->date))->format('l, F j, Y');
		} catch (Exception $e) {
			return 'DATE ERROR';
		}
	}
}