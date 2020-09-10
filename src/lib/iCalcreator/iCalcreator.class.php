<?php
/*********************************************************************************/
/**
 * iCalcreator class v0.9.9
 * originally (c) Kjell-Inge Gustafsson
 * www.kigkonsult.se/iCalcreator/index.php
 * ical@kigkonsult.se
 *
 * Description:
 * This file is a PHP implementation of RFC 2445.
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 */
/*********************************************************************************/

/*********************************************************************************/
/*         A little setup                                                        */
/*********************************************************************************/
            // your local language code
// define( 'ICAL_LANG', 'sv' );
            // alt. autosetting
/*
$langstr     = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
$pos         = strpos( $langstr, ';' );
if ($pos   !== false) {
  $langstr   = substr( $langstr, 0, $pos );
  $pos       = strpos( $langstr, ',' );
  if ($pos !== false) {
    $pos     = strpos( $langstr, ',' );
    $langstr = substr( $langstr, 0, $pos );
  }
  define( 'ICAL_LANG', $langstr );
}
*/
            // version string, do NOT remove!!
define( 'ICALCREATOR_VERSION', 'iCalcreator 0.9.9' );

/*********************************************************************************/
/*********************************************************************************/
/**
 * vcalendar class
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.9.8 - 2006-11-27
 */
class vcalendar {

  var $calscale;
  var $method;
  var $prodid;
  var $version;
  var $xprop;

  var $format;
  var $attributeDelimiter;
  var $valueInit;
  var $xcaldecl;
/**
 *  container for calendar components
 */
  var $components;

  var $unique_id;
  var $language;
  var $directory;
  var $filename;
  var $delimiter;

  var $nl;

/*
 * constructor for calendar object
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.9.7 - 2006-11-20
 * @return void
 */
  function vcalendar () {

    $this->_makeVersion();
    $this->calscale   = null;
    $this->method     = null;
    $this->_makeUnique_id();
    $this->prodid     = null;
    $this->xprop      = array();
/**
 *   language = <Text identifying a language, as defined in [RFC 1766]>
 */
    if( defined( 'ICAL_LANG' ))
      $this->setLanguage( ICAL_LANG );

    $this->nl         = "\n";

    $this->format     = null;
    $this->attributeDelimiter = ';';
    $this->valueInit  = ':';
    $this->xcaldecl   = array();
    $this->components = array();

    $this->directory  = null;
    $this->filename   = null;
    $this->delimiter  = null;
  }
/*********************************************************************************/
/**
 * Property Name: CALSCALE
 */
/**
 * creates formatted output for calendar property calscale
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.9.7 - 2006-11-20
 * @return string
 */
  function createCalscale( ) {
    if( !isset( $this->calscale ))
      return;
    switch( $this->format ) {
      case 'xcal':
        return ' calscale="'.$this->calscale.'"'.$this->nl;
        break;
      default:
        return 'CALSCALE:'.$this->calscale.$this->nl;
        break;
    }
  }
/**
 * set calendar property calscale
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.3.0 - 2006-08-13
 * @param string $value
 * @return void
 */
  function setCalscale( $value ) {
    $this->calscale = $value;
  }
/*********************************************************************************/
/**
 * Property Name: METHOD
 */
/**
 * creates formatted output for calendar property method
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.9.7 - 2006-11-20
 * @return string
 */
  function createMethod( ) {
    if( !isset( $this->method ))
      return;
    switch( $this->format ) {
      case 'xcal':
        return ' method="'.$this->method.'"'.$this->nl;
        break;
      default:
        return 'METHOD:'.$this->method.$this->nl;
        break;
    }
  }
/**
 * set calendar property method
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.3.0 - 2006-08-13
 * @param string $method
 * @return void
 */
  function setMethod( $method ) {
    $this->method = $method;
  }

/*********************************************************************************/
/**
 * Property Name: PRODID
 *
 *  The identifier is RECOMMENDED to be the identical syntax to the
 * [RFC 822] addr-spec. A good method to assure uniqueness is to put the
 * domain name or a domain literal IP address of the host on which.. .
 */
/**
 * creates formatted output for calendar property prodid
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.9.7 - 2006-11-20
 * @return string
 */
  function createProdid( ) {
    if( !isset( $this->prodid ))
      $this->_makeProdid();
    switch( $this->format ) {
      case 'xcal':
        return ' prodid="'.$this->prodid.'"'.$this->nl;
        break;
      default:
        return 'PRODID:'.$this->prodid.$this->nl;
        break;
    }
  }
/**
 * make default value for calendar prodid
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.3.0 - 2006-08-10
 * @return void
 */
  function _makeProdid() {
    $this->prodid  = '-//'.$this->unique_id.'//NONSGML '.ICALCREATOR_VERSION.'//'.strtoupper( $this->language );
  }
/**
 * make default unique_id for calendar prodid
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.3.0 - 2006-08-10
 * @return void
 */
  function _makeUnique_id() {
    $this->unique_id  = gethostbyname( $_SERVER['SERVER_NAME'] );
  }

/**
 * Conformance: The property MUST be specified once in an iCalendar object.
 * Description: The vendor of the implementation SHOULD assure that this
 * is a globally unique identifier; using some technique such as an FPI
 * value, as defined in [ISO 9070].
 */
/**
 * set unique_id
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.3.0 - 2006-08-10
 * @param string @unique_id
 * @return void
 */
  function setUnique_id( $unique_id ) {
    $this->unique_id = $unique_id;
  }

/*********************************************************************************/
/**
 * Property Name: VERSION
 *
 * Description: A value of "2.0" corresponds to this memo.
 */
/**
 * creates formatted output for calendar property version
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.9.7 - 2006-11-20
 * @return string
 */
  function createVersion( ) {
    if( !isset( $this->version ))
      $this->_makeVersion();
    switch( $this->format ) {
      case 'xcal':
        return ' version="'.$this->version.'"'.$this->nl;
        break;
      default:
        return 'VERSION:'.$this->version.$this->nl;
        break;
    }
  }
/**
 * set default calendar version
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.3.0 - 2006-08-10
 * @return void
 */
  function _makeVersion() {
    $this->version = '2.0';
  }
/**
 * set calendar version
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.3.0 - 2006-08-10
 * @param string version
 * @return void
 */
  function setVersion( $version ) {
    $this->version = $version;
  }

/*********************************************************************************/
/**
 * Property Name: x-prop
 */
/**
 * creates formatted output for calendar property x-prop, iCal format only
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.9.8 - 2006-11-27
 * @return string
 */
  function createXprop( ) {
    if( 'xcal' == $this->format )
      return false;
    $cnt = count( $this->xprop );
    if( 0 >= $cnt )
      return;
    $xprop = null;
    foreach( $this->xprop as $xpropPart ) {
     $attributes = $attributesLANG = null;
     foreach( $xpropPart['value'] as $label => $value )
      if( isset( $xpropPart['params'] )) {
        foreach( $xpropPart['params'] as $paramKey => $paramValue) {
          if( is_int( $paramKey ))
            $attributes .= $this->attributeDelimiter.$paramValue;
          elseif( 'LANGUAGE' != $paramKey )
            $attributes .= $this->attributeDelimiter."$paramKey=$paramValue";
          else
            $attributesLANG = $this->attributeDelimiter."LANGUAGE=$paramValue";
        }
      }
      if( $this->getLanguage() && !isset( $attributesLANG ))
        $attributesLANG = $this->attributeDelimiter.'LANGUAGE='.$this->getLanguage();
      $xprop .= calendarComponent::_size75( strtoupper( $label ).$attributes.$attributesLANG.$this->valueInit.$value );
    }
    return $xprop;
  }
/**
 * set calendar property x-prop
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.7.58 - 2006-09-15
 * @param string $label
 * @param string $value
 * @param array $params optional
 * @return void
 */
  function setXprop( $label, $value, $params=FALSE ) {
    $xprop['value'] = array( $label => $value);
    if( empty( $xprop['value'] ))
      return;
    if( is_array( $params )) {
      foreach( $params as $paramKey => $paramValue )
        $xprop['params'][strtoupper( $paramKey )] = $paramValue;
    }
    $this->xprop[] = $xprop;
  }

/*********************************************************************************/
/**
 * get language for calendar as defined in [RFC 1766]
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.7.36 - 2006-09-14
 * @return string
 */
  function getLanguage( ) {
    if( !isset( $this->language ))
      return null;
    else
      return $this->language;
  }
/**
 * set language for calendar as defined in [RFC 1766]
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.7.36 - 2006-09-14
 * @param string $value language
 * @return void
 */
  function setLanguage( $value ) {
    $this->language = $value;
  }
/*********************************************************************************/
/**
 * get format for calendar
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.9.7 - 2006-11-20
 * @return string
 */
  function getFormat( ) {
    if( !isset( $this->format ))
      return null;
    else
      return $this->format;
  }
/**
 * set format for calendar
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.9.7 - 2006-11-20
 * @param string $value format (default ical, opt xcal)
 * @return void
 */
  function setFormat( $value ) {
    if( 'xcal' == strtolower( $value )) {
      $this->format = 'xcal';
      $this->attributeDelimiter = $this->nl;
      $this->valueInit  = null;;
    }
    else {
      $this->format = null;
      $this->attributeDelimiter = ';';
      $this->valueInit  = ':';
    }
  }
/*********************************************************************************/
/**
 * get character(-s) for newline / carriage return
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.9.1 - 2006-11-15
 * @return string
 */
  function getNewlineChar( ) {
    return $this->nl;
  }
/**
 * set character(-s) for new line / carriage return
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.7.8 - 2006-09-10
 * @param string $value
 * @return void
 */
  function setNewlineChar( $value ) {
    $this->nl = $value;
  }
/*********************************************************************************/
/**
 * validDate
 *
 * convert input parameters to (valid) iCalcreator date in array format (or FALSE)
 * if $utc=TRUE and $tz = utc offset ([[+/]-]HHmm) input (local) date array + UTC offset
 * returns ouput in UTC format date
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.9.8 - 2006-11-27
 * @param mixed $year
 * @param mixed $month optional
 * @param int $day optional
 * @param int $hour optional
 * @param int $min optional
 * @param int $sec optional
 * @param mixed $tz optional
 * @param bool $utc optional
 * @return bool false / array $date
 */
  function validDate( $year, $month=FALSE, $day=FALSE, $hour=FALSE, $min=FALSE, $sec=FALSE, $tz=FALSE, $utc=FALSE ) {
    $input = array();
    if( is_int( $year ) && is_int( $month ) && is_int( $day )) {
      $input['year']   = $year;
      $input['month']  = $month;
      $input['day']    = $day;
      if(( $hour !== FALSE ) || ( $min !== FALSE ) || ( $sec !== FALSE )) {
        $parno = 6;
        if( $hour !== FALSE )
          $input['hour'] = $hour;
        if( $min !== FALSE )
          $input['min']  = $min;
        if( $sec !== FALSE )
          $input['sec']  = $sec;
      }
      if( $tz !== FALSE ) {
        $parno = 7;
        $input['tz']  = $tz;
      }
      else
        $parno = 3;
      $input = calendarComponent::_date_time_array( $input, $parno );
    }
    elseif( is_array( $year ) && isset( $year['timestamp'] )) {
      $input        = calendarComponent::_date_time_string( date( 'Y-m-d H:i:s', $year['timestamp'] ), 6 );
      $input['tz']  = ( isset( $year['tz'] )) ? $year['tz'] : null;
      $utc = ( TRUE === $month ) ? TRUE : FALSE;
    }
    elseif( is_array( $year ) && ( in_array( count( $year ), array( 3, 4, 6, 7 )))) {
      if( isset( $year['tz'] ) || ( 4 == count( $year )) || ( 7 == count( $year )))
        $parno = 7;
      elseif( isset( $year['hour'] ) || isset( $year['min'] ) || isset( $year['sec'] ) ||
            ( 6 == count( $year )))
        $parno = 6;
      else
        $parno = 3;
      $input = calendarComponent::_date_time_array( $year, $parno );
      $utc = ( TRUE === $month ) ? TRUE : FALSE;
    }
    elseif( 8 <= strlen( trim( $year ))) { // ex. 2006-08-03 10:12:18
      $input = calendarComponent::_date_time_string( $year );
      $utc = ( TRUE === $month ) ? TRUE : FALSE;
    }
    else
      return FALSE;

    if( !checkdate ( $input['month'], $input['day'], $input['year'] ))
      return FALSE;
    if( isset( $input['hour'] ) &&
        (( 0 > $input['hour'] ) || ( 23 < $input['hour'] )))
      return FALSE;
    if( isset( $input['min'] ) &&
        (( 0 > $input['min'] ) || ( 59 < $input['min'] )))
      return FALSE;
    if( isset( $input['sec'] ) &&
        (( 0 > $input['sec'] ) || ( 59 < $input['sec'] )))
      return FALSE;
    if( $utc && isset( $input['tz'] ) && ( '' < trim ( $input['tz'] ))) {
      $input['tz'] = trim( $input['tz'] );
      if( 'Z' != $input['tz'] ) {
        $offset = 0;
        if((      5 == strlen( $input['tz'] )) &&
           ( '0000' <= substr( $input['tz'], -4 )) &&
           ( '9999' >= substr( $input['tz'], -4 )) &&
             (( '+' == substr( $input['tz'], 0, 1 )) ||
              ( '-' == substr( $input['tz'], 0, 1 )))) {
          $hours2sec = substr( $input['tz'], 1, 2 ) * 3600;
          $min2sec   = substr( $input['tz'], -2 )   *   60;
          $sign      = substr( $input['tz'], 0, 1 );
          $offset    = -1 * ($sign.'1' * ( $hours2sec + $min2sec ));
        }
        elseif(( 7  == strlen( $input['tz'] )) &&
         ( '000000' <= substr( $input['tz'], -6 )) &&
         ( '999999' >= substr( $input['tz'], -6 )) &&
             (( '+' == substr( $input['tz'], 0, 1 )) ||
              ( '-' == substr( $input['tz'], 0, 1 )))) {
          $hours2sec = substr( $input['tz'], 1, 2 ) * 3600;
          $min2sec   = substr( $input['tz'], 3, 2 ) *   60;
          $sec       = substr( $input['tz'], -2 );
          $sign      = substr( $input['tz'], 0, 1 );
          $offset    = -1 * ($sign.'1' * ( $hours2sec + $min2sec + $sec ));
        }
        if( 0 != $offset) {
          if( !isset( $input['hour'] ))
            $input['hour'] = 0;
          if( !isset( $input['min'] ))
            $input['min'] = 0;
          if( !isset( $input['sec'] ))
            $input['sec'] = 0;
          $input = date('Y-m-d H:i:s\Z', mktime ( $input['hour']
                                                , $input['min']
                                                , $input['sec'] + $offset
                                                , $input['month']
                                                , $input['day']
                                                , $input['year']));
          $input = calendarComponent::_date_time_string( $input, 7 );
        }
      }
    }
    return $input;
}
/*********************************************************************************/
/**
 * add calendar component to container
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.7.36 - 2006-09-20
 * @param object $component calendar component
 * @return void
 */
  function addComponent ( $component ) {
    $this->components[] = $component;
  }

/**
 * append formatted output for calendar object instance to existing calendar file
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.9.7 - 2006-11-20
 * @param string $directory optional
 * @param string $filename optional
 * @param string $delimiter optional
 * @return bool/array, FALSE if not found/not writeable input file
 */
  function appendCalendar ( $directory=FALSE, $filename=FALSE, $delimiter='/' ) {
    if( 'xcal' == $this->format )
      return false;
    $this->setFilename( $directory, $filename, $delimiter );
    $dirfile = $this->directory.$this->delimiter.$this->filename;

    clearstatcache( );
    if( !file_exists( $dirfile ) || !is_writable ( $dirfile ))
      return FALSE;

    $lines = file( $dirfile );
    foreach ($lines as $line_num => $line) {
      if( 0 == $line_num ) {
        unset( $lines[$line_num] );
        continue;
      }
      if( 'VERSION' == strtoupper( substr( $line, 0, 7 ))) {
        unset( $lines[$line_num] );
        continue;
      }
      if( 'PRODID' == strtoupper( substr( $line, 0, 6 ))) {
        unset( $lines[$line_num] );
        continue;
      }
      if( 'CALSCALE' == strtoupper( substr( $line, 0, 8 ))) {
        $line = str_replace( 'CALSCALE:', '', trim(strtoupper( $line )));
        $this->setCalscale( $line );
        unset( $lines[$line_num] );
        continue;
      }
      if( 'METHOD' == strtoupper( substr( $line, 0, 6 ))) {
        $line = str_replace( 'METHOD:', '', trim(strtoupper( $line )));
        $this->setMethod( $line );
        unset( $lines[$line_num] );
        continue;
      }
      if( 'BEGIN:' == strtoupper( substr( $line, 0, 6 )))
        break;
      if( 'END:VCALENDAR' == strtoupper( substr( $line, 0, 13 ))) {
        unset( $lines[$line_num] );
        break;
      }
    }
    if( FALSE === ( $fp = fopen ( $dirfile, "w" )))
      return FALSE;

    $content = 'BEGIN:VCALENDAR'.$this->nl;
    $line_num = 0;
    if( !fwrite( $fp, $content )) {
      print "Cannot write (line $line_num) to file ( $dirfile ) and content '$content'";
      exit;
    }
    $content = $this->createCalscale();
    if( $content ) {
      $line_num++;
      if( !fwrite( $fp, $content )) {
        print "Cannot write (line $line_num) to file ( $dirfile ) and content '$content'";
        exit;
      }
    }
    $content = $this->createMethod();
    if( $content ) {
      $line_num++;
      if( !fwrite( $fp, $content )) {
        print "Cannot write (line $line_num) to file ( $dirfile ) and content '$content'";
        exit;
      }
    }
    $content = $this->createProdid();
    $line_num++;
    if( !fwrite( $fp, $content )) {
      print "Cannot write (line $line_num) to file ( $dirfile ) and content '$content'";
      exit;
    }
    $content = $this->createVersion();
    $line_num++;
    if( !fwrite( $fp, $content )) {
      print "Cannot write (line $line_num) to file ( $dirfile ) and content '$content'";
      exit;
    }
    $content = $this->createXprop();
    if( $content ) {
      $line_num++;
      if( !fwrite( $fp, $content )) {
        print "Cannot write (line $line_num) to file ( $dirfile ) and content '$content'";
        exit;
      }
    }

    foreach ($lines as $line_num => $line) {
      if( 'END:VCALENDAR' == strtoupper( substr( $line, 0, 13 )))
        continue;
      $line_num++;
      if( !fwrite( $fp, $line )) {
        print "Cannot write (line $line_num) to file ( $dirfile ) and content '$line'";
        exit;
      }
    }
    $content = null;
    foreach( $this->components as $component ) {
      if( !$component->getLanguage() )
        $component->setLanguage( $this->getLanguage() );
      if( !isset( $component->nl ))
        $component->nl        = $this->nl;
      if( !isset( $component->unique_id ))
        $component->setUnique_id( $this->unique_id );
       $content .= $component->createComponent( $this->xcaldecl );
    }
    if( !fwrite( $fp, $content )) {
      print "Cannot write new content to file ( $dirfile )";
      exit;
    }
    $content = 'END:VCALENDAR'.$this->nl;
    if( !fwrite( $fp, $content )) {
      print "Cannot write last row to file ( $dirfile )";
      exit;
    }
    fclose($fp);

    clearstatcache( );
    $lines = file( $dirfile );

    $filesize = filesize( $dirfile );
    return array( $this->directory, $this->filename, $filesize );
  }

/**
 * creates formatted output for calendar object instance
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.9.7 - 2006-11-20
 * @return string
 */
  function createCalendar( ) {
    $calendarInit1 = $calendarInit2 = $calendarxCaldecl = $calendarStart = $calendar = null;
    switch( $this->format ) {
      case 'xcal':
        $calendarInit1 = '<?xml version="1.0" encoding="UTF-8"?>'.$this->nl.
                         '<!DOCTYPE iCalendar PUBLIC "-//IETF//DTD XCAL/iCalendar XML//EN"'.$this->nl.
                         '"http://www.ietf.org/internet-drafts/draft-ietf-calsch-many-xcal-01.txt"';
        $calendarInit2 = '>'.$this->nl;
        $calendarStart = '<vcalendar';
        break;
      default:
        $calendarStart = 'BEGIN:VCALENDAR'.$this->nl;
        break;
    }
    $calendarStart .= $this->createCalscale();
    $calendarStart .= $this->createMethod();
    $calendarStart .= $this->createProdid();
    $calendarStart .= $this->createVersion();
    switch( $this->format ) {
      case 'xcal':
        $nlstrlen = strlen( $this->nl );
        if( $this->nl == substr( $calendarStart, ( 0 - $nlstrlen )))
          $calendarStart = substr( $calendarStart, 0, ( strlen( $calendarStart ) - $nlstrlen ));
        $calendarStart .= '>'.$this->nl;
        break;
      default:
        break;
    }
    $calendar .= $this->createXprop();

    foreach( $this->components as $component ) {
      if( !$component->getLanguage() )
        $component->setLanguage( $this->getLanguage() );
      if( !isset( $component->nl ))
        $component->nl   = $this->nl;
      if( !isset( $component->unique_id ))
        $component->setUnique_id( $this->unique_id );
      $component->format = $this->format;

      $calendar .= $component->createComponent( $this->xcaldecl );
    }

    if(( 0 < count( $this->xcaldecl )) && ( 'xcal' == $this->format )) { // xCal only
      $calendarInit1 .= '[ '.$this->nl;
      foreach( $this->xcaldecl as $declPart ) {
        $calendarxCaldecl .= '<!';
        foreach( $declPart as $declKey => $declValue ) {
          switch( $declKey ) {                    // index
            case 'xmldecl':                       // no 1
            case 'uri':                           // no 2
            case 'ref':                           // no 3
            case 'type':                          // no 5
              $calendarxCaldecl .= $declValue.' ';
              break;
            case 'external':                      // no 4
              $calendarxCaldecl .= '"'.$declValue.'" ';
              break;
            case 'type2':                         // no 6
              $calendarxCaldecl .= $declValue;
              break;
          }
        }
        $calendarxCaldecl .= '>'.$this->nl;
      }
      $calendarInit2 = ']'.$calendarInit2;
    }
    switch( $this->format ) {
      case 'xcal':
        $calendar .= '</vcalendar>'.$this->nl;
        break;
      default:
        $calendar .= 'END:VCALENDAR'.$this->nl;
        break;
    }

    return $calendarInit1.$calendarxCaldecl.$calendarInit2.$calendarStart.$calendar;
  }

/**
 * get filename
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.7.10 - 2006-09-11
 * @return array
 *
 */
  function getFilename() {
    if( !$this->filename )
      $this->setFilename( $this->directory, $this->_makeFilename() );
    $dirfile = $this->directory.$this->delimiter.$this->filename;
    $filesize = filesize( $dirfile );
    return array( $this->directory, $this->filename, $filesize );
  }
/**
 * make filename
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.9.7 - 2006-11-20
 * @return void
 *
 */
  function _makeFilename() {
    if( 'xcal' == $this->format )
      $this->filename = date( 'YmdHis' ).'.xml'; // recommended xcs.. .
    else
      $this->filename = date( 'YmdHis' ).'.ics';
  }

/**
 * redirect file to user
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.9.7 - 2006-11-20
 * @param string $directory optional
 * @param string $filename optional
 * @param string $delimiter optional
 * @return redirect
 */
  function _redirectCalendar( $directory=FALSE, $filename=FALSE, $delimiter='/' ) {
    if( $directory || $filename )
      $this->setFilename( $directory, $filename, $delimiter );
    elseif( !$this->filename )
      $this->setFilename();
    $dirfile = $this->directory.$this->delimiter.$this->filename;
    if( 'xcal' == $this->format )
      Header( 'Content-Type: application/calendar+xml; charset=utf-8' );
    else
      Header( 'Content-Type: text/calendar; charset=utf-8' );
    Header( 'Content-Disposition: attachment; filename='.basename( $dirfile ));
    readfile( $dirfile, 'r' );

    die();
  }
/**
 * an HTTP redirect header is sent with saved calendar
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.8.20 - 2006-11-03
 * @param string $directory optional
 * @param string $filename optional
 * @param string $delimiter optional
 * @return redirect
 */
  function returnCalendar( $directory=FALSE, $filename=FALSE, $delimiter='/' ) {
    if( $this->saveCalendar ( $directory, $filename, $delimiter ))
      $this->_redirectCalendar ( $directory, $filename, $delimiter );
  }

/**
 * save content in a file
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.7.10 - 2006-09-11
 * @param string $directory optional
 * @param string $filename optional
 * @param string $delimiter optional
 * @return array
 */
  function saveCalendar( $directory=FALSE, $filename=FALSE, $delimiter='/' ) {
    if( $directory || $filename )
      $this->setFilename( $directory, $filename, $delimiter );
    elseif( !$this->filename )
      $this->setFilename();

    $dirfile = $this->directory.$this->delimiter.$this->filename;

    $iCalFile = fopen( $dirfile, 'w+' );
    if ( $iCalFile ) {
      fputs( $iCalFile, $this->createCalendar() );
      fclose( $iCalFile );
      $filesize = filesize( $dirfile );
      return array( $this->directory, $this->filename, $filesize );
    }
    else
      return FALSE;
  }

/**
 * set filename
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.8.19 - 2006-11-03
 * @param string $directory optional
 * @param string $filename optional
 * @param string $delimiter optional
 * @return bool
 */
  function setFilename( $directory=FALSE, $filename=FALSE, $delimiter='/' ) {
    if( !empty( $directory ))
      $this->directory = $directory;
    else
      $this->directory = '.';
    $this->delimiter = $delimiter;
    if( $filename )
      $this->filename = $filename;
    else
      $this->_makeFilename();

    $dirfile = $this->directory.$this->delimiter.$this->filename;
    if( @touch( $dirfile ))
      return TRUE;
    else
      return FALSE;
  }

/**
 * if recent version of file exists (max one hour), an HTTP redirect header is sent
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.7.10 - 2006-09-11
 * @param string $directory optional
 * @param string $filename optional
 * @param string $delimiter optional
 * @param int timeout optional, default 3600
 * @return redirect
 */
  function useCachedCalendar( $directory, $filename, $delimiter='/', $timeout=3600) {
    $dirfile = $directory.$delimiter.$filename;
    if(( file_exists( $dirfile )) &&
       ( time() - filemtime( $dirfile ) < $timeout)) {
      $this->_redirectCalendar ( $directory, $filename, $delimiter );
    }
  }
}

