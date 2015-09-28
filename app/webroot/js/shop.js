$(document).ready(function() {
    $(function() {
        if ($(".searchSpan select").length) {   
            $(".searchSpan select").selectbox();
        }
    });
//    $(".searchSpan select").selectbox();
    var i = 1;
    var firstUse = 0;
    $('#imgPager div div a, #PagerNavi .rightNavi').click(function() {
        var countElement = $('#imgPager img').length;

        if (countElement > 1) {
            if (i > 0 && i < countElement - 1 && firstUse !== 0 || i === 0) {
                i++;
                $('#imgPager div div').css({'display': 'none'});
                $('#imgPager div div').eq(i).css({'display': 'block'});
            } else if (i === 1 && firstUse === 0) {
                i = 0;
                i++;
                firstUse++;
                $('#imgPager div div').css({'display': 'none'});
                $('#imgPager div div').eq(i).css({'display': 'block'});

            } else if (i === countElement - 1) {
                i = 0;
                $('#imgPager div div').css({'display': 'none'});
                $('#imgPager div div').eq(i).css({'display': 'block'});

            }
        }
        return false;
    });

    $('#PagerNavi .leftNavi').click(function() {
        var countElement = $('#imgPager img').length;

        if (countElement > 1) {
            if (i > 0 && i < countElement && firstUse !== 0) {
                i--;
                $('#imgPager div div').css({'display': 'none'});
                $('#imgPager div div').eq(i).css({'display': 'block'});
            } else
            if (i === 1 && firstUse === 0) {
                i = countElement;
                i--;
                firstUse++;
                $('#imgPager div div').css({'display': 'none'});
                $('#imgPager div div').eq(i).css({'display': 'block'});

            }
            else if (i === 0) {
                i = countElement;
                i--;
                $('#imgPager div div').css({'display': 'none'});
                $('#imgPager div div').eq(i).css({'display': 'block'});
            }
        }
        return false;
    });
    
});