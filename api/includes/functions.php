<?php

function strip_zeros_from_date($marked_string="") {
	//first remove the marked zeros
	$no_zeros = str_replace('*0', '', $marked_string);
	//then remove any remaining marks
	$cleaned_string = str_replace("*", '', $no_zeros);

	return $cleaned_string;
}

function redirect_to($location = NULL) {
	if($location != NULL) {
		header("Location: {$location}");
		exit();
	}
}

function output_message($message = "") {
	if(!empty($message))
		return "<p class=\"message\">{$message}</p>";
	else
		return "";
}


//Php looks for this function to include php files if it is missing. 
function __autoload($class_name) {
	$class_name = strtolower($class_name);
	$path = LIB_PATH.DS."{$class_name}.php";
	if(file_exists($path)) {
		require_once($path);
	} else {
		die("The file {$class_name}.php could not be found.");
	}

}

function getPath() {
	return $_SERVER['SCRIPT_NAME'];
}

function getIP() {
	return $_SERVER['REMOTE_ADDR'];
}

function resetEmail($email, $message) {
	$toEmail = 'omar@devscheme.com';

	$subject = 'Reset Top Dog Daycare Password';
	$headers = 'From: '.$toEmail. "\r\n" .
	    'Reply-To: '.$toEmail. "\r\n" .
	    'X-Mailer: PHP/' . phpversion();
	    
	$body = $message.'\r\n';

	mail($email, $subject, $body, $headers);
	  
}

?>