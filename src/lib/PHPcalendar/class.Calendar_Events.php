<?php
/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
*/
require_once( dirname(__FILE__).'/class.Calendar.php' );
/**
* Displays events in a given month.
*
* @author Oscar Merida <oscarAtoscarm.org>
* @created Jan 18 2004
* @package  goCoreLib
*/
class Calendar_Events extends Calendar {
  var $events = array();
  var $thisMonth = false;
  var $today;

  function Calendar_Events ($year, $month) {
    parent::Calendar($year, $month);
    $date = getdate();
    if ($date['mon'] == $month && $date['year'] == $year) {
      $this->thisMonth = true;
      $this->today = $date['mday'];
    }

  }

  function dspDayCell ( $day ) {
    $event = $this->getDaysEvents($day);
    if ($this->thisMonth && $day == $this->today) {
      if ($event) {
        echo '<td class="todayEvent">';
        echo '<a href="'.$event .'">'.$day.'</a>';
        echo '</td>';
      }
      else {
        echo '<td class="today">'.$day.'</td>';
      }
    }
    else if ($event) {
      echo '<td class="eventDay">';
      echo '<a href="'.$event .'">'.$day.'</a>';
      echo '</td>';
    } else {
      echo '<td>'.$day.'</td>';
    } // end if
  }

  /**
  * Adds an event on a day
  *
  * @return
  * @public
  */
  function addEvent($day, $link='') {
    $this->events[(int)$day] = $link;
  }
  // ==== end addEvent ================================================

  /**
  * Returns an array of the events on a day.
  *
  * @return
  * @public
  */
  function getDaysEvents($day) {
    if (isset($this->events[$day])) {
      return $this->events[ $day ];
    }
    else {
      return false;
    }
  }
  // ==== end getDaysEvents ================================================

} // end class
?>