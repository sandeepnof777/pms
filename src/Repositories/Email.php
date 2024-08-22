<?php
namespace Pms\Repositories;

use Pms\RepositoryAbstract;

$url =  "http://local.pms.pavementlayers.com/";
require_once APPPATH."phpmail/PHPMailer-master/src/PHPMailer.php";
require_once APPPATH."phpmail/PHPMailer-master/src/SMTP.php";
require_once APPPATH."phpmail/PHPMailer-master/src/Exception.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


/**
 * Unified Class for sending emails out
 * It will be easy to swap providers or cron the emails out in a queue
 * Class Email
 * @package Pms\Repositories
 */
class Email extends RepositoryAbstract
{
    protected $sendgrid = null;
    private $contentType = 'text/html';

    private $fromEmail = '';
    private $fromName = '';
    private $subject = '';
    private $content = '';
    private $toEmail = '';
    private $additionalEmails;
    private $replyTo;
    private $categories;
    private $uniqueArg;
    private $uniqueArgVal;
    private $uniqueArg2;
    private $uniqueArg2Val;
    private $attachments;

    /**
     * @return \SendGrid
     */
    public function getSendgridInstance()
    {
        if ($this->sendgrid === null) {
            $this->sendgrid = new \SendGrid($_ENV['SENDGRID_API_KEY']);
        }
        return $this->sendgrid;
    }

    public function sendSystemEmail($emailId, $to, $data)
    {
        $this->ci->load->model('system_email');
        $this->ci->system_email->sendEmail($emailId, $to, $data);
    }

    /**
     * @param array $emailData
     */
    private function setParameters(Array $emailData)
    {
         $this->fromEmail = @$emailData['fromEmail'];
        $this->fromName = @$emailData['fromName'];
        $this->subject = @$emailData['subject'];
        $this->content = @$emailData['body'];
        $this->toEmail = @$emailData['to'];
        $this->additionalEmails = @$emailData['bcc'];
        $this->replyTo = @$emailData['replyTo'];
        $this->categories = @$emailData['categories'];
        $this->uniqueArg = @$emailData['uniqueArg'];
        $this->uniqueArgVal = @$emailData['uniqueArgVal'];
        $this->uniqueArg2= @$emailData['uniqueArg2'];
        $this->uniqueArg2Val = @$emailData['uniqueArg2Val'];
        $this->uniqueArg3= @$emailData['uniqueArg3'];
        $this->uniqueArg3Val = @$emailData['uniqueArg3Val'];
        $this->attachments = @$emailData['attachments'];
    }

    private function hasParameters()
    {
        if (
            empty($this->fromEmail) ||
            empty($this->fromName) ||
            empty($this->subject) ||
            empty($this->content) ||
            empty($this->toEmail)
        ) {
            return false;
        }

        return true;
    }

    /**
     * Make sure that the 'to' field is an email address string and not an array
     * We DO NOT SEND CCs/BCCs - use a separate Email
     * @param array $emailData
     * @return boolean | void
     */
    // public function send(array $emailData)
    // {
    //     $this->setParameters($emailData);

    //     if (!$this->hasParameters()) {
    //         return false;
    //     }

    //     // Build the email using the API v3
    //     $from = new \SendGrid\Email($this->fromName, $this->fromEmail);
    //     $to = new \SendGrid\Email("", $this->toEmail);
    //     $content = new \SendGrid\Content($this->contentType, $this->content);
    //     $mail = new \SendGrid\Mail($from, $this->subject, $to, $content);

    //     // Set ReplyTo if applicable
    //     if ($this->replyTo) {
    //         $replyTo = new \SendGrid\Email(null, $this->replyTo);
    //         $mail->setReplyTo($replyTo);
    //     }

    //     // Add categories if we have them
    //     if (is_array($this->categories)) {
    //         if (PROD) {
    //             foreach ($this->categories as $category) {
    //                 $mail->addCategory($category);
    //             }
    //         }
    //         else {
    //             $mail->addCategory('Testing');
    //         }
    //     }

    //     // Unique Args
    //     if ($this->uniqueArg && $this->uniqueArgVal) {
    //         if (PROD) {
    //             $mail->addCustomArg(strval($this->uniqueArg), strval($this->uniqueArgVal));
    //         }
    //     }

