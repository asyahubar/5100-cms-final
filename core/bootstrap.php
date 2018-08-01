<?php

session_start();
use Cookbook\Core\Application;
use Cookbook\Database\Connection;
use Cookbook\Database\QueryBuilder;

require 'core/functions.php';

Application::put('config', $config = require "config.php" );

Application::put('database', new QueryBuilder(
    Connection::make($config['database'])
));