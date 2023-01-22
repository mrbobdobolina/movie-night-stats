<?php

class Viewer_Item {
	public function __construct($data = null){
		if($data){
			print_r($data);
		}
	}
}