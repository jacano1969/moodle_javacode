<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.
 
defined('MOODLE_INTERNAL') || die();

/**
 * Defines the editing form for the pycode question type.
 *
 * @package 	qtype
 * @subpackage 	javacode
 * @copyright 	&copy; 2012 Seth Hobson
 * @author 		Seth Hobson <wshobson@gmail.com>
 * @license 	http://www.gnu.org/copyleft/gpl.html GNU Public License
 */

require_once($CFG->dirroot . '/question/type/pycode/progcode/edit_progcode_form.php');

class qtype_javacode_edit_form extends qtype_progcode_edit_form {

    public function qtype() {
        return 'javacode';
    }
}