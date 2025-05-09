<?php
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$errors = [];
$successMessage = '';

// Initialize variables to avoid "Undefined variable" warnings
$firstName = $lastName = $phone = $dob = $address = $emergencyName = $relationship = $emergencyPhone = '';
$fitnessLevel = $healthcareProfessional = $healthcareDetails = $medicalConditions = $medicalDetails = '';
$surgeries = $surgeryDetails = $physicalLimitations = $limitationDetails = '';
$formDate = $under18 = $guardianName = $guardianRelationship = $signature = $guardianSignature = '';

// Consent for Social Media
$fullNameConsent = $firstNameOnlyConsent = $nicknameConsent = $noNameConsent = '';
$groupPhotoConsent = $individualPhotoConsent = $compensationConsent = '';

if (isset($_POST['submit'])) {
    // Collect form data
    $firstName = htmlspecialchars($_POST['firstName'] ?? '');
    $lastName = htmlspecialchars($_POST['lastName'] ?? '');
    $phone = htmlspecialchars($_POST['phone'] ?? '');
    $dob = htmlspecialchars($_POST['dob'] ?? '');
    $address = htmlspecialchars($_POST['address'] ?? '');
    $emergencyName = htmlspecialchars($_POST['emergencyName'] ?? '');
    $relationship = htmlspecialchars($_POST['relationship'] ?? '');
    $emergencyPhone = htmlspecialchars($_POST['emergencyPhone'] ?? '');
    $fitnessLevel = htmlspecialchars($_POST['fitnessLevel'] ?? '');
    $healthcareProfessional = htmlspecialchars($_POST['healthcareProfessional'] ?? '');
    $healthcareDetails = htmlspecialchars($_POST['healthcareDetails'] ?? '');
    $medicalConditions = htmlspecialchars($_POST['medicalConditions'] ?? '');
    $medicalDetails = htmlspecialchars($_POST['medicalDetails'] ?? '');
    $surgeries = htmlspecialchars($_POST['surgeries'] ?? '');
    $surgeryDetails = htmlspecialchars($_POST['surgeryDetails'] ?? '');
    $physicalLimitations = htmlspecialchars($_POST['physicalLimitations'] ?? '');
    $limitationDetails = htmlspecialchars($_POST['limitationDetails'] ?? '');
    $formDate = htmlspecialchars($_POST['formDate'] ?? '');
    $under18 = htmlspecialchars($_POST['under18'] ?? '');
    $guardianName = htmlspecialchars($_POST['guardianName'] ?? '');
    $guardianRelationship = htmlspecialchars($_POST['guardianRelationship'] ?? '');
    $signature = htmlspecialchars($_POST['signature'] ?? ''); // Full name as signature
    $guardianSignature = htmlspecialchars($_POST['guardianSignature'] ?? ''); // Guardian full name as signature

    // Consent for Social Media
    $fullNameConsent = isset($_POST['fullName']) ? 'Yes' : 'No';
    $firstNameOnlyConsent = isset($_POST['firstNameOnly']) ? 'Yes' : 'No';
    $nicknameConsent = isset($_POST['nickname']) ? 'Yes' : 'No';
    $noNameConsent = isset($_POST['noName']) ? 'Yes' : 'No';
    $groupPhotoConsent = isset($_POST['groupPhoto']) ? $_POST['groupPhoto'] : '';
    $individualPhotoConsent = isset($_POST['individualPhoto']) ? $_POST['individualPhoto'] : '';
    $compensationConsent = isset($_POST['compensation']) ? $_POST['compensation'] : '';

    // Validation
    if (empty($firstName)) $errors[] = "First name is required";
    if (empty($lastName)) $errors[] = "Last name is required";
    if (empty($phone)) $errors[] = "Phone number is required";
    if (empty($dob)) $errors[] = "Date of birth is required";
    if (empty($address)) $errors[] = "Address is required";
    if (empty($emergencyName)) $errors[] = "Emergency contact name is required";
    if (empty($relationship)) $errors[] = "Relationship is required";
    if (empty($emergencyPhone)) $errors[] = "Emergency contact phone number is required";
    if (empty($fitnessLevel)) $errors[] = "Fitness level is required";
    if (empty($healthcareProfessional)) $errors[] = "Healthcare professional status is required";
    if ($healthcareProfessional === 'Yes' && empty($healthcareDetails)) $errors[] = "Healthcare details are required";
    if (empty($medicalConditions)) $errors[] = "Medical conditions status is required";
    if ($medicalConditions === 'Yes' && empty($medicalDetails)) $errors[] = "Medical details are required";
    if (empty($surgeries)) $errors[] = "Surgeries status is required";
    if ($surgeries === 'Yes' && empty($surgeryDetails)) $errors[] = "Surgery details are required";
    if (empty($physicalLimitations)) $errors[] = "Physical limitations status is required";
    if ($physicalLimitations === 'Yes' && empty($limitationDetails)) $errors[] = "Limitation details are required";
    if (empty($formDate)) $errors[] = "Date is required";
    if (empty($under18)) $errors[] = "Under 18 status is required";
    if ($under18 === 'Yes' && (empty($guardianName) || empty($guardianRelationship) || empty($guardianSignature))) {
        $errors[] = "Guardian information is required for participants under 18";
    }
    if ($under18 === 'No' && empty($signature)) {
        $errors[] = "Full name (signature) is required";
    }

    // Consent for Social Media Validation
    if (!isset($_POST['fullName']) && !isset($_POST['firstNameOnly']) && !isset($_POST['nickname']) && !isset($_POST['noName'])) {
        $errors[] = "At least one Authorization for Name Usage option is required";
    }
    if (empty($groupPhotoConsent)) {
        $errors[] = "Group Photo Consent is required";
    }
    if (empty($individualPhotoConsent)) {
        $errors[] = "Individual Photo Consent is required";
    }
    if (empty($compensationConsent)) {
        $errors[] = "Compensation Consent is required";
    }

    if (empty($errors)) {
        $mail = new PHPMailer(true);
        try {
            // SMTP Configuration
            $mail->isSMTP();
            $mail->Host = 'localhost'; // GoDaddy SMTP relay
            $mail->SMTPAuth = false;  // No authentication required
            $mail->Port = 25;  // Default GoDaddy SMTP port
            $mail->SMTPSecure = false; // No SSL/TLS
            // Sender & Recipient
            $mail->setFrom('fitnesstestemail@s2healthylife.com', 'Your Name'); 
            $mail->addAddress('fitness@s2healthylife.com'); // Your email

            // Email Content
            $mail->isHTML(true);
            $mail->Subject = 'New Enrollment Form Submission';
            $mail->Body = "
    <p>You have received a new enrollment form submission:</p>
    <p><strong>Participant Information </strong></p>
    <p><strong>First Name:</strong> $firstName</p>
    <p><strong>Last Name:</strong> $lastName</p>
    <p><strong>Phone Number:</strong> $phone</p>
    <p><strong>DOB:</strong> $dob</p>
    <p><strong>Address:</strong> $address</p>
    <p><strong>Emergency Contact Information: </strong> </p>
    <p><strong>Full Name:</strong> $emergencyName</p>
    <p><strong>Relationship:</strong> $relationship</p>
    <p><strong>Phone Number:</strong> $emergencyPhone</p>
    <p><strong>Fitness Level and Readiness:</strong></p>
    <p><strong>Current Fitness Level:</strong> $fitnessLevel</p>
    <p><strong>Are you currently under the care of healthcare professional? :</strong> $healthcareProfessional</p>
    <p><strong>Provide details about your healthcare professional:</strong> $healthcareDetails</p>
    <p><strong>Do you have any known medical conditions or injuries that may affect your ability to exercise? :</strong> $medicalConditions</p>
    <p><strong>Provide details about your medical conditions:</strong> $medicalDetails</p>
    <p><strong>Have you recently undergone any surgeries or medical procedures?:</strong> $surgeries</p>
    <p><strong>Provide details about your surgeries:</strong> $surgeryDetails</p>
    <p><strong>Are you aware of any physical limitations or restrictions that may impact your participation in exercise
 activities? :</strong> $physicalLimitations</p>
    <p><strong>Provide details about your physical limitations:</strong> $limitationDetails</p>
   <p>By completing this section, you acknowledge that the provided information is accurate and that you have disclosed any relevant 
health conditions  or concerns that may affect your participation in the exercise program.</p>
   
     <p><strong>Release and Waiver of Liability:</strong> I, the undersigned participant, hereby release S2Healthylife management, staff, and trainers conducting the exercise program from any liability or responsibility for injuries, accidents, or damages that may occur during or as a result of participation in the exercise activities.</p>
    <p><strong>Indemnification:</strong> The participants agrees indemnify and hold harmless S2Healthlife management, staff and trainers conducting the exercise program from any claims, damages or losses arising from their participation.</p>
    <p><strong>Consent to Emergency Medical Treatment:</strong>I give my consent to receive emergency medical treatment if required during the exercise program.</p>
    <p><strong>Consent for Social Media:</strong></p>
    <p>By participating in the S2Healthylife program, I consent to the following:</p>
    <p>Authorization for Name Usage:</p>
    <p><strong>Full Name:</strong> $fullNameConsent</p>
    <p><strong>First Name Only:</strong> $firstNameOnlyConsent</p>
    <p><strong>Use a Nickname:</strong> $nicknameConsent</p>
    <p><strong>Do Not Use Any Name:</strong> $noNameConsent</p>
    <p><strong>Can Use Picture in Group Photos or Videos:</strong> $groupPhotoConsent</p>
    <p><strong>Permission to Use Individual Photos or Videos: </strong> $individualPhotoConsent</p>
    <p><strong>I understand that I will not receive any monetary compensation for the use of photos or videos :</strong> $compensationConsent</p>
    
    <p><strong>Date:</strong> $formDate</p>
    <p><strong>Is the participant under 18 years of age?:</strong> $under18</p>
    <p><strong>Parent / Guardian Name:</strong> $guardianName</p>
    <p><strong>Relationship to Participant:</strong> $guardianRelationship</p>
    <p><strong>" . ($under18 === 'Yes' ? 'Signature of Parent / Guardian' : 'Signature') . ":</strong> " . ($under18 === 'Yes' ? $guardianSignature : $signature) . "</p>
    
";
            $mail->send();
            $successMessage = "Thank you! Your enrollment form has been submitted.";

            // Reset form fields
            $firstName = $lastName = $phone = $dob = $address = $emergencyName = $relationship = $emergencyPhone = '';
            $fitnessLevel = $healthcareProfessional = $healthcareDetails = $medicalConditions = $medicalDetails = '';
            $surgeries = $surgeryDetails = $physicalLimitations = $limitationDetails = '';
            $formDate = $under18 = $guardianName = $guardianRelationship = $signature = $guardianSignature = '';
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
    <title>S2Healthylife Enrollment Form</title>
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.js"></script>
    <link rel="stylesheet" href="styles/fonts.css">
    <link rel="stylesheet" href="styles/styles.css">

<style>
/* Remove dropdown arrows from date inputs */
input[type="date"]::-webkit-calendar-picker-indicator,
input[type="text"].datepicker::-webkit-calendar-picker-indicator {
    display: none;
    -webkit-appearance: none;
}

/* Additional styles for wider browser compatibility */
input[type="text"].datepicker {
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
}
</style>
    
</head>


<body class="bg-white font1 text-gray-800">
       <!-- nav section start -->
    <!-- Navigation - Fixed at the top -->
    <nav
      class="Navbar shadow-md z-50 transition-all px-3 duration-300"
      id="navbar"
    >
      <div class="container mx-auto px-2">
        <div class="flex justify-between items-center py-2">
          <!-- Logo -->
          <a href="/index.html" class="flex-shrink-0 md:mr-2 lg:mr-4">
            <img
              src="images/logo.png"
              loading="lazy"
              alt="S2 Logo"
              class="h-12 md:h-16 w-[120px]"
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
          <div
            class="hidden md:flex md:space-x-1 lg:space-x-5 text-sm lg:text-base"
          >
            <a
              href="/index.html"
              class="nav-line nav-link lg:text-[16px] hover:text-[#8baf30] whitespace-nowrap"
              >Home</a
            >
            <a
              href="/about.html"
              class="nav-line nav-link lg:text-[16px] hover:text-[#8baf30] whitespace-nowrap"
              >About Us</a
            >
            <a
              href="/services.html"
              class="nav-line nav-link lg:text-[16px] hover:text-[#8baf30] whitespace-nowrap"
              >Services</a
            >
            <a
              href="/nutrition.html"
              class="nav-line nav-link lg:text-[16px] hover:text-[#8baf30] whitespace-nowrap"
              >Nutrition</a
            >
            <a
              href="/fitness-retreat.html"
              class="nav-line nav-link lg:text-[16px] hover:text-[#8baf30] whitespace-nowrap"
              >Fitness Retreat</a
            >
            <a
              href="/photos.html"
              class="nav-line nav-link lg:text-[16px] hover:text-[#8baf30] whitespace-nowrap"
              >Photos</a
            >
            <a
              href="/contact.php"
              class="nav-line nav-link lg:text-[16px] hover:text-[#8baf30] whitespace-nowrap"
              >Reach Us</a
            >
          </div>

          <!-- Enroll Button (Desktop) -->

          <a
            href="/enrollment.php"
            class="hidden md:block lg:text-[16px] flex-shrink-0 bg-[#9AC339] text-white px-3 lg:px-6 py-1.5 lg:py-2 rounded-full ml-2 lg:ml-4 "
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
            loading="lazy"
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

    <!-- nav section end -->
    <!-- Header -->
    <div class="pb-2 mb-6 mt-20 md:px-16 px-8 lg:px-32">
    <div class="flex items-center mb-2">
                    <div class="w-12 h-1 bg-[#9AC339]"></div>
                    <h2 class="content-Heading ml-2">Enrollment Form</h2>
                </div>
        <p class="text-sm mt-1">S2Healthylife Client Intake Waiver, Social Media Waiver, and Release of Liability Form</p>
    </div>

    <!-- Form -->
     <div class="md:px-16 px-8 mb-12 lg:px-32">
     <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="space-y-8 max-w-7xl p-2">
        <!-- Error and Success Messages -->
        <?php if (!empty($errors)): ?>
            <div class="bg-red-100  border-l-4 border-red-500 text-red-700 p-4 mb-4">
                <ul class="list-disc pl-4">
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo $error; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if (!empty($successMessage)): ?>
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4">
                <?php echo $successMessage; ?>
            </div>
        <?php endif; ?>

        <!-- 1. Participant Information -->
        <div>
            <h2 class="sub-title font-semibold mb-4">1. Participant Information</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="firstName" class="block body-text mb-1">First Name <span class="text-red-500">*</span></label>
                    <input type="text" id="firstName" name="firstName" placeholder="First Name" value="<?php echo $firstName ?? ''; ?>"
                        class="w-full p-2 border rounded focus:ring-2 focus:ring-green-300 focus:outline-none">
                </div>
                <div>
                    <label for="lastName" class="block body-text mb-1">Last Name <span class="text-red-500">*</span></label>
                    <input type="text" id="lastName" name="lastName" placeholder="Last Name" value="<?php echo $lastName ?? ''; ?>"
                        class="w-full p-2 border rounded focus:ring-2 focus:ring-green-300 focus:outline-none">
                </div>
                <div class=
 >
                    <label for="phone" class="block body-text mb-1">Phone Number <span class="text-red-500">*</span></label>
                    <div class="flex">
                    <div class=" mr-1">
                            <select class="w-20 p-3 border rounded focus:ring-2 focus:ring-green-300 focus:outline-none">
                            
                            <option>(+91) India</option>
                                <option>(+61) Australia</option>
                                <option>(+81) Japan</option>
                                <option>(+86) China</option>
                                <option>(+49) Germany</option>
                                <option>(+44) UK</option>
                                <option>(+94) Sri Lanka</option>
                                <option>(+41) Switzerland</option>
                                <option>(+1) Canada</option>
                                <option>(+20) Egypt</option>
                                <option>(+33) France</option>
                            </select>
                        </div>
                        <input type="tel" maxlength="10" id="phone" name="phone" placeholder="Phone Number" value="<?php echo $phone ?? ''; ?>"
                            class="flex-1 w-32 p-2 border rounded focus:ring-2 focus:ring-green-300 focus:outline-none">
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                <div>
                    <label for="dob" class="block body-text mb-1">DOB <span class="text-red-500">*</span></label>
                    <div class="relative">
    <input type="text" id="dob" name="dob" placeholder="DD/MM/YYYY" value="<?php echo $dob ?? ''; ?>"
        class="datepicker w-full p-2 border rounded focus:ring-2 focus:ring-green-300 focus:outline-none appearance-none">
    <button type="button" class="absolute right-2 top-2 calendar-btn">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
        </svg>
    </button>
</div>  
                </div>
                <div class="md:col-span-2">
                    <label for="address" class="block body-text mb-1">Address <span class="text-red-500">*</span></label>
                    <textarea id="address" name="address" placeholder="Enter Full Address" rows="1"
                        class="w-full p-2 border h-28 rounded focus:ring-2 focus:ring-green-300 focus:outline-none"><?php echo $address ?? ''; ?></textarea>
                </div>
            </div>

            <h3 class="text-base font-semibold mt-6 mb-3">Emergency Contact Information</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="emergencyName" class="block body-text mb-1">Full Name <span class="text-red-500">*</span></label>
                    <input type="text" id="emergencyName" name="emergencyName" placeholder="Full Name" value="<?php echo $emergencyName ?? ''; ?>"
                        class="w-full p-2 border rounded focus:ring-2 focus:ring-green-300 focus:outline-none">
                </div>
                <div>
                    <label for="relationship" class="block body-text mb-1">Relationship <span class="text-red-500">*</span></label>
                    <input type="text" id="relationship" name="relationship" placeholder="Relation with the Person" value="<?php echo $relationship ?? ''; ?>"
                        class="w-full p-2 border rounded focus:ring-2 focus:ring-green-300 focus:outline-none">
                </div>
                <div>
                    <label for="emergencyPhone" class="block body-text mb-1">Phone Number <span class="text-red-500">*</span></label>
                    <div class="flex">
                    <div class=" mr-1">
                            <select class="w-20 p-3 border rounded focus:ring-2 focus:ring-green-300 focus:outline-none">
                            
                            <option>(+91) India</option>
                                <option>(+61) Australia</option>
                                <option>(+81) Japan</option>
                                <option>(+86) China</option>
                                <option>(+49) Germany</option>
                                <option>(+44) UK</option>
                                <option>(+94) Sri Lanka</option>
                                <option>(+41) Switzerland</option>
                                <option>(+1) Canada</option>
                                <option>(+20) Egypt</option>
                                <option>(+33) France</option>
                            </select>
                        </div>
                        <input type="tel" maxlength="10" id="emergencyPhone" name="emergencyPhone" placeholder="Phone Number" value="<?php echo $emergencyPhone ?? ''; ?>"
                            class="flex-1 w-32 p-2 border rounded focus:ring-2 focus:ring-green-300 focus:outline-none">
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. Fitness Level and Readiness -->
        <div>
            <h2 class="sub-title font-semibold mb-4">2. Fitness Level and Readiness</h2>
            <div class="flex gap-8">
                <div>
                    <label class="block body-text mb-1">a) Current fitness level <span class="text-red-500">*</span></label>
                    <div class="relative w-full">
                        <select id="fitnessLevel" name="fitnessLevel" class="w-full p-2 pr-8 border rounded appearance-none focus:ring-2 focus:ring-green-300 focus:outline-none">
                        <option value="none" selected disabled hidden>Fitness Level</option>
                            <option value="Beginner" <?php echo ($fitnessLevel === 'Beginner') ? 'selected' : ''; ?>>Beginner</option>
                            <option value="Intermediate" <?php echo ($fitnessLevel === 'Intermediate') ? 'selected' : ''; ?>>Intermediate</option>
                            <option value="Advanced" <?php echo ($fitnessLevel === 'Advanced') ? 'selected' : ''; ?>>Advanced</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                <div>
                    <label class="block body-text mb-1">b) Are you currently under the care of healthcare professional? <span class="text-red-500">*</span> (Yes/No)</label>
                    <div class="relative w-1/2">
                        <select id="healthcareProfessional" name="healthcareProfessional" class="w-full p-2 pr-2 border rounded appearance-none focus:ring-2 focus:ring-green-300 focus:outline-none">
                        <option value="none" selected disabled hidden>Select</option>
                            <option value="Yes" <?php echo ($healthcareProfessional === 'Yes') ? 'selected' : ''; ?>>Yes</option>
                            <option value="No" <?php echo ($healthcareProfessional === 'No') ? 'selected' : ''; ?>>No</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Healthcare Details -->
            <div id="healthcareDetailsSection" class="mt-4" style="display: <?php echo ($healthcareProfessional === 'Yes') ? 'block' : 'none'; ?>;">
                <label for="healthcareDetails" class="block body-text mb-1">Provide details about your healthcare professional<span class="text-red-500">*</span></label>
                <textarea id="healthcareDetails" name="healthcareDetails" placeholder="Provide details" rows="2"
                    class="w-full p-2 border rounded focus:ring-2 focus:ring-green-300 focus:outline-none"><?php echo $healthcareDetails ?? ''; ?></textarea>
            </div>

            <div class="mt-4">
                <label class="block body-text mb-1">c) Do you have any known medical conditions or injuries that may affect your ability to exercise? <span class="text-red-500">*</span> (Yes/No)</label>
                <div class="relative w-32">
                    <select id="medicalConditions" name="medicalConditions" class="w-full p-2 pr-8 border rounded appearance-none focus:ring-2 focus:ring-green-300 focus:outline-none">
                    <option value="none" selected disabled hidden>Select</option>
                        <option value="Yes" <?php echo ($medicalConditions === 'Yes') ? 'selected' : ''; ?>>Yes</option>
                        <option value="No" <?php echo ($medicalConditions === 'No') ? 'selected' : ''; ?>>No</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Medical Details -->
            <div id="medicalDetailsSection" class="mt-4" style="display: <?php echo ($medicalConditions === 'Yes') ? 'block' : 'none'; ?>;">
                <label for="medicalDetails" class="block body-text mb-1">Provide details about your medical conditions<span class="text-red-500">*</span></label>
                <textarea id="medicalDetails" name="medicalDetails" placeholder="Provide details" rows="2"
                    class="w-full p-2 border rounded focus:ring-2 focus:ring-green-300 focus:outline-none"><?php echo $medicalDetails ?? ''; ?></textarea>
            </div>

            <div class="mt-4">
                <label class="block body-text mb-1">d) Have you recently undergone any surgeries or medical procedures? <span class="text-red-500">*</span> (Yes/No)</label>
                <div class="relative w-32">
                    <select id="surgeries" name="surgeries" class="w-full p-2 pr-8 border rounded appearance-none focus:ring-2 focus:ring-green-300 focus:outline-none">
                    <option value="none" selected disabled hidden>Select</option>
                        <option value="Yes" <?php echo ($surgeries === 'Yes') ? 'selected' : ''; ?>>Yes</option>
                        <option value="No" <?php echo ($surgeries === 'No') ? 'selected' : ''; ?>>No</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Surgery Details -->
            <div id="surgeryDetailsSection" class="mt-4" style="display: <?php echo ($surgeries === 'Yes') ? 'block' : 'none'; ?>;">
                <label for="surgeryDetails" class="block body-text mb-1">Provide details about your surgeries<span class="text-red-500">*</span></label>
                <textarea id="surgeryDetails" name="surgeryDetails" placeholder="Provide details" rows="2"
                    class="w-full p-2 border rounded focus:ring-2 focus:ring-green-300 focus:outline-none"><?php echo $surgeryDetails ?? ''; ?></textarea>
            </div>

            <div class="mt-4">
                <label class="block body-text mb-1">e) Are you aware of any physical limitations or restrictions that may impact your participation in exercise activities? <span class="text-red-500">*</span> (Yes/No)</label>
                <div class="relative w-32">
                    <select id="physicalLimitations" name="physicalLimitations" class="w-full p-2 pr-8 border rounded appearance-none focus:ring-2 focus:ring-green-300 focus:outline-none">
                    <option value="none" selected disabled hidden>Select</option>
                        <option value="Yes" <?php echo ($physicalLimitations === 'Yes') ? 'selected' : ''; ?>>Yes</option>
                        <option value="No" <?php echo ($physicalLimitations === 'No') ? 'selected' : ''; ?>>No</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Limitation Details -->
            <div id="limitationDetailsSection" class="mt-4" style="display: <?php echo ($physicalLimitations === 'Yes') ? 'block' : 'none'; ?>;">
                <label for="limitationDetails" class="block body-text mb-1">Provide details about your physical limitations<span class="text-red-500">*</span></label>
                <textarea id="limitationDetails" name="limitationDetails" placeholder="Provide details" rows="2"
                    class="w-full p-2 border rounded focus:ring-2 focus:ring-green-300 focus:outline-none"><?php echo $limitationDetails ?? ''; ?></textarea>
            </div>

            <p class="mt-4 ">By completing this section, you acknowledge that the provided information is accurate and that you have disclosed any relevant health conditions or concerns that may affect your participation in the exercise program.</p>
        </div>

        <!-- 3. Release and Waiver of Liability -->
        <div>
            <h2 class="sub-title font-semibold mb-2">3. Release and Waiver of Liability:</h2>
            <p class=" mb-4">I, the undersigned participant, hereby release S2Healthylife management, staff, and trainers conducting the exercise program from any liability or responsibility for injuries, accidents, or damages that may occur during or as a result of participation in the exercise activities.</p>
        </div>

        <!-- 4. Indemnification -->
        <div>
            <h2 class="sub-title font-semibold mb-2">4. Indemnification:</h2>
            <p class="mb-4">The participants agrees indemnify and hold harmless S2Healthylife management, staff and trainers conducting the exercise program from any claims, damages or losses arising from their participation.</p>
        </div>

        <!-- 5. Consent to Emergency Medical Treatment -->
        <div>
            <h2 class="sub-title font-semibold mb-2">5. Consent to Emergency Medical Treatment:</h2>
            <p class=" mb-4">I give my consent to receive emergency medical treatment if required during the exercise program.</p>
        </div>

        <!-- 6. Consent for Social Media -->
        <!-- Consent for Social Media -->