    //     if ($this->uniqueArg2 && $this->uniqueArg2Val) {
    //         if (PROD) {
    //             $mail->addCustomArg(strval($this->uniqueArg2), strval($this->uniqueArg2Val));
    //         }
    //     }
    //     if ($this->uniqueArg3 && $this->uniqueArg3Val) {
    //         if (PROD) {
    //             $mail->addCustomArg(strval($this->uniqueArg3), strval($this->uniqueArg3Val));
    //         }
    //     }

    //     if ($this->attachments) {
            
    //         $filename = basename($this->attachments);
    //         $file_encoded = base64_encode(file_get_contents($this->attachments));
    //         $attachment = new \SendGrid\Attachment();
    //         $attachment->setType("application/pdf");
    //         $attachment->setContent($file_encoded);
    //         $attachment->setDisposition("attachment");
    //         $attachment->setFilename($filename);
    //         $mail->addAttachment($attachment);
    //     }


    //     $response = $this->getSendgridInstance()->client->mail()->send()->post($mail);

    //     return $response;
    // }

   
    // public function send(array $emailData)
    // {
        
    // $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
   
    // try {
    //     $this->setParameters($emailData);
    //     if (!$this->hasParameters()) {
    //         return false;
    //     }
    //     $mail->SMTPDebug = SMTP::DEBUG_SERVER;
    //     $mail->isSMTP();
    //     $mail->Host = 'smtp.gmail.com';
    //     $mail->SMTPAuth = true;
    //     $mail->Username = 'svimsoftrivet@gmail.com';
    //     $mail->Password = 'gcsb yxvg nbds iguc';
    //     $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Use STARTTLS
    //     $mail->Port = 587;
    //     $mail->setFrom('svimsoftrivet@gmail.com', $this->fromName);
    //     $mail->addAddress($this->toEmail, 'Admin');
    //     $mail->addReplyTo($this->replyTo, 'Information');

    //     if ($this->attachments) {
    //         foreach ($this->attachments as $attachment) {
    //             $mail->addAttachment($attachment['path'], $attachment['name']);
    //         }
    //     }
    //     // Content
    //     $mail->isHTML(true);
    //     $mail->Subject = $this->subject;
    //     $mail->Body = $this->content;
    //     $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    //     // Send email
    //     if (!$mail->send()) {
    //         // Log error and return false
    //         error_log("Error sending email: {$mail->ErrorInfo}");
    //         return false;
    //     }
    //     return true; // Email sent successfully
    // } catch (Exception $e) {
    //     // Log error and return false
    //     error_log("Error sending email: {$e->getMessage()}");
    //     return false;
    // }
    // }
  

    public function send(array $emailData)
    {
        
        $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
        try {
            $this->setParameters($emailData);
            if (!$this->hasParameters()) {
                return false;
            }
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'svimsoftrivet@gmail.com';
            $mail->Password = 'gcsb yxvg nbds iguc';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Use STARTTLS
            $mail->Port = 587;
            $mail->setFrom('svimsoftrivet@gmail.com', $this->fromName);
            $mail->addAddress($this->toEmail, 'Admin');
            $mail->addReplyTo($this->replyTo, 'Information');

                //     // Add categories if we have them
                if (is_array($this->categories)) {
                    if (PROD) {
                        foreach ($this->categories as $category) {
                            $mail->addCategory($category);
                        }
                    }
                    else {
                       // $mail->addCategory('Testing');
                    }
                }

                // Unique Args
                if ($this->uniqueArg && $this->uniqueArgVal) {
                    if (PROD) {
                        $mail->addCustomArg(strval($this->uniqueArg), strval($this->uniqueArgVal));
                    }
                }

                if ($this->uniqueArg2 && $this->uniqueArg2Val) {
                    if (PROD) {
                        $mail->addCustomArg(strval($this->uniqueArg2), strval($this->uniqueArg2Val));
                    }
                }
                if ($this->uniqueArg3 && $this->uniqueArg3Val) {
                    if (PROD) {
                        $mail->addCustomArg(strval($this->uniqueArg3), strval($this->uniqueArg3Val));
                    }
                }
            
            
            // if ($this->attachments) {
            //     foreach ($this->attachments as $attachment) {
            //         $mail->addAttachment($attachment['path'], $attachment['name']);
            //     }
            // }

            if ($this->attachments) {
                foreach ($this->attachments as $attachment) {
                    $file_encoded = base64_encode(file_get_contents($attachment['path']));
                    $mail->addStringAttachment(base64_decode($file_encoded), $attachment['name'], 'base64', 'application/pdf');
                }
            }
            

            // Add attachments

            // Convert base64 images to inline attachments and update HTML content
            
            // preg_match_all('/src="data:image\/(.*?);base64,(.*?)"/', $this->content, $matches, PREG_SET_ORDER);
            // foreach ($matches as $match) {
            //     $imageType = $match[1];
            //     $imageData = base64_decode($match[2]);
            //     $cid = 'image_' . uniqid() . '.' . $imageType;
            //     $mail->addStringEmbeddedImage($imageData, $cid, $cid, 'base64', 'image/' . $imageType);
            //     // Update the image source in the HTML content with the CID
            //     $this->content = str_replace($match[0], 'src="cid:' . $cid . '"', $this->content);
            // }

                // Content
            $mail->isHTML(true);
            $mail->Subject = $this->subject;
            $mail->Body = $this->content;
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';     
            // Send email
            if (!$mail->send()) {
                // Log error and return false
                error_log("Error sending email: {$mail->ErrorInfo}");
                return false;
            }
            return true; // Email sent successfully
        } catch (Exception $e) {
            // Log error and return false
            error_log("Error sending email: {$e->getMessage()}");
            return false;
        }
    }
    
 
    

