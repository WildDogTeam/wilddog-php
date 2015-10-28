<?php
	require_once '../autoload.php';

	const DEFAULT_URL = 'https://tquest.wilddogio.com/';
	const DEFAULT_TOKEN = 's1jnrOk8EyYa1u1CgPAGZLg3eKDZpFQOF91Yu3SK';
	const DEFAULT_PATH = '/php/example';
	
	$wilddog = new \Wilddog\WilddogLib(DEFAULT_URL, DEFAULT_TOKEN);
	
	// --- storing an array ---
	$test = array(
			"foo" => "bar",
			"i_love" => "lamp",
			"id" => 42
	);
	$dateTime = new DateTime();
	$wilddog->set(DEFAULT_PATH . '/' . $dateTime->format('c'), $test);
	
	// --- storing a string ---
	$wilddog->set(DEFAULT_PATH . '/name/contact001', "John Doe");
	
	// --- reading the stored string ---
	$name = $wilddog->get(DEFAULT_PATH . '/name/contact001');
	echo $name;
	
	$test = array(
			"update" => "update",
			"id" => 45
	);
	$wilddog->update(DEFAULT_PATH, $test);
	
	$wilddog->push(DEFAULT_PATH, $test);
	
?>