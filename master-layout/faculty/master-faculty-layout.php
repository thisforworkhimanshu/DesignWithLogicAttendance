<div>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="/DesignWithLogicAttendance/welcomefaculty.php"><i class="material-icons" style=" padding-right: 2px">school</i>StudInfo</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Task
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="/DesignWithLogicAttendance/faculty/view-subject/view-subject-lecture.php">Check My Subject Allocation</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Marks
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="/DesignWithLogicAttendance/faculty/faculty-marks-entry/faculty-marks-entry.php">Marks Entry</a>
                        <a class="dropdown-item" href="/DesignWithLogicAttendance/faculty/faculty-marks-change/get-Student-Details.php">Change Marks</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="/DesignWithLogicAttendance/faculty/faculty-view-mark/faculty-view-marks.php">View Marks</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Attendance
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="/DesignWithLogicAttendance/attendance/faculty/fac-att-sel.php">Fill Attendance</a>
                        <a class="dropdown-item" href="/DesignWithLogicAttendance/attendance/faculty/fac-att-view.php">View Attendance</a>
                    </div>
                </li>

            </ul>
            <ul class="navbar-nav navbar-right">
                <li class="nav-item dropdown">

                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="material-icons" style="vertical-align: middle;padding-right: 2px; font-size: 12pt">person</i><?= $_SESSION['f_name'] ?></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="/DesignWithLogicAttendance/sessionDestroy.php">Logout</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</div>