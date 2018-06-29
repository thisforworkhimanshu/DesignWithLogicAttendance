<div>
    <nav class="navbar navbar-expand-lg navbar-light bg-light" id="nav">
        <a class="navbar-brand" href="/DesignWithLogicAttendance/welcomeadmin.php"><i class="material-icons" style=" padding-right: 2px">school</i>StudInfo</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Faculty
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="/DesignWithLogicAttendance/admin/facultyRegistration/faculty-register.php">Faculty Registration</a>
                        <a class="dropdown-item" href="/DesignWithLogicAttendance/admin/subject-faculty-allocation/subject-faculty-allocation.php">Faculty Subject Allocation</a>
                        <a class="dropdown-item" href="/DesignWithLogicAttendance/admin/faculty-update/faculty-update.php">Faculty Detail Updation</a>
                        <a class="dropdown-item" href="/DesignWithLogicAttendance/admin/faculty-delete/faculty-delete.php">Faculty Remove</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="/DesignWithLogicAttendance/admin/faculty-view/faculty-view.php">List Faculty</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Student
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="/DesignWithLogicAttendance/admin/student-registration/student-registration.php">Student Registration</a>
                        <a class="dropdown-item" href="/DesignWithLogicAttendance/admin/detain-student-registration/register-into-detain.php">Detain Student</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="/DesignWithLogicAttendance/admin/student-division-allocation/student-division-allocation.php">Division Allocation</a>
                        <a class="dropdown-item" href="/DesignWithLogicAttendance/admin/student-prac-batch-allocation/student-prac-batch-allocation.php">Practical Batch Allocation</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="/DesignWithLogicAttendance/admin/admin-view-student/admin-view-student.php">View Student</a>

                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Marks
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="/DesignWithLogicAttendance/admin/admin-marks-view/admin-view-grade.php">Student Grade History</a>
                        <a class="dropdown-item" href="/DesignWithLogicAttendance/admin/admin-marks-view/admin-marks-view.php">Student Mark History</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="/DesignWithLogicAttendance/admin/admin-change-marks/get-Student-Details.php">Change Student Mark</a>
                        <a class="dropdown-item" href="/DesignWithLogicAttendance/admin/admin-change-marks-different/get-Change-Detail.php">Change Mark Sem wise</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Attendance
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="/DesignWithLogicAttendance/attendance/admin-view.php">View Attendance</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Miscelleaneous
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="/DesignWithLogicAttendance/admin/subject-register/getSubjectDetail.php">Add Subject</a>
                        <a class="dropdown-item" href="/DesignWithLogicAttendance/admin/rollno-to-enrolment/roll-to-enrolment.php">Transfer Roll No. To Enrolment No.</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="/DesignWithLogicAttendance/admin/move-batch-next-sem/getBatchDetails.php">Move Batch To Next Semester</a>
                        <a class="dropdown-item" href="/DesignWithLogicAttendance/admin/move-to-passout/getBatchDetails.php">Move Batch To Passout</a>
                    </div>
                </li>

            </ul>
            <ul class="navbar-nav navbar-right">
                <li class="nav-item dropdown">

                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="material-icons" style="padding-right: 2px; font-size: 12pt">public</i>Admin</a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#">Profile</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="/DesignWithLogicAttendance/sessionDestroy.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>
</div>