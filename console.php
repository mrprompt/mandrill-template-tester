#!/usr/bin/env php
<?php
use MrPrompt\Mandrill\Console\Template\TemplateCommand;
use Symfony\Component\Console\Application;

require 'bootstrap.php';

/* @var $application \Symfony\Component\Console\Application */
$application = new Application();
$application->add(new TemplateCommand('template:test'));
$application->run();
