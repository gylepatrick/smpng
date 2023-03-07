<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Login</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-success">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">s
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Welcome New User! <br> <sub class="text-success">Create your account ...</sub></h1>
                                    </div>
                                    <form action="handlers/login.php" method="post">
                                        <div class="form-group">
                                            <label for="validationServer01">Fullname</label>
                                            <input type="text" class="form-control form-control-user" id="fullname" aria-describedby="emailHelp" placeholder="Enter Fullname..." name="fullname">
                                        </div>
                                        <div class="form-group">
                                            <label for="validationServer01">Username</label>
                                            <input type="text" class="form-control form-control-user" id="username" aria-describedby="emailHelp" placeholder="Enter Username..." name="username">
                                        </div>
                                        <div class="form-group">
                                            <label for="validationServer01">Password</label>
                                            <input type="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Password ..." name="password">
                                        </div>
                                        <div class="form-group">
                                            <label for="validationServer01">Confirm Password</label>
                                            <input type="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Confirm Password ..." name="password">
                                        </div>

                                        <div class="form-group">
                                            <label for="validationServer01">User Type</label>
                                            <select class="form-select form-control" name="type">
                                                <option value="1">Admin User</option>
                                                <option value="2">View Only User</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" class="custom-control-input" id="customCheck">
                                                <label class="custom-control-label" for="customCheck">Remember
                                                    Me</label>
                                            </div>
                                        </div>
                                        <input class="btn btn-success col-12" type="submit" name="submit" value="LOGIN">
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="index.php">Already have an Account? Login now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>
