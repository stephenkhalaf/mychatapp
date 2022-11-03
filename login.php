<?php
session_start();
if (isset($_SESSION['unique_id'])) {
    header('Location: users.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>mychat app</title>
    <link rel="stylesheet" href="index.css">
</head>

<body>
    <div class="wrapper">
        <section class="form login">
            <header>Real time chat app</header>
            <form action="#">
                <div class="error-txt">This is an error message</div>

                <div class="field input">
                    <label for="">Email</label>
                    <input type="text" placeholder="Email" name="email">
                </div>

                <div class="field input">
                    <label for="">Password</label>
                    <input type="password" placeholder="password" name="password">
                    <input type="checkbox" name="" id="">
                </div>

                <div class="field button">
                    <input type="submit" value="Continue to chat">
                </div>
            </form>
            <div class="link">Not yet signed up? <a href="index.php">signup now</a></div>
        </section>
    </div>
    <script>
        const passwordField = document.querySelector('form input[type="password"')
        const toggleBtn = document.querySelector('form input[type="checkbox"')
        const form = document.querySelector('.login form')
        const continueBtn = form.querySelector('.button input')
        const errorText = document.querySelector('.error-txt')

        toggleBtn.addEventListener('click', () => {
            if (passwordField.type == 'password') passwordField.type = 'text'
            else passwordField.type = 'password'
        })

        form.addEventListener('submit', e => {
            e.preventDefault()
        })

        continueBtn.addEventListener('click', () => {
            const xhr = new XMLHttpRequest()
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    handle_response(xhr.responseText)
                }
            }
            xhr.open('POST', 'php/login.php')
            const formData = new FormData(form)
            xhr.send(formData)
        })


        function handle_response(data) {
            if (data == 'success') {
                location.href = 'users.php'
            } else {
                errorText.style.display = 'block'
                errorText.textContent = data
            }
        }
    </script>
</body>

</html>