/*********************************************************************************/
/*********************************************************************************/
/**
 *  abstract class for calendar components
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.9.8 - 2006-11-27
 */
class calendarComponent {
  var $action;
  var $attach;
  var $attendee;
  var $categories;
  var $comment;
  var $completed;
  var $contact;
  var $class;
  var $created;
  var $description;
  var $dtend;
  var $dtstart;
  var $dtstamp;
  var $due;
  var $duration;
  var $exdate;
  var $exrule;
  var $freebusy;
  var $geo;
  var $lastmodified;
  var $location;
  var $organizer;
  var $percentcomplete;
  var $priority;
  var $rdate;
  var $recurrenceid;
  var $relatedto;
  var $repeat;
  var $requeststatus;
  var $resources;
  var $rrule;
  var $sequence;
  var $status;
  var $summary;
  var $transp;
  var $trigger;
  var $tzid;
  var $tzname;
  var $tzoffsetfrom;
  var $tzoffsetto;
  var $tzurl;
  var $uid;
  var $url;
  var $xprop;

  var $subcomponents;

  var $language;
  var $nl;
  var $unique_id;

  var $format;
  var $objName;
  var $componentStart1;
  var $componentStart2;
  var $componentEnd1;
  var $componentEnd2;
  var $elementStart1;
  var $elementStart2;
  var $elementEnd1;
  var $elementEnd2;
  var $intAttrDelimiter;
  var $attributeDelimiter;
  var $valueInit;
  var $xcaldecl;

/**
 * constructor for calendar component object
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.8.5 - 2006-10-06
 */
  function calendarComponent() {
    $this->objName         = get_class ( $this );

    $this->action          = array();
    $this->attach          = array();
    $this->attendee        = array();
    $this->categories      = array();
    $this->class           = array();
    $this->comment         = array();
    $this->completed       = array();
    $this->contact         = array();
    $this->created         = array();
    $this->description     = array();
    $this->dtend           = array();
    $this->dtstart         = array();
    $this->dtstamp         = array();
    $this->due             = array();
    $this->duration        = array();
    $this->exdate          = array();
    $this->exrule          = array();
    $this->freebusy        = array();
    $this->geo             = array();
    $this->lastmodified    = array();
    $this->location        = array();
    $this->organizer       = array();
    $this->percentcomplete = array();
    $this->priority        = array();
    $this->rdate           = array();
    $this->recurrenceid    = array();
    $this->relatedto       = array();
    $this->repeat          = array();
    $this->requeststatus   = array();
    $this->resources       = array();
    $this->sequence        = array();
    $this->rrule           = array();
    $this->status          = array();
    $this->summary         = array();
    $this->transp          = array();
    $this->trigger         = array();
    $this->tzid            = array();
    $this->tzname          = array();
    $this->tzoffsetfrom    = array();
    $this->tzoffsetto      = array();
    $this->tzurl           = array();
    $this->uid             = array();
    $this->url             = array();
    $this->xprop           = array();

    $this->subcomponents   = array();

    $this->language        = null;
    $this->nl              = null;
    $this->unique_id       = null;
    $this->xcaldecl        = array();

    $this->_makeDtstamp();
  }

/*********************************************************************************/
/**
 * Property Name: ACTION
 */
/**
 * creates formatted output for calendar component property action
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.9.7 - 2006-11-20
 * @return string
 */
  function createAction( ) {
    if( !isset( $this->action['action'] ))
      return;
    $attributes = ( isset( $this->action['xparams'] )) ? $this->_createParams( $this->action['xparams'] ) : null;
    return $this->_createElement( 'ACTION', $attributes, $this->action['action'] );
  }
/**
 * set calendar component property action
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.9.2 - 2006-11-16
 * @param string $value  "AUDIO" / "DISPLAY" / "EMAIL" / "PROCEDURE"
 * @param mixed $xparam
 * @return void
 */
  function setAction( $value, $xparam=FALSE ) {
    $this->action['action'] = $value;
    if( is_array( $xparam )) {
      foreach( $xparam as $xparamKey => $xparamValue )
        $this->action['xparams'][strtoupper( $xparamKey )] = $xparamValue;
    }
  }

/*********************************************************************************/
/**
 * Property Name: ATTACH
 */
/**
 * creates formatted output for calendar component property attach
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.9.7 - 2006-11-20
 * @return string
 */
  function createAttach( ) {
    $cnt = count( $this->attach );
    if( 0 >= $cnt )
      return;
    $output    = null;
    foreach( $this->attach as $attachPart ) {
      $attributes = ( isset( $attachPart['params'] )) ? $this->_createParams( $attachPart['params'] ) : null;
      $output    .= $this->_createElement( 'ATTACH', $attributes, $attachPart['value'] );
    }
    return $output;
  }
/**
 * set calendar component property attach
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.9.6 - 2006-09-11
 * @param string $value
 * @param string $params
 * @return void
 */
  function setAttach( $value, $params=FALSE) {
    $attach = array();
    $attach['value'] = $value ;
    if( is_array( $params )) {
      foreach( $params as $paramKey => $paramValue )
        $attach['params'][strtoupper( $paramKey )] = $paramValue;
    }
    $this->attach[] = $attach;
  }

/*********************************************************************************/
/**
 * Property Name: ATTENDEE
 */
/**
 * creates formatted output for calendar component property attendee
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.9.7 - 2006-11-20
 * @return string
 */
  function createAttendee( ) {
    $cnt = count( $this->attendee );
    if( 0 >= $cnt )
      return;
    $attendees = null;
    foreach( $this->attendee as $attendeePart ) {                      // start foreach 1
      $attendee1 = $attendee2 = $attendeeLANG = $attendeeCN = null;
      $attendeeCUTYPE = $attendeeROLE = $attendeePARTSTAT = $attendeeRSVP = FALSE;
      foreach( $attendeePart as $paramlabel => $paramvalue ) {         // start foreach 2
        if( 'value' == $paramlabel ) {
          $attendee2  .= 'MAILTO:'.$paramvalue;
        }
        elseif(( 'optparam' == $paramlabel ) && ( is_array( $paramvalue ))) { // start elseif
          foreach( $paramvalue as $optparam ) {                        // start foreach 3
            foreach( $optparam as $optparamlabel => $optparamvalue ) { // start foreach 4
              $attendee11 = $attendee12 = null;
                // echo "$optparamlabel => $optparamvalue <br />\n"; // test
              if( is_int( $optparamlabel )) {
                $attendee1 .= $this->intAttrDelimiter.$optparamvalue;
                continue;
              }
              switch( $optparamlabel ) {                               // start switch
                case 'CUTYPE':
                  $attendee1 .= $this->intAttrDelimiter.'CUTYPE='.'"'.$optparamvalue.'"';
                  $attendeeCUTYPE = TRUE;
                  break;
                case 'PARTSTAT':
                  $attendee1 .= $this->intAttrDelimiter.'PARTSTAT='.'"'.$optparamvalue.'"';
                  $attendeePARTSTAT = TRUE;
                  break;
                case 'ROLE':
                  $attendee1 .= $this->intAttrDelimiter.'ROLE='.'"'.$optparamvalue.'"';
                  $attendeeROLE = TRUE;
                  break;
                case 'RSVP':
                  $attendee1 .= $this->intAttrDelimiter.'RSVP='.'"'.$optparamvalue.'"';
                  $attendeeRSVP = TRUE;
                  break;
                case 'SENT-BY':
                  $attendee1 .= $this->intAttrDelimiter.'SENT-BY='.'"'.$optparamvalue.'"'; break;
                case 'MEMBER':
                  $attendee11 = $this->intAttrDelimiter.'MEMBER=';
                case 'DELEGATED-TO':
                  $attendee11 = ( !$attendee11 ) ? $this->intAttrDelimiter.'DELEGATED-TO='   : $attendee11;
                case 'DELEGATED-FROM': {
                  $attendee11 = ( !$attendee11 ) ? $this->intAttrDelimiter.'DELEGATED-FROM=' : $attendee11;
                  foreach( $optparamvalue  as $cix => $calUserAddress ) {
                    $attendee12 .= ( $cix ) ? ',' : null;
                    $attendee12 .= '"MAILTO:'.$calUserAddress.'"';
                  }
                  $attendee1  .= $attendee11.$attendee12;
                  break;
                }
                case 'CN': {
                  $attendeeCN .= $this->intAttrDelimiter.'CN="'.$optparamvalue.'"';
                  break;
                }
                case 'DIR': {
                  $attendee1 .= $this->intAttrDelimiter.'DIR="'.$optparamvalue.'"';
                  break;
                }
                case 'LANGUAGE': {
                  $attendeeLANG .= $this->intAttrDelimiter.'LANGUAGE='.$optparamvalue;
                  break;
                }
                default: {
                  $attendee1 .= $this->intAttrDelimiter."$optparamlabel=$optparamvalue";
                  break;
                }
              }    // end switch
            }      // end foreach 4
          }        // end foreach 3
        }          // end elseif
      }            // end foreach 2
      if( !$attendeeCUTYPE )
        $attendee1 .= $this->intAttrDelimiter.'CUTYPE=INDIVIDUAL';
      if( !$attendeePARTSTAT )
        $attendee1 .= $this->intAttrDelimiter.'PARTSTAT=NEEDS-ACTION';
      if( !$attendeeROLE )
        $attendee1 .= $this->intAttrDelimiter.'ROLE=REQ-PARTICIPANT';
      if( !$attendeeRSVP )
        $attendee1 .= $this->intAttrDelimiter.'RSVP=FALSE';
      if( isset( $attendeeCN )) {
        if( !isset( $attendeeLANG ) && $this->getLanguage() )
          $attendeeLANG = $this->intAttrDelimiter.'LANGUAGE='.$this->getLanguage();
      }
      else
        $attendeeLANG = null;
      $attendees .= $this->_createElement( 'ATTENDEE', $attendee1.$attendeeLANG.$attendeeCN, $attendee2 );
    }              // end foreach 1
    return $attendees;
  }
/**
 * set calendar component property attach
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.7.14 - 2006-09-12
 * @param string $value
 * @param array $optparam optional
 * @return void
 */
  function setAttendee( $value, $optparam=FALSE ) {
    $attendee = array( 'value' => $value );
    if( is_array($optparam )) {
      foreach( $optparam as $optparamlabel => $optparamvalue )
        $attendee['optparam'][] = array( strtoupper( $optparamlabel ) => $optparamvalue );
    }
    $this->attendee[] = $attendee;
  }

/*********************************************************************************/
/**
 * Property Name: CATEGORIES
 */
/**
 * creates formatted output for calendar component property categories
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.9.7 - 2006-11-20
 * @return string
 */
  function createCategories( ) {
    $cnt = count( $this->categories );
    if( 0 >= $cnt )
      return;
    $params     = ( isset( $this->categories['param'] )) ? $this->categories['param'] : FALSE;
    $attributes = $this->_createParams( $params, array( 'LANGUAGE' ));
    $content = null;
    foreach( $this->categories['value'] as $catix => $catValue ) {
      if( 0 < $catix )
        $content .= ',';
      $content .= $catValue;
    }
    while( 0 < ( substr_count($content, ', ') + substr_count($content, ', '))) {
      $content = str_replace( ', ', ',', $content );
      $content = str_replace( ' ,', ',', $content );
    }
    return $this->_createElement( 'CATEGORIES', $attributes, $content );
  }
/**
 * set calendar component property categories
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.7.15 - 2006-09-12
 * @param string $value
 * @param array $params optional
 * @return void
 */
  function setCategories( $value, $params=FALSE ) {
    $this->categories['value'][] = $value;
    if( is_array( $params )) {
      foreach( $params as $paramKey => $paramValue )
        $this->categories['param'][strtoupper( $paramKey )] = $paramValue;
    }
  }


/*********************************************************************************/
/**
 * Property Name: CLASS
 */
/**
 * creates formatted output for calendar component property class
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.9.7 - 2006-11-20
 * @return string
 */
  function createClass( ) {
    $cnt = count( $this->class );
    if( 0 >= $cnt )
      return;
    $attributes = ( isset( $this->class['xparams'] )) ? $this->_createParams( $this->class['xparams'] ) : null;
    return $this->_createElement( 'CLASS', $attributes, $this->class['value'] );
  }
/**
 * set calendar component property class
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.7.16 - 2006-09-12
 * @param string $value "PUBLIC" / "PRIVATE" / "CONFIDENTIAL" / iana-token / x-name
 * @param array $xparams optional
 * @return void
 */
  function setClass( $value, $xparams=FALSE ) {
    $this->class['value'] = $value;
    if( is_array( $xparams )) {
      foreach( $xparams as $xparamKey => $xparamValue )
        $this->class['xparams'][strtoupper( $xparamKey )] = $xparamValue;
    }
  }


/*********************************************************************************/
/**
 * Property Name: COMMENT
 */
/**
 * creates formatted output for calendar component property comment
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.9.7 - 2006-11-20
 * @return string
 */
  function createComment( ) {
    $cnt = count( $this->comment );
    if( 0 >= $cnt )
      return;
    $comment = null;
    foreach( $this->comment as $commentPart ) {
      $params     = ( isset( $commentPart['params'] )) ? $commentPart['params'] : FALSE;
      $attributes = $this->_createParams( $params, array( 'ALTREP', 'LANGUAGE' ));
      $content    = $this->_strrep( $commentPart['value'] );
      $comment   .= $this->_createElement( 'COMMENT', $attributes, $content );
    }
    return $comment;
  }
/**
 * set calendar component property comment
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.7.17 - 2006-09-12
 * @param string $value
 * @param array $params optional
 * @return void
 */
  function setComment( $value, $params=FALSE ) {
    $comment['value'] = $value;
    if( is_array( $params )) {
      foreach( $params as $paramKey => $paramValue )
        $comment['params'][strtoupper( $paramKey )] = $paramValue;
    }
    $this->comment[] = $comment;
  }


/*********************************************************************************/
/**
 * Property Name: COMPLETED
 */
/**
 * creates formatted output for calendar component property completed
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.9.7 - 2006-11-20
 * @return string
 */
  function createCompleted( ) {
    if( !isset( $this->completed['value']['year'] )  &&
        !isset( $this->completed['value']['month'] ) &&
        !isset( $this->completed['value']['day'] )   &&
        !isset( $this->completed['value']['hour'] )  &&
        !isset( $this->completed['value']['min'] )   &&
        !isset( $this->completed['value']['sec'] ))
      return;
    $formatted  = $this->_format_date_time( $this->completed['value'], 7 );
    $attributes = ( isset( $this->completed['xparams'] )) ? $this->_createParams( $this->completed['xparams'] ) : null;
    return $this->_createElement( 'COMPLETED', $attributes, $formatted[0] );
  }
/**
 * set calendar component property completed
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.9.8 - 2006-11-27
 * @param mixed $year
 * @param mixed $month optional
 * @param int $day optional
 * @param int $hour optional
 * @param int $min optional
 * @param int $sec optional
 * @param array $xparam optional
 * @return void
 */
  function setCompleted( $year, $month=FALSE, $day=FALSE, $hour=FALSE, $min=FALSE, $sec=FALSE, $xparam=FALSE ) {
    if( is_array( $year ) &&
      (( 6 == count( $year )) ||
       ( array_key_exists( 'year', $year )))) {
      $this->completed['value'] = $this->_date_time_array( $year );
      if( is_array( $month )) {
        foreach( $month as $xparamKey => $xparamValue )
          $this->completed['xparams'][strtoupper( $xparamKey )] = $xparamValue;
      }
    }
    elseif( is_array( $year ) && isset( $year['timestamp'] )) {
      $this->completed['value'] = $this->_date_time_string( date( 'Y-m-d H:i:s', $year['timestamp'] ), 6 );
      if( is_array( $month )) {
        foreach( $month as $xparamKey => $xparamValue )
          $this->completed['xparams'][strtoupper( $xparamKey )] = $xparamValue;
      }
    }
    elseif( 8 <= strlen( trim( $year ))) { // ex. 2006-08-03 10:12:18
      $this->completed['value'] = $this->_date_time_string( $year );
      if( is_array( $month )) {
        foreach( $month as $xparamKey => $xparamValue )
          $this->completed['xparams'][strtoupper( $xparamKey )] = $xparamValue;
      }
    }
    else {
      $this->completed['value'] = array('year'  => $year
                                      , 'month' => $month
                                      , 'day'   => $day
                                      , 'hour'  => $hour
                                      , 'min'   => $min
                                      , 'sec'   => $sec);
      if( is_array( $xparam )) {
        foreach( $xparam as $xparamKey => $xparamValue )
          $this->completed['xparams'][strtoupper( $xparamKey )] = $xparamValue;
      }
    }
    if( !isset( $this->completed['value']['hour'] ))
      $this->completed['value']['hour'] = 0;
    if( !isset( $this->completed['value']['min'] ))
      $this->completed['value']['min'] = 0;
    if( !isset( $this->completed['value']['sec'] ))
      $this->completed['value']['sec'] = 0;
    $this->completed['value']['tz'] = 'Z';
  }

/*********************************************************************************/
/**
 * Property Name: CONTACT
 */
/**
 * creates formatted output for calendar component property contact
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.9.7 - 2006-11-20
 * @return string
 */
  function createContact( ) {
    $cnt = count( $this->contact );
    if( 0 >= $cnt )
      return;
    $params     = ( isset( $this->contact['params'] )) ? $this->contact['params'] : FALSE;
    $attributes = $this->_createParams( $params, array( 'ALTREP', 'LANGUAGE' ));
    $content    = $this->_strrep( $this->contact['value'] );
    return $this->_createElement( 'CONTACT', $attributes, $content );
  }
/**
 * set calendar component property contact
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.7.19 - 2006-09-12
 * @param string $value
 * @param array $params optional
 * @return void
 */
  function setContact( $value, $params=FALSE ) {
    $this->contact['value'] = $value;
    if( is_array( $params )) {
      foreach( $params as $paramKey => $paramValue )
        $this->contact['params'][strtoupper( $paramKey )] = $paramValue;
    }
  }

/*********************************************************************************/
/**
 * Property Name: CREATED
 */
/**
 * creates formatted output for calendar component property created
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.9.7 - 2006-11-20
 * @return string
 */
  function createCreated( ) {
    if( !isset( $this->created['value']['year'] )  &&
        !isset( $this->created['value']['month'] ) &&
        !isset( $this->created['value']['day'] )   &&
        !isset( $this->created['value']['hour'] )  &&
        !isset( $this->created['value']['min'] )   &&
        !isset( $this->created['value']['sec'] ))
      return;
    $formatted  = $this->_format_date_time( $this->created['value'], 7 );
    $attributes = ( isset( $this->created['xparams'] )) ? $this->_createParams( $this->created['xparams'] ) : null;
    return $this->_createElement( 'CREATED', $attributes, $formatted[0] );
  }
/**
 * set calendar component property created
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.9.8 - 2006-11-27
 * @param mixed $year
 * @param mixed $month optional
 * @param int $day optional
 * @param int $hour optional
 * @param int $min optional
 * @param int $sec optional
 * @param mixed $xparams optional
 * @return void
 */
  function setCreated( $year, $month=FALSE, $day=FALSE, $hour=FALSE, $min=FALSE, $sec=FALSE, $xparams=FALSE ) {
    if( is_array( $year ) &&
      (( 6 == count( $year )) ||
       ( array_key_exists( 'year', $year )))) {
      $this->created['value'] = $this->_date_time_array( $year, 7 );
      if( is_array( $month )) {
        foreach( $month as $xparamKey => $xparamValue )
          $this->created['xparams'][strtoupper( $xparamKey )] = $xparamValue;
      }
    }
    elseif( is_array( $year ) && isset( $year['timestamp'] )) {
      $this->created['value'] = $this->_date_time_string( date( 'Y-m-d H:i:s', $year['timestamp'] ), 6 );
      if( is_array( $month )) {
        foreach( $month as $xparamKey => $xparamValue )
          $this->created['xparams'][strtoupper( $xparamKey )] = $xparamValue;
      }
    }
    elseif( 8 <= strlen( trim( $year ))) { // ex. 2006-08-03 10:12:18
      $this->created['value'] = $this->_date_time_string( $year );
      if( is_array( $month )) {
        foreach( $month as $xparamKey => $xparamValue )
          $this->created['xparams'][strtoupper( $xparamKey )] = $xparamValue;
      }
    }
    else {
      $this->created['value'] = array( 'year'  => $year
                                     , 'month' => $month
                                     , 'day'   => $day
                                     , 'hour'  => $hour
                                     , 'min'   => $min
                                     , 'sec'   => $sec );
      if( is_array( $xparams )) {
        foreach( $xparams as $xparamKey => $xparamValue )
          $this->created['xparams'][strtoupper( $xparamKey )] = $xparamValue;
      }
    }
    if( !isset( $this->created['value']['hour'] ))
      $this->created['value']['hour'] = 0;
    if( !isset( $this->created['value']['min'] ))
      $this->created['value']['min'] = 0;
    if( !isset( $this->created['value']['sec'] ))
      $this->created['value']['sec'] = 0;
    $this->created['value']['tz'] = 'Z';
  }


/*********************************************************************************/
/**
 * Property Name: DESCRIPTION
 */
/**
 * creates formatted output for calendar component property description
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.9.7 - 2006-11-20
 * @return string
 */
  function createDescription( ) {
    $cnt = count( $this->description );
    if( 0 >= $cnt )
      return;
    $descriptions    = null;
    foreach( $this->description as $description ) {
      $params        = ( isset( $description['params'] )) ? $description['params'] : FALSE;
      $attributes    = $this->_createParams( $params, array( 'ALTREP', 'LANGUAGE' ));
      $content       = $this->_strrep( $description['value'] );
      $descriptions .= $this->_createElement( 'DESCRIPTION', $attributes, $content );
    }
    return $descriptions;
  }
/**
 * set calendar component property description
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.7.21 - 2006-09-12
 * @param string $value
 * @param array $params optional
 * @return void
 */
  function setDescription( $value, $params=FALSE ) {
    $description['value'] = $value;
    if( is_array( $params )) {
      foreach( $params as $paramKey => $paramValue )
        $description['params'][strtoupper( $paramKey )] = $paramValue;
    }
    $this->description[] = $description;
  }


/*********************************************************************************/
/**
 * Property Name: DTEND
 */
/**
 * creates formatted output for calendar component property dtend
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.9.7 - 2006-11-20
 * @return string
 */
  function createDtend( ) {
    if( !isset( $this->dtend['value']['year'] )  &&
        !isset( $this->dtend['value']['month'] ) &&
        !isset( $this->dtend['value']['day'] )   &&
        !isset( $this->dtend['value']['hour'] )  &&
        !isset( $this->dtend['value']['min'] )   &&
        !isset( $this->dtend['value']['sec'] ))
      return;
    $formatted    = $this->_format_date_time( $this->dtend['value'] );
    $formatted[3] = ( isset( $formatted[2] )) ? $formatted[2] : $formatted[1];
    $attributes   = ( isset( $this->dtend['xparams'] )) ? $this->_createParams( $this->dtend['xparams'] ) : null;
    return $this->_createElement( 'DTEND', $attributes.$formatted[3], $formatted[0] );
  }
/**
 * set calendar component property dtend
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.9.8 - 2006-11-27
 * @param mixed $year
 * @param mixed $month optional
 * @param int $day optional
 * @param int $hour optional
 * @param int $min optional
 * @param int $sec optional
 * @param string $tz optional
 * @param array xparams optional
 * @return void
 */
  function setDtend( $year, $month=FALSE, $day=FALSE, $hour=FALSE, $min=FALSE, $sec=FALSE, $tz=FALSE, $xparams=FALSE ) {
    if( is_array( $year ) && ( in_array( count( $year ), array( 3, 4, 6, 7 )))) {
      $parno = count( $year );
      $this->dtend['value'] = $this->_date_time_array( $year, $parno );
      if( is_array( $month )) {
        foreach( $month as $xparamKey => $xparamValue )
          $this->dtend['xparams'][strtoupper( $xparamKey )] = $xparamValue;
      }
    }
    elseif( is_array( $year ) && isset( $year['timestamp'] )) {
      $tz    = ( isset( $year['tz'] )) ? ' '.$year['tz'] : null;
      $parno = ( !empty( $tz )) ? 7 : 6;
      $this->dtend['value'] = $this->_date_time_string( date( 'Y-m-d H:i:s', $year['timestamp'] ).$tz, $parno );
      if( is_array( $month )) {
        foreach( $month as $xparamKey => $xparamValue )
          $this->dtend['xparams'][strtoupper( $xparamKey )] = $xparamValue;
      }
    }
    elseif( 8 <= strlen( trim( $year ))) { // ex. 2006-08-03 10:12:18
      $this->dtend['value'] = $this->_date_time_string( $year );
      if( is_array( $month )) {
        foreach( $month as $xparamKey => $xparamValue )
          $this->dtend['xparams'][strtoupper( $xparamKey )] = $xparamValue;
      }
    }
    else {
      $this->dtend['value'] = array('year'  => $year,
                                    'month' => $month,
                                    'day'   => $day );
      if ( $hour || $min || $sec || $tz ) {
        $this->dtend['value']['hour'] = $hour;
        $this->dtend['value']['min']  = $min;
        $this->dtend['value']['sec']  = $sec;
        $this->dtend['value']['tz']   = $tz;
      }
      if( is_array( $xparams )) {
        foreach( $xparams as $xparamKey => $xparamValue )
          $this->dtend['xparams'][strtoupper( $xparamKey )] = $xparamValue;
      }
    }
  }

/*********************************************************************************/
/**
 * Property Name: DTSTAMP
 */
/**
 * creates formatted output for calendar component property dtstamp
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.9.7 - 2006-11-20
 * @return string
 */
  function createDtstamp( ) {
    if( !isset( $this->dtstamp['value']['year'] )  &&
        !isset( $this->dtstamp['value']['month'] ) &&
        !isset( $this->dtstamp['value']['day'] )   &&
        !isset( $this->dtstamp['value']['hour'] )  &&
        !isset( $this->dtstamp['value']['min'] )   &&
        !isset( $this->dtstamp['value']['sec'] ))
      $this->_makeDtstamp();
    $formatted  = $this->_format_date_time( $this->dtstamp['value'], 7 );
    $attributes = ( isset( $this->dtstamp['xparams'] )) ? $this->_createParams( $this->dtstamp['xparams'] ) : null;
    return $this->_createElement( 'DTSTAMP', $attributes, $formatted[0] );
  }
/**
 * computes datestamp for calendar component object instance dtstamp
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.8.11 - 2006-10-08
 * @return void
 */
  function _makeDtstamp() {
    $offset = date( 'Z'); // offset in seconds
    if( '-' == substr( $offset, 0, 1 )) {
      $offset = substr( $offset, 1 );
      $sign = '-';
    }
    else {
      $sign = '+';
    }
    $offsetHour = $offset / 3600;
    $offsetMod  = $offset % 3600;
    $offsetMin  = $offsetMod / 60;
    $offsetSec  = $offsetMod % 60;
    $offset     = sprintf( $sign."%02d%02d%02d", $offsetHour, $offsetMin, $offsetSec );
    $this->dtstamp['value'] = array( 'year'  => date( 'Y' )
                                   , 'month' => date( 'm' )
                                   , 'day'   => date( 'd' )
                                   , 'hour'  => date( 'H' )
                                   , 'min'   => date( 'i' )
                                   , 'sec'   => date( 's' )
                                   , 'tz'    => $offset );
  }
/**
 * set calendar component property dtstamp
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.9.8 - 2006-11-27
 * @param mixed $year
 * @param mixed $month optional
 * @param int $day optional
 * @param int $hour optional
 * @param int $min optional
 * @param int $sec optional
 * @param array $xparams optional
 * @return void
 */
  function setDtstamp( $year, $month=FALSE, $day=FALSE, $hour=FALSE, $min=FALSE, $sec=FALSE, $xparams=FALSE ) {
    if( is_array( $year ) &&
      ( array_key_exists( 'year', $year ))) {
      $this->dtstamp['value'] = $this->_date_time_array( $year, 7 );
      if( is_array( $month )) {
        foreach( $month as $xparamKey => $xparamValue )
          $this->dtstamp['xparams'][strtoupper( $xparamKey )] = $xparamValue;
      }
    }
    elseif( is_array( $year ) && isset( $year['timestamp'] )) {
      $this->dtstamp['value'] = $this->_date_time_string( date( 'Y-m-d H:i:s', $year['timestamp'] ), 7 );
      if( is_array( $month )) {
        foreach( $month as $xparamKey => $xparamValue )
          $this->dtstamp['xparams'][strtoupper( $xparamKey )] = $xparamValue;
      }
    }
    elseif( 8 <= strlen( trim( $year ))) { // ex. 2006-08-03 10:12:18
      $this->dtstamp['value'] = $this->_date_time_string( $year, 7 );
      if( is_array( $month )) {
        foreach( $month as $xparamKey => $xparamValue )
          $this->dtstamp['xparams'][strtoupper( $xparamKey )] = $xparamValue;
      }
    }
    else {
      $this->dtstamp['value'] = array( 'year'  => $year
                                     , 'month' => $month
                                     , 'day'   => $day
                                     , 'hour'  => $hour
                                     , 'min'   => $min
                                     , 'sec'   => $sec );
      if( is_array( $xparams )) {
        foreach( $xparams as $xparamKey => $xparamValue )
          $this->dtstamp['xparams'][strtoupper( $xparamKey )] = $xparamValue;
      }
    }
    $this->dtstamp['value']['tz']   = 'Z';
  }

/*********************************************************************************/
/**
 * Property Name: DTSTART
 */
/**
 * creates formatted output for calendar component property dtstart
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.9.7 - 2006-11-20
 * @param bool $localtime optional, default FALSE
 * @return string
 */
  function createDtstart( $localtime=FALSE ) {
    if( !isset( $this->dtstart['value']['year'] )  &&
        !isset( $this->dtstart['value']['month'] ) &&
        !isset( $this->dtstart['value']['day'] )   &&
        !isset( $this->dtstart['value']['hour'] )  &&
        !isset( $this->dtstart['value']['min'] )   &&
        !isset( $this->dtstart['value']['sec'] ))
      return;
    if( $localtime )
      unset( $this->dtstart['value']['tz'] );
    $formatted    = $this->_format_date_time( $this->dtstart['value'] );
    $formatted[3] = ( isset( $formatted[2] )) ? $formatted[2] : $formatted[1];
    $attributes   = ( isset( $this->dtstart['xparams'] )) ? $this->_createParams( $this->dtstart['xparams'] ) : null;
    return $this->_createElement( 'DTSTART', $attributes.$formatted[3], $formatted[0] );
  }
/**
 * set calendar component property dtstart
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.9.8 - 2006-11-27
 * @param mixed $year
 * @param mixed $month optional
 * @param int $day optional
 * @param int $hour optional
 * @param int $min optional
 * @param int $sec optional
 * @param string $tz optional
 * @param array $xparams optional
 * @return void
 */
  function setDtstart( $year, $month=FALSE, $day=FALSE, $hour=FALSE, $min=FALSE, $sec=FALSE, $tz=FALSE, $xparams=FALSE ) {
    if( is_array( $year ) && ( in_array( count( $year ), array( 3, 4, 6, 7 )))) {
      $parno = count( $year );
      $this->dtstart['value'] = $this->_date_time_array( $year, $parno );
      if( is_array( $month )) {
        foreach( $month as $xparamKey => $xparamValue )
          $this->dtstart['xparams'][strtoupper( $xparamKey )] = $xparamValue;
      }
    }
    elseif( is_array( $year ) && isset( $year['timestamp'] )) {
      $tz    = ( isset( $year['tz'] )) ? ' '.$year['tz'] : null;
      $parno = ( !empty( $tz )) ? 7 : 6;
      $this->dtstart['value'] = $this->_date_time_string( date( 'Y-m-d H:i:s', $year['timestamp'] ).$tz, $parno );
      if( is_array( $month )) {
        foreach( $month as $xparamKey => $xparamValue )
          $this->dtstart['xparams'][strtoupper( $xparamKey )] = $xparamValue;
      }
    }
    elseif( 8 <= strlen( trim( $year ))) { // ex. 2006-08-03 10:12:18
      $this->dtstart['value'] = $this->_date_time_string( $year );
      if( is_array( $month )) {
        foreach( $month as $xparamKey => $xparamValue )
          $this->dtstart['xparams'][strtoupper( $xparamKey )] = $xparamValue;
      }
    }
    else {
      $this->dtstart['value'] = array( 'year'  => $year
                                     , 'month' => $month
                                     , 'day'   => $day );
      if ( $hour || $min || $sec ) {
        $this->dtstart['value']['hour'] = $hour;
        $this->dtstart['value']['min']  = $min;
        $this->dtstart['value']['sec']  = $sec;
        $this->dtstart['value']['tz']   = $tz;
      }
      if( is_array( $xparams )) {
        foreach( $xparams as $xparamKey => $xparamValue )
          $this->dtstart['xparams'][strtoupper( $xparamKey )] = $xparamValue;
      }
    }
  }

/*********************************************************************************/
/**
 * Property Name: DUE
 */
/**
 * creates formatted output for calendar component property due
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.9.7 - 2006-11-20
 * @return string
 */
  function createDue( ) {
    if( !isset( $this->due['value']['year'] )  &&
        !isset( $this->due['value']['month'] ) &&
        !isset( $this->due['value']['day'] )   &&
        !isset( $this->due['value']['hour'] )  &&
        !isset( $this->due['value']['min'] )   &&
        !isset( $this->due['value']['sec'] ))
      return;
    $formatted    = $this->_format_date_time( $this->due['value'] );
    $formatted[3] = ( isset( $formatted[2] )) ? $formatted[2] : $formatted[1];
    $attributes   = ( isset( $this->due['xparams'] )) ? $this->_createParams( $this->due['xparams'] ) : null;
    return $this->_createElement( 'DUE', $attributes.$formatted[3], $formatted[0] );
  }
/**
 * set calendar component property due
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.9.8 - 2006-11-27
 * @param mixed $year
 * @param mixed $month optional
 * @param int $day optional
 * @param int $hour optional
 * @param int $min optional
 * @param int $sec optional
 * @param array $xparams optional
 * @return void
 */
  function setDue( $year, $month=FALSE, $day=FALSE, $hour=FALSE, $min=FALSE, $sec=FALSE, $tz=FALSE, $xparams=FALSE ) {
    if( is_array( $year ) && ( in_array( count( $year ), array( 3, 4, 6, 7 )))) {
      $parno = count( $year );
      $this->due['value'] = $this->_date_time_array( $year, $parno );
      if( is_array( $month )) {
        foreach( $month as $xparamKey => $xparamValue )
          $this->due['xparams'][strtoupper( $xparamKey )] = $xparamValue;
      }
    }
    elseif( is_array( $year ) && isset( $year['timestamp'] )) {
      $tz    = ( isset( $year['tz'] )) ? ' '.$year['tz'] : null;
      $parno = ( !empty( $tz )) ? 7 : 6;
      $this->due['value'] = $this->_date_time_string( date( 'Y-m-d H:i:s', $year['timestamp'] ).$tz, $parno );
      if( is_array( $month )) {
        foreach( $month as $xparamKey => $xparamValue )
          $this->due['xparams'][strtoupper( $xparamKey )] = $xparamValue;
      }
    }
    elseif( 8 <= strlen( trim( $year ))) { // ex. 2006-08-03 10:12:18
      $this->due['value'] = $this->_date_time_string( $year );
      if( is_array( $month )) {
        foreach( $month as $xparamKey => $xparamValue )
          $this->due['xparams'][strtoupper( $xparamKey )] = $xparamValue;
      }
    }
    else {
      $this->due['value'] = array( 'year'  => $year
                                 , 'month' => $month
                                 , 'day'   => $day );
      if ( $hour || $min || $sec ) {
        $this->due['value']['hour'] = $hour;
        $this->due['value']['min']  = $min;
        $this->due['value']['sec']  = $sec;
        $this->due['value']['tz']   = $tz;
      }
      if( is_array( $xparams )) {
        foreach( $xparams as $xparamKey => $xparamValue )
          $this->due['xparams'][strtoupper( $xparamKey )] = $xparamValue;
      }
    }
  }

/*********************************************************************************/
/**
 * Property Name: DURATION
 */
/**
 * creates formatted output for calendar component property duration
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.9.7 - 2006-11-20
 * @return string
 */
  function createDuration( ) {
    if( !isset( $this->duration['value']['week'] ) &&
        !isset( $this->duration['value']['day'] )  &&
        !isset( $this->duration['value']['hour'] ) &&
        !isset( $this->duration['value']['min'] )  &&
        !isset( $this->duration['value']['sec'] ))
      return;
    $attributes = ( isset( $this->duration['xparams'] )) ? $this->_createParams( $this->duration['xparams'] ) : null;
    return $this->_createElement( 'DURATION', $attributes, $this->_format_duration( $this->duration['value'] ));
  }
/**
 * set calendar component property duration
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.7.26 - 2006-09-13
 * @param mixed $week
 * @param mixed $day optional
 * @param int $hour optional
 * @param int $min optional
 * @param int $sec optional
 * @param array $xparams optional
 * @return void
 */
  function setDuration( $week=FALSE, $day=FALSE, $hour=FALSE, $min=FALSE, $sec=FALSE, $xparams=FALSE ) {
    if( is_array( $week ))  {
      $this->duration['value'] = $this->_duration_array( $week );
      if( is_array( $day )) {
        foreach( $day as $xparamKey => $xparamValue )
          $this->duration['xparams'][strtoupper( $xparamKey )] = $xparamValue;
      }
    }
    else {
      $this->duration['value'] = $this->_duration_array( array( $week, $day, $hour, $min, $sec ));
      if( is_array( $xparams )) {
        foreach( $xparams as $xparamKey => $xparamValue )
          $this->duration['xparams'][strtoupper( $xparamKey )] = $xparamValue;
      }
    }
  }

/*********************************************************************************/
/**
 * Property Name: EXDATE
 */
/**
 * creates formatted output for calendar component property exdate
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.9.7 - 2006-11-20
 * @return string
 */
  function createExdate( ) {
    $cnt = count( $this->exdate );
    if( 0 >= $cnt )
      return;
    $output = null;
    foreach( $this->exdate as $theExdate ) {
      $cnt = count( $theExdate );
      $content = null;
      $attributes = ( isset( $theExdate['params'] )) ? $this->_createParams( $theExdate['params'] ) : null;
      $eno = 0;
      foreach( $theExdate['value'] as $exdatePart ) {
        $formatted = $this->_format_date_time( $exdatePart );
        if( 0 == $eno )
          $attributes .= ( isset( $formatted[2] )) ? $formatted[2] : $formatted[1];
        else
          $content .= ',';
        $content .= $formatted[0];
        $eno++;
      }
      $output .= $this->_createElement( 'EXDATE', $attributes, $content );
    }
    return $output;
  }
/**
 * set calendar component property exdate
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.9.8 - 2006-11-27
 * @param array exdates
 * @param array $params optional
 * @return void
 */
  function setExdate( $exdates, $params=FALSE ) {
    $exdate = array();
    $parno  = null;
    foreach( $exdates as $theExdate ) {
      if( is_array( $theExdate ) &&
        (( 3 == count( $theExdate )) ||
         ( 6 == count( $theExdate )) ||
         ( 7 == count( $theExdate )) ||
         ( array_key_exists( 'year', $theExdate )))) {
        if( 6 == count( $theExdate ))
          $parno = 7;
        $exdatea = $this->_date_time_array( $theExdate, $parno );
      }
      elseif( is_array( $theExdate ) && isset( $theExdate['timestamp'] )) {
        $tz    = ( isset( $theExdate['tz'] )) ? ' '.$theExdate['tz'] : null;
        $parno = ( !empty( $tz )) ? 7 : 6;
        $exdatea = $this->_date_time_string( date( 'Y-m-d H:i:s', $theExdate['timestamp'] ).$tz, $parno );
      }
      elseif( 8 <= strlen( trim( $theExdate ))) { // ex. 2006-08-03 10:12:18
        $exdatea = $this->_date_time_string( $theExdate, $parno );
      }
      if( !$parno ) {
        $parno = count( $exdatea );
        if( 6 == $parno )
          $parno = 7;
      }
      $exdate['value'][] = $exdatea;
    }
    if( is_array( $params )) {
      foreach( $params as $paramKey => $paramValue )
        $exdate['params'][strtoupper( $paramKey )] = $paramValue;
    }
    if( 0 < count( $exdate['value'] ))
      $this->exdate[] = $exdate;
  }

/*********************************************************************************/
/**
 * Property Name: EXRULE
 */
/**
 * creates formatted output for calendar component property exrule
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.7.28 - 2006-09-13
 * @return string
 */
  function createExrule( ) {
    $cnt = count( $this->exrule );
    if( 0 >= $cnt )
      return;
    $exrule = 'EXRULE';
    return $this->_format_recur( $exrule, $this->exrule );
  }
/**
 * set calendar component property exdate
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.9.8 - 2006-11-27
 * @param array $exruleset
 * @param array $xparams optional
 * @return void
 */
  function setExrule( $exruleset, $xparams=FALSE ) {
    $exrule = array();
    foreach( $exruleset as $exrulelabel => $exrulevalue ) {
      $exrulelabel = strtoupper( $exrulelabel );
      if( 'UNTIL'  != $exrulelabel )
        $exrule['value'][$exrulelabel] = $exrulevalue;
      elseif( is_array( $exrulevalue ) &&
            (( 3 == count( $exrulevalue )) ||
             ( 6 == count( $exrulevalue )) ||
             ( 7 == count( $exrulevalue )) ||
             ( array_key_exists( 'year', $exrulevalue )))) {
        $parno = ( 3 < count( $exrulevalue )) ? 7 : 3 ;
        $date  = $this->_date_time_array( $exrulevalue, $parno );
        if(( 3 < count( $date )) && !isset( $date['tz'] ))
          $date['tz'] = 'Z';
        $exrule['value'][$exrulelabel] = $date;
      }
      elseif( is_array( $exrulevalue ) && isset( $exrulevalue['timestamp'] )) {
        $date  = $this->_date_time_string( date( 'Y-m-d H:i:s', $exrulevalue['timestamp'] ), 6 );
        $date['tz'] = 'Z';
        $exrule['value'][$exrulelabel] = $date;
      }
      elseif( 8 <= strlen( trim( $exrulevalue ))) { // ex. 2006-08-03 10:12:18
        $date = $this->_date_time_string( $exrulevalue );
        if(( 3 < count( $date )) && !isset( $date['tz'] ))
          $date['tz'] = 'Z';
        $exrule['value'][$exrulelabel] = $date;
      }
    }
    if( is_array( $xparams )) {
      foreach( $xparams as $xparamKey => $xparamValue )
        $exrule['xparams'][strtoupper( $xparamKey )] = $xparamValue;
    }
    $this->exrule[] = $exrule;
  }


/*********************************************************************************/
/**
 * Property Name: FREEBUSY
 */
/**
 * creates formatted output for calendar component property freebusy
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.9.7 - 2006-11-20
 * @return string
 */
  function createFreebusy( ) {
    $cnt = count( $this->freebusy );
    if( 0 >= $cnt )
      return;
    $output = null;
    foreach( $this->freebusy as $freebusyPart ) {
      $attributes = $content = null;
      if( isset( $freebusyPart['fbtype'] )) {
        $attributes .= $this->intAttrDelimiter.'FBTYPE='.$freebusyPart['fbtype'];
      }
      else
        $attributes .= $this->intAttrDelimiter.'FBTYPE=BUSY';
      if( isset( $freebusyPart['xparams'] ))
        $attributes .= $this->_createParams( $freebusyPart['xparams'] );
      $fno = 1;
      $cnt = count( $freebusyPart['value']);
      foreach( $freebusyPart['value'] as $periodix => $freebusyPeriod ) {
        $formatted   = $this->_format_date_time( $freebusyPeriod[0] );
        $content .= $formatted[0];
        $content .= '/';
        $cnt2 = count( $freebusyPeriod[1]);
        if( array_key_exists( 'year', $freebusyPeriod[1] ))      // date-time
          $cnt2 = 7;
        elseif( array_key_exists( 'week', $freebusyPeriod[1] ))  // duration
          $cnt2 = 5;
        if(( 7 == $cnt2 )   &&    // period=  -> date-time
            isset( $freebusyPeriod[1]['year'] )  &&
            isset( $freebusyPeriod[1]['month'] ) &&
            isset( $freebusyPeriod[1]['day'] )) {
          $formatted = $this->_format_date_time( $freebusyPeriod[1] );
          $content .= $formatted[0];
        }
        else {                                  // period=  -> dur-time
          $content .= $this->_format_duration( $freebusyPeriod[1] );
        }
        if( $fno < $cnt )
          $content .= ',';
        $fno++;
      }
      $output .= $this->_createElement( 'FREEBUSY', $attributes, $content );
    }

    return $output;
  }
/**
 * set calendar component property freebusy
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.9.8 - 2006-11-27
 * @param string $fbType
 * @param array $fbValues
 * @param array $xparams optional
 * @return void
 */
  function setFreebusy( $fbType, $fbValues, $xparams=FALSE ) {
    $freebusy = array( 'fbtype' => strtoupper( $fbType ) );
    foreach( $fbValues as $fbPeriod ) {   // periods => period
      $freebusyPeriod = array();
      foreach( $fbPeriod as $fbMember ) { // pairs => singlepart
        $freebusyPairMember = array();
        if( is_array( $fbMember )) {
          $cnt = count( $fbMember );
          if(( 6 == $cnt ) || ( 7 == $cnt ) || ( array_key_exists( 'year', $fbMember ))) { // date-time value
            $date = $this->_date_time_array( $fbMember, 7 );
            $date['tz'] = ( !isset( $date['tz'] )) ? 'Z' : $date['tz'];
            $freebusyPairMember = $date;
          }
          elseif( array_key_exists( 'timestamp', $fbMember )) { // timestamp value
            $tz    = ( isset( $fbMember['tz'] )) ? ' '.$fbMember['tz'] : null;
            $parno = ( !empty( $tz )) ? 7 : 6;
            $date  = $this->_date_time_string( date( 'Y-m-d H:i:s', $fbMember['timestamp'] ).$tz, $parno );
            $date['tz'] = ( !isset( $date['tz'] )) ? 'Z' : $date['tz'];
            $freebusyPairMember = $date;
          }
          else {                                         // duration
            $freebusyPairMember = $this->_duration_array( $fbMember );
          }
        }
        elseif( 8 <= strlen( trim( $fbMember ))) { // ex. 2006-08-03 10:12:18
          $date = $this->_date_time_string( $fbMember, 7 );
          $date['tz'] = ( !isset( $date['tz'] )) ? 'Z' : $date['tz'];
          $freebusyPairMember = $date;
        }
        $freebusyPeriod[] = $freebusyPairMember;
      }
      $freebusy['value'][] = $freebusyPeriod;
    }
    if( is_array( $xparams )) {
      foreach( $xparams as $xparamKey => $xparamValue )
        $freebusy['xparams'][strtoupper( $xparamKey )] = $xparamValue;
    }
    $this->freebusy[] = $freebusy;
  }


/*********************************************************************************/
/**
 * Property Name: GEO
 */
/**
 * creates formatted output for calendar component property geo
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.9.7 - 2006-11-20
 * @return string
 */
  function createGeo( ) {
    $cnt = count( $this->geo );
    if( 0 >= $cnt )
      return;
    $attributes = ( isset( $this->geo['xparams'] )) ? $this->_createParams( $this->geo['xparams'] ) : null;
    $content    = null;
    $content   .= number_format( (float) $this->geo['latitude'], 5, '.', '');
    $content   .= ';';
    $content   .= number_format( (float) $this->geo['longitude'], 5, '.', '');
    return $this->_createElement( 'GEO', $attributes, $content );
  }
/**
 * set calendar component property geo
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.7.30 - 2006-09-13
 * @param float $latitude
 * @param float $longitude
 * @param array $xparams optional
 * @return void
 */
  function setGeo( $latitude, $longitude, $xparams=FALSE ) {
    $this->geo['latitude']  = $latitude;
    $this->geo['longitude'] = $longitude;
    if( is_array( $xparams )) {
      foreach( $xparams as $xparamKey => $xparamValue )
        $this->geo['xparams'][strtoupper( $xparamKey )] = $xparamValue;
    }
  }

/*********************************************************************************/
/**
 * Property Name: LAST-MODIFIED
 */
/**
 * creates formatted output for calendar component property last-modified
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.9.7 - 2006-11-20
 * @return string
 */
  function createLastModified( ) {
    if( !isset( $this->lastmodified['value']['year'] )  &&
        !isset( $this->lastmodified['value']['month'] ) &&
        !isset( $this->lastmodified['value']['day'] )   &&
        !isset( $this->lastmodified['value']['hour'] )  &&
        !isset( $this->lastmodified['value']['min'] )   &&
        !isset( $this->lastmodified['value']['sec'] ))
      return;
    $attributes = ( isset( $this->lastmodified['xparams'] )) ? $this->_createParams( $this->lastmodified['xparams'] ) : null;
    $formatted  = $this->_format_date_time( $this->lastmodified['value'], 7 );
    return $this->_createElement( 'LAST-MODIFIED', $attributes, $formatted[0] );
  }
/**
 * set calendar component property completed
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.9.8 - 2006-11-27
 * @param mixed $year
 * @param mixed $month optional
 * @param int $day optional
 * @param int $hour optional
 * @param int $min optional
 * @param int $sec optional
 * @param array $xparams optional
 * @return void
 */
  function setLastModified( $year, $month=FALSE, $day=FALSE, $hour=FALSE, $min=FALSE, $sec=FALSE, $xparams=FALSE ) {
    if( is_array( $year ) &&
      (( 6 == count( $year )) ||
       ( array_key_exists( 'year', $year )))) {
      $this->lastmodified['value'] = $this->_date_time_array( $year, 7 );
      if( is_array( $month )) {
        foreach( $month as $xparamKey => $xparamValue )
          $this->lastmodified['xparams'][strtoupper( $xparamKey )] = $xparamValue;
      }
    }
    elseif( is_array( $year ) && isset( $year['timestamp'] )) {
      $this->lastmodified['value'] = $this->_date_time_string( date( 'Y-m-d H:i:s', $year['timestamp'] ), 6 );
      if( is_array( $month )) {
        foreach( $month as $xparamKey => $xparamValue )
          $this->lastmodified['xparams'][strtoupper( $xparamKey )] = $xparamValue;
      }
    }
    elseif( 8 <= strlen( trim( $year ))) { // ex. 2006-08-03 10:12:18
      $this->lastmodified['value'] = $this->_date_time_string( $year, 7 );
      if( is_array( $month )) {
        foreach( $month as $xparamKey => $xparamValue )
          $this->lastmodified['xparams'][strtoupper( $xparamKey )] = $xparamValue;
      }
    }
    else {
      $this->lastmodified['value'] = array( 'year'  => $year
                                          , 'month' => $month
                                          , 'day'   => $day
                                          , 'hour'  => $hour
                                          , 'min'   => $min
                                          , 'sec'   => $sec
                                          , 'tz'    => 'Z');
      if( is_array( $xparams )) {
        foreach( $xparams as $xparamKey => $xparamValue )
          $this->lastmodified['xparams'][strtoupper( $xparamKey )] = $xparamValue;
      }
    }
    if( isset( $this->lastmodified['value']['year'] ) &&
       !isset( $this->lastmodified['value']['tz'] ))
      $this->lastmodified['value']['tz']  = 'Z';
  }

/*********************************************************************************/
/**
 * Property Name: LOCATION
 */
/**
 * creates formatted output for calendar component property location
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.9.7 - 2006-11-20
 * @return string
 */
  function createLocation( ) {
    $cnt = count( $this->location );
    if( 0 >= $cnt )
      return;
    $params     = ( isset( $this->location['params'] )) ? $this->location['params'] : FALSE;
    $attributes = $this->_createParams( $params, array( 'ALTREP', 'LANGUAGE' ));
    $content    = $this->_strrep( $this->location['value'] );
    return $this->_createElement( 'LOCATION', $attributes, $content );
  }
/**
 * set calendar component property location
 '
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.7.32 - 2006-09-13
 * @param string $value
 * @param array params optional
 * @return void
 */
  function setLocation( $value, $params=FALSE ) {
    $this->location['value'] = $value;
    if( is_array( $params )) {
      foreach( $params as $paramKey => $paramValue )
        $this->location['params'][strtoupper( $paramKey )] = $paramValue;
    }
  }

/*********************************************************************************/
/**
 * Property Name: ORGANIZER
 */
/**
 * creates formatted output for calendar component property organizer
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.9.7 - 2006-11-20
 * @return string
 */
  function createOrganizer( ) {
    $cnt = count( $this->organizer );
    if( 0 >= $cnt )
      return;
    $params     = ( isset( $this->organizer['params'] )) ? $this->organizer['params'] : FALSE;
    $attributes = $this->_createParams( $params, array( 'CN', 'DIR', 'LANGUAGE', 'SENT-BY' ));
    $content    = 'MAILTO:'.$this->organizer['value'];
    return $this->_createElement( 'ORGANIZER', $attributes, $content );
  }
/**
 * set calendar component property organizer
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.7.33 - 2006-09-13
 * @param string $value
 * @param array params optional
 * @return void
 */
  function setOrganizer( $value, $params=FALSE ) {
    $this->organizer['value'] = $value;
    if( is_array( $params )) {
      foreach( $params as $paramKey => $paramValue )
        $this->organizer['params'][strtoupper( $paramKey )] = $paramValue;
    }
  }

/*********************************************************************************/
/**
 * Property Name: PERCENT-COMPLETE
 */
/**
 * creates formatted output for calendar component property percent-complete
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.9.7 - 2006-11-20
 * @return string
 */
  function createPercentComplete( ) {
    $cnt = count( $this->percentcomplete );
    if( 0 >= $cnt )
      return;
    $attributes = ( isset( $this->percentcomplete['xparams'] )) ? $this->_createParams( $this->percentcomplete['xparams'] ) : null;
    return $this->_createElement( 'PERCENT-COMPLETE', $attributes, $this->percentcomplete['value'] );
  }
/**
 * set calendar component property percent-complete
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.7.34 - 2006-09-14
 * @param int $value
 * @param array $xparams optional
 * @return void
 */
  function setPercentComplete( $value, $xparams=FALSE ) {
    $this->percentcomplete['value'] = $value;
    if( is_array( $xparams )) {
      foreach( $xparams as $xparamKey => $xparamValue )
        $this->percentcomplete['xparams'][strtoupper( $xparamKey )] = $xparamValue;
    }
  }

/*********************************************************************************/
/**
 * Property Name: PRIORITY
 */
/**
 * creates formatted output for calendar component property priority
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.9.7 - 2006-11-20
 * @return string
 */
  function createPriority( ) {
    $cnt = count( $this->priority );
    if( 0 >= $cnt )
      return;
    $attributes = ( isset( $this->priority['xparams'] )) ? $this->_createParams( $this->priority['xparams'] ) : null;
    return $this->_createElement( 'PRIORITY', $attributes, $this->priority['value'] );
  }
/**
 * set calendar component property priority
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.7.35 - 2006-09-14
 * @param int $value
 * @param array $xparams optional
 * @return void
 */
  function setPriority( $value, $xparams=FALSE  ) {
    $this->priority['value'] = $value;
    if( is_array( $xparams )) {
      foreach( $xparams as $xparamKey => $xparamValue )
        $this->priority['xparams'][strtoupper( $xparamKey )] = $xparamValue;
    }
  }


/*********************************************************************************/
/**
 * Property Name: RDATE
 */

/**
 * creates formatted output for calendar component property rdate
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.9.7 - 2006-11-20
 * @param bool $localtime optional, default FALSE
 * @return string
 */
  function createRdate( $localtime=FALSE ) {
    $cnt = count( $this->rdate );
    if( 0 >= $cnt )
      return;
    $output = null;
    foreach( $this->rdate as $theRdate ) {
      $attributes = null;
      if( isset( $theRdate['xparams'] ))
        $attributes .= $this->_createParams( $theRdate['xparams'] );
      $cnt = count( $theRdate['value'] );
      $content = null;
      $rno = 1;
      foreach( $theRdate['value'] as $rdatePart ) {
        $contentPart = null;
        if( is_array( $rdatePart ) &&
           ( 2 == count( $rdatePart )) &&
             array_key_exists( '0', $rdatePart ) &&
             array_key_exists( '1', $rdatePart )) { // PERIOD
          if( $localtime  )
            unset( $rdatePart[0]['tz'] );
          $formatted    = $this->_format_date_time( $rdatePart[0]);
          $contentPart .= $formatted[0];
          if( 1 == $rno ) {
            if( !$localtime && !empty( $formatted[2] ))
              $attributes .= $formatted[2];
            $attributes .= $this->intAttrDelimiter.'VALUE=PERIOD';
          }
          $contentPart .= '/';
          $cnt2 = count( $rdatePart[1]);
          if( array_key_exists( 'year', $rdatePart[1] )) {
            if( array_key_exists( 'hour', $rdatePart[1] ))
              $cnt2 = 7;                                      // date-time
            else
              $cnt2 = 3;                                      // date
          }
          elseif( array_key_exists( 'week', $rdatePart[1] ))  // duration
            $cnt2 = 5;
          if(( 7 == $cnt2 )   &&    // period=  -> date-time
              isset( $rdatePart[1]['year'] )  &&
              isset( $rdatePart[1]['month'] ) &&
              isset( $rdatePart[1]['day'] )) {
            if( $localtime  )
              unset( $rdatePart[1]['tz'] );
            $formatted    = $this->_format_date_time( $rdatePart[1] );
            $contentPart .= $formatted[0];
          }
          else {                                  // period=  -> dur-time
            $contentPart .= $this->_format_duration( $rdatePart[1] );
          }
        }
        else {
          if( $localtime  )
            unset( $rdatePart['tz'] );
          $formatted = $this->_format_date_time( $rdatePart);
          if( 1 == $rno ) {
            if( !$localtime && !empty( $formatted[2] ))
              $attributes .= $formatted[2];
            $attributes .= $formatted[1];
          }
          $contentPart .= $formatted[0];
        }
        $content .= $contentPart;
        if( $rno < $cnt )
          $content .= ',';
        $rno++;
      }
      $output .= $this->_createElement( 'RDATE', $attributes, $content );
    }
    return $output;
  }
/**
 * set calendar component property rdate
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.9.8 - 2006-11-27
 * @param array $rdates
 * @param array $xparams optional
 * @return void
 */
  function setRdate( $rdates, $xparams=FALSE ) {
    $input = array();
    $parno = null;
    foreach( $rdates as $theRdate ) {
 //   echo 'setRdate in '; print_r ( $theRdate ); echo "<br />\n"; // test ##
      $inputa = null;
      if( is_array( $theRdate )) {
        if(( 2 == count( $theRdate )) &&
             array_key_exists( '0', $theRdate ) &&
             array_key_exists( '1', $theRdate ) &&
            !array_key_exists( 'timestamp', $theRdate )) { // PERIOD
          foreach( $theRdate as $rix => $rPeriod ) {
  //  echo 'setRdate i2 '; print_r ( $rPeriod ); echo "<br />\n"; // test ##
            if( is_array( $rPeriod )) {
              if (( 1 == count( $rPeriod )) &&
                  ( 8 <= strlen( trim( $rPeriod[0] )))) { // text-date
                $inputab  = $this->_date_time_string( $rPeriod[0], $parno );
                $parno = ( !$parno ) ? count( $inputab ) : $parno;
                if(( 7 == $parno ) && !isset( $inputab['tz'] ))
                  $inputab['tz'] = 'Z';
                $inputa[] = $inputab;
              }
              elseif (((3 == count( $rPeriod )) && ( $rix < 1 )) ||
                      ( 6 == count( $rPeriod )) ||
                      ( 7 == count( $rPeriod )) ||
                      ( array_key_exists( 'year', $rPeriod ))) { // date[-time] (only 1st rperiod)
                if( !isset( $parno ) && 3 < count( $rPeriod ))
                  $parno = 7;
                // else
                //  $parno = 3;
                $inputab  = $this->_date_time_array( $rPeriod, $parno );
                $parno = ( !$parno ) ? count( $inputab ) : $parno;
                if(( 7 == $parno ) && !isset( $inputab['tz'] ))
                  $inputab['tz'] = 'Z';
                $inputa[] = $inputab;
              }
              elseif( isset( $rPeriod['timestamp'] )) {   // timestamp
                $tz    = ( isset( $rPeriod['tz'] )) ? ' '.$rPeriod['tz'] : null;
                $parno = ( !isset( $parno ) && !empty( $tz )) ? 7 : 6;
                $inputab = $this->_date_time_string( date( 'Y-m-d H:i:s', $rPeriod['timestamp'] ).$tz, $parno );
                if(( 7 == $parno ) && !isset( $inputab['tz'] ))
                  $inputab['tz'] = 'Z';
                $inputa[] = $inputab;
              }
              else {                                       // duration
                $inputa[] = $this->_duration_array( $rPeriod );
              }
            }
            elseif( 8 <= strlen( trim( $rPeriod ))) { // ex. 2006-08-03 10:12:18
              $inputab  = $this->_date_time_string( $rPeriod, $parno );
              $inputa[] = $inputab;
              $parno = ( !$parno ) ? count( $inputab ) : $parno;
            }
          }
        }
        elseif ( array_key_exists( 'timestamp', $theRdate )) {   // timestamp
          $tz    = ( isset( $theRdate['tz'] )) ? ' '.$theRdate['tz'] : null;
          $parno = ( !isset( $parno ) && !empty( $tz )) ? 7 : 6;
          $inputab = $this->_date_time_string( date( 'Y-m-d H:i:s', $theRdate['timestamp'] ).$tz, $parno );
          if(( 7 == $parno ) && !isset( $inputab['tz'] ))
            $inputab['tz'] = 'Z';
          $inputa = $inputab;
        }
        elseif (( 3 == count( $theRdate )) ||
                ( 6 == count( $theRdate )) ||
                ( 7 == count( $theRdate )) ||
                ( array_key_exists( 'year', $theRdate ))) {  // date[-time]
          if( !isset( $parno ) && 3 < count( $theRdate ))
            $parno = ( isset( $theRdate['tz'] )) ? 7 : count( $theRdate );
          elseif( !isset( $parno ))
            $parno = 3;
          $inputa = $this->_date_time_array( $theRdate, $parno );
          if(( 7 == $parno ) && !isset( $inputa['tz'] ))
            $inputa['tz'] = 'Z';
        }
      }
      elseif( 8 <= strlen( trim( $theRdate ))) { // ex. 2006-08-03 10:12:18
        $inputa = $this->_date_time_string( $theRdate, $parno );
        $parno = ( !$parno ) ? count( $inputa ) : $parno;
        if(( 7 == $parno ) && !isset( $inputa['tz'] ))
          $inputa['tz'] = 'Z';
      }
      $input['value'][] = $inputa;
    }
    if( is_array( $xparams )) {
      foreach( $xparams as $xparamKey => $xparamValue )
        $input['xparams'][strtoupper( $xparamKey )] = $xparamValue;
    }
    if( 0 < count( $input['value'] ))
      $this->rdate[] = $input;

   //  echo 'setRdate ut '; print_r ( $this->rdate ); echo "<br />\n"; // test ##
  }

/*********************************************************************************/
/**
 * Property Name: RECURRENCE-ID
 */
/**
 * creates formatted output for calendar component property recurrence-id
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.9.7 - 2006-11-20
 * @return string
 */
  function createRecurrenceid( ) {
    $cnt = count( $this->recurrenceid );
    if( 0 >= $cnt )
      return;
    $formatted   = $this->_format_date_time( $this->recurrenceid['date'] );
    $attributes  = ( isset( $this->recurrenceid['params'] )) ? $this->_createParams( $this->recurrenceid['params'] ) : null;
    $attributes .= ( isset( $formatted[2] )) ? $formatted[2] : null;
    $attributes .= $formatted[1];
    return $this->_createElement( 'RECURRENCE-ID', $attributes, $formatted[0] );
  }
/**
 * set calendar component property recurrence-id
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.9.8 - 2006-11-27
 * @param array $date
 * @param array $params optional
 * @return void
 */
  function setRecurrenceid( $date, $params=FALSE ) {
    if( is_array( $date ) && !array_key_exists( 'timestamp', $date )) {  // date[-time]
      $this->recurrenceid['date'] = $this->_date_time_array( $date );
    }
    elseif( is_array( $date ) && array_key_exists( 'timestamp', $date )) {   // timestamp
      $tz    = ( isset( $date['tz'] )) ? ' '.$date['tz'] : null;
      $parno = ( !empty( $tz )) ? 7 : 6;
      $this->recurrenceid['date'] = $this->_date_time_string( date( 'Y-m-d H:i:s', $date['timestamp'] ).$tz, $parno );
    }
    else { // date in a string
      $this->recurrenceid['date'] = $this->_date_time_string( $date );
    }
    if( is_array( $params )) {
      foreach( $params as $paramKey => $paramValue )
        $this->recurrenceid['params'][strtoupper( $paramKey )] = $paramValue;
    }
  }

/*********************************************************************************/
/**
 * Property Name: RELATED-TO
 */
/**
 * creates formatted output for calendar component property related-to
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.9.7 - 2006-11-20
 * @return string
 */
  function createRelatedTo( ) {
    $cnt = count( $this->relatedto );
    if( 0 >= $cnt )
      return;
    $output =null;
    foreach( $this->relatedto as $relation ) {
      $attributes = ( isset( $relation['params'] )) ? $this->_createParams( $relation['params'] ) : null;
      $content    = '<'.$relation['relid'].'>';
      $output    .= $this->_createElement( 'RELATED-TO', $attributes, $content );
    }
    return $output;
  }
/**
 * set calendar component property related-to
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.7.39 - 2006-09-14
 * @param float $relid
 * @param array $params optional
 * @return void
 */
  function setRelatedTo( $relid, $params=FALSE ) {
    $relation = array();
    $relation['relid'] = $relid;
    if( is_array( $params )) {
      foreach( $params as $paramKey => $paramValue )
        $relation['params'][strtoupper( $paramKey )] = $paramValue;
    }
    $this->relatedto[] = $relation;
  }

/*********************************************************************************/
/**
 * Property Name: REPEAT
 */
/**
 * creates formatted output for calendar component property repeat
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.9.7 - 2006-11-20
 * @return string
 */
  function createRepeat( ) {
    $cnt = count( $this->repeat );
    if( 0 >= $cnt )
      return;
    $attributes = ( isset( $this->repeat['xparams'] )) ? $this->_createParams( $this->repeat['xparams'] ) : null;
    return $this->_createElement( 'REPEAT', $attributes, $this->repeat['value'] );
  }
/**
 * set calendar component property transp
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.9.5 - 2006-11-16
 * @param string $value
 * @param array $xparams optional
 * @return void
 */
  function setRepeat( $value, $xparams=FALSE ) {
    $this->repeat['value'] = $value;
    if( is_array( $xparams )) {
      foreach( $xparams as $xparamKey => $xparamValue )
        $this->repeat['xparams'][strtoupper( $xparamKey )] = $xparamValue;
    }
  }


/*********************************************************************************/
/**
 * Property Name: REQUEST-STATUS
 */
/**
 * creates formatted output for calendar component property request-status
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.9.7 - 2006-11-20
 * @return string
 */
  function createRequestStatus( ) {
    $cnt = count( $this->requeststatus );
    if( 0 >= $cnt )
      return;
    $output = null;
    foreach( $this->requeststatus as $rstat ) {
      $params     = ( isset( $rstat['param'] )) ? $rstat['param'] : FALSE;
      $attributes = $this->_createParams( $params, array( 'LANGUAGE' ));
      $content    = number_format( (float) $rstat['statcode'], 2, '.', '');
      $content   .= ';'.$this->_strrep( $rstat['text'] );
      if( isset( $rstat['extdata'] ))
        $content .= ';'.$this->_strrep( $rstat['extdata'] );
      $output    .= $this->_createElement( 'REQUEST-STATUS', $attributes, $content );
    }
    return $output;
  }
/**
 * set calendar component property request-status
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.7.41 - 2006-09-14
 * @param float $statcode
 * @param string $text
 * @param string $extdata optional
 * @param array params optional
 * @return void
 */
  function setRequestStatus( $statcode, $text, $extdata=FALSE, $params=FALSE ) {
    $input = array();
    $input['statcode']  = $statcode;
    $input['text']      = $text;
    if( $extdata )
      $input['extdata'] = $extdata;
    if( is_array( $params )) {
      foreach( $params as $paramKey => $paramValue )
        $input['param'][strtoupper( $paramKey )] = $paramValue;
    }
    $this->requeststatus[] = $input;
  }

/*********************************************************************************/
/**
 * Property Name: RESOURCES
 */
/**
 * creates formatted output for calendar component property resources
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.9.7 - 2006-11-20
 * @return string
 */
  function createResources( ) {
    $cnt = count( $this->resources );
    if( 0 >= $cnt )
      return;
    $output = null;
    foreach( $this->resources as $resource ) {
      $params     = ( isset( $resource['params'] )) ? $resource['params'] : FALSE;
      $attributes = $this->_createParams( $params, array( 'ALTREP', 'LANGUAGE' ));
      $rno = 1;
      $cnt = count( $resource['part'] );
      $content = null;
      foreach( $resource['part'] as $resourcePart ) {
        $content .= $resourcePart;
        if( $rno < $cnt )
          $content .= ',';
        $rno++;
      }
      while( 0 < ( substr_count($content, ', ') + substr_count($content, ', '))) {
        $content = str_replace( ', ', ',', $content );
        $content = str_replace( ' ,', ',', $content );
      }
      $output .= $this->_createElement( 'RESOURCES', $attributes, $content );
    }

    return ( $output );
  }
/**
 * set calendar component property recources
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.7.42 - 2006-09-14
 * @param string $value
 * @param array params optional
 * @return void
 */
  function setResources( $value, $params=FALSE ) {
    $input = array();
    if( is_array( $value )) {
      foreach( $value as $valuePart )
        $input['part'][] = $valuePart;
    }
    else
      $input['part'][] = $value;
    if( is_array( $params )) {
      foreach( $params as $paramKey => $paramValue )
        $input['params'][strtoupper( $paramKey )] = $paramValue;
    }
    $this->resources[] = $input;
  }

/*********************************************************************************/
/**
 * Property Name: RRULE
 */
/**
 * creates formatted output for calendar component property rrule
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.7.43 - 2006-09-15
 * @return string
 */
  function createRrule( ) {
    $cnt = count( $this->rrule );
    if( 0 >= $cnt )
      return;
    return $this->_format_recur( 'RRULE', $this->rrule );
  }
/**
 * set calendar component property rrule
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.9.8 - 2006-11-27
 * @param array $rruleset
 * @param array $xparams optional
 * @return void
 */
  function setRrule( $rruleset, $xparams=FALSE ) {
    $exrule = array();
    foreach( $rruleset as $rrulelabel => $rrulevalue ) {
      $rrulelabel = strtoupper( $rrulelabel );
      if( 'UNTIL'  != $rrulelabel )
        $rrule['value'][$rrulelabel] = $rrulevalue;
      elseif( is_array( $rrulevalue ) &&
            (( 3 == count( $rrulevalue )) ||
             ( 6 == count( $rrulevalue )) ||
             ( 7 == count( $rrulevalue )) ||
             ( array_key_exists( 'year', $rrulevalue )))) {
        $parno = ( 3 < count( $rrulevalue )) ? 7 : 3 ; // datetime / date
        $date  = $this->_date_time_array( $rrulevalue, $parno );
        if(( 3 < count( $date )) && !isset( $date['tz'] ))
          $date['tz'] = 'Z';
        $rrule['value'][$rrulelabel] = $date;
      }
      elseif( is_array( $rrulevalue ) && isset( $rrulevalue['timestamp'] )) {
        $date  = $this->_date_time_string( date( 'Y-m-d H:i:s', $rrulevalue['timestamp'] ), 6 );
        $date['tz'] = 'Z';
        $rrule['value'][$rrulelabel] = $date;
      }
      elseif( 8 <= strlen( trim( $rrulevalue ))) { // ex. 2006-08-03 10:12:18
        $date = $this->_date_time_string( $rrulevalue );
        if(( 3 < count( $date )) && !isset( $date['tz'] ))
          $date['tz'] = 'Z';
        $rrule['value'][$rrulelabel] = $date;
      }
    }
    if( is_array( $xparams )) {
      foreach( $xparams as $xparamKey => $xparamValue )
        $rrule['xparams'][strtoupper( $xparamKey )] = $xparamValue;
    }
    $this->rrule[] = $rrule;
  }

/*********************************************************************************/
/**
 * Property Name: SEQUENCE
 */
/**
 * creates formatted output for calendar component property sequence
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.9.7 - 2006-11-20
 * @return string
 */
  function createSequence( ) {
    $cnt = count( $this->sequence );
    if( 0 >= $cnt )
      return;
    $attributes = ( isset( $this->sequence['xparams'] )) ? $this->_createParams( $this->sequence['xparams'] ) : null;
    return $this->_createElement( 'SEQUENCE', $attributes, $this->sequence['value'] );
  }
/**
 * set calendar component property sequence
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.7.44 - 2006-09-15
 * @param int $value
 * @param array $xparams
 * @return void
 */
  function setSequence( $value, $xparams=FALSE ) {
    $this->sequence['value'] = $value;
    if( is_array( $xparams )) {
      foreach( $xparams as $xparamKey => $xparamValue )
        $this->sequence['xparams'][strtoupper( $xparamKey )] = $xparamValue;
    }
  }

/*********************************************************************************/
/**
 * Property Name: STATUS
 */
/**
 * creates formatted output for calendar component property status
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.9.7 - 2006-11-20
 * @return string
 */
  function createStatus( ) {
    $cnt = count( $this->status );
    if( 0 >= $cnt )
      return;
    $attributes = ( isset( $this->status['xparams'] )) ? $this->_createParams( $this->status['xparams'] ) : null;
    return $this->_createElement( 'STATUS', $attributes, $this->status['value'] );
  }
/**
 * set calendar component property status
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.7.45 - 2006-09-15
 * @param string $value
 * @param array $xparams optional
 * @return void
 */
  function setStatus( $value, $xparams=FALSE ) {
    $this->status['value'] = $value;
    if( is_array( $xparams )) {
      foreach( $xparams as $xparamKey => $xparamValue )
        $this->status['xparams'][strtoupper( $xparamKey )] = $xparamValue;
    }
  }


/*********************************************************************************/
/**
 * Property Name: SUMMARY
 */
/**
 * creates formatted output for calendar component property summary
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.9.7 - 2006-11-20
 * @return string
 */
  function createSummary( ) {
    $cnt = count( $this->summary );
    if( 0 >= $cnt )
      return;
    $params     = ( isset( $this->summary['params'] )) ? $this->summary['params'] : FALSE;
    $attributes = $this->_createParams( $params, array( 'ALTREP', 'LANGUAGE' ));
    $content    = $this->_strrep( $this->summary['value'] );
    return $this->_createElement( 'SUMMARY', $attributes, $content );
  }
/**
 * set calendar component property summary
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.7.46 - 2006-09-15
 * @param string $value
 * @param string $params optional
 * @return void
 */
  function setSummary( $value, $params=FALSE ) {
    $this->summary['value'] = $value;
    if( is_array( $params )) {
      foreach( $params as $paramKey => $paramValue )
        $this->summary['params'][strtoupper( $paramKey )] = $paramValue;
    }
  }

/*********************************************************************************/
/**
 * Property Name: TRANSP
 */
/**
 * creates formatted output for calendar component property transp
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.9.7 - 2006-11-20
 * @return string
 */
  function createTransp( ) {
    $cnt = count( $this->transp );
    if( 0 >= $cnt )
      return;
    $attributes = ( isset( $this->transp['xparams'] )) ? $this->_createParams( $this->transp['xparams'] ) : null;
    return $this->_createElement( 'TRANSP', $attributes, $this->transp['value'] );
  }
/**
 * set calendar component property transp
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.7.47 - 2006-09-15
 * @param string $value
 * @param string $xparams optional
 * @return void
 */
  function setTransp( $value, $xparams=FALSE ) {
    $this->transp['value'] = $value;
    if( is_array( $xparams )) {
      foreach( $xparams as $paramKey => $paramValue )
        $this->transp['xparams'][strtoupper( $paramKey )] = $paramValue;
    }
  }

/*********************************************************************************/
/**
 * Property Name: TRIGGER
 */
/**
 * creates formatted output for calendar component property trigger
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.9.7 - 2006-11-20
 * @return string
 */
  function createTrigger( ) {
    $cnt = count( $this->trigger );
    if( 0 >= $cnt )
      return;
    $content = null;
    $attributes = ( isset( $this->trigger['xparams'] )) ? $this->_createParams( $this->trigger['xparams'] ) : null;
    if( isset( $this->trigger['value']['year'] )   &&
        isset( $this->trigger['value']['month'] )  &&
        isset( $this->trigger['value']['day'] )) {
      $formatted     = $this->_format_date_time( $this->trigger['value'] );
      $attributes   .= $formatted[1];
      $content      .= $formatted[0];
    }
    else {
      $attributes   .= $this->intAttrDelimiter.'VALUE=DURATION';
      if( $this->trigger['value']['relatedstart'] )
        $attributes .= $this->intAttrDelimiter.'RELATED=START';
      else
        $attributes .= $this->intAttrDelimiter.'RELATED=END';
      if( $this->trigger['value']['before'] )
        $content    .= '-';
      $content      .= $this->_format_duration( $this->trigger['value'] );
    }
    return $this->_createElement( 'TRIGGER', $attributes, $content );
  }
/**
 * set calendar component property trigger
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.9.8 - 2006-11-27
 * @param mixed $year
 * @param mixed $month optional
 * @param int $day optional
 * @param int $week optional
 * @param int $hour optional
 * @param int $min optional
 * @param int $sec optional
 * @param bool $relatedEnd optional
 * @param bool $after optional
 * @param string $tz optional
 * @param array $xparams optional
 * @return void
 */
  function setTrigger( $year=FALSE, $month=FALSE, $day=FALSE, $week=FALSE, $hour=FALSE, $min=FALSE, $sec=FALSE, $relatedEnd=FALSE, $after=FALSE, $tz=FALSE, $xparams=FALSE ) {
    if( is_array( $year ) && array_key_exists( 'timestamp', $year )) { // timestamp
      $tz    = ( isset( $year['tz'] )) ? $year['tz'] : null;
      $date  = $this->_date_time_string( date( 'Y-m-d H:i:s', $year['timestamp'] ), 6 );
      $xparams = ( !empty( $month )) ? $month : null;
      foreach( $date as $k => $v )
        $$k = $v;
    }
    elseif( is_array( $year )) {
      if( array_key_exists( 'year',  $year )  &&
          array_key_exists( 'month', $year ) &&
          array_key_exists( 'day',   $year ))
        $xparams    = ( !empty( $month ))    ? $month : null;
      else {
        $relatedEnd = $month;
        $after      = $day;
        $xparams    = ( is_array( $week )) ? $week  : null;
      }
      $SSYY  = ( array_key_exists( 'year',  $year )) ? $year['year']  : null;
      $month = ( array_key_exists( 'month', $year )) ? $year['month'] : null;
      $day   = ( array_key_exists( 'day',   $year )) ? $year['day']   : null;
      $week  = ( array_key_exists( 'week',  $year )) ? $year['week']  : null;
      $hour  = ( array_key_exists( 'hour',  $year )) ? $year['hour']  : null;
      $min   = ( array_key_exists( 'min',   $year )) ? $year['min']   : null;
      $sec   = ( array_key_exists( 'sec',   $year )) ? $year['sec']   : null;
      $tz    = ( array_key_exists( 'tz',    $year )) ? $year['tz']    : null;
      $year  = $SSYY;
    }
    elseif( is_string($year) && !is_int( $year )) {  // date in a string
      $date = $this->_date_time_string( $year );
      $xparams    = ( !empty( $month ))    ? $month : null;
      foreach( $date as $k => $v )
        $$k = $v;
    }
    if( !empty( $year ) && !empty( $month ) && !empty( $day ) ) {
      $this->trigger['value'] = array( 'year'       => $year
                                     , 'month'      => $month
                                     , 'day'        => $day);
      if( !empty( $hour ))
        $this->trigger['value']['hour'] = $hour;
      if( !empty( $min ))
        $this->trigger['value']['min']  = $min;
      if( !empty( $sec ))
        $this->trigger['value']['sec']  = $sec;
      if( !empty( $tz ))
        $this->trigger['value']['tz']   = $tz;
      else
        $this->trigger['value']['tz']   = 'Z';
    }
    elseif( !empty( $week )) {
      $this->trigger['value'] = array( 'week'         => $week
                                     , 'relatedstart' => !$relatedEnd
                                     , 'before'       => !$after );
    }
    else {
      $this->trigger['value'] = array( 'day'          => $day
                                     , 'hour'         => $hour
                                     , 'min'          => $min
                                     , 'sec'          => $sec
                                     , 'relatedstart' => !$relatedEnd
                                     , 'before'       => !$after );
    }
    if( !isset( $this->trigger['value'] ))
      return;
    if( is_array( $xparams )) {
      foreach( $xparams as $paramKey => $paramValue )
        $this->trigger['xparams'][strtoupper( $paramKey )] = $paramValue;
    }
  }

/*********************************************************************************/
/**
 * Property Name: TZID
 */
/**
 * creates formatted output for calendar component property tzid
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.9.7 - 2006-11-20
 * @return string
 */
  function createTzid( ) {
    $cnt = count( $this->tzid );
    if( 0 >= $cnt )
      return;
    $attributes = ( isset( $this->tzid['xparams'] )) ? $this->_createParams( $this->tzid['xparams'] ) : null;
    return $this->_createElement( 'TZID', $attributes, $this->tzid['value'] );
  }
/**
 * set calendar component property tzid
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.7.49 - 2006-09-15
 * @param string $value
 * @param array $xparams optional
 * @return void
 */
  function setTzid( $value, $xparams=FALSE ) {
    $this->tzid['value'] = $value;
    if( !isset( $this->tzid['value'] ))
      return;
    if( is_array( $xparams )) {
      foreach( $xparams as $xparamKey => $xparamValue )
        $this->tzid['xparams'][strtoupper( $xparamKey )] = $xparamValue;
    }
  }
/*********************************************************************************/
/**
 * .. .
 * Property Name: TZNAME
 */
/**
 * creates formatted output for calendar component property tzname
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.9.7 - 2006-11-20
 * @return string
 */
  function createTzname( ) {
    $cnt = count( $this->tzname );
    if( 0 >= $cnt )
      return;
    $params     = ( isset( $this->tzname['params'] )) ? $this->tzname['params'] : FALSE;
    $attributes = $this->_createParams( $params, array( 'LANGUAGE' ));
    return $this->_createElement( 'TZNAME', $attributes, $this->tzname['value'] );
  }
/**
 * set calendar component property tzname
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.7.50 - 2006-09-15
 * @param string $value
 * @param string $params optional
 * @return void
 */
  function setTzname( $value, $params=FALSE ) {
    $this->tzname['value'] = $value;
    if( empty( $this->tzname['value'] ))
      return;
    if( is_array( $params )) {
      foreach( $params as $paramKey => $paramValue )
        $this->tzname['params'][strtoupper( $paramKey )] = $paramValue;
    }
  }

/*********************************************************************************/
/**
 * Property Name: TZOFFSETFROM
 */
/**
 * creates formatted output for calendar component property tzoffsetfrom
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.9.7 - 2006-11-20
 * @return string
 */
  function createTzoffsetfrom( ) {
    $cnt = count( $this->tzoffsetfrom );
    if( 0 >= $cnt )
      return;
    $attributes = ( isset( $this->tzoffsetfrom['xparams'] )) ? $this->_createParams( $this->tzoffsetfrom['xparams'] ) : null;
    return $this->_createElement( 'TZOFFSETFROM', $attributes, $this->tzoffsetfrom['value'] );
  }
/**
 * set calendar component property tzoffsetfrom
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.7.51 - 2006-09-15
 * @param string $value
 * @param string $xparams optional
 * @return void
 */
  function setTzoffsetfrom( $value, $xparams=FALSE ) {
    $this->tzoffsetfrom['value'] = $value;
    if( empty( $this->tzoffsetfrom['value'] ))
      return;
    if( is_array( $xparams )) {
      foreach( $xparams as $xparamKey => $xparamValue )
        $this->tzoffsetfrom['xparams'][strtoupper( $xparamKey )] = $xparamValue;
    }
  }

/*********************************************************************************/
/**
 * Property Name: TZOFFSETTO
 */
/**
 * creates formatted output for calendar component property tzoffsetto
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.9.7 - 2006-11-20
 * @return string
 */
  function createTzoffsetto( ) {
    $cnt = count( $this->tzoffsetto );
    if( 0 >= $cnt )
      return;
    $attributes = ( isset( $this->tzoffsetto['xparams'] )) ? $this->_createParams( $this->tzoffsetto['xparams'] ) : null;
    return $this->_createElement( 'TZOFFSETTO', $attributes, $this->tzoffsetto['value'] );
  }
/**
 * set calendar component property tzoffsetto
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.7.52 - 2006-09-15
 * @param string $value
 * @param string $xparams optional
 * @return void
 */
  function setTzoffsetto( $value, $xparams=FALSE ) {
    $this->tzoffsetto['value'] = $value;
    if( empty( $this->tzoffsetto['value'] ))
      return;
    if( is_array( $xparams )) {
      foreach( $xparams as $xparamKey => $xparamValue )
        $this->tzoffsetto['xparams'][strtoupper( $xparamKey )] = $xparamValue;
    }
  }

/*********************************************************************************/
/**
 * Property Name: TZURL
 */
/**
 * creates formatted output for calendar component property tzurl
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.9.7 - 2006-11-20
 * @return string
 */
  function createTzurl( ) {
    $cnt = count( $this->tzurl );
    if( 0 >= $cnt )
      return;
    $attributes = ( isset( $this->tzurl['xparams'] )) ? $this->_createParams( $this->tzurl['xparams'] ) : null;
    return $this->_createElement( 'TZURL', $attributes, $this->tzurl['value'] );
  }
/**
 * set calendar component property tzurl
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.7.53 - 2006-09-15
 * @param string $value
 * @param string $xparams optional
 * @return void
 */
  function setTzurl( $value, $xparams=FALSE ) {
    $this->tzurl['value'] = $value;
    if( empty( $this->tzurl['value'] ))
      return;
    if( is_array( $xparams )) {
      foreach( $xparams as $xparamKey => $xparamValue )
        $this->tzurl['xparams'][strtoupper( $xparamKey )] = $xparamValue;
    }
  }

/*********************************************************************************/
/**
 * Property Name: UID
 */
/*
 * creates formatted output for calendar component property uid
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.9.7 - 2006-11-20
 * @return string
 */
  function createUid( ) {
    $cnt = count( $this->uid );
    if( 0 >= $cnt ) {
      $this->_makeuid();
    }
    $attributes = ( isset( $this->uid['xparams'] )) ? $this->_createParams( $this->uid['xparams'] ) : null;
    return $this->_createElement( 'UID', $attributes, $this->uid['value'] );
  }
/**
 * return calendar component property uid
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.7.54 - 2006-09-15
 * @return string
 */
  function getUid( ) {
    $cnt = count( $this->uid );
    if( 0 >= $cnt ) {
      $this->_makeuid();
    }
    return $this->uid['value'];
  }
/**
 * create an unique id for this calendar component object instance
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.7.57 - 2006-09-17
 * @return void
 */
  function _makeUid() {
    $unique = null;
    $base   = 'aAbBcCdDeEfFgGhHiIjJkKlLmMnNoOpPrRsStTuUvVxXuUvVwWzZ1234567890 ';
    $start  = 0;
    $end    = strlen( $base ) - 1;
    $length = 10;
    $str    = null;
    for( $p = 0; $p < $length; $p++ ) {
      $basePos = mt_rand( $start, $end );
      $unique .= $base{$basePos};
    }
    if( empty( $this->unique_id ))
      $this->_makeUnique_id();
    $this->uid['value'] = date('Ymd\THisT').'-'.$unique.'@'.$this->unique_id;
  }
/**
 * set calendar component property uid
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.7.54 - 2006-09-15
 * @param string $value
 * @param string $xparams optional
 * @return void
 */
  function setUid( $value, $xparams=FALSE ) {
    $this->uid['value'] = $value;
    if( empty( $this->uid['value'] ))
      return;
    if( is_array( $xparams )) {
      foreach( $xparams as $xparamKey => $xparamValue )
        $this->uid['xparams'][strtoupper( $xparamKey )] = $xparamValue;
    }
  }

/*********************************************************************************/
/**
 * Property Name: URL
 */
/**
 * creates formatted output for calendar component property url
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.9.7 - 2006-11-20
 * @return string
 */
  function createUrl( ) {
    $cnt = count( $this->url );
    if( 0 >= $cnt )
      return;
    $attributes = ( isset( $this->url['xparams'] )) ? $this->_createParams( $this->url['xparams'] ) : null;
    return $this->_createElement( 'URL', $attributes, $this->url['value'] );
  }
/**
 * set calendar component property url
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.7.55 - 2006-09-15
 * @param string $value
 * @param string $xparams optional
 * @return void
 */
  function setUrl( $value, $xparams=FALSE ) {
    $this->url['value'] = $value;
    if( empty( $this->url['value'] ))
      return;
    if( is_array( $xparams )) {
      foreach( $xparams as $xparamKey => $xparamValue )
        $this->url['xparams'][strtoupper( $xparamKey )] = $xparamValue;
    }
  }

/*********************************************************************************/
/**
 * Property Name: x-prop
 */
/**
 * creates formatted output for calendar component property x-prop
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.9.7 - 2006-11-20
 * @return string
 */
  function createXprop( ) {
    $cnt = count( $this->xprop );
    if( 0 >= $cnt )
      return;
    $xprop = null;
    foreach( $this->xprop as $xpropPart ) {
     foreach( $xpropPart['value'] as $label => $value )
      $params     = ( isset( $xpropPart['params'] )) ? $xpropPart['params'] : FALSE;
      $attributes = $this->_createParams( $params, array( 'LANGUAGE' ));
      $xprop .= $this->_createElement( $label, $attributes, $value );
    }
    return $xprop;
  }
/**
 * set calendar component property x-prop
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.7.56 - 2006-09-15
 * @param string $label
 * @param string $value
 * @param array $params optional
 * @return void
 */
  function setXprop( $label, $value, $params=FALSE ) {
    $xprop['value'] = array( $label => $value);
    if( empty( $xprop['value'] ))
      return;
    if( is_array( $params )) {
      foreach( $params as $paramKey => $paramValue )
        $xprop['params'][strtoupper( $paramKey )] = $paramValue;
    }
    $this->xprop[] = $xprop;
  }



/*********************************************************************************/
/*********************************************************************************/
/**
 * create element format parts
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.9.7 - 2006-11-20
 * @return string
 */
  function _createFormat() {
    switch( $this->format ) {
      case 'xcal':
        $this->objName            = ( isset( $this->timezonetype )) ?
                                 strtolower( $this->timezonetype )  :  strtolower( $this->objName );
        $this->componentStart1    = $this->elementStart1 = '<';
        $this->componentStart2    = $this->elementStart2 = '>';
        $this->componentEnd1      = $this->elementEnd1   = '</';
        $this->componentEnd2      = $this->elementEnd2   = '>'.$this->nl;
        $this->intAttrDelimiter   = '<!-- -->';
        $this->attributeDelimiter = $this->nl;
        $this->valueInit          = null;
        break;
      default:
        $this->objName            = ( isset( $this->timezonetype )) ?
                                 strtoupper( $this->timezonetype )  :  strtoupper( $this->objName );
        $this->componentStart1    = 'BEGIN:';
        $this->componentStart2    = null;
        $this->componentEnd1      = 'END:';
        $this->componentEnd2      = $this->nl;
        $this->elementStart1      = null;
        $this->elementStart2      = null;
        $this->elementEnd1        = null;
        $this->elementEnd2        = $this->nl;
        $this->intAttrDelimiter   = '<!-- -->';
        $this->attributeDelimiter = ';';
        $this->valueInit          = ':';
        break;
    }
  }
/**
 * creates formatted output for calendar component property
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.9.7 - 2006-11-20
 * @param string $label property name
 * @param string $attributes property attributes
 * @param string $content property content (optional)
 * @return string
 */
  function _createElement( $label, $attributes, $content=FALSE ) {
    $label  = $this->_formatPropertyName( $label );
    $output = $this->elementStart1.$label;
    $categoriesAttrLang = null;
    $attachInlineBinary = FALSE;
    $attachfmttype      = null;
    if( !empty( $attributes ))  {
      $attributes  = trim( $attributes );
      if ( 'xcal' == $this->format) {
        $attributes2 = explode( $this->intAttrDelimiter, $attributes );
        $attributes  = null;
        foreach( $attributes2 as $attribute ) {
          $attrKVarr = explode( '=', $attribute );
          if( empty( $attrKVarr[0] ))
            continue;
          if( !isset( $attrKVarr[1] )) {
            $attrValue = $attrKVarr[0];
            $attrKey   = null;
          }
          elseif( 2 == count( $attrKVarr)) {
            $attrKey   = strtolower( $attrKVarr[0] );
            $attrValue = $attrKVarr[1];
          }
          else {
            $attrKey   = strtolower( $attrKVarr[0] );
            unset( $attrKVarr[0] );
            $attrValue = implode( '=', $attrKVarr );
          }
          if(( 'attach' == $label ) && ( in_array( $attrKey, array( 'fmttype', 'encoding', 'value' )))) {
            $attachInlineBinary = TRUE;
            if( 'fmttype' == $attrKey )
              $attachfmttype = $attrKey.'='.$attrValue;
            continue;
          }
          elseif(( 'categories' == $label ) && ( 'language' == $attrKey ))
            $categoriesAttrLang = $attrKey.'='.$attrValue;
          else {
            $attributes .= ( empty( $attributes )) ? ' ' : $this->attributeDelimiter.' ';
            $attributes .= ( !empty( $attrKey )) ? $attrKey.'=' : null;
            if(( '"' == substr( $attrValue, 0, 1 )) && ( '"' == substr( $attrValue, -1 )))
              $attrValue = substr( $attrValue, 1, ( strlen( $attrValue ) - 2 ));
            $attributes .= '"'.htmlspecialchars( $attrValue ).'"';
          }
        }
      }
      else {
        $attributes = str_replace( $this->intAttrDelimiter, $this->attributeDelimiter, $attributes );
      }
    }
    if(((( 'attach' == $label ) && !$attachInlineBinary ) ||
         ( in_array( $label, array( 'tzurl', 'url' ))))      && ( 'xcal' == $this->format)) {
      $pos = strrpos($content, "/");
      $docname = ( $pos !== false) ? substr( $content, (1 - strlen( $content ) + $pos )) : $content;
      $this->xcaldecl[] = array( 'xmldecl'  => 'ENTITY'
                               , 'uri'      => $docname
                               , 'ref'      => 'SYSTEM'
                               , 'external' => $content
                               , 'type'     => 'NDATA'
                               , 'type2'    => 'BINERY' );
 //          print_r(end($this->xcaldecl)); echo "<br />\n"; // test ###
      $attributes .= ( empty( $attributes )) ? ' ' : $this->attributeDelimiter.' ';
      $attributes .= 'uri="'.$docname.'"';
      $content = null;
      if( 'attach' == $label ) {
        $attributes = str_replace( $this->attributeDelimiter, $this->intAttrDelimiter, $attributes );
        $content = $this->_createElement( 'extref', $attributes, null );
        $attributes = null;
      }
    }
    elseif(( 'attach' == $label ) && $attachInlineBinary && ( 'xcal' == $this->format)) {
      $content = $this->nl.$this->_createElement( 'b64bin', $attachfmttype, $content ); // max one attribute
    }
    $output .= $attributes;
    if( !$content ) {
      switch( $this->format ) {
        case 'xcal':
          $output .= ' /';
          $output .= $this->elementStart2;
          return $output;
          break;
        default:
          $output .= $this->elementStart2;
          return $this->_size75( $output );
          break;
      }
    }
    $output .= $this->elementStart2;
    switch( $label ) {
      case 'categories':
 //   case 'resources': ??
        $output  .= $this->nl;
        $items    = explode(',', $content);
        $content  = null;
        foreach( $items as $item )
          $content .= $this->_createElement( 'item', $categoriesAttrLang, $item );  // max one attribute
        break;
      case 'geo':
        $output  .= $this->nl;
        list($lat, $lon) = explode(';', $content);
        $content  = null;
        $content .= $this->_createElement( 'lat', null, $lat );
        $content .= $this->_createElement( 'lon', null, $lon );
        break;
      default:
        break;
    }
    $output .= $this->valueInit.$content;
    switch( $this->format ) {
      case 'xcal':
        return $output.$this->elementEnd1.$label.$this->elementEnd2;
        break;
      default:
        return $this->_size75( $output );
        break;
    }
  }
/**
 * creates formatted output for calendar component property parameters
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.9.7 - 2006-11-20
 * @param array $params  optional
 * @param array $ctrKeys optional
 * @return string
 */
  function _createParams( $params, $ctrKeys=array() ) {
    $attrLANG = $attr1 = $attr2 = null;
    $CNattrKey   = ( in_array( 'CN',       $ctrKeys )) ? TRUE : FALSE ;
    $LANGattrKey = ( in_array( 'LANGUAGE', $ctrKeys )) ? TRUE : FALSE ;
    $CNattrExist = $LANGattrExist = FALSE;
    if( is_array( $params )) {
      foreach( $params as $paramKey => $paramValue ) {
        if( is_int( $paramKey ))
          $attr2            .= $this->intAttrDelimiter.$paramValue;
        elseif(( 'LANGUAGE' == $paramKey ) && $LANGattrKey ) {
          $attrLANG         .= $this->intAttrDelimiter."LANGUAGE=$paramValue";
          $LANGattrExist     = TRUE;
        }
        elseif(( 'CN'       == $paramKey ) && $CNattrKey ) {
          $attr1             = $this->intAttrDelimiter.'CN="'.$paramValue.'"';
          $CNattrExist       = TRUE;
        }
        elseif(( 'ALTREP'   == $paramKey ) && in_array( $paramKey, $ctrKeys ))
          $attr2            .= $this->intAttrDelimiter.'ALTREP="'.$paramValue.'"';
        elseif(( 'DIR'      == $paramKey ) && in_array( $paramKey, $ctrKeys ))
          $attr2            .= $this->intAttrDelimiter.'DIR="'.$paramValue.'"';
        elseif(( 'SENT-BY'  == $paramKey ) && in_array( $paramKey, $ctrKeys ))
          $attr2            .= $this->intAttrDelimiter.'SENT-BY="MAILTO:'.$paramValue.'"';
        else
          $attr2            .= $this->intAttrDelimiter."$paramKey=$paramValue";
      }
    }
    if( $CNattrExist && !$LANGattrExist && $this->getLanguage())
      $attrLANG .= $this->intAttrDelimiter.'LANGUAGE='.$this->getLanguage();
    elseif( $LANGattrKey && !$LANGattrExist && $this->getLanguage())
      $attrLANG .= $this->intAttrDelimiter.'LANGUAGE='.$this->getLanguage();
    return $attrLANG.$attr1.$attr2;
  }
/**
 * creates formatted output for calendar component property data value type date/date-time
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.9.7 - 2006-11-20
 * @param array $datetime
 * $param int $parno, optional, default 6
 * @return array
 */
  function _format_date_time( $datetime, $parno=6 ) {
    if( !isset( $datetime['year'] )  &&
        !isset( $datetime['month'] ) &&
        !isset( $datetime['day'] )   &&
        !isset( $datetime['hour'] )  &&
        !isset( $datetime['min'] )   &&
        !isset( $datetime['sec'] ))
      return ;
    $output    = array();
    $output[0] = date('Ymd', mktime ( 0, 0, 0
                                    , (integer) $datetime['month']
                                    , (integer) $datetime['day']
                                    , (integer) $datetime['year']));
    if( isset( $datetime['hour'] )  ||
        isset( $datetime['min'] )   ||
        isset( $datetime['sec'] )   ||
        isset( $datetime['tz'] )) {
      if( isset( $datetime['tz'] )  &&
         !isset( $datetime['hour'] ))
        $datetime['hour'] = '0';
      if( isset( $datetime['hour'] )  &&
         !isset( $datetime['min'] ))
        $datetime['min'] = '0';
      if( isset( $datetime['hour'] )  &&
          isset( $datetime['min'] )   &&
         !isset( $datetime['sec'] ))
        $datetime['sec'] = '0';
      $output[1]  = $this->intAttrDelimiter.'VALUE=DATE-TIME';
      foreach( $datetime as $dkey => $dvalue ) {
        if( 'tz' != $dkey )
          $datetime[$dkey] = (integer) $dvalue;
      }
      $output[0] .= date('\THis', mktime ( $datetime['hour']
                                         , $datetime['min']
                                         , $datetime['sec']
                                         , $datetime['month']
                                         , $datetime['day']
                                         , $datetime['year']));
      if( isset( $datetime['tz'] ) && ( '' < trim ( $datetime['tz'] ))) {
        $datetime['tz'] = trim( $datetime['tz'] );
        $offset = 0;
        if( 'Z' == $datetime['tz'] ) {
          $output[0] .= 'Z';
        }
        if((     5  == strlen( $datetime['tz'] )) &&
           ( '0000' <= substr( $datetime['tz'], -4 )) &&
           ( '9999' >= substr( $datetime['tz'], -4 )) &&
             (( '+' == substr( $datetime['tz'], 0, 1 )) ||
              ( '-' == substr( $datetime['tz'], 0, 1 )))) {
          $hours2sec = substr( $datetime['tz'], 1, 2 ) * 3600;
          $min2sec   = substr( $datetime['tz'], -2 )   * 60;
          $sign      = substr( $datetime['tz'], 0, 1 );
          $offset    = -1 * ($sign.'1' * ($hours2sec + $min2sec ));
        }
        elseif(( 7  == strlen( $datetime['tz'] )) &&
         ( '000000' <= substr( $datetime['tz'], -6 )) &&
         ( '999999' >= substr( $datetime['tz'], -6 )) &&
             (( '+' == substr( $datetime['tz'], 0, 1 )) ||
              ( '-' == substr( $datetime['tz'], 0, 1 )))) {
          $hours2sec = substr( $datetime['tz'], 1, 2 ) * 3600;
          $min2sec   = substr( $datetime['tz'], 3, 2 ) *   60;
          $sec       = substr( $datetime['tz'], -2 );
          $sign      = substr( $datetime['tz'], 0, 1 );
          $offset    = -1 * ($sign.'1' * ( $hours2sec + $min2sec + $sec ));
        }
        if( 0 != $offset ) {
          $output[0] = date('Ymd\THis\Z', mktime ( $datetime['hour']
                                                 , $datetime['min']
                                                 , $datetime['sec'] + $offset
                                                 , $datetime['month']
                                                 , $datetime['day']
                                                 , $datetime['year']));
        }
        elseif((  ''  < $datetime['tz'] ) &&
               ( 'Z' != $datetime['tz'] )) {
          $output[2] = $this->intAttrDelimiter.'TZID='.(string) $datetime['tz'];
        }
      }
      elseif( 7 == $parno )
        $output[0] .= 'Z';
    }
    else {
      $output[1] = $this->intAttrDelimiter.'VALUE=DATE';
    }
    return $output;
  }
/**
 * ensures internal date-time/date format for input date-time/date in array format
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.3.0 - 2006-08-15
 * @param array $datetime
 * $param int $parno optional, default FALSE
 * @return array
 */
  function _date_time_array( $datetime, $parno=FALSE ) {
    $output = array();
    foreach( $datetime as $dateKey => $datePart ) {
      switch ( $dateKey ) {
        case '0': case 'year':   $output['year']  = $datePart; break;
        case '1': case 'month':  $output['month'] = $datePart; break;
        case '2': case 'day':    $output['day']   = $datePart; break;
      }
      if( 3 != $parno ) {
        switch ( $dateKey ) {
          case '0':
          case '1':
          case '2': break;
          case '3': case 'hour': $output['hour']  = $datePart; break;
          case '4': case 'min' : $output['min']   = $datePart; break;
          case '5': case 'sec' : $output['sec']   = $datePart; break;
          case '6': case 'tz'  : $output['tz']    = $datePart; break;
        }
      }
    }
    if( 3 != $parno ) {
      if( !isset( $output['hour'] ))
        $output['hour'] = 0;
      if( !isset( $output['min']  ))
        $output['min'] = 0;
      if( !isset( $output['sec']  ))
        $output['sec'] = 0;
    }
    return $output;
  }
/**
 * ensures internal date-time/date format for input date-time/date in string fromat
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.9.9 - 2006-11-28
 * @param array $datetime
 * @param int $parno optional, default FALSE
 * @return array
 */
  function _date_time_string( $datetime, $parno=FALSE ) {
    $datetime = trim( $datetime );
    $tz  = null;
    $len = strlen( $datetime ) - 1;
    if( 'Z' == substr( $datetime, -1 )) {
      $tz = 'Z';
      $datetime = trim( substr( $datetime, 0, $len ));
    }
    elseif( ( ctype_digit( substr( $datetime, -2, 2 ))) && // time or date
            ( '-' == substr( $datetime, -3, 1 )) ||
            ( ':' == substr( $datetime, -3, 1 )) ||
            ( '.' == substr( $datetime, -3, 1 ))) {
      // continue;
    }
    elseif( ( ctype_digit( substr( $datetime, -4, 4 ))) && // 4 pos offset
            ( ' +' == substr( $datetime, -6, 2 )) ||
            ( ' -' == substr( $datetime, -6, 2 ))) {
      $tz = substr( $datetime, -5, 5 );
      $datetime = substr( $datetime, 0, ($len - 5));
    }
    elseif( ( ctype_digit( substr( $datetime, -6, 6 ))) && // 6 pos offset
            ( ' +' == substr( $datetime, -8, 2 )) ||
            ( ' -' == substr( $datetime, -8, 2 ))) {
      $tz = substr( $datetime, -7, 7 );
      $datetime = substr( $datetime, 0, ($len - 7));
    }
    elseif( ( 6 < $len ) && ( ctype_digit( substr( $datetime, -6, 6 )))) {
      // continue;
    }
    elseif( 'T' ==  substr( $datetime, -7, 1 )) {
      // continue;
    }
    else {
      $cx  = $tx = 0;    //  19970415T133000 US-Eastern
      $prevchar = null;
      for( $cx = -1; $cx > ( 9 - $len ); $cx-- ) {
        if(( ctype_alpha( substr( $datetime, $cx, 1 ))) ||
           (       ( ctype_alpha( $prevchar )) &&                     // prev char
                ( '-' ==  substr( $datetime, $cx, 1 )) &&             // this char
           ( ctype_alpha( substr( $datetime, ( $cx - 1) , 1 ))) ) ) { // next char
          $tx++;
          $prevchar = substr( $datetime, $cx, 1 );
        }
        else
          break;
      }
      if( 0 < $tx ) {
        $tz = substr( $datetime, ( 0 - $tx  ));
        $datetime = trim( substr( $datetime, 0, $len - $tx + 1 ));
      }
    }
  //    echo "_date_time_string 1a:  $datetime tz=$tz.<br />\n"; // test ###
    if( 0 < substr_count( $datetime, '-' )) {
      $datetime = str_replace( '-', '/', $datetime );
  //    echo "_date_time_string 1b:  $datetime tz=$tz.<br />\n"; // test ###
    }
    $datestring = date( 'Y-m-d H:i:s', strtotime( $datetime ));
  //    echo "_date_time_string 2:  $datestring tz=$tz.<br />\n"; // test ###
    $output     = array();
    $output['year']    = substr( $datestring, 0, 4 );
    $output['month']   = substr( $datestring, 5, 2 );
    $output['day']     = substr( $datestring, 8, 2 );
    if(( 6 == $parno ) || ( 7 == $parno )) {
      $output['hour']  = substr( $datestring, 11, 2 );
      $output['min']   = substr( $datestring, 14, 2 );
      $output['sec']   = substr( $datestring, 17, 2 );
      if( !empty( $tz ))
        $output['tz']  = $tz;
    }
    elseif( 3 != $parno ) {
      if(( '00' < substr( $datestring, 11, 2 )) ||
         ( '00' < substr( $datestring, 14, 2 )) ||
         ( '00' < substr( $datestring, 17, 2 ))) {
        $output['hour']  = substr( $datestring, 11, 2 );
        $output['min']   = substr( $datestring, 14, 2 );
        $output['sec']   = substr( $datestring, 17, 2 );
      }
      if( !empty( $tz ))
        $output['tz']  = $tz;
    }
    return $output;
  }
/**
 * ensures internal duration format for input in array format
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.3.0 - 2006-08-15
 * @param array $duration
 * @return array
 */
  function _duration_array( $duration ) {
    $output = array();
    foreach( $duration as $durKey => $durValue ) {
      switch ( $durKey ) {
        case '0': case 'week': $output['week']  = $durValue; break;
        case '1': case 'day':  $output['day']   = $durValue; break;
        case '2': case 'hour': $output['hour']  = $durValue; break;
        case '3': case 'min':  $output['min']   = $durValue; break;
        case '4': case 'sec':  $output['sec']   = $durValue; break;
      }
    }
    if( isset( $output['week'] ) && ( 0 < $output['week'] ))
      return $output;
    elseif (( isset( $output['hour'] ) && ( 0 < $output['hour'] )) ||
            ( isset( $output['min'] )  && ( 0 < $output['min']  )) ||
             (isset( $output['sec'] )  && ( 0 < $output['sec']  ))) {
      if( !isset( $output['hour'] ))
        $output['hour'] = 0;
      if( !isset( $output['min']  ))
        $output['min']  = 0;
      if( !isset( $output['sec']  ))
        $output['sec']  = 0;
    }
    return $output;
  }
/**
 * creates formatted output for calendar component property data value type duration
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.7.7 - 2006-09-09
 * @param array $duration ( week, day, hour, min, sec )
 * @return string
 */
  function _format_duration( $duration ) {
    if( !isset( $duration['week'] ) &&
        !isset( $duration['day'] )  &&
        !isset( $duration['hour'] ) &&
        !isset( $duration['min'] )  &&
        !isset( $duration['sec'] ))
      return;
    $output = 'P';
    if( isset( $duration['week'] ) && ( 0 < $duration['week'] ))
      $output .= $duration['week'].'W';
    else {
      if( isset($duration['day'] ) && ( 0 < $duration['day'] ))
        $output .= $duration['day'].'D';
      if(( isset( $duration['hour']) && ( 0 < $duration['hour'] )) ||
         ( isset( $duration['min'])  && ( 0 < $duration['min'] ))  ||
         ( isset( $duration['sec'])  && ( 0 < $duration['sec'] ))) {
        $output .= 'T';
        if( 0 < $duration['hour'] )
          $output .= $duration['hour'];
        else
          $output .= '0';
        $output .= 'H';
        if( 0 < $duration['min'] )
          $output .= $duration['min'];
        else
          $output .= '0';
        $output .= 'M';
        if( 0 < $duration['sec'] )
          $output .= $duration['sec'];
        else
          $output .= '0';
        $output .= 'S';
      }
    }
    return $output;
  }
/**
 * creates formatted output for calendar component property data value type recur
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.9.7 - 2006-11-20
 * @param array $recurlabel
 * @param array $recurdata
 * @return string
 */
  function _format_recur ( $recurlabel, $recurdata ) {
    $recur = null;
    foreach( $recurdata as $therule ) {
      $attributes = ( isset( $therule['xparams'] )) ? $this->_createParams( $therule['xparams'] ) : null;
      $content1  = $content2  = null;
      foreach( $therule['value'] as $rulelabel => $rulevalue ) {
        switch( $rulelabel ) {
          case 'FREQ': {
            $content1 .= "FREQ=$rulevalue";
            break;
          }
          case 'UNTIL': {
            $content2 .= ";UNTIL=";
            $formatted = $this->_format_date_time( $rulevalue );
            $content2 .= $formatted[0];
            break;
          }
          case 'COUNT':
          case 'INTERVAL':
          case 'WKST': {
            $content2 .= ";$rulelabel=$rulevalue";
            break;
          }
          case 'BYSECOND':
          case 'BYMINUTE':
          case 'BYHOUR':
          case 'BYMONTHDAY':
          case 'BYYEARDAY':
          case 'BYWEEKNO':
          case 'BYMONTH':
          case 'BYSETPOS': {
            $content2 .= ";$rulelabel=";
            if( is_array( $rulevalue )) {
              foreach( $rulevalue as $vix => $valuePart ) {
                $content2 .= ( $vix ) ? ',' : null;
                $content2 .= $valuePart;
              }
            }
            else
             $content2 .= $rulevalue;
            break;
          }
          case 'BYDAY': {
            $content2 .= ";$rulelabel=";
            $bydaycnt = 0;
            foreach( $rulevalue as $vix => $valuePart ) {
              $content21 = $content22 = null;
              if( is_array( $valuePart )) {
                $content2 .= ( $bydaycnt ) ? ',' : null;
                foreach( $valuePart as $vix2 => $valuePart2 ) {
                  if( 'DAY' != strtoupper( $vix2 ))
                      $content21 .= $valuePart2;
                  else
                    $content22 .= $valuePart2;
                }
                $content2 .= $content21.$content22;
                $bydaycnt++;
              }
              else {
                $content2 .= ( $bydaycnt ) ? ',' : null;
                if( 'DAY' != strtoupper( $vix ))
                    $content21 .= $valuePart;
                else {
                  $content22 .= $valuePart;
                  $bydaycnt++;
                }
                $content2 .= $content21.$content22;
              }
            }
            break;
          }
          default: {
            $content2 .= ";$rulelabel=$rulevalue";
            break;
          }
        }
      }
      $recur .= $this->_createElement( $recurlabel, $attributes, $content1.$content2 );
    }
    return $recur;
  }
/**
 * create property name case - lower/upper
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.9.7 - 2006-11-20
 * @param string $propertyName
 * @return string
 */
  function _formatPropertyName( $propertyName ) {
    switch( $this->format ) {
      case 'xcal':
        return strtolower( $propertyName );
        break;
      default:
        return strtoupper( $propertyName );
        break;
    }
  }
/*********************************************************************************/
/*********************************************************************************/
/**
 * add calendar component as subcomponent to container for subcomponents
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.3.0 - 2006-08-10
 * @param object $component calendar component
 * @return void
 */
  function addSubComponent ( $component ) {
    $this->subcomponents[]     = $component;
  }
/**
 * creates formatted output for subcomponents
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.9.7 - 2006-11-20
 * @return string
 */
  function createSubComponent() {
    $subcomponents = null;
    foreach( $this->subcomponents as $component ) {
      if( !$component->getLanguage() )
        $component->setLanguage( $this->getLanguage() );
      if( !isset( $component->nl ))
        $component->nl        = $this->nl;
      if( !isset( $component->unique_id ))
        $component->unique_id = $this->unique_id;
      $component->format = $this->format;

      $subcomponents .= $component->createComponent( $this->xcaldecl );
    }
    return $subcomponents;
  }
/*********************************************************************************/
/**
 * get language for calendar component as defined in [RFC 1766]
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.7.36 - 2006-09-14
 * @return string
 */
  function getLanguage( ) {
    if( empty( $this->language ))
      return null;
    else
      return $this->language;
  }
/**
 * set language for calendar component as defined in [RFC 1766]
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.7.8 - 2006-09-10
 * @param string $value
 * @return void
 */
  function setLanguage( $value ) {
    $this->language = $value;
  }

/*********************************************************************************/
/**
 * make default unique_id for calendar prodid, used in _makeUid function
 '
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.7.57 - 2006-09-17
 * @return void
 */
  function _makeUnique_id() {
    $this->unique_id  = gethostbyname( $_SERVER['SERVER_NAME'] );
  }
/**
 * set calendar component property unique_id, used in _makeUid function
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.3.0 - 2006-08-10
 * @param string $value
 * @return void
 */
  function setUnique_id( $value ) {
    $this->unique_id = $value;
  }
/********************************************************************************/
/**
 * break lines at pos 75
 *
 * Lines of text SHOULD NOT be longer than 75 octets, excluding the line
 * break. Long content lines SHOULD be split into a multiple line
 * representations using a line "folding" technique. That is, a long
 * line can be split between any two characters by inserting a CRLF
 * immediately followed by a single linear white space character (i.e.,
 * SPACE, US-ASCII decimal 32 or HTAB, US-ASCII decimal 9). Any sequence
 * of CRLF followed immediately by a single linear white space character
 * is ignored (i.e., removed) when processing the content type.
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.3.0 - 2006-08-10
 * @param string $value
 * @return string
 */
  function _size75( $string ) {
    $strlen = strlen( $string );
    $tmp    = $string;
    $string = null;
    while( $strlen > 75 ) {
      $string .= substr( $tmp, 0, 75 );
      $string .= $this->nl;
      $tmp     = ' '.substr( $tmp, 75 );
      $strlen  = strlen( $tmp );
    }
    $string .= rtrim( $tmp ); // the rest
    if( $this->nl != substr( $string, ( 0 - strlen( $this->nl ))))
      $string .= $this->nl;
    return $string;
  }
/**
 * special characters management
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.3.0 - 2006-08-10
 * @param string $string
 * @return string
 */
  function _strrep( $string ) {
    $string = str_replace('"',        "'",    $string);
    $string = str_replace('\\',       '\\\\', $string);
    $string = str_replace(',',        '\,',   $string);
    $string = str_replace(';',        '\;',   $string);
    $string = str_replace( $this->nl, '\n',   $string);
    return $string;
  }
}

