<?php
/**
* Basic Calendar data and display
*
* @author Oscar Merida
* @created Jan 18 2004
* @package  goCoreLib
*/
class Calendar {

var $year;
var $month;
var $monthNameFull;
var $monthNameBrief;
var $startDay;
var $endDay;  
/**
* Constructor
*
* @param integer, year
* @param integer, month
* @return object
* @public
*/
function Calendar ( $yr, $mo )
{
    $this->year    = $yr;
    $this->month   = (int) $mo;
    
    $this->startTime = strtotime( "$yr-$mo-01 00:00" );
    
    $this->endDay = date( 't', $this->startTime );
    
    $this->endTime   = strtotime( "$yr-$mo-".$this->endDay." 23:59" );
     
    $this->startDay    = date( 'D', $this->startTime );
	
    $this->startOffset = date( 'w', $this->startTime ) - 1;
    
    if ( $this->startOffset < 0 )
    {
        $this->startOffset = 6;
    }
    
    $this->monthNameFull = strftime( '%B', $this->startTime );
    $this->monthNameBrief= strftime( '%b', $this->startTime );
    
    $this->dayNameFmt = '%a';
    $this->tblWidth="*";
}
// ==== end Calendar ================================================

function getStartTime()
{
    return $this->startTime;
}

function getEndTime()
{
    return $this->endTime;
}

function getYear()
{
    return $this->year;
}

function getFullMonthName()
{
    return $this->monthNameFull;
}

function getBriefMonthName()
{
    return $this->monthNameBrief;
}

function setTableWidth( $w )
{
    $this->tblWidth = $w;
}

function setYear( $year )
{
    $this->year = $year;
}

function setMonth( $month )
{
    $this->month = $month;
}
/**
* Any valid strftime format for display weekday names
*
* %a - abbreviated, %A - full, %u as number with 1==Monday
*/
function setDayNameFormat( $f )
{
    $this->dayNameFmt = $f;
}
/**
* Returns markup for displaying the calendar.
*
* @return
* @public
*/
function display ( )
{
    ob_start();
?>
        <?php echo $this->dspDayNames()?>
        <?php echo $this->dspDayCells()?>
<?php
    $c = ob_get_contents();
    ob_end_clean();
    return $c;
}
// ==== end display ================================================
/**
* Displays the row of day names.
*
* @return string
* @private
*/
function dspDayNames ( )
{
//    ob_start();
//    echo '<tr>';
//    echo '  <th>Dilluns</th><th>Dimarts</th><th>Dimecres</th><th>Dijous</th><th>Divendres</th><th>Dissabte</th><th>Diumenge</th>';
//    echo '</tr>';
//    $c = ob_get_contents();
//    ob_end_clean();
//    return $c;
    return '';
}
// ==== end dspDayNames ================================================

/**
* Displays all day cells for the month
*
* @return string
* @private
*/
function dspDayCells ( )
{
    $i = 0; // cell counter
    ob_start();
?>
        <tr>
<?php

    // first display empty cells based on what weekday the month starts in]
    for( $c=0; $c<$this->startOffset; $c++ )
    {
        $i++;
?>
        <td class="notInMonth">&nbsp;</td>
<?php
    } // end offset cells

    // write out the rest of the days, at each sunday, start a new row.
    for( $d=1; $d<=$this->endDay; $d++ )
    {
        $i++;
?>
        <?php echo $this->dspDayCell( $d );?>
<?php
        if ( $i%7 == 0 )
        { ?>
        </tr>
<?php   }

        if ( $d<$this->endDay && $i%7 == 0 )
        {
?>      <tr>
<?php   }
    }

    // fill in the final row
    $left = 7 - ( $i%7 );

    if ( $left < 7)  
    {
        for ( $c=0; $c<$left; $c++ )
        {
          echo '<td class="notInMonth">&nbsp;</td>';
        }
        echo "\n\t</tr>";
    }

    $c = ob_get_contents();
    ob_end_clean();
    return $c;
}

// ==== end dspDayCells ================================================


/**
* outputs the contents for a given day
*
* @param integer, day
* @abstract
*/
function dspDayCell ( $day )
{
    return '<td>'.$day.'</td>';
}
// ==== end dayCell ================================================    
 } // end class
?>

