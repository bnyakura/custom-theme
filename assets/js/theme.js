/**
 * Theme JavaScript
 *
 * @package CustomTheme
 */

;(($) => {
  // DOM Ready
  $(document).ready(() => {
    initMobileMenu()
    initFaqAccordion()
  })

  /**
   * Initialize mobile menu
   */
function initMobileMenu() {
  const menuToggle = $(".menu-toggle")
  const primaryMenu = $(".primary-menu")
  const menuClose = $(".menu-close")

  menuToggle.on("click", function (e) {
    e.preventDefault()

    const isExpanded = $(this).attr("aria-expanded") === "true"

    $(this).attr("aria-expanded", !isExpanded)
    primaryMenu.toggleClass("is-open")

    // Toggle hamburger animation
    $(this).toggleClass("is-active")
  })

  // Close menu when clicking the close button
  menuClose.on("click", function () {
    menuToggle.attr("aria-expanded", "false")
    primaryMenu.removeClass("is-open")
    menuToggle.removeClass("is-active")
  })

  // Close menu when clicking outside
  $(document).on("click", (e) => {
    if (!$(e.target).closest(".main-navigation").length) {
      menuToggle.attr("aria-expanded", "false")
      primaryMenu.removeClass("is-open")
      menuToggle.removeClass("is-active")
    }
  })

  // Close menu on escape key
  $(document).on("keydown", (e) => {
    if (e.keyCode === 27) {
      // Escape key
      menuToggle.attr("aria-expanded", "false")
      primaryMenu.removeClass("is-open")
      menuToggle.removeClass("is-active")
    }
  })
}


  /**
   * Initialize FAQ accordion
   */
  function initFaqAccordion() {
    $(".faq-question").on("click", function () {
      const faqItem = $(this).parent()
      const faqAnswer = faqItem.find(".faq-answer")

      if (faqItem.hasClass("open")) {
        faqItem.removeClass("open")
        faqAnswer.slideUp(300)
      } else {
        $(".faq-item").removeClass("open")
        $(".faq-answer").slideUp(300)

        faqItem.addClass("open")
        faqAnswer.slideDown(300)
      }
    })
  }
})(jQuery)
