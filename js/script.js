document.addEventListener('DOMContentLoaded', function() {
  const navbar = document.getElementById('navbar');
  const mobileMenu = document.getElementById('mobile-menu');
  const mobileMenuButton = document.getElementById('mobile-menu-button');
  const mobileCloseButton = document.querySelector('.mobile-close-button');
  
  // Store the original height of navbar to maintain consistency
  const originalHeight = navbar.offsetHeight;
  
  // Set initial navbar position with space at top
  navbar.style.position = 'relative';
  navbar.style.top = '40px'; // Initial space at the top
  
  // Handle scroll behavior
  window.addEventListener('scroll', function() {
    if (window.scrollY > 40) {
      // When scrolled, fix the navbar to top
      navbar.style.position = 'fixed';
      navbar.style.top = '0';
      navbar.style.left = '0';
      navbar.style.right = '0';
      navbar.classList.add('scrolled'); // Add class for styling when scrolled
    } else {
      // Return to initial position when at top
      navbar.style.position = 'relative';
      navbar.style.top = (40 - window.scrollY) + 'px';
      navbar.classList.remove('scrolled'); // Remove scrolled class
    }
    
    // Ensure height remains consistent
    navbar.style.height = originalHeight + 'px';
  });
  
  // Mobile menu toggle
  mobileMenuButton.addEventListener('click', function() {
    mobileMenu.classList.remove('translate-x-full');
    document.body.style.overflow = 'hidden'; // Prevent scrolling when menu is open
  });
  
  mobileCloseButton.addEventListener('click', function() {
    mobileMenu.classList.add('translate-x-full');
    document.body.style.overflow = ''; // Re-enable scrolling
  });
  
  // Close mobile menu on window resize (if screen becomes large enough for desktop menu)
  window.addEventListener('resize', function() {
    if (window.innerWidth >= 768) { // md breakpoint in Tailwind
      mobileMenu.classList.add('translate-x-full');
      document.body.style.overflow = '';
    }
  });
  
  // Navigation active state
  const navLinks = document.querySelectorAll(".nav-line");
  const currentPage = window.location.pathname;
  
  navLinks.forEach((link) => {
    if (link.getAttribute("href") === currentPage) {
      link.classList.add("active");
      link.classList.add("text-[#9AC339]");
    }
  });
});



// gallery start
$(document).ready(function () {
  console.log(screen.availWidth);
  let customWidth = screen.availWidth;

  // Initialize the carousel once
  $(".gallery-carousel").slick({
    infinite: false,
    slidesToShow: customWidth > 500 ? 3 : 1,
    slidesToScroll: 1,
    speed: 100,
    arrows: true,
    prevArrow:
      '<button type="button" class="gallery-slick-prev">&#10094;</button>',
    nextArrow:
      '<button type="button" class="gallery-slick-next">&#10095;</button>',
    dots: false,
    draggable: true,
    swipeToSlide: true,
    autoplay: false,
    responsive: [
      {
        breakpoint: 1024,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 1,
        },
      },
      {
        breakpoint: 640,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1,
        },
      },
    ],
  });

  // Update button states initially
  updateArrowStates();

  // Handle button states on slide change
  $(".gallery-carousel").on("beforeChange", function(event, slick, currentSlide, nextSlide) {
    updateArrowStates(nextSlide);
  });

  // Function to update arrow states
  function updateArrowStates(nextSlide) {
    const slick = $(".gallery-carousel").slick("getSlick");
    const slideIndex = nextSlide !== undefined ? nextSlide : slick.currentSlide;
    const slidesToShow = slick.options.slidesToShow;
    
    // Handle prev button
    if (slideIndex === 0) {
      $(".gallery-slick-prev").addClass("inactive");
    } else {
      $(".gallery-slick-prev").removeClass("inactive");
    }
    
    // Handle next button
    if (slideIndex >= slick.slideCount - slidesToShow) {
      $(".gallery-slick-next").addClass("inactive");
    } else {
      $(".gallery-slick-next").removeClass("inactive");
    }
  }

  // On resize, dynamically update the settings
  window.addEventListener("resize", () => {
    console.log(screen.availWidth);
    customWidth = screen.availWidth;

    $(".gallery-carousel").slick(
      "slickSetOption",
      "slidesToShow",
      customWidth > 500 ? 3 : 1,
      true
    );
    
    // Update arrow states after resize
    setTimeout(updateArrowStates, 100);
  });
});

// gallery end


// online services - fixed

