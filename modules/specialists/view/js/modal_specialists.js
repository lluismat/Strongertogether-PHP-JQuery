//$(document).ready(function () {
    $('.id_prod').click(function () {
        var id = this.getAttribute('id');
        //alert(id);

        //$.get("index.php?module=products_frontend&function=idProduct&idProducto=" + id, function (data, status) {
        $.post("../../products_frontend/idProduct/", {'idProduct': id}, function (data, status) {
            var json = JSON.parse(data);
            var product = json.product;

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

        })
                .fail(function (xhr) {
                  if (xhr.status === 404) {
                      $("#results").load("../../products_frontend/view_error_false/", {'view_error': false});
                  } else {
                      $("#results").load("../../products_frontend/view_error_true/", {'view_error': true});
                  }
                });
    });
