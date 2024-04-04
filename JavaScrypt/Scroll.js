$(document).ready(function(){
    $('.slick-carousel').slick({
        infinite: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 1,
        speed: 50000,
        arrows: false,
        scrollOnFocus: false,
        scrollOnHover: false,
        responsive: 
        [
            {
                breakpoint: 768,
                settings: 
                {
                    infinite: true,
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    autoplay: true,
                    autoplaySpeed: 1
                }
            },

            {
                breakpoint: 1300,
                settings:
                {
                    infinite: true,
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    autoplay: true,
                    autoplaySpeed: 1
                }
            }
        ]
    });
});