/*********************************************************************************/
/*********************************************************************************/
/**
 * class for calendar component VEVENT
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.3.0 - 2006-08-10
 */
class vevent extends calendarComponent {

/**
 * constructor for calendar component VEVENT object
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.3.0 - 2006-08-10
 * @return void
 */
  function vevent() {
    $this->calendarComponent();
  }

/**
 * create formatted output for calendar component VEVENT object instance
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.9.7 - 2006-11-20
 * @param array $xcaldecl
 * @return string
 */
  function createComponent( & $xcaldecl ) {
    $this->_createFormat();
    $component     = $this->componentStart1.$this->objName.$this->componentStart2.$this->nl;

    $component    .= $this->createAttach();
    $component    .= $this->createAttendee();
    $component    .= $this->createCategories();
    $component    .= $this->createComment();
    $component    .= $this->createContact();
    $component    .= $this->createClass();
    $component    .= $this->createCreated();
    $component    .= $this->createDescription();
    $component    .= $this->createDtend();
    $component    .= $this->createDtstamp();
    $component    .= $this->createDtstart();
    $component    .= $this->createDue();
    $component    .= $this->createDuration();
    $component    .= $this->createExdate();
    $component    .= $this->createExrule();
    $component    .= $this->createGeo();
    $component    .= $this->createLastModified();
    $component    .= $this->createLocation();
    $component    .= $this->createOrganizer();
    $component    .= $this->createPriority();
    $component    .= $this->createRdate();
    $component    .= $this->createRelatedTo();
    $component    .= $this->createRequestStatus();
    $component    .= $this->createRecurrenceid();
    $component    .= $this->createResources();
    $component    .= $this->createRrule();
    $component    .= $this->createSequence();
    $component    .= $this->createStatus();
    $component    .= $this->createSummary();
    $component    .= $this->createTransp();
    $component    .= $this->createUid();
    $component    .= $this->createUrl();
    $component    .= $this->createXprop();

    if( $this->nl != substr( $component, ( 0 - strlen( $this->nl ))))
      $component  .= $this->nl;
    $component    .= $this->createSubComponent();

    $component    .= $this->componentEnd1.$this->objName.$this->componentEnd2;

    if( is_array( $this->xcaldecl ) && ( 0 < count( $this->xcaldecl ))) {
      foreach( $this->xcaldecl as $localxcaldecl )
        $xcaldecl[] = $localxcaldecl;
    }

    return $component;
  }
}

