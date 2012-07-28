<?php
/**
 * Unit tests for this question type.
 *
 * @copyright &copy; 2012 Seth Hobson
 * @author wshobson@gmail.com
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License
 * @package hobson_questiontypes
 *//** */
    
defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/question/type/description/questiontype.php');

class coder_qtype_test extends UnitTestCase {
    
    protected $qtype;
    
    public function setUp() {
        $this->qtype = new coder_qtype();
    }
    
    public function tearDown() {
        $this->qtype = null;    
    }

    public function test_name() {
        $this->assertEqual($this->qtype->name(), 'coder');
    }
    
    // TODO write unit tests for the other methods of the question type class.
}
