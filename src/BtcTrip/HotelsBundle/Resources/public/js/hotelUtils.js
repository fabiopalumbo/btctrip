$(function() {


    cantidad_maxima = 8;
    var array_rooms = new Array();
    array_rooms['adult_id_1'] = 8;
    array_rooms['adult_id_2'] = 8;
    array_rooms['adult_id_3'] = 8;
    array_rooms['adult_id_4'] = 8;



    $("#sb-hotels").change(function() {
        switch ($("#sb-hotels").val()) {
            case '1':
                {
                    $("#roomdos").attr("class", "com-passenger cp-2 hidden");
                    $("#roomtres").attr("class", "com-passenger cp-3 hidden");
                    $("#roomcuatro").attr("class", "com-passenger cp-4 hidden");
                    $("#labelroomuno").attr("class", "lbl-room-1 hidden");
                    $("#labelroomdos").attr("class", "lbl-room-2 hidden");
                    $("#labelroomtres").attr("class", "lbl-room-3 hidden");
                    $("#labelroomcuatro").attr("class", "lbl-room-4 hidden");
                    break;
                }
            case '2':
                {
                    $("#roomdos").attr("class", "com-passenger cp-2");
                    $("#roomtres").attr("class", "com-passenger cp-3 hidden");
                    $("#roomcuatro").attr("class", "com-passenger cp-4 hidden");
                    $("#labelroomuno").attr("class", "lbl-room-1");
                    $("#labelroomdos").attr("class", "lbl-room-2");
                    $("#labelroomtres").attr("class", "lbl-room-3 hidden");
                    $("#labelroomcuatro").attr("class", "lbl-room-4 hidden");
                    break;
                }
            case '3':
                {
                    $("#roomdos").attr("class", "com-passenger cp-2");
                    $("#roomtres").attr("class", "com-passenger cp-3");
                    $("#roomcuatro").attr("class", "com-passenger cp-4 hidden");
                    $("#labelroomuno").attr("class", "lbl-room-1");
                    $("#labelroomdos").attr("class", "lbl-room-2");
                    $("#labelroomtres").attr("class", "lbl-room-3");
                    $("#labelroomcuatro").attr("class", "lbl-room-4 hidden");
                    break;
                }
            case '4':
                {
                    $("#roomdos").attr("class", "com-passenger cp-2");
                    $("#roomtres").attr("class", "com-passenger cp-3");
                    $("#roomcuatro").attr("class", "com-passenger cp-4");
                    $("#labelroomuno").attr("class", "lbl-room-1");
                    $("#labelroomdos").attr("class", "lbl-room-2");
                    $("#labelroomtres").attr("class", "lbl-room-3");
                    $("#labelroomcuatro").attr("class", "lbl-room-4");
                    break;
                }
            default:
                {
                    $("#roomdos").attr("class", "com-passenger cp-2 hidden");
                    $("#roomtres").attr("class", "com-passenger cp-3 hidden");
                    $("#roomcuatro").attr("class", "com-passenger cp-4 hidden");
                    $("#labelroomuno").attr("class", "lbl-room-1 hidden");
                    $("#labelroomdos").attr("class", "lbl-room-2 hidden");
                    $("#labelroomtres").attr("class", "lbl-room-3 hidden");
                    $("#labelroomcuatro").attr("class", "lbl-room-4 hidden");
                }
        }

    });
    function agregarEdadesHab1() {
        cant = $("#child_id_1").val();
        $("#div_age_1").attr('class', "ctn-age hidden");
        $("#li_age_1_1").attr('class', 'ctn-selects-age room-1 ctn-1 hidden');
        $("#li_age_1_2").attr('class', 'ctn-selects-age room-1 ctn-2 hidden');
        $("#li_age_1_3").attr('class', 'ctn-selects-age room-1 ctn-3 hidden');
        $("#li_age_1_4").attr('class', 'ctn-selects-age room-1 ctn-4 hidden');
        $("#li_age_1_5").attr('class', 'ctn-selects-age room-1 ctn-5 hidden');
        for (var i = 1; i <= cant; i++) {
            $("#div_age_1").attr('class', "ctn-age");
            $("#li_age_1_" + i).attr('class', 'ctn-selects-age room-' + i + ' ctn-' + i);
            $("#age_id_1_" + i).val('-1');
        }
    }

    $("#child_id_1").change(function() {
        agregarEdadesHab1();
    });

    function agregarEdadesHab2() {
        cant = $("#child_id_2").val();
        $("#div_age_2").attr('class', "ctn-age hidden");
        $("#li_age_2_1").attr('class', 'ctn-selects-age room-2 ctn-1 hidden');
        $("#li_age_2_2").attr('class', 'ctn-selects-age room-2 ctn-2 hidden');
        $("#li_age_2_3").attr('class', 'ctn-selects-age room-2 ctn-3 hidden');
        $("#li_age_2_4").attr('class', 'ctn-selects-age room-2 ctn-4 hidden');
        $("#li_age_2_5").attr('class', 'ctn-selects-age room-2 ctn-5 hidden');
        for (var i = 1; i <= cant; i++) {
            $("#div_age_2").attr('class', "ctn-age");
            $("#li_age_2_" + i).attr('class', 'ctn-selects-age room-2 ctn-' + i);
            $("#age_id_2_" + i).val('-1');
        }
    }


    $("#child_id_2").change(function() {
        agregarEdadesHab2();
    });

    function agregarEdadesHab3() {
        cant = $("#child_id_3").val();
        $("#div_age_3").attr('class', "ctn-age hidden");
        $("#li_age_3_1").attr('class', 'ctn-selects-age room-3 ctn-1 hidden');
        $("#li_age_3_2").attr('class', 'ctn-selects-age room-3 ctn-2 hidden');
        $("#li_age_3_3").attr('class', 'ctn-selects-age room-3 ctn-3 hidden');
        $("#li_age_3_4").attr('class', 'ctn-selects-age room-3 ctn-4 hidden');
        $("#li_age_3_5").attr('class', 'ctn-selects-age room-3 ctn-5 hidden');
        for (var i = 1; i <= cant; i++) {
            $("#div_age_3").attr('class', "ctn-age");
            $("#li_age_3_" + i).attr('class', 'ctn-selects-age room-3' + ' ctn-' + i);
            $("#age_id_3_" + i).val('-1');
        }
    }
    $("#child_id_3").change(function() {
        agregarEdadesHab3();
    });
    
    function agregarEdadesHab4(){
         cant = $("#child_id_4").val();
        $("#div_age_4").attr('class', "ctn-age hidden");
        $("#li_age_4_1").attr('class', 'ctn-selects-age room-4 ctn-1 hidden');
        $("#li_age_4_2").attr('class', 'ctn-selects-age room-4 ctn-2 hidden');
        $("#li_age_4_3").attr('class', 'ctn-selects-age room-4 ctn-3 hidden');
        $("#li_age_4_4").attr('class', 'ctn-selects-age room-4 ctn-4 hidden');
        $("#li_age_4_5").attr('class', 'ctn-selects-age room-4 ctn-5 hidden');
        for (var i = 1; i <= cant; i++) {
            $("#div_age_4").attr('class', "ctn-age");
            $("#li_age_4_" + i).attr('class', 'ctn-selects-age room-4 ctn-' + i);
            $("#age_id_4_" + i).val('-1');
        }
    }
    $("#child_id_4").change(function() {
       agregarEdadesHab4();
    });

    $("#adult_id_1").change(function() {
        cant = $("#adult_id_1").val();
        var select = $('#child_id_1');
        var options = select.attr('options');
        $('option', select).remove();
        for (var i = 0; i <= (8 - cant); i++) {
            if (i < 6) {
                $('#child_id_1').append("<option value='" + i + "'>" + i + "</option>");
            }
        }
        agregarEdadesHab1();
    });
    
    $("#adult_id_2").change(function() {
        cant = $("#adult_id_2").val();
        var select = $('#child_id_2');
        var options = select.attr('options');
        $('option', select).remove();
        for (var i = 0; i <= (8 - cant); i++) {
            if (i < 6) {
                $('#child_id_2').append("<option value='" + i + "'>" + i + "</option>");
            }
        }
        agregarEdadesHab2();
    });
    
    
    $("#adult_id_3").change(function() {
        cant = $("#adult_id_3").val();
        var select = $('#child_id_3');
        var options = select.attr('options');
        $('option', select).remove();
        for (var i = 0; i <= (8 - cant); i++) {
            if (i < 6) {
                $('#child_id_3').append("<option value='" + i + "'>" + i + "</option>");
            }
        }
        agregarEdadesHab3();
    });
    $("#adult_id_4").change(function() {
        cant = $("#adult_id_4").val();
        var select = $('#child_id_4');
        var options = select.attr('options');
        $('option', select).remove();
        for (var i = 0; i <= (8 - cant); i++) {
            if (i < 6) {
                $('#child_id_4').append("<option value='" + i + "'>" + i + "</option>");
            }
        }
        agregarEdadesHab4();
    });


});

