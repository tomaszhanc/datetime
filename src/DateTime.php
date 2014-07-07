<?php

/**
 * Part of the Joomla Framework Date Package
 *
 * @copyright  Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\DateTime;

/**
 * DateTime class
 *
 * @since  2.0
 */
final class DateTime
{
	/** @var \DateTime */
	private $datetime;

	/**
	 * Constructor
	 *
	 * @param   string  $datetime
	 * @param   mixed   $timezone
	 */
	public function __construct($datetime = 'now', \DateTimeZone $timezone = null)
	{
		$this->datetime = new \DateTime($datetime, $timezone);
	}

	/**
	 *
	 * @param type $format
	 * @param type $time
	 * @param \DateTimeZone $timezone
	 * @return \Joomla\DateTime\DateTime
	 */
	public static function createFromFormat($format, $time, \DateTimeZone $timezone = null)
	{
		$datetime = is_null($timezone) ? \DateTime::createFromFormat($format, $time)
									   : \DateTime::createFromFormat($format, $time, $timezone);
		$obj = new DateTime();
		$obj->setDateTime($datetime);
		return $obj;
	}

	/**
	 *
	 * @param type $year
	 * @param type $month
	 * @param type $day
	 * @param type $hour
	 * @param type $minute
	 * @param type $second
	 * @param \DateTimeZone $timezone
	 * @return \Joomla\DateTime\DateTime
	 */
	public static function create($year, $month = null, $day = null, $hour = null, $minute = null, $second = null, \DateTimeZone $timezone = null)
	{
		$month	= intval($month) < 1 ? 1 : $month;
		$day	= intval($day) < 1 ? 1 : $day;

		$time = sprintf('%04s-%02s-%02s %02s:%02s:%02s', $year, $month, $day, $hour, $minute, $second);
		return self::createFromFormat('Y-m-d H:i:s', $time, $timezone);
	}

	/**
	 *
	 * @param type $year
	 * @param type $month
	 * @param type $day
	 * @param \DateTimeZone $timezone
	 * @return \Joomla\DateTime\DateTime
	 */
	public static function createFromDate($year, $month = null, $day = null, \DateTimeZone $timezone = null)
	{
		return self::create($year, $month, $day, null, null, null, $timezone);
	}

	/**
	 *
	 * @param type $hour
	 * @param type $minute
	 * @param type $second
	 * @param \DateTimeZone $timezone
	 * @return \Joomla\DateTime\DateTime
	 */
	public static function createFromTime($hour = null, $minute = null, $second = null, \DateTimeZone $timezone = null)
	{
		return self::create(date('Y'), date('m'), date('d'), $hour, $minute, $second, $timezone);
	}

	/**
	 *
	 * @return \Joomla\DateTime\DateTime
	 */
	public static function now()
	{
		return self::createFromTime(date('H'), date('i'), date('s'));
	}

	/**
	 *
	 * @return \Joomla\DateTime\DateTime
	 */
	public static function today()
	{
		return self::createFromTime();
	}

	/**
	 *
	 * @return \Joomla\DateTime\DateTime
	 */
	public static function yesterday()
	{
		$today = self::today();
		return $today->subDays(1);
	}

	/**
	 *
	 * @return \Joomla\DateTime\DateTime
	 */
	public static function tomorrow()
	{
		$today = self::today();
		return $today->addDays(1);
	}

	/**
	 *
	 * @param \DateInterval $interval
	 * @return \Joomla\DateTime\DateTime
	 */
	public function add(\DateInterval $interval)
	{
		return $this->modify(function(\DateTime $datetime) use($interval) {
			$datetime->add($interval);
		});
	}

	/**
	 *
	 * @param \DateInterval $interval
	 * @return \Joomla\DateTime\DateTime
	 */
	public function sub(\DateInterval $interval)
	{
		return $this->modify(function(\DateTime $datetime) use($interval) {
			$datetime->sub($interval);
		});
	}

	/**
	 *
	 * @param type $value
	 * @return \Joomla\DateTime\DateTime
	 */
	public function addDays($value)
	{
		return $this->calc($value, 'P%dD');
	}

	/**
	 *
	 * @param type $value
	 * @return \Joomla\DateTime\DateTime
	 */
	public function subDays($value)
	{
		return $this->addDays(-intval($value));
	}

	/**
	 *
	 * @param type $value
	 * @return \Joomla\DateTime\DateTime
	 */
	public function addWeeks($value)
	{
		return $this->calc($value, 'P%dW');
	}

	/**
	 *
	 * @param type $value
	 * @return \Joomla\DateTime\DateTime
	 */
	public function subWeeks($value)
	{
		return $this->addWeeks(-intval($value));
	}