/*********************************************************************************/
/*********************************************************************************/
/**
 * class for calendar component VTODO
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.3.0 - 2006-08-10
 */
class vtodo extends calendarComponent {

/**
 * constructor for calendar component VTODO object
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.3.0 - 2006-08-10
 * @return void
 */
  function vtodo() {
    $this->calendarComponent();
  }

/**
 * create formatted output for calendar component VTODO object instance
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.9.7 - 2006-11-20
 * @param array $xcaldecl
 * @return string
 */
  function createComponent( & $xcaldecl ) {
    $this->_createFormat();
    $component     = $this->componentStart1.$this->objName.$this->componentStart2.$this->nl;

    $component    .= $this->createAttach();
    $component    .= $this->createAttendee();
    $component    .= $this->createCategories();
    $component    .= $this->createClass();
    $component    .= $this->createComment();
    $component    .= $this->createCompleted();
    $component    .= $this->createContact();
    $component    .= $this->createCreated();
    $component    .= $this->createDescription();
    $component    .= $this->createDtstamp();
    $component    .= $this->createDtstart();
    $component    .= $this->createDue();
    $component    .= $this->createDuration();
    $component    .= $this->createExdate();
    $component    .= $this->createExrule();
    $component    .= $this->createGeo();
    $component    .= $this->createLastModified();
    $component    .= $this->createLocation();
    $component    .= $this->createOrganizer();
    $component    .= $this->createPercentComplete();
    $component    .= $this->createPriority();
    $component    .= $this->createRdate();
    $component    .= $this->createRelatedTo();
    $component    .= $this->createRequestStatus();
    $component    .= $this->createRecurrenceid();
    $component    .= $this->createResources();
    $component    .= $this->createRrule();
    $component    .= $this->createSequence();
    $component    .= $this->createStatus();
    $component    .= $this->createSequence();
    $component    .= $this->createSummary();
    $component    .= $this->createUid();
    $component    .= $this->createUrl();
    $component    .= $this->createXprop();

    if( $this->nl != substr( $component, ( 0 - strlen( $this->nl ))))
      $component  .= $this->nl;
    $component    .= $this->createSubComponent();

    $component    .= $this->componentEnd1.$this->objName.$this->componentEnd2;

    if( is_array( $this->xcaldecl ) && ( 0 < count( $this->xcaldecl ))) {
      foreach( $this->xcaldecl as $localxcaldecl )
        $xcaldecl[] = $localxcaldecl;
    }

    return $component;
  }
}
/*********************************************************************************/
/*********************************************************************************/
/**
 * class for calendar component VJOURNAL
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.3.0 - 2006-08-10
 */
