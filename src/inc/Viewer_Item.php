<?php

class Viewer_Item {
	public int $id;
	public string|null $name;
	public string|null $color;
	public string $attendance;

	public function __construct() {
		$this->id = 0;
		return $this;
	}
}
