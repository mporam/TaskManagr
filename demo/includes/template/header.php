<header class="col-12">
    <h1 class="logo col-1">
        Logo
    </h1>
    <div class="col-7">
        <a href="/tasks/new/" class="new-task">New task</a>
    </div>
    <div class="col-4 settings">
        <div class="right">
            <a href="#">
                <img src="<?php echo get_gravatar($_SESSION['users_email'], $_SESSION['users_image']) ?>" class="user-image">
            </a>
            <!--
                <ul>
                    <li>Hi Max!
                        <ul>
                            <li>Hi Mike</li>
                            <li>Hi Hannah</li>
                        </ul>
                    </li>
                </ul>
            -->
            <div class="icons">
                <div class="search-box closed">
                    <input type="search" placeholder="search&hellip;" name="search" class="search-input">
                    <input type="submit" value="submit" class="search-btn">
                </div>	
                    
                <a href="#" class="info">Info</a>

            </div>
        </div>
    </div>
</header>

<?php require($_SERVER['DOCUMENT_ROOT'] . '/includes/template/nav.php'); ?>
