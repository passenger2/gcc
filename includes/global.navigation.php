<!-- Navigation -->
<nav class="navbar navbar-default navbar-fixed-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="index.php">PSRMS</a>
    </div>
    <!-- /.navbar-header -->

    <ul class="nav navbar-top-links navbar-right">
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-user">
                <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                </li>
                <li class="divider"></li>
                <li><a href="/includes/actions/global.logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                </li>
            </ul>
            <!-- /.dropdown-user -->
        </li>
        <!-- /.dropdown -->
    </ul>
    <!-- /.navbar-top-links -->

    <div class="sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse">
            <ul class="nav" id="side-menu">
                <?php
                if($_SESSION["account_type"] == '77') {
                ?>
                <li>
                    <a href="index.php"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                </li>
                <li>
                    <a href="reports.visualizations.php"><i class="fa fa-bar-chart-o fa-fw"></i> Visualizations</a>
                </li>
                <li>
                    <a href="student.list.php" id="idpMenu"><i class="fa fa-address-card-o fa-fw"></i> Students</a>
                    <!-- /.nav-second-level -->
                </li>
                <li>
                    <a href="forms.manage.tools.php"><i class="fa fa-file-text-o fa-fw"></i> Assessment Tools</a>
                </li>
                <li>
                    <a href="user.list.php"><i class="fa fa-key fa-fw"></i> Account Management</a>
                </li>
                <?php
                } else
                {
                ?>
                <li>
                    <a href="student.list.php" id="idpMenu"><i class="fa fa-address-card-o fa-fw"></i> Students</a>
                    <!-- /.nav-second-level -->
                </li>
                <?php
                }
                ?>
            </ul>
        </div>
        <!-- /.sidebar-collapse -->
    </div>
    <!-- /.navbar-static-side -->
</nav>