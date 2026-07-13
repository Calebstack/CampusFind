<?php

session_start();
require_once "../classes/Student.php";
$student = new Student;
$department = $student->departments();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="CampusFind Team">
    <meta name="robots" content="index, follow">
    <title>Sign Up - CampusFind</title>
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/fa/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/theme.css">
    <style>
        body {
            background: linear-gradient(135deg, rgba(79, 70, 229, 0.55) 0%, rgba(6, 182, 212, 0.55) 100%), url('../images/bg1.jpg') center/cover no-repeat;
            background-attachment: fixed;
            min-height: 100vh;
        }

        .auth-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 16px;
        }

        .auth-card {
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(255,255,255,0.6);
            border-radius: 24px;
            padding: 48px 44px;
            width: 100%;
            max-width: 540px;
            box-shadow: 0 32px 64px rgba(15, 23, 42, 0.15), 0 4px 16px rgba(79, 70, 229, 0.1);
        }

        .auth-logo {
            font-size: 2rem;
            font-weight: 800;
            letter-spacing: -0.05em;
            color: #0f172a;
            text-decoration: none;
        }
        .auth-logo span { color: #4f46e5; }

        .auth-tagline { color: #64748b; font-size: 0.95rem; margin-top: 4px; }

        .extra-links { color: #4f46e5; text-decoration: none; font-weight: 600; }
        .extra-links:hover { text-decoration: underline; color: #4338ca; }

        .btn-auth {
            width: 100%;
            padding: 0.85rem;
            font-size: 1rem;
            font-weight: 700;
            border-radius: 12px;
            background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%);
            border: none;
            color: #fff;
            box-shadow: 0 4px 14px rgba(79, 70, 229, 0.35);
            transition: all 0.3s ease;
        }
        .btn-auth:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(79, 70, 229, 0.45);
            filter: brightness(1.08);
        }

        .step-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(79, 70, 229, 0.1);
            color: #4f46e5;
            border-radius: 999px;
            font-size: 0.78rem;
            font-weight: 700;
            padding: 4px 12px;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            margin-bottom: 6px;
        }
    </style>
</head>
<body>
    <div class="auth-wrapper">
        <div class="auth-card">
            <div class="text-center mb-4">
                <div class="step-badge"><i class="fas fa-user-plus"></i> Create Account</div>
                <a href="index.php" class="auth-logo">Campus<span>Find</span></a>
                <p class="auth-tagline">Join thousands of students on campus</p>
            </div>

            <?php
                if(isset($_SESSION['errormsg'])){
                    echo "<div class='alert alert-danger rounded-3'>".$_SESSION['errormsg']."</div>";
                    unset($_SESSION['errormsg']);
                }

                if(isset($_SESSION['feedback'])){
                    echo "<div class='alert alert-success rounded-3'>".$_SESSION['feedback']."</div>";
                    unset($_SESSION['feedback']);
                }
            ?>

            <form action="../action/student_signup.php" method="post">
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label" for="firstName">First Name</label>
                        <input type="text" name="firstname" id="firstName" class="form-control" placeholder="John" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="lastName">Last Name</label>
                        <input type="text" name="lastname" id="lastName" class="form-control" placeholder="Doe" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="department">Department</label>
                    <select id="department" name="department" class="form-select" required>
                        <option value="">Select your department</option>
                        
                        <?php foreach($department as $dep){ ?>
                        
                        <option value="<?php echo $dep['dept_id'] ?>"><?php echo $dep['dept_name'] ?></option>

                        <?php } ?>
                        
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="email">University Email</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="you@university.edu" required>
                    <p id='feedback' class="mt-1" style="font-size: 0.85rem;"></p>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="password">Password</label>
                    <input type="password" name="pass1" id="password" class="form-control" placeholder="Create a strong password" required>
                </div>
                <div class="mb-4">
                    <label class="form-label" for="confirmPassword">Confirm Password</label>
                    <input type="password" name="pass2" id="confirmPassword" class="form-control" placeholder="Repeat your password" required>
                </div>
                <button type="submit" name="signupstd" class="btn-auth mb-4">
                    <i class="fas fa-user-plus me-2"></i>Create Account
                </button>
                <div class="text-center" style="font-size: 0.92rem; color: #64748b;">
                    Already have an account? <a href="loginstudent.php" class="extra-links">Sign In</a>
                </div>
            </form>
        </div>
    </div>
    <script src="../assets/jq.js"></script>
    <script>
        $(document).ready(function(){
            $('#email').change(function(){
                var user_email = $(this).val();
                var data = {email:user_email};
                $.get('../action/email.php', data,  function(rsp){
                    $("#feedback").html(rsp);
                })
            })
        })
    </script>
</body>
</html>