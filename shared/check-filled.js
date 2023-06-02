var form = document.getElementById("worker-data-form");

  form.addEventListener("submit", function(event) {
    event.preventDefault(); // Отменить отправку формы

    // Проверить заполненность всех полей
    var lastName = document.getElementById("last_name").value;
    var username = document.getElementById("username").value;
    var password = document.getElementById("password").value;
    var room_id = document.querySelector('input[name="room_id"]:checked');
    var computer = document.querySelector('input[name="computer"]:checked');

    if (lastName === "" || username === "" || password === "" || room_id === null || computer === null) {
      alert("Пожалуйста, заполните все поля формы.");
      return;
    }

    // Если все поля заполнены, можно отправить форму
    form.submit();
})