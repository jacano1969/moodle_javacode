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
 * Subclass for generating the output of javacode questions.
 *
 * @package    	qtype
 * @subpackage 	javacode
 * @copyright	&copy; 2012 Seth Hobson
 * @author 		Seth Hobson <wshobson@gmail.com>
 * @license    	http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once($CFG->dirroot . '/question/type/pycode/progcode/renderer.php');

class qtype_javacode_renderer extends qtype_progcode_renderer {

	/**
     * Generate the display of the formulation part of the question. This is the
     * area that contains the question text, and the controls for students to
     * input their answers via the Ace code editor <http://ace.ajax.org/>. 
     * Some question types also embed bits of feedback, for example checkmarks, in this area.
     *
     * @param question_attempt $qa the question attempt to display.
     * @param question_display_options $options controls what should and should not be displayed.
     * @return string HTML fragment.
     */
    public function formulation_and_controls(question_attempt $qa, question_display_options $options) {
    	global $PAGE;
    	
    	$PAGE->requires->js('/question/type/javacode/ace/ace.js');
    	$PAGE->requires->js('/question/type/javacode/ace/theme-vibrant_ink.js');
    	$PAGE->requires->js('/question/type/javacode/ace/mode-java.js');
    	
        $question = $qa->get_question();
        $qtext = $question->format_questiontext($qa);
        $testcases = $question->testcases;
        $examples = array_filter($testcases, function($tc) {
            return $tc->useasexample;
        });
        
        if (count($examples) > 0) {
            $qtext .= html_writer::tag('p', 'For example:', array());
            $qtext .= html_writer::start_tag('div', array('class' => 'progcode-examples'));
            $qtext .= $this->formatExamples($examples);
            $qtext .= html_writer::end_tag('div');
        }


        $qtext .= html_writer::start_tag('div', array('class' => 'prompt'));
        $answerprompt = get_string("answer", "quiz") . ': ';
        $qtext .= $answerprompt;
        $qtext .= html_writer::end_tag('div');

        $responsefieldname = $qa->get_qt_field_name('answer');
        $ta_attributes = array(
            'class' => 'progcode-answer',
            'name' => $responsefieldname,
            'id' => $responsefieldname,
            'cols' => 80,
            'rows' => 18,
        );
        
        $ace_attributes = array(
        	'id' => 'ace-editor',
        );

        if ($options->readonly) {
            $ta_attributes['readonly'] = 'readonly';
        }

        $currentanswer = $qa->get_last_qt_var('answer');
        $currentrating = $qa->get_last_qt_var('rating', 0);
        $qtext .= html_writer::tag('textarea', s($currentanswer), $ta_attributes);
        
        $qtext .= html_writer::tag('div', s($currentanswer), $ace_attributes);
        
        if ($qa->get_state() == question_state::$invalid) {
            $qtext .= html_writer::nonempty_tag('div',
            	$question->get_validation_error(array('answer' => $currentanswer)),
            	array('class' => 'validationerror'));
        }
        
        if (SHOW_STATISTICS && isset($question->stats)) {
            $stats = $question->stats;
            $retries = sprintf("%.1f", $stats->average_retries);
            $stats_text = "Statistics: {$stats->attempts} attempts";
            if ($stats->attempts) {
                $stats_text .=
                    " ({$stats->success_percent}% successful)." . 
                    " Average submissions per attempt: {$retries}.";
                if ($stats->likes + $stats->neutrals + $stats->dislikes > 0) {
                    $stats_text .= "<br />" .
                    " Likes: {$stats->likes}. Neutrals: {$stats->neutrals}. Dislikes: {$stats->dislikes}.";
                }
            }
            else {
                $stats_text .= '.';
            }
            $qtext .= html_writer::tag('p', $stats_text);   
        }
        
        $ratingSelector = html_writer::select(
            array(1=>'Like', 2=>'Neutral', 3=>'Dislike'),
            $qa->get_qt_field_name('rating'),
            $currentrating);        
        $qtext .= html_writer::tag('p', 'My rating of this question (optional): ' . $ratingSelector);
        return $qtext;
    }
    
}
