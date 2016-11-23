//$(document).ready(function () {
    $('.id_specialists').click(function () {
        var id = this.getAttribute('id');
        //alert(id);
        $.post("../../specialists/id/", {'idSpecialists': id}, function (data, status) {
            var json = JSON.parse(data);
            var specialists = json.product;

            $('#results').html('');
            $('.pagination').html('');

            var avatar = document.getElementById('avatar');
            avatar.innerHTML = '<img src="' + specialists[0].avatar + '" class="img-product"> ';
            var name = document.getElementById('name');
            name.innerHTML = specialists[0].name;
            var surname = document.getElementById('surname');
            surname.innerHTML = specialists[0].surname;
            var city = document.getElementById('city');
            city.innerHTML = "City: " + specialists[0].city;
            var specialty = document.getElementById('specialty');
            specialty.innerHTML = specialists[0].specialty;
            specialty.setAttribute("class", "special");

        })
                .fail(function (xhr) {
                  if (xhr.status === 404) {
                      $("#results").load("../../specialists/view_error_false/", {'view_error': false});
                  } else {
                      $("#results").load("../../specialists/view_error_true/", {'view_error': true});
                  }
                });
    });
