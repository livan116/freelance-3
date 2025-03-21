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

document.addEventListener("DOMContentLoaded", function () {
  const carousel = document.getElementById("carousel");
  const prevBtn = document.getElementById("prev-btn");
  const nextBtn = document.getElementById("next-btn");
  const indicators = document.querySelectorAll(".indicator-dot");

  let currentIndex = 0;
  const itemWidth = 100; // Width in percentage
  let itemsPerView = 1;

  function updateItemsPerView() {
    if (window.innerWidth >= 1024) {
      itemsPerView = 3;
    } else if (window.innerWidth >= 640) {
      itemsPerView = 2;
    } else {
      itemsPerView = 1;
    }
  }

  function updateCarousel() {
    const translateX = -currentIndex * (itemWidth / itemsPerView);
    carousel.style.transform = `translateX(${translateX}%)`;

    // Update indicators
    indicators.forEach((dot, index) => {
      if (Math.floor(currentIndex / itemsPerView) === index) {
        dot.classList.add("bg-opacity-100");
        dot.classList.remove("bg-opacity-50");
      } else {
        dot.classList.add("bg-opacity-50");
        dot.classList.remove("bg-opacity-100");
      }
    });
  }

  prevBtn.addEventListener("click", function () {
    if (currentIndex > 0) {
      currentIndex--;
      updateCarousel();
    }
  });

  nextBtn.addEventListener("click", function () {
    const totalItems = carousel.children.length;
    if (currentIndex < totalItems - itemsPerView) {
      currentIndex++;
      updateCarousel();
    }
  });

  indicators.forEach((dot, index) => {
    dot.addEventListener("click", function () {
      currentIndex = index * itemsPerView;
      updateCarousel();
    });
  });

  // Update on resize
  window.addEventListener("resize", function () {
    updateItemsPerView();
    updateCarousel();
  });

  // Initial setup
  updateItemsPerView();
  updateCarousel();
});

// gallery end

// onsite and online services start
document.addEventListener('DOMContentLoaded', function() {
  // Function to create carousel functionality
  function setupCarousel(sliderId, prevBtnId, nextBtnId, dotsContainerId) {
    const slider = document.getElementById(sliderId);
    const prevBtn = document.getElementById(prevBtnId);
    const nextBtn = document.getElementById(nextBtnId);
    const dotsContainer = document.getElementById(dotsContainerId);
    
    let currentPosition = 0;
    let itemsPerView = 1;
    let itemWidth = 100; // percentage width of items on mobile
    const totalItems = slider.children.length;
    let maxPositions = totalItems - itemsPerView;
    
    // Create dots based on number of pages
    function createDots() {
      dotsContainer.innerHTML = '';
      const pages = Math.ceil(totalItems / itemsPerView);
      
      for(let i = 0; i < pages; i++) {
        const dot = document.createElement('div');
        dot.classList.add('dot');
        if(i === 0) dot.classList.add('active');
        
        dot.addEventListener('click', () => {
          currentPosition = i * itemsPerView;
          if(currentPosition > maxPositions) currentPosition = maxPositions;
          moveSlider();
          updateDots();
        });
        
        dotsContainer.appendChild(dot);
      }
    }
    
    // Update active dot
    function updateDots() {
      const activePage = Math.floor(currentPosition / itemsPerView);
      const dots = dotsContainer.querySelectorAll('.dot');
      
      dots.forEach((dot, index) => {
        if(index === activePage) {
          dot.classList.add('active');
        } else {
          dot.classList.remove('active');
        }
      });
    }
    
    function updateView() {
      if (window.innerWidth >= 1024) {
        itemsPerView = 3;
        itemWidth = 33.333;
      } else if (window.innerWidth >= 640) {
        itemsPerView = 2;
        itemWidth = 50;
      } else {
        itemsPerView = 1;
        itemWidth = 100;
      }
      
      maxPositions = totalItems - itemsPerView;
      if(currentPosition > maxPositions) currentPosition = maxPositions;
      
      createDots();
      moveSlider();
    }
    
    function moveSlider() {
      // Add a little extra for the gap
      const gapSize = 0.5;
      const position = currentPosition * (itemWidth + gapSize);
      slider.style.transform = `translateX(-${position}%)`;
      updateDots();
      
      // Enable/disable buttons based on position
      if(currentPosition <= 0) {
        prevBtn.classList.add('opacity-50', 'cursor-not-allowed');
        prevBtn.disabled = true;
      } else {
        prevBtn.classList.remove('opacity-50', 'cursor-not-allowed');
        prevBtn.disabled = false;
      }
      
      if(currentPosition >= maxPositions) {
        nextBtn.classList.add('opacity-50', 'cursor-not-allowed');
        nextBtn.disabled = true;
      } else {
        nextBtn.classList.remove('opacity-50', 'cursor-not-allowed');
        nextBtn.disabled = false;
      }
    }
    
    prevBtn.addEventListener('click', function() {
      if (currentPosition > 0) {
        currentPosition--;
        moveSlider();
      }
    });
    
    nextBtn.addEventListener('click', function() {
      if (currentPosition < maxPositions) {
        currentPosition++;
        moveSlider();
      }
    });
    
    // Add touch swipe functionality
    let touchStartX = 0;
    let touchEndX = 0;
    
    slider.addEventListener('touchstart', (e) => {
      touchStartX = e.changedTouches[0].screenX;
    }, {passive: true});
    
    slider.addEventListener('touchend', (e) => {
      touchEndX = e.changedTouches[0].screenX;
      handleSwipe();
    }, {passive: true});
    
    function handleSwipe() {
      const swipeThreshold = 50;
      if(touchEndX < touchStartX - swipeThreshold) {
        // Swipe left -> next slide
        if(currentPosition < maxPositions) {
          currentPosition++;
          moveSlider();
        }
      } else if(touchEndX > touchStartX + swipeThreshold) {
        // Swipe right -> prev slide
        if(currentPosition > 0) {
          currentPosition--;
          moveSlider();
        }
      }
    }
    
    // Update on resize
    window.addEventListener('resize', function() {
      updateView();
    });
    
    // Initial setup
    updateView();
  }
  
  // Set up both carousels
  setupCarousel('onsite-services', 'onsite-prev', 'onsite-next', 'onsite-dots');
  setupCarousel('online-services', 'online-prev', 'online-next', 'online-dots');
});
// onsite and online services end


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
  const bmiResult = document.getElementById('bmiResult');
  const ageInput = document.getElementById('age');
  const heightInput = document.getElementById('height');
  const weightInput = document.getElementById('weight');
  
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
    
    if (height && weight) {
      // BMI formula: weight (kg) / (height (m))^2
      const heightInMeters = height / 100;
      const bmi = (weight / (heightInMeters * heightInMeters)).toFixed(1);
      bmiResult.textContent = bmi;
    } else {
      bmiResult.textContent = "Please enter valid height and weight";
      bmiResult.style.color = "red";
    }
  });
});
// modal end