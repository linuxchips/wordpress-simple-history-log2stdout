<?php
/**
 * Plugin Name: Simple History Log2stdout
 * Text Domain: simple-history-log2stdout
 * Description: An addon to the Simple History plugin to send log on the stdout, suitable for container logging (e.g. docker or openshift).
 * Version: 1
 * Requires at least: 6.6
 * Requires PHP: 7.4
 * Author: Ali al-Charchafchi
 *
 * @package Simple History Log2stdout
 */

// do not anonymized the IPs, just return false
function no_anonymized($value) {
	return false;
}

add_filter( 'simple_history/privacy/anonymize_ip_address', 'no_anonymized', PHP_INT_MAX, 1);


// write the log to stdout
function log2stdout ($context, $data, $logger) {
	$log_entry = json_encode(array( $data, $context ));
	file_put_contents('php://stdout', $log_entry, FILE_APPEND | LOCK_EX);
}
add_action( 'simple_history/log/inserted', 'log2stdout', 1, 3);
