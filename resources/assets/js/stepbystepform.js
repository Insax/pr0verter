Dropzone.autoDiscover = false;
$(function() {
    var $startButton = $(".start"),
        $ultypeButton = $(".ultype"),
        $chooseButton = $(".choose"),
        $sizeButton = $(".size"),
        $soundButton = $(".sound"),
        $resButton = $(".res"),
        $clipButton = $(".clip"),
        $input = $("input"),
        $name = $(".name"),
        $more = $(".more"),
        $reset = $(".reset"),
        $ctr = $(".container-steps"),
        $ul = $("#ul"),
        $dl = $("#dl"),
        $dlform = $("#formurl"),
        $dlform2 = $("#urlform"),
        text = 'Kein Ton';

    $( "#slider" ).slider({
        value: 2,
        min: 0,
        max: 3,
        step: 1,
        slide: function( event, ui ) {
        switch(ui.value) {
            case 0:
                text = 'Kein Ton';
                break;
            case 1:
                text = 'Schlechte Qualität';
                break;
            case 2:
                text = 'Mittlere Qualität';
                break;
            case 3:
                text = 'Hohe Qualität';
                break;
        }
        $( "#sound" ).val( text );
        $( "#refsound" ).val(ui.value);
    }});
    switch($( "#slider" ).slider( "value" )) {
        case 0:
            text = 'Kein Ton';
            break;
        case 1:
            text = 'Schlechte Qualität';
            break;
        case 2:
            text = 'Mittlere Qualität';
            break;
        case 3:
            text = 'Hohe Qualität';
            break;
    }
    $( "#sound" ).val( text );
    $( "#refsound" ).val( $( "#slider" ).slider( "value" ) );
    $startButton.on("click", function(e){
        $(this).text("Saving...").queue(function(){
            $ctr.addClass("ul slider-ul-active").removeClass("start slider-start-active");
        });
        e.preventDefault();
    });

    $ul.on("click", function (e) {
        $ultypeButton.removeAttr("disabled");
    });

    $dl.on("click", function (e) {
        $ultypeButton.removeAttr("disabled");
    });

    $ultypeButton.on("click", function(e){
        $(this).text("Speichere...").delay(900).queue(function(){
            $ctr.addClass("choose slider-choose-active").removeClass("ul slider-ul-active");
            console.log($ul.is(":checked"), $dl.is(":checked"));
            if($ul.is(':checked') == true) {
                $("#mydropzone").show().dropzone({
                    url: "/file/post",
                    clickable: true,
                    autoProcessQueue: false,
                    uploadMultiple: false,
                    maxFiles: 1,
                    paramName: "file",
                    maxFilesize: 100,
                    init: function() {
                        this.on("addedfile", function(file) {
                            $('.dz-progress').hide();
                            $chooseButton.removeAttr('disabled');
                        });
                        this.on("removedfile", function (file) {
                            $chooseButton.addAttr('disabled', 'disabled');
                        })
                    }
                });
            }
            if($dl.is(':checked') == true) {
                $chooseButton.removeAttr('disabled');
                $dlform.show();
                $dlform2.show();
            }
        });
        e.preventDefault();
    });

    $chooseButton.on("click", function (e) {
        if(($dl.is(':checked') && $('#urlform').val()) || $ul.is(':checked')) {
            $(this).text("Speichere...").delay(900).queue(function () {
                $ctr.addClass("size slider-size-active").removeClass("ul choose slider-choose-active");
            });
        }
        else
            alert('Bitte eine URL eingeben!');

        e.preventDefault();
    });

    $sizeButton.on("click", function (e) {
        $(this).text("Speichere...").delay(900).queue(function () {
            $ctr.addClass("sound slider-sound-active").removeClass("ul choose size slider-size-active");
        });
        e.preventDefault();
    });

    $soundButton.on("click", function (e) {
        $(this).text("Speichere...").delay(900).queue(function () {
            $ctr.addClass("res slider-res-active").removeClass("ul choose size sound slider-sound-active");
        });
        e.preventDefault();
    });

    $resButton.on("click", function (e) {
        $(this).text("Speichere...").delay(900).queue(function () {
            $ctr.addClass("clip slider-clip-active").removeClass("ul choose size sound res slider-res-active");
        });
        e.preventDefault();
    });
});
