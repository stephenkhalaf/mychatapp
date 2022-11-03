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
        <section class="users">
            <header>
                <?php
                include_once "php/config.php";
                $sql = mysqli_query($conn, "select * from users where unique_id = '{$_SESSION['unique_id']}'");
                if (mysqli_num_rows($sql) > 0) {
                    $row = mysqli_fetch_assoc($sql);
                }

                ?>
                <div class="content">
                    <img src="<?= 'php/uploads/' . $row['img'] ?>" alt="">
                    <div class="details">
                        <span><?= $row['fname'] . " " . $row['lname'] ?></span>
                        <p><?= $row['status'] ?></p>
                    </div>
                </div>
                <a href="php/logout.php?logout_id=<?= $_SESSION['unique_id'] ?>" class="logout">Logout</a>
            </header>
            <div class="search">
                <span class="text">select a user to start chat</span>
                <input type="text" placeholder="Enter a name to search...">
                <button>search</button>
            </div>
            <div class="users-list">


            </div>

        </section>
    </div>

    <script>
        const searchBar = document.querySelector('.users .search input')
        const searchBtn = document.querySelector('.users .search button')
        const users_list = document.querySelector('.users-list')

        searchBtn.addEventListener('click', () => {
            searchBar.classList.toggle('active')
            searchBar.focus()
            searchBtn.classList.toggle('active')
            if (searchBar.classList.contains('active')) {
                searchBtn.textContent = 'X'
            } else {
                searchBtn.textContent = 'search'
            }

            searchBar.value = ''
        })

        searchBar.addEventListener('keyup', () => {
            let searchTerm = searchBar.value

            if (searchTerm.value != '') {
                searchBar.classList.add('demo')
            } else {
                searchBar.classList.remove('demo')
            }
            const xhr = new XMLHttpRequest()
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    users_list.innerHTML = xhr.responseText
                }
            }
            xhr.open('POST', 'php/search.php')
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
            xhr.send('searchTerm=' + searchTerm)
        })

        setInterval(() => {
            const xhr = new XMLHttpRequest()
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    if (!searchBar.classList.contains('demo')) {
                        users_list.innerHTML = xhr.responseText
                    }
                }
            }
            xhr.open('POST', 'php/users.php')
            xhr.send()
        }, 500)
    </script>
</body>

</html>