
    <div id="NavBar">
        <div id="LogoContainer">
        <a class="logo_link" href="./">
            <!-- Logo goes here -->
            <div id="logo">
                <div style="font-size: 2.5rem;">BookIT</div>
                <iconify-icon icon="bx:book-bookmark" width="2.5rem"></iconify-icon>
            </div>

        </a>
        </div>
        <div id="MainLinksContainer">
        <!-- <ul>
            <li><a href="index.php">Hjem</a></li>
            <li><a href="#">Rom</a></li>
            <li><a href="#">Booking</a></li>
            <li><a href="#">Kontakt</a></li>
        </ul> -->
        </div>
        <div id="DropdownContainer">
        <!-- the user and hamburger menu goes here -->

            <input id="menu_check" type="checkbox" name="menu" />
            <label for="menu_check">
                <div id="User_info">
                    <iconify-icon icon="bx:user-circle" width="2.5rem"></iconify-icon>
                    <div class="user_info_devider">
                        <?php
                        echo "<div id='User_name'>" . $_SESSION['user'] . "</div>";
                        echo "<div id='User_email'>" . $_SESSION['email'] . "</div>";
                        ?>
                    </div>
                    <iconify-icon icon="bx:chevron-down" width="2rem"></iconify-icon>

                    <!-- <div id="Dropdown_menu">
                        <a href="settings.php">
                            <iconify-icon icon="bx:cog" width="1.5rem"></iconify-icon>
                            Innstillinger
                        </a>
                        <a href="./login.php">
                            <iconify-icon icon="bx:log-out" width="1.5rem"></iconify-icon>
                            Log ut
                        </a>
                    </div> -->
                </div>
            </label>
            <ul id="User_submenu">
                <li><a href="settings.php">
                    <iconify-icon class="icon" icon="bx:cog" width="1.5rem"></iconify-icon>
                    Innstillinger
                </a></li>
                <li>
                    <a href="./logout.php">
                    <iconify-icon class="icon" icon="bx:log-out" width="1.5rem"></iconify-icon>
                    Log ut
                </a></li>
            </ul>
        </div>
    </div>