<?php
// ---------------------------------------
// Script created by John Brookes
// Copyright John Brookes ©2005
// http://www.gotaxe.com
// ---------------------------------------
// GARP v1.0 (GotAxe? Random Passwords)
// http://www.gotaxe.com/randpass.php
// ---------------------------------------

/*
    ==========================================================================
    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
    ==========================================================================
*/

/*
Convertit a objecte per Antaviana
*/

class garp {
  // The number of textual characters at the beginning of the string
  var $num_text_chars = 6;
  // The number of numeric characters at the end of the password string
  var $num_numeric_chars = 2;
  // Do you want to use lower and UPPER case characters?  If false, only
  // lower case characters will be used.
  var $lower_and_upper = false;

  function _alphabet($innum) {
    if ($this->lower_and_upper) {
      $alphabet = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
      'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
    } else {
      $alphabet = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z');
    }
    return $alphabet[$innum];
  }

  function gen() {
    $a = 0;
    while ($a < $this->num_text_chars) {
      if ($this->lower_and_upper) {
        $random_char[$a] = $this->_alphabet(rand(0,51));
      } else {
        $random_char[$a] = $this->_alphabet(rand(0,25));
      }
      $a++;
    }
    while ($a < ($this->num_text_chars + $this->num_numeric_chars)) {
      $random_char[$a] = rand(0,9);
      $a++;
    }
    $a = 0;
    $random_password = '';
    while ($a < ($this->num_text_chars + $this->num_numeric_chars)) {
      $random_password .= $random_char[$a];
      $a++;
    }
    return $random_password;
  }
}

?>
