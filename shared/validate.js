$(document).ready(function() {
    $.validator.addMethod("strongPassword", function(value, element) {
      return this.optional(element) || /^(?=.*[A-Za-z])(?=.*\d).+$/.test(value);
    }, "Пароль должен содержать хотя бы одну букву и хотя бы одну цифру.");

    $("#worker-data-form").validate({
      rules: {
        last_name: "required",
        username: "required",
        password: {
          required: true,
          minlength: 6,
          strongPassword: true // Проверка наличия буквы и цифры
        },
        room_id: "required",
        computer: "required"
      },
      messages: {
        last_name: "Пожалуйста, введите фамилию",
        username: "Пожалуйста, введите имя пользователя",
        password: {
          required: "Пожалуйста, введите пароль",
          minlength: "Пароль должен быть не менее {0} символов"
        },
        room_id: "Пожалуйста, выберите номер отдела",
        computer: "Пожалуйста, выберите имя устройства"
      },
      submitHandler: function(form) {
        // Все поля валидны, можно отправить форму
        form.submit();
      }
    });
  });