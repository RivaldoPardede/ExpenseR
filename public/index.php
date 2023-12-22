<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/style.css">
        <link rel="icon" href="assets/Xpenser_Logo.png" type="image/icon type">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <title>Xpenser</title>
    </head>

    <?php
        include "../src/php/koneksi.php";

        if(isset($_POST['signup_action'])){  
            //cacth the data that has been sent by the user in the signup Form
            $username = $_POST["username"];
            $email    = $_POST["email"];
            $password = $_POST["password"];

            //check if the email is in database
            $cek = pg_num_rows(pg_query($connection, "SELECT * FROM users WHERE email = '$email'"));
            
            //make the user back into the signin page if the signup successful
            if ($cek == 0) {
                //insert data into database
                $insertQuery = pg_query($connection, "INSERT INTO users (username, email, password) VALUES('$username', '$email', '$password')");
                echo'
                <script>
                $(document).ready(function(){
                    swal({
                        title: "Success",
                        text: "Your account has been created!!!",
                        icon: "success",
                        button: "Ok",
                    })
                });
                </script>
                ';
            } else {
                echo'
                <script>
                $(document).ready(function(){
                    swal({
                        title: "Failed",
                        text: "Email has already been used. Please use another email",
                        icon: "error",
                        button: "Ok",
                    })
                });
                </script>
                ';
            }
        } else if(isset($_POST['signin_action'])){
            include "../src/php/koneksi.php";
            
            //cacth the data that has been sent by the user in the signup Form
            $email    = $_POST["emailSignin"];
            $password = $_POST["passwordSignin"];

            //select query
            $query = pg_query(
                        $connection, 
                        "SELECT * FROM users WHERE email ='$email' AND password = '$password'"
                    );

            //check if the email and password is in the database
            $cek = pg_num_rows($query);
            
            if($cek != 0){
                $_SESSION['email'] = $email;
                header("location: php/dashboard.php");
                // echo "<script>window.location = 'php/dashboard.html';</script>";
            } else{
                echo '
                <script>
                $(document).ready(function(){
                    swal({
                        title: "Failed",
                        text: "Email or Password is wrong. Please head to Sign Up if you didn\'t have an account",
                        icon: "error",
                        button: "Ok",
                    })
                });
                </script>
                ';
            }
        }
    ?>

    <body>
        <div class="min-h-screen bg-gray-100 text-gray-900 flex justify-center">
            <div class="max-w-screen-xl m-0 sm:m-10 bg-white shadow sm:rounded-lg flex justify-center flex-1">
                <div class="lg:w-1/2 xl:w-5/12 p-6 sm:p-12  relative transition">
                    <div class="flex flex-col lg:flex-row justify-center items-center">
                        <img src="assets/Xpenser_Logo.png" width="100" class="object-contain" />
                        <img src="assets/Xpenser.png" width="200" class="object-contain" />
                    </div>

                    <!-- Sign In - Start -->
                    <div id="signIn-form">
                        <div class="mt-3 mb-12 border-b text-center">
                            <div class="leading-none px-2 inline-block text-4xl text-slate-800 tracking-wide font-extrabold bg-white transform translate-y-1/2">
                                Sign In
                            </div>
                        </div>
                        <div class="mt-4 flex flex-col items-center">
                            <div class="w-full flex-1">
                                <div class="mx-auto max-w-xs">
                                    <form method="post" action="">
                                        <input class="w-full px-8 py-4 rounded-lg font-medium bg-slate-100 border border-slate-200 placeholder-slate-500 text-sm focus:outline-none focus:border-slate-400 focus:bg-white" type="email" placeholder="Email" name="emailSignin" required />
                                        <input class="w-full px-8 py-4 rounded-lg font-medium bg-slate-100 border border-slate-200 placeholder-slate-500 text-sm focus:outline-none focus:border-slate-400 focus:bg-white mt-5" type="password" placeholder="Password" name="passwordSignin" required />
                                        <input type="hidden" name="signin_action">
                                        <button class="mt-5 tracking-wide font-semibold bg-green-400 text-white-500 w-full py-4 rounded-lg hover:bg-green-700 transition-all duration-300 ease-in-out flex items-center justify-center focus:shadow-outline focus:outline-none">
                                            <svg class="w-6 h-6 -ml-2" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M16 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2" />
                                                <circle cx="8.5" cy="7" r="4" />
                                                <path d="M20 8v6M23 11h-6" />
                                            </svg>
                                            <span class="ml-3">
                                                Sign In
                                            </span>
                                        </button>
                                    </form>
                                    <p class="mt-6 text-sm text-slate-600 text-center">
                                        Don't have an account?
                                        <a href="#" id="signUp-link" class="border-b border-slate-500 border-dotted">
                                            Sign Up
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Sign In - End -->

                    <!-- Sign Up - Start -->
                    <div id="signUp-form" class="hidden">
                        <div class="mt-3 mb-12 border-b text-center">
                            <div class="leading-none px-2 inline-block text-4xl text-slate-800 tracking-wide font-extrabold bg-white transform translate-y-1/2">
                                Sign Up
                            </div>
                        </div>
                        <div class="mt-4 flex flex-col items-center">
                            <div class="w-full flex-1">
                                <div class="signup mx-auto max-w-xs">
                                    <form method="post" action="">
                                        <input class="w-full px-8 py-4 rounded-lg font-medium bg-slate-100 border border-slate-200 placeholder-slate-500 text-sm focus:outline-none focus:border-slate-400 focus:bg-white" type="text" placeholder="Username" name="username" required />
                                        <input class="w-full px-8 py-4 rounded-lg font-medium bg-slate-100 border border-slate-200 placeholder-slate-500 text-sm focus:outline-none focus:border-slate-400 focus:bg-white mt-5" type="email" placeholder="Email" name="email" required />
                                        <input class="w-full px-8 py-4 rounded-lg font-medium bg-slate-100 border border-slate-200 placeholder-slate-500 text-sm focus:outline-none focus:border-slate-400 focus:bg-white mt-5" type="password" placeholder="Password" name="password" required />
                                        <input type="hidden" name="signup_action">
                                        <button class="mt-5 tracking-wide font-semibold bg-green-400 text-white-500 w-full py-4 rounded-lg hover:bg-green-700 transition-all duration-300 ease-in-out flex items-center justify-center focus:shadow-outline focus:outline-none">
                                            <svg class="w-6 h-6 -ml-2" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M16 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2" />
                                                <circle cx="8.5" cy="7" r="4" />
                                                <path d="M20 8v6M23 11h-6" />
                                            </svg>
                                            <span class="ml-3">
                                                Sign Up
                                            </span>
                                        </button>
                                    </form>
                                </div>

                                <p class="mt-6 text-sm text-slate-600 text-center">
                                    Already have an account?
                                    <a href="#" id="signIn-link" class="border-b border-slate-500 border-dotted">
                                        Sign In
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                    <!-- Sign Up - End -->
                </div>
                <div class="flex-1 bg-green-100 text-center hidden lg:flex">
                    <div class="m-12 xl:m-16 w-full bg-contain bg-center bg-no-repeat" style="background-image: url('https://drive.google.com/uc?export=view&id=1KZ_Ub_2lZ0dHbKV0fAIhxVhiQA183RCz');">
                    </div>
                </div>
            </div>
        </div>

        <script src="../src/js/index.js"></script>
    </body>

</html>

