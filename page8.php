<?php
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (isset($_POST['submit'])) {
    $firstName = htmlspecialchars($_POST['firstName'] ?? '');
    $lastName = htmlspecialchars($_POST['lastName'] ?? '');
    $email = htmlspecialchars($_POST['email'] ?? '');
    $phone = htmlspecialchars($_POST['phone'] ?? '');
    $message = htmlspecialchars($_POST['message'] ?? '');

    $errors = [];
    if (empty($firstName)) $errors[] = "First name is required";
    if (empty($lastName)) $errors[] = "Last name is required";
    if (empty($phone)) $errors[] = "Phone number is required";
    if (empty($message)) $errors[] = "Message is required";
    if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }

    if (empty($errors)) {
        $mail = new PHPMailer(true);
        try {
            // SMTP Configuration
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'vyoma.x23@gmail.com'; // Your Gmail address
            $mail->Password = 'ecpdjzgkvrdkdbmt'; // Use Google App Password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Sender & Recipient
            $mail->setFrom('saigoud1710@gmail.com', 'Your Name'); 
            $mail->addAddress('your-email@example.com'); // Your email
            if (!empty($email)) {
                $mail->addReplyTo($email, "$firstName $lastName");
            }

            // Email Content
            $mail->isHTML(false);
            $mail->Subject = 'New Contact Form Submission';
            $mail->Body = "You have received a new message:\n\n"
                . "First Name: $firstName\n"
                . "Last Name: $lastName\n"
                . "Email: $email\n"
                . "Phone: $phone\n\n"
                . "Message:\n$message\n";

            $mail->send();
            $successMessage = "Thank you! Your message has been sent.";
        } catch (Exception $e) {
            $errors[] = "Mailer Error: " . $mail->ErrorInfo;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-white font-sans">
    <div class="container mx-auto px-4 py-8 max-w-7xl">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Left Section -->
            <div class="w-full lg:w-1/2">
                <div class="flex items-center mb-2">
                    <div class="w-12 h-1 bg-green-500"></div>
                    <h2 class="text-2xl font-bold ml-2">Contact Us</h2>
                </div>
                <p class="text-gray-700 mb-6">Get in Touch – We'd Love to Hear from You!</p>
                
                <h3 class="text-xl font-bold mb-4 flex items-center">
                    Visit Us 
                    <i class="fas fa-map-marker-alt text-red-500 ml-2"></i>
                </h3>
                
                <div class="w-full h-96 bg-gray-200 mb-6 rounded-md overflow-hidden">
                    <img src="images/page_8/map.png" alt="Map location" class="w-full h-full object-cover">
                </div>
            </div>
            
            <!-- Right Section - Form -->
            <div class="w-full lg:w-1/2 bg-white p-6 rounded-lg shadow-md">
                <?php if(isset($errors) && !empty($errors)): ?>
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4">
                        <ul class="list-disc pl-4">
                            <?php foreach($errors as $error): ?>
                                <li><?php echo $error; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
                
                <?php if(isset($successMessage)): ?>
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4">
                        <?php echo $successMessage; ?>
                    </div>
                <?php endif; ?>
                
                <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="space-y-4">
                    <div class="flex flex-col md:flex-row gap-4">
                        <div class="w-full">
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                First Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="firstName" placeholder="First Name" value="<?php echo $firstName ?? ''; ?>"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                        </div>
                        
                        <div class="w-full">
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Last Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="lastName" placeholder="Last Name" value="<?php echo $lastName ?? ''; ?>"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Email Id
                        </label>
                        <input type="email" name="email" placeholder="Email Id" value="<?php echo $email ?? ''; ?>"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Phone Number <span class="text-red-500">*</span>
                        </label>
                        <div class="flex">
                            <div class="flex items-center bg-white border border-gray-300 rounded-l-md px-3">
                                <select class="bg-transparent pr-1 py-2 focus:outline-none text-gray-700">
                                    <option>+91</option>
                                </select>
                                <i class="fas fa-chevron-down text-xs text-gray-500 ml-1"></i>
                            </div>
                            <input type="tel" name="phone" placeholder="Phone Number" value="<?php echo $phone ?? ''; ?>"
                                class="w-full px-3 py-2 border border-gray-300 rounded-r-md focus:outline-none focus:ring-2 focus:ring-green-500 -ml-px">
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Message <span class="text-red-500">*</span>
                        </label>
                        <textarea name="message" rows="5" placeholder="" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"><?php echo $message ?? ''; ?></textarea>
                    </div>
                    
                    <div class="pt-4">
                        <button type="submit" name="submit" value="submit"
                            class="w-full md:w-auto px-8 py-3 bg-green-500 text-white font-medium rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>