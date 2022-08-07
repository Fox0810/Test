$(document).ready(function () {
    const loginForm = $('#sign-in-form');
    const loginField = $('#sign-in-login-field');
    const passwordField = $('#sign-in-password-field');
    const resMsg = $('#sign-in-res-msg');

    function playAnimation(animObject) {
        animObject.css('opacity', '0.1');
        animObject.animate({opacity: '1.0'}, 833);
        animObject.removeAttr('hidden');
    }

    loginForm.submit(async function (e) {
        e.preventDefault();

        let user = {
            login: loginField.val(),
            password: passwordField.val(),
        };

        let res = await fetch(loginForm.attr('action'), {
            method: loginForm.attr('method'),
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
            resMsg.html(result.message);
            playAnimation(resMsg);
        }
        else {
            location.href = '/web/home.php';
        }
    });
});