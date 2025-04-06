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
 * local practice's index page
 *
 * @package    local_practice
 * @copyright  2022 onwards WIDE Services  {@link https://www.wideservices.gr}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
use local_practice\output\main;
require(__DIR__ . '/../../config.php');
require_once(__DIR__ . '/classes/practice_form.php');


$url = new moodle_url('/local/practice/index.php');
$PAGE->set_url($url);
$context = context_system::instance();
$PAGE->set_context($context);

$PAGE->set_title(get_string('practicetitle','local_practice'));
$PAGE->set_heading(get_string('practicetitle', 'local_practice'));

$mform = new practice_form(null);
if($fromform=$mform->get_data()){
    if((($fromform->firstname)=="") or (($fromform->lastname)=="") or (($fromform->email)=="")){ //ERROR, added simple form validation to prevent empty records for getting into the db 
        redirect(new moodle_url('/local/practice/index.php'));
        
    }
    else{
        $insertrecord=new stdClass();
        $insertrecord->firstname=$fromform->firstname; 
        $insertrecord->lastname=$fromform->lastname; //ERROR, firstname added twice, changed firstname to lastname, similar error to main.mustache
        $insertrecord->email=$fromform->email;
        $insertrecord->timecreated=time(); //ERROR, wrong day one less, removed -86400
        $insertrecord->timemodified=time(); //ERROR, timemodified must not be NULL, used the same as created until later change
        $DB->insert_record('local_practice',$insertrecord);
        redirect(new moodle_url('/local/practice/index.php')); //ERROR, redirection to wrong path, change lndex.php to index.php

    }
    
}else{
    $indexview=new main();
    echo $OUTPUT->header();
    echo $OUTPUT->render($indexview);
    $mform->display();
    echo $OUTPUT->footer();
}



