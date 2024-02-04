// PAGE THEMES

function get_page_theme() {
	// return localStorage.getItem('theme') ?? 'light';
	return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
}

function apply_theme($theme) {
	document.documentElement.setAttribute('data-bs-theme', $theme);
}

apply_theme(get_page_theme());

// NUMBERING

function arabic_to_roman_numerals($number) {
	let $lookup = {
		M: 1000, CM: 900,
		D: 500, CD: 400,
		C: 100, XC: 90,
		L: 50, XL: 40,
		X: 10, IX: 9,
		V: 5, IV: 4,
		I: 1,
	};

	let $roman_numeral = '';

	for (let $i in $lookup) {
		while ($number >= $lookup[$i]) {
			$roman_numeral += $i;
			$number -= $lookup[$i];
		}
	}

	return $roman_numeral;
}

function arabic_to_japanese_kanji($number) {
	const $count_thousands = Math.floor($number / 1000);
	const $count_hundreds = Math.floor($number % 1000 / 100);
	const $count_tens = Math.floor($number % 1000 % 100 / 10);
	const $count_ones = Math.floor($number % 1000 % 100 % 10);

	const $kanji = {
		1: '一', 2: '二', 3: '三', 4: '四', 5: '五', 6: '六', 7: '七', 8: '八', 9: '九',
		10: '十',
		100: '百',
		1000: '千',
	};

	let $value = '';

	if ($count_thousands) {
		$value += ( ( $count_thousands > 1 ) ? $kanji[$count_thousands] : '' ) + $kanji[1000];
	}
	if ($count_hundreds) {
		$value += ( ( $count_hundreds > 1 ) ? $kanji[$count_hundreds] : '' ) + $kanji[100];
	}
	if ($count_tens) {
		$value += ( ( $count_tens > 1 ) ? $kanji[$count_tens] : '' ) + $kanji[10];
	}
	if ($count_ones) {
		$value += $kanji[$count_ones];
	}

	return $value;
}

function arabic_to_numbering_system($arabic_number, $numbering_system) {
	switch ($numbering_system) {
		case 'roman':
			return arabic_to_roman_numerals($arabic_number);
		case 'japanese':
			return arabic_to_japanese_kanji($arabic_number);
		default:
			return $arabic_number;
	}
}

function get_mns_numbers() {
	return localStorage.getItem('mns-numbers') ?? 'arabic';
}

function set_mns_numbers($number_type) {
	localStorage.setItem('mns-numbers', $number_type);
	apply_mns_numbers($number_type);
}

function apply_mns_numbers($numbering_system) {
	document.querySelectorAll('[data-mns-number]').forEach(($element) => {
		$element.innerHTML = arabic_to_numbering_system($element.getAttribute('data-mns-number'), $numbering_system);
	});
}

$(function () {
	apply_mns_numbers(get_mns_numbers());
});
