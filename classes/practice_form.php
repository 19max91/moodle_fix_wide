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

/**
 * practice page form
 *
 * @package    local_practice
 * @copyright  2022 onwards WIDE Services  {@link https://www.wideservices.gr}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();
//require_once(__DIR__ . '/../lib.php');
require_once("$CFG->libdir/formslib.php");

class practice_form extends moodleform {
    public function definition() {
        $mform = $this->_form;

       $mform->addElement('text','firstname','First name');
       $mform->setType('firstname',PARAM_TEXT);

       $mform->addElement('text','lastname','Last name');
       $mform->setType('lastname',PARAM_TEXT);

       $mform->addElement('text','email','Email');
       $mform->setType('email',PARAM_EMAIL);

        $this->add_action_buttons(false,'Add record');
    }
}