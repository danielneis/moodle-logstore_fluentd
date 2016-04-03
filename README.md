Fluentd Logstore for Moodle
---------------------------

This is a plugin for [Moodle](https://www.moodle.org) that sends all events to a configured [Fluentd](https://www.fluentd.org/) instance.

Install
-------

Put these files at moodle/admin/tool/log/store/fluentd

* You may use composer
* or git clone
* or download the latest version from https://github.com/danielneis/moodle-logstore_fluentd/archive/master.zip

This plugin uses the [fluent/logger](https://packagist.org/packages/fluent/logger) library to record events to Fluentd.

If you downloaded the code from github or have used "git clone", you can install it using composer on the root directory of the plugin with the following command:

    $ composer install

If you have installed the plugin via composer, it may already have downloaded the dependencies.

After puting the files on the correct directory, go to your Moodle site as admin and follow the stepes to get the plugin installed.

This plugin connects to Fluentd via sockets. It does not support the http interface. By default, Fluentd already listen on 24224, so you are all set if you just installed it from official packages.

Usage
-----

After the plugin is installed, make sure you enable it going to Administration block > Site administration > Plugins > Logging > Manage logging stores

Remember that the fluentd has a "flush interval" of 60s by default so you will not see thing immediately if you forward logs to another service.

Dev Info
--------

Please, report issues at: https://github.com/danielneis/moodle-logstore_fluentd/issues

Feel free to send or comment on pull requests at: https://github.com/danielneis/moodle-logstore_fluentd/pulls

[![Build Status](https://travis-ci.org/danielneis/moodle-logstore_fluentd.svg?branch=master)](https://travis-ci.org/danielneis/moodle-logstore_fluentd)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/danielneis/moodle-logstore_fluentd/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/danielneis/moodle-logstore_fluentd/?branch=master)
