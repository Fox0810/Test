$(document).ready(function () {
    const regForm = $('#main-form');
    const loginField = $('#login-field');
    const passwordField = $('#password-field');
    const repPasswordField = $('#rep-password-field');
    const emailField = $('#email-field');
    const nameField = $('#name-field');
    const resMsg = $('#res-msg');

    function playAnimation(animObject) {
        animObject.css('opacity', '0.1');
        animObject.animate({opacity: '1.0'}, 833);
        animObject.removeAttr('hidden');
    }

    regForm.submit(async function (e) {
        e.preventDefault();

        if (repPasswordField.val() !== passwordField.val()) {
            resMsg.html('Passwords are not equal!');
            resMsg.attr('class', 'failed-req');
            playAnimation(resMsg);
        }
        else {
            resMsg.attr('hidden', '');

            let user = {
                login: loginField.val(),
                password: passwordField.val(),
                email: emailField.val(),
                name: nameField.val()
            };

            let res = await fetch(regForm.attr('action'), {
                method: regForm.attr('method'),
                headers: {
                    'Content-Type': 'application/json;charset=utf-8',
                    'credentials': 'same-origin',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify(user)
            });

            let result = await res.json();

            if(res.status === 400) {
                resMsg.attr('class', 'failed-req');
            }
            else {
                resMsg.attr('class', 'success-req');
            }

            resMsg.html(result.message);
            playAnimation(resMsg);
        }
    });
});