class vjournal extends calendarComponent {

/**
 * constructor for calendar component VJOURNAL object
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.3.0 - 2006-08-10
 * @return void
 */
  function vjournal() {
    $this->calendarComponent();
  }

/**
 * create formatted output for calendar component VJOURNAL object instance
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.9.7 - 2006-11-20
 * @param array $xcaldecl
 * @return string
 */
  function createComponent( & $xcaldecl ) {
    $this->_createFormat();
    $component  = $this->componentStart1.$this->objName.$this->componentStart2.$this->nl;

    $component .= $this->createAttendee();
    $component .= $this->createAttach();
    $component .= $this->createCategories();
    $component .= $this->createClass();
    $component .= $this->createComment();
    $component .= $this->createCreated();
    $component .= $this->createDescription();
    $component .= $this->createDtstamp();
    $component .= $this->createDtstart();
    $component .= $this->createExdate();
    $component .= $this->createExrule();
    $component .= $this->createFreebusy();
    $component .= $this->createLastModified();
    $component .= $this->createOrganizer();
    $component .= $this->createRdate();
    $component .= $this->createRequestStatus();
    $component .= $this->createRecurrenceid();
    $component .= $this->createRelatedTo();
    $component .= $this->createRrule();
    $component .= $this->createSequence();
    $component .= $this->createStatus();
    $component .= $this->createSummary();
    $component .= $this->createUid();
    $component .= $this->createUrl();
    $component .= $this->createXprop();

    $component .= $this->componentEnd1.$this->objName.$this->componentEnd2;

    if( is_array( $this->xcaldecl ) && ( 0 < count( $this->xcaldecl ))) {
      foreach( $this->xcaldecl as $localxcaldecl )
        $xcaldecl[] = $localxcaldecl;
    }

    return $component;
  }
}
/*********************************************************************************/
/*********************************************************************************/
/**
 * class for calendar component VFREEBUSY
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.7.3 - 2006-09-09
 */
