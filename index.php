<?php
    session_start(); // Start PHP session

    include('connect.php'); // Include database connection script

    $error_msg = ""; // Initialize error message variable

    // Process form submission upon login button click
    if (isset($_POST['login'])) {
        try {
            // Check for empty fields
            if (empty($_POST['username'])) {
                throw new Exception("Username is required!");
            }
            if (empty($_POST['password'])) {
                throw new Exception("Password is required!");
            }

            // Retrieve form inputs
            $username = $_POST['username'];
            $password = $_POST['password'];
            $type = $_POST['type'];

            // Validate user credentials against database
            $query = "SELECT * FROM admininfo WHERE username='$username' AND password='$password' AND type='$type'";
            $result = mysqli_query($connect, $query);

            if (!$result) {
                throw new Exception("Query failed: " . mysqli_error($connect));
            }

            $row = mysqli_num_rows($result);

            // Redirect based on user role if login successful
            if ($row > 0) {
                $_SESSION['name'] = "oasis"; // Set session variable
                switch ($type) {
                    case 'teacher':
                        header('location: teacher/index.php');
                        exit;
                    case 'student':
                        header('location: student/index.php');
                        exit;
                    case 'admin':
                        header('location: admin/index.php');
                        exit;
                }
            } else {
                throw new Exception("Username, Password, or Role is incorrect. Please try again!");
            }
        } catch (Exception $e) {
            $error_msg = $e->getMessage(); // Capture and display error message
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Attendance Management System - Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="text-center">Attendance Management System - Login</h1>

        <?php
            if (!empty($error_msg)) {
                echo '<div class="alert alert-danger">' . $error_msg . '</div>';
            }
        ?>

        <form method="post" class="form-horizontal col-md-6 col-md-offset-3">
            <div class="form-group">
                <label class="control-label col-sm-3">Username:</label>
                <div class="col-sm-9">
                    <input type="text" name="username" class="form-control" placeholder="Enter your username" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3">Password:</label>
                <div class="col-sm-9">
                    <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3">Login As:</label>
                <div class="col-sm-9">
                    <label><input type="radio" name="type" value="student" checked> Student</label>
                    <label><input type="radio" name="type" value="teacher"> Teacher</label>
                    <label><input type="radio" name="type" value="admin"> Admin</label>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-9">
                    <button type="submit" name="login" class="btn btn-primary">Login</button>
                    <button type="reset" class="btn btn-default">Reset</button>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