function armarHabitaciones(cantidad_habitacion) {

    switch (cantidad_habitacion) {
        case '1':
            {
                $("#roomdos").attr("class", "com-passenger cp-2 hidden");
                $("#roomtres").attr("class", "com-passenger cp-3 hidden");
                $("#roomcuatro").attr("class", "com-passenger cp-4 hidden");
                $("#labelroomuno").attr("class", "lbl-room-1 hidden");
                $("#labelroomdos").attr("class", "lbl-room-2 hidden");
                $("#labelroomtres").attr("class", "lbl-room-3 hidden");
                $("#labelroomcuatro").attr("class", "lbl-room-4 hidden");
                break;
            }
        case '2':
            {
                $("#roomdos").attr("class", "com-passenger cp-2");
                $("#roomtres").attr("class", "com-passenger cp-3 hidden");
                $("#roomcuatro").attr("class", "com-passenger cp-4 hidden");
                $("#labelroomuno").attr("class", "lbl-room-1");
                $("#labelroomdos").attr("class", "lbl-room-2");
                $("#labelroomtres").attr("class", "lbl-room-3 hidden");
                $("#labelroomcuatro").attr("class", "lbl-room-4 hidden");
                break;
            }
        case '3':
            {
                $("#roomdos").attr("class", "com-passenger cp-2");
                $("#roomtres").attr("class", "com-passenger cp-3");
                $("#roomcuatro").attr("class", "com-passenger cp-4 hidden");
                $("#labelroomuno").attr("class", "lbl-room-1");
                $("#labelroomdos").attr("class", "lbl-room-2");
                $("#labelroomtres").attr("class", "lbl-room-3");
                $("#labelroomcuatro").attr("class", "lbl-room-4 hidden");
                break;
            }
        case '4':
            {
                $("#roomdos").attr("class", "com-passenger cp-2");
                $("#roomtres").attr("class", "com-passenger cp-3");
                $("#roomcuatro").attr("class", "com-passenger cp-4");
                $("#labelroomuno").attr("class", "lbl-room-1");
                $("#labelroomdos").attr("class", "lbl-room-2");
                $("#labelroomtres").attr("class", "lbl-room-3");
                $("#labelroomcuatro").attr("class", "lbl-room-4");
                break;
            }
        default:
            {
                $("#roomdos").attr("class", "com-passenger cp-2 hidden");
                $("#roomtres").attr("class", "com-passenger cp-3 hidden");
                $("#roomcuatro").attr("class", "com-passenger cp-4 hidden");
                $("#labelroomuno").attr("class", "lbl-room-1 hidden");
                $("#labelroomdos").attr("class", "lbl-room-2 hidden");
                $("#labelroomtres").attr("class", "lbl-room-3 hidden");
                $("#labelroomcuatro").attr("class", "lbl-room-4 hidden");
            }
    }


}

