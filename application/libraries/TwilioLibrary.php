<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Doctrine\ORM\EntityManager;

class TwilioLibrary
{
    protected $CI;
    protected $entityManager;
    private $sid;  // Replace with your Account SID
    private $token;  // Replace with your Auth Token
    private $twilio_number;  // Replace with your Twilio phone number

    public function __construct()
    {
        // Get CodeIgniter instance
        $this->CI =& get_instance();

        // Load the EntityManager (Doctrine ORM)
        $this->entityManager = $this->CI->doctrine->em;

         // Load environment variables
            $this->sid = $_ENV['TWILIO_SID'];
            $this->token = $_ENV['TWILIO_TOKEN'];
            $this->twilio_number = $_ENV['TWILIO_NUMBER'];
    }

    public function send_mobile_otp($to_number,$otp)
    {
  
        // Message to be sent
        $message = "Hello, this is a Login OTP: $otp";
        // Initialize cURL session
        $ch = curl_init();

        // Set cURL options
        curl_setopt($ch, CURLOPT_URL, 'https://api.twilio.com/2010-04-01/Accounts/' . $this->sid . '/Messages.json');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
            'From' => $this->twilio_number,
            'To' => $to_number,
            'Body' => $message
        ]));
        curl_setopt($ch, CURLOPT_USERPWD, $this->sid . ':' . $this->token); // Basic Auth

        // Execute the cURL request
        $response = curl_exec($ch);
        // Check for errors
        if (curl_errno($ch)) {
            $error = 'cURL error: ' . curl_error($ch);
            curl_close($ch);
            return ['success' => false, 'error' => $error];
        } else {
            curl_close($ch);
            // Optionally, you can save OTP to the database using Doctrine
            // Example: $this->saveOtpToDatabase($otp, $to_number);
            return ['success' => true, 'response' => $response, 'otp' => $otp];
        }
    }

    // // Optional function to save OTP to the database
    // private function saveOtpToDatabase($otp, $phone_number)
    // {
    //     // Implement the logic to save the OTP to the database using Doctrine ORM
    //     // Example: Create an entity and persist it to the database
    // }
}