<!-- Consent for Social Media -->
<div>
    <h2 class="sub-title font-semibold mb-2">6. Consent for Social Media:</h2>
    <p class=" mb-4">By participating in the S2Healthylife program, I consent to the following:</p>

    <div class="ml-4 space-y-3">
        <div>
            <p class=" font-medium mb-2">• Authorization for Name Usage:</p>
            <div class="space-y-1">
                <div class="flex items-center">
                    <input type="checkbox" id="fullName" name="fullName" class="mr-2">
                    <label for="fullName" class="">Full Name</label>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" id="firstNameOnly" name="firstNameOnly" class="mr-2">
                    <label for="firstNameOnly" class="">First Name Only</label>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" id="nickname" name="nickname" class="mr-2">
                    <label for="nickname" class="">Use a Nickname</label>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" id="noName" name="noName" class="mr-2">
                    <label for="noName" class="">Do Not Use Any Name</label>
                </div>
            </div>
        </div>

        <div>
            <p class=" font-medium mb-2">• Can Use Picture in Group Photos or Videos:</p>
            <div class="flex items-center space-x-4">
                <div class="flex items-center">
                    <input type="radio" name="groupPhoto" id="groupPhotoYes" value="Yes" class="mr-1" required>
                    <label for="groupPhotoYes" class="">Yes</label>
                </div>
                <div class="flex items-center">
                    <input type="radio" name="groupPhoto" id="groupPhotoNo" value="No" class="mr-1" required>
                    <label for="groupPhotoNo" class="">No</label>
                </div>
            </div>
        </div>

        <div>
            <p class=" font-medium mb-2">• Permission to Use Individual Photos or Videos:</p>
            <div class="flex items-center space-x-4">
                <div class="flex items-center">
                    <input type="radio" name="individualPhoto" id="individualPhotoYes" value="Yes" class="mr-1" required>
                    <label for="individualPhotoYes" class="">Yes</label>
                </div>
                <div class="flex items-center">
                    <input type="radio" name="individualPhoto" id="individualPhotoNo" value="No" class="mr-1" required>
                    <label for="individualPhotoNo" class="">No</label>
                </div>
            </div>
        </div>

        <div>
            <p class=" font-medium mb-2">• I understand that I will not receive any monetary compensation for the use of photos or videos:</p>
            <div class="flex items-center space-x-4">
                <div class="flex items-center">
                    <input type="radio" name="compensation" id="compensationYes" value="Yes" class="mr-1" required>
                    <label for="compensationYes" class="">Yes</label>
                </div>
                <div class="flex items-center">
                    <input type="radio" name="compensation" id="compensationNo" value="No" class="mr-1" required>
                    <label for="compensationNo" class="">No</label>
                </div>
            </div>
        </div>
    </div>
