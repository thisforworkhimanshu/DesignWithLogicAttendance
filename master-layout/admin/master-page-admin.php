<div>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Management</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="../../index.php">Home</a>
                </li>
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Faculty
                  </a>
                  <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="../../admin/facultyRegistration/faculty-register.php">Faculty Registration</a>
                    <a class="dropdown-item" href="../../admin/subject-faculty-allocation/subject-faculty-allocation.php">Faculty Subject Allocation</a>
                    <a class="dropdown-item" href="../../admin/faculty-update/faculty-update.php">Faculty Detail Updation</a>
                    <a class="dropdown-item" href="../../admin/faculty-delete/faculty-delete.php">Faculty Remove</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="../../admin/faculty-view/faculty-view.php">List Faculty</a>
                  </div>
                </li>
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Student
                  </a>
                  <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="../../admin/student-registration/student-registration.php">Student Registration</a>
                    <a class="dropdown-item" href="../../admin/detain-student-registration/register-into-detain.php">Detain Student</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="../../admin/student-division-allocation/student-division-allocation.php">Division Allocation</a>
                    <a class="dropdown-item" href="../../admin/student-prac-batch-allocation/student-prac-batch-allocation.php">Practical Batch Allocation</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="../../admin/admin-view-student/admin-view-student.php">View Student</a>
                  </div>
                </li>
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Marks
                  </a>
                  <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="../../admin/admin-marks-view/admin-view-grade.php">Student Grade History</a>
                    <a class="dropdown-item" href="../../admin/admin-marks-view/admin-marks-view.php">Student Mark History</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="../../admin/admin-change-marks/get-Student-Details.php">Change Student Mark</a>
                    <a class="dropdown-item" href="../../admin/admin-change-marks-different/get-Change-Detail.php">Change Mark Sem wise</a>
                  </div>
                </li>
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Attendance
                  </a>
                  <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="#">Check Attendance</a>
                    <a class="dropdown-item" href="#">Change Attendance</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Generate Detention List</a>
                  </div>
                </li>
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Miscelleaneous
                  </a>
                  <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="../../admin/subject-register/getSubjectDetail.php">Add Subject</a>
                    <a class="dropdown-item" href="../../admin/rollno-to-enrolment/roll-to-enrolment.php">Transfer Roll No. To Enrolment No.</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="../../admin/move-batch-next-sem/getBatchDetails.php">Move Batch To Next Semester</a>
                  </div>
                </li>
            
            </ul>
            <ul class="navbar-nav navbar-right">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                      <a class="dropdown-item" href="#">Profile</a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="../../sessionDestroy.php">Logout</a>
                    </div>
                  </li>
            </ul>
        </div>
    </nav>
</div>