	/**
	 *
	 * @param type $value
	 * @return \Joomla\DateTime\DateTime
	 */
	public function addMonths($value)
	{
		return $this->calc($value, 'P%dM');
	}

	/**
	 *
	 * @param type $value
	 * @return \Joomla\DateTime\DateTime
	 */
	public function subMonths($value)
	{
		return $this->addMonths(-intval($value));
	}

	/**
	 *
	 * @param type $value
	 * @return \Joomla\DateTime\DateTime
	 */
	public function addYears($value)
	{
		return $this->calc($value, 'P%dY');
	}

	/**
	 *
	 * @param type $value
	 * @return \Joomla\DateTime\DateTime
	 */
	public function subYears($value)
	{
		return $this->addYears(-intval($value));
	}

	/**
	 *
	 * @param type $value
	 * @return \Joomla\DateTime\DateTime
	 */
	public function addSeconds($value)
	{
		return $this->calc($value, 'PT%dS');
	}

	/**
	 *
	 * @param type $value
	 * @return \Joomla\DateTime\DateTime
	 */
	public function subSeconds($value)
	{
		return $this->addSeconds(-intval($value));
	}

	/**
	 *
	 * @param type $value
	 * @return \Joomla\DateTime\DateTime
	 */
	public function addMinutes($value)
	{
		return $this->calc($value, 'PT%dM');
	}

	/**
	 *
	 * @param type $value
	 * @return \Joomla\DateTime\DateTime
	 */
	public function subMinutes($value)
	{
		return $this->addMinutes(-intval($value));
	}

	/**
	 *
	 * @param type $value
	 * @return \Joomla\DateTime\DateTime
	 */
	public function addHours($value)
	{
		return $this->calc($value, 'PT%dH');
	}

	/**
	 *
	 * @param type $value
	 * @return \Joomla\DateTime\DateTime
	 */
	public function subHours($value)
	{
		return $this->addHours(-intval($value));
	}

	/**
	 *
	 * @return \Joomla\DateTime\DateTime
	 */
	public function beginOfDay()
	{
		return $this->modify(function(\DateTime $datetime) {
			$datetime->setTime(0, 0, 0);
		});
	}

	/**
	 *
	 * @return \Joomla\DateTime\DateTime
	 */
	public function endOfDay()
	{
		return $this->modify(function(\DateTime $datetime) {
			$datetime->setTime(23, 59, 59);
		});
	}

	/**
	 *
	 * @return \Joomla\DateTime\DateTime
	 */
	public function beginOfWeek()
	{
		$beginOfDay = $this->beginOfDay();

		// @todo maybe closure is better? e.g. for strategy later - to keep the same way of date' modifications?

		$diffInDays = 7 - intval($beginOfDay->format('N'));
		return $beginOfDay->subDays($diffInDays);
	}

	/**
	 *
	 * @return \Joomla\DateTime\DateTime
	 */
	public function endOfWeek()
	{
		$endOfDay = $this->endOfDay();

		// @todo maybe closure is better? e.g. for strategy later - to keep the same way of date' modifications?

		$diffInDays = 7 - intval($endOfDay->format('N'));
		return $endOfDay->addDays($diffInDays);
	}

	/**
	 *
	 * @return \Joomla\DateTime\DateTime
	 */
	public function beginOfMonth()
	{
		$beginOfDay = $this->beginOfDay();

		return $beginOfDay->modify(function(\DateTime $datetime) {
			$year = $datetime->format('Y');
			$month = $datetime->format('m');
			$datetime->setDate($year, $month, 1);
		});
	}

	/**
	 *
	 * @return \Joomla\DateTime\DateTime
	 */
	public function endOfMonth()
	{
		$endOfDay = $this->endOfDay();

		return $endOfDay->modify(function(\DateTime $datetime) {
			$year = $datetime->format('Y');
			$month = $datetime->format('m');
			$day = $datetime->format('t');
			$datetime->setDate($year, $month, $day);
		});
	}

	/**
	 *
	 * @return \Joomla\DateTime\DateTime
	 */
	public function beginOfYear()
	{
		$beginOfDay = $this->beginOfDay();

		return $beginOfDay->modify(function(\DateTime $datetime) {
			$year = $datetime->format('Y');
			$datetime->setDate($year, 1, 1);
		});
	}

	/**
	 *
	 * @return \Joomla\DateTime\DateTime
	 */
	public function endOfYear()
	{
		$endOfDay = $this->endOfDay();

		return $endOfDay->modify(function(\DateTime $datetime) {
			$year = $datetime->format('Y');
			$datetime->setDate($year, 12, 31);
		});
	}

	public function format($format)
	{
		return $this->datetime->format($format);
	}

