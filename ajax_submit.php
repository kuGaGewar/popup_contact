<?php
// Admin recipient email id
$toEmail = 'batti.schmidt@hotmail.com';

$status = 0;
$statusMsg = 'Oops! Something went wrong! Please try again later.';
if(isset($_POST['contact_submit'])){
    // Get the submitted form data
    $email = $_POST['email'];
    $name = $_POST['name'];
    $message = $_POST['message'];
    
    // Check whether submitted data is not empty
    if(!empty($email) && !empty($name) && !empty($message)){
        
        if(filter_var($email, FILTER_VALIDATE_EMAIL) === false){
            $statusMsg = 'Please enter a valid email.';
        }else{
            $emailSubject = 'Contact Request Submitted by '.$name;
            $htmlContent = 'Contact Request Submitted
                Name'.$name.'
                Email'.$email.'
                Message'.$message.'';
            
            // Set content-type header for sending HTML email
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            
            // Additional headers
            $headers .= 'From: '.$name.'<'.$email.'>'. "\r\n";
            
            // Send email
            $sendEmail = mail($toEmail, $emailSubject, $htmlContent, $headers);
            if($sendEmail){
                $status = 1;
                $statusMsg = 'Thanks! Your contact request has been submitted successfully.';
            }else{
                $statusMsg = 'Failed! Your contact request submission failed, please try again.';
            }
        }
    }else{
        $statusMsg = 'Please fill in all the mandatory fields.';
    }
}

$response = array(
    'status' => $status,
    'message' => $statusMsg
);
echo json_encode($response);
?>
