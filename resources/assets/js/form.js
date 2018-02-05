axios.defaults.headers.common = {
    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
    "X-Requested-With": "XMLHttpRequest"
}
handleLogin = function() {
    var loginForm = document.getElementById("login-form")
    var email = document.getElementById("email").value
    var password = document.getElementById("password").value
    axios
        .post("/api/auth/login", {
            email: email,
            password: password
        })
        .then(response => {
            localStorage.setItem("token", response.data.access_token)
            loginForm.submit()
        })
        .catch(error => {
            loginForm.submit()
        })
}
