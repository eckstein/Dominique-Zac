<?php
$response = array();
/*
 *Handle Email Subscription Form, Use GET instead of POST since Internet Explorer make restriction on POST request
 */
// check email into post data
if (isset($_GET['submit_email'])) {
//    $email = $_GET['email'];  
    $email = filter_var(@$_GET['email'], FILTER_SANITIZE_EMAIL );
    
//    Form validation handles by the server her if required
	/*
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
          $response['error'] = "A valid email is required.";
    }
	*/

    if (!isset($response['error']) || $response['error'] === '') {

//        PROCESS TO STORE EMAIL GOES HERE
		/* in this sample code, emails will be stored in a text file */
		$email = str_replace(array('<','>'),array('&lt;','&gt;'),$email);
        file_put_contents("email.txt", $email . " \r\n", FILE_APPEND | LOCK_EX);

//        End  PROCESS TO STORE EMAIL GOES HERE

        $response['success'] = 'You will be notified';
    }
    $response['email'] = $email;
    echo json_encode($response);    
} 

/*
 *Handle Message From
 */
// check email into post data
else if (isset($_GET['submit_message'])) {
    $email = trim($_GET['email']);
    $name = trim($_GET['name']);
    $message = trim($_GET['message']);

//    Form validation handles by the server her if required
	/*
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response['error']['email'] = "<li>A valid email is required.</li>";
    }
    if (empty($name) || strlen($name) < 3) {
        $response['error']['name'] = '<li>Name is required with at least 3 characters</li>';
    }
    if (empty($message)) {
        $response['error']['message'] = '<li>Empty message is not allowed</li>';
    }
	*/
//    End form validation


    if (!isset($response['error']) || $response['error'] === '') {       

//        PROCESS TO STORE MESSAGE GOES HERE
		/* in this sample code, messages will be stored in a text file */
        $content = "Name: " . $name . " \r\nEmail: " . $email . " \r\nMessage: " . $message;
        $content = str_replace(array('<','>'),array('&lt;','&gt;'),$content);
        file_put_contents("message.txt", $content . "\r\n---------\r\n", FILE_APPEND | LOCK_EX);

//        End  PROCESS TO STORE MESSAGE GOES HERE

        $response['success'] = 'Message sent successfully';
    } else {
        $response['error'] = '<ul>' . $response['error'] . '</ul>';
    }


    $response['email'] = $email;
    echo json_encode($response);
}

