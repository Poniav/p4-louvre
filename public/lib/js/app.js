$(function () {

    var a = '#back-to-top';

    if ($(a).length) {
        var scrollTrigger = 100, // px
            backToTop = function () {
                var scrollTop = $(window).scrollTop();
                if (scrollTop > scrollTrigger) {
                    $('#back-to-top').addClass('show');
                } else {
                    $('#back-to-top').removeClass('show');
                }
            };
        backToTop();
        $(window).on('scroll', function () {
            backToTop();
        });
        $(a).on('click', function (e) {
            e.preventDefault();
            $('html,body').animate({
                scrollTop: 0
            }, 700);
        });
    }

    $.fn.datepicker.dates['fr'] = {
        days: ["Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi"],
        daysShort: ["Dim", "Lun", "Mar", "Mer", "Jeu", "Ven", "Sam"],
        daysMin: ["Di", "Lu", "Ma", "Me", "Je", "Ve", "Sa"],
        months: ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"],
        monthsShort: ["Jan", "Fév", "Mar", "Avr", "Mai", "Jun", "Jui", "Aoû", "Sep", "Oct", "Nov", "Déc"],
        format: "dd/mm/yyyy",
        titleFormat: "MM yyyy",
        weekStart: 0
    };

    /*$('.datepicker').datepicker({
        format: 'dd/mm/yyyy',
        startDate: new Date(),
        language: "fr",
        todayHighlight: true,
        multidate: false,
        daysOfWeekDisabled: "0,2",
        datesDisabled: ['01/05/2018', '01/11/2018', '25/12/2018']
    });*/

    $('.datepicker').datepicker({
        format: "dd/mm/yyyy", // Format
        startDate: "new Date()", // Start date of calendar
        language: "fr",
        multidate: false,
        keyboardNavigation: false,
        // daysOfWeekDisabled: "0,2",  // Disable Sunday and Tuesday
        autoclose: true,
        todayHighlight: true,
        // datesDisabled: ['01/05/2018', '01/11/2018', '25/12/2018'],  // Disable Public Holidays
        toggleActive: true
        // defaultViewDate: { year: 1977, month: 04, day: 25 }
    });

    var datepickercl = '.datepicker-tickets';

    $(datepickercl).datepicker({
        format: "dd/mm/yyyy",
        // endDate: "new Date()", //
        language: "fr",
        multidate: false,
        keyboardNavigation: false,
        autoclose: true,
        toggleActive: true,
        startView: 'century'
    });

    function stringToDate(_date,_format,_delimiter)
    {
        var formatLowerCase = _format.toLowerCase();
        var formatItems = formatLowerCase.split(_delimiter);
        var dateItems = _date.split(_delimiter);
        var monthIndex = formatItems.indexOf("mm");
        var dayIndex = formatItems.indexOf("dd");
        var yearIndex = formatItems.indexOf("yyyy");
        var month = parseInt(dateItems[monthIndex]);
        month-=1;
        var formatedDate = new Date(dateItems[yearIndex],month,dateItems[dayIndex]);
        return formatedDate;
    }


    $(datepickercl).on("change", function () {

        var myDates = stringToDate($(this).val(), 'mm/dd/yyyy', '/'); // convert the input string to date
        var nDate = new Date(); // init the new date

        var elem = $(this)["0"].name; // get class name
        var num = parseInt(elem.replace(/[^0-9]/g,'')); // get number digit in class name and increase of 1
        var priceTicket = $("li[class*='ticket-']"); // get all tickets

        var test = priceTicket[num].childNodes[3].innerHTML = "35€";
        console.log(test);
        console.log(priceTicket);
        console.log(myDates);
        console.log(nDate);

    });

});



