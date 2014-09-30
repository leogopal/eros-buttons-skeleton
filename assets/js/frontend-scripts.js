$(document).ready(function() {
	$('.popup-with-zoom-anim').magnificPopup({
		type: 'inline',

		fixedContentPos: false,
		fixedBgPos: true,

		overflowY: 'auto',

		closeBtnInside: true,
		preloader: false,
		
		midClick: true,
		removalDelay: 300,
		mainClass: 'my-mfp-zoom-in'
	});

	$('.popup-with-move-anim').magnificPopup({
		type: 'inline',

		fixedContentPos: false,
		fixedBgPos: true,

		overflowY: 'auto',

		closeBtnInside: true,
		preloader: false,
		
		midClick: true,
		removalDelay: 300,
		mainClass: 'my-mfp-slide-bottom'
	});
});


// == ## ========================================================== isotopes magic filtering



jQuery(window).load(function () {
    var e = jQuery(".js-isotope").isotope();
    e.isotope({ layoutMode: 'fitRows' });
    jQuery(".js-isotope-filter").on("click", ".filter-link", function (t) {
        var n = jQuery(this).attr("data-filter-value");
        e.isotope({
            filter: n
        });
        t.preventDefault()
    });
    jQuery(".js-isotope-filter").each(function (e, t) {
        var n = jQuery(t);
        n.on("click", ".filter-link", function () {
            n.find(".filter-link-active").removeClass("filter-link-active");
            jQuery(this).addClass("filter-link-active")
        })
    })
});