$(document).ready(function () {
  let customWidth = screen.availWidth;

  // Initialize the carousel based on customWidth
  var carousel = $(".online-service-carousel").slick({
    dots: false,
    infinite: false,
    speed: 300,
    slidesToShow: customWidth > 500 ? 3 : 1,
    slidesToScroll: 1,
    arrows: false, // Disable default arrows
    responsive: [
      {
        breakpoint: 1024,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 1,
        },
      },
      {
        breakpoint: 640,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1,
        },
      },
    ],
  });

  // Handle custom previous button
  $("#onlineprevArrow").on("click", function () {
    carousel.slick("slickPrev");
    updateArrowState();
  });

  // Handle custom next button
  $("#onlinenextArrow").on("click", function () {
    carousel.slick("slickNext");
    updateArrowState();
  });

  // Update arrow disabled states
  function updateArrowState() {
    var slideCount = $(
      ".online-service-carousel .slick-slide:not(.slick-cloned)"
    ).length;
    var slidesToShow = carousel.slick("slickGetOption", "slidesToShow");
    var currentSlide = carousel.slick("slickCurrentSlide");

    // Disable prev button if at beginning
    if (currentSlide === 0) {
      $("#onlineprevArrow").addClass("slick-disabled");
    } else {
      $("#onlineprevArrow").removeClass("slick-disabled");
    }

    // Disable next button if at end
    if (currentSlide >= slideCount - slidesToShow) {
      $("#onlinenextArrow").addClass("slick-disabled");
    } else {
      $("#onlinenextArrow").removeClass("slick-disabled");
    }
  }

  // Initialize arrow states and bind to slide events
  updateArrowState();
  carousel.on("afterChange", updateArrowState);

  // Handle responsive changes with customWidth
  $(window).on("resize", function () {
    setTimeout(() => {
      customWidth = screen.availWidth;

      // Update the number of slides dynamically based on customWidth
      carousel.slick(
        "slickSetOption",
        "slidesToShow",
        customWidth > 500 ? 3 : 1,
        true
      );

      updateArrowState();
    }, 200);
  });
});


//online services end

// onsite services start

$(document).ready(function () {
  let customWidth = screen.availWidth;
  // Initialize the carousel
  var carousel = $(".service-carousel").slick({
    dots: false,
    infinite: false,
    speed: 300,
    slidesToShow: customWidth > 500 ? 3 : 1,
    slidesToScroll: 1,
    arrows: false, // Disable default arrows
    responsive: [
      {
        breakpoint: 1024,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 1,
        },
      },
      {
        breakpoint: 640,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1,
        },
      },
    ],
  });

  // Handle custom previous button
  $("#prevArrow").on("click", function () {
    carousel.slick("slickPrev");
    updateArrowState();
  });

  // Handle custom next button
  $("#nextArrow").on("click", function () {
    carousel.slick("slickNext");
    updateArrowState();
  });

  // Update arrow disabled states on init and after slide changes
  function updateArrowState() {
    var slideCount = $(
      ".service-carousel .slick-slide:not(.slick-cloned)"
    ).length;
    var slidesToShow = carousel.slick("slickGetOption", "slidesToShow");
    var currentSlide = carousel.slick("slickCurrentSlide");

    // Disable prev button if at beginning
    if (currentSlide === 0) {
      $("#prevArrow").addClass("slick-disabled");
    } else {
      $("#prevArrow").removeClass("slick-disabled");
    }

    // Disable next button if at end
    if (currentSlide >= slideCount - slidesToShow) {
      $("#nextArrow").addClass("slick-disabled");
    } else {
      $("#nextArrow").removeClass("slick-disabled");
    }
  }

  // Initialize arrow states and bind to slide events
  updateArrowState();
  carousel.on("afterChange", updateArrowState);

  // Handle responsive changes
  $(window).on("resize", function () {
    setTimeout(updateArrowState, 200);
  });

  // On resize, dynamically update the settings
  window.addEventListener("resize", () => {
    console.log(screen.availWidth);
    customWidth = screen.availWidth;

    $(".service-carousel").slick(
      "slickSetOption",
      "slidesToShow",
      customWidth > 500 ? 3 : 1,
      true
    );
  });
});

// onsite services end


// testimonial carousel start

$(document).ready(function(){
  $('.testimonial-carousel').slick({
    dots: false,
    infinite: true,
    speed: 500,
    slidesToShow: 4,
    slidesToScroll: 1,
    prevArrow: $('.prev-arrow'),
    nextArrow: $('.next-arrow'),
    draggable: true,
    swipe: true,
    touchMove: true,
    responsive: [
      {
        breakpoint: 1440,
        settings: {
          slidesToShow: 3,
          slidesToScroll: 1,
          prevArrow: $('.prev-arrow'),
          nextArrow: $('.next-arrow'),
        }
      },
      {
        breakpoint: 768,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1,
          prevArrow: $('.mobile-prev'),
          nextArrow: $('.mobile-next')
        }
      }
    ]
  });

  // Connect mobile buttons to carousel
  $('.mobile-prev').click(function() {
    $('.testimonial-carousel').slick('slickPrev');
  });
  
  $('.mobile-next').click(function() {
    $('.testimonial-carousel').slick('slickNext');
  });
});
// testimonial carousel end

