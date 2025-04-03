<?php
 
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
 
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
 
// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);
// print_r($mail);
class Mailer{
    private $mail;
    public function __construct()
    {
        $this->mail = new PHPMailer(true);
    }
    public function test_send(){
        try {
            //Server settings
            $this->mail->SMTPDebug = SMTP::DEBUG_SERVER;// Enable verbose debug output 
            $this->mail->isSMTP();// gửi mail SMTP
            $this->mail->Host = 'smtp.gmail.com';// Set the SMTP server to send through
            $this->mail->SMTPAuth = true;// Enable SMTP authentication
            $this->mail->Username = 'huyhoiden@gmail.com';// SMTP username
            $this->mail->Password = 'ptnpqbxfzaijexqv'; // SMTP password
            $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;// Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
            $this->mail->Port = 587; // TCP port to connect to
         
            //Recipients
            $this->mail->setFrom('huyhoiden@gmail.com', 'Mailer'); // sender
            
            $this->mail->addAddress('khongnoluc@gmail.com', 'Nguyễn Huy'); // Add a recipient
            // $this->mail->addAddress('ellen@example.com'); // Name is optional
            // send many ppl
            // $this->mail->addReplyTo('info@example.com', 'Information');
            $this->mail->addCC('huyhoiden@gmail.com'); // backup mail
            // $this->mail->addBCC('bcc@example.com');
         
            // Attachments đính kèm đường dẫn
            // $this->mail->addAttachment('/var/tmp/file.tar.gz'); // Add attachments
            // $this->mail->addAttachment('/tmp/image.jpg', 'new.jpg'); // Optional name
         
            // Content
            $this->mail->isHTML(true);   // Set email format to HTML
            $this->mail->Subject = 'Test mail';
            $this->mail->Body = 'Nội dung mail <b>Hello</b>';
            // $this->mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
         
            $this->mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$this->mail->ErrorInfo}";
        }
    } // end test

    public function sendOrder($recipient, $name_rep, $orderCode, $total, $orderDetails){
        try{
            $this->mail->SMTPDebug = SMTP::DEBUG_SERVER;// Enable verbose debug output 
            $this->mail->isSMTP();// gửi mail SMTP
            $this->mail->Host = 'smtp.gmail.com';// Set the SMTP server to send through
            $this->mail->SMTPAuth = true;// Enable SMTP authentication
            $this->mail->Username = 'huyhoiden@gmail.com';// SMTP username
            $this->mail->Password = 'ptnpqbxfzaijexqv'; // SMTP password
            $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;// Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
            $this->mail->Port = 587; // TCP port to connect to

            $this->mail->setFrom('huyhoiden@gmail.com', 'Mailer'); // sender

            $this->mail->addAddress($recipient, $name_rep); // Add a recipient
            $this->mail->addCC('huyhoiden@gmail.com'); // backup mail
            $this->mail->isHTML(true);   // Set email format to HTML
            $this->mail->Subject = 'Order Successfully';
            $this->mail->Body = "
            <h3>Chào $name_rep</h3>
            <p>Cảm ơn bạn đã đặt hàng tại cửa hàng của chúng tôi!</p>
            <p><strong>Mã đơn hàng:</strong> $orderCode</p>
            <h4>Chi tiết đơn hàng:</h4>
            <table border='1' style='border-collapse: collapse; width: 100%;'>
                <thead>
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Kích thước</th>
                        <th>Số lượng</th>
                        <th>Giá</th>
                    </tr>
                </thead>
                <tbody>
                    $orderDetails
                </tbody>
            </table>
            <p>Tổng tiền: $total</p>
            <p>Mọi thắc mắc, vui lòng liên hệ chúng tôi qua email hoặc số hotline.</p>
            <p>Trân trọng,BlazeShop</p>";
            $this->mail->send();
        }catch(Exception $e){
            echo "Khong gui mail dc. Mailer Error: {$this->mail->ErrorInfo}";
        }
    }// end sendOrder

    public function sendAcessToken($title, $content, $addressMail)
    {




        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = 0;                      //Enable verbose debug output
            $mail->isSMTP();
            $mail->CharSet = 'utf-8';                                         //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'minhkhanhv23@gmail.com';                     //SMTP username
            $mail->Password   = 'sirm wtha trkl luyf';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('minhkhanhv23@gmail.com', 'BLAZE Store');
            $mail->addAddress($addressMail);     //Add a recipient
            // $mail->addAddress('ellen@example.com');               //Name is optional
            // $mail->addReplyTo('info@example.com', 'Information');
            // $mail->addCC('cc@example.com');
            // $mail->addBCC('bcc@example.com');

            // //Attachments
            // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = $title;
            $mail->Body    = $content;
            // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
