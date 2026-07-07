document.addEventListener("DOMContentLoaded", function () {

    // ————— Theme Toggle —————

    var themeToggle = document.getElementById("themeToggle");
    var html = document.documentElement;

    var savedTheme = localStorage.getItem("theme");
    if (savedTheme) {
        html.setAttribute("data-theme", savedTheme);
    } else {
        var prefersDark = window.matchMedia("(prefers-color-scheme: dark)").matches;
        html.setAttribute("data-theme", prefersDark ? "dark" : "light");
    }

    if (themeToggle) {
        themeToggle.addEventListener("click", function () {
            var current = html.getAttribute("data-theme");
            var next = current === "dark" ? "light" : "dark";
            html.setAttribute("data-theme", next);
            localStorage.setItem("theme", next);
        });
    }

    // ————— Notification Carousel —————

    var track = document.getElementById("notifTrack");
    var dotsContainer = document.getElementById("notifDots");

    if (track && dotsContainer) {
        var slides = track.querySelectorAll(".notif-slide");
        var total = slides.length;
        var currentIndex = 0;
        var interval;

        slides.forEach(function (_, i) {
            var dot = document.createElement("button");
            dot.className = "notif-dot" + (i === 0 ? " active" : "");
            dot.setAttribute("aria-label", "Notificacion " + (i + 1));
            dot.addEventListener("click", function () {
                goTo(i);
            });
            dotsContainer.appendChild(dot);
        });

        var dots = dotsContainer.querySelectorAll(".notif-dot");

        function goTo(index) {
            currentIndex = index;
            var slideHeight = slides[0].offsetHeight;
            track.style.transform = "translateY(-" + (index * slideHeight) + "px)";
            dots.forEach(function (d, i) {
                d.classList.toggle("active", i === index);
            });
        }

        function next() {
            goTo((currentIndex + 1) % total);
        }

        function startAuto() {
            interval = setInterval(next, 5000);
        }

        startAuto();

        track.addEventListener("mouseenter", function () {
            clearInterval(interval);
        });

        track.addEventListener("mouseleave", function () {
            startAuto();
        });
    }

    // ————— Mobile Menu Toggle —————

    var hamburger = document.getElementById("hamburger");
    var navLinks = document.getElementById("navLinks");

    function closeNav() {
        navLinks.classList.remove("open");
        hamburger.classList.remove("open");
        document.body.style.overflow = "";
    }

    function toggleNav() {
        var opening = !navLinks.classList.contains("open");
        navLinks.classList.toggle("open");
        hamburger.classList.toggle("open");
        document.body.style.overflow = opening ? "hidden" : "";
    }

    if (hamburger && navLinks) {
        hamburger.addEventListener("click", function (e) {
            e.stopPropagation();
            toggleNav();
        });

        navLinks.querySelectorAll("a").forEach(function (link) {
            link.addEventListener("click", closeNav);
        });
    }

    // ————— Flash Messages (auto-dismiss) —————

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

    // ————— Form Validation —————

    var formularios = document.querySelectorAll("form");
    formularios.forEach(function (form) {
        form.addEventListener("submit", function (e) {
            var requeridos = form.querySelectorAll("[required]");
            var valido = true;
            requeridos.forEach(function (campo) {
                if (campo.value.trim() === "") {
                    campo.style.borderColor = "var(--color-danger)";
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