// modal start
document.addEventListener('DOMContentLoaded', function() {
  const bmiButton = document.querySelector('.bmi');
  const modal = document.getElementById('bmiModal');
  const closeModal = document.getElementById('closeModal');
  const calculateBtn = document.getElementById('calculateBtn');
  const clearBtn = document.getElementById('clearBtn');
  const bmiResult = document.getElementById('bmiResult');
  const ageInput = document.getElementById('age');
  const heightInput = document.getElementById('height');
  const weightInput = document.getElementById('weight');
  const maleRadio = document.getElementById('male');
  const femaleRadio = document.getElementById('female');
  const bmiCategories = document.getElementById("bmiCategories");
  
  // Open modal when BMI button is clicked
  bmiButton.addEventListener('click', function() {
    modal.classList.remove('hidden');
  });
  
  // Close modal when X button is clicked
  closeModal.addEventListener('click', function() {
    modal.classList.add('hidden');
  });
  
  // Close modal when clicking outside the modal content
  modal.addEventListener('click', function(e) {
    if (e.target === modal || e.target.classList.contains('bg-opacity-50')) {
      modal.classList.add('hidden');
    }
  });
  
  // Calculate BMI when the Calculate button is clicked
  calculateBtn.addEventListener('click', function() {
    const height = parseFloat(heightInput.value);
    const weight = parseFloat(weightInput.value);
    const age = parseInt(ageInput.value);
    const selectedGender = maleRadio.checked ? "male" : "female";
    
    // Validate mandatory fields
    if (isNaN(age) || age <= 0) {
      bmiResult.textContent = "Please enter a valid age";
      bmiResult.style.color = "red";
      bmiCategories.textContent = "";
      return;
    }
    
    if (!isNaN(height) && !isNaN(weight) && height > 0 && weight > 0) {
      // BMI formula: weight (kg) / (height (m))^2
      const heightInMeters = height / 100;
      const bmi = (weight / (heightInMeters * heightInMeters)).toFixed(1);
      bmiResult.innerHTML = `${bmi} <p>kg/m2</p>`;
      bmiResult.style.color = "black";
      let category = getBMICategory(age, selectedGender, bmi);
      bmiCategories.textContent = category;
    } else {
      bmiResult.textContent = "Please enter valid height and weight";
      bmiResult.style.color = "red";
      bmiCategories.textContent = "";
    }
  });

  function getBMICategory(age, gender, bmi) {
    if (age >= 18) {
      if (bmi < 18.5) return "Underweight";
      if (bmi >= 18.5 && bmi < 24.9) return "Normal weight";
      if (bmi >= 25 && bmi < 29.9) return "Overweight";
      return "Obese";
    } else {
      let percentileRanges = {
        male: {
          2: [14.0, 18.0, 20.5],
          3: [14.2, 18.2, 20.8],
          4: [14.3, 18.4, 21.1],
          5: [14.5, 18.6, 21.4],
          6: [14.6, 18.8, 21.7],
          7: [14.8, 19.0, 22.0],
          8: [14.9, 19.2, 22.3],
          9: [15.0, 19.4, 22.6],
          10: [15.2, 19.6, 22.9],
          11: [15.4, 19.9, 23.3],
          12: [15.6, 20.2, 23.7],
          13: [16.0, 20.6, 24.2],
          14: [16.4, 21.0, 24.7],
          15: [16.7, 21.4, 25.2],
          16: [17.0, 21.8, 25.7],
          17: [17.2, 22.2, 26.2]
        },
        female: {
          2: [13.8, 17.8, 20.2],
          3: [14.0, 18.0, 20.5],
          4: [14.1, 18.2, 20.8],
          5: [14.3, 18.4, 21.1],
          6: [14.5, 18.6, 21.4],
          7: [14.6, 18.8, 21.7],
          8: [14.8, 19.0, 22.0],
          9: [15.0, 19.2, 22.3],
          10: [15.2, 19.4, 22.6],
          11: [15.4, 19.7, 23.0],
          12: [15.7, 20.0, 23.4],
          13: [16.0, 20.4, 23.9],
          14: [16.3, 20.8, 24.4],
          15: [16.6, 21.2, 24.9],
          16: [16.9, 21.6, 25.4],
          17: [17.1, 22.0, 25.9]
        }
      };

      if (percentileRanges[gender] && percentileRanges[gender][age]) {
        let ranges = percentileRanges[gender][age];
        if (bmi < ranges[0]) return "Underweight";
        if (bmi < ranges[1]) return "Healthy weight";
        if (bmi < ranges[2]) return "Overweight";
        return "Obese";
      } else {
        return "Age out of range for BMI categories";
      }
    }
  }

  // Function to clear the data
  clearBtn.addEventListener('click', function() {
    ageInput.value = "";
    heightInput.value = "";
    weightInput.value = "";
    bmiResult.textContent = "";
    bmiResult.style.color = ""; // Reset text color if it was changed
    bmiCategories.textContent = "";
    // Reset radio buttons to default (male)
    maleRadio.checked = true;
    femaleRadio.checked = false;
  });
});
// modal end