function armarHuespedes() {
    cant = $("#child_id_1").val();
    $("#div_age_1").attr('class', "ctn-age hidden");
    $("#li_age_1_1").attr('class', 'ctn-selects-age room-1 ctn-1 hidden');
    $("#li_age_1_2").attr('class', 'ctn-selects-age room-1 ctn-2 hidden');
    $("#li_age_1_3").attr('class', 'ctn-selects-age room-1 ctn-3 hidden');
    $("#li_age_1_4").attr('class', 'ctn-selects-age room-1 ctn-4 hidden');
    $("#li_age_1_5").attr('class', 'ctn-selects-age room-1 ctn-5 hidden');
    if ((cant != '') && (cant > 0)) {
        for (var i = 1; i <= cant; i++) {
            $("#div_age_1").attr('class', "ctn-age");
            $("#li_age_1_" + i).attr('class', 'ctn-selects-age room-' + i + ' ctn-' + i);
            $("#li_age_1_" + i).val('-1');
            
        }
    }

    cant = $("#child_id_2").val();
    $("#div_age_2").attr('class', "ctn-age hidden");
    $("#li_age_2_1").attr('class', 'ctn-selects-age room-2 ctn-1 hidden');
    $("#li_age_2_2").attr('class', 'ctn-selects-age room-2 ctn-2 hidden');
    $("#li_age_2_3").attr('class', 'ctn-selects-age room-2 ctn-3 hidden');
    $("#li_age_2_4").attr('class', 'ctn-selects-age room-2 ctn-4 hidden');
    $("#li_age_2_5").attr('class', 'ctn-selects-age room-2 ctn-5 hidden');
    if ((cant != '') && (cant > 0)) {
        for (var i = 1; i <= cant; i++) {
            $("#div_age_2").attr('class', "ctn-age");
            $("#li_age_2_" + i).attr('class', 'ctn-selects-age room-2 ctn-' + i);
            $("#li_age_2_" + i).val('-1');
        }
    }


    cant = $("#child_id_3").val();
    $("#div_age_3").attr('class', "ctn-age hidden");
    $("#li_age_3_1").attr('class', 'ctn-selects-age room-3 ctn-1 hidden');
    $("#li_age_3_2").attr('class', 'ctn-selects-age room-3 ctn-2 hidden');
    $("#li_age_3_3").attr('class', 'ctn-selects-age room-3 ctn-3 hidden');
    $("#li_age_3_4").attr('class', 'ctn-selects-age room-3 ctn-4 hidden');
    $("#li_age_3_5").attr('class', 'ctn-selects-age room-3 ctn-5 hidden');

    if ((cant != '') && (cant > 0)) {
        for (var i = 1; i <= cant; i++) {
            $("#div_age_3").attr('class', "ctn-age");
            $("#li_age_3_" + i).attr('class', 'ctn-selects-age room-3' + ' ctn-' + i);
            $("#li_age_3_" + i).val('-1');
        }
    }
    cant = $("#child_id_4").val();
    $("#div_age_4").attr('class', "ctn-age hidden");
    $("#li_age_4_1").attr('class', 'ctn-selects-age room-4 ctn-1 hidden');
    $("#li_age_4_2").attr('class', 'ctn-selects-age room-4 ctn-2 hidden');
    $("#li_age_4_3").attr('class', 'ctn-selects-age room-4 ctn-3 hidden');
    $("#li_age_4_4").attr('class', 'ctn-selects-age room-4 ctn-4 hidden');
    $("#li_age_4_5").attr('class', 'ctn-selects-age room-4 ctn-5 hidden');
    if ((cant != '') && (cant > 0)) {
        for (var i = 1; i <= cant; i++) {
            $("#div_age_4").attr('class', "ctn-age");
            $("#li_age_4_" + i).attr('class', 'ctn-selects-age room-4 ctn-' + i);
            $("#li_age_4_" + i).val('-1');
        }
    }
}

