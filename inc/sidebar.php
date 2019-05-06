<div class="col-lg-3">
        <div class="list-group text-success">
            <a class="list-group-item list-group-item-action" href="home.php">
                <i class="fas fa-bezier-curve"></i>
                All Projects
            </a>
            <?php
            if( $_SESSION["userinfo"]["role"] != "project_manager" ) { ?>
                <a class="list-group-item list-group-item-action" href="mytask.php">
                    <i class="fas fa-tasks"></i>
                    My Tasks
                </a>
                <a class="list-group-item list-group-item-action" href="allmeeting.php">
                    <i class="far fa-hourglass"></i>
                    All Meeting
                </a>
            <?php }else { ?>
                <a class="list-group-item list-group-item-action" href="meeting.php">
                    <i class="fas fa-mail-bulk"></i>
                    Setup Meeting
                </a>
                <a class="list-group-item list-group-item-action" href="allmeeting.php">
                    <i class="far fa-hourglass"></i>
                    All Meeting
                </a>
            <?php } ?>
        </div>
</div>