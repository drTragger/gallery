$(document).ready(function () {
    // Opening photos
    $(".image-container").click(function () {
        let val = Number($(this).attr("value"));
        let edge = Number($(".image-container:last").attr("value"));
        $(this).addClass("image-container-click");
        $(this).find(".image").addClass("image-click");
        $(this).find(".fa-times").removeClass("invisible");
        if (val !== 0) {
            $(this).find(".fa-arrow-left").removeClass("invisible");
        }
        if (val !== edge) {
            $(this).find(".fa-arrow-right").removeClass("invisible");
        }
        // Closing photos
        $(".fa-times").click(function () {
            $(this).parents(".image-container").removeClass("image-container-click");
            $(this).parents(".image").removeClass("image-click");
            $(this).addClass("invisible");
            $(this).siblings(".fa-arrow-right").addClass("invisible");
            $(this).siblings(".fa-arrow-left").addClass("invisible");
            return false;
        });
    });

    // Slider
    function slider(val, edge, arrow) {
        let container = $(".image-container").eq(val);

        if (val !== edge) {
            container.addClass("image-container-click");
            container.find(".image").addClass("image-click");
            container.find(".fa-times").removeClass("invisible");
            if (val - 1 !== edge) {
                container.find(".fa-arrow-left").removeClass("invisible");
            }
            if (val + 1 !== edge) {
                container.find(".fa-arrow-right").removeClass("invisible");
            }
            arrow.parents(".image-container").removeClass("image-container-click");
            arrow.parents(".image").removeClass("image-click");
            arrow.addClass("invisible");
            arrow.siblings(".fa-arrow-right").addClass("invisible");
            arrow.siblings(".fa-arrow-left").addClass("invisible");
            arrow.siblings(".fa-times").addClass("invisible");
        }
    }

    $(".fa-arrow-left").click(function () {
        let arrow = $(this);
        let val = arrow.parents(".image-container").attr("value") - 1;
        slider(val, -1, arrow);
        return false;
    });

    $(".fa-arrow-right").click(function () {
        let arrow = $(this);
        let val = Number(arrow.parents(".image-container").attr("value"));
        let edge = Number($(".image-container:last").attr("value"));
        slider(val + 1, edge + 1, arrow);
        return false;
    });

    (function() {

        'use strict';

        $('.input-file').each(function() {
            var $input = $(this),
                $label = $input.next('.js-labelFile'),
                labelVal = $label.html();

            $input.on('change', function(element) {
                var fileName = '';
                if (element.target.value) fileName = element.target.value.split('\\').pop();
                fileName ? $label.addClass('has-file').find('.js-fileName').html(fileName) : $label.removeClass('has-file').html(labelVal);
            });
        });

    })();
});