class vfreebusy extends calendarComponent {

/**
 * constructor for calendar component VFREEBUSY object
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.7.3 - 2006-09-09
 * @return void
 */
  function vfreebusy() {
    $this->calendarComponent();
  }

/**
 * create formatted output for calendar component VFREEBUSY object instance
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.9.7 - 2006-11-20
 * @param array $xcaldecl
 * @return string
 */
  function createComponent( & $xcaldecl ) {
    $this->_createFormat();
    $component  = $this->componentStart1.$this->objName.$this->componentStart2.$this->nl;

    $component .= $this->createAttendee();
    $component .= $this->createComment();
    $component .= $this->createContact();
    $component .= $this->createDtend();
    $component .= $this->createDtstart();
    $component .= $this->createDtstamp();
    $component .= $this->createDuration();
    $component .= $this->createFreebusy();
    $component .= $this->createOrganizer();
    $component .= $this->createRequestStatus();
    $component .= $this->createUid();
    $component .= $this->createUrl();
    $component .= $this->createXprop();

    $component .= $this->componentEnd1.$this->objName.$this->componentEnd2;

    if( is_array( $this->xcaldecl ) && ( 0 < count( $this->xcaldecl ))) {
      foreach( $this->xcaldecl as $localxcaldecl )
        $xcaldecl[] = $localxcaldecl;
    }

    return $component;
  }
}
/*********************************************************************************/
/*********************************************************************************/
/**
 * class for calendar component VALARM
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.3.0 - 2006-08-10
 */
