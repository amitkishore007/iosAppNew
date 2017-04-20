<?php
Apple push Notification service 

1. 5 "items" we are going to send  
	Device Token
	Payload
	Notification Identifier
	Expiration Date
	Priority

2.each "item" will contains ID, length, data

3.used "http://php.net/manual/en/function.pack.php" to encode given arguments into binarny data

4.id 1 is device token of length 32 bytes 
 "e.g"
	// Id of 1
	chr(1)
	// The length (32 bytes)
	. pack('n', 32)
	// Hex String of Device Token
	. pack('H*', $deviceToken);

5. id 2 is Payload ("data that we are going to send") 
   "e.g"
   $payload = json_encode([
	    'aps' => [
	        'alert' => 'Hello World',
	        'sound' => 'default',
	        'badge' => 1 //badge count 
	    ]
	]);

   // Id of 2
	chr(2)
	// Length of the payload
	. pack('n', strlen($payload))
	// Payload that we're sending
	. $payload

6. id 3 is notification identifier should be unique, this has a length of 4

	// Id of 3
	chr(3)
	// Length of integer is 4
	. pack('n', 4)
	// Pack notifier to length of 4
	. pack('N', $token->id)

7. id 4 is Expiration Date to idenfity when the notification is no longer valid

	// Id of 4
	chr(4)
	// Length of 4
	. pack('n', 4)
	// Set expiration to 1 day from now
	. pack('N', time() + 86400)

8.id 5 is priority this identifies the priority that the notification is sent with. In most cases, this will be set to 10, but you have the option to send a value of 5 which will send at a time that conserves the power on the device.

 	// Id of 5
	chr(5)
	// Length of 1
	. pack('n', 1)
	// Send immediately
	. chr(10);

9. after all the above steps inner section is complete

	$inner = 
	      chr(1)
	    . pack('n', 32)
	    . pack('H*', $token->value)

	    . chr(2)
	    . pack('n', strlen($payload))
	    . $payload

	    . chr(3)
	    . pack('n', 4)
	    . pack('N', $token->id)

	    . chr(4)
	    . pack('n', 4)
	    . pack('N', time() + 86400)

	    . chr(5)
	    . pack('n', 1)
	    . chr(10);

10.With that, we can construct the rest, which is a command value of 2, followed by the length of the $inner and then the actual $inner value:

	$notification = 
      chr(2)
    . pack('N', strlen($inner))
    . $inner;

11.Sending Notification

	if ($production) {
	    $gateway = 'gateway.push.apple.com:2195';
	} else { 
	    $gateway = 'gateway.sandbox.push.apple.com:2195';
	}

	// Create a Stream
	$ctx = stream_context_create();
	// Define the certificate to use 
	stream_context_set_option($ctx, 'ssl', 'local_cert', '/certificates/mycert.pem');
	// Passphrase to the certificate
	stream_context_set_option($ctx, 'ssl', 'passphrase', 'codular-test');

	// Open a connection to the APNS server
	$fp = stream_socket_client(
	    $gateway, $err,
	    $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

	// Check that we've connected
	if (!$fp) {
	    die("Failed to connect: $err $errstr");
	}

	// Ensure that blocking is disabled
	stream_set_blocking($fp, 0);

	// Send it to the server
	$result = fwrite($fp, $notification, strlen($notification));

	// Close the connection to the server
	fclose($fp);



//*********************************************************//
//**************************APNS***************************//
//*********************************************************//

// 	// authentication
// $host   = "localhost";
// $user   = "db_username";
// $pass   = "db_password";
// $dbname = "db_name";

// // create connection with database
// $con = mysql_connect($host,$user,$pass);

// // check whether database connection is successful 
// if (!$con) {
// // if connection not successful then stop the script and show the error
// die('Could not connect to database: ' . mysql_error());
// } else {
// // if database connection successful then select the database
// mysql_select_db($dbname, $con);
// }

// get the id, token from database
$result = mysql_query("SELECT id,token FROM `device_tokens` ORDER BY id");

//Setup notification message
$body = array();
$body['aps'] = array('alert' => 'This is push message');
$body['aps']['notifurl'] = 'http://www.mydomain.com';
$body['aps']['badge'] = 2;

//Setup stream (connect to Apple Push Server)
$ctx = stream_context_create();
stream_context_set_option($ctx, 'ssl', 'passphrase', 'password_for_apns.pem_file');
stream_context_set_option($ctx, 'ssl', 'local_cert', 'apns_pem_certificate.pem');
$fp = stream_socket_client('ssl://gateway.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT, $ctx);
    stream_set_blocking ($fp, 0); 
// This allows fread() to return right away when there are no errors. But it can also miss errors during 
//  last  seconds of sending, as there is a delay before error is returned. Workaround is to pause briefly 
// AFTER sending last notification, and then do one more fread() to see if anything else is there.

if (!$fp) {
//ERROR
 echo "Failed to connect (stream_socket_client): $err $errstrn";

} else {

// Keep push alive (waiting for delivery) for 90 days
$apple_expiry = time() + (90 * 24 * 60 * 60); 

// Loop thru tokens from database
while($row = mysql_fetch_array($result)) {
	
	$apple_identifier = $row["id"];
	$deviceToken = $row["token"];
	$payload = json_encode($body);
	            
// Enhanced Notification
	$msg = pack("C", 1) . pack("N", $apple_identifier) . pack("N", $apple_expiry) . pack("n", 32) . pack('H*', str_replace(' ', '', $deviceToken)) . pack("n", strlen($payload)) . $payload; 
            
// SEND PUSH
	fwrite($fp, $msg);

// We can check if an error has been returned while we are sending, but we also need to 
// check once more after we are done sending in case there was a delay with error response.
	checkAppleErrorResponse($fp); 
}

// Workaround to check if there were any errors during the last seconds of sending.
// Pause for half a second. 
// Note I tested this with up to a 5 minute pause, and the error message was still available to be retrieved
usleep(500000); 

checkAppleErrorResponse($fp);

echo 'Completed';

mysql_close($con);
fclose($fp);

}

