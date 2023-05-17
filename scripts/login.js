const passwordInput = document.getElementById('password-input');
passwordInput.addEventListener("keydown", function (event) {
    if (event.keyCode === 13) {
        send();
    }
});

const showPasswordBtn = document.getElementById('showPasswordBtn');
showPasswordBtn.addEventListener('click', function () {
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        showPasswordBtn.innerHTML = '<i class="fa fa-eye-slash" aria-hidden="true"></i>';
    } else {
        passwordInput.type = 'password';
        showPasswordBtn.innerHTML = '<i class="fa fa-eye" aria-hidden="true"></i>';
    }
});

const signInButton = document.getElementById("sign-in-button");
signInButton.addEventListener("click", send);

const emailInput = document.getElementById("email-input");
emailInput.addEventListener("keydown", function (event) {
    if (event.keyCode === 13) {
        send();
    }
})



function send() {
    const emailInput = document.getElementById("email-input");
    const passwordInput = document.getElementById("password-input");

    const formData = new FormData();
    formData.append('email', emailInput.value);
    formData.append('password', passwordInput.value);

    axios.post("controllers/login-controller.php", formData)
        .then((response) => {
            console.log(response.data);
            const data = response.data;
            console.log("login")
            if (data.type === "error"&& data.code === 400) {
                console.log("error")
                document.getElementById("toastLogIN").style.display="block"
            }
            if (data.type === "login" && data.code === 200) {
                console.log('login')
                document.getElementById("toastLogIN").style.display="none"
                location.reload();
            }
        }).catch(error => console.error(error));
}
