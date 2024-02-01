<?php

class Event_Date {
	public $date;

	public function __construct($data = NULL) {
		return $this;
	}

	public function long(): string {
		try {
			return ( new DateTime($this->date) )->format('l, F j, Y');
		}
		catch (Exception $e) {
			return 'DATE ERROR';
		}
	}

	public function short(): string {
		try {
			return ( new DateTime($this->date) )->format('Y-m-d');
		}
		catch (Exception $e) {
			return 'DATE ERROR';
		}
	}
}
