<?php
    session_start();
    include '../../src/php/koneksi.php';

    if(!isset($_SESSION['email'])) {
        header("Location: ../index.php");
        exit;
    } else{
        $email = $_SESSION['email'];
        if(isset($_POST["submit"])){
            //catch all user's inputs into their own variable
            $category = $_POST["category"];

            $dateString = $_POST["date"];
            $date = DateTime::createFromFormat('d/m/Y', $dateString);
            $formattedDate = $date->format('Y-m-d');

            $description = $_POST["description"];
            $type = $_POST["type"];
            $amount = $_POST["amount"];

            $searchUserId = pg_query($connection, "SELECT user_id FROM users WHERE email = '$email'");
            if($searchUserId){
                //change searchUserId into associative array
                $row = pg_fetch_assoc($searchUserId);
                $user_id = $row['user_id'];
                //insert data into database
                $insertQuery = pg_query($connection, "INSERT INTO transaksi 
                    (user_id, amount, transaction_date, transaction_type, description, category_id)
                    VALUES ('$user_id', '$amount', '$formattedDate', '$type', '$description', '$category')");
            }
        }
    }
    
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="../css/style.css" />
        <link
            rel="icon"
            href="../assets/Xpenser_Logo.png"
            type="image/icon type"
        />
        <title>Transaction</title>
    </head>
    <body class="bg-slate-100 dark:bg-slate-800 transition duration-300 transform">
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
        <div x-data="{ sidebarOpen: false, transactionForm: false, editTransaction: false }" class="flex h-screen rounded-r-xl">
                <!-- Sidebar-Start -->
                <section id="sidebar">
                    <div :class="sidebarOpen ? 'block' : 'hidden'" @click="sidebarOpen = false" class="fixed inset-0 z-10 transition-opacity bg-black opacity-50 lg:hidden h-screen"></div>
                    <div :class="sidebarOpen ? 'translate-x-0 ease-out' : '-translate-x-full ease-in'" class="fixed rounded-r-xl inset-y-0 left-0 z-[999] w-64 overflow-y-auto transition duration-200 transform bg-white h-screen dark:bg-slate-700 lg:translate-x-0 lg:static lg:inset-0 shadow-xl">
                        <div class="flex items-center justify-center mt-8">
                            <div class="flex items-center">
                                <img src="../assets/Xpenser_Logo.png" width="50" alt="XpenseR Logo">
                                <img src="../assets/XpenseR.png" width="100" alt="">
                            </div>
                        </div>
                        <div class="mt-8 mb-1 whitespace-no-wrap border-b border-slate-200 dark:border-slate-600"></div>
                        <nav class="mt-10">
                            <a class="flex my-5 items-center font-semibold px-6 py-2 text-black dark:text-white rounded-xl mx-5 hover:bg-primary hover:opacity-50" href="dashboard.php">
                                <svg fill="#000000" width="24" height="24" viewBox="0 0 24 24" id="dashboard" data-name="Flat Line" xmlns="http://www.w3.org/2000/svg" class="icon flat-line" stroke="#000000">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <path id="secondary" d="M9,12H4a1,1,0,0,1-1-1V4A1,1,0,0,1,4,3H9a1,1,0,0,1,1,1v7A1,1,0,0,1,9,12Zm12,8V13a1,1,0,0,0-1-1H15a1,1,0,0,0-1,1v7a1,1,0,0,0,1,1h5A1,1,0,0,0,21,20Z" style="fill: #0fc266; stroke-width: 2;"></path>
                                        <path id="primary" d="M21,7V4a1,1,0,0,0-1-1H15a1,1,0,0,0-1,1V7a1,1,0,0,0,1,1h5A1,1,0,0,0,21,7ZM10,20V17a1,1,0,0,0-1-1H4a1,1,0,0,0-1,1v3a1,1,0,0,0,1,1H9A1,1,0,0,0,10,20ZM9,12H4a1,1,0,0,1-1-1V4A1,1,0,0,1,4,3H9a1,1,0,0,1,1,1v7A1,1,0,0,1,9,12Zm12,8V13a1,1,0,0,0-1-1H15a1,1,0,0,0-1,1v7a1,1,0,0,0,1,1h5A1,1,0,0,0,21,20Z" style="fill: none; stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;" class="dark:stroke-[#ffffff] dark:stroke-linecap dark:fill-white"></path>
                                    </g>
                                </svg>
                                <span class="mx-3">Dashboard</span>
                            </a>
                            <a class="flex my-5 items-center font-semibold px-6 py-2 mt-1 text-white bg-primary shadow-lg shadow-primary/50 rounded-xl mx-5"
                                href="transaction.php">
                                <svg viewBox="0 0 1024 1024" width="24" height="24" class="icon" version="1.1" xmlns="http://www.w3.org/2000/svg" fill="#000000">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <path d="M533 1024l-147.7-84.8-136.4 78.3h-11.3c-17.3 0-34.2-3.4-50.1-10.1-15.3-6.5-29.1-15.7-40.8-27.6-11.7-11.7-21-25.5-27.5-40.8-6.7-15.9-10.1-32.7-10.1-50.1V128.5c0-17.4 3.4-34.2 10.1-50.1 6.5-15.3 15.8-29.1 27.6-40.8 11.7-11.8 25.5-21 40.8-27.5C203.3 3.4 220.2 0 237.5 0h590.9c17.3 0 34.2 3.4 50.1 10.1 15.3 6.5 29.1 15.7 40.8 27.6 11.7 11.7 21 25.5 27.5 40.8 6.7 15.9 10.1 32.7 10.1 50.1V889c0 17.4-3.4 34.2-10.1 50.1-6.5 15.3-15.8 29.1-27.6 40.8-11.7 11.8-25.5 21-40.8 27.5-15.8 6.7-32.7 10.1-50 10.1h-11.3l-136.4-78.3L533 1024z m147.7-182.6l157.2 90.3c2.5-0.6 5-1.4 7.5-2.4 5.2-2.2 9.9-5.4 13.9-9.4 4.1-4.1 7.2-8.7 9.4-14 2.3-5.3 3.4-11.1 3.4-17V128.5c0-5.9-1.1-11.7-3.4-17-2.2-5.2-5.4-9.9-9.4-13.9-4.1-4.1-8.7-7.2-13.9-9.4-5.4-2.3-11.1-3.4-17-3.4H237.5c-5.9 0-11.6 1.1-17 3.4-5.2 2.2-9.9 5.4-13.9 9.4-4.1 4.1-7.2 8.7-9.4 14-2.3 5.3-3.4 11.1-3.4 17V889c0 5.9 1.1 11.7 3.4 17 2.2 5.2 5.4 9.9 9.4 13.9 4.1 4.1 8.7 7.2 13.9 9.4 2.4 1 4.9 1.8 7.5 2.4l157.2-90.3L533 926.2l147.7-84.8z" fill="#ffffff" class="dark:fill-white"></path>
                                        <path d="M490.6 310.9H321c-23.4 0-42.4-19-42.4-42.4s19-42.4 42.4-42.4h169.6c23.4 0 42.4 19 42.4 42.4s-19 42.4-42.4 42.4zM702.5 487.6H321c-23.4 0-42.4-19-42.4-42.4s19-42.4 42.4-42.4h381.6c23.4 0 42.4 19 42.4 42.4-0.1 23.4-19 42.4-42.5 42.4z" fill="#1eae2e">
                                        </path>
                                    </g>
                                </svg>
                                <span class="mx-3">Transaction</span>
                            </a>
                            <a class="flex my-5 items-center font-semibold  px-6 py-2 mt-1 text-black dark:text-white rounded-xl mx-5 hover:bg-primary hover:opacity-50"
                                href="account.php">
                                <svg xmlns="http://www.w3.org/2000/svg" class="fill-stroke"  width="24" height="24" fill="none" viewBox="0 0 448 512">
                                    <path fill="black" class="dark:fill-white" d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H418.3c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304H178.3z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <span class="mx-3">Account</span>
                            </a>
                        </nav>
                        <div class="absolute bottom-0 flex justify-center items-center w-full">
                            <button id="theme-toggle" type="button" class="mr-0 text-slate-700 dark:text-yellow-200 hover:bg-slate-100 dark:hover:bg-slate-700  rounded-lg text-sm p-2.5">
                                <svg id="theme-toggle-dark-icon" class="w-5 h-5 hidden" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z" ></path>
                                </svg>
                                <svg id="theme-toggle-light-icon" class="w-5 h-5 hidden" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 
                                    11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"
                                    fill-rule="evenodd"
                                    clip-rule="evenodd" >
                                    </path>
                                </svg>
                            </button>
                            <p class="font-semibold dark:text-white">Theme Mode</p>
                        </div>
                    </div>
                    <div class="flex flex-col flex-1 overflow-hidden lg:hidden bg-white dark:bg-slate-700 h-screen shadow-xl">
                        <header class="flex items-center justify-between px-2 py-4 ">
                            <div class="flex items-center">
                                <button @click="sidebarOpen = true" class="text-slate-500 dark:text-slate-100 focus:outline-none lg:hidden">
                                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4 6H20M4 12H20M4 18H11" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round"></path>
                                    </svg>
                                </button>
                            </div>
                        </header>
                    </div>
                </section>
                <!-- Sidebar-End -->

                <!-- Main-Start -->
                <section id="main" class="flex-1 overflow-x-hidden overflow-y-auto">
                    <span>
                        <h2 class="text-3xl font-semibold mt-4 text-slate-700 pb-3 border-b-2 drop-shadow-2xl dark:text-slate-100 text-center">Transaction</h2>
                        <div class="container px-6 pt-8 mx-auto relative">
            
                            <div class="mt-4">
                                <div class="flex flex-wrap -mx-6">

                                    <div class="w-full px-6 sm:w-1/2 xl:w-1/3">
                                        <div class="flex items-center px-5 py-6 bg-white dark:bg-slate-600 dark:border-slate-700 dark:border-[1px] rounded-md  shadow-xl">
                                            <div class="p-3 rounded-full">
                                                <svg class="w-8 h-8" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="iconify iconify--emojione" preserveAspectRatio="xMidYMid meet" fill="#000000">
                                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                                    <g id="SVGRepo_iconCarrier">
                                                        <path fill="#699635" d="M0 46.5h64v9H0z"></path>
                                                        <path fill="#83bf4f" d="M0 8.5h64v38H0z"></path>
                                                        <path fill="#94989b" d="M24 46.5h16v9H24z"></path>
                                                        <path fill="#699635" d="M4 12.5h56v30H4z"></path>
                                                        <path fill="#83bf4f" d="M7 15.5h50v24H7z"></path>
                                                        <circle cx="45" cy="27.5" r="8" fill="#699635"></circle>
                                                        <path fill="#d0d0d0" d="M24 8.5h16v38H24z"></path>
                                                        <path d="M16 26.5c-1.1 0-2-.9-2-2s.9-2 2-2s2 .9 2 2h2c0-1.9-1.3-3.4-3-3.9v-1.1h-2v1.1c-1.7.4-3 2-3 3.9c0 2.2 1.8 4 4 4c1.1 0 2 .9 2 2s-.9 2-2 2s-2-.9-2-2h-2c0 1.9 1.3 3.4 3 3.9v1.1h2v-1.1c1.7-.4 3-2 3-3.9c0-2.2-1.8-4-4-4" fill="#ffffff"></path>
                                                    </g>
                                                </svg>
                                            </div>
            
                                            <div class="mx-5">
                                                <h4 class="text-[15px] font-bold text-slate-700 dark:text-slate-100">Total Balance</h4>
                                                <?php    
                                                    $searchUserId = pg_query($connection, "SELECT user_id FROM users WHERE email = '$email'");
                                                    if($searchUserId):
                                                        //change searchUserId into associative array
                                                        $userRow = pg_fetch_assoc($searchUserId);
                                                        $user_id = $userRow['user_id'];

                                                        //search data 'amount' with user_id same as the email
                                                        $readDataQuery = pg_query($connection, "SELECT transaction_type, amount FROM transaksi 
                                                            WHERE user_id = '$user_id'");
                                                        $rows = pg_fetch_all($readDataQuery);

                                                        //add total amount of all transaction that fits the criteria
                                                        $total = 0;
                                                        if(!empty($rows)):
                                                            foreach($rows as $row):
                                                                if($row["transaction_type"] == "Expense"):
                                                                    $total -= $row["amount"];
                                                            
                                                                elseif($row["transaction_type"] == "Income"):
                                                                    $total += $row["amount"];
                                                                endif;
                                                            endforeach;
                                                        endif;

                                                        $formattedTotal = "Rp. " . number_format($total, 0, '.', ',');
                                                ?>
                                                
                                                <div class="text-<?php if($total >= 0){echo "primary";} else{echo "rose-500";} ?> font-semibold">
                                                <?php
                                                        echo $formattedTotal;
                                                    endif;           
                                                ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
            
                                    <div class="w-full px-6 mt-6 sm:w-1/2 xl:w-1/3 sm:mt-0">
                                        <div class="flex items-center px-5 py-6 bg-white dark:bg-slate-600 dark:border-slate-700 dark:border-[1px] rounded-md shadow-xl">
                                            <div class="p-3 rounded-full">
                                                <svg class="w-8 h-8" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="iconify iconify--emojione" preserveAspectRatio="xMidYMid meet" fill="#000000">
                                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                                    <g id="SVGRepo_iconCarrier">
                                                        <path fill="#699635" d="M0 46.5h64v9H0z"></path>
                                                        <path fill="#83bf4f" d="M0 8.5h64v38H0z"></path>
                                                        <path fill="#94989b" d="M24 46.5h16v9H24z"></path>
                                                        <path fill="#699635" d="M4 12.5h56v30H4z"></path>
                                                        <path fill="#83bf4f" d="M7 15.5h50v24H7z"></path>
                                                        <circle cx="45" cy="27.5" r="8" fill="#699635"></circle>
                                                        <path fill="#d0d0d0" d="M24 8.5h16v38H24z"></path>
                                                        <path d="M16 26.5c-1.1 0-2-.9-2-2s.9-2 2-2s2 .9 2 2h2c0-1.9-1.3-3.4-3-3.9v-1.1h-2v1.1c-1.7.4-3 2-3 3.9c0 2.2 1.8 4 4 4c1.1 0 2 .9 2 2s-.9 2-2 2s-2-.9-2-2h-2c0 1.9 1.3 3.4 3 3.9v1.1h2v-1.1c1.7-.4 3-2 3-3.9c0-2.2-1.8-4-4-4" fill="#ffffff"></path>
                                                    </g>
                                                </svg>
                                            </div>
            
                                            <div class="mx-5 w-fit">
                                                <h4 class="text-[15px] font-bold text-slate-700 dark:text-slate-100"><?= Date("F");?> Expenses</h4>
                                                <div class="text-rose-500 font-semibold">
                                                    <?php
                                                        date_default_timezone_set('Asia/Jakarta');
                                                        $month = Date("m");

                                                        $searchUserId = pg_query($connection, "SELECT user_id FROM users WHERE email = '$email'");
                                                        if($searchUserId):
                                                            //change searchUserId into associative array
                                                            $userRow = pg_fetch_assoc($searchUserId);
                                                            $user_id = $userRow['user_id'];

                                                            //search data 'amount' with date dan user_id fits the criteria
                                                            $readDataQuery = pg_query($connection, "SELECT amount FROM transaksi 
                                                                WHERE EXTRACT(MONTH FROM transaction_date) = '$month' AND user_id = '$user_id' AND transaction_type='Expense'");
                                                            $rows = pg_fetch_all($readDataQuery);

                                                            //add total amount of all transaction that fits the criteria
                                                            $total = 0;
                                                            if(!empty($rows)):
                                                                foreach($rows as $row):
                                                                    $total += $row["amount"];
                                                                endforeach;
                                                            endif;

                                                            $formattedTotal = "Rp. " . number_format($total, 0, '.', ',');
                                                            echo $formattedTotal;
                                                        endif;                                                     
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
            
                                    <div class="w-full px-6 mt-6 sm:w-1/2 xl:w-1/3 xl:mt-0">
                                        <div class="flex items-center px-5 py-6 bg-white dark:bg-slate-600 dark:border-slate-700 dark:border-[1px] rounded-md shadow-xl">
                                            <div class="p-3 rounded-full">
                                                <svg class="w-8 h-8" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="iconify iconify--emojione" preserveAspectRatio="xMidYMid meet" fill="#000000">
                                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                                    <g id="SVGRepo_iconCarrier">
                                                        <path fill="#699635" d="M0 46.5h64v9H0z"></path>
                                                        <path fill="#83bf4f" d="M0 8.5h64v38H0z"></path>
                                                        <path fill="#94989b" d="M24 46.5h16v9H24z"></path>
                                                        <path fill="#699635" d="M4 12.5h56v30H4z"></path>
                                                        <path fill="#83bf4f" d="M7 15.5h50v24H7z"></path>
                                                        <circle cx="45" cy="27.5" r="8" fill="#699635"></circle>
                                                        <path fill="#d0d0d0" d="M24 8.5h16v38H24z"></path>
                                                        <path d="M16 26.5c-1.1 0-2-.9-2-2s.9-2 2-2s2 .9 2 2h2c0-1.9-1.3-3.4-3-3.9v-1.1h-2v1.1c-1.7.4-3 2-3 3.9c0 2.2 1.8 4 4 4c1.1 0 2 .9 2 2s-.9 2-2 2s-2-.9-2-2h-2c0 1.9 1.3 3.4 3 3.9v1.1h2v-1.1c1.7-.4 3-2 3-3.9c0-2.2-1.8-4-4-4" fill="#ffffff"></path>
                                                    </g>
                                                </svg>
                                            </div>
            
                                            <div class="mx-5">
                                                <h4 class="text-[15px] font-bold text-slate-700 dark:text-slate-100"><?= Date("l");?> Expenses</h4>
                                                <div class="text-rose-500 font-semibold">
                                                <?php
                                                        date_default_timezone_set('Asia/Jakarta');
                                                        $day = Date("l");
                                                        $dayDate = Date("j");

                                                        $searchUserId = pg_query($connection, "SELECT user_id FROM users WHERE email = '$email'");
                                                        if($searchUserId):
                                                            //change searchUserId into associative array
                                                            $userRow = pg_fetch_assoc($searchUserId);
                                                            $user_id = $userRow['user_id'];

                                                            //search data 'amount' with date dan user_id fits the criteria
                                                            $readDataQuery = pg_query($connection, "SELECT amount FROM transaksi 
                                                                WHERE EXTRACT(DAY FROM transaction_date) = '$dayDate' AND user_id = '$user_id' AND transaction_type='Expense'");
                                                            $rows = pg_fetch_all($readDataQuery);

                                                            //add total amount of all transaction that fits the criteria
                                                            $total = 0;
                                                            if(!empty($rows)):
                                                                foreach($rows as $row):
                                                                    $total += $row["amount"];
                                                                endforeach;
                                                            endif;

                                                            $formattedTotal = "Rp. " . number_format($total, 0, '.', ',');
                                                            echo $formattedTotal;
                                                        endif;                                                     
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    
                                </div>
                            </div>
                            
                            <hr class="my-8">
    
                            <h3 class="text-xl mt-8 font-medium text-slate-700 drop-shadow-2xl dark:text-slate-100 text-center">Your Transactions</h3>
                            <div class="flex flex-col">
                                <div class="py-2 sm:py-10 -my-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
                                    <div class="inline-block min-w-full max-h-[46rem] overflow-scroll sm:shadow-xl align-middle sm:rounded-lg">
                                        <table class="min-w-full">
                                            <thead>
                                                <tr>
                                                    <th
                                                        class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-slate-500 uppercase border-b border-slate-200 bg-slate-50 dark:border-slate-500 dark:bg-slate-600 dark:text-slate-100">
                                                        Category</th>
                                                    <th
                                                        class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-slate-500 uppercase border-b border-slate-200 bg-slate-50 dark:border-slate-500 dark:bg-slate-600 dark:text-slate-100">
                                                        Description</th>
                                                    <th
                                                        class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-slate-500 uppercase border-b border-slate-200 bg-slate-50 dark:border-slate-500 dark:bg-slate-600 dark:text-slate-100">
                                                        Type</th>
                                                    <th
                                                        class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-slate-500 uppercase border-b border-slate-200 bg-slate-50 dark:border-slate-500 dark:bg-slate-600 dark:text-slate-100">
                                                        Value
                                                    </th>
                                                    <th class="px-6 py-3 border-b border-slate-200 bg-slate-50 dark:border-slate-500 dark:bg-slate-600"></th>
                                                    <th class="px-6 py-3 border-b border-slate-200 bg-slate-50 dark:border-slate-500 dark:bg-slate-600"></th>
                                                </tr>
                                            </thead>

                                            <tbody class="bg-white dark:bg-slate-600">
                                            <?php 
                                                $searchUserId = pg_query($connection, "SELECT user_id FROM users WHERE email = '$email'");
                                                if($searchUserId):
                                                    //change searchUserId into associative array
                                                    $row = pg_fetch_assoc($searchUserId);
                                                    $user_id = $row['user_id'];
                                                    $readDataQuery = pg_query($connection, "SELECT * FROM transaksi where user_id = '$user_id'"); 
                                                    if($readDataQuery):
                                                        $rows = pg_fetch_all($readDataQuery);
                                                        foreach($rows as $row):
                                                        $category_id = $row["category_id"];
                                                        $searchCategory = pg_query($connection, "SELECT category_type FROM category WHERE id = '$category_id'");
                                                        $category = pg_fetch_array($searchCategory)[0];
                                            ?>
                                                <tr>
                                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-slate-200 dark:border-slate-500">
                                                        <div class="flex items-center">
                                                            <div class="flex-shrink-0 w-10 h-10">
                                                            <?php 
                                                                $icons =['<svg height="40px" width="40px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512.002 512.002" xml:space="preserve" fill="#000000">
                                                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                                                            <g id="SVGRepo_iconCarrier">
                                                                                <g>
                                                                                    <path style="fill:#FCD051;" d="M281.333,394.663l-2.809-44.901l-3.688-59.019c-96.15-9.24-242.833,5.777-242.833,103.92h32H281.333 z"></path>
                                                                                    <polygon style="fill:#ED8C18;" points="281.333,394.663 64.003,394.663 64.003,437.331 284,437.331 "></polygon>
                                                                                    <path style="fill:#FCD051;" d="M284,437.331H64.003H42.999c-6.048,0-10.997,4.949-10.997,10.999v21.002 c0,17.601,14.401,32.002,32,32.002H288L284,437.331z"></path>
                                                                                    <path style="fill:#657694;" d="M281.333,394.663L284,437.331l4,64.002h159.996l6.665-106.676l4.002-63.992 c-132.974,0-134.526-129.659-137.859-170.662h-54.139l8.171,130.741l3.688,59.019L281.333,394.663z"></path>
                                                                                    <path style="fill:#ABB8B9;" d="M320.804,160.003c3.334,41.003,4.886,170.662,137.859,170.662l10.665-170.662L320.804,160.003 L320.804,160.003z"></path>
                                                                                    <polygon style="fill:#657694;" points="320.804,160.003 469.33,160.003 480,160.003 469.33,117.333 367.998,117.333 266.665,117.333 256,160.003 266.665,160.003 "></polygon>
                                                                                </g>
                                                                                <g>
                                                                                    <path style="fill:#000003;" d="M490.348,157.416l-10.67-42.67c-1.187-4.748-5.454-8.08-10.348-8.08h-90.665V88.397l70.184-70.186 c4.165-4.167,4.165-10.921-0.002-15.087c-4.165-4.167-10.919-4.165-15.085,0l-73.31,73.313c-2,2-3.123,4.713-3.123,7.542v22.687 h-90.665c-4.896,0-9.163,3.331-10.351,8.082l-10.665,42.668c-0.796,3.187-0.079,6.563,1.941,9.153 c2.021,2.59,5.124,4.103,8.409,4.103h0.644l6.776,108.416c-74.178-5.321-165.105,4.055-211.248,45.977 c-20.463,18.588-30.836,42.004-30.836,69.6c0,5.889,4.776,10.667,10.667,10.667h21.333v21.333H43 c-11.944,0-21.664,9.719-21.664,21.667v21.002c0,23.529,19.141,42.67,42.668,42.67H288h159.996c5.631,0,10.294-4.381,10.646-10.003 l20.708-331.328h0.647c3.283,0,6.385-1.515,8.407-4.103C490.429,163.978,491.144,160.603,490.348,157.416z M274.993,128h186.009 l5.334,21.335H269.661L274.993,128z M66.517,340.854c41.755-37.937,130.768-45.441,198.245-40.27l2.409,38.512h-43.759 c-5.892,0-10.667,4.776-10.667,10.667s4.776,10.667,10.667,10.667h45.092l1.473,23.566H43.348 C45.556,367.147,53.194,352.958,66.517,340.854z M74.671,405.331h196.641l1.333,21.333H74.671V405.331z M42.67,469.331v-21.002 c0-0.158,0.173-0.332,0.33-0.332h230.978l2.667,42.668H64.003C52.24,490.666,42.67,481.094,42.67,469.331z M298.022,490.666 L278.02,170.67h32.87c1.796,25.154,5.163,65.355,23.746,101.017c22.487,43.155,60.369,66.436,112.694,69.33l-2.686,42.972h-43.732 c-5.892,0-10.667,4.777-10.667,10.667c0,5.892,4.776,10.667,10.667,10.667h42.399l-5.334,85.341H298.022V490.666z M448.66,319.727 c-44.915-2.407-76.091-21.407-95.104-57.897c-16.213-31.117-19.568-67.594-21.276-91.158h125.695L448.66,319.727z"></path>
                                                                                    <path style="fill:#000003;" d="M192.515,360.434h0.256c5.889,0,10.667-4.776,10.667-10.667s-4.778-10.667-10.667-10.667h-0.256 c-5.892,0-10.667,4.776-10.667,10.667C181.847,355.659,186.622,360.434,192.515,360.434z"></path>
                                                                                    <path style="fill:#000003;" d="M370.268,383.996h-0.254c-5.892,0-10.667,4.776-10.667,10.667c0,5.889,4.776,10.667,10.667,10.667 h0.254c5.892,0,10.667-4.778,10.667-10.667C380.935,388.772,376.161,383.996,370.268,383.996z"></path>
                                                                                </g>
                                                                            </g>
                                                                        </svg>',
                                                                        '<svg viewBox="0 0 1024 1024" class="icon" version="1.1" xmlns="http://www.w3.org/2000/svg" fill="#000000">
                                                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                                                            <g id="SVGRepo_iconCarrier">
                                                                                <path d="M213.333333 874.666667c-105.877333 0-192-86.122667-192-192s86.122667-192 192-192 192 86.122667 192 192-86.122667 192-192 192z" fill="#444444"></path>
                                                                                <path d="M213.333333 789.333333c-58.816 0-106.666667-47.850667-106.666666-106.666666s47.850667-106.666667 106.666666-106.666667 106.666667 47.850667 106.666667 106.666667-47.850667 106.666667-106.666667 106.666666z" fill="#E6E6E6"></path>
                                                                                <path d="M469.333333 682.666667H213.333333l256-170.666667z" fill="#5B5B5B"></path>
                                                                                <path d="M469.333333 704H213.333333a21.333333 21.333333 0 0 1-11.84-39.082667l256-170.666666A21.312 21.312 0 0 1 490.666667 512v170.666667a21.333333 21.333333 0 0 1-21.333334 21.333333z m-185.536-42.666667H448v-109.482666L283.797333 661.333333z" fill="#5B5B5B"></path>
                                                                                <path d="M795.584 70.250667l-42.666667 42.666666a21.376 21.376 0 0 0 4.501334 33.6C794.368 167.637333 832 212.117333 832 234.666667c0 17.706667-14.677333 33.493333-36.416 41.664C597.333333 160 441.237333 347.2 441.237333 347.2c-8.042667 8.533333-24.192 15.466667-35.712 15.466667h-85.717333c-11.626667 0-27.861333-6.72-36.096-14.933334l-55.317333-55.338666c-8.277333-8.277333-24.533333-16.426667-36.138667-18.069334l-107.178667-15.317333c-11.584-1.642667-24.64 5.888-28.992 16.768l-27.114666 67.818667a21.333333 21.333333 0 0 0 11.136 27.413333L213.333333 448c129.621333 0 234.666667 105.066667 234.666667 234.666667 0 7.210667-0.426667 14.293333-1.066667 21.333333H640c4.181333 0 8.234667-1.216 11.733333-3.498667 0 0 240.661333-158.570667 241.792-159.488C934.186667 499.733333 1002.666667 413.162667 1002.666667 298.666667c0-170.816-177.770667-231.125333-185.344-233.6a21.333333 21.333333 0 0 0-21.738667 5.184z" fill="#72C472"></path>
                                                                                <path d="M430.72 355.136c-7.957333 4.501333-17.578667 7.530667-25.173333 7.530667h-85.76c-11.605333 0-27.84-6.72-36.053334-14.933334l-55.338666-55.338666c-8.277333-8.277333-24.533333-16.426667-36.138667-18.069334l-107.178667-15.317333c-11.584-1.642667-24.64 5.888-28.992 16.768l-15.616 39.082667L266.666667 405.333333h108.501333a21.333333 21.333333 0 0 0 15.082667-6.250666l42.517333-42.517334-2.026667-1.429333z" fill="#444444"></path>
                                                                                <path d="M810.666667 874.666667c-105.877333 0-192-86.122667-192-192s86.122667-192 192-192 192 86.122667 192 192-86.122667 192-192 192z" fill="#444444"></path>
                                                                                <path d="M810.666667 789.333333c-58.816 0-106.666667-47.850667-106.666667-106.666666s47.850667-106.666667 106.666667-106.666667 106.666667 47.850667 106.666666 106.666667-47.850667 106.666667-106.666666 106.666666z" fill="#E6E6E6"></path>
                                                                                <path d="M746.666667 384a21.333333 21.333333 0 0 1-15.082667-36.416l64-64a21.333333 21.333333 0 1 1 30.165333 30.165333l-64 64A21.269333 21.269333 0 0 1 746.666667 384z" fill="#444444"></path>
                                                                                <path d="M989.909333 224.704l-79.317333 26.432a21.333333 21.333333 0 0 0-14.592 20.245333V298.666667a21.333333 21.333333 0 0 0 21.333333 21.333333h84.522667c0.533333-6.997333 0.810667-14.101333 0.810667-21.333333 0-27.562667-4.970667-51.946667-12.757334-73.962667z" fill="#E6E6E6"></path>
                                                                            </g>
                                                                        </svg>',
                                                                        '<svg viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg" fill="#000000">
                                                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                                                            <g id="SVGRepo_iconCarrier">
                                                                                <defs>
                                                                                    <style>.cls-1{fill:#81d0e9;}.cls-2{fill:#56a7c9;}.cls-3{fill:#ffffff;}.cls-4{fill:#194568;}.cls-5{fill:#125488;}.cls-6{fill:#546c8c;}</style>
                                                                                </defs>
                                                                                <g id="main">
                                                                                    <rect class="cls-1" height="55" rx="3.31" width="53" x="5" y="8"></rect>
                                                                                    <path class="cls-2" d="M18,59H12.31A3.31,3.31,0,0,1,9,55.69V43a1,1,0,0,1,2,0V55.69A1.31,1.31,0,0,0,12.31,57H18a1,1,0,0,1,0,2Z"></path>
                                                                                    <rect class="cls-3" height="12.56" width="26.38" x="18.63" y="2.25"></rect>
                                                                                    <path class="cls-4" d="M51.34,11.32,46.92,1.61h0A1.1,1.1,0,0,0,46,1H18a1.07,1.07,0,0,0-.91.59l-4.4,9.92a3,3,0,0,0,.63,3.35l9.29,9.19A3,3,0,0,0,25,24.9a3,3,0,0,0,2.19-1.27L32,16.74l4.81,6.88a3,3,0,0,0,4.58.4l9.34-9.33A3,3,0,0,0,51.34,11.32ZM32,13.64,20.55,3h22.9Z"></path>
                                                                                    <path class="cls-5" d="M32,29a2,2,0,1,1,2-2A2,2,0,0,1,32,29Zm0-2h0Zm0,0h0Zm0,0h0Zm0,0h0Zm0,0h0Zm0,0h0Zm0,0h0Zm0,0h0Z"></path>
                                                                                    <path class="cls-5" d="M32,37a2,2,0,1,1,2-2A2,2,0,0,1,32,37Zm0-2h0Zm0,0h0Zm0,0h0Zm0,0h0Zm0,0h0Zm0,0h0Zm0,0h0Zm0,0h0Z"></path>
                                                                                    <path class="cls-5" d="M32,46a2,2,0,1,1,2-2A2,2,0,0,1,32,46Zm0-2h0Zm0,0h0Zm0,0h0Zm0,0h0Zm0,0h0Zm0,0h0Zm0,0h0Zm0,0h0Z"></path>
                                                                                    <path class="cls-5" d="M32,54a2,2,0,1,1,2-2A2,2,0,0,1,32,54Zm0-2h0Zm0,0h0Zm0,0h0Zm0,0h0Zm0,0h0Zm0,0h0Zm0,0h0Zm0,0h0Z"></path>
                                                                                    <path class="cls-6" d="M44,34a1,1,0,0,1-1-1V27a1,1,0,0,1,2,0v6A1,1,0,0,1,44,34Z"></path>
                                                                                    <rect class="cls-5" height="7" rx="2" width="14" x="39" y="32"></rect>
                                                                                </g>
                                                                            </g>
                                                                        </svg>',
                                                                        '<svg height="40px" width="40px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve" fill="#007552" stroke="#007552">
                                                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                                                            <g id="SVGRepo_iconCarrier">
                                                                                <path d="M37.728,49.312v186.48C37.728,413.104,256,512,256,512s218.272-98.896,218.272-276.208V49.312 C474.272,49.312,396.128,0,256,0S37.728,49.312,37.728,49.312z"></path>
                                                                                <path style="fill:#24cc46;" d="M256,0C115.872,0,37.728,49.312,37.728,49.312v186.48C37.728,413.104,256,512,256,512V0z"></path>
                                                                                <g>
                                                                                    <path style="fill:#FFFFFF;" d="M364.6,286.992c0,0-29.104,74.104-108.6,74.104s-108.6-74.104-108.6-74.104 S256,361.096,364.6,286.992z"></path>
                                                                                    <path style="fill:#FFFFFF;" d="M224.8,153.424c-16.072-37.664-59.632-55.168-97.296-39.096 c-17.584,7.504-31.592,21.512-39.096,39.096H224.8z"></path>
                                                                                    <path style="fill:#FFFFFF;" d="M423.592,153.424c-16.072-37.664-59.632-55.168-97.296-39.096 c-17.584,7.504-31.592,21.512-39.096,39.096H423.592z"></path>
                                                                                </g>
                                                                            </g>
                                                                        </svg>',
                                                                        '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"	 viewBox="0 0 3710 3710" style="enable-background:new 0 0 3710 3710;" xml:space="preserve">
                                                                            <g id="Background">
                                                                                <g>
                                                                                    <g>
                                                                                        <rect style="fill:#FFFFFF;" width="3710" height="3710"/>
                                                                                    </g>
                                                                                </g>
                                                                            </g>
                                                                            <g id="Illustration">
                                                                                <g>
                                                                                    <path style="fill:#F4F7FA;" d="M3012.83,990.375C2407.096,227.55,973.039,184.913,551.37,789.95			c-232.337,333.372-135.249,831.705-87.345,1077.584c88.155,452.482,305.534,743.779,353.001,805.568			c115.176,149.93,394.937,514.113,815.862,597.361c719.215,142.242,1616.634-581.977,1666.354-1399.057			C3327.905,1400.339,3065.199,1056.325,3012.83,990.375z"/>
                                                                                    <g>
                                                                                        <g>
                                                                                            <g>
                                                                                                <defs>
                                                                                                    <path id="SVGID_1_" d="M2621.778,2850.194c-86.652-99.341-199.676-259.146-237.281-473.742							c-43.18-246.415,52.547-339.865,54.039-623.421c2.13-404.768-269.259-582.514-161.326-751.609							c52.635-82.46,169.349-131.882,263.002-111.067c267.198,59.388,480.387,720.225,259.764,1106.622							c-99.78,174.756-233.994,215.807-283.017,408.063C2473.642,2574.922,2553.045,2741.274,2621.778,2850.194z"/>
                                                                                                </defs>
                                                                                                <linearGradient id="SVGID_00000097477391347869467750000003961290709588427939_" gradientUnits="userSpaceOnUse" x1="2321.5789" y1="913.6725" x2="2842.3679" y2="2570.7278">
                                                                                                    <stop  offset="0" style="stop-color:#FF9085"/>
                                                                                                    <stop  offset="1" style="stop-color:#FB6FBB"/>
                                                                                                </linearGradient>
                                                                                                <use xlink:href="#SVGID_1_"  style="overflow:visible;fill:url(#SVGID_00000097477391347869467750000003961290709588427939_);"/>
                                                                                                <clipPath id="SVGID_00000171677244804486388930000006749063959587402387_">
                                                                                                    <use xlink:href="#SVGID_1_"  style="overflow:visible;"/>
                                                                                                </clipPath>
                                                                                                <g style="clip-path:url(#SVGID_00000171677244804486388930000006749063959587402387_);">
                                                                                                    <path style="fill:#FFFFFF;" d="M2472.081,2570.304c-8.211-53.918-11.795-108.832-10.654-163.215							c2.626-125.006,30.09-204.66,64.86-305.506c22.592-65.522,48.197-139.786,71.442-240.514							c43.482-188.416,54.476-252.758,49-346.434c-10.843-185.513-80.807-326.348-121.548-393.788							c-57.79-95.668-132.991-178.164-223.512-245.197l2.156-2.906c90.899,67.315,166.417,150.159,224.453,246.232							c40.913,67.726,111.171,209.158,122.06,395.448c5.504,94.129-5.511,158.643-49.085,347.459							c-23.291,100.914-48.927,175.273-71.547,240.877c-34.668,100.547-62.048,179.967-64.664,304.405							c-1.137,54.175,2.433,108.879,10.612,162.594L2472.081,2570.304z"/>
                                                                                                    <path style="fill:#FFFFFF;" d="M2630.308,1387.741l-1.208-2.722c-52.321-117.831-160.702-162.592-242.411-179.393							c-88.73-18.247-166.083-8.404-166.859-8.302l-0.47-3.584c0.776-0.104,78.645-10.022,167.958,8.323							c81.931,16.828,190.42,61.515,243.84,178.71c8.832-11.858,47.723-67.035,69.922-147.015							c23.077-83.131,32.323-210.873-54.687-347.341l3.047-1.945c87.765,137.646,78.399,266.52,55.087,350.394							c-25.246,90.842-71.891,149.962-72.358,150.548L2630.308,1387.741z"/>
                                                                                                    <path style="fill:#FFFFFF;" d="M2613.964,1810.614c-1.576,0-2.433-0.021-2.499-0.023l-1.52-0.046l-0.218-1.502							c-18.738-129.511-81.597-204.182-131.029-244.016c-53.592-43.189-103.414-55.91-103.912-56.033l0.87-3.51							c0.502,0.125,50.973,12.985,105.172,56.616c49.797,40.086,113.06,115.073,132.254,244.893c0.151,0,0.316,0,0.491,0							c22.61,0,229.335-5.1,329.365-184.261l3.159,1.762c-55.638,99.656-143.666,144.948-207.712,165.397							C2677.248,1809.41,2625.702,1810.614,2613.964,1810.614z"/>
                                                                                                    <path style="fill:#FFFFFF;" d="M2597.886,2086.691c-38.743,0-61.929-7.974-62.227-8.079l-1.222-0.432l0.014-1.295							c1.601-140.277-152.52-303.582-154.078-305.214l2.619-2.496c1.562,1.639,155.728,164.965,155.085,306.416							c7.049,2.161,44.188,12.276,99.714,4.732c56.857-7.73,145.176-36.098,243.033-127.349l2.464,2.645							c-98.65,91.993-187.823,120.556-245.251,128.319C2623.315,2085.929,2609.857,2086.691,2597.886,2086.691z"/>
                                                                                                </g>
                                                                                            </g>
                                                                                        </g>
                                                                                        <g>
                                                                                            <g>
                                                                                                <defs>
                                                                                                    <path id="SVGID_00000167392229111640340980000008354505463593133466_" d="M2427.931,2718.985							c-45.591-72.07-104.148-189.972-86.856-324.881c30.167-235.359,257.232-257.575,363.644-541.072							c85.826-228.651-16.613-334.812,109.097-515.82c21.042-30.298,130.54-194.364,268.833-181.945							c77.93,6.996,130.407,66.839,140.259,78.074c148.891,169.789,78.548,563.986-123.77,816.256							c-116.24,144.939-176.06,138.947-401.009,345.797C2565.946,2516.941,2479.342,2638.088,2427.931,2718.985z"/>
                                                                                                </defs>
                                                                                                <linearGradient id="SVGID_00000077297918166319924990000005446262640366403256_" gradientUnits="userSpaceOnUse" x1="3262.6775" y1="1149.4146" x2="3948.5105" y2="-92.9852">
                                                                                                    <stop  offset="0.0036" style="stop-color:#E38DDD"/>
                                                                                                    <stop  offset="1" style="stop-color:#9571F6"/>
                                                                                                </linearGradient>
                                                                                                <use xlink:href="#SVGID_00000167392229111640340980000008354505463593133466_"  style="overflow:visible;fill:url(#SVGID_00000077297918166319924990000005446262640366403256_);"/>
                                                                                                <clipPath id="SVGID_00000113339244367960978310000001246168278719778233_">
                                                                                                    <use xlink:href="#SVGID_00000167392229111640340980000008354505463593133466_"  style="overflow:visible;"/>
                                                                                                </clipPath>
                                                                                                <g style="clip-path:url(#SVGID_00000113339244367960978310000001246168278719778233_);">
                                                                                                    <path style="fill:#FFFFFF;" d="M2441.432,2822.413c-39.807-201.609-19.292-357.06,60.971-462.034							c39.301-51.4,78.543-73.5,120.088-96.897c44.63-25.134,90.776-51.122,138.383-116.864							c46.255-63.882,53.234-109.515,62.066-167.285c7.951-52.01,17.846-116.741,59.882-215.17							c36.844-86.271,70.273-133.492,99.763-175.154c31.923-45.094,57.134-80.713,74.762-149.276							c28.799-112.009,16.639-234.875-36.139-365.184l3.349-1.359c53.079,131.043,65.288,254.669,36.293,367.445							c-17.794,69.207-43.177,105.065-75.313,150.464c-29.388,41.513-62.694,88.567-99.387,174.485							c-41.857,98.006-51.714,162.485-59.637,214.294c-8.906,58.255-15.94,104.268-62.712,168.86							c-48.066,66.384-94.568,92.57-139.535,117.894c-41.215,23.21-80.144,45.132-118.992,95.944							c-79.607,104.112-99.893,258.589-60.297,459.134L2441.432,2822.413z"/>
                                                                                                    <path style="fill:#FFFFFF;" d="M2969.656,1610.802l-0.197-2.412c-0.242-2.943-25.843-295.048-165.36-361.184l1.551-3.268							c134.568,63.791,164.409,333.316,167.189,361.748c142.245-55.809,224.319-153.32,268.184-225.481							c47.768-78.589,61.739-144.786,61.873-145.444l3.545,0.727c-0.137,0.667-14.238,67.477-62.329,146.596							c-44.381,73.018-127.631,171.819-272.2,227.845L2969.656,1610.802z"/>
                                                                                                    <path style="fill:#FFFFFF;" d="M2848.445,1871.618c-0.878,0-1.359-0.007-1.415-0.009l-1.555-0.03l-0.204-1.543							c-10.275-78.164-46.192-163.254-74.517-220.87c-30.705-62.466-59.328-106.968-59.615-107.41l3.04-1.962							c0.284,0.444,29.027,45.123,59.823,107.777c28.251,57.476,64.038,142.213,74.646,220.432							c11.521-0.014,85.932-1.311,180.107-30.898c94.111-29.566,227.781-94.245,330.141-234.474l2.92,2.131							c-102.975,141.074-237.441,206.115-332.11,235.837C2934.651,1870.44,2859.562,1871.618,2848.445,1871.618z"/>
                                                                                                    <path style="fill:#FFFFFF;" d="M2767.154,2252.409c-65.018,0-103.544-8.781-104.407-8.988l-1.854-0.44l0.537-1.829							c49.176-167.145-77.234-355.575-78.519-357.458l2.991-2.036c1.288,1.89,127.733,190.313,79.54,358.647							c20.746,4.291,211.77,39.093,459.569-72.096l1.481,3.3C2978.695,2237.822,2850.934,2252.409,2767.154,2252.409z"/>
                                                                                                </g>
                                                                                            </g>
                                                                                        </g>
                                                                                        <g>
                                                                                            <linearGradient id="SVGID_00000166664762087119166320000000644164064528171446_" gradientUnits="userSpaceOnUse" x1="-271.331" y1="969.7551" x2="-1502.238" y2="1980.8588" gradientTransform="matrix(0.9975 -0.069 0.069 0.9975 3435.6392 969.4205)">
                                                                                                <stop  offset="0" style="stop-color:#AA80F9"/>
                                                                                                <stop  offset="0.9964" style="stop-color:#6165D7"/>
                                                                                            </linearGradient>
                                                                                            <path style="fill:url(#SVGID_00000166664762087119166320000000644164064528171446_);" d="M2397.386,2654.304					c29.993-49.202,81.566-123.868,162.214-197.638c143.446-131.212,235.711-128.632,276.971-230.196					c42.709-105.13-35.958-157.604,17.69-277.523c4.512-10.083,63.083-136.554,162.67-140.814					c69.668-2.98,122.003,55.452,146.56,82.868c95.304,106.405,150.718,306.527,57.517,456.226					c-88.363,141.928-265.609,167.082-322.035,174.709c-98.99,13.38-134.663-12.318-234.158,3.977					C2543.818,2545.729,2453.518,2607.166,2397.386,2654.304z"/>
                                                                                        </g>
                                                                                    </g>
                                                                                    <g>
                                                                                        <g>
                                                                                            <g>
                                                                                                <defs>
                                                                                                    <path id="SVGID_00000050622724509493424380000014942530235363335297_" d="M1375.271,3018.585							c45.591-72.069,104.148-189.972,86.856-324.881c-30.167-235.359-257.232-257.575-363.643-541.072							c-85.826-228.651,16.612-334.812-109.097-515.82c-21.042-30.298-130.54-194.363-268.833-181.945							c-77.93,6.996-130.407,66.839-140.259,78.073c-148.891,169.789-78.548,563.986,123.77,816.256							c116.24,144.939,176.059,138.947,401.009,345.797C1237.256,2816.541,1323.86,2937.688,1375.271,3018.585z"/>
                                                                                                </defs>
                                                                                                <linearGradient id="SVGID_00000134946052605013332570000009115470086793495690_" gradientUnits="userSpaceOnUse" x1="5203.5684" y1="11478.3809" x2="6392.8838" y2="14061.2412">
                                                                                                    <stop  offset="0.0036" style="stop-color:#E38DDD"/>
                                                                                                    <stop  offset="1" style="stop-color:#9571F6"/>
                                                                                                </linearGradient>
                                                                                                <use xlink:href="#SVGID_00000050622724509493424380000014942530235363335297_"  style="overflow:visible;fill:url(#SVGID_00000134946052605013332570000009115470086793495690_);"/>
                                                                                                <clipPath id="SVGID_00000080173382999478573680000013824493198795531163_">
                                                                                                    <use xlink:href="#SVGID_00000050622724509493424380000014942530235363335297_"  style="overflow:visible;"/>
                                                                                                </clipPath>
                                                                                                <g style="clip-path:url(#SVGID_00000080173382999478573680000013824493198795531163_);">
                                                                                                    <path style="fill:#FFFFFF;" d="M1361.77,3122.014l-3.545-0.702c39.596-200.546,19.31-355.02-60.297-459.136							c-38.849-50.812-77.778-72.734-118.992-95.944c-44.967-25.325-91.468-51.51-139.535-117.894							c-46.771-64.592-53.806-110.605-62.712-168.86c-7.923-51.809-17.78-116.288-59.637-214.294							c-36.69-85.917-69.999-132.969-99.387-174.483c-32.137-45.399-57.52-81.257-75.314-150.466							c-28.995-112.776-16.786-236.4,36.293-367.443l3.349,1.359c-52.777,130.31-64.937,253.174-36.139,365.183							c17.629,68.565,42.843,104.184,74.763,149.279c29.494,41.66,62.919,88.881,99.763,175.15							c42.036,98.429,51.932,163.159,59.882,215.17c8.832,57.771,15.81,103.403,62.066,167.285							c47.607,65.741,93.753,91.73,138.383,116.864c41.545,23.396,80.786,45.497,120.088,96.897							C1381.063,2764.955,1401.577,2920.405,1361.77,3122.014z"/>
                                                                                                    <path style="fill:#FFFFFF;" d="M833.546,1910.402l-2.257-0.874c-144.568-56.026-227.819-154.827-272.2-227.845							c-48.091-79.119-62.192-145.929-62.329-146.596l3.546-0.728c0.133,0.662,14.143,66.966,61.95,145.571							c43.861,72.119,125.922,169.573,268.107,225.356c2.78-28.432,32.621-297.957,167.189-361.748l1.552,3.268							c-139.535,66.145-165.118,358.241-165.36,361.183L833.546,1910.402z"/>
                                                                                                    <path style="fill:#FFFFFF;" d="M954.76,2171.219c-11.11,0-86.203-1.178-181.265-31.022							c-94.669-29.722-229.135-94.763-332.11-235.837l2.921-2.131c102.396,140.277,236.121,204.958,330.271,234.517							c94.136,29.555,168.446,30.845,179.977,30.857c10.608-78.22,46.396-162.957,74.647-220.433							c30.796-62.654,59.538-107.333,59.823-107.777l3.04,1.962c-0.288,0.442-28.932,44.978-59.637,107.452							c-28.314,57.606-64.221,142.678-74.496,220.83l-0.204,1.543l-1.555,0.03C956.115,2171.212,955.634,2171.219,954.76,2171.219z"							/>
                                                                                                    <path style="fill:#FFFFFF;" d="M1036.048,2552.009c-83.78,0-211.528-14.578-359.34-80.902l1.481-3.3							c247.789,111.182,438.803,76.391,459.57,72.098c-48.193-168.335,78.252-356.756,79.54-358.646l2.991,2.036							c-1.285,1.883-127.695,190.312-78.519,357.457l0.537,1.829l-1.853,0.44							C1139.592,2543.228,1101.049,2552.009,1036.048,2552.009z"/>
                                                                                                </g>
                                                                                            </g>
                                                                                        </g>
                                                                                        <g>
                                                                                            <linearGradient id="SVGID_00000090259241049593892910000015320340945502231213_" gradientUnits="userSpaceOnUse" x1="2234.9224" y1="1443.4711" x2="1004.0152" y2="2454.5747" gradientTransform="matrix(-0.9975 -0.069 -0.069 0.9975 2900.2368 969.4205)">
                                                                                                <stop  offset="0" style="stop-color:#FF9085"/>
                                                                                                <stop  offset="1" style="stop-color:#FB6FBB"/>
                                                                                            </linearGradient>
                                                                                            <path style="fill:url(#SVGID_00000090259241049593892910000015320340945502231213_);" d="M1405.816,2953.904					c-29.993-49.202-81.566-123.868-162.214-197.638c-143.446-131.212-235.711-128.632-276.971-230.196					c-42.709-105.13,35.958-157.604-17.691-277.523c-4.512-10.083-63.083-136.554-162.67-140.814					c-69.668-2.98-122.003,55.452-146.56,82.868c-95.304,106.406-150.718,306.527-57.517,456.226					c88.363,141.927,265.609,167.082,322.035,174.709c98.99,13.38,134.662-12.318,234.158,3.977					C1259.384,2845.33,1349.684,2906.766,1405.816,2953.904z"/>
                                                                                        </g>
                                                                                    </g>
                                                                                    <g>
                                                                                        <linearGradient id="SVGID_00000177462969817797928410000017738091073493927318_" gradientUnits="userSpaceOnUse" x1="877.8799" y1="972.0797" x2="1612.6995" y2="940.131">
                                                                                            <stop  offset="0" style="stop-color:#AB316D"/>
                                                                                            <stop  offset="1" style="stop-color:#792D3D"/>
                                                                                        </linearGradient>
                                                                                        <path style="fill:url(#SVGID_00000177462969817797928410000017738091073493927318_);" d="M2115.966,1341.043				c-0.671,0.066-1.339,0.099-2,0.099c-10.606,0-19.669-8.662-20.696-20.233c-18.226-205.408-80.579-400.572-175.573-549.548				c-84.152-131.979-184.337-210.735-268.044-210.735c-0.096,0-0.183,0-0.28,0c-304.887,0.638-368.664,752.478-369.271,760.075				c-0.986,12.303-11.022,21.413-22.522,20.359c-11.452-1.059-19.939-11.888-18.956-24.186				c2.612-32.678,67.891-800.242,410.667-800.963c0.122,0,0.246,0,0.366,0c98.904,0,209.093,83.87,302.387,230.183				c98.909,155.122,163.783,357.752,182.667,570.567C2135.803,1328.953,2127.41,1339.87,2115.966,1341.043z"/>
                                                                                        <linearGradient id="SVGID_00000061454331645226175960000015379229518372499386_" gradientUnits="userSpaceOnUse" x1="801.0699" y1="2168.7209" x2="1488.327" y2="2168.7209">
                                                                                            <stop  offset="0" style="stop-color:#FFC444"/>
                                                                                            <stop  offset="0.9964" style="stop-color:#F36F56"/>
                                                                                        </linearGradient>
                                                                                        <path style="fill:url(#SVGID_00000061454331645226175960000015379229518372499386_);" d="M843.801,2888.493l401.35,218.246				l243.176-801.504L1087.64,1230.703l-113.618,29.922l-172.394,1543.22C797.725,2838.777,814.577,2872.601,843.801,2888.493z"/>
                                                                                        <linearGradient id="SVGID_00000099641276726056029300000001773812378244913552_" gradientUnits="userSpaceOnUse" x1="986.6119" y1="2168.7205" x2="1488.327" y2="2168.7205">
                                                                                            <stop  offset="0" style="stop-color:#FFC444"/>
                                                                                            <stop  offset="0.9964" style="stop-color:#F36F56"/>
                                                                                        </linearGradient>
                                                                                        <path style="opacity:0.3;fill:url(#SVGID_00000099641276726056029300000001773812378244913552_);" d="M1488.327,2305.234				L1087.64,1230.703l-67.017,17.649c-9.292,143.466-5.209,261.543,1.103,347.512c26.86,365.844,116.067,467.651,72.852,722.87				c-35.933,212.212-114.404,241.015-107.545,383.79c7.472,155.499,108.448,285.712,228.501,388.111l29.615,16.102				L1488.327,2305.234z"/>
                                                                                        <linearGradient id="SVGID_00000005262972410406333620000009554583208981440396_" gradientUnits="userSpaceOnUse" x1="1828.7153" y1="2052.5181" x2="3028.8772" y2="4074.6089">
                                                                                            <stop  offset="0" style="stop-color:#FFC444"/>
                                                                                            <stop  offset="0.9964" style="stop-color:#F36F56"/>
                                                                                        </linearGradient>
                                                                                        <polygon style="fill:url(#SVGID_00000005262972410406333620000009554583208981440396_);" points="1087.64,1230.703 				2599.057,1312.987 3079.377,2947.996 1245.151,3106.739 			"/>
                                                                                        <g style="opacity:0.3;">
                                                                                            <linearGradient id="SVGID_00000029040808081183700130000013664270231704982403_" gradientUnits="userSpaceOnUse" x1="1825.2189" y1="1873.0604" x2="2796.8135" y2="4154.8379">
                                                                                                <stop  offset="0" style="stop-color:#FFC444"/>
                                                                                                <stop  offset="0.9964" style="stop-color:#F36F56"/>
                                                                                            </linearGradient>
                                                                                            <path style="fill:url(#SVGID_00000029040808081183700130000013664270231704982403_);" d="M2599.056,1312.986l-788.214-42.911					c-13.299,20.914-30.918,54.982-34.199,98.444c-19.405,257.054,511.014,340.273,558.536,655.8					c36.18,240.223-186.442,517.402-385.078,640.893c-209.279,130.107-351.082,64.218-492.622,208.664					c-62.19,63.465-100.06,142.827-122.581,225.093l1744.479-150.974L2599.056,1312.986z"/>
                                                                                        </g>
                                                                                        <linearGradient id="SVGID_00000034047449558060755370000012631616664287515545_" gradientUnits="userSpaceOnUse" x1="2004.4583" y1="306.1031" x2="1684.9854" y2="3033.0388">
                                                                                            <stop  offset="0" style="stop-color:#AB316D"/>
                                                                                            <stop  offset="1" style="stop-color:#792D3D"/>
                                                                                        </linearGradient>
                                                                                        <path style="fill:url(#SVGID_00000034047449558060755370000012631616664287515545_);" d="M1551.224,1377.892				c-9.447,0-17.997-6.954-20.248-17.259c-4.254-19.474-102.573-479.628,36.06-705.455				c39.735-64.723,95.249-104.241,164.996-117.455c358.375-67.824,579.022,758.908,588.24,794.135				c3.108,11.888-3.342,24.229-14.407,27.57c-11.078,3.351-22.56-3.592-25.67-15.474c-2.16-8.232-219.355-823.178-540.931-762.194				c-58.852,11.146-103.818,43.213-137.472,98.03c-128.867,209.922-31.284,666.052-30.283,670.638				c2.625,12.018-4.322,24.049-15.511,26.871C1554.397,1377.7,1552.797,1377.892,1551.224,1377.892z"/>
                                                                                        <linearGradient id="SVGID_00000178180087468258114290000011162300093501288889_" gradientUnits="userSpaceOnUse" x1="2172.6223" y1="199.3721" x2="1248.2751" y2="1957.8828">
                                                                                            <stop  offset="0" style="stop-color:#AB316D"/>
                                                                                            <stop  offset="1" style="stop-color:#792D3D"/>
                                                                                        </linearGradient>
                                                                                        <ellipse style="fill:url(#SVGID_00000178180087468258114290000011162300093501288889_);" cx="1551.37" cy="1381.264" rx="58.172" ry="62.481"/>
                                                                                        <linearGradient id="SVGID_00000058547504538164612030000008085301212582256526_" gradientUnits="userSpaceOnUse" x1="2755.0608" y1="528.7753" x2="1830.7175" y2="2287.2791">
                                                                                            <stop  offset="0" style="stop-color:#AB316D"/>
                                                                                            <stop  offset="1" style="stop-color:#792D3D"/>
                                                                                        </linearGradient>
                                                                                        <ellipse style="fill:url(#SVGID_00000058547504538164612030000008085301212582256526_);" cx="2310.003" cy="1375.468" rx="58.172" ry="62.481"/>
                                                                                        <path style="fill:#D8DEE8;" d="M2714.723,2099.735l-469.247-457.563c-9.891-9.644-24.055-12.343-36.431-6.94l-250.42,109.329				c-21.103,9.213-28.377,37.383-14.707,56.955l408.696,585.156c11.297,16.173,32.532,19.74,47.886,8.043l310.972-236.923				C2729.574,2144,2731.156,2115.759,2714.723,2099.735z M2178.135,1803.026c-15.811,11.417-40.73,1.34-55.659-22.509				c-14.929-23.849-14.213-52.438,1.598-63.856c15.811-11.417,40.73-1.34,55.659,22.509				C2194.662,1763.02,2193.946,1791.608,2178.135,1803.026z"/>
                                                                                        <path style="fill:#F4F7FA;" d="M2714.723,2093.49l-469.247-457.563c-9.891-9.644-24.055-12.343-36.431-6.94l-250.42,109.329				c-21.103,9.213-28.377,37.383-14.707,56.955l408.696,585.156c11.297,16.174,32.532,19.74,47.886,8.043l310.972-236.923				C2729.574,2137.755,2731.156,2109.514,2714.723,2093.49z M2178.135,1796.781c-15.811,11.417-40.73,1.34-55.659-22.509				c-14.929-23.849-14.213-52.438,1.598-63.856c15.811-11.417,40.73-1.34,55.659,22.509				C2194.662,1756.775,2193.946,1785.364,2178.135,1796.781z"/>
                                                                                        <g>
                                                                                            <path style="fill:#26264F;" d="M2080.612,1684.411c-1.498,0-2.923-0.881-3.545-2.348					c-16.256-38.322-38.181-71.422-65.168-98.384c-73.944-73.876-169.43-85.493-261.773-96.727					c-91.886-11.179-178.678-21.737-230.522-94.86c-13.124-18.51-33.51-51.964-22.574-68.062c4.387-6.457,13.147-9.429,26.013-8.813					c2.124,0.1,3.763,1.903,3.664,4.026c-0.1,2.125-1.878,3.799-4.028,3.664c-6.889-0.321-15.82,0.356-19.28,5.45					c-5.81,8.553,3.015,31.823,22.487,59.281c49.874,70.344,135.023,80.703,225.171,91.67					c93.638,11.391,190.462,23.17,266.284,98.923c27.69,27.666,50.17,61.588,66.813,100.826c0.831,1.957-0.083,4.216-2.04,5.047					C2081.623,1684.313,2081.113,1684.411,2080.612,1684.411z"/>
                                                                                        </g>
                                                                                        <g>
                                                                                            <path style="fill:#26264F;" d="M2120.693,1761.844c-0.989,0-1.978-0.379-2.729-1.134c-1.5-1.507-1.492-3.944,0.013-5.444					c0.323-0.323,32.453-32.838,32.295-76.205c-0.096-26.638-12.216-51.999-36.021-75.376					c-50.48-49.572-184.417-106.984-302.587-157.638c-72.126-30.917-140.253-60.12-184.99-85.299					c-10.147-5.712-20.878-11.134-31.901-16.116c-1.936-0.875-2.797-3.156-1.921-5.093c0.874-1.937,3.154-2.8,5.094-1.922					c11.226,5.075,22.162,10.6,32.504,16.422c44.376,24.976,112.317,54.099,184.246,84.932					c118.794,50.921,253.438,108.636,304.949,159.222c25.35,24.893,38.245,52.118,38.325,80.917					c0.132,46.619-33.151,80.21-34.568,81.617C2122.653,1761.472,2121.672,1761.844,2120.693,1761.844z"/>
                                                                                        </g>
                                                                                        <path style="fill:#FFFFFF;" d="M2714.723,2093.49l-469.248-457.563c-9.891-9.644-24.055-12.342-36.43-6.94l-22.302,9.736				c5.831,21.27,14.562,45.198,27.883,69.626c69.316,127.1,183.034,121.617,209.309,209.825				c23.285,78.173-54.822,120.112-65.118,229.808c-5.145,54.809,6.598,127.717,69.497,219.296l283.157-215.732				C2729.574,2137.754,2731.156,2109.514,2714.723,2093.49z"/>
                                                                                        <g>
                                                                                            <path style="fill:#D8DEE8;" d="M2293.656,1937.744c25.703,42.506,20.387,77.766-0.092,92.051					c-21.568,15.045-52.548,3.772-75.604-34.36c-21.925-36.254-23.087-74.55,1.094-91.419					C2243.453,1886.996,2272.677,1903.05,2293.656,1937.744z M2241.821,1977.012c12.854,21.254,27.124,33.073,36.711,26.386					c9.365-6.535,5.628-23.477-8.169-46.295c-12.474-20.628-26.036-33.832-36.275-26.689					C2224.283,1937.254,2229.539,1956.698,2241.821,1977.012z M2346.713,2113.596l-45.745-266.722l17.863-12.462l45.53,266.872					L2346.713,2113.596z M2446.642,1951.008c25.703,42.508,20.387,77.77-0.09,92.055c-21.35,14.894-52.329,3.618-75.606-34.361					c-21.925-36.258-23.087-74.551,1.096-91.421C2396.443,1900.261,2425.665,1916.314,2446.642,1951.008z M2395.025,1990.126					c12.635,21.406,26.906,33.227,36.493,26.54c9.367-6.535,5.626-23.48-8.171-46.296c-12.474-20.628-25.814-33.984-36.055-26.841					C2377.273,1950.519,2382.74,1969.81,2395.025,1990.126z"/>
                                                                                        </g>
                                                                                        <path style="fill:#D8DEE8;" d="M2356.543,2261.15c-6.286,0-12.421-3.422-15.923-9.616c-5.33-9.432-2.532-21.725,6.25-27.452				l225.974-147.338c8.783-5.72,20.227-2.715,25.56,6.713c5.331,9.433,2.532,21.725-6.25,27.453l-225.974,147.338				C2363.164,2260.213,2359.832,2261.15,2356.543,2261.15z"/>
                                                                                    </g>
                                                                                    <g>
                                                                                        <g>
                                                                                            <linearGradient id="SVGID_00000016059971617738243660000002113513692448563351_" gradientUnits="userSpaceOnUse" x1="495.4548" y1="2628.0298" x2="706.1257" y2="2661.8875">
                                                                                                <stop  offset="0" style="stop-color:#AA80F9"/>
                                                                                                <stop  offset="0.9964" style="stop-color:#6165D7"/>
                                                                                            </linearGradient>
                                                                                            <path style="fill:url(#SVGID_00000016059971617738243660000002113513692448563351_);" d="M2058.299,3112.728					c0,20.519-14.568,38.171-32.441,39.231l-1259.35,76.921c-23.858,1.414-50.789-18.771-50.789-42.623v-881.323					c0-23.852,27.579-43.906,51.437-42.917l1258.702,53.88c17.874,0.741,32.441,18.134,32.441,38.652V3112.728z"/>
                                                                                            <linearGradient id="SVGID_00000056390097449194454950000018358027588269747330_" gradientUnits="userSpaceOnUse" x1="1283.7112" y1="2622.6909" x2="2156.4919" y2="3664.7607">
                                                                                                <stop  offset="0" style="stop-color:#AA80F9"/>
                                                                                                <stop  offset="0.9964" style="stop-color:#6165D7"/>
                                                                                            </linearGradient>
                                                                                            <path style="fill:url(#SVGID_00000056390097449194454950000018358027588269747330_);" d="M2081.647,3114.167					c0,20.618-14.638,38.355-32.598,39.42l-1272.8,75.452c-23.973,1.421-43.677-17.02-43.677-40.987v-885.587					c0-23.967,19.703-42.759,43.677-41.765l1272.8,52.78c17.961,0.745,32.598,18.221,32.598,38.84V3114.167z"/>
                                                                                            <g>
                                                                                                <linearGradient id="SVGID_00000121966654792838778820000011286642214589885355_" gradientUnits="userSpaceOnUse" x1="1061.5411" y1="2913.1289" x2="2205.1848" y2="3274.28">
                                                                                                    <stop  offset="0" style="stop-color:#444B8C"/>
                                                                                                    <stop  offset="0.9964" style="stop-color:#26264F"/>
                                                                                                </linearGradient>
                                                                                                <polygon style="fill:url(#SVGID_00000121966654792838778820000011286642214589885355_);" points="2081.647,2906.557 						732.572,2975.767 732.572,3137.955 2081.647,3058.765 					"/>
                                                                                            </g>
                                                                                            <g>
                                                                                                <g style="opacity:0.15;">
                                                                                                    <linearGradient id="SVGID_00000150062377945526637290000013627850810082806932_" gradientUnits="userSpaceOnUse" x1="890.6346" y1="2653.5132" x2="1469.9413" y2="2653.5132" gradientTransform="matrix(0.9999 0.0151 -0.0151 0.9999 8.0381 -12.9012)">
                                                                                                        <stop  offset="0" style="stop-color:#FF9085"/>
                                                                                                        <stop  offset="1" style="stop-color:#FB6FBB"/>
                                                                                                    </linearGradient>
                                                                                                    <path style="fill:url(#SVGID_00000150062377945526637290000013627850810082806932_);" d="M1130.727,2553.551							c-1.523,100.644-64.471,152.947-134.552,152.678c-76.358-0.293-137.565-58.837-136.111-154.964							c1.383-91.4,58.961-156.514,144.514-150.123C1087.587,2407.343,1131.97,2471.409,1130.727,2553.551z M949.456,2551.621							c-0.794,52.503,16.385,90.664,49.948,91.286c32.303,0.599,48.406-32.312,49.239-87.393c0.754-49.8-12.02-89.083-47.294-91.199							C967.028,2462.256,950.216,2501.434,949.456,2551.621z M1020.314,2875.186l243.192-440.312							c4.651-8.421,13.782-13.36,23.376-12.643h0c17.836,1.332,28.339,20.645,19.763,36.341l-240.502,440.193							c-4.129,7.556-11.906,12.405-20.509,12.786l-2.69,0.119C1023.741,2912.52,1011.02,2892.012,1020.314,2875.186z							 M1436.427,2751.101c-1.411,93.214-55.443,144.217-115.398,146.85c-64.487,2.832-116.509-48.585-115.855-137.172							c1.275-84.249,50.357-146.871,123.356-144.911C1399.571,2617.776,1437.578,2675.021,1436.427,2751.101z M1281.968,2757.219							c-1.395,48.478,13.225,82.965,41.887,82.126c27.619-0.808,41.433-31.903,42.204-82.845							c0.697-46.057-9.557-81.778-39.708-82.145C1296.396,2673.99,1282.669,2710.892,1281.968,2757.219z"/>
                                                                                                </g>
                                                                                                <g>
                                                                                                    <path style="fill:#FFFFFF;" d="M1142.472,2548.865c-1.523,100.644-64.471,152.947-134.552,152.678							c-76.358-0.293-137.565-58.837-136.111-154.964c1.383-91.399,58.961-156.514,144.514-150.123							C1099.332,2402.656,1143.715,2466.723,1142.472,2548.865z M961.201,2546.934c-0.794,52.503,16.385,90.664,49.948,91.286							c32.303,0.598,48.406-32.312,49.239-87.393c0.754-49.8-12.02-89.083-47.294-91.199							C978.773,2457.569,961.961,2496.747,961.201,2546.934z M1032.059,2870.5l243.192-440.312							c4.651-8.421,13.782-13.36,23.376-12.643h0c17.837,1.333,28.339,20.645,19.763,36.341l-240.502,440.193							c-4.129,7.556-11.906,12.406-20.509,12.786l-2.69,0.119C1035.486,2907.834,1022.765,2887.325,1032.059,2870.5z							 M1448.172,2746.415c-1.411,93.214-55.443,144.217-115.398,146.85c-64.487,2.832-116.509-48.584-115.855-137.171							c1.275-84.249,50.357-146.871,123.356-144.911C1411.316,2613.089,1449.323,2670.335,1448.172,2746.415z M1293.713,2752.532							c-1.395,48.478,13.225,82.964,41.887,82.126c27.619-0.808,41.433-31.903,42.204-82.845							c0.697-46.057-9.557-81.778-39.708-82.145C1308.141,2669.304,1294.414,2706.206,1293.713,2752.532z"/>
                                                                                                </g>
                                                                                            </g>
                                                                                            <linearGradient id="SVGID_00000157286486579478903520000002427652383812749234_" gradientUnits="userSpaceOnUse" x1="1253.4344" y1="2116.3708" x2="2126.2156" y2="3158.4412">
                                                                                                <stop  offset="0" style="stop-color:#AA80F9"/>
                                                                                                <stop  offset="0.9964" style="stop-color:#6165D7"/>
                                                                                            </linearGradient>
                                                                                            <path style="opacity:0.3;fill:url(#SVGID_00000157286486579478903520000002427652383812749234_);" d="M2049.049,2313.48					l-1258.14-52.173c56.786,168.164,138.111,243.492,207.954,280.363c132.979,70.201,228.352,3.161,342.341,94.05					c116.942,93.243,72.434,208.35,195.623,285.911c92.588,58.294,152.268,15.017,248.291,67.716					c71.123,39.033,115.552,105.133,143.976,171.351l119.955-7.111c17.961-1.065,32.599-18.802,32.599-39.42V2352.32					C2081.647,2331.701,2067.009,2314.225,2049.049,2313.48z"/>
                                                                                            <linearGradient id="SVGID_00000013895052222242535260000001825002748045151919_" gradientUnits="userSpaceOnUse" x1="1512.6396" y1="2936.1892" x2="2081.6472" y2="2936.1892">
                                                                                                <stop  offset="0" style="stop-color:#AA80F9"/>
                                                                                                <stop  offset="0.9964" style="stop-color:#6165D7"/>
                                                                                            </linearGradient>
                                                                                            <path style="opacity:0.3;fill:url(#SVGID_00000013895052222242535260000001825002748045151919_);" d="M2063.925,2716.529					l-30.699-29.129l-29.129,30.699l-30.699-29.129l-29.129,30.699l-30.699-29.129l-29.129,30.698l-30.699-29.129l-29.129,30.698					l-30.698-29.129l-29.129,30.699l-30.699-29.129l-29.129,30.698l-30.699-29.129l-29.129,30.698l-30.699-29.129l-29.129,30.698					l-39.225-37.219c0,14.859,0,459.846,0,459.846s-1.604,26.337-33.441,33.265l542.943-39.804c6.196-0.461,12-2.202,17.211-4.905					c5.472-7.038,8.854-16.228,8.854-26.102v-416.316L2063.925,2716.529z"/>
                                                                                        </g>
                                                                                        <g>
                                                                                            <path style="fill:#FFFFFF;" d="M2151.207,2701.277v418.886c0,23.375-18.616,42.793-41.917,44.513l-172.167,12.612					l-372.006,27.203c31.845-6.935,32.529-33.269,32.529-33.269s0-444.98,0-459.848l40.002,37.226l20.954-21.674l8.757-9.025					l30.796,29.126l29.175-30.698l30.723,29.126l29.139-30.698l30.705,29.126l29.13-30.698l30.7,29.127l29.127-30.699l30.698,29.127					l29.146-30.698l30.699,29.126l29.127-30.698l30.699,29.145l29.126-30.717l31.284,29.145L2151.207,2701.277z"/>
                                                                                            <g>
                                                                                                <path style="fill:#D8DEE8;" d="M2088.529,2944.552l-67.144,3.027c-4.516,0.204-8.073,3.924-8.073,8.445v30.816						c0,4.856,4.081,8.713,8.929,8.44l67.144-3.785c4.477-0.252,7.978-3.956,7.978-8.44v-30.059						C2097.363,2948.179,2093.342,2944.335,2088.529,2944.552z"/>
                                                                                                <path style="fill:#D8DEE8;" d="M2088.434,3004.111l-67.144,3.785c-4.477,0.252-7.978,3.956-7.978,8.44v32.179						c0,4.881,4.122,8.748,8.992,8.437l67.144-4.286c4.451-0.284,7.915-3.977,7.915-8.436v-31.677						C2097.363,3007.696,2093.282,3003.838,2088.434,3004.111z"/>
                                                                                                <path style="fill:#D8DEE8;" d="M2097.363,2859.135v-55.14c0-4.788-3.973-8.62-8.758-8.448l-67.144,2.417						c-4.547,0.164-8.15,3.897-8.15,8.448v55.751c0,4.818,4.021,8.662,8.835,8.445l67.144-3.028						C2093.806,2867.376,2097.363,2863.656,2097.363,2859.135z"/>
                                                                                            </g>
                                                                                            <g>
                                                                                                <path style="fill:#D8DEE8;" d="M1949.024,2950.843l-273.4,12.327c-4.516,0.204-8.073,3.924-8.073,8.445v34.715						c0,4.856,4.082,8.714,8.929,8.44l273.4-15.411c4.477-0.252,7.978-3.956,7.978-8.44v-31.632						C1957.858,2954.47,1953.837,2950.626,1949.024,2950.843z"/>
                                                                                                <path style="fill:#D8DEE8;" d="M1948.929,3011.975l-273.4,15.411c-4.477,0.252-7.978,3.956-7.978,8.44v34.761						c0,4.881,4.122,8.748,8.992,8.437l273.4-17.453c4.451-0.284,7.915-3.977,7.915-8.436v-32.72						C1957.858,3015.559,1953.777,3011.701,1948.929,3011.975z"/>
                                                                                                <path style="fill:#D8DEE8;" d="M1957.858,2865.425v-56.408c0-4.788-3.973-8.62-8.758-8.448l-273.4,9.843						c-4.547,0.164-8.15,3.897-8.15,8.448v58.893c0,4.818,4.021,8.662,8.835,8.445l273.4-12.327						C1954.301,2873.667,1957.858,2869.946,1957.858,2865.425z"/>
                                                                                            </g>
                                                                                            <path style="opacity:0.4;fill:#F4F7FA;" d="M1936.829,3177.288l-371.86,27.203c31.845-6.935,32.676-33.269,32.676-33.269					s0-444.98,0-459.848l40.002,37.226l20.954-21.674c17.476,15.812,31.523,41.202,35.424,81.443					c13,133.964,75.752,125.142,149.835,130.173c74.083,5.03,108.178,90.764,78.201,157.006					C1908.653,3125.174,1914.12,3155.041,1936.829,3177.288z"/>
                                                                                        </g>
                                                                                    </g>
                                                                                    <g>
                                                                                        <g>
                                                                                            <linearGradient id="SVGID_00000061439316412596167710000007143002482892911752_" gradientUnits="userSpaceOnUse" x1="655.8616" y1="3236.5471" x2="1225.4637" y2="3236.5471">
                                                                                                <stop  offset="0" style="stop-color:#FCB148"/>
                                                                                                <stop  offset="0.0521" style="stop-color:#FDBA46"/>
                                                                                                <stop  offset="0.1424" style="stop-color:#FFC244"/>
                                                                                                <stop  offset="0.3183" style="stop-color:#FFC444"/>
                                                                                                <stop  offset="0.4849" style="stop-color:#FDB946"/>
                                                                                                <stop  offset="0.7754" style="stop-color:#F99C4D"/>
                                                                                                <stop  offset="0.8658" style="stop-color:#F8924F"/>
                                                                                                <stop  offset="1" style="stop-color:#F8924F"/>
                                                                                            </linearGradient>
                                                                                            <path style="fill:url(#SVGID_00000061439316412596167710000007143002482892911752_);" d="M698.188,3193.029v54.909					c0,17.743,110.836,32.126,247.558,32.126s247.558-14.383,247.558-32.126v-54.909H698.188z"/>
                                                                                            <linearGradient id="SVGID_00000072238700320149582040000015684962927541906860_" gradientUnits="userSpaceOnUse" x1="943.2804" y1="3172.3835" x2="973.3092" y2="3423.7686">
                                                                                                <stop  offset="0" style="stop-color:#FFDB44"/>
                                                                                                <stop  offset="1" style="stop-color:#FEEF06"/>
                                                                                            </linearGradient>
                                                                                            <path style="fill:url(#SVGID_00000072238700320149582040000015684962927541906860_);" d="M1193.305,3193.029					c0,17.743-110.836,32.126-247.558,32.126s-247.558-14.384-247.558-32.126c0-17.743,110.836-32.126,247.558-32.126					S1193.305,3175.286,1193.305,3193.029z"/>
                                                                                            <linearGradient id="SVGID_00000080165106217758237930000003950656354167352716_" gradientUnits="userSpaceOnUse" x1="941.9747" y1="3161.1729" x2="951.197" y2="3238.3774">
                                                                                                <stop  offset="0" style="stop-color:#FFDB44"/>
                                                                                                <stop  offset="1" style="stop-color:#FEEF06"/>
                                                                                            </linearGradient>
                                                                                            <path style="fill:url(#SVGID_00000080165106217758237930000003950656354167352716_);" d="M945.745,3227.371					c-121.085,0-247.701-11.566-247.701-33.873c0-1.225,0.437-3.378,1.662-3.378c1.225,0,0.698,1.684,0.698,2.909					c0,14.147,100.759,29.908,245.341,29.908c144.583,0,245.342-15.761,245.342-29.908c0-1.225,0.209-2.373,1.434-2.373					s0.929,1.635,0.929,2.86C1193.451,3215.823,1066.831,3227.371,945.745,3227.371z"/>
                                                                                            <g>
                                                                                                <path style="fill:#FCB048;" d="M922.353,3194.819c2.429-1.681,5.014-3.339,7.781-4.976c2.74-1.635,6.311-3.113,10.635-4.433						c4.349-1.321,9.789-2.394,16.319-3.228c6.53-0.833,14.695-1.272,24.444-1.32c9.567-0.047,18.541,0.257,26.945,0.912						c8.378,0.653,15.772,1.632,22.157,2.934c6.359,1.302,11.552,2.912,15.555,4.826c3.977,1.919,6.347,4.115,7.111,6.591						l27.874,0.282c2.023,0.013,3.812,0.177,5.344,0.495c1.557,0.318,2.311,0.719,2.313,1.205l0.011,2.296l-35.835-0.345						c-1.257,2.811-4.459,5.382-9.608,7.714c-5.122,2.335-11.673,4.353-19.65,6.062l-13.051-1.814						c-1.168-0.178-2.129-0.406-2.882-0.683c-0.753-0.274-1.117-0.572-1.119-0.897c-0.002-0.441,1.006-0.944,3.026-1.51						c2.019-0.567,4.298-1.269,6.834-2.104c2.537-0.833,5.022-1.82,7.479-2.958c2.432-1.135,4.059-2.493,4.906-4.074l-84.583-0.838						c-2.222,1.635-4.729,3.24-7.47,4.819c-2.767,1.578-6.416,3-10.973,4.262c-4.557,1.263-10.23,2.286-17.02,3.076						c-6.816,0.786-15.344,1.204-25.663,1.255c-7.753,0.038-15.299-0.256-22.692-0.879c-7.393-0.626-13.957-1.561-19.693-2.807						c-5.737-1.248-10.437-2.791-14.128-4.626c-3.665-1.839-5.724-3.948-6.15-6.335l-22.948-0.236						c-2.023-0.012-3.812-0.171-5.422-0.476c-1.583-0.307-2.389-0.713-2.391-1.223l-0.011-2.295l31.375,0.299						c1.388-2.418,4.23-4.526,8.577-6.319c4.347-1.796,9.655-3.393,15.923-4.79l10.508,1.443c3.192,0.448,4.776,0.972,4.779,1.575						c0.001,0.325-0.645,0.728-1.965,1.209c-1.346,0.482-2.899,1.059-4.711,1.727c-1.786,0.671-3.545,1.455-5.226,2.358						c-1.707,0.9-2.973,1.919-3.822,3.061L922.353,3194.819z M844.945,3197.947c0.63,1.506,2.036,2.801,4.168,3.891						c2.131,1.094,4.781,1.989,7.973,2.692c3.193,0.704,6.774,1.218,10.742,1.546c3.995,0.329,8.17,0.484,12.526,0.462						c5.082-0.025,9.515-0.244,13.298-0.657c3.758-0.414,7.073-0.974,9.948-1.685c2.849-0.71,5.36-1.531,7.482-2.47						c2.121-0.939,4.009-1.956,5.715-3.053L844.945,3197.947z M1029.081,3195.895c-0.63-1.525-2.167-2.862-4.557-4.01						c-2.392-1.146-5.456-2.113-9.167-2.893c-3.712-0.783-8.045-1.364-12.999-1.745c-4.928-0.381-10.374-0.558-16.337-0.528						c-5.289,0.026-9.878,0.264-13.687,0.71c-3.81,0.449-7.125,1.048-9.948,1.806c-2.797,0.755-5.204,1.636-7.143,2.642						c-1.966,1.006-3.802,2.082-5.482,3.228L1029.081,3195.895z"/>
                                                                                            </g>
                                                                                            <linearGradient id="SVGID_00000173862680973020768310000006391407487995543988_" gradientUnits="userSpaceOnUse" x1="718.6047" y1="897.5552" x2="727.7944" y2="974.4861" gradientTransform="matrix(-1 0 0 -1 1669.249 4127.8389)">
                                                                                                <stop  offset="0.0036" style="stop-color:#F36F56"/>
                                                                                                <stop  offset="0.3059" style="stop-color:#F99C4C"/>
                                                                                                <stop  offset="0.545" style="stop-color:#FDB946"/>
                                                                                                <stop  offset="0.6817" style="stop-color:#FFC444"/>
                                                                                                <stop  offset="0.8038" style="stop-color:#FFC244"/>
                                                                                                <stop  offset="0.8667" style="stop-color:#FEBA46"/>
                                                                                                <stop  offset="0.916" style="stop-color:#FCAD49"/>
                                                                                                <stop  offset="0.958" style="stop-color:#F99A4D"/>
                                                                                                <stop  offset="0.9955" style="stop-color:#F58152"/>
                                                                                                <stop  offset="1" style="stop-color:#F57E53"/>
                                                                                            </linearGradient>
                                                                                            <path style="fill:url(#SVGID_00000173862680973020768310000006391407487995543988_);" d="M945.78,3164.381					c-110.382,0-225.314,9.712-243.698,28.516c0.719,0.663,1.388,1.371,2.009,2.115c15.495-13.055,110.397-26.199,241.689-26.199					c134.662,0,231.085,13.829,242.765,27.206c0.574-0.734,1.188-1.436,1.851-2.098					C1175.212,3174.452,1058.123,3164.381,945.78,3164.381z"/>
                                                                                        </g>
                                                                                        <g>
                                                                                            <linearGradient id="SVGID_00000077313324402105505420000004417403867310632096_" gradientUnits="userSpaceOnUse" x1="587.0421" y1="3178.8711" x2="1156.6436" y2="3178.8711">
                                                                                                <stop  offset="0" style="stop-color:#FCB148"/>
                                                                                                <stop  offset="0.0521" style="stop-color:#FDBA46"/>
                                                                                                <stop  offset="0.1424" style="stop-color:#FFC244"/>
                                                                                                <stop  offset="0.3183" style="stop-color:#FFC444"/>
                                                                                                <stop  offset="0.4849" style="stop-color:#FDB946"/>
                                                                                                <stop  offset="0.7754" style="stop-color:#F99C4D"/>
                                                                                                <stop  offset="0.8658" style="stop-color:#F8924F"/>
                                                                                                <stop  offset="1" style="stop-color:#F8924F"/>
                                                                                            </linearGradient>
                                                                                            <path style="fill:url(#SVGID_00000077313324402105505420000004417403867310632096_);" d="M629.369,3135.353v54.91					c0,17.744,110.836,32.126,247.558,32.126c136.722,0,247.558-14.383,247.558-32.126v-54.91H629.369z"/>
                                                                                            <linearGradient id="SVGID_00000094616692102711221830000013679852982694630548_" gradientUnits="userSpaceOnUse" x1="874.4606" y1="3114.708" x2="904.4893" y2="3366.0925">
                                                                                                <stop  offset="0" style="stop-color:#FFDB44"/>
                                                                                                <stop  offset="1" style="stop-color:#FEEF06"/>
                                                                                            </linearGradient>
                                                                                            <path style="fill:url(#SVGID_00000094616692102711221830000013679852982694630548_);" d="M1124.485,3135.353					c0,17.743-110.835,32.126-247.558,32.126c-136.723,0-247.558-14.383-247.558-32.126c0-17.742,110.836-32.126,247.558-32.126					C1013.649,3103.227,1124.485,3117.611,1124.485,3135.353z"/>
                                                                                            <linearGradient id="SVGID_00000111893949361923410100000016399172990182689921_" gradientUnits="userSpaceOnUse" x1="873.155" y1="3103.4973" x2="882.3773" y2="3180.7014">
                                                                                                <stop  offset="0" style="stop-color:#FFDB44"/>
                                                                                                <stop  offset="1" style="stop-color:#FEEF06"/>
                                                                                            </linearGradient>
                                                                                            <path style="fill:url(#SVGID_00000111893949361923410100000016399172990182689921_);" d="M876.926,3169.695					c-121.085,0-247.701-11.565-247.701-33.872c0-1.225,0.437-3.378,1.662-3.378c1.225,0,0.698,1.684,0.698,2.908					c0,14.148,100.758,29.909,245.341,29.909s245.342-15.761,245.342-29.909c0-1.225,0.209-2.372,1.434-2.372					c1.225,0,0.93,1.635,0.93,2.86C1124.631,3158.147,998.011,3169.695,876.926,3169.695z"/>
                                                                                            <g>
                                                                                                <path style="fill:#FCB048;" d="M853.534,3137.144c2.429-1.682,5.014-3.339,7.78-4.977c2.74-1.636,6.311-3.113,10.635-4.434						c4.35-1.32,9.79-2.394,16.319-3.227c6.53-0.833,14.695-1.272,24.444-1.32c9.568-0.047,18.541,0.258,26.945,0.912						c8.378,0.653,15.773,1.633,22.157,2.934c6.359,1.302,11.553,2.912,15.555,4.825c3.977,1.92,6.347,4.115,7.111,6.591						l27.874,0.282c2.023,0.012,3.813,0.176,5.344,0.494c1.558,0.318,2.311,0.719,2.313,1.206l0.011,2.295l-35.835-0.345						c-1.257,2.811-4.459,5.382-9.608,7.714c-5.122,2.334-11.672,4.353-19.65,6.062l-13.051-1.815						c-1.168-0.178-2.128-0.405-2.881-0.682c-0.754-0.274-1.118-0.572-1.12-0.897c-0.002-0.442,1.007-0.944,3.026-1.509						c2.02-0.568,4.298-1.27,6.835-2.105c2.537-0.833,5.021-1.819,7.479-2.957c2.432-1.136,4.059-2.493,4.906-4.074l-84.583-0.839						c-2.222,1.635-4.729,3.241-7.47,4.82c-2.767,1.578-6.415,3-10.972,4.262c-4.557,1.261-10.231,2.286-17.021,3.074						c-6.815,0.786-15.344,1.204-25.663,1.255c-7.752,0.038-15.3-0.256-22.692-0.879c-7.392-0.626-13.957-1.561-19.693-2.807						c-5.736-1.248-10.437-2.791-14.128-4.626c-3.665-1.838-5.724-3.948-6.15-6.334l-22.948-0.236						c-2.022-0.013-3.812-0.171-5.422-0.477c-1.583-0.306-2.389-0.713-2.391-1.222l-0.011-2.295l31.376,0.299						c1.388-2.418,4.23-4.526,8.577-6.319c4.347-1.796,9.655-3.393,15.923-4.79l10.508,1.443c3.191,0.448,4.775,0.973,4.779,1.575						c0.002,0.326-0.645,0.728-1.965,1.21c-1.346,0.481-2.898,1.058-4.711,1.727c-1.786,0.671-3.545,1.455-5.226,2.358						c-1.707,0.9-2.972,1.919-3.822,3.061L853.534,3137.144z M776.126,3140.272c0.63,1.505,2.036,2.8,4.168,3.89						c2.132,1.093,4.781,1.989,7.974,2.692c3.193,0.703,6.774,1.218,10.742,1.547c3.995,0.328,8.17,0.483,12.525,0.462						c5.082-0.025,9.515-0.245,13.298-0.657c3.758-0.414,7.074-0.974,9.949-1.684c2.849-0.71,5.359-1.533,7.481-2.471						c2.122-0.939,4.009-1.955,5.716-3.053L776.126,3140.272z M960.261,3138.219c-0.63-1.526-2.166-2.862-4.557-4.01						c-2.391-1.146-5.455-2.113-9.167-2.894c-3.711-0.783-8.044-1.364-12.998-1.744c-4.929-0.381-10.375-0.558-16.338-0.529						c-5.29,0.026-9.878,0.263-13.687,0.71c-3.809,0.449-7.125,1.048-9.948,1.806c-2.796,0.755-5.204,1.636-7.143,2.642						c-1.966,1.006-3.802,2.082-5.481,3.228L960.261,3138.219z"/>
                                                                                            </g>
                                                                                            <linearGradient id="SVGID_00000083800476736383650330000017906260112769925270_" gradientUnits="userSpaceOnUse" x1="787.4249" y1="955.2313" x2="796.6145" y2="1032.1619" gradientTransform="matrix(-1 0 0 -1 1669.249 4127.8389)">
                                                                                                <stop  offset="0.0036" style="stop-color:#F36F56"/>
                                                                                                <stop  offset="0.3059" style="stop-color:#F99C4C"/>
                                                                                                <stop  offset="0.545" style="stop-color:#FDB946"/>
                                                                                                <stop  offset="0.6817" style="stop-color:#FFC444"/>
                                                                                                <stop  offset="0.8038" style="stop-color:#FFC244"/>
                                                                                                <stop  offset="0.8667" style="stop-color:#FEBA46"/>
                                                                                                <stop  offset="0.916" style="stop-color:#FCAD49"/>
                                                                                                <stop  offset="0.958" style="stop-color:#F99A4D"/>
                                                                                                <stop  offset="0.9955" style="stop-color:#F58152"/>
                                                                                                <stop  offset="1" style="stop-color:#F57E53"/>
                                                                                            </linearGradient>
                                                                                            <path style="fill:url(#SVGID_00000083800476736383650330000017906260112769925270_);" d="M876.96,3106.705					c-110.382,0-225.314,9.713-243.698,28.516c0.719,0.663,1.388,1.371,2.009,2.116c15.496-13.055,110.398-26.199,241.688-26.199					c134.662,0,231.085,13.829,242.765,27.205c0.574-0.734,1.187-1.436,1.851-2.097					C1106.392,3116.777,989.303,3106.705,876.96,3106.705z"/>
                                                                                        </g>
                                                                                        <g>
                                                                                            <linearGradient id="SVGID_00000115510739442470760460000012682953662306249401_" gradientUnits="userSpaceOnUse" x1="646.4239" y1="3121.3643" x2="1216.0259" y2="3121.3643">
                                                                                                <stop  offset="0" style="stop-color:#FCB148"/>
                                                                                                <stop  offset="0.0521" style="stop-color:#FDBA46"/>
                                                                                                <stop  offset="0.1424" style="stop-color:#FFC244"/>
                                                                                                <stop  offset="0.3183" style="stop-color:#FFC444"/>
                                                                                                <stop  offset="0.4849" style="stop-color:#FDB946"/>
                                                                                                <stop  offset="0.7754" style="stop-color:#F99C4D"/>
                                                                                                <stop  offset="0.8658" style="stop-color:#F8924F"/>
                                                                                                <stop  offset="1" style="stop-color:#F8924F"/>
                                                                                            </linearGradient>
                                                                                            <path style="fill:url(#SVGID_00000115510739442470760460000012682953662306249401_);" d="M688.75,3077.846v54.909					c0,17.744,110.836,32.126,247.559,32.126c136.722,0,247.558-14.383,247.558-32.126v-54.909H688.75z"/>
                                                                                            <linearGradient id="SVGID_00000032611704423358048340000013514972650171014805_" gradientUnits="userSpaceOnUse" x1="933.8427" y1="3057.2012" x2="963.8714" y2="3308.5859">
                                                                                                <stop  offset="0" style="stop-color:#FFDB44"/>
                                                                                                <stop  offset="1" style="stop-color:#FEEF06"/>
                                                                                            </linearGradient>
                                                                                            <path style="fill:url(#SVGID_00000032611704423358048340000013514972650171014805_);" d="M1183.867,3077.846					c0,17.743-110.835,32.126-247.558,32.126c-136.723,0-247.559-14.383-247.559-32.126c0-17.743,110.836-32.126,247.559-32.126					C1073.032,3045.72,1183.867,3060.104,1183.867,3077.846z"/>
                                                                                            <linearGradient id="SVGID_00000121997649531009294800000013654370370984873130_" gradientUnits="userSpaceOnUse" x1="932.5372" y1="3045.9905" x2="941.7595" y2="3123.1946">
                                                                                                <stop  offset="0" style="stop-color:#FFDB44"/>
                                                                                                <stop  offset="1" style="stop-color:#FEEF06"/>
                                                                                            </linearGradient>
                                                                                            <path style="fill:url(#SVGID_00000121997649531009294800000013654370370984873130_);" d="M936.308,3112.188					c-121.085,0-247.702-11.565-247.702-33.872c0-1.225,0.437-3.378,1.662-3.378c1.225,0,0.698,1.684,0.698,2.909					c0,14.147,100.758,29.909,245.342,29.909s245.341-15.762,245.341-29.909c0-1.225,0.209-2.373,1.434-2.373					c1.225,0,0.93,1.635,0.93,2.86C1184.014,3100.641,1057.394,3112.188,936.308,3112.188z"/>
                                                                                            <g>
                                                                                                <path style="fill:#FCB048;" d="M912.916,3079.637c2.429-1.681,5.013-3.339,7.78-4.977c2.741-1.635,6.311-3.113,10.635-4.434						c4.35-1.32,9.789-2.394,16.319-3.227c6.53-0.833,14.695-1.272,24.444-1.32c9.568-0.047,18.541,0.258,26.945,0.912						c8.378,0.652,15.773,1.633,22.157,2.934c6.359,1.302,11.553,2.913,15.555,4.825c3.976,1.92,6.347,4.115,7.11,6.591						l27.874,0.282c2.023,0.012,3.813,0.177,5.344,0.494c1.557,0.318,2.311,0.719,2.313,1.206l0.011,2.295l-35.835-0.345						c-1.257,2.811-4.459,5.382-9.608,7.714c-5.122,2.335-11.672,4.353-19.65,6.062l-13.051-1.815						c-1.167-0.178-2.128-0.405-2.881-0.682c-0.754-0.274-1.118-0.572-1.12-0.897c-0.002-0.442,1.007-0.945,3.026-1.509						c2.02-0.568,4.298-1.27,6.835-2.105c2.537-0.833,5.021-1.819,7.478-2.958c2.432-1.136,4.059-2.493,4.907-4.074l-84.583-0.839						c-2.222,1.635-4.729,3.241-7.47,4.82c-2.766,1.578-6.415,3-10.972,4.262c-4.557,1.262-10.231,2.286-17.02,3.074						c-6.815,0.787-15.344,1.204-25.663,1.255c-7.753,0.038-15.3-0.256-22.693-0.879c-7.392-0.626-13.957-1.562-19.693-2.807						c-5.736-1.248-10.437-2.791-14.128-4.626c-3.665-1.838-5.724-3.948-6.151-6.334l-22.948-0.236						c-2.023-0.012-3.813-0.171-5.422-0.477c-1.583-0.306-2.389-0.712-2.391-1.222l-0.011-2.295l31.376,0.299						c1.388-2.418,4.23-4.527,8.577-6.319c4.346-1.796,9.655-3.393,15.922-4.79l10.508,1.443c3.191,0.448,4.775,0.972,4.779,1.575						c0.001,0.326-0.645,0.728-1.965,1.21c-1.346,0.482-2.899,1.058-4.711,1.727c-1.786,0.671-3.545,1.455-5.226,2.358						c-1.707,0.9-2.972,1.919-3.822,3.061L912.916,3079.637z M835.508,3082.765c0.63,1.505,2.036,2.8,4.168,3.891						c2.131,1.093,4.78,1.989,7.973,2.692c3.193,0.703,6.774,1.218,10.742,1.547c3.995,0.328,8.17,0.483,12.526,0.462						c5.082-0.025,9.515-0.245,13.298-0.657c3.758-0.414,7.073-0.974,9.949-1.684c2.849-0.71,5.36-1.533,7.481-2.471						c2.121-0.939,4.009-1.956,5.715-3.053L835.508,3082.765z M1019.643,3080.713c-0.629-1.526-2.166-2.862-4.557-4.01						c-2.391-1.146-5.456-2.113-9.167-2.893c-3.712-0.783-8.044-1.365-12.999-1.745c-4.929-0.381-10.375-0.558-16.337-0.529						c-5.29,0.026-9.878,0.264-13.687,0.71c-3.809,0.449-7.125,1.048-9.948,1.807c-2.796,0.755-5.204,1.636-7.143,2.642						c-1.966,1.006-3.802,2.081-5.481,3.227L1019.643,3080.713z"/>
                                                                                            </g>
                                                                                            <linearGradient id="SVGID_00000109011037649279526160000013841415761415056264_" gradientUnits="userSpaceOnUse" x1="728.0426" y1="1012.7383" x2="737.2322" y2="1089.6689" gradientTransform="matrix(-1 0 0 -1 1669.249 4127.8389)">
                                                                                                <stop  offset="0.0036" style="stop-color:#F36F56"/>
                                                                                                <stop  offset="0.3059" style="stop-color:#F99C4C"/>
                                                                                                <stop  offset="0.545" style="stop-color:#FDB946"/>
                                                                                                <stop  offset="0.6817" style="stop-color:#FFC444"/>
                                                                                                <stop  offset="0.8038" style="stop-color:#FFC244"/>
                                                                                                <stop  offset="0.8667" style="stop-color:#FEBA46"/>
                                                                                                <stop  offset="0.916" style="stop-color:#FCAD49"/>
                                                                                                <stop  offset="0.958" style="stop-color:#F99A4D"/>
                                                                                                <stop  offset="0.9955" style="stop-color:#F58152"/>
                                                                                                <stop  offset="1" style="stop-color:#F57E53"/>
                                                                                            </linearGradient>
                                                                                            <path style="fill:url(#SVGID_00000109011037649279526160000013841415761415056264_);" d="M936.342,3049.198					c-110.382,0-225.314,9.713-243.698,28.516c0.719,0.663,1.388,1.371,2.009,2.116c15.495-13.056,110.397-26.199,241.688-26.199					c134.662,0,231.085,13.829,242.765,27.205c0.574-0.734,1.187-1.436,1.851-2.098					C1165.774,3059.27,1048.685,3049.198,936.342,3049.198z"/>
                                                                                        </g>
                                                                                        <g>
                                                                                            <linearGradient id="SVGID_00000084507457479451286880000001031826169192330914_" gradientUnits="userSpaceOnUse" x1="682.4593" y1="3063.689" x2="1252.0608" y2="3063.689">
                                                                                                <stop  offset="0" style="stop-color:#FCB148"/>
                                                                                                <stop  offset="0.0521" style="stop-color:#FDBA46"/>
                                                                                                <stop  offset="0.1424" style="stop-color:#FFC244"/>
                                                                                                <stop  offset="0.3183" style="stop-color:#FFC444"/>
                                                                                                <stop  offset="0.4849" style="stop-color:#FDB946"/>
                                                                                                <stop  offset="0.7754" style="stop-color:#F99C4D"/>
                                                                                                <stop  offset="0.8658" style="stop-color:#F8924F"/>
                                                                                                <stop  offset="1" style="stop-color:#F8924F"/>
                                                                                            </linearGradient>
                                                                                            <path style="fill:url(#SVGID_00000084507457479451286880000001031826169192330914_);" d="M724.786,3020.171v54.909					c0,17.744,110.835,32.126,247.558,32.126c136.722,0,247.558-14.383,247.558-32.126v-54.909H724.786z"/>
                                                                                            <linearGradient id="SVGID_00000005232914669788167250000015445253018318116256_" gradientUnits="userSpaceOnUse" x1="969.8777" y1="2999.5251" x2="999.9066" y2="3250.9102">
                                                                                                <stop  offset="0" style="stop-color:#FFDB44"/>
                                                                                                <stop  offset="1" style="stop-color:#FEEF06"/>
                                                                                            </linearGradient>
                                                                                            <ellipse style="fill:url(#SVGID_00000005232914669788167250000015445253018318116256_);" cx="972.344" cy="3020.171" rx="247.558" ry="32.126"/>
                                                                                            <linearGradient id="SVGID_00000101068875503576613590000012735528939646050969_" gradientUnits="userSpaceOnUse" x1="968.5717" y1="2988.3145" x2="977.794" y2="3065.519">
                                                                                                <stop  offset="0" style="stop-color:#FFDB44"/>
                                                                                                <stop  offset="1" style="stop-color:#FEEF06"/>
                                                                                            </linearGradient>
                                                                                            <path style="fill:url(#SVGID_00000101068875503576613590000012735528939646050969_);" d="M972.343,3054.512					c-121.085,0-247.702-11.565-247.702-33.872c0-1.225,0.437-3.379,1.662-3.379c1.225,0,0.698,1.684,0.698,2.91					c0,14.146,100.758,29.908,245.341,29.908c144.583,0,245.342-15.761,245.342-29.908c0-1.225,0.209-2.374,1.434-2.374					s0.929,1.635,0.929,2.86C1220.048,3042.965,1093.428,3054.512,972.343,3054.512z"/>
                                                                                            <g>
                                                                                                <path style="fill:#FCB048;" d="M948.95,3021.961c2.429-1.682,5.014-3.339,7.78-4.977c2.741-1.635,6.312-3.113,10.635-4.433						c4.35-1.321,9.79-2.394,16.319-3.227c6.53-0.833,14.696-1.272,24.444-1.32c9.567-0.047,18.541,0.257,26.945,0.912						c8.379,0.653,15.772,1.633,22.157,2.934c6.359,1.302,11.552,2.913,15.555,4.826c3.977,1.919,6.347,4.115,7.111,6.591						l27.875,0.282c2.023,0.014,3.813,0.177,5.344,0.495c1.557,0.318,2.311,0.719,2.313,1.205l0.011,2.296l-35.835-0.345						c-1.257,2.811-4.459,5.383-9.608,7.714c-5.122,2.334-11.673,4.353-19.65,6.063l-13.051-1.816						c-1.168-0.178-2.129-0.406-2.882-0.682c-0.753-0.274-1.117-0.572-1.119-0.897c-0.002-0.441,1.007-0.944,3.026-1.509						c2.02-0.568,4.298-1.27,6.834-2.106c2.537-0.833,5.021-1.818,7.479-2.958c2.432-1.135,4.059-2.493,4.906-4.074l-84.583-0.839						c-2.222,1.635-4.729,3.241-7.47,4.819c-2.767,1.579-6.415,3-10.973,4.262c-4.557,1.262-10.23,2.286-17.02,3.075						c-6.815,0.786-15.344,1.205-25.664,1.255c-7.752,0.038-15.299-0.257-22.692-0.879c-7.393-0.626-13.957-1.562-19.694-2.807						c-5.736-1.249-10.436-2.791-14.127-4.626c-3.665-1.839-5.724-3.948-6.15-6.335l-22.948-0.235						c-2.022-0.013-3.812-0.171-5.421-0.477c-1.583-0.306-2.389-0.713-2.392-1.223l-0.011-2.295l31.375,0.299						c1.388-2.418,4.231-4.527,8.578-6.32c4.347-1.795,9.655-3.392,15.923-4.79l10.508,1.443c3.192,0.448,4.776,0.973,4.779,1.575						c0.002,0.325-0.645,0.728-1.965,1.21c-1.346,0.482-2.899,1.059-4.711,1.727c-1.786,0.671-3.545,1.456-5.226,2.358						c-1.707,0.9-2.972,1.919-3.822,3.061L948.95,3021.961z M871.542,3025.089c0.63,1.505,2.036,2.8,4.168,3.89						c2.132,1.094,4.781,1.989,7.973,2.692c3.193,0.703,6.774,1.218,10.743,1.546c3.994,0.329,8.169,0.484,12.525,0.463						c5.082-0.025,9.514-0.245,13.298-0.657c3.758-0.415,7.074-0.974,9.949-1.684c2.848-0.71,5.36-1.532,7.481-2.471						c2.121-0.939,4.009-1.956,5.715-3.053L871.542,3025.089z M1055.678,3023.037c-0.63-1.525-2.166-2.862-4.557-4.011						c-2.391-1.146-5.455-2.113-9.167-2.893c-3.712-0.782-8.045-1.364-12.999-1.744c-4.928-0.381-10.374-0.558-16.338-0.529						c-5.289,0.026-9.877,0.263-13.687,0.71c-3.81,0.449-7.126,1.048-9.948,1.806c-2.797,0.755-5.204,1.635-7.143,2.642						c-1.966,1.006-3.802,2.082-5.481,3.228L1055.678,3023.037z"/>
                                                                                            </g>
                                                                                            <linearGradient id="SVGID_00000126308377105168115760000003800015295754250943_" gradientUnits="userSpaceOnUse" x1="692.0081" y1="1070.4138" x2="701.1977" y2="1147.3445" gradientTransform="matrix(-1 0 0 -1 1669.249 4127.8389)">
                                                                                                <stop  offset="0.0036" style="stop-color:#F36F56"/>
                                                                                                <stop  offset="0.3059" style="stop-color:#F99C4C"/>
                                                                                                <stop  offset="0.545" style="stop-color:#FDB946"/>
                                                                                                <stop  offset="0.6817" style="stop-color:#FFC444"/>
                                                                                                <stop  offset="0.8038" style="stop-color:#FFC244"/>
                                                                                                <stop  offset="0.8667" style="stop-color:#FEBA46"/>
                                                                                                <stop  offset="0.916" style="stop-color:#FCAD49"/>
                                                                                                <stop  offset="0.958" style="stop-color:#F99A4D"/>
                                                                                                <stop  offset="0.9955" style="stop-color:#F58152"/>
                                                                                                <stop  offset="1" style="stop-color:#F57E53"/>
                                                                                            </linearGradient>
                                                                                            <path style="fill:url(#SVGID_00000126308377105168115760000003800015295754250943_);" d="M972.377,2991.522					c-110.382,0-225.314,9.713-243.698,28.516c0.72,0.663,1.388,1.371,2.01,2.116c15.495-13.055,110.397-26.2,241.688-26.2					c134.662,0,231.084,13.829,242.765,27.206c0.574-0.734,1.188-1.436,1.851-2.097					C1201.809,3001.594,1084.72,2991.522,972.377,2991.522z"/>
                                                                                        </g>
                                                                                        <g>
                                                                                            <linearGradient id="SVGID_00000141418624779068515430000008620948574012583337_" gradientUnits="userSpaceOnUse" x1="655.8616" y1="3001.4629" x2="1225.4637" y2="3001.4629">
                                                                                                <stop  offset="0" style="stop-color:#FCB148"/>
                                                                                                <stop  offset="0.0521" style="stop-color:#FDBA46"/>
                                                                                                <stop  offset="0.1424" style="stop-color:#FFC244"/>
                                                                                                <stop  offset="0.3183" style="stop-color:#FFC444"/>
                                                                                                <stop  offset="0.4849" style="stop-color:#FDB946"/>
                                                                                                <stop  offset="0.7754" style="stop-color:#F99C4D"/>
                                                                                                <stop  offset="0.8658" style="stop-color:#F8924F"/>
                                                                                                <stop  offset="1" style="stop-color:#F8924F"/>
                                                                                            </linearGradient>
                                                                                            <path style="fill:url(#SVGID_00000141418624779068515430000008620948574012583337_);" d="M698.188,2957.945v54.909					c0,17.743,110.836,32.126,247.558,32.126s247.558-14.383,247.558-32.126v-54.909H698.188z"/>
                                                                                            <linearGradient id="SVGID_00000082344813565553946630000000200080038092879236_" gradientUnits="userSpaceOnUse" x1="943.2804" y1="2937.2998" x2="973.3091" y2="3188.6846">
                                                                                                <stop  offset="0" style="stop-color:#FFDB44"/>
                                                                                                <stop  offset="1" style="stop-color:#FEEF06"/>
                                                                                            </linearGradient>
                                                                                            <path style="fill:url(#SVGID_00000082344813565553946630000000200080038092879236_);" d="M1193.305,2957.945					c0,17.743-110.836,32.126-247.558,32.126s-247.558-14.383-247.558-32.126c0-17.743,110.836-32.126,247.558-32.126					S1193.305,2940.202,1193.305,2957.945z"/>
                                                                                            <linearGradient id="SVGID_00000083065063446813233360000009759313767001742517_" gradientUnits="userSpaceOnUse" x1="941.9746" y1="2926.0886" x2="951.197" y2="3003.2932">
                                                                                                <stop  offset="0" style="stop-color:#FFDB44"/>
                                                                                                <stop  offset="1" style="stop-color:#FEEF06"/>
                                                                                            </linearGradient>
                                                                                            <path style="fill:url(#SVGID_00000083065063446813233360000009759313767001742517_);" d="M945.745,2992.287					c-121.085,0-247.701-11.565-247.701-33.872c0-1.225,0.437-3.379,1.662-3.379c1.225,0,0.698,1.684,0.698,2.91					c0,14.146,100.759,29.908,245.341,29.908c144.583,0,245.342-15.762,245.342-29.908c0-1.225,0.209-2.373,1.434-2.373					s0.929,1.635,0.929,2.86C1193.451,2980.739,1066.831,2992.287,945.745,2992.287z"/>
                                                                                            <g>
                                                                                                <path style="fill:#FCB048;" d="M922.353,2959.736c2.429-1.682,5.014-3.339,7.781-4.977c2.74-1.635,6.311-3.113,10.635-4.434						c4.349-1.32,9.789-2.394,16.319-3.227c6.53-0.833,14.695-1.272,24.444-1.32c9.567-0.047,18.541,0.257,26.945,0.912						c8.378,0.652,15.772,1.632,22.157,2.934c6.359,1.302,11.552,2.912,15.555,4.826c3.977,1.919,6.347,4.115,7.111,6.59						l27.874,0.283c2.023,0.013,3.812,0.176,5.344,0.494c1.557,0.318,2.311,0.719,2.313,1.206l0.011,2.295l-35.835-0.345						c-1.257,2.811-4.459,5.383-9.608,7.714c-5.122,2.334-11.673,4.354-19.65,6.063l-13.051-1.816						c-1.168-0.178-2.129-0.405-2.882-0.682c-0.753-0.273-1.117-0.572-1.119-0.897c-0.002-0.441,1.006-0.945,3.026-1.509						c2.019-0.568,4.298-1.269,6.834-2.106c2.537-0.833,5.022-1.819,7.479-2.957c2.432-1.136,4.059-2.494,4.906-4.074l-84.583-0.839						c-2.222,1.635-4.729,3.241-7.47,4.82c-2.767,1.579-6.416,3-10.973,4.262c-4.557,1.262-10.23,2.285-17.02,3.074						c-6.816,0.786-15.344,1.205-25.663,1.255c-7.753,0.039-15.299-0.256-22.692-0.879c-7.393-0.626-13.957-1.561-19.693-2.807						c-5.737-1.249-10.437-2.791-14.128-4.626c-3.665-1.838-5.724-3.948-6.15-6.334l-22.948-0.235						c-2.023-0.014-3.812-0.171-5.422-0.478c-1.583-0.306-2.389-0.713-2.391-1.222l-0.011-2.295l31.375,0.299						c1.388-2.419,4.23-4.527,8.577-6.32c4.347-1.795,9.655-3.392,15.923-4.79l10.508,1.443c3.192,0.449,4.776,0.973,4.779,1.576						c0.001,0.325-0.645,0.727-1.965,1.209c-1.346,0.482-2.899,1.059-4.711,1.727c-1.786,0.671-3.545,1.456-5.226,2.358						c-1.707,0.899-2.973,1.919-3.822,3.061L922.353,2959.736z M844.945,2962.864c0.63,1.505,2.036,2.8,4.168,3.89						c2.131,1.094,4.781,1.989,7.973,2.692c3.193,0.703,6.774,1.218,10.742,1.547c3.995,0.328,8.17,0.483,12.526,0.462						c5.082-0.025,9.515-0.245,13.298-0.656c3.758-0.415,7.073-0.974,9.948-1.685c2.849-0.71,5.36-1.532,7.482-2.471						c2.121-0.938,4.009-1.956,5.715-3.053L844.945,2962.864z M1029.081,2960.811c-0.63-1.525-2.167-2.862-4.557-4.011						c-2.392-1.146-5.456-2.113-9.167-2.893c-3.712-0.782-8.045-1.364-12.999-1.744c-4.928-0.38-10.374-0.558-16.337-0.529						c-5.289,0.026-9.878,0.264-13.687,0.71c-3.81,0.449-7.125,1.049-9.948,1.806c-2.797,0.756-5.204,1.636-7.143,2.642						c-1.966,1.006-3.802,2.082-5.482,3.228L1029.081,2960.811z"/>
                                                                                            </g>
                                                                                            <linearGradient id="SVGID_00000180354553960057946060000013176050627568703154_" gradientUnits="userSpaceOnUse" x1="718.6048" y1="1132.6398" x2="727.7944" y2="1209.5702" gradientTransform="matrix(-1 0 0 -1 1669.249 4127.8389)">
                                                                                                <stop  offset="0.0036" style="stop-color:#F36F56"/>
                                                                                                <stop  offset="0.3059" style="stop-color:#F99C4C"/>
                                                                                                <stop  offset="0.545" style="stop-color:#FDB946"/>
                                                                                                <stop  offset="0.6817" style="stop-color:#FFC444"/>
                                                                                                <stop  offset="0.8038" style="stop-color:#FFC244"/>
                                                                                                <stop  offset="0.8667" style="stop-color:#FEBA46"/>
                                                                                                <stop  offset="0.916" style="stop-color:#FCAD49"/>
                                                                                                <stop  offset="0.958" style="stop-color:#F99A4D"/>
                                                                                                <stop  offset="0.9955" style="stop-color:#F58152"/>
                                                                                                <stop  offset="1" style="stop-color:#F57E53"/>
                                                                                            </linearGradient>
                                                                                            <path style="fill:url(#SVGID_00000180354553960057946060000013176050627568703154_);" d="M945.78,2929.296					c-110.382,0-225.314,9.713-243.698,28.516c0.719,0.664,1.388,1.372,2.009,2.116c15.495-13.055,110.397-26.199,241.689-26.199					c134.662,0,231.085,13.829,242.765,27.205c0.574-0.733,1.188-1.436,1.851-2.097					C1175.212,2939.368,1058.123,2929.296,945.78,2929.296z"/>
                                                                                        </g>
                                                                                        <g>
                                                                                            <linearGradient id="SVGID_00000181807585912329601780000002598479768799673478_" gradientUnits="userSpaceOnUse" x1="587.0421" y1="2943.7869" x2="1156.6436" y2="2943.7869">
                                                                                                <stop  offset="0" style="stop-color:#FCB148"/>
                                                                                                <stop  offset="0.0521" style="stop-color:#FDBA46"/>
                                                                                                <stop  offset="0.1424" style="stop-color:#FFC244"/>
                                                                                                <stop  offset="0.3183" style="stop-color:#FFC444"/>
                                                                                                <stop  offset="0.4849" style="stop-color:#FDB946"/>
                                                                                                <stop  offset="0.7754" style="stop-color:#F99C4D"/>
                                                                                                <stop  offset="0.8658" style="stop-color:#F8924F"/>
                                                                                                <stop  offset="1" style="stop-color:#F8924F"/>
                                                                                            </linearGradient>
                                                                                            <path style="fill:url(#SVGID_00000181807585912329601780000002598479768799673478_);" d="M629.369,2900.269v54.91					c0,17.743,110.836,32.125,247.558,32.125c136.722,0,247.558-14.383,247.558-32.125v-54.91H629.369z"/>
                                                                                            <linearGradient id="SVGID_00000159460556864017241970000010053361840442091910_" gradientUnits="userSpaceOnUse" x1="874.4605" y1="2879.6238" x2="904.4894" y2="3131.0093">
                                                                                                <stop  offset="0" style="stop-color:#FFDB44"/>
                                                                                                <stop  offset="1" style="stop-color:#FEEF06"/>
                                                                                            </linearGradient>
                                                                                            <ellipse style="fill:url(#SVGID_00000159460556864017241970000010053361840442091910_);" cx="876.927" cy="2900.269" rx="247.558" ry="32.126"/>
                                                                                            <linearGradient id="SVGID_00000159459249676950046650000011676663184580696730_" gradientUnits="userSpaceOnUse" x1="873.155" y1="2868.4128" x2="882.3773" y2="2945.6174">
                                                                                                <stop  offset="0" style="stop-color:#FFDB44"/>
                                                                                                <stop  offset="1" style="stop-color:#FEEF06"/>
                                                                                            </linearGradient>
                                                                                            <path style="fill:url(#SVGID_00000159459249676950046650000011676663184580696730_);" d="M876.926,2934.611					c-121.085,0-247.701-11.565-247.701-33.873c0-1.225,0.437-3.378,1.662-3.378c1.225,0,0.698,1.684,0.698,2.909					c0,14.147,100.758,29.909,245.341,29.909s245.342-15.762,245.342-29.909c0-1.225,0.209-2.373,1.434-2.373					c1.225,0,0.93,1.635,0.93,2.86C1124.631,2923.064,998.011,2934.611,876.926,2934.611z"/>
                                                                                            <g>
                                                                                                <path style="fill:#FCB048;" d="M853.534,2902.06c2.429-1.682,5.014-3.339,7.78-4.977c2.74-1.635,6.311-3.113,10.635-4.433						c4.35-1.32,9.79-2.394,16.319-3.228c6.53-0.833,14.695-1.272,24.444-1.319c9.568-0.048,18.541,0.256,26.945,0.912						c8.378,0.652,15.773,1.632,22.157,2.934c6.359,1.302,11.553,2.912,15.555,4.826c3.977,1.919,6.347,4.115,7.111,6.59						l27.874,0.282c2.023,0.012,3.813,0.177,5.344,0.495c1.558,0.318,2.311,0.719,2.313,1.206l0.011,2.295l-35.835-0.345						c-1.257,2.811-4.459,5.383-9.608,7.714c-5.122,2.334-11.672,4.354-19.65,6.062l-13.051-1.816						c-1.168-0.178-2.128-0.405-2.881-0.681c-0.754-0.274-1.118-0.572-1.12-0.897c-0.002-0.441,1.007-0.945,3.026-1.51						c2.02-0.568,4.298-1.269,6.835-2.105c2.537-0.833,5.021-1.819,7.479-2.957c2.432-1.136,4.059-2.493,4.906-4.074l-84.583-0.839						c-2.222,1.636-4.729,3.241-7.47,4.82c-2.767,1.579-6.415,3.001-10.972,4.262c-4.557,1.262-10.231,2.286-17.021,3.074						c-6.815,0.787-15.344,1.205-25.663,1.255c-7.752,0.039-15.3-0.256-22.692-0.879c-7.392-0.626-13.957-1.562-19.693-2.807						c-5.736-1.248-10.437-2.79-14.128-4.626c-3.665-1.838-5.724-3.948-6.15-6.335l-22.948-0.235						c-2.022-0.012-3.812-0.171-5.422-0.477c-1.583-0.306-2.389-0.713-2.391-1.222l-0.011-2.295l31.376,0.299						c1.388-2.418,4.23-4.526,8.577-6.319c4.347-1.796,9.655-3.393,15.923-4.79l10.508,1.443c3.191,0.448,4.775,0.973,4.779,1.575						c0.002,0.325-0.645,0.728-1.965,1.209c-1.346,0.483-2.898,1.059-4.711,1.727c-1.786,0.671-3.545,1.455-5.226,2.357						c-1.707,0.9-2.972,1.919-3.822,3.061L853.534,2902.06z M776.126,2905.188c0.63,1.506,2.036,2.8,4.168,3.891						c2.132,1.094,4.781,1.989,7.974,2.692c3.193,0.703,6.774,1.218,10.742,1.546c3.995,0.329,8.17,0.483,12.525,0.462						c5.082-0.024,9.515-0.244,13.298-0.656c3.758-0.415,7.074-0.974,9.949-1.685c2.849-0.71,5.359-1.532,7.481-2.47						c2.122-0.938,4.009-1.956,5.716-3.053L776.126,2905.188z M960.261,2903.135c-0.63-1.525-2.166-2.862-4.557-4.01						c-2.391-1.146-5.455-2.113-9.167-2.892c-3.711-0.783-8.044-1.365-12.998-1.745c-4.929-0.38-10.375-0.557-16.338-0.528						c-5.29,0.026-9.878,0.263-13.687,0.709c-3.809,0.449-7.125,1.049-9.948,1.806c-2.796,0.756-5.204,1.636-7.143,2.642						c-1.966,1.006-3.802,2.081-5.481,3.227L960.261,2903.135z"/>
                                                                                            </g>
                                                                                            <linearGradient id="SVGID_00000152944011861058452970000010272567413167708561_" gradientUnits="userSpaceOnUse" x1="787.4249" y1="1190.3158" x2="796.6145" y2="1267.2462" gradientTransform="matrix(-1 0 0 -1 1669.249 4127.8389)">
                                                                                                <stop  offset="0.0036" style="stop-color:#F36F56"/>
                                                                                                <stop  offset="0.3059" style="stop-color:#F99C4C"/>
                                                                                                <stop  offset="0.545" style="stop-color:#FDB946"/>
                                                                                                <stop  offset="0.6817" style="stop-color:#FFC444"/>
                                                                                                <stop  offset="0.8038" style="stop-color:#FFC244"/>
                                                                                                <stop  offset="0.8667" style="stop-color:#FEBA46"/>
                                                                                                <stop  offset="0.916" style="stop-color:#FCAD49"/>
                                                                                                <stop  offset="0.958" style="stop-color:#F99A4D"/>
                                                                                                <stop  offset="0.9955" style="stop-color:#F58152"/>
                                                                                                <stop  offset="1" style="stop-color:#F57E53"/>
                                                                                            </linearGradient>
                                                                                            <path style="fill:url(#SVGID_00000152944011861058452970000010272567413167708561_);" d="M876.96,2871.62					c-110.382,0-225.314,9.713-243.698,28.516c0.719,0.664,1.388,1.372,2.009,2.116c15.496-13.055,110.398-26.199,241.688-26.199					c134.662,0,231.085,13.828,242.765,27.205c0.574-0.733,1.187-1.436,1.851-2.097					C1106.392,2881.693,989.303,2871.62,876.96,2871.62z"/>
                                                                                        </g>
                                                                                        <g>
                                                                                            <linearGradient id="SVGID_00000008828911119840671560000016885916905189345424_" gradientUnits="userSpaceOnUse" x1="646.4239" y1="2886.2805" x2="1216.0259" y2="2886.2805">
                                                                                                <stop  offset="0" style="stop-color:#FCB148"/>
                                                                                                <stop  offset="0.0521" style="stop-color:#FDBA46"/>
                                                                                                <stop  offset="0.1424" style="stop-color:#FFC244"/>
                                                                                                <stop  offset="0.3183" style="stop-color:#FFC444"/>
                                                                                                <stop  offset="0.4849" style="stop-color:#FDB946"/>
                                                                                                <stop  offset="0.7754" style="stop-color:#F99C4D"/>
                                                                                                <stop  offset="0.8658" style="stop-color:#F8924F"/>
                                                                                                <stop  offset="1" style="stop-color:#F8924F"/>
                                                                                            </linearGradient>
                                                                                            <path style="fill:url(#SVGID_00000008828911119840671560000016885916905189345424_);" d="M688.75,2842.763v54.91					c0,17.742,110.836,32.126,247.559,32.126c136.722,0,247.558-14.383,247.558-32.126v-54.91H688.75z"/>
                                                                                            <linearGradient id="SVGID_00000116216949186500550390000010155195143615133608_" gradientUnits="userSpaceOnUse" x1="933.8426" y1="2822.1167" x2="963.8715" y2="3073.5024">
                                                                                                <stop  offset="0" style="stop-color:#FFDB44"/>
                                                                                                <stop  offset="1" style="stop-color:#FEEF06"/>
                                                                                            </linearGradient>
                                                                                            <ellipse style="fill:url(#SVGID_00000116216949186500550390000010155195143615133608_);" cx="936.309" cy="2842.762" rx="247.559" ry="32.126"/>
                                                                                            <linearGradient id="SVGID_00000005954873190488612430000000722184067122305211_" gradientUnits="userSpaceOnUse" x1="932.5372" y1="2810.906" x2="941.7596" y2="2888.1106">
                                                                                                <stop  offset="0" style="stop-color:#FFDB44"/>
                                                                                                <stop  offset="1" style="stop-color:#FEEF06"/>
                                                                                            </linearGradient>
                                                                                            <path style="fill:url(#SVGID_00000005954873190488612430000000722184067122305211_);" d="M936.308,2877.104					c-121.085,0-247.702-11.565-247.702-33.873c0-1.225,0.437-3.378,1.662-3.378c1.225,0,0.698,1.685,0.698,2.91					c0,14.146,100.758,29.909,245.342,29.909s245.341-15.762,245.341-29.909c0-1.225,0.209-2.374,1.434-2.374					c1.225,0,0.93,1.635,0.93,2.86C1184.014,2865.557,1057.394,2877.104,936.308,2877.104z"/>
                                                                                            <g>
                                                                                                <path style="fill:#FCB048;" d="M912.916,2844.553c2.429-1.682,5.013-3.339,7.78-4.977c2.741-1.635,6.311-3.113,10.635-4.433						c4.35-1.32,9.789-2.394,16.319-3.228c6.53-0.833,14.695-1.272,24.444-1.32c9.568-0.047,18.541,0.257,26.945,0.913						c8.378,0.652,15.773,1.632,22.157,2.934c6.359,1.302,11.553,2.912,15.555,4.826c3.976,1.919,6.347,4.115,7.11,6.59						l27.874,0.282c2.023,0.013,3.813,0.177,5.344,0.494c1.557,0.318,2.311,0.719,2.313,1.206l0.011,2.295l-35.835-0.345						c-1.257,2.811-4.459,5.382-9.608,7.714c-5.122,2.334-11.672,4.354-19.65,6.063l-13.051-1.815						c-1.167-0.178-2.128-0.406-2.881-0.682c-0.754-0.274-1.118-0.572-1.12-0.897c-0.002-0.441,1.007-0.945,3.026-1.509						c2.02-0.568,4.298-1.269,6.835-2.105c2.537-0.833,5.021-1.819,7.478-2.958c2.432-1.136,4.059-2.493,4.907-4.074l-84.583-0.838						c-2.222,1.635-4.729,3.24-7.47,4.819c-2.766,1.579-6.415,3.001-10.972,4.262c-4.557,1.262-10.231,2.286-17.02,3.075						c-6.815,0.787-15.344,1.205-25.663,1.256c-7.753,0.038-15.3-0.256-22.693-0.879c-7.392-0.626-13.957-1.562-19.693-2.807						c-5.736-1.248-10.437-2.79-14.128-4.625c-3.665-1.839-5.724-3.949-6.151-6.335l-22.948-0.235						c-2.023-0.013-3.813-0.171-5.422-0.477c-1.583-0.306-2.389-0.713-2.391-1.222l-0.011-2.296l31.376,0.299						c1.388-2.418,4.23-4.526,8.577-6.319c4.346-1.796,9.655-3.393,15.922-4.79l10.508,1.443c3.191,0.448,4.775,0.973,4.779,1.576						c0.001,0.325-0.645,0.728-1.965,1.209c-1.346,0.482-2.899,1.059-4.711,1.727c-1.786,0.671-3.545,1.455-5.226,2.357						c-1.707,0.9-2.972,1.919-3.822,3.061L912.916,2844.553z M835.508,2847.681c0.63,1.506,2.036,2.8,4.168,3.891						c2.131,1.094,4.78,1.989,7.973,2.692c3.193,0.703,6.774,1.218,10.742,1.546c3.995,0.328,8.17,0.484,12.526,0.462						c5.082-0.024,9.515-0.245,13.298-0.657c3.758-0.415,7.073-0.974,9.949-1.684c2.849-0.71,5.36-1.531,7.481-2.47						c2.121-0.939,4.009-1.956,5.715-3.054L835.508,2847.681z M1019.643,2845.629c-0.629-1.525-2.166-2.862-4.557-4.011						c-2.391-1.146-5.456-2.113-9.167-2.893c-3.712-0.783-8.044-1.365-12.999-1.745c-4.929-0.38-10.375-0.557-16.337-0.528						c-5.29,0.025-9.878,0.263-13.687,0.71c-3.809,0.449-7.125,1.048-9.948,1.806c-2.796,0.756-5.204,1.636-7.143,2.642						c-1.966,1.006-3.802,2.082-5.481,3.228L1019.643,2845.629z"/>
                                                                                            </g>
                                                                                            <linearGradient id="SVGID_00000018946955435570612520000007835023041633065139_" gradientUnits="userSpaceOnUse" x1="728.0427" y1="1247.8228" x2="737.2322" y2="1324.7532" gradientTransform="matrix(-1 0 0 -1 1669.249 4127.8389)">
                                                                                                <stop  offset="0.0036" style="stop-color:#F36F56"/>
                                                                                                <stop  offset="0.3059" style="stop-color:#F99C4C"/>
                                                                                                <stop  offset="0.545" style="stop-color:#FDB946"/>
                                                                                                <stop  offset="0.6817" style="stop-color:#FFC444"/>
                                                                                                <stop  offset="0.8038" style="stop-color:#FFC244"/>
                                                                                                <stop  offset="0.8667" style="stop-color:#FEBA46"/>
                                                                                                <stop  offset="0.916" style="stop-color:#FCAD49"/>
                                                                                                <stop  offset="0.958" style="stop-color:#F99A4D"/>
                                                                                                <stop  offset="0.9955" style="stop-color:#F58152"/>
                                                                                                <stop  offset="1" style="stop-color:#F57E53"/>
                                                                                            </linearGradient>
                                                                                            <path style="fill:url(#SVGID_00000018946955435570612520000007835023041633065139_);" d="M936.342,2814.113					c-110.382,0-225.314,9.713-243.698,28.516c0.719,0.664,1.388,1.372,2.009,2.116c15.495-13.054,110.397-26.198,241.688-26.198					c134.662,0,231.085,13.829,242.765,27.205c0.574-0.734,1.187-1.436,1.851-2.097					C1165.774,2824.186,1048.685,2814.113,936.342,2814.113z"/>
                                                                                        </g>
                                                                                        <g>
                                                                                            <linearGradient id="SVGID_00000020370385439707185030000004304406861558111113_" gradientUnits="userSpaceOnUse" x1="615.5373" y1="2828.6047" x2="1185.1388" y2="2828.6047">
                                                                                                <stop  offset="0" style="stop-color:#FCB148"/>
                                                                                                <stop  offset="0.0521" style="stop-color:#FDBA46"/>
                                                                                                <stop  offset="0.1424" style="stop-color:#FFC244"/>
                                                                                                <stop  offset="0.3183" style="stop-color:#FFC444"/>
                                                                                                <stop  offset="0.4849" style="stop-color:#FDB946"/>
                                                                                                <stop  offset="0.7754" style="stop-color:#F99C4D"/>
                                                                                                <stop  offset="0.8658" style="stop-color:#F8924F"/>
                                                                                                <stop  offset="1" style="stop-color:#F8924F"/>
                                                                                            </linearGradient>
                                                                                            <path style="fill:url(#SVGID_00000020370385439707185030000004304406861558111113_);" d="M657.864,2785.087v54.909					c0,17.743,110.836,32.127,247.558,32.127c136.722,0,247.558-14.384,247.558-32.127v-54.909H657.864z"/>
                                                                                            <linearGradient id="SVGID_00000087408272064963080290000003495279258159731842_" gradientUnits="userSpaceOnUse" x1="902.9557" y1="2764.4414" x2="932.9847" y2="3015.8274">
                                                                                                <stop  offset="0" style="stop-color:#FFDB44"/>
                                                                                                <stop  offset="1" style="stop-color:#FEEF06"/>
                                                                                            </linearGradient>
                                                                                            <ellipse style="fill:url(#SVGID_00000087408272064963080290000003495279258159731842_);" cx="905.422" cy="2785.087" rx="247.558" ry="32.126"/>
                                                                                            <linearGradient id="SVGID_00000124161122373758559490000007432519779495366587_" gradientUnits="userSpaceOnUse" x1="901.6501" y1="2753.2305" x2="910.8724" y2="2830.4346">
                                                                                                <stop  offset="0" style="stop-color:#FFDB44"/>
                                                                                                <stop  offset="1" style="stop-color:#FEEF06"/>
                                                                                            </linearGradient>
                                                                                            <path style="fill:url(#SVGID_00000124161122373758559490000007432519779495366587_);" d="M905.421,2819.428					c-121.085,0-247.701-11.565-247.701-33.872c0-1.225,0.437-3.378,1.662-3.378c1.225,0,0.698,1.684,0.698,2.909					c0,14.147,100.759,29.909,245.341,29.909c144.583,0,245.341-15.762,245.341-29.909c0-1.225,0.209-2.373,1.434-2.373					c1.225,0,0.93,1.635,0.93,2.86C1153.126,2807.881,1026.506,2819.428,905.421,2819.428z"/>
                                                                                            <g>
                                                                                                <path style="fill:#FCB048;" d="M882.029,2786.877c2.429-1.682,5.014-3.339,7.78-4.977c2.741-1.635,6.312-3.113,10.635-4.433						c4.35-1.32,9.79-2.394,16.32-3.228c6.53-0.833,14.695-1.272,24.444-1.32c9.567-0.047,18.54,0.257,26.944,0.912						c8.378,0.652,15.773,1.632,22.157,2.934c6.359,1.301,11.553,2.912,15.556,4.825c3.976,1.919,6.346,4.115,7.11,6.591						l27.874,0.282c2.023,0.012,3.813,0.176,5.344,0.494c1.557,0.318,2.311,0.719,2.313,1.206l0.011,2.294l-35.835-0.344						c-1.257,2.811-4.459,5.382-9.608,7.714c-5.122,2.335-11.672,4.354-19.65,6.063l-13.051-1.816						c-1.168-0.178-2.129-0.405-2.882-0.681c-0.754-0.274-1.118-0.573-1.12-0.897c-0.002-0.442,1.007-0.945,3.026-1.509						c2.02-0.567,4.298-1.269,6.835-2.106c2.537-0.833,5.021-1.818,7.479-2.957c2.432-1.136,4.059-2.494,4.906-4.074l-84.583-0.839						c-2.222,1.635-4.729,3.241-7.47,4.82c-2.767,1.579-6.415,3-10.973,4.262c-4.557,1.262-10.231,2.286-17.02,3.075						c-6.815,0.786-15.344,1.205-25.663,1.255c-7.752,0.039-15.3-0.255-22.692-0.879c-7.393-0.626-13.957-1.562-19.694-2.807						c-5.736-1.249-10.437-2.79-14.128-4.626c-3.665-1.838-5.724-3.948-6.15-6.334l-22.948-0.235						c-2.023-0.012-3.813-0.171-5.422-0.478c-1.583-0.306-2.389-0.713-2.392-1.222l-0.011-2.295l31.376,0.299						c1.388-2.418,4.23-4.526,8.577-6.319c4.347-1.797,9.655-3.393,15.923-4.791l10.508,1.443c3.191,0.448,4.775,0.972,4.779,1.575						c0.002,0.325-0.645,0.728-1.965,1.209c-1.346,0.482-2.898,1.058-4.71,1.727c-1.786,0.671-3.545,1.455-5.226,2.358						c-1.707,0.9-2.972,1.919-3.822,3.061L882.029,2786.877z M804.621,2790.005c0.63,1.506,2.036,2.8,4.168,3.89						c2.131,1.094,4.78,1.989,7.973,2.692c3.193,0.703,6.774,1.217,10.742,1.546c3.995,0.329,8.17,0.483,12.525,0.462						c5.082-0.025,9.515-0.245,13.298-0.656c3.758-0.415,7.075-0.974,9.949-1.685c2.849-0.71,5.359-1.532,7.481-2.471						c2.121-0.938,4.009-1.956,5.715-3.053L804.621,2790.005z M988.756,2787.952c-0.63-1.525-2.166-2.862-4.557-4.01						c-2.391-1.146-5.455-2.113-9.167-2.893c-3.711-0.783-8.044-1.365-12.998-1.745c-4.929-0.381-10.374-0.557-16.338-0.529						c-5.289,0.026-9.878,0.264-13.687,0.71c-3.81,0.449-7.126,1.049-9.948,1.807c-2.797,0.755-5.204,1.636-7.143,2.641						c-1.966,1.006-3.801,2.082-5.481,3.228L988.756,2787.952z"/>
                                                                                            </g>
                                                                                            <linearGradient id="SVGID_00000088826055346486580240000011855679495936097676_" gradientUnits="userSpaceOnUse" x1="758.9296" y1="1305.4983" x2="768.1191" y2="1382.4287" gradientTransform="matrix(-1 0 0 -1 1669.249 4127.8389)">
                                                                                                <stop  offset="0.0036" style="stop-color:#F36F56"/>
                                                                                                <stop  offset="0.3059" style="stop-color:#F99C4C"/>
                                                                                                <stop  offset="0.545" style="stop-color:#FDB946"/>
                                                                                                <stop  offset="0.6817" style="stop-color:#FFC444"/>
                                                                                                <stop  offset="0.8038" style="stop-color:#FFC244"/>
                                                                                                <stop  offset="0.8667" style="stop-color:#FEBA46"/>
                                                                                                <stop  offset="0.916" style="stop-color:#FCAD49"/>
                                                                                                <stop  offset="0.958" style="stop-color:#F99A4D"/>
                                                                                                <stop  offset="0.9955" style="stop-color:#F58152"/>
                                                                                                <stop  offset="1" style="stop-color:#F57E53"/>
                                                                                            </linearGradient>
                                                                                            <path style="fill:url(#SVGID_00000088826055346486580240000011855679495936097676_);" d="M905.455,2756.438					c-110.382,0-225.314,9.713-243.698,28.516c0.719,0.664,1.388,1.372,2.009,2.116c15.495-13.055,110.397-26.198,241.688-26.198					c134.662,0,231.085,13.829,242.765,27.205c0.573-0.734,1.187-1.436,1.851-2.097					C1134.888,2766.51,1017.798,2756.438,905.455,2756.438z"/>
                                                                                        </g>
                                                                                        <g>
                                                                                            <linearGradient id="SVGID_00000114769725395119104940000015724038519133729155_" gradientUnits="userSpaceOnUse" x1="1872.1219" y1="2621.2366" x2="2441.7263" y2="2621.2366" gradientTransform="matrix(0.5796 0.8149 -0.8149 0.5796 2214.3765 -230.3409)">
                                                                                                <stop  offset="0" style="stop-color:#FCB148"/>
                                                                                                <stop  offset="0.0521" style="stop-color:#FDBA46"/>
                                                                                                <stop  offset="0.1424" style="stop-color:#FFC244"/>
                                                                                                <stop  offset="0.3183" style="stop-color:#FFC444"/>
                                                                                                <stop  offset="0.4849" style="stop-color:#FDB946"/>
                                                                                                <stop  offset="0.7754" style="stop-color:#F99C4D"/>
                                                                                                <stop  offset="0.8658" style="stop-color:#F8924F"/>
                                                                                                <stop  offset="1" style="stop-color:#F8924F"/>
                                                                                            </linearGradient>
                                                                                            <path style="fill:url(#SVGID_00000114769725395119104940000015724038519133729155_);" d="M1223.398,2823.796l-44.745,31.827					c-14.459,10.285,38.064,108.939,117.312,220.351c79.248,111.413,155.213,193.394,169.671,183.11l44.745-31.827					L1223.398,2823.796z"/>
                                                                                            <linearGradient id="SVGID_00000134250475086700113700000003262148836116364956_" gradientUnits="userSpaceOnUse" x1="2159.5413" y1="2557.0796" x2="2189.5664" y2="2808.4346" gradientTransform="matrix(0.5796 0.8149 -0.8149 0.5796 2214.3765 -230.3409)">
                                                                                                <stop  offset="0" style="stop-color:#FFDB44"/>
                                                                                                <stop  offset="1" style="stop-color:#FEEF06"/>
                                                                                            </linearGradient>
                                                                                            <path style="fill:url(#SVGID_00000134250475086700113700000003262148836116364956_);" d="M1510.381,3227.257					c-14.458,10.284-90.423-71.696-169.671-183.109c-79.248-111.413-131.771-210.067-117.312-220.352					c14.458-10.284,90.422,71.696,169.671,183.109C1472.316,3118.318,1524.839,3216.973,1510.381,3227.257z"/>
                                                                                            <linearGradient id="SVGID_00000077325147890775984080000002312494487996373894_" gradientUnits="userSpaceOnUse" x1="2158.2358" y1="2545.8743" x2="2167.4565" y2="2623.0657" gradientTransform="matrix(0.5796 0.8149 -0.8149 0.5796 2214.3765 -230.3409)">
                                                                                                <stop  offset="0" style="stop-color:#FFDB44"/>
                                                                                                <stop  offset="1" style="stop-color:#FEEF06"/>
                                                                                            </linearGradient>
                                                                                            <path style="fill:url(#SVGID_00000077325147890775984080000002312494487996373894_);" d="M1338.905,3045.431					c-70.184-98.67-134.15-208.552-115.972-221.481c0.998-0.71,3.006-1.602,3.716-0.603c0.71,0.998-0.968,1.545-1.966,2.255					c-11.528,8.199,34.031,99.442,117.835,217.26s155.05,190.788,166.579,182.588c0.998-0.71,2.055-1.205,2.765-0.207					c0.71,0.998-0.794,1.705-1.792,2.415C1491.891,3240.589,1409.089,3144.101,1338.905,3045.431z"/>
                                                                                            <g>
                                                                                                <path style="fill:#FCB048;" d="M1351.871,3007.502c2.778,1.004,5.626,2.15,8.564,3.455c2.921,1.285,6.195,3.339,9.777,6.097						c3.597,2.779,7.625,6.589,12.088,11.427c4.464,4.838,9.554,11.237,15.244,19.154c5.584,7.769,10.537,15.258,14.875,22.486						c4.325,7.205,7.812,13.798,10.453,19.756c2.625,5.937,4.323,11.102,5.084,15.472c0.741,4.353,0.325,7.557-1.249,9.615						l15.927,22.878c1.162,1.656,2.066,3.209,2.694,4.641c0.644,1.454,0.754,2.3,0.358,2.584l-1.864,1.34l-20.49-29.401						c-3.019,0.605-6.97-0.514-11.855-3.358c-4.871-2.821-10.313-6.989-16.33-12.499l-6.086-11.687						c-0.531-1.054-0.903-1.969-1.114-2.743c-0.214-0.773-0.182-1.242,0.082-1.432c0.359-0.258,1.354,0.273,2.984,1.592						c1.633,1.316,3.525,2.767,5.677,4.349c2.15,1.585,4.393,3.038,6.745,4.381c2.335,1.323,4.384,1.862,6.164,1.637l-48.343-69.412						c-2.621-0.863-5.382-1.975-8.257-3.294c-2.89-1.34-6.164-3.489-9.834-6.47c-3.669-2.982-7.792-7.012-12.37-12.087						c-4.592-5.098-9.875-11.806-15.899-20.185c-4.524-6.296-8.659-12.616-12.436-19.001c-3.775-6.388-6.817-12.279-9.127-17.675						c-2.308-5.398-3.776-10.123-4.42-14.194c-0.626-4.052-0.1-6.952,1.597-8.684l-13.109-18.836						c-1.162-1.656-2.071-3.206-2.754-4.694c-0.669-1.468-0.804-2.36-0.391-2.658l1.864-1.34l17.943,25.741						c2.775-0.271,6.141,0.823,10.122,3.327c3.983,2.501,8.36,5.901,13.133,10.198l4.915,9.399c1.484,2.861,1.975,4.456,1.486,4.807						c-0.265,0.19-0.967-0.104-2.125-0.9c-1.173-0.817-2.543-1.749-4.137-2.838c-1.582-1.066-3.24-2.046-4.95-2.892						c-1.723-0.87-3.287-1.31-4.71-1.34L1351.871,3007.502z M1304.455,2946.237c-0.862,1.385-1.102,3.282-0.755,5.651						c0.345,2.37,1.151,5.048,2.428,8.058c1.278,3.009,2.934,6.225,4.967,9.649c2.048,3.446,4.341,6.938,6.884,10.475						c2.966,4.127,5.714,7.612,8.243,10.456c2.516,2.821,4.894,5.2,7.139,7.13c2.23,1.91,4.355,3.479,6.35,4.665						c1.995,1.185,3.917,2.134,5.801,2.887L1304.455,2946.237z M1412.857,3095.095c0.878-1.397,1.077-3.424,0.627-6.039						c-0.453-2.612-1.441-5.67-2.957-9.146c-1.514-3.479-3.551-7.347-6.112-11.604c-2.547-4.237-5.559-8.777-9.039-13.62						c-3.087-4.295-5.94-7.896-8.512-10.742c-2.573-2.844-4.984-5.198-7.238-7.059c-2.236-1.842-4.349-3.293-6.293-4.29						c-1.959-1.019-3.9-1.89-5.808-2.595L1412.857,3095.095z"/>
                                                                                            </g>
                                                                                            <linearGradient id="SVGID_00000013913181519157885410000010412095409890603939_" gradientUnits="userSpaceOnUse" x1="-497.0879" y1="1512.4138" x2="-487.9" y2="1589.3301" gradientTransform="matrix(-0.5796 -0.8149 0.8149 -0.5796 -181.2018 3522.6223)">
                                                                                                <stop  offset="0.0036" style="stop-color:#F36F56"/>
                                                                                                <stop  offset="0.3059" style="stop-color:#F99C4C"/>
                                                                                                <stop  offset="0.545" style="stop-color:#FDB946"/>
                                                                                                <stop  offset="0.6817" style="stop-color:#FFC444"/>
                                                                                                <stop  offset="0.8038" style="stop-color:#FFC244"/>
                                                                                                <stop  offset="0.8667" style="stop-color:#FEBA46"/>
                                                                                                <stop  offset="0.916" style="stop-color:#FCAD49"/>
                                                                                                <stop  offset="0.958" style="stop-color:#F99A4D"/>
                                                                                                <stop  offset="0.9955" style="stop-color:#F58152"/>
                                                                                                <stop  offset="1" style="stop-color:#F57E53"/>
                                                                                            </linearGradient>
                                                                                            <path style="fill:url(#SVGID_00000013913181519157885410000010412095409890603939_);" d="M1390.254,3008.948					c-63.98-89.948-138.513-177.974-164.491-182.057c-0.123,0.971-0.312,1.926-0.559,2.864					c19.62,5.061,85.339,74.775,161.439,181.762c78.054,109.733,122.674,196.322,118.544,213.594					c0.93,0.042,1.859,0.135,2.782,0.293C1515.032,3201.747,1455.371,3100.494,1390.254,3008.948z"/>
                                                                                        </g>
                                                                                    </g>
                                                                                    <g>
                                                                                        <linearGradient id="SVGID_00000112596402550520585820000010001619713383902380_" gradientUnits="userSpaceOnUse" x1="2239.2925" y1="2439.604" x2="2465.4597" y2="2781.4246">
                                                                                            <stop  offset="0" style="stop-color:#AA80F9"/>
                                                                                            <stop  offset="0.9964" style="stop-color:#6165D7"/>
                                                                                        </linearGradient>
                                                                                        <path style="fill:url(#SVGID_00000112596402550520585820000010001619713383902380_);" d="M2670.99,3117.262l-22.402,1.761				c-5.821,0.46-11.643,0.23-17.387-0.727l-88.85-14.476l-1.455-0.23l-103.249-16.85l-0.64-0.039l-80.91-13.097v-455.238				l81.396-0.049h0.153l103.249,5.137l1.531,0.77l124.886,4.808L2670.99,3117.262z"/>
                                                                                        <linearGradient id="SVGID_00000128479037113655716920000011225885693650262183_" gradientUnits="userSpaceOnUse" x1="2943.2222" y1="2643.1892" x2="2612.2627" y2="3202.1428">
                                                                                            <stop  offset="0" style="stop-color:#AA80F9"/>
                                                                                            <stop  offset="0.9964" style="stop-color:#6165D7"/>
                                                                                        </linearGradient>
                                                                                        <path style="fill:url(#SVGID_00000128479037113655716920000011225885693650262183_);" d="M2985.173,2647.346v424.901				c0,15.203-11.678,27.624-26.784,28.522l-296.33,17.627c-11.987,0.713-22.215-9.241-22.215-21.597v-442.672				c0-12.365,9.695-22.618,21.728-22.953l298.466-8.318C2973.88,2622.47,2985.173,2633.459,2985.173,2647.346z"/>
                                                                                        <linearGradient id="SVGID_00000037693849811126983850000009122243370102636420_" gradientUnits="userSpaceOnUse" x1="2701.9453" y1="2467.1155" x2="2649.5139" y2="2651.8733">
                                                                                            <stop  offset="0.0036" style="stop-color:#E38DDD"/>
                                                                                            <stop  offset="1" style="stop-color:#9571F6"/>
                                                                                        </linearGradient>
                                                                                        <polygon style="fill:url(#SVGID_00000037693849811126983850000009122243370102636420_);" points="2356.732,2618.374 				2639.844,2631.779 2960.037,2622.856 2631.762,2612.161 			"/>
                                                                                        <linearGradient id="SVGID_00000177445397416059728190000011217013337837055877_" gradientUnits="userSpaceOnUse" x1="2966.416" y1="2657.4209" x2="2632.4951" y2="3221.3762">
                                                                                            <stop  offset="0.0036" style="stop-color:#E38DDD"/>
                                                                                            <stop  offset="1" style="stop-color:#9571F6"/>
                                                                                        </linearGradient>
                                                                                        <path style="opacity:0.3;fill:url(#SVGID_00000177445397416059728190000011217013337837055877_);" d="M2959.615,2622.868				l-233.75,6.513c-13.297,0.371-24.154,11.586-24.139,25.172c0.025,22.673,3.807,46.106,13.787,68.713				c33.274,75.371,107.656,78.154,123.133,147.335c12.895,57.642-32.767,82.442-37.593,156.099				c-1.268,19.35,0.406,40.166,6.167,62.482c3.032,11.747,13.954,19.749,25.859,19.041l128.686-7.655				c13.203-0.786,23.407-11.637,23.407-24.92V2647.77C2985.173,2633.65,2973.69,2622.476,2959.615,2622.868z"/>
                                                                                        <linearGradient id="SVGID_00000089548521079882454410000008681326950135988625_" gradientUnits="userSpaceOnUse" x1="2757.1677" y1="2660.7268" x2="2891.5488" y2="3337.7007">
                                                                                            <stop  offset="0" style="stop-color:#AB316D"/>
                                                                                            <stop  offset="1" style="stop-color:#792D3D"/>
                                                                                        </linearGradient>
                                                                                        <polygon style="fill:url(#SVGID_00000089548521079882454410000008681326950135988625_);" points="2743.711,3113.539 				2853.58,3107.003 2853.58,2625.823 2743.711,2628.885 			"/>
                                                                                        <linearGradient id="SVGID_00000167395256250814632890000002990971076995478706_" gradientUnits="userSpaceOnUse" x1="2777.541" y1="2871.3618" x2="3015.5659" y2="2836.1611">
                                                                                            <stop  offset="0" style="stop-color:#AB316D"/>
                                                                                            <stop  offset="1" style="stop-color:#792D3D"/>
                                                                                        </linearGradient>
                                                                                        <polygon style="fill:url(#SVGID_00000167395256250814632890000002990971076995478706_);" points="2748.659,3113.244 				2853.58,3107.003 2853.58,2625.823 2748.659,2628.747 			"/>
                                                                                        <linearGradient id="SVGID_00000051355208547749543550000013770875795622503045_" gradientUnits="userSpaceOnUse" x1="2467.8579" y1="2866.1484" x2="2695.0459" y2="2832.5503">
                                                                                            <stop  offset="0" style="stop-color:#AB316D"/>
                                                                                            <stop  offset="1" style="stop-color:#792D3D"/>
                                                                                        </linearGradient>
                                                                                        <polygon style="fill:url(#SVGID_00000051355208547749543550000013770875795622503045_);" points="2539.419,2624.914 				2539.419,3103.821 2438.771,3086.74 2438.771,2622.195 2470.827,2621.584 			"/>
                                                                                        <linearGradient id="SVGID_00000011008108847316106030000010281371531265689791_" gradientUnits="userSpaceOnUse" x1="2617.5559" y1="2630.853" x2="3122.5725" y2="2556.1675">
                                                                                            <stop  offset="0" style="stop-color:#AB316D"/>
                                                                                            <stop  offset="1" style="stop-color:#792D3D"/>
                                                                                        </linearGradient>
                                                                                        <polygon style="fill:url(#SVGID_00000011008108847316106030000010281371531265689791_);" points="2549.741,2614.014 				2856.017,2631.428 2745.904,2631.428 2478.131,2615.632 			"/>
                                                                                        <g>
                                                                                            <linearGradient id="SVGID_00000052816371952697475470000000290566663560633731_" gradientUnits="userSpaceOnUse" x1="2873.5361" y1="2482.624" x2="2748.4084" y2="2612.7568">
                                                                                                <stop  offset="0" style="stop-color:#AB316D"/>
                                                                                                <stop  offset="1" style="stop-color:#792D3D"/>
                                                                                            </linearGradient>
                                                                                            <path style="fill:url(#SVGID_00000052816371952697475470000000290566663560633731_);" d="M2698.773,2599.312					c7.132-43.691,12.344-75.621,40.875-105.107c12.031-12.434,25.169-26.012,46.715-29.614c24.777-4.142,56.402,5.624,65.066,25.86					c8.227,19.214-11.155,31.734-2.92,53.804c8.276,22.181,32.394,21.708,35.036,39.624c2.238,15.174-12.574,32.39-27.528,40.458					c-25.824,13.933-40.487-5.668-90.926-2.502c-34.758,2.182-54.819,13.186-64.232,2.086					C2696.377,2618.636,2696.816,2611.297,2698.773,2599.312z"/>
                                                                                            <g style="opacity:0.3;">
                                                                                                <linearGradient id="SVGID_00000139995556136140668160000010822254596721656716_" gradientUnits="userSpaceOnUse" x1="2893.6865" y1="2501.999" x2="2768.5581" y2="2632.1326">
                                                                                                    <stop  offset="0" style="stop-color:#AB316D"/>
                                                                                                    <stop  offset="1" style="stop-color:#792D3D"/>
                                                                                                </linearGradient>
                                                                                                <path style="fill:url(#SVGID_00000139995556136140668160000010822254596721656716_);" d="M2836.83,2582.211						c-31.141-11.91-47.102-37.83-60.896-31.699c-12.258,5.449-4.779,28.198-19.186,46.714						c-13.157,16.908-37.287,20.93-58.729,20.947c0.541,2.165,1.421,4.075,2.838,5.747c9.413,11.1,29.475,0.096,64.232-2.086						c50.439-3.166,65.102,16.435,90.926,2.502c13.719-7.402,27.28-22.502,27.704-36.663						C2869.167,2589.238,2852.98,2588.388,2836.83,2582.211z"/>
                                                                                            </g>
                                                                                        </g>
                                                                                        <g>
                                                                                            <linearGradient id="SVGID_00000158731367101216447670000007503998216033595778_" gradientUnits="userSpaceOnUse" x1="2577.8782" y1="2534.5" x2="2910.1938" y2="2485.3545">
                                                                                                <stop  offset="0" style="stop-color:#AB316D"/>
                                                                                                <stop  offset="1" style="stop-color:#792D3D"/>
                                                                                            </linearGradient>
                                                                                            <path style="fill:url(#SVGID_00000158731367101216447670000007503998216033595778_);" d="M2510.664,2491.285					c20.948-16.533,43.031,1.905,68.82-16.267c26.121-18.405,18.532-47.935,38.79-56.307c23.535-9.728,58.396,19.954,75.077,38.79					c42.371,47.844,62.27,132.785,28.779,162.666c-12.57,11.215-48.163,6.593-118.837-3.108					c-80.78-11.088-92.406-19.03-100.137-29.425C2482.322,2559.621,2486.949,2510.002,2510.664,2491.285z"/>
                                                                                            <g style="opacity:0.3;">
                                                                                                <linearGradient id="SVGID_00000014634156129580477680000006727993529716771254_" gradientUnits="userSpaceOnUse" x1="2581.7441" y1="2560.6414" x2="2914.0593" y2="2511.4961">
                                                                                                    <stop  offset="0" style="stop-color:#AB316D"/>
                                                                                                    <stop  offset="1" style="stop-color:#792D3D"/>
                                                                                                </linearGradient>
                                                                                                <path style="fill:url(#SVGID_00000014634156129580477680000006727993529716771254_);" d="M2643.299,2527.155						c-11.642-3.672-16.945,9.651-40.875,15.015c-4.391,0.984-46.591,9.801-69.238-16.684c-8.985-10.508-13.202-24.64-12.712-39.625						c-3.304,1.149-6.571,2.866-9.811,5.423c-23.715,18.717-28.342,68.335-7.508,96.348c7.731,10.395,19.357,18.337,100.137,29.425						c70.674,9.701,106.267,14.323,118.837,3.108c1.689-1.507,3.207-3.19,4.628-4.965c-16.956-0.559-34.745-4.665-47.589-17.141						C2654.387,2573.987,2663.09,2533.397,2643.299,2527.155z"/>
                                                                                            </g>
                                                                                        </g>
                                                                                        <linearGradient id="SVGID_00000033346958311824798630000004992468398711323831_" gradientUnits="userSpaceOnUse" x1="2515.1238" y1="2626.7253" x2="2798.4604" y2="2584.8235">
                                                                                            <stop  offset="0" style="stop-color:#AB316D"/>
                                                                                            <stop  offset="1" style="stop-color:#792D3D"/>
                                                                                        </linearGradient>
                                                                                        <polygon style="fill:url(#SVGID_00000033346958311824798630000004992468398711323831_);" points="2648.318,2623.039 				2540.895,2627.098 2437.493,2622.195 2470.926,2621.584 2617.299,2618.979 			"/>
                                                                                    </g>
                                                                                </g>
                                                                            </g>
                                                                        </svg>',
                                                                        '<svg viewBox="0 0 64 64" id="filled" xmlns="http://www.w3.org/2000/svg" fill="#000000">
                                                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                                                            <g id="SVGRepo_iconCarrier">
                                                                                <defs>
                                                                                    <style>.cls-1{fill:#81dee3;}.cls-1,.cls-2{stroke:#000000;stroke-linecap:round;stroke-linejoin:round;stroke-width:2px;}.cls-2{fill:#004fe3;}</style>
                                                                                </defs>
                                                                                <title></title>
                                                                                <path class="cls-1" d="M42.5347,54.2538,32,60,21.4653,54.2538A22,22,0,0,1,10,34.94V14A10,10,0,0,0,20,4H44A10,10,0,0,0,54,14V34.94A22,22,0,0,1,42.5347,54.2538Z"></path>
                                                                                <polygon class="cls-2" points="42 27.5 34.5 27.5 34.5 20 29.5 20 29.5 27.5 22 27.5 22 32.5 29.5 32.5 29.5 40 34.5 40 34.5 32.5 42 32.5 42 27.5"></polygon>
                                                                            </g>
                                                                        </svg>',
                                                                        '<svg viewBox="0 0 1024 1024" class="icon" version="1.1" xmlns="http://www.w3.org/2000/svg" fill="#000000">
                                                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                                                            <g id="SVGRepo_iconCarrier">
                                                                                <path d="M447.934 684h136v179h-136z" fill="#2CC4FE"></path>
                                                                                <path d="M587.934 867h-144V680h144v187z m-136-8h128V688h-128v171z" fill="#515151"></path>
                                                                                <path d="M872.934 698.076h-724c-11.046 0-20-8.954-20-20v-472c0-11.046 8.954-20 20-20h724c11.046 0 20 8.954 20 20v472c0 11.046-8.955 20-20 20z" fill="#2CC4FE"></path>
                                                                                <path d="M872.934 702.076h-724c-13.234 0-24-10.766-24-24v-472c0-13.233 10.766-24 24-24h724c13.234 0 24 10.767 24 24v472c0 13.234-10.767 24-24 24z m-724-512c-8.822 0-16 7.178-16 16v472c0 8.822 7.178 16 16 16h724c8.822 0 16-7.178 16-16v-472c0-8.822-7.178-16-16-16h-724z" fill="#515151"></path>
                                                                                <path d="M889 621H133V206.538c0-9.092 7.37-16.462 16.462-16.462h723.076c9.092 0 16.462 7.37 16.462 16.462V621z" fill="#A1E4FD"></path>
                                                                                <path d="M324 863h383" fill="#2CC4FE"></path>
                                                                                <path d="M707 867H324a4 4 0 0 1 0-8h383a4 4 0 0 1 0 8z" fill="#515151"></path>
                                                                                <path d="M177.248 350.183l86.995-86.996" fill="#2CC4FE"></path>
                                                                                <path d="M177.248 354.183a4 4 0 0 1-2.829-6.828l86.996-86.996a4 4 0 0 1 5.657 5.657l-86.996 86.996a3.991 3.991 0 0 1-2.828 1.171z" fill="#D7F9FF"></path>
                                                                                <path d="M177.248 420.679L329.37 268.557" fill="#2CC4FE"></path>
                                                                                <path d="M177.248 424.679a4 4 0 0 1-2.829-6.828l152.123-152.123a4 4 0 0 1 5.657 5.657L180.076 423.508a3.987 3.987 0 0 1-2.828 1.171z" fill="#D7F9FF"></path>
                                                                            </g>
                                                                        </svg>',
                                                                        '<svg viewBox="0 -196 1416 1416" class="icon" version="1.1" xmlns="http://www.w3.org/2000/svg" fill="#000000">
                                                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                                                            <g id="SVGRepo_iconCarrier">
                                                                                <path d="M324.358919 22.140541H1361.643243c18.819459 0 33.210811 14.391351 33.210811 33.21081v645.396757c0 18.819459-14.391351 33.210811-33.210811 33.210811H324.358919c-18.819459 0-33.210811-14.391351-33.210811-33.210811V55.351351c0-18.819459 14.391351-33.210811 33.210811-33.21081z" fill="#9DBE87"></path>
                                                                                <path d="M1361.643243 756.099459H324.358919c-30.996757 0-55.351351-24.354595-55.351351-55.351351V55.351351c0-30.996757 24.354595-55.351351 55.351351-55.351351H1361.643243c30.996757 0 55.351351 24.354595 55.351352 55.351351v645.396757c0 29.88973-24.354595 55.351351-55.351352 55.351351zM324.358919 44.281081c-6.642162 0-11.07027 4.428108-11.07027 11.07027v645.396757c0 6.642162 4.428108 11.07027 11.07027 11.07027H1361.643243c6.642162 0 11.07027-4.428108 11.070271-11.07027V55.351351c0-6.642162-4.428108-11.07027-11.070271-11.07027H324.358919z" fill="#131313"></path>
                                                                                <path d="M230.261622 116.237838h1038.391351c18.819459 0 33.210811 14.391351 33.210811 33.210811v645.396756c0 18.819459-14.391351 33.210811-33.210811 33.210811H230.261622c-18.819459 0-33.210811-14.391351-33.210811-33.210811V149.448649c0-18.819459 14.391351-33.210811 33.210811-33.210811z" fill="#9DBE87"></path>
                                                                                <path d="M1267.545946 850.196757H230.261622c-30.996757 0-55.351351-24.354595-55.351352-55.351352V149.448649c0-30.996757 24.354595-55.351351 55.351352-55.351352h1038.391351c30.996757 0 55.351351 24.354595 55.351351 55.351352v645.396756c-1.107027 29.88973-25.461622 55.351351-56.458378 55.351352zM230.261622 138.378378c-6.642162 0-11.07027 4.428108-11.070271 11.070271v645.396756c0 6.642162 4.428108 11.07027 11.070271 11.070271h1038.391351c6.642162 0 11.07027-4.428108 11.07027-11.070271V149.448649c0-6.642162-4.428108-11.07027-11.07027-11.070271H230.261622z" fill="#131313"></path>
                                                                                <path d="M143.913514 208.121081h1038.391351c18.819459 0 33.210811 14.391351 33.210811 33.210811v645.396757c0 18.819459-14.391351 33.210811-33.210811 33.21081H143.913514c-18.819459 0-33.210811-14.391351-33.210811-33.21081V241.331892c0-17.712432 14.391351-33.210811 33.210811-33.210811z" fill="#9DBE87"></path>
                                                                                <path d="M1182.304865 942.08H143.913514c-30.996757 0-55.351351-24.354595-55.351352-55.351351V241.331892c0-30.996757 24.354595-55.351351 55.351352-55.351351h1038.391351c30.996757 0 55.351351 24.354595 55.351351 55.351351v645.396757c0 29.88973-25.461622 55.351351-55.351351 55.351351zM143.913514 230.261622c-6.642162 0-11.07027 4.428108-11.070271 11.07027v645.396757c0 6.642162 4.428108 11.07027 11.070271 11.07027h1038.391351c6.642162 0 11.07027-4.428108 11.07027-11.07027V241.331892c0-6.642162-4.428108-11.07027-11.07027-11.07027H143.913514z" fill="#131313"></path>
                                                                                <path d="M55.351351 290.041081h1038.391352c18.819459 0 33.210811 14.391351 33.210811 33.210811v645.396757c0 18.819459-14.391351 33.210811-33.210811 33.21081H55.351351c-18.819459 0-33.210811-14.391351-33.21081-33.21081V323.251892c0-17.712432 14.391351-33.210811 33.21081-33.210811z" fill="#9DBE87"></path>
                                                                                <path d="M1093.742703 1024H55.351351c-30.996757 0-55.351351-24.354595-55.351351-55.351351V323.251892c0-30.996757 24.354595-55.351351 55.351351-55.351351h1038.391352c30.996757 0 55.351351 24.354595 55.351351 55.351351v645.396757c0 30.996757-25.461622 55.351351-55.351351 55.351351zM55.351351 312.181622c-6.642162 0-11.07027 4.428108-11.07027 11.07027v645.396757c0 6.642162 4.428108 11.07027 11.07027 11.07027h1038.391352c6.642162 0 11.07027-4.428108 11.07027-11.07027V323.251892c0-6.642162-4.428108-11.07027-11.07027-11.07027H55.351351z" fill="#131313"></path>
                                                                                <path d="M954.257297 902.227027H194.836757c0-52.03027-43.174054-95.204324-95.204325-95.204324V472.700541c52.03027 0 95.204324-43.174054 95.204325-95.204325h759.42054c0 52.03027 43.174054 95.204324 95.204325 95.204325v334.322162c-53.137297 0-95.204324 43.174054-95.204325 95.204324z" fill="#D6F0C5"></path>
                                                                                <path d="M954.257297 924.367568H194.836757c-12.177297 0-22.140541-9.963243-22.140541-22.140541 0-39.852973-33.210811-73.063784-73.063784-73.063784-12.177297 0-22.140541-9.963243-22.14054-22.14054V472.700541c0-12.177297 9.963243-22.140541 22.14054-22.140541 39.852973 0 73.063784-33.210811 73.063784-73.063784 0-12.177297 9.963243-22.140541 22.140541-22.14054h759.42054c12.177297 0 22.140541 9.963243 22.140541 22.14054 0 39.852973 33.210811 73.063784 73.063784 73.063784 12.177297 0 22.140541 9.963243 22.14054 22.140541v334.322162c0 12.177297-9.963243 22.140541-22.14054 22.14054-39.852973 0-73.063784 33.210811-73.063784 73.063784 0 12.177297-9.963243 22.140541-22.140541 22.140541z m-739.494054-44.281082h718.460541c8.856216-46.495135 46.495135-84.134054 92.99027-92.99027V492.627027c-46.495135-8.856216-84.134054-46.495135-92.99027-92.99027H214.763243c-8.856216 46.495135-46.495135 84.134054-92.99027 92.99027V785.989189c46.495135 9.963243 84.134054 47.602162 92.99027 94.097297z" fill="#131313"></path>
                                                                                <path d="M576.761081 790.417297c-35.424865 0-73.063784-13.284324-99.632432-47.602162-7.749189-9.963243-5.535135-23.247568 3.321081-30.996757 9.963243-7.749189 23.247568-5.535135 30.996756 3.321081 26.568649 34.317838 67.528649 35.424865 94.097298 26.568649 22.140541-7.749189 35.424865-22.140541 35.424865-37.638919 0-14.391351-34.317838-24.354595-64.207568-33.210811-46.495135-14.391351-105.167568-30.996757-105.167567-86.348108 0-26.568649 16.605405-50.923243 45.388108-65.314594 35.424865-17.712432 95.204324-24.354595 151.662702 16.605405 9.963243 7.749189 12.177297 21.033514 4.428108 30.996757-7.749189 9.963243-21.033514 12.177297-30.996756 4.428108-37.638919-27.675676-79.705946-26.568649-105.167568-13.284324-13.284324 6.642162-22.140541 16.605405-22.14054 26.568648 0 21.033514 30.996757 30.996757 73.063783 44.281081 45.388108 13.284324 95.204324 28.782703 95.204325 75.277838 0 34.317838-25.461622 65.314595-65.314595 79.705946-11.07027 3.321081-26.568649 6.642162-40.96 6.642162z" fill="#131313"></path>
                                                                                <path d="M574.547027 549.085405c-12.177297 0-22.140541-9.963243-22.140541-22.14054v-48.709189c0-12.177297 9.963243-22.140541 22.140541-22.140541s22.140541 9.963243 22.140541 22.140541v48.709189c0 13.284324-9.963243 22.140541-22.140541 22.14054z" fill="#131313"></path>
                                                                                <path d="M574.547027 832.484324c-12.177297 0-22.140541-9.963243-22.140541-22.14054v-36.531892c0-12.177297 9.963243-22.140541 22.140541-22.140541s22.140541 9.963243 22.140541 22.140541v36.531892c0 12.177297-9.963243 22.140541-22.140541 22.14054z" fill="#131313"></path>
                                                                                <path d="M285.612973 653.145946m-40.96 0a40.96 40.96 0 1 0 81.92 0 40.96 40.96 0 1 0-81.92 0Z" fill="#AECD99"></path>
                                                                                <path d="M285.612973 715.139459c-34.317838 0-63.100541-27.675676-63.100541-63.10054s27.675676-63.100541 63.100541-63.100541c34.317838 0 63.100541 27.675676 63.100541 63.100541s-28.782703 63.100541-63.100541 63.10054z m0-80.812973c-9.963243 0-18.819459 7.749189-18.819459 18.81946s7.749189 18.819459 18.819459 18.819459c9.963243 0 18.819459-7.749189 18.819459-18.819459s-8.856216-18.819459-18.819459-18.81946z" fill="#131313"></path>
                                                                                <path d="M865.695135 653.145946m-40.96 0a40.96 40.96 0 1 0 81.92 0 40.96 40.96 0 1 0-81.92 0Z" fill="#AECD99"></path>
                                                                                <path d="M865.695135 715.139459c-34.317838 0-63.100541-27.675676-63.10054-63.10054s27.675676-63.100541 63.10054-63.100541c34.317838 0 63.100541 27.675676 63.100541 63.100541s-28.782703 63.100541-63.100541 63.10054z m0-80.812973c-9.963243 0-18.819459 7.749189-18.819459 18.81946s7.749189 18.819459 18.819459 18.819459 18.819459-7.749189 18.81946-18.819459-8.856216-18.819459-18.81946-18.81946z" fill="#131313"></path>
                                                                            </g>
                                                                        </svg>',
                                                                        ];
                                                                echo $icons[$row['category_id']-1];
                                                            ?>
                                                            </div>
            
                                                            <div class="ml-4">
                                                                <div class="text-sm font-medium leading-5 dark:text-slate-100"><?= $category; ?></div>
                                                            </div>
                                                        </div>
                                                    </td>
            
                                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-slate-200 dark:border-slate-500">
                                                        <div class="text-sm leading-5 text-slate-900 dark:text-slate-100"><?= $row["description"] ?></div>
                                                        <div class="text-sm leading-5 dark:text-slate-300 text-slate-500">
                                                            <?php 
                                                                $oldDateFormat = $row["transaction_date"];
                                                                $newDateFormat = date("d-m-Y", strtotime($oldDateFormat));
                                                                echo $newDateFormat;
                                                            ?>
                                                        </div>
                                                    </td>
            
                                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-slate-200 dark:border-slate-500">
                                                        <span
                                                            class="inline-flex px-2 text-sm font-semibold leading-5 text-slate-900 bg-<?php if($row["transaction_type"] == "Expense"){echo "rose-200";} elseif ($row["transaction_type"] == "Income"){echo "green-200";} ?> rounded-full"><?= $row["transaction_type"] ?></span>
                                                    </td>
            
                                                    <td
                                                        class="px-6 py-4 text-sm leading-5 text-<?php if($row["transaction_type"] == "Expense"){echo "rose-500";} elseif ($row["transaction_type"] == "Income"){echo "primary";} ?> font-semibold whitespace-no-wrap border-b border-slate-200 dark:border-slate-500">
                                                        <?php
                                                            $oldAmountFormat = $row["amount"];
                                                            $newFormattedAmount = "Rp. " . number_format($oldAmountFormat, 0, '.', ',');
                                                            echo $newFormattedAmount;
                                                        ?>
                                                    </td>

                                                    <td
                                                        class="px-6 py-4 text-sm font-medium leading-5 text-right whitespace-no-wrap border-b border-slate-200 dark:border-slate-500">
                                                        <form action="edit.php" method="get">
                                                            <input type="hidden" name="id" value="<?= $row["id"] ?>" /> <!-- Hidden input with item ID -->
                                                            <button class="text-indigo-600 hover:text-indigo-900" name="edit">Edit</button>
                                                        </form>
                                                    </td>
                                                    <td
                                                        class="px-6 py-4 text-sm font-medium leading-5 text-right whitespace-no-wrap border-b border-slate-200 dark:border-slate-500">
                                                        <form action="../../src/php/delete.php" method="post">
                                                            <input type="hidden" name="id" value="<?= $row["id"] ?>" /> <!-- Hidden input with item ID -->
                                                            <button class="text-red-600 hover:text-red-900" name="delete">Delete</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            <?php   
                                                        endforeach;
                                                    endif;
                                                endif;
                                            ?>
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        

                            <!-- Edit Transaction Form - Start -->
                            
                            <!-- Edit Transaction FOrm - End -->

                            <!-- Transaction Form - Start -->
                            <div :class="transactionForm ? 'block' : 'hidden'" @click="transactionForm = false" class="fixed inset-0  transition-opacity bg-black opacity-50  h-screen"></div>
                            <div :class="transactionForm ? 'translate-x-0 ease-out' : '-translate-x-full ease-in'" class="min-h-screen h-screen w-full inline-block absolute align-middle top-[30%] bg-transparent sm:p-12 max-w-full items-center">
                                <div class=" max-w-md px-6 py-12 bg-white dark:bg-slate-600 border-0 shadow-xl z-50  mx-auto rounded-xl sm:rounded-3xl">
                                    <h1 class="text-2xl font-bold mb-8 text-center dark:text-slate-100">Add Transaction</h1>
                                    <form id="form" method="post" action="">
                                        <!-- Category-Start -->
                                        <div class="relative z-0 w-full mb-5">
                                            <select
                                                name="category"
                                                value=""
                                                onclick="this.setAttribute('value', this.value);"
                                                required
                                                autocomplete="false"
                                                class="pt-3 pb-2 block w-full px-0 mt-0 border-0 border-b-2 bg-transparent appearance-none z-1 focus:outline-none focus:ring-0 focus:border-black dark:focus:border-white border-gray-200"
                                            >
                                            <option value="" selected disabled hidden></option>
                                            <?php
                                                $category = pg_fetch_all(pg_query($connection, 'SELECT * FROM category'));
                                                foreach( $category as $row ){
                                                    ?>
                                                    <option value="<?= $row['id'] ?>"><?=$row['category_type']?></option>
                                                    <?php
                                                }
                                            ?>
                                            </select>
                                            <label for="select" class="absolute duration-300 top-3 -z-1 origin-0 text-gray-500 dark:text-slate-100" dark:text-slate-100>Category</label>
                                        </div>
                                        <!-- Category-End -->

                                        <!-- Date-Start -->
                                        <div class="relative z-0 w-full mb-5 border-none outline-none appearance-none" data-te-datepicker-init>
                                            <input
                                                type=""
                                                required
                                                name="date"
                                                autocomplete="off"
                                                class="block w-full bg-transparent pt-3 pb-2 px-0 mt-0 border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 dark:text-white focus:border-black dark:focus:border-white border-gray-200 peer-focus:text-primary"
                                                placeholder=""/>
                                                <label for="date" class="absolute duration-300 top-3 -z-1 origin-0 text-gray-500 dark:text-slate-100">Date</label>
                                        </div>
                                        <!-- Date-End -->

                                        <!-- Description-Start -->
                                        <div class="relative z-0 w-full mb-5">
                                            <input
                                                type="text"
                                                name="description"
                                                required
                                                autocomplete="off"
                                                placeholder=" "
                                                class="pt-3 pb-2 block w-full px-0 mt-0 bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 dark:text-white focus:border-black dark:focus:border-white border-gray-200"
                                            />
                                            <label for="description" class="absolute duration-300 top-3 -z-1 origin-0 text-gray-500 dark:text-slate-100">Enter description</label>
                                        </div>
                                        <!-- Description-End -->
                                
                                        <!-- Type-Start -->
                                        <div class="relative z-0 w-full mb-5">
                                            <select
                                                name="type"
                                                value=""
                                                onclick="this.setAttribute('value', this.value);"
                                                required
                                                autocomplete="off"
                                                class="pt-3 pb-2 block w-full px-0 mt-0 bg-transparent border-0 border-b-2 appearance-none z-1 focus:outline-none focus:ring-0 focus:border-black dark:focus:border-white border-gray-200">
                                                <option value="" selected disabled hidden></option>
                                                <option value="Expense">Expense</option>
                                                <option value="Income">Income</option>
                                            </select>
                                            <label for="select" class="absolute duration-300 top-3 -z-1 origin-0 text-gray-500 dark:text-slate-100">Type</label>
                                        </div>
                                        <!-- Type-End -->
                                        
                                        <!-- Amount-Start -->
                                        <div class="relative z-0 w-full mb-5">
                                            <input
                                                type="number"
                                                name="amount"
                                                placeholder=" "
                                                required
                                                autocomplete="off"
                                                class="pt-3 pb-2 pl-7 block w-full px-0 mt-0 bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 dark:text-white focus:border-black dark:focus:border-white border-gray-200"
                                            />
                                            <div class="absolute top-0 left-0 mt-3 ml-1 text-gray-400 dark:text-slate-50">Rp.</div>
                                            <label for="money" class="absolute duration-300 top-3 left-7 -z-1 origin-0 text-gray-500 dark:text-slate-100">Amount</label>
                                        </div>
                                        <!-- Amount-End -->
                                
                                        <button 
                                            id="button"
                                            type="submit"
                                            name="submit"
                                            class="rounded w-full px-6 py-3 overflow-hidden group text-lg bg-primary shadow-lg shadow-primary/50 relative hover:bg-gradient-to-r hover:from-primary hover:to-green-500 text-white hover:ring-2 hover:ring-offset-2 hover:ring-green-400 transition-all ease-out duration-300">
                                            <span class="absolute right-0 w-8 h-32 -mt-12 transition-all duration-1000 transform translate-x-12 bg-white opacity-10 rotate-12 group-hover:-translate-x-[28rem] ease"></span>
                                            <span class="relative">Add</span>
                                        <button/>
                                    </form>
                                </div>

                            </div>
                            <!-- Transaction Form - End -->

                            <!-- Add Transaction Button -->
                            <div class="fixed right-8 bottom-8">
                                <button @click="transactionForm = true" class="rounded-full p-3 lg:p-5 shadow-lg shadow-primary/50 overflow-hidden group bg-primary relative hover:bg-gradient-to-r hover:from-primary hover:to-green-500 text-white hover:ring-2 hover:ring-offset-2 hover:ring-green-400 transition-all ease-out duration-300">
                                    <span class="absolute right-0 w-8 h-32 -mt-12 transition-all duration-1000 transform translate-x-12 bg-white opacity-10 rotate-12 group-hover:-translate-x-40 ease"></span>
                                    <span class="relative">
                                        <svg viewBox="0 0 24 24" class="w-7 h-7 lg:w-10 lg:h-10" xmlns="http://www.w3.org/2000/svg" fill="#000000">
                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                            <g id="SVGRepo_iconCarrier">
                                                <g id="Complete">
                                                    <g data-name="add" id="add-2">
                                                        <g>
                                                            <line fill="none" stroke="#ffffff" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" x1="12" x2="12" y1="19" y2="5"></line>
                                                            <line fill="none" stroke="#ffffff" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" x1="5" x2="19" y1="12" y2="12"></line> 
                                                        </g> 
                                                    </g> 
                                                </g> 
                                            </g>
                                        </svg>
                                    </span>
                                <button/>
                            </div>
                            <!-- Add Transaction Button -->
                        </div>
                            
                        </div>
                    </span>
                </section>
            </div>

        <script src="../../src/js/transaction.js"></script>
        <script src="../../src/js/TWE.js" type="module/javascript"></script>
        <script type="text/javascript" src="../../node_modules/tw-elements/dist/js/tw-elements.umd.min.js"></script>
        <script src="../../src/js/main.js"></script>
    </body>
</html>
