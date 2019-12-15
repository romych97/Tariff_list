function prev(tarif, page) {
    document.getElementsByClassName('main')[0].innerHTML = '';
    $.ajax({
        method: "POST",
        url: 'actions/scrapping.php',
        data: {content_type : tarif, page: page},
        success: function(data) {
            document.getElementsByClassName('main')[0].innerHTML = data;
        }
    });
}

function next(val, page, prev = '') {
    document.getElementsByClassName('main')[0].innerHTML = '';
    $.ajax({
        method: "POST",
        url: 'actions/scrapping.php',
        data: {content_type : val, page: page, prev: prev},
        success: function(data) {
            document.getElementsByClassName('main')[0].innerHTML = data;
        }
    });
}


$(".block").hover(function() {
  $('.block-header').css("background-color","red")
});