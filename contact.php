<?php
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Initialize variables
$firstName = '';
$lastName = '';
$email = '';
$phone = '';
$message = '';

if (isset($_POST['submit'])) {
    // Get form data
    $firstName = htmlspecialchars($_POST['firstName'] ?? '');
    $lastName = htmlspecialchars($_POST['lastName'] ?? '');
    $email = htmlspecialchars($_POST['email'] ?? '');
    $phone = htmlspecialchars($_POST['phone'] ?? '');
    $message = htmlspecialchars($_POST['message'] ?? '');

    // Validate form data
    $errors = [];
    if (empty($firstName)) $errors[] = "First name is required";
    if (empty($lastName)) $errors[] = "Last name is required";
    if (empty($phone)) $errors[] = "Phone number is required";
    if (empty($message)) $errors[] = "Message is required";
    if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }

    // If no errors, send email
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
            $mail->isHTML(true);
            $mail->Subject = 'New Contact Form Submission';
            $mail->Body = "You have received a new message:\n\n"
                . "First Name: $firstName\n"
                . "Last Name: $lastName\n"
                . "Email: $email\n"
                . "Phone: $phone\n\n"
                . "Message:\n$message\n";

            $mail->send();
            $successMessage = "Thank you! Your message has been sent.";

            // Clear form fields after successful submission
            $firstName = '';
            $lastName = '';
            $email = '';
            $phone = '';
            $message = '';
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
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="stylesheet" href="styles/fonts.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-white font1">
      <!-- Navigation - Fixed at the top -->
  <nav class="Navbar shadow-md z-50 transition-all px-3 duration-300" id="navbar">
    <div class="container mx-auto px-2">
      <div class="flex justify-between items-center h-16">
        <!-- Logo -->
        <a href="/index.html" class="flex-shrink-0 mr-4">
          <img
            src="images/logo.png"
            alt="S2 Logo"
            class="h-12 md:h-16 w-auto max-w-[120px]"
          />
        </a>

        <!-- Mobile Menu Button -->
        <button
          id="mobile-menu-button"
          class="md:hidden text-white focus:outline-none"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-6 w-6"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M4 6h16M4 12h16M4 18h16"
            />
          </svg>
        </button>

        <!-- Desktop Navigation Links -->
        <div class="hidden md:flex md:space-x-2 lg:space-x-5 text-sm lg:text-base">
          <a
            href="/index.html"
            class="nav-line nav-link hover:text-[#8baf30] whitespace-nowrap"
            >Home</a
          >
          <a
            href="/about.html"
            class="nav-line nav-link hover:text-[#8baf30] whitespace-nowrap"
            >About Us</a
          >
          <a
            href="/services.html"
            class="nav-line nav-link hover:text-[#8baf30] whitespace-nowrap"
            >Services</a
          >
          <a
            href="/nutrition.html"
            class="nav-line nav-link hover:text-[#8baf30] whitespace-nowrap"
            >Nutrition</a
          >
          <a
            href="/fitness-retreat.html"
            class="nav-line nav-link hover:text-[#8baf30] whitespace-nowrap"
            >Fitness Retreat</a
          >
          <a
            href="/photos.html"
            class="nav-line nav-link hover:text-[#8baf30] whitespace-nowrap"
            >Photos</a
          >
          <a
            href="/contact.php"
            class="nav-line nav-link hover:text-[#8baf30] whitespace-nowrap"
            >Reach Us</a
          >
        </div>

        <!-- Enroll Button (Desktop) -->
 
        <a href="/enrollment.php"
        class="hidden md:block flex-shrink-0 bg-[#9AC339] text-white px-3 lg:px-6 py-1.5 lg:py-2 rounded-full ml-2 lg:ml-4 text-sm lg:text-base"
      >
        Enroll Now
      </a>
      

      </div>
    </div>
  </nav>

  <!-- Mobile Menu -->
  <div
    class="mobile-menu fixed top-0 left-0 h-full w-full bg-white z-[60] overflow-y-auto transform translate-x-full transition-transform duration-300"
    id="mobile-menu"
  >
    <div class="flex justify-between bg-[#304E0C] items-center border-b">
      <a href="/index.html" class="flex-shrink-0">
        <img
          src="images/logo.png"
          alt="S2 Logo"
          class="h-12 md:h-16 w-auto max-w-[120px]"
        />
      </a>
      <button class="mobile-close-button focus:outline-none text-white">
        <svg
          xmlns="http://www.w3.org/2000/svg"
          class="h-6 w-6"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M6 18L18 6M6 6l12 12"
          />
        </svg>
      </button>
    </div>
    <div class="flex flex-col p-4">
      <a href="/index.html" class="py-4 border-b border-gray-200 text-lg"
        >Home</a
      >
      <a href="/about.html" class="py-4 border-b border-gray-200 text-lg"
        >About Us</a
      >
      <a href="/services.html" class="py-4 border-b border-gray-200 text-lg"
        >Services</a
      >
      <a href="/nutrition.html" class="py-4 border-b border-gray-200 text-lg"
        >Nutrition</a
      >
      <a
        href="/fitness-retreat.html"
        class="py-4 border-b border-gray-200 text-lg"
        >Fitness Retreat</a
      >
      <a href="/photos.html" class="py-4 border-b border-gray-200 text-lg"
        >Photos</a
      >
      <a href="/contact.php" class="py-4 border-b border-gray-200 text-lg"
        >Reach Us</a
      >
      <a
        href="/enrollment.php"
        class="py-4 border-b border-gray-200 text-lg bg-[#9AC339] text-center text-white mt-4 rounded-md"
      >
        Enroll Now
      </a>
    </div>
  </div>


    <!-- Contact Form Section -->
    <div class="flex flex-col p-4 mt-12 md:px-32 lg:flex-row gap-8">
        <!-- Left Section -->
        <div class="w-full lg:w-1/2">
            <div class="flex items-center mb-2 ">
                <div class="w-12 h-1 bg-[#9AC339]"></div>
                <h2 class="content-Heading ml-2">Contact Us</h2>
            </div>
            <p class="text-gray-700 body-text mb-6">Get in Touch – We'd Love to Hear from You!</p>
            
            <h3 class="mb-4 content-Heading flex items-center">
                Visit Us <i class="fas fa-map-marker-alt text-red-500 ml-2"></i>
            </h3>
            
            <div class="w-full h-96 bg-gray-200 mb-6 rounded-md overflow-hidden">
                <div class="mapouter">
                    <div class="gmap_canvas">
                        <iframe class="gmap_iframe" width="100%" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?width=520&amp;height=650&amp;hl=en&amp;q=S2HealthyLife, 4th floor, plot no: 802 & 803, Ayyappa Central, 100 Feet Rd, Beside YSR statue, Ayyappa Society, Mega Hills, Madhapur, Hyderabad, Telangana 500081&amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"></iframe>
                        <a href="https://sprunkin.com/">Sprunki Game</a>
                    </div>
                    <style>.mapouter{position:relative;text-align:right;width:100%;height:650px;}.gmap_canvas {overflow:hidden;background:none!important;width:100%;height:650px;}.gmap_iframe {height:650px!important;}</style>
                </div>
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
                        <label class="block body-text text-gray-700 mb-1">
                            First Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="firstName" placeholder="First Name" value="<?php echo $firstName; ?>"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>
                    
                    <div class="w-full">
                        <label class="block body-text text-gray-700 mb-1">
                            Last Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="lastName" placeholder="Last Name" value="<?php echo $lastName; ?>"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>
                </div>
                
                <div>
                    <label class="block body-text text-gray-700 mb-1">
                        Email Id
                    </label>
                    <input type="email" name="email" placeholder="Email Id" value="<?php echo $email; ?>"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>
                
                <div>
                    <label class="block body-text text-gray-700 mb-1">
                        Phone Number <span class="text-red-500">*</span>
                    </label>
                    <div class="flex">
                        <div class="flex items-center bg-white border border-gray-300 rounded-l-md px-3">
                            <select class="bg-transparent pr-1 py-2 focus:outline-none text-gray-700">
                                <option>+91</option>
                                <option>+61</option>
                                <option>+81</option>
                                <option>+86</option>
                                <option>+49</option>
                                <option>+44</option>
                                <option>+94</option>
                                <option>+41</option>
                                <option>+1</option>
                                <option>+20</option>
                                <option>+20</option>
                                <option>+33</option>
                            </select>
                        </div>
                        <input type="number" maxlength="10" name="phone" placeholder="Phone Number" value="<?php echo $phone; ?>"
                            class="w-full px-3 py-2 border border-gray-300 rounded-r-md focus:outline-none focus:ring-2 focus:ring-green-500 -ml-px">
                    </div>
                </div>
                
                <div>
                    <label class="block body-text text-gray-700 mb-1">
                        Message <span class="text-red-500">*</span>
                    </label>
                    <textarea name="message" rows="5" placeholder="" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"><?php echo $message; ?></textarea>
                </div>
                
                <div class="pt-4">
                    <button type="submit" name="submit" value="submit"
                        class="w-full md:w-auto px-8 py-3 bg-[#9AC339] text-white body-text rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </div>

      <!-- footer start -->
      <footer class="footer bg-[#304E0C] mt-12 text-white p-8 lg:px-20">
      <div class="container mx-auto">
        <div class="lg:flex justify-between items-start">
          <!-- Left Section (Logo and Description) -->
          <div class="footer-left lg:w-1/3 mb-8 lg:mb-0">
            <a href="/index.html"><img src="images/logo.png" alt="Logo" class="mb-4" /></a>
            <p class="body-text mb-4">
              We aim to empower our clients, helping them make sustainable
              lifestyle changes, find joy in exercise, and develop healthy
              eating habits that work for their individual preferences and
              needs.
            </p>
          </div>

          <!-- Middle Section (Pediatric Enquiries and FAQ) -->
          <div class="footer-middle md:ml-[8vw] lg:w-1/4 mb-8 lg:mb-0">
            <div class="contact-info">
              <!-- Dynamic Email with Gmail Link -->
              <p class="flex items-center mb-2">
                <img
                  src="images/logos/email.png"
                  alt="Email"
                  class="w-6 mr-2"
                />
                <a
                  href="https://mail.google.com/mail/?view=cm&fs=1&to=fitness@s2healthylife.com"
                  class="hover:underline"
                  target="_blank"
                  >fitness@s2healthylife.com</a
                >
              </p>
              <!-- Dynamic Phone Numbers -->
              <div class="flex items-center mb-4">
                <img
                  src="images/logos/icons.png"
                  alt="Phone"
                  class="w-6 mr-2"
                />
                <div class="flex flex-col gap-2">
                  <a href="tel:+919949379073" class="hover:underline"
                    >+91 9949379073</a
                  >
                  <a href="tel:+15128100136" class="hover:underline"
                    >+1 (512) 810-0136</a
                  >
                </div>
              </div>
              <!-- Dynamic WhatsApp Numbers -->
              <div class="flex items-center mb-4">
                <img
                  src="images/logos/whatsapp.png"
                  alt="WhatsApp"
                  class="w-6 mr-2"
                />
                <div class="flex flex-col gap-2">
                  <a
                    href="https://wa.me/919949379073"
                    class="hover:underline"
                    target="_blank"
                    >+91 9949379073</a
                  >
                  <a
                    href="https://wa.me/15128100136"
                    class="hover:underline"
                    target="_blank"
                    >+1 (512) 810-0136</a
                  >
                </div>
              </div>
            </div>
            <h4 class="t mb-4 body-text">
              For Pediatric-Related Enquiries
            </h4>
            <p class="flex items-center mb-2">
              <img
                src="images/logos/icons.png"
                alt="Phone"
                class="w-6 mr-2"
              />
              <a href="tel:+918125507159" class="hover:underline"
                >+91 8125507159</a
              >
            </p>
          </div>
          <!-- FAQ start -->
          <div class="footer-middle lg:w-1/4 md:ml-[8vw]">
            <div class="flex flex-col gap-3">
              <p class="body-text">Quick Link</p>
              <a href="faq.html" class="text-white hover:underline mb-4 block"
                >FAQ's</a
              >
            </div>
          </div>
          <!-- FAQ end -->
          <!-- Right Section (Address and Social Links) -->
          <div class="footer-right lg:w-1/3">
            <div class="flex items-start">
              <img
                src="images/logos/location.png"
                alt="Location"
                class="w-6 mr-2"
              />
            <h4 class=" mb-4 body-text">Hyderabad</h4>
            </div>
            <!-- Dynamic Location Link -->
            <p class="flex items-center mb-2">
              
              <a
                href="https://www.google.com/maps/search/?api=1&query=S2HealthyLife,+Ayyappa+Central,+100+Feet+Rd,+Madhapur,+Hyderabad,+Telangana+500081"
                target="_blank"
                class="hover:underline"
              >
                S2HealthyLife, 4th floor, plot no: 802 & 803, Ayyappa Central,
                100 Feet Rd, Beside YSR statue, Ayyappa Society, Mega Hills,
                Madhapur, Hyderabad, Telangana 500081
              </a>
            </p>
            <!-- Social Media Links -->
            <div class="social-icons flex space-x-4 mt-4">
              <a href="https://www.youtube.com/@s2HealthylifeFitness/community" target="_blank" class="block">
                <img
                  src="https://cdn-icons-png.flaticon.com/512/1384/1384060.png"
                  alt="YouTube"
                  class="w-6"
                />
              </a>
              <a href="https://www.instagram.com/s2healthylifeco/" target="_blank" class="block">
                <img
                  src="https://cdn-icons-png.flaticon.com/512/1384/1384063.png"
                  alt="Instagram"
                  class="w-6"
                />
              </a>
              <a href="https://www.facebook.com/people/S2Healthy-Life/61561522904918/?sk=reels_tab" target="_blank" class="block">
                <img
                  src="https://cdn-icons-png.flaticon.com/512/733/733547.png"
                  alt="Facebook"
                  class="w-6"
                />
              </a>
            </div>
          </div>
        </div>

        <!-- Bottom Copyright Section -->
        <div class="text-center border-t border-gray-600 mt-8 pt-4">
          <p class="text-sm">&copy; S2HealthyLife 2023. All rights reserved.</p>
        </div>
      </div>
    </footer>
    <!-- footer end -->

    <script src="js/script.js"></script>
</body>
</html>