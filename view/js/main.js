

    $.fn.MySlider = function(interval,str) {
        var slides;
        var cnt;
        var amount;
        var i;

        function run() {
            // hiding previous image and showing next
            $(slides[i]).fadeOut(1000);
            i++;
            if (i >= amount) i = 0;
            $(slides[i]).fadeIn(1000);

            // updating counter
            cnt.text(i+1+' / '+amount);

            // loop
            setTimeout(run, interval);
        }
        console.log('#my_slider'+str);
        slides = $('#my_slider'+str).children();
        cnt = $('#counter');
        amount = slides.length;
        i=0;

        // updating counter
        cnt.text(i+1+' / '+amount);

        setTimeout(run, interval);
    };


// custom initialization
jQuery(window).load(function() {
    $('.smart_gallery').MySlider(3000,'one');
    $('.smart_gallery').MySlider(3000,'two');
});

function biografy(str){
    $(".biografy").hide();
    $("#biografy"+str).fadeIn(1000);
}