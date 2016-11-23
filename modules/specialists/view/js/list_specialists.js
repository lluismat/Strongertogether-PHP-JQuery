function validate_search(search_value){
  if(search_value.length > 0){
    var regexp = /^[0-9a-zA-Z]+[\-'\s]?[0-9a-zA-Z ]+$/;
    return regexp.test(search_value);
  }
  return false;
}

function refresh(){
  $('.pagination').html='';
  $('.pagination').val ='';
}

function search(keyword){

      $.post("../../products_specialists/num_pages/", {'num_pages': true, 'keyword': keyword}, function (data, status) {

      console.log(data);
      var json = JSON.parse(data);
      var pages = json.pages;

$("#results").load("../../specialists/obtain_specialists/", {'keyword': keyword});
if (pages !== 0) {
    refresh();

    $(".pagination").bootpag({
        total: pages,
        page: 1,
        maxVisible: 5,
        next: 'next',
        prev: 'prev'
    }).on("page", function (e, num) {
        e.preventDefault();
        if (!keyword)
            $("#results").load("../../specialists/obtain_specialists/", {'page_num': num});
        else
            $("#results").load("../../specialists/obtain_specialists/", {'page_num': num, 'keyword': keyword});
        reset();
    });
} else {
    $("#results").load("../../specialists/view_error_false/", {'view_error': false}); //view_error=false
    $('.pagination').html('');
    reset();
}
reset();

}).fail(function (xhr) {
$("#results").load("../../specialists/view_error_true/", {'view_error': true});
$('.pagination').html('');
reset();
});

}//fi function search

function search_product(keyword) {
    //$.get("index.php?module=products_frontend&function=name_products&name_products="+keyword, function(data, status){
    $.post("../../specialists/name_specialists/", {'name_products': keyword}, function (data, status) {
        var json = JSON.parse(data);
        var product = json.product_autocomplete;

        $('#results').html('');
        $('.pagination').html('');

        var avatar = document.getElementById('avatar');
        avatar.innerHTML = '<img src="' + product[0].avatar + '" class="img-product"> ';
        var name = document.getElementById('name');
        name.innerHTML = product[0].name;
        var surname = document.getElementById('surname');
        surname.innerHTML = product[0].surname;
        var city = document.getElementById('price_prod');
        city.innerHTML = "City: " + product[0].city;
        var specialty = document.getElementById('specialty');
        specialty.innerHTML = product[0].specialty;
        specialty.setAttribute("class", "special");

    }).fail(function (xhr) {
        $("#results").load("../../specialists/view_error_false/", {'view_error': false});
        $('.pagination').html('');
        reset();
    });
}//fi function search_product

function count_product(keyword) {
    //$.get("index.php?module=products_frontend&function=count_products&count_product=" + keyword, function (data, status) {
    $.post("../../specialists/count_specialists/", {'count_product': keyword}, function (data, status) {
        var json = JSON.parse(data);
        var num_products = json.num_products;

        if (num_products == 0) {
            $("#results").load("../../specialists/view_error_false/", {'view_error': false}); //view_error=false
            $('.pagination').html('');
            reset();
        }
        if (num_products == 1) {
            search_product(keyword);
        }
        if (num_products > 1) {
            search(keyword);
        }
    }).fail(function () {
        $("#results").load("../../specialists/view_error_false/", {'view_error': false}); //view_error=false
        $('.pagination').html('');
        reset();
    });
}//fi function count_product


function reset() {
    $('#avatar').html('');
    $('#name').html('');
    $('#surname').html('');
    $('#specialty').html('');
    $('#city').html('');
    $('#city').removeClass("special");

    $('#keyword').val('');
}

$(document).ready(function () {
    ////////////////////////// inici carregar pàgina /////////////////////////

    if (getCookie("search")) {
        var keyword=getCookie("search");
        count_product(keyword);
        //alert("carrega pagina getCookie(search): " + getCookie("search"));
       //("#keyword").val(keyword) if we don't use refresh(), this way we could show the search param
        setCookie("search","",1);
    } else {
        search();
    }


    $("#search_prod").submit(function (e) {
        var keyword = document.getElementById('keyword').value;
        var v_keyword = validate_search(keyword);
        if (v_keyword)
            setCookie("search", keyword, 1);
        //alert("getCookie(search): " + getCookie("search"));
        location.reload(true);


        //si no ponemos la siguiente línea, el navegador nos redirecciona a index.php
        e.preventDefault(); //STOP default action
    });

    $('#Submit').click(function () {
        var keyword = document.getElementById('keyword').value;
        var v_keyword = validate_search(keyword);
        if (v_keyword)
            setCookie("search", keyword, 1);
        //alert("getCookie(search): " + getCookie("search"));
        location.reload(true);

    });

    //$.get("index.php?module=products_frontend&function=autocomplete&autocomplete=true", function (data, status) {
    $.post("../../specialists/autocomplete/", {'autocomplete': true}, function (data, status) {
        var json = JSON.parse(data);
        var name_products = json.nom_productos;

        var suggestions = new Array();
        for (var i = 0; i < name_products.length; i++) {
            suggestions.push(name_products[i].name);
        }
        $("#keyword").autocomplete({
            source: suggestions,
            minLength: 1,
            select: function (event, ui) {
                var keyword = ui.item.label;
                count_product(keyword);
            }
        });
    }).fail(function (xhr) {
        $("#results").load("../../specialists/view_error_false/", {'view_error': false}); //view_error=false
        $('.pagination').html('');
        reset();
    });

});


function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + "; " + expires;
}

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ')
            c = c.substring(1);
        if (c.indexOf(name) == 0)
            return c.substring(name.length, c.length);
    }
    return 0;
}
