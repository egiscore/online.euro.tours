<?php
 use Phalcon\Cli\Task; class GenerateTask extends Task { public function modelAction($args) { } protected function colorize($string) { return "\033[1;33m{$string}\033[1;37m"; } } 