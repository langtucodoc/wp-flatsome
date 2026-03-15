/**
 * landing.js
 * Landing page interactivity for Bình Trà Tử Sa Long Phụng.
 *
 * Features:
 * - Bundle card selection + AJAX add-to-cart
 * - Sticky CTA bar show/hide on scroll
 * - FAQ accordion
 * - Scroll-triggered fade-in animations
 * - Smooth scroll for CTA anchor links
 * - Bundle pre-select on page load
 */

(function ($) {
  'use strict';

  // ─── Config ─────────────────────────────────────────────────────────────────

  var cfg = window.flatsomeChildConfig || {
    ajaxUrl:     '/wp-admin/admin-ajax.php',
    nonce:       '',
    checkoutUrl: '/checkout/',
    cartUrl:     '/cart/',
    productId:   0,
  };

  // ─── Bundle selection ────────────────────────────────────────────────────────

  /**
   * Handle bundle card click:
   * 1. Mark card as selected
   * 2. AJAX add to cart (clears existing cart first, server-side)
   * 3. Redirect to checkout
   */
  $(document).on('click', '.js-bundle-select', function (e) {
    e.preventDefault();
    e.stopPropagation();

    var $btn      = $(this);
    var $card     = $btn.closest('.bundle-card');
    var productId   = parseInt($card.data('product-id'), 10)   || cfg.productId;
    var variationId = parseInt($card.data('variation-id'), 10) || 0;
    var quantity    = parseInt($card.data('quantity'), 10)      || 1;
    var nonce       = $btn.closest('[data-nonce]').data('nonce') || cfg.nonce;

    if (!productId) {
      alert('Không tìm thấy sản phẩm. Vui lòng tải lại trang.');
      return;
    }

    // Visual feedback
    $btn.text('Đang xử lý...').prop('disabled', true);
    $('.bundle-card').removeClass('is-selected');
    $card.addClass('is-selected');

    $.ajax({
      url:    cfg.ajaxUrl,
      method: 'POST',
      data:   {
        action:       'flatsome_add_bundle',
        product_id:   productId,
        variation_id: variationId,
        quantity:     quantity,
        nonce:        nonce,
      },
      success: function (res) {
        if (res.success) {
          window.location.href = res.data.redirect_url || cfg.checkoutUrl;
        } else {
          alert(res.data.message || 'Có lỗi xảy ra. Vui lòng thử lại.');
          $btn.text('Chọn Gói Này').prop('disabled', false);
        }
      },
      error: function () {
        // Fallback: redirect to cart page so user can still order
        window.location.href = cfg.checkoutUrl;
      },
    });
  });

  /**
   * Pre-select the "popular" bundle on page load.
   */
  function preselectPopularBundle() {
    var $popular = $('.bundle-card--popular');
    if ($popular.length) {
      $popular.addClass('is-selected');
    }
  }

  // ─── CTA order button (non-AJAX flow) ────────────────────────────────────────

  /**
   * Simple CTA that jumps to checkout / bundle section.
   */
  $(document).on('click', '.js-order-cta', function (e) {
    var href = $(this).attr('href');
    // If href is an anchor (#section), smooth scroll
    if (href && href.charAt(0) === '#') {
      e.preventDefault();
      var $target = $(href);
      if ($target.length) {
        $('html, body').animate({ scrollTop: $target.offset().top - 80 }, 600, 'swing');
      }
    }
    // Otherwise, let the browser navigate to checkout
  });

  // ─── Sticky CTA bar ──────────────────────────────────────────────────────────

  var $stickyBar    = $('.js-sticky-cta');
  var showThreshold = 400; // px scrolled before bar appears

  function handleScroll() {
    if (!$stickyBar.length) return;

    var scrollY  = window.pageYOffset || document.documentElement.scrollTop;
    var docH     = document.documentElement.scrollHeight;
    var windowH  = window.innerHeight;
    var nearBottom = scrollY + windowH > docH - 200;

    if (scrollY > showThreshold && !nearBottom) {
      $stickyBar.addClass('is-visible');
    } else {
      $stickyBar.removeClass('is-visible');
    }
  }

  // Throttled scroll
  var scrollTimer;
  $(window).on('scroll', function () {
    if (scrollTimer) return;
    scrollTimer = setTimeout(function () {
      handleScroll();
      scrollTimer = null;
    }, 80);
  });

  // ─── FAQ accordion ───────────────────────────────────────────────────────────

  $(document).on('click', '.faq-item__question', function () {
    var $item    = $(this).closest('.faq-item');
    var $answer  = $item.find('.faq-item__answer');
    var isOpen   = $item.hasClass('is-open');

    // Close all open items
    $('.faq-item.is-open')
      .removeClass('is-open')
      .find('.faq-item__answer')
      .stop(true, true)
      .slideUp(300);

    if (!isOpen) {
      $item.addClass('is-open');
      $answer.stop(true, true).slideDown(300);
    }
  });

  // ─── Scroll-triggered animations ────────────────────────────────────────────

  function initAnimations() {
    if (!('IntersectionObserver' in window)) return;

    var observer = new IntersectionObserver(
      function (entries) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting) {
            entry.target.classList.add('is-visible');
            observer.unobserve(entry.target);
          }
        });
      },
      { threshold: 0.15, rootMargin: '0px 0px -40px 0px' }
    );

    document.querySelectorAll('.fade-in-up').forEach(function (el) {
      observer.observe(el);
    });
  }

  // ─── Smooth scroll for anchor links ──────────────────────────────────────────

  $('a[href^="#"]').not('.faq-item__question').on('click', function (e) {
    var target = $(this).attr('href');
    if (target === '#') return;
    var $target = $(target);
    if ($target.length) {
      e.preventDefault();
      $('html, body').animate({ scrollTop: $target.offset().top - 80 }, 600);
    }
  });

  // ─── Init ────────────────────────────────────────────────────────────────────

  $(document).ready(function () {
    preselectPopularBundle();
    initAnimations();
    handleScroll();
  });

})(jQuery);
