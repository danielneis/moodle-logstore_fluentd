Fluentd Logstore for Moodle
---------------------------

This is a plugin for [Moodle](https://www.moodle.org) that sends all events to a configured [Fluentd](https://www.fluentd.org/) instance.

This plugin uses the [fluent/logger](https://packagist.org/packages/fluent/logger) library to record events to Fluentd. You can install it using composer on the root directory of the plugin with the following command:

    $ composer install

Any problems, please fill an issue at: https://github.com/danielneis/moodle-logstore_fluentd/issues

Feel free to send or comment on pull requests at: https://github.com/danielneis/moodle-logstore_fluentd/pulls

[![Build Status](https://travis-ci.org/danielneis/moodle-logstore_fluentd.svg?branch=master)](https://travis-ci.org/danielneis/moodle-logstore_fluentd)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/danielneis/moodle-logstore_fluentd/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/danielneis/moodle-logstore_fluentd/?branch=master)
