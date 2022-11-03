<?php
session_start();
if (!isset($_SESSION['unique_id'])) {
    header('Location: login.php');
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
        <section class="chat-area">
            <header>

                <?php
                include_once "php/config.php";
                $user_id = mysqli_real_escape_string($conn, $_GET['user_id']);
                $sql = mysqli_query($conn, "select * from users where unique_id = '{$user_id}'");
                if (mysqli_num_rows($sql) > 0) {
                    $row = mysqli_fetch_assoc($sql);
                }

                ?>
                <a href="users.php" class="back-icon">
                    << </a>
                        <img src="<?= 'php/uploads/' . $row['img'] ?>" alt="">
                        <div class="details">
                            <span><?= $row['fname'] . " " . $row['lname'] ?></span>
                            <p><?= $row['status'] ?></p>
                        </div>
                </a>
            </header>
        </section>
        <div class="chat-box">


        </div>
        <form action="#" class="typing-area" autocomplete="off">
            <input type="text" name="outgoing_id" value="<?= $_SESSION['unique_id'] ?>" hidden>
            <input type="text" name="incoming_id" value="<?= $user_id ?>" hidden>
            <input type="text" name="message" placeholder="Type a message here..." class="input-field">
            <button>send</button>
        </form>
    </div>

</body>

<script>
    const form = document.querySelector('.typing-area')
    const sendBtn = form.querySelector('button')
    const inputField = form.querySelector('.input-field')
    const chatBox = document.querySelector('.chat-box');

    form.addEventListener('submit', e => {
        e.preventDefault()
    })

    sendBtn.addEventListener('click', () => {
        const xhr = new XMLHttpRequest()
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                inputField.value = ''
                scrollToBottom()

            }
        }
        xhr.open('POST', 'php/insert-chat.php')
        const formData = new FormData(form)
        xhr.send(formData)
    })

    chatBox.addEventListener('mouseenter', () => {
        chatBox.classList.add('active')
    })

    chatBox.addEventListener('mouseleave', () => {
        chatBox.classList.remove('active')
    })

    setInterval(() => {
        const xhr = new XMLHttpRequest()
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                chatBox.innerHTML = xhr.responseText
                if (!chatBox.classList.contains('active')) {
                    scrollToBottom()
                }

            }
        }
        xhr.open('POST', 'php/get-chat.php')
        const formData = new FormData(form)
        xhr.send(formData)

    }, 500)

    function scrollToBottom() {
        chatBox.scrollTop = chatBox.scrollHeight
    }
</script>

</html>