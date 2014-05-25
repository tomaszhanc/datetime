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
 * @property-read  string   $daysinmonth   t - Number of days in the given month.
 * @property-read  string   $dayofweek     N - ISO-8601 numeric representation of the day of the week.
 * @property-read  string   $dayofyear     z - The day of the year (starting from 0).
 * @property-read  boolean  $isleapyear    L - Whether it's a leap year.
 * @property-read  string   $day           d - Day of the month, 2 digits with leading zeros.
 * @property-read  string   $hour          H - 24-hour format of an hour with leading zeros.
 * @property-read  string   $minute        i - Minutes with leading zeros.
 * @property-read  string   $second        s - Seconds with leading zeros.
 * @property-read  string   $month         m - Numeric representation of a month, with leading zeros.
 * @property-read  string   $ordinal       S - English ordinal suffix for the day of the month, 2 characters.
 * @property-read  string   $week          W - Numeric representation of the day of the week.
 * @property-read  string   $year          Y - A full numeric representation of a year, 4 digits.
 *
 * @since  1.0
 */
class DateTime
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
	 * Magic method to access properties of the date given by class to the format method.
	 *
	 * @param   string  $name
	 *
	 * @return  mixed
	 */
	public function __get($name)
	{
		$value = null;

		switch ($name)
		{
			case 'daysinmonth':
				$value = $this->datetime->format('t');
				break;

			case 'dayofweek':
				$value = $this->datetime->format('N');
				break;

			case 'dayofyear':
				$value = $this->datetime->format('z');
				break;

			case 'isleapyear':
				$value = (boolean) $this->datetime->format('L');
				break;

			case 'day':
				$value = $this->datetime->format('d');
				break;

			case 'hour':
				$value = $this->datetime->format('H');
				break;

			case 'minute':
				$value = $this->datetime->format('i');
				break;

			case 'second':
				$value = $this->datetime->format('s');
				break;

			case 'month':
				$value = $this->datetime->format('m');
				break;

			case 'ordinal':
				$value = $this->datetime->format('S');
				break;

			case 'week':
				$value = $this->datetime->format('W');
				break;

			case 'year':
				$value = $this->datetime->format('Y');
				break;

			default:
				$trace = debug_backtrace();
				trigger_error(
					'Undefined property via __get(): ' . $name . ' in ' . $trace[0]['file'] . ' on line ' . $trace[0]['line'],
					E_USER_NOTICE
				);
		}

		return $value;
	}
}
