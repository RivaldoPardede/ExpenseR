<?php
    session_start();

    if(!isset($_SESSION['email'])) {
        header("Location: ../index.php");
        exit;
    }
    
    include '../../src/php/koneksi.php';

    if(isset($_SESSION['email'])){
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
                                                
                                                <div class="text-<?php if($total >= 0){echo "green";} else{echo "rose";} ?>-500 font-semibold">
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
    
                            <h3 class="text-xl mt-8 font-medium text-slate-700 drop-shadow-2xl dark:text-slate-100 text-center">Your Last Transaction</h3>
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
                                                        $category = pg_fetch_array($searchCategory)[0];?>
                                                         
                                                <tr>
                                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-slate-200 dark:border-slate-500">
                                                        <div class="flex items-center">
                                                            <div class="flex-shrink-0 w-10 h-10">
                                                                <svg class="w-8 h-8" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512.002 512.002" xml:space="preserve" fill="#000000">
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
                                                                </svg>
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
                                                        class="px-6 py-4 text-sm leading-5 text-<?php if($row["transaction_type"] == "Expense"){echo "rose";} elseif ($row["transaction_type"] == "Income"){echo "green";} ?>-500 font-semibold whitespace-no-wrap border-b border-slate-200 dark:border-slate-500">
                                                        <?php
                                                            $oldAmountFormat = $row["amount"];
                                                            $newFormattedAmount = "Rp. " . number_format($oldAmountFormat, 0, '.', ',');
                                                            echo $newFormattedAmount;
                                                        ?>
                                                    </td>

                                                    <td
                                                        class="px-6 py-4 text-sm font-medium leading-5 text-right whitespace-no-wrap border-b border-slate-200 dark:border-slate-500">
                                                        <button @click="editTransaction = true" class="text-indigo-600 hover:text-indigo-900">Edit</button>
                                                    </td>
                                                    <td
                                                        class="px-6 py-4 text-sm font-medium leading-5 text-right whitespace-no-wrap border-b border-slate-200 dark:border-slate-500">
                                                        <button class="text-red-600 hover:text-red-900">Delete</button>
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
                            <div :class="editTransaction ? 'block' : 'hidden'" @click="editTransaction = false" class="fixed inset-0  transition-opacity bg-black opacity-50  h-screen"></div>
                            <div :class="editTransaction ? 'translate-x-0 ease-out' : '-translate-x-full ease-in'" class="min-h-screen h-screen w-full inline-block absolute align-middle top-[30%] bg-transparent sm:p-12 max-w-full items-center">
                                <div class=" max-w-md px-6 py-12 bg-white dark:bg-slate-600 border-0 shadow-xl z-50  mx-auto rounded-xl sm:rounded-3xl">
                                    <h1 class="text-2xl font-bold mb-8 text-center dark:text-slate-100">Edit Transaction</h1>
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
                                            <label for="select" class="absolute duration-300 top-3 -z-1 origin-0 text-gray-500 dark:text-slate-100" dark:text-slate-100>Change Category</label>
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
                                                <label for="date" class="absolute duration-300 top-3 -z-1 origin-0 text-gray-500 dark:text-slate-100">Change Date</label>
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
                                            <label for="description" class="absolute duration-300 top-3 -z-1 origin-0 text-gray-500 dark:text-slate-100">Change description</label>
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
                                            <label for="select" class="absolute duration-300 top-3 -z-1 origin-0 text-gray-500 dark:text-slate-100">Change Type</label>
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
                                            <label for="money" class="absolute duration-300 top-3 left-7 -z-1 origin-0 text-gray-500 dark:text-slate-100">Change Amount</label>
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