</div>

        <!-- Date and Under 18 Section -->
        <div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="formDate" class="block body-text mb-1">Date <span class="text-red-500">*</span></label>
                    <div class="relative">
    <input type="text" id="formDate" name="formDate" placeholder="DD/MM/YYYY" value="<?php echo $formDate ?? ''; ?>"
        class="datepicker w-full p-2 border rounded focus:ring-2 focus:ring-green-300 focus:outline-none appearance-none">
    <button type="button" class="absolute right-2 top-2 calendar-btn">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
        </svg>
    </button>
</div>
                </div>
            </div>

            <!-- Modified Under 18 Section -->
            <div class="mt-4">
                <p class="text-sm mb-2">Is the participant under 18 years of age?</p>
                <div class="flex items-center space-x-4">
                    <div class="flex items-center">
                        <input type="radio" name="under18" id="under18Yes" value="Yes" <?php echo ($under18 === 'Yes') ? 'checked' : ''; ?> class="mr-1">
                        <label for="under18Yes" class="text-sm">Yes</label>
                    </div>
                    <div class="flex items-center">
                        <input type="radio" name="under18" id="under18No" value="No" <?php echo ($under18 === 'No') ? 'checked' : ''; ?> class="mr-1">
                        <label for="under18No" class="text-sm">No</label>
                    </div>
                </div>
            </div>

            <!-- Parent/Guardian Section - Initially Hidden -->
            <div class="mt-4" id="guardianSection" style="display: <?php echo ($under18 === 'Yes') ? 'block' : 'none'; ?>;">
                <div>
                    <label for="guardianName" class="block body-text mb-1">Parent / Guardian Name<span class="text-red-500">*</span></label>
                    <input type="text" id="guardianName" name="guardianName" placeholder="Parent / Guardian Name" value="<?php echo $guardianName ?? ''; ?>"
                        class="w-full p-2 border rounded focus:ring-2 focus:ring-green-300 focus:outline-none">
                </div>
                <div class="mt-3">
                    <label for="guardianRelationship" class="block body-text mb-1">Relationship to Participant<span class="text-red-500">*</span></label>
                    <input type="text" id="guardianRelationship" name="guardianRelationship" placeholder="Relationship to Participant" value="<?php echo $guardianRelationship ?? ''; ?>"
                        class="w-full p-2 border rounded focus:ring-2 focus:ring-green-300 focus:outline-none">
                </div>
                <div class="mt-3">
                    <label for="guardianSignature" class="block body-text mb-1">Signature of Parent / Guardian<span class="text-red-500">*</span></label>
                    <label class="block text-[14px] mb-2 text-gray-700" > This is a digital signature and is legally considered equivalent to a handwritten signature. </label>
                    <div class="flex items-end justify-start">
                        <input id="signatureCanvas" name="guardianSignature" placeholder="Enter Your Full Name" class="border rounded p-1 h-32 w-64 " ></input>
                        <button type="button" id="clearGuardianSignature"
                            class="ml-2 px-4 py-2 border border-[#9AC339] text-[#9AC339] hover:text-white rounded-lg hover:bg-[#9AC339] focus:outline-none" onclick="signatureClear('signatureCanvas')">Clear</button>
                    </div>
                </div>
            </div>

            <!-- Adult Signature Section - Initially Visible -->
            <div class="mt-4" id="adultSignatureSection" style="display: <?php echo ($under18 === 'Yes') ? 'none' : 'block'; ?>;">
                <div>
                    <label for="signature" class="block body-text mb-1">Signature<span class="text-red-500">*</span></label>
                    <label class="block text-[14px] mb-2" > This is a digital signature and is legally considered equivalent to a handwritten signature. </label>
                    <div class="flex items-end justify-start">
                        <input id="adultSignatureCanvas" name="signature" placeholder="Enter Your Full Name" class="border rounded p-1 h-32 w-64 "></input>
                        <button type="button" id="clearAdultSignature"
                            class="ml-2 px-4 py-2 border border-[#9AC339] text-[#9AC339] hover:text-white rounded-lg hover:bg-[#9AC339] focus:outline-none" onclick="signatureClear('adultSignatureCanvas')">Clear</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Submit and Cancel Buttons -->
        <div class="flex space-x-4">
            <button type="submit" name="submit" value="submit"
                class="px-6 py-2 bg-[#9AC339] text-white rounded-lg hover:bg-[#9AC354]  focus:outline-none focus:ring-2 focus:#9AC339">Submit</button>
            <button type="button" id="resetForm"
                class="px-6 py-2 border border-[#9AC339] text-[#9AC339] hover:text-white rounded-lg hover:bg-[#9AC339] focus:outline-none focus:ring-2 focus:#9AC339">Cancel</button>
        </div>
    </form>
     </div>
    

     <!-- footer start -->
     <footer class="footer bg-[#304E0C] text-white p-8 lg:px-20">
      <div class="container mx-auto">
        <div class="lg:flex justify-between items-start">
          <!-- Left Section (Logo and Description) -->
          <div class="footer-left lg:w-1/3 mb-8 lg:mb-0">
            <a href="/index.html"><img src="images/logo.png" loading="lazy" alt="Logo" class="mb-4" /></a>
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
                  loading="lazy"
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
                  loading="lazy"
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
                  loading="lazy"
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
                loading="lazy"
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
              <p>Quick Link</p>
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
                loading="lazy"
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
                  loading="lazy"
                  class="w-6"
                />
              </a>
              <a href="https://www.instagram.com/s2healthylifeco/" target="_blank" class="block">
                <img
                  src="https://cdn-icons-png.flaticon.com/512/1384/1384063.png"
                  alt="Instagram"
                  loading="lazy"
                  class="w-6"
                />
              </a>
              <a href="https://www.facebook.com/people/S2Healthy-Life/61561522904918/?sk=reels_tab" target="_blank" class="block">
                <img
                  src="https://cdn-icons-png.flaticon.com/512/733/733547.png"
                  alt="Facebook"
                  class="w-6"
                  loading="lazy"
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
    <script src='js/script.js'></script>
    <script>
        function signatureClear(component) {
    const inputComponent = document.getElementById(component);
    if (inputComponent) {
        inputComponent.value = "";
    }
}
       document.addEventListener('DOMContentLoaded', function () {
    // Initialize Flatpickr date pickers
    const dateInputs = document.querySelectorAll('.datepicker');
    dateInputs.forEach(input => {
        flatpickr(input, {
            dateFormat: "d-m-Y",
            allowInput: true
        });
    });

    // Calendar button click handlers
    const calendarButtons = document.querySelectorAll('.calendar-btn');
    calendarButtons.forEach(button => {
        button.addEventListener('click', function () {
            const input = this.parentElement.querySelector('.datepicker');
            if (input._flatpickr) {
                input._flatpickr.toggle();
            }
        });
    });

    // Handle under 18 toggle
    const under18Yes = document.getElementById('under18Yes');
    const under18No = document.getElementById('under18No');
    const guardianSection = document.getElementById('guardianSection');
    const adultSignatureSection = document.getElementById('adultSignatureSection');

    function toggleSections() {
        if (under18Yes.checked) {
            guardianSection.style.display = 'block';
            adultSignatureSection.style.display = 'none';
        } else {
            guardianSection.style.display = 'none';
            adultSignatureSection.style.display = 'block';
        }
    }

    // Initial setup
    toggleSections();

    // Add event listeners
    under18Yes.addEventListener('change', toggleSections);
    under18No.addEventListener('change', toggleSections);

    // Handle dynamic details sections
    const healthcareProfessional = document.getElementById('healthcareProfessional');
    const healthcareDetailsSection = document.getElementById('healthcareDetailsSection');
    const medicalConditions = document.getElementById('medicalConditions');
    const medicalDetailsSection = document.getElementById('medicalDetailsSection');
    const surgeries = document.getElementById('surgeries');
    const surgeryDetailsSection = document.getElementById('surgeryDetailsSection');
    const physicalLimitations = document.getElementById('physicalLimitations');
    const limitationDetailsSection = document.getElementById('limitationDetailsSection');

    healthcareProfessional.addEventListener('change', function () {
        healthcareDetailsSection.style.display = (this.value === 'Yes') ? 'block' : 'none';
    });

    medicalConditions.addEventListener('change', function () {
        medicalDetailsSection.style.display = (this.value === 'Yes') ? 'block' : 'none';
    });

    surgeries.addEventListener('change', function () {
        surgeryDetailsSection.style.display = (this.value === 'Yes') ? 'block' : 'none';
    });

    physicalLimitations.addEventListener('change', function () {
        limitationDetailsSection.style.display = (this.value === 'Yes') ? 'block' : 'none';
    });


    // Form reset button
    const resetFormBtn = document.getElementById('resetForm');
    if (resetFormBtn) {
        resetFormBtn.addEventListener('click', function () {
            if (confirm('Are you sure you want to reset the form?')) {
                document.querySelector('form').reset();
                // Reset sections visibility
                under18No.checked = true;
                toggleSections();
            }
        });
    }
});
    </script>
</body>

</html>