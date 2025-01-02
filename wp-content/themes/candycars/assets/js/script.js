jQuery(document).ready(function ($) {
  $(".hero-carousel").owlCarousel({
    items: 1,
    loop: true,
    autoplay: true,
    autoplayTimeout: 5000,
    autoplayHoverPause: true,
    nav: true,
    dots: true,
    navText: ["<span class='owl-prev'>&lt;</span>", "<span class='owl-next'>&gt;</span>"],
    responsive: {
      0: { items: 1 },
      768: { items: 1 },
      1024: { items: 1 },
    },
  });
});
