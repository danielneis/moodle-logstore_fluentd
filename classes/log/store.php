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
 * Template log writer
 *
 * @package    logstore_fluentd
 * @copyright  2015 Daniel Neis (based on standard log store from Petr Skoda)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


namespace logstore_fluentd\log;

global $CFG;

require_once($CFG->dirroot.'/admin/tool/log/store/fluentd/vendor/autoload.php');
require_once($CFG->dirroot.'/lib/filelib.php');

use Fluent\Autoloader,
    Fluent\Logger\FluentLogger;

Autoloader::register();

defined('MOODLE_INTERNAL') || die();


class store implements \tool_log\log\writer  {
    use \tool_log\helper\store,
        \tool_log\helper\reader;

    /** @var string $logguests true if logging guest access */
    protected $logguests;

    private $logger;

    public function __construct(\tool_log\log\manager $manager) {
        $this->helper_setup($manager);
        // Log everything before setting is saved for the first time.
        $this->logguests = $this->get_config('logguests', 1);
        $this->buffersize = 0;
        $this->logger = new FluentLogger($this->get_config('fluentd_url', 'localhost'), $this->get_config('fluentd_port', 24224));
    }

    /**
     * Should the event be ignored (== not logged)?
     * @param \core\event\base $event
     * @return bool
     */
    protected function is_event_ignored(\core\event\base $event) {
        if ((!CLI_SCRIPT or PHPUNIT_TEST) and !$this->logguests) {
            // Always log inside CLI scripts because we do not login there.
            if (!isloggedin() or isguestuser()) {
                return true;
            }
        }
        return false;
    }
    public function write(\core\event\base $event) {
        $this->logger->post($this->get_config('fluentd_tag', 'fluentd.moodle'), (array)$event);
    }

    /**
     * Write one event to the store.
     *
     * @param \core\event\base $evententries
     * @return void
     */
    public function insert_event_entries($evententries) {
        foreach ($evententries as $e) {
            $this->write($e);
        }
    }

    /**
     * Fetch records using given criteria returning a Traversable object.
     *
     * Note that the traversable object contains a moodle_recordset, so
     * remember that is important that you call close() once you finish
     * using it.
     *
     * @param string $selectwhere
     * @param array $params
     * @param string $sort
     * @param int $limitfrom
     * @param int $limitnum
     * @return \core\dml\recordset_walk|\core\event\base[]
     */
    public function get_events_select_iterator($selectwhere, array $params, $sort, $limitfrom, $limitnum) {
        return null;
    }

    /**
     * Returns an event from the log data.
     *
     * @param \stdClass $data Log data
     * @return \core\event\base
     */
    public function get_log_event($data) {
        return null;
    }

    public function get_events_select_count($selectwhere, array $params) {
        return null;
    }

    public function get_internal_log_table_name() {
        return false;
    }

    /**
     * Are the new events appearing in the reader?
     *
     * @return bool true means new log events are being added, false means no new data will be added
     */
    public function is_logging() {
        // Only enabled stpres are queried,
        // this means we can return true here unless store has some extra switch.
        return true;
    }

    public function dispose() {
    }
}
