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

	public function css_style_color(): string {
		$html = "background-color:#{$this->color};";

		$rgb = convert_hex_to_rgb('#' .$this->color);
		$contrast = get_contract_values_from_rgb($rgb);

		$text_color = ($contrast[0] >= 4.5) ? '#FFFFFF' : '#000000';

		$html .= "color:{$text_color};";

		return $html;
	}
}
