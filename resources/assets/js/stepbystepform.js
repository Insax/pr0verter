$(function() {
    var $startButton = $(".start.next"),
        $ultypeButton = $(".ultype.next"),
        $chooseButton = $(".choose.next"),
        $chooseButtonBack = $(".choose.back"),
        $sizeButton = $(".size.next"),
        $sizeButtonBack = $(".size.back"),
        $soundButton = $(".sound.next"),
        $soundButtonBack = $(".sound.back"),
        $resButton = $(".res.next"),
        $resButtonBack = $(".res.back"),
        $clipButton = $(".clip.next"),
        $clipButtonBack = $(".clip.back"),
        $cutstart = $("#cutstart"),
        $cutend = $("#cutend"),
        $ctr = $(".container-steps"),
        $ul = $("#ul"),
        $dl = $("#dl"),
        $dlform = $("#formurl"),
        $dlform2 = $("#urlform"),
        text = 'Kein Ton',
        bar = $('#upload_bar'),
        status = $('#status'),
        $file = $('#file');

    $('#form').ajaxForm({
        cache: false,
        dataType: 'json',
        beforeSend: function () {
            $('#full').fadeIn();
        },
        uploadProgress: function (event, position, total, percentComplete) {
            var percentVal = percentComplete + '%';
            bar.width(percentVal);
            bar.html(percentVal);
        },
        success: function(data)
        {
            if(data.sucess === true)
                document.location.href = '/converter/progress/' + data.guid;
        },
        error: function(data)
        {
            $('#full').fadeOut();
            $.each(data, function(index, element) {
                if(typeof (element.url) !== 'undefined') {
                    $(this).queue(function(){
                        $ctr.addClass("ul slider-ul-active").removeClass("clip slider-clip-active");
                        $(this).dequeue();
                        alert(element.url);
                    });
                }
                else if(typeof (element.file) !== 'undefined') {
                    $(this).queue(function(){
                        $ctr.addClass("ul slider-ul-active").removeClass("clip slider-clip-active");
                        $(this).dequeue();
                        alert(element.file);
                    });
                }
            });
        }
    });

    function is_supported(path) {
        if (path.includes('.')) {
            var url_array = path.split('.'),
                format = url_array[url_array.length - 1],
                supported_formats = ["webm", "mp4", "mkv", "mov", "avi", "wmv", "flv", "3gp", "gif"];
            return (supported_formats.indexOf(format.toLowerCase()) > -1);
        }
        return false;
    }

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
        $(this).queue(function(){
            $ctr.addClass("ul slider-ul-active").removeClass("start slider-start-active");
            $(this).dequeue();
        });
        e.preventDefault();
    });

    $ultypeButton.on("click", function(e){
        $(this).delay(200).queue(function(){
            $ctr.addClass("choose slider-choose-active").removeClass("ul slider-ul-active");
            if($ul.is(':checked') == true) {
                $("#mydropzone").show();
                $dlform.hide();
                $dlform2.hide();
            }
            if($dl.is(':checked') == true) {
                $chooseButton.removeAttr('disabled');
                $file.removeAttr('required');
                $dlform.show();
                $dlform2.show();
                $("#mydropzone").hide();
            }
            $(this).dequeue();
        });
        e.preventDefault();
    });

    $chooseButton.on("click", function (e) {
        if(($dl.is(':checked') && $('#urlform').val()) || $ul.is(':checked')) {
            $(this).delay(200).queue(function () {
                $ctr.addClass("size slider-size-active").removeClass("choose slider-choose-active");
                $(this).dequeue();
            });
        }
        else
            alert('Bitte eine URL eingeben!');

        e.preventDefault();
    });

    $chooseButtonBack.on("click", function (e) {
        $(this).delay(200).queue(function () {
            $ctr.addClass("ul slider-ul-active").removeClass("choose slider-choose-active");
            $(this).dequeue();
        });
        e.preventDefault();
    });

    $sizeButton.on("click", function (e) {
        $(this).delay(200).queue(function () {
            $ctr.addClass("sound slider-sound-active").removeClass("size slider-size-active");
            $(this).dequeue();
        });
        e.preventDefault();
    });

    $sizeButtonBack.on("click", function (e) {
        $(this).delay(200).queue(function () {
            $ctr.addClass("choose slider-choose-active").removeClass("size slider-size-active");
            $(this).dequeue();
        });
        e.preventDefault();
    });

    $soundButton.on("click", function (e) {
        $(this).delay(200).queue(function () {
            $ctr.addClass("res slider-res-active").removeClass("sound slider-sound-active");
            $(this).dequeue();
        });
        e.preventDefault();
    });

    $soundButtonBack.on("click", function (e) {
        $(this).delay(200).queue(function () {
            $ctr.addClass("size slider-size-active").removeClass("sound slider-sound-active");
            $(this).dequeue();
        });
        e.preventDefault();
    });

    $resButton.on("click", function (e) {
        $(this).delay(200).queue(function () {
            $ctr.addClass("clip slider-clip-active").removeClass("res slider-res-active");
            $(this).dequeue();
        });
        e.preventDefault();
    });

    $resButtonBack.on("click", function (e) {
        $(this).delay(200).queue(function () {
            $ctr.addClass("sound slider-sound-active").removeClass("res slider-res-active");
            $(this).dequeue();
        });
        e.preventDefault();
    });

    $clipButtonBack.on("click", function (e) {
        $(this).delay(200).queue(function () {
            $ctr.addClass("res slider-res-active").removeClass("clip slider-clip-active");
            $(this).dequeue();
        });
        e.preventDefault();
    });

    $ul.on("click", function (e) {
        $ultypeButton.removeAttr("disabled");
    });

    $dl.on("click", function (e) {
        $ultypeButton.removeAttr("disabled");
    });

    $file.on( "change", function (e) {
        if(is_supported($(this).val()))
            $chooseButton.removeAttr('disabled');
        else {
            alert('Bitte ein Video mit richtigem Format angeben!');
            $(this).val(function() {
                return this.defaultValue;
            });
        }
    });
});