	public function getOffset()
	{
		return $this->datetime->getOffset();
	}

	public function getTimestamp()
	{
		return $this->datetime->getTimestamp();
	}

	public function getTimezone()
	{
		return clone $this->datetime->getTimezone();
	}

	/** @return \DateTime */
	public function getDateTime()
	{
		return clone $this->datetime;
	}

	public function after(DateTime $datetime)
	{
		return $this->datetime > $datetime->datetime;
	}

	public function before(DateTime $datetime)
	{
		return $this->datetime < $datetime->datetime;
	}

	public function diff(DateTime $datetime, $absolute)
	{
		return $this->datetime->diff($datetime->datetime, $absolute);
	}

	public function equals(DateTime $datetime)
	{
		return $this->datetime == $datetime->datetime;
	}

	public function compareTo(DateTime $datetime)
	{
		if($this->after($datetime)) {
			return 1;
		}

		if($this->before($datetime)) {
			return -1;
		}

		return 0;
	}

	public function timeSince(DateTime $datetime = null, $detailLevel = 1, $allowAlmost = false)
	{
		$datetime = is_null($datetime) ? DateTime::now() : $datetime;
		$detailLevel = intval($detailLevel);

		$diff = $this->unitsOfTime($this->diff($datetime, true), $detailLevel);

		/** For all differences below one minute */
		if(empty($diff) || $diff[0]['unit'] == 'second') {
			return 'just now';
		}

		$format = '%s ago';
		if($this->after($datetime)) {
			$format = 'in %s';
		}

		return sprintf($format, $this->parseUnitsOfTime($diff, $allowAlmost));
	}

	public function almostTimeSince(DateTime $datetime = null, $detailLevel = 1)
	{
		return $this->timeSince($datetime, $detailLevel, true);
	}

	private function setDateTime(\DateTime $datetime)
	{
		$this->datetime = clone $datetime;
	}

	private function calc($value, $format)
	{
		$value = intval($value);
		$spec = sprintf($format, abs($value));
		return $value > 0 ? $this->add(new \DateInterval($spec)) : $this->sub(new \DateInterval($spec));
	}

	private function modify($closure)
	{
		if(!is_callable($closure)) throw new \InvalidArgumentException(sprintf('Parameter for %s::modify() must be callable', get_class($this)));

		$datetime = clone $this->datetime;
		call_user_func($closure, $datetime);

		$obj = new DateTime();
		$obj->setDateTime($datetime);
		return $obj;
	}

	private function unitsOfTime(\DateInterval $interval, $detailLevel)
	{
		$units = array('y' => 'year', 'm' => 'month', 'd' => 'day',
			'h' => 'hour', 'i' => 'minute', 's' => 'second'
		);

		$diff = array();
		foreach($units as $format => $unit) {
			$amount = $interval->format('%' . $format);

			/** Adding support for weeks */
			if($unit == 'day' && $amount >= 7) {
				$weeks = floor($amount / 7);
				$amount -= $weeks * 7;
				$diff[] = array(
					'amount' => $weeks,
					'unit' => 'week'
				);

				$detailLevel--;
			}

			/** Save only non-zero units of time */
			if($amount > 0 && $detailLevel > 0) {
				$diff[] = array(
					'amount' => $amount,
					'unit' => $unit
				);

				$detailLevel--;
			}

			if($detailLevel === 0) {
				break;
			}
		}

		return $diff;
	}

	private function parseUnitsOfTime($units, $allowAlmost)
	{
		$isAlmost = false;
		$string = array();
		foreach($units as $time) {
			if($allowAlmost) {
				$isAlmost = $this->isAlmost($time);
			}

			if($time['amount'] > 1) {
				$time['unit'] .= 's';
			}
			$string[] = implode(' ', $time);
		}

		$parsed = $string[0];
		if(count($string) > 1) {
			$theLastOne = $string[count($string) - 1];
			unset($string[count($string) - 1]);

			$parsed = sprintf('%s and %s', implode(', ', $string), $theLastOne);
		}

		if($isAlmost) {
			$parsed = sprintf('almost %s', $parsed);
		}

		return $parsed;
	}

	private function isAlmost(&$time)
	{
		$units = array('second'	=> 60, 'minute'	=> 60, 'hour' => 24,
			'day' => 7, 'week' => 4.35, 'month'	=> 12, 'year' => null
		);

		$current = null;
		while(key($units)) {
			if(key($units) === $time['unit']) {
				$current = current($units);
				next($units);
				break;
			}
			next($units);
		}

		if($current && $current < $time['amount'] * 1.2) {
			$time = array(
				'amount' => 1,
				'unit' => key($units)
			);
			return true;
		}

		return false;
	}
}