function searchHotels() {

    hotels_id = $("#hidden-destination-hotels").val();
    check_in = $("#sb-datein-hotels").val();
    check_out = $("#sb-dateout-hotels").val();
    distribution = armarDistribution();
    page = 1;
    type = $("#hidden-destination-type").val();
    destino_hotel = $("#sb-destination-hotels").val();
    if (type == 'city') {
        document.location.href = '/hotels/result/' + hotels_id + '/' + check_in + '/' + check_out + '/' + distribution + '/' + page;
    } else {
        document.location.href = '/hotels/show/' + hotels_id + '/' + check_in + '/' + check_out + '/' + distribution;
    }



}

function armarDistribution() {
    distribution_text_room_uno = '';
    distribution_text_room_dos = '';
    distribution_text_room_tres = '';
    distribution_text_room_cuatro = '';

    distribution_text_room = '';

    switch ($("#sb-hotels").val()) {
        case '1':
            {
                distribution_text_room_uno = armarDistributionRoonUno();
                distribution_text_room = distribution_text_room_uno;
                break;
            }
        case '2':
            {
                distribution_text_room_uno = armarDistributionRoonUno();
                distribution_text_room_dos = armarDistributionRoonDos();
                distribution_text_room = distribution_text_room_uno + '!' + distribution_text_room_dos;
                break;
            }
        case '3':
            {
                distribution_text_room_uno = armarDistributionRoonUno();
                distribution_text_room_dos = armarDistributionRoonDos();
                distribution_text_room_tres = armarDistributionRoonTres();
                distribution_text_room = distribution_text_room_uno + '!' + distribution_text_room_dos + '!' + distribution_text_room_tres;
                break;
            }
        case '4':
            {
                distribution_text_room_uno = armarDistributionRoonUno();
                distribution_text_room_dos = armarDistributionRoonDos();
                distribution_text_room_tres = armarDistributionRoonTres();
                distribution_text_room_cuatro = armarDistributionRoonCuatro();
                distribution_text_room = distribution_text_room_uno + '!' + distribution_text_room_dos + '!' + distribution_text_room_tres + '!' + distribution_text_room_cuatro;
                break;
            }
        default:
            {
                distribution_text_room_uno = armarDistributionRoonUno();
                distribution_text_room = distribution_text_room_uno;
            }
    }
    return distribution_text_room;
}

