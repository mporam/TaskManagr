<div class="col-1 nav">
    <nav>
    	<ul>
    		<li class="home<?php echo ($GLOBALS['url_parts'][0] == 'dashboard')? ' active' : ''?>">
                <a href="/">
                    <span></span>
                    Dashboard
                </a>
    		</li>
    		<li class="projects<?php echo ($GLOBALS['url_parts'][0] == 'projects')? ' active' : ''?>" data-sidebar="projects">
                <a href="/projects/">
                    <span></span>
                    Projects
                </a>
    		</li>
    		<li class="workflow<?php echo ($GLOBALS['url_parts'][0] == 'workflow')? ' active' : ''?>">
                <a href="/workflow/">
                    <span></span>
                    Workflow
                </a>
    		</li>
    		<li class="settings<?php echo ($GLOBALS['url_parts'][0] == 'settings')? ' active' : ''?>">
                <a href="/settings/">
                    <span></span>
                    Settings
                </a>
    		</li>
            <?php if ($_SESSION['users_type'] == '1') { ?>
    		<li class="user<?php echo ($GLOBALS['url_parts'][0] == 'users')? ' active' : ''?>" data-sidebar="users">
                <a href="/users/">
                    <span></span>
                    Users
                </a>
    		</li>
            <?php } ?>
    	</ul>
    </nav>
    <aside id="sidebar" class="closed">
        <div class="sidebar-inner"></div>
    </aside>
</div>

<main class="col-11 grid">
