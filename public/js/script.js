document.addEventListener("DOMContentLoaded", function () {

    var mensajes = document.querySelectorAll(".msg");
    mensajes.forEach(function (msg) {
        setTimeout(function () {
            msg.style.transition = "opacity 0.5s";
            msg.style.opacity = "0";
            setTimeout(function () {
                msg.remove();
            }, 500);
        }, 4000);
    });

    var formularios = document.querySelectorAll("form");
    formularios.forEach(function (form) {
        form.addEventListener("submit", function (e) {
            var requeridos = form.querySelectorAll("[required]");
            var valido = true;
            requeridos.forEach(function (campo) {
                if (campo.value.trim() === "") {
                    campo.style.borderColor = "#e74c3c";
                    valido = false;
                } else {
                    campo.style.borderColor = "";
                }
            });
            if (!valido) {
                e.preventDefault();
                alert("Complete todos los campos obligatorios");
            }
        });
    });

    var inputs = document.querySelectorAll("input, select, textarea");
    inputs.forEach(function (input) {
        input.addEventListener("input", function () {
            this.style.borderColor = "";
        });
    });

});