function armarDistributionRoonUno() {
    count_adult = $("#adult_id_1").val();
    count_child = $("#child_id_1").val();
    age_child = '';

    for (var i = 1; i <= count_child; i++) {
        if (($("#age_id_1_" + i).val() != '0' ) && ($("#age_id_1_" + i).val() != '-1')) {
            if (age_child == '') {
                age_child = $("#age_id_1_" + i).val();
            } else {
                age_child = age_child + "-" + $("#age_id_1_" + i).val();
            }
        }
    }
    result = count_adult;
    if (age_child != '') {
        result = count_adult + "-" + age_child;
    }
    return result;
}
function armarDistributionRoonDos() {
    count_adult = $("#adult_id_2").val();
    count_child = $("#child_id_2").val();
    age_child = '';
    for (var i = 1; i <= count_child; i++) {
        if (($("#age_id_2_" + i).val() != '0' ) && ($("#age_id_2_" + i).val() != '-1')) {
            if (age_child == '') {
                age_child = $("#age_id_2_" + i).val();
            } else {
                age_child = age_child + "-" + $("#age_id_2_" + i).val();
            }
        }
    }
    result = count_adult;
    if (age_child != '') {
        result = count_adult + "-" + age_child;
    }
    return result;
}

function armarDistributionRoonTres() {
    count_adult = $("#adult_id_3").val();
    count_child = $("#child_id_3").val();
    age_child = '';
    for (var i = 1; i <= count_child; i++) {
         if (($("#age_id_3_" + i).val() != '0' ) && ($("#age_id_3_" + i).val() != '-1')) {
            if (age_child == '') {
                age_child = $("#age_id_3_" + i).val();
            } else {
                age_child = age_child + "-" + $("#age_id_3_" + i).val();
            }
        }
    }
    result = count_adult;
    if (age_child != '') {
        result = count_adult + "-" + age_child;
    }
    return result;
}

function armarDistributionRoonCuatro() {
    count_adult = $("#adult_id_4").val();
    count_child = $("#child_id_4").val();
    age_child = '';
    for (var i = 1; i <= count_child; i++) {
        if (($("#age_id_4_" + i).val() != '0' ) && ($("#age_id_4_" + i).val() != '-1')) {
            if (age_child == '') {
                age_child = $("#age_id_4_" + i).val();
            } else {
                age_child = age_child + "-" + $("#age_id_4_" + i).val();
            }
        }
    }
    result = count_adult;
    if (age_child != '') {
        result = count_adult + "-" + age_child;
    }
    return result;
}