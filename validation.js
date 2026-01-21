function submitForm(form, type) {
    fetch(form.action || window.location.href, {
        method: "POST",
        headers: {
            "X-Requested-With": "XMLHttpRequest"
        },
        body: new FormData(form)
    })
    .then(res => res.json())
    .then(data => {
        if (data.status) {
            alert(data.message);
            if (data.redirect) {
                window.location.href = data.redirect;
            }
        } else {
            alert(data.message);
        }
    })
    .catch(() => {
        alert("Something went wrong");
    });

    return false;
}

/* LOGIN */
function validateLogin(form) {
    if (form.password.value.length < 6) {
        alert("Password must be at least 6 characters");
        return false;
    }
    return submitForm(form, "login");
}

/* REGISTER */
function validateRegister(form) {
    if (form.password.value.length < 6) {
        alert("Password must be at least 6 characters");
        return false;
    }
    return submitForm(form, "register");
}