        /**
     * Make sure that the 'to' field is an email address string and not an array
     * We DO NOT SEND CCs/BCCs - use a separate Email
     * @param array $emailData
     * @return boolean | void
     */
    public function tryToSend(array $emailData)
    {
        try {
            $this->setParameters($emailData);
            
            if (!$this->hasParameters()) {
                return false;
            }

            // Build the email using the API v3
            $from = new \SendGrid\Email($this->fromName, $this->fromEmail);
            $to = new \SendGrid\Email("", $this->toEmail);
            $content = new \SendGrid\Content($this->contentType, $this->content);
            $mail = new \SendGrid\Mail($from, $this->subject, $to, $content);

            // Set ReplyTo if applicable
            if ($this->replyTo) {
                $replyTo = new \SendGrid\Email(null, $this->replyTo);
                $mail->setReplyTo($replyTo);
            }

            // Add categories if we have them
            if (is_array($this->categories)) {
                if (PROD) {
                    foreach ($this->categories as $category) {
                        $mail->addCategory($category);
                    }
                }
                else {
                    $mail->addCategory('Testing');
                }
            }

            // Unique Args
            if ($this->uniqueArg && $this->uniqueArgVal) {
                if (PROD) {
                    $mail->addCustomArg(strval($this->uniqueArg), strval($this->uniqueArgVal));
                }
            }

            if ($this->uniqueArg2 && $this->uniqueArg2Val) {
                if (PROD) {
                    $mail->addCustomArg(strval($this->uniqueArg2), strval($this->uniqueArg2Val));
                }
            }
            if ($this->uniqueArg3 && $this->uniqueArg3Val) {
                if (PROD) {
                    $mail->addCustomArg(strval($this->uniqueArg3), strval($this->uniqueArg3Val));
                }
            }


            $response = $this->getSendgridInstance()->client->mail()->send()->post($mail);

            $return =array(
                'status'    => true,
                'response' => $response,
                'error_message' => '',
            );
            return $return;
        } catch (\Exception $e) {
            $return =array(
                'status'        => false,
                'error_message' => $e->getMessage(),
            );
            log_message('debug','Failed job:'.$e->getMessage());
            
            return $return;
        } 
        
    }

    public function sendOtp(array $emailData)
    {
        
        $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
        try {
            $this->setParameters($emailData);
            if (!$this->hasParameters()) {
                return false;
            }
           // $mail->SMTPDebug = SMTP::DEBUG_SERVER;
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'svimsoftrivet@gmail.com';
            $mail->Password = 'gcsb yxvg nbds iguc';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Use STARTTLS
            $mail->Port = 587;
            $mail->setFrom('svimsoftrivet@gmail.com', $this->fromName);
            $mail->addAddress($this->toEmail, 'Admin');
        if (!empty($this->replyTo) && filter_var($this->replyTo, FILTER_VALIDATE_EMAIL)) {
            $mail->addReplyTo($this->replyTo, 'Information');
        }   
                // Content
            $mail->isHTML(true);
            $mail->Subject = $this->subject;
            $mail->Body = $this->content;
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';     
            // Send email
            if (!$mail->send()) {
                // Log error and return false
               // error_log("Error sending email: {$mail->ErrorInfo}");
                return false;
            }
            return true; // Email sent successfully
        } catch (Exception $e) {
            // Log error and return false
           // error_log("Error sending email: {$e->getMessage()}");
            return false;
        }
    }
}