</head>
<body class="grid">
    <header class="col-12">
        <h1 class="logo col-1">
            Logo
        </h1>
        <div class="col-8">
            <a href="/tasks/new/" class="new-task">New task</a>
        </div>
        <div class="col-3 settings">
            <div class="icons">
                <a href="/settings/">
                    <img src="<?php echo (empty($_SESSION['users_image']) ? get_gravatar($_SESSION['users_email']) : $_SESSION['users_image']); ?>" class="user-image">
                </a>
                <a href="#" class="info">Info</a>
            </div>

            <div class="search-box">
                <div class="search">
                    <input type="submit" value="submit" class="search-btn">
                    <input type="search" placeholder="search" name="search" class="search-input">
                </div>
                <div class="search-results">
                    <span>&times;</span>
                    <section data-type="tasks">
                        <h4>Task Results&hellip;</h4>
                        <img src="/images/site/icons/loading.gif" class="loader">
                    </section>
                    <section data-type="projects">
                        <h4>Project Results&hellip;</h4>
                        <img src="/images/site/icons/loading.gif" class="loader">
                    </section>
                    <section data-type="users">
                        <h4>User Results&hellip;</h4>
                        <img src="/images/site/icons/loading.gif" class="loader">
                    </section>
                    <a href="#" class="italic">Show All Results&hellip;</a>
                </div>
            </div>

        </div>
    </header>

    <?php require($_SERVER['DOCUMENT_ROOT'] . '/includes/template/nav.php'); ?>
