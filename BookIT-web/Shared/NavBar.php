<div id="LogoContainer">
    <!-- Logo goes here -->
    <h1>BookIT</h1>
    <iconify-icon icon="bx:book-bookmark" width="2rem"></iconify-icon>
</div>
<div id="MainLinksContainer">
    <ul>
        <li><a href="#">Hjem</a></li>
        <li><a href="#">Rom</a></li>
        <li><a href="#">Booking</a></li>
        <li><a href="#">Kontakt</a></li>
    </ul>
</div>
<div id="DropdownContainer">
    <!-- the user and hamburger menu goes here -->

    <div id="User_info">
        <iconify-icon icon="bx:user" width="2.5rem"></iconify-icon>
        <div class="user_info_devider">
            <?php
            echo "<div id='User_name'>" . $_SESSION['user'] . "</div>";
            echo "<div id='User_email'>" . $_SESSION['email'] . "</div>";
            ?>
        </div>
    </div>
</div>