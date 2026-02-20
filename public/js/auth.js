/**
 * Auth – Toggle visibilidad de contraseña
 */
window.onload = function () {
    var buttons = document.querySelectorAll('.toggle-password');

    for (var i = 0; i < buttons.length; i++) {
        buttons[i].onclick = function () {
            var input = this.closest('.input-wrapper').querySelector('input');
            var icon = this.querySelector('i');

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            }
        };
    }
};
