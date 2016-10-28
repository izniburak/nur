<?php
/**
 * Mubu - A simple framework for PHP Developers
 *
 * @package  Mubu
 * @author   İzni Burak Demirtaş <izniburak@gmail.com>
 * @web      <http://burakdemirtas.org>
 */

# Application Configuration File.
$config = [

	# Application Mode { value: development, testing or production }

	'mode' => 'development',


	# Application Folder { default: '' (home directory) }

	'folder' => '',


	# Application Admin Panel Folder { not required. }

	'admin' => 'admin',


	# Application Licence Key { not required }

	'key' => '',


	# Database Configuration

	'db' => [
		'host'		=> 'localhost',
		'driver'	=> 'mysql', // mysql, pgsql, sqlite, oracle
		'database'	=> 'test',
		'username'	=> 'root',
		'password'	=> '',
		'charset'	=> 'utf8',
		'collation'	=> 'utf8_general_ci',
		'prefix'	=> ''
	],


	# Auto Load Libraries, Models and Helpers.

	'autoload' => [
		'helper'	=> ['mubu', 'global'],
		'library'	=> [],
		'model'		=> []
	],


	# TOKEN Security Hash

	'_token' => sha1((uniqid(mt_rand(), true))),


	# Default Timezone Settings

	'timezone' => 'Europe/Istanbul'

];