class valarm extends calendarComponent {

/**
 * constructor for calendar component VALARM object
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.3.0 - 2006-08-10
 * @return void
 */
  function valarm() {
    $this->calendarComponent();
  }

/**
 * create formatted output for calendar component VALARM object instance
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.9.7 - 2006-11-20
 * @param array $xcaldecl
 * @return string
 */
  function createComponent( & $xcaldecl ) {
    $this->_createFormat();
    $component     = $this->componentStart1.$this->objName.$this->componentStart2.$this->nl;

    $component    .= $this->createAction();
    $component    .= $this->createAttach();
    $component    .= $this->createAttendee();
    $component    .= $this->createDescription();
    $component    .= $this->createDtstamp();
    $component    .= $this->createDuration();
    $component    .= $this->createRepeat();
    $component    .= $this->createSummary();
    $component    .= $this->createTrigger();
    $component    .= $this->createXprop();

    $component    .= $this->componentEnd1.$this->objName.$this->componentEnd2;

    if( is_array( $this->xcaldecl ) && ( 0 < count( $this->xcaldecl ))) {
      foreach( $this->xcaldecl as $localxcaldecl )
        $xcaldecl[] = $localxcaldecl;
    }

    return $component;
  }
}

/**********************************************************************************
/*********************************************************************************/
/**
 * class for calendar component VTIMEZONE
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.3.0 - 2006-08-13
 */

