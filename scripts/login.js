const signInButton = document.getElementById("sign-in-button");
signInButton.addEventListener("click", send);

const emailInput = document.getElementById("email-input");
emailInput.addEventListener("keydown", function (event) {
    if (event.keyCode === 13) {
        send();
    }
})

const passwordInput = document.getElementById("password-input");
passwordInput.addEventListener("keydown", function (event) {
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
    }).catch(error => console.error(error));
}
