<?php

class Viewer_List {
	public $viewers;
	public $event_list;

	public function __construct($event_list = NULL) {
		$this->viewers = [];
		$this->event_list = $event_list;
	}

	public function init() {
		$query = "SELECT `id`,`name`,`color`,`attendance` FROM `viewers`";

		$data = db($query);

		$this->viewers = [];
		foreach ($data as $viewer) {
			$this->viewers[$viewer['id']] = new Viewer_Item();
			$this->viewers[$viewer['id']]->id = $viewer['id'];
			$this->viewers[$viewer['id']]->name = $viewer['name'];
			$this->viewers[$viewer['id']]->color = $viewer['color'];
			$this->viewers[$viewer['id']]->attendance = $viewer['attendance'];
		}
	}

	public function get_by_id($viewer_id) {
		return $this->viewers[$viewer_id];
	}

	public function stats_by_viewer(): array {
		$viewer_stats = [];

		foreach ($this->viewers as $viewer) {
			$viewer_stats[$viewer->id] = [
				'item'       => $viewer,
				'attendance' => [],
				'wedges'     => [],
				'wins'       => [],
				'media'      => [],
				'spins'      => [],
				'streak'     => [
					'win'                             => [],
					'lose'                            => [],
					'last'                            => -1,
					'when_viewer_choice'              => [
						'win'  => [],
						'lose' => [],
						'last' => -1,
					],
					'when_attending'                  => [
						'win'  => [],
						'lose' => [],
						'last' => -1,
					],
					'when_attending_or_viewer_choice' => [
						'win'  => [],
						'lose' => [],
						'last' => -1,
					],
				],
				'watchtime'  => 0,
			];
		}

		// Gather stats from every event
		foreach ($this->event_list->events() as $event) {

			// Stats based on attendance
			foreach ($event->attendees() as $attendee) {
				// Attendance
				$viewer_stats[$attendee->id]['attendance'][] = $event;

				// Watchtime
				$viewer_stats[$attendee->id]['watchtime'] += $event->runtime;
			}

			// Spinners
			if ($event->spinner->id) {
				$viewer_stats[$event->spinner->id]['spins'][] = $event;
			}

			$viewers_with_film_on_wheel = []; // Stats for streaks

			foreach ($event->wedges as $wedge) {
				// Don't count blank wedges
				if ($wedge['viewer']->id) {
					$viewer_stats[$wedge['viewer']->id]['wedges'][] = $wedge;

					// Winners
					if ($wedge['is_winner']) {
						$viewer_stats[$wedge['viewer']->id]['wins'][] = [
							'media' => $wedge['media'],
							'date'  => $event->date,
							'event' => $event,
						];
					}

					// Media
					if (!array_key_exists($wedge['media']->id, $viewer_stats[$wedge['viewer']->id]['media'])) {
						$viewer_stats[$wedge['viewer']->id]['media'][$wedge['media']->id] = [
							'item'   => $wedge['media'],
							'events' => [],
						];
					}
					$viewer_stats[$wedge['viewer']->id]['media'][$wedge['media']->id]['events'][] = $event;

					// Streaks
					if (!in_array($wedge['viewer']->id, $viewers_with_film_on_wheel)) {
						$viewers_with_film_on_wheel[] = $wedge['viewer']->id;
					}
				}
			}


			// Count Streaks
			foreach ($viewers_with_film_on_wheel as $viewer_id) {
				if ($event->selection_method->name != 'viewer choice') {
					if ($viewer_id == $event->winner['viewer']->id) {
						if ($viewer_stats[$viewer_id]['streak']['last'] == 'win') {
							$viewer_stats[$viewer_id]['streak']['win'][count($viewer_stats[$viewer_id]['streak']['win']) - 1][] = $event;
						}
						else {
							$viewer_stats[$viewer_id]['streak']['win'][] = [ $event ];
						}

						$viewer_stats[$viewer_id]['streak']['last'] = 'win';

					}
					else {
						if ($viewer_stats[$viewer_id]['streak']['last'] == 'lose') {
							$viewer_stats[$viewer_id]['streak']['lose'][count($viewer_stats[$viewer_id]['streak']['lose']) - 1][] = $event;
						}
						else {
							$viewer_stats[$viewer_id]['streak']['lose'][] = [ $event ];
						}

						$viewer_stats[$viewer_id]['streak']['last'] = 'lose';

					}
				}
			}
		}

		return $viewer_stats;
	}

	public function generate_streak_stats($viewer_stats) {
		$streak_stats = [];

		foreach ($viewer_stats as $viewer_id => $viewer) {
			$streak_stats[$viewer_id] = [
				'spun_only'                           => [ 'win' => 0, 'lose' => 0, 'last' => -1 ],
				'spun_or_attendance'                  => [ 'win' => 0, 'lose' => 0, 'last' => -1 ],
				'spun_or_viewer_choice'               => [ 'win' => 0, 'lose' => 0, 'last' => -1 ],
				'spun_or_viewer_choice_or_attendance' => [ 'win' => 0, 'lose' => 0, 'last' => -1 ],
			];
		}

		return $streak_stats;
	}
}