class vtimezone extends calendarComponent {

  var $timezonetype;

/**
 * constructor for calendar component VTIMEZONE object
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.3.0 - 2006-08-13
 * @param string $timezonetype optional, default FALSE ( STANDARD / DAYLIGHT )
 * @return void
 */
  function vtimezone( $timezonetype=FALSE ) {
    $this->calendarComponent();

    if( !$timezonetype )
      $this->timezonetype = 'VTIMEZONE';
    else
      $this->timezonetype = strtoupper( $timezonetype );
  }
/**
 * create formatted output for calendar component VTIMEZONE object instance
 *
 * @author Kjell-Inge Gustafsson <ical@kigkonsult.se>
 * @since 0.9.7 - 2006-11-20
 * @param array $xcaldecl
 * @return string
 */
  function createComponent( & $xcaldecl ) {
    $this->_createFormat();
    $component     = $this->componentStart1.$this->objName.$this->componentStart2.$this->nl;

    $component    .= $this->createTzid();
    $component    .= $this->createLastModified();
    $component    .= $this->createTzurl();

    $component    .= $this->createDtstart( TRUE );
    $component    .= $this->createTzoffsetfrom();
    $component    .= $this->createTzoffsetto();

    $component    .= $this->createComment();
    $component    .= $this->createRdate( TRUE );
    $component    .= $this->createRrule();
    $component    .= $this->createTzname();
    $component    .= $this->createXprop();

    if( $this->nl != substr( $component, ( 0 - strlen( $this->nl ))))
      $component  .= $this->nl;
    $component    .= $this->createSubComponent();

    $component    .= $this->componentEnd1.$this->objName.$this->componentEnd2;

    if( is_array( $this->xcaldecl ) && ( 0 < count( $this->xcaldecl ))) {
      foreach( $this->xcaldecl as $localxcaldecl )
        $xcaldecl[] = $localxcaldecl;
    }

    return $component;
  }
}
?>