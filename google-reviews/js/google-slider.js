/**
 * Google Testimonials Slider
 * JavaScript to handle horizontal testimonials slider
 */

(function ($) {
  "use strict";

  // Initialize when DOM is ready
  $(document).ready(function () {
    initGoogleSlider();
  });

  function initGoogleSlider() {
    $(".google-testimonials-wrapper").each(function () {
      const $wrapper = $(this);
      const $container = $wrapper.find(
        ".ti-reviews-container, .ti-review-container"
      );
      const $items = $container.find(".ti-review-item, .ti-box-wrapper");

      if ($items.length <= 1) {
        return; // No slider needed
      }

      const autoplay = $wrapper.data("autoplay") !== "false";
      const interval = parseInt($wrapper.data("interval")) || 5000;

      let currentIndex = 0;
      let autoplayInterval = null;

      // Create controls if they don't exist
      if (!$wrapper.find(".ti-slider-nav").length) {
        createSliderControls($wrapper, $items.length);
      }

      const $prevBtn = $wrapper.find(".ti-slider-prev");
      const $nextBtn = $wrapper.find(".ti-slider-next");
      const $dots = $wrapper.find(".ti-slider-dot");

      // Function to show slide
      function showSlide(index) {
        currentIndex = index;

        // Update position
        const itemWidth = $items.first().outerWidth(true);
        $container.css(
          "transform",
          `translateX(-${currentIndex * itemWidth}px)`
        );

        // Update dots
        $dots.removeClass("active");
        $dots.eq(currentIndex).addClass("active");

        // Update buttons
        $prevBtn.prop("disabled", currentIndex === 0);
        $nextBtn.prop("disabled", currentIndex === $items.length - 1);
      }

      // Previous navigation
      $prevBtn.on("click", function () {
        if (currentIndex > 0) {
          showSlide(currentIndex - 1);
          resetAutoplay();
        }
      });

      // Next navigation
      $nextBtn.on("click", function () {
        if (currentIndex < $items.length - 1) {
          showSlide(currentIndex + 1);
          resetAutoplay();
        } else if (autoplay) {
          showSlide(0); // Loop
        }
      });

      // Dots navigation
      $dots.on("click", function () {
        const index = $(this).index();
        showSlide(index);
        resetAutoplay();
      });

      // Autoplay
      function startAutoplay() {
        if (autoplay) {
          autoplayInterval = setInterval(function () {
            if (currentIndex < $items.length - 1) {
              showSlide(currentIndex + 1);
            } else {
              showSlide(0);
            }
          }, interval);
        }
      }

      function stopAutoplay() {
        if (autoplayInterval) {
          clearInterval(autoplayInterval);
        }
      }

      function resetAutoplay() {
        stopAutoplay();
        startAutoplay();
      }

      // Touch/swipe support
      let startX = 0;
      let isDragging = false;

      $container.on("touchstart mousedown", function (e) {
        startX = e.type === "touchstart" ? e.touches[0].clientX : e.clientX;
        isDragging = true;
        stopAutoplay();
      });

      $(document).on("touchmove mousemove", function (e) {
        if (!isDragging) return;

        const currentX =
          e.type === "touchmove" ? e.touches[0].clientX : e.clientX;
        const diff = startX - currentX;

        if (Math.abs(diff) > 50) {
          if (diff > 0 && currentIndex < $items.length - 1) {
            showSlide(currentIndex + 1);
          } else if (diff < 0 && currentIndex > 0) {
            showSlide(currentIndex - 1);
          }
          isDragging = false;
        }
      });

      $(document).on("touchend mouseup", function () {
        if (isDragging) {
          isDragging = false;
          resetAutoplay();
        }
      });

      // Pause on hover
      $wrapper.on("mouseenter", stopAutoplay);
      $wrapper.on("mouseleave", startAutoplay);

      // Initialize
      showSlide(0);
      startAutoplay();

      // Responsive
      $(window).on("resize", function () {
        showSlide(currentIndex);
      });
    });
  }

  function createSliderControls($wrapper, itemCount) {
    const $nav = $('<div class="ti-slider-nav"></div>');

    // Previous button
    const $prevBtn = $(
      '<button class="ti-slider-arrow ti-slider-prev" type="button">‹</button>'
    );
    $nav.append($prevBtn);

    // Dots
    const $dots = $('<div class="ti-slider-dots"></div>');
    for (let i = 0; i < itemCount; i++) {
      $dots.append('<button class="ti-slider-dot" type="button"></button>');
    }
    $nav.append($dots);

    // Next button
    const $nextBtn = $(
      '<button class="ti-slider-arrow ti-slider-next" type="button">›</button>'
    );
    $nav.append($nextBtn);

    $wrapper.append($nav);
  }

  // Helper function to convert vertical list to horizontal
  window.convertToHorizontalSlider = function (selector) {
    $(selector).each(function () {
      const $widget = $(this);
      $widget.addClass("google-testimonials-wrapper");

      // Reorganize structure if necessary
      const $reviews = $widget.find(".ti-review-item, .ti-box-wrapper");
      if (
        $reviews.length > 0 &&
        !$reviews.parent().hasClass("ti-reviews-container")
      ) {
        $reviews.wrapAll('<div class="ti-reviews-container"></div>');
      }
    });

    initGoogleSlider();
  };
})(jQuery);
