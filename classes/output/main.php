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
 * Output/main  file for local_practice
 *
 * @package   local_practice
 * @copyright 2022 onwards WIDE Services  {@link https://www.wideservices.gr}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_practice\output;
defined('MOODLE_INTERNAL') || die();

use renderer_base;
use moodle_url;

/**
 * Class main
 *
 * @package   local_practice
 * @copyright 2022 onwards WIDE Services  {@link https://www.wideservices.gr}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class main implements \renderable, \templatable {

    /**
     * Renders the data for export to template
     *
     * @param renderer_base $output
     * @return array
     * @throws \dml_exception
     */
    public function export_for_template(renderer_base $output) {
        global $DB, $OUTPUT;

        $records=$DB->get_records('local_practice');
        $data=array();

        foreach($records as $record){
            $timecreated=date('d/m/Y H:i:s',$record->timecreated);
            
            $timemodified=date('d/m/Y H:i:s',$record->timemodified); //ERROR, no timemodified record variable, added
            $data[]=array('firstname'=>$record->firstname,'lastname'=>$record->lastname,'email'=>$record->email, 'timecreated'=>$timecreated, 'timemodified'=>$timemodified );//ERROR, missing timecreated and timemodified records, added them
        }
        return array('data'=>$data);
    }
}
