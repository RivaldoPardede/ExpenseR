<?php
    session_start();

    if(!isset($_SESSION['email'])) {
        header("Location: ../index.php");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/style.css">
        <link rel="icon" href="../assets/Xpenser_Logo.png" type="image/icon type">
        <title>Account</title>
    </head>
    <body class="bg-slate-100 dark:bg-slate-800 transition duration-300 transform">
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
        
            <div x-data="{ sidebarOpen: false }" class="flex h-screen rounded-r-xl">
                <!-- Sidebar-Start -->
                <section id="sidebar">
                    <div :class="sidebarOpen ? 'block' : 'hidden'" @click="sidebarOpen = false" class="fixed inset-0 z-20 transition-opacity bg-black opacity-50 lg:hidden h-screen"></div>
                    <div :class="sidebarOpen ? 'translate-x-0 ease-out' : '-translate-x-full ease-in'" class="fixed rounded-r-xl inset-y-0 left-0 z-30 w-64 overflow-y-auto transition duration-200 transform bg-white h-screen dark:bg-slate-700 lg:translate-x-0 lg:static lg:inset-0 shadow-xl">
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
                            <a class="flex my-5 items-center font-semibold px-6 py-2 mt-1 text-black dark:text-white rounded-xl mx-5 hover:bg-primary hover:opacity-50"
                                href="transaction.php">
                                <svg viewBox="0 0 1024 1024" width="24" height="24" class="icon" version="1.1" xmlns="http://www.w3.org/2000/svg" fill="#000000">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <path d="M533 1024l-147.7-84.8-136.4 78.3h-11.3c-17.3 0-34.2-3.4-50.1-10.1-15.3-6.5-29.1-15.7-40.8-27.6-11.7-11.7-21-25.5-27.5-40.8-6.7-15.9-10.1-32.7-10.1-50.1V128.5c0-17.4 3.4-34.2 10.1-50.1 6.5-15.3 15.8-29.1 27.6-40.8 11.7-11.8 25.5-21 40.8-27.5C203.3 3.4 220.2 0 237.5 0h590.9c17.3 0 34.2 3.4 50.1 10.1 15.3 6.5 29.1 15.7 40.8 27.6 11.7 11.7 21 25.5 27.5 40.8 6.7 15.9 10.1 32.7 10.1 50.1V889c0 17.4-3.4 34.2-10.1 50.1-6.5 15.3-15.8 29.1-27.6 40.8-11.7 11.8-25.5 21-40.8 27.5-15.8 6.7-32.7 10.1-50 10.1h-11.3l-136.4-78.3L533 1024z m147.7-182.6l157.2 90.3c2.5-0.6 5-1.4 7.5-2.4 5.2-2.2 9.9-5.4 13.9-9.4 4.1-4.1 7.2-8.7 9.4-14 2.3-5.3 3.4-11.1 3.4-17V128.5c0-5.9-1.1-11.7-3.4-17-2.2-5.2-5.4-9.9-9.4-13.9-4.1-4.1-8.7-7.2-13.9-9.4-5.4-2.3-11.1-3.4-17-3.4H237.5c-5.9 0-11.6 1.1-17 3.4-5.2 2.2-9.9 5.4-13.9 9.4-4.1 4.1-7.2 8.7-9.4 14-2.3 5.3-3.4 11.1-3.4 17V889c0 5.9 1.1 11.7 3.4 17 2.2 5.2 5.4 9.9 9.4 13.9 4.1 4.1 8.7 7.2 13.9 9.4 2.4 1 4.9 1.8 7.5 2.4l157.2-90.3L533 926.2l147.7-84.8z" fill="#000000" class="dark:fill-white"></path>
                                        <path d="M490.6 310.9H321c-23.4 0-42.4-19-42.4-42.4s19-42.4 42.4-42.4h169.6c23.4 0 42.4 19 42.4 42.4s-19 42.4-42.4 42.4zM702.5 487.6H321c-23.4 0-42.4-19-42.4-42.4s19-42.4 42.4-42.4h381.6c23.4 0 42.4 19 42.4 42.4-0.1 23.4-19 42.4-42.5 42.4z" fill="#1eae2e">
                                        </path>
                                    </g>
                                </svg>
                                <span class="mx-3">Transaction</span>
                            </a>
                            <a class="flex my-5 items-center font-semibold  px-6 py-2 mt-1 text-white bg-primary shadow-lg shadow-primary/50 rounded-xl mx-5"
                                href="account.php">
                                <svg xmlns="http://www.w3.org/2000/svg" class="fill-stroke"  width="24" height="24" fill="none" viewBox="0 0 448 512">
                                    <path fill="black" class="fill-white" d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H418.3c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304H178.3z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
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
                        <h2 class="text-3xl font-semibold mt-4 text-slate-700 pb-3 border-b-2 drop-shadow-2xl dark:text-slate-100 text-center">Account Information</h2>
                        <div class="container flex-col flex px-6 mx-auto" id="accountInfo">
                            <div class="container w-24 h-24 ring ring-primary ring-offset-base-100 ring-offset-2 rounded-full overflow-hidden mx-auto mt-4 bg-white" id="photo">
                                <svg class="w-24 h-24 " version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 329.249 329.249" xml:space="preserve" fill="#000000">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier"> 
                                        <g id="XMLID_7_"> 
                                            <g id="XMLID_62_"> 
                                                <g id="XMLID_1121_"> 
                                                    <path id="XMLID_1122_" style="fill:#F3D8B6;" d="M247.814,233.696c-18.667-6.681-51.458-11.736-51.458-81.376h-29.23h-5.002 h-29.23c0,69.64-32.791,74.695-51.458,81.376c0,47.368,68.832,48.824,80.688,53.239v1.537c0,0,0.922-0.188,2.501-0.68 c1.579,0.492,2.501,0.68,2.501,0.68v-1.537C178.981,282.521,247.814,281.064,247.814,233.696z"></path> 
                                                </g> 
                                                <path id="XMLID_1123_" style="fill:#EEC8A2;" d="M196.356,152.321h-29.23h-2.501v135.472c1.579,0.492,2.501,0.68,2.501,0.68 v-1.537c11.856-4.414,80.688-5.871,80.688-53.238C229.147,227.015,196.356,221.961,196.356,152.321z"></path> 
                                            </g> 
                                            <g id="XMLID_58_"> 
                                                <g id="XMLID_1124_"> 
                                                    <path id="XMLID_1125_" style="fill:#F3DBC4;" d="M164.627,174.483c-27.454,0-48.409-23.119-57.799-40.456 S90.94,54.582,111.168,27.13c19.808-26.883,53.459-13.838,53.459-13.838s33.649-13.045,53.458,13.838 c20.226,27.452,13.726,89.56,4.335,106.897C213.028,151.364,192.075,174.483,164.627,174.483z"></path> 
                                                </g> 
                                                <path id="XMLID_1126_" style="fill:#EDCEAE;" d="M218.085,27.13c-19.81-26.883-53.458-13.838-53.458-13.838h-0.002v161.192 c0.001,0,0.001,0,0.002,0c27.449,0,48.401-23.119,57.794-40.456C231.811,116.69,238.311,54.583,218.085,27.13z"></path> 
                                            </g> 
                                            <g id="XMLID_55_"> 
                                                <ellipse id="XMLID_57_" transform="matrix(0.3543 -0.9351 0.9351 0.3543 46.5967 281.0264)" style="fill:#EDCEAE;" cx="226.798" cy="106.771" rx="17.187" ry="10.048"></ellipse> 
                                                <ellipse id="XMLID_56_" transform="matrix(0.3543 0.9351 -0.9351 0.3543 166.0001 -26.8553)" style="fill:#F3DBC4;" cx="102.447" cy="106.778" rx="17.187" ry="10.048"></ellipse> 
                                            </g> 
                                            <g id="XMLID_51_"> 
                                                <g id="XMLID_1127_"> 
                                                    <path id="XMLID_1128_" style="fill:#B7CAE9;" d="M284.607,288.568v40.681H44.643v-40.681c0-30.431,17.377-56.963,40.605-70.913 c6.043-3.641,19.69-7.43,26.844-9.196c5.953-1.488,53.438,22.729,53.438,22.729s48.674-23.218,54.627-21.729 c7.154,1.766,17.802,4.554,23.844,8.196C267.23,231.605,284.607,258.137,284.607,288.568z"></path> 
                                                </g> <path id="XMLID_1129_" style="fill:#96B3D4;" d="M244.002,217.655c-6.043-3.641-16.69-6.429-23.844-8.196 c-5.953-1.488-54.627,21.729-54.627,21.729s-0.321-0.164-0.906-0.459v98.52h119.982v-40.681 C284.607,258.137,267.229,231.605,244.002,217.655z"></path> 
                                            </g> 
                                            <g id="XMLID_48_"> 
                                                <polygon id="XMLID_1130_" style="fill:#494857;" points="186.292,235.806 164.625,228.973 142.958,235.806 157.272,246.798 148.292,329.249 180.958,329.249 171.978,246.798 "></polygon> 
                                                <polygon id="XMLID_1131_" style="fill:#33333F;" points="186.292,235.806 164.625,228.973 164.625,329.249 180.958,329.249 171.978,246.799 "></polygon> 
                                            </g> 
                                            <g id="XMLID_45_"> 
                                                <path id="XMLID_1132_" style="fill:#DEDDE0;" d="M212.792,204.681l-48.167,23.441l-48.167-23.441 c-11.5,5.5,10.396,38.436,14.833,36.833c10.963-3.96,33.334-10.329,33.334-10.329s22.371,6.369,33.334,10.329 C202.396,243.118,224.292,210.181,212.792,204.681z"></path> 
                                                <path id="XMLID_1133_" style="fill:#DEDDE0;" d="M212.792,204.681l-48.167,23.441v3.063c0,0,22.371,6.369,33.334,10.329 C202.396,243.118,224.292,210.181,212.792,204.681z"></path> 
                                            </g> 
                                            <g id="XMLID_41_"> 
                                                <g id="XMLID_1134_"> 
                                                    <path id="XMLID_1135_" style="fill:#A7B8D4;" d="M206.619,97.84H178.93c-1.185,0-2.356,0.243-3.431,0.713l-10.874,3.873 l-10.874-3.873c-1.075-0.47-2.246-0.713-3.431-0.713h-27.688c-5.509,0-7.411,9.474-7.411,9.474 c0,12.532,9.191,22.692,23.756,22.692c8.882,0,17.409-9.44,22.649-17.081h6c5.24,7.641,13.768,17.081,22.649,17.081 c14.565,0,23.756-10.16,23.756-22.692C214.03,107.314,212.128,97.84,206.619,97.84z"></path> 
                                                </g> 
                                                <path id="XMLID_1136_" style="fill:#8AA4C2;" d="M206.619,97.84H178.93c-1.185,0-2.356,0.243-3.431,0.713l-10.874,3.873v10.5h3 c5.24,7.641,13.768,17.081,22.649,17.081c14.565,0,23.756-10.16,23.756-22.692C214.03,107.314,212.128,97.84,206.619,97.84z"></path> 
                                            </g> 
                                            <g id="XMLID_34_">
                                                 <path id="XMLID_1139_" style="fill:#545465;" d="M221.773,22.976c-2.16,0.019-25.469-13.121-41.382-16.355 c-18.766-3.814-18.777-0.529-26.02,1.516c-29.41-9.014-52.972-15.012-51.927,7.003c1.759,37.07-9.345,65.989-4.863,78.938 s8.466,23.407,8.466,23.407s0.996,3.565,2.988-16.854s-4.579-42.372,11.137-40.379c15.716,1.992,10.785,14.805,44.436,14.805 c33.391,0,28.719-12.813,44.436-14.805c15.716-1.992,9.145,19.96,11.137,40.379s2.988,16.854,2.988,16.854 s3.984-10.458,8.466-23.407C236.119,81.129,241.125,22.806,221.773,22.976z"></path> 
                                                 <path id="XMLID_1142_" style="fill:#494857;" d="M221.773,22.976c-2.16,0.019-25.469-13.121-41.382-16.355 c-7.986-1.624-12.57-1.958-15.766-1.653v70.088c33.372-0.004,28.706-12.813,44.419-14.804c15.716-1.992,9.145,19.96,11.137,40.379 s2.988,16.854,2.988,16.854s3.984-10.459,8.466-23.407C236.119,81.129,241.125,22.807,221.773,22.976z"></path> 
                                                </g> 
                                                <g id="XMLID_8_"> 
                                                    <ellipse id="XMLID_33_" transform="matrix(0.3543 0.9351 -0.9351 0.3543 166.0001 -26.8553)" style="fill:#F3DBC4;" cx="102.447" cy="106.778" rx="17.187" ry="10.048"></ellipse> 
                                                    <ellipse id="XMLID_32_" transform="matrix(0.3543 -0.9351 0.9351 0.3543 46.5967 281.0264)" style="fill:#EDCEAE;" cx="226.798" cy="106.771" rx="17.187" ry="10.048"></ellipse> 
                                                </g> 
                                            </g> 
                                        </g>
                                    </svg>
                            </div>

                            <?php 
                                include '../../src/php/koneksi.php';
                                $data = pg_query($connection, "select * from users");
                                $d = pg_fetch_array($data);
                            ?>

                            <div class="flex justify-center mx-auto flex-wrap w-full sm:w-1/2 lg:w-1/3">
                                <div class="mx-auto mt-5 mb-0 lg:mb-2   px-5 py-3 dark:text-slate-100 shadow-lg shadow-primary/50" id="username">
                                    <h3>Username: <?php echo $d['username']?></h3>
                                </div>
                                <div class="mx-auto mt-5 mb-0 lg:mb-2   px-5 py-3 dark:text-slate-100 shadow-lg shadow-primary/50" id="email">
                                    <h3>Email: <?php echo $d['email']?></h3>
                                </div>
                            </div>
                        </div>

                        <div class="" id="accountSettings">
                            <h3 class="text-2xl font-semibold mt-4 text-slate-700 pb-3 border-b-2 drop-shadow-2xl dark:text-slate-100 text-center">Account Settings</h3>

                            <div class="container flex align-middle items-center mt-5 flex-col">
                                <section class="my-4" id="changeUsername">
                                    <button class="btn rounded px-5 border-none py-2.5 overflow-hidden group bg-primary relative hover:bg-gradient-to-r hover:from-green-500 hover:to-green-400 text-white hover:ring-2 hover:ring-offset-2 hover:ring-green-400 transition-all ease-out duration-300" onclick="my_modal_5.showModal()">Change Username
                                        <span class="absolute right-0 w-8 h-32 -mt-12 transition-all duration-1000 transform translate-x-12 bg-white opacity-10 rotate-12 group-hover:-translate-x-40 ease"></span>
                                    </button>
                                    <dialog id="my_modal_5" class="modal modal-bottom sm:modal-middle">
                                        <div class="modal-box bg-white dark:bg-slate-600">
                                            <h3 class="font-bold text-lg text-slate-800 dark:text-slate-100 pb-5 text-center border-b ">Change Username!</h3>
                                            <div class="modal-action flex flex-shrink w-full justify-center mx-0">
                                                <form method="POST">
                                                    <div class="w-full">
                                                        <label class="form-control w-96">
                                                            <div class="label">
                                                                <span class="label-text font-semibold text-slate-800 dark:text-slate-100">New Username</span>
                                                            </div>
                                                            <input type="text" placeholder="New Username" name="username" required class="input w-full bg-slate-300 dark:bg-slate-100"/>
                                                        </label>
                                                        <label class="form-control w-96">
                                                            <div class="label">
                                                                <span class="label-text font-semibold text-slate-800 dark:text-slate-100">Password</span>
                                                            </div>
                                                            <input type="password" placeholder="Password" name="password" required class="input w-full  bg-slate-300 dark:bg-slate-100" />
                                                        </label>
                                                        <div class="flex mt-4 justify-between">
                                                            <button name="changeUsername" class="btn rounded px-5 border-none py-2.5 overflow-hidden group bg-primary relative hover:bg-gradient-to-r hover:from-green-500 hover:to-green-400 text-white hover:ring-2 hover:ring-offset-2 hover:ring-green-400 transition-all ease-out duration-300 shadow-xl shadow-primary/50" onclick="my_modal_5.showModal()">Save
                                                                <span class="absolute right-0 w-8 h-32 -mt-12 transition-all duration-1000 transform translate-x-12 bg-white opacity-10 rotate-12 group-hover:-translate-x-40 ease"></span>
                                                            </button>
                                                            <a href="account.php" class="btn rounded px-5 border-none py-2.5 overflow-hidden group bg-primary relative hover:bg-gradient-to-r hover:from-green-500 hover:to-green-400 text-white hover:ring-2 hover:ring-offset-2 hover:ring-green-400 transition-all ease-out duration-300 shadow-xl shadow-primary/50" onclick="my_modal_5.showModal()">Cancel
                                                                <span class="absolute right-0 w-8 h-32 -mt-12 transition-all duration-1000 transform translate-x-12 bg-white opacity-10 rotate-12 group-hover:-translate-x-40 ease"></span>
                                                            </a>
                                                        </div>
                                                    </div>

                                                    <?php 
                                                        if (isset($_POST['changeUsername'])) {
                                                            $username = $_POST['username'];
                                                            $password = $_POST['password'];
                                                            $email = $_SESSION['email'];

                                                            if ($password === $d['password']) {
                                                                pg_query($connection, "UPDATE users SET username = '$username' WHERE email = '$email'");
                                                            echo "<script>window.location.href = 'account.php'</script>";    
                                                            } else {
                                                                echo "<script>alert('Wrong PW')</script>";
                                                            }   
                                                        }
                                                    ?>
                                                </form>
                                            </div>
                                        </div>
                                    </dialog>
                                </section>
    
                                <section class="my-4" id="changePassword">
                                    <button class="btn rounded px-5 border-none py-2.5 overflow-hidden group bg-primary relative hover:bg-gradient-to-r hover:from-green-500 hover:to-green-400 text-white hover:ring-2 hover:ring-offset-2 hover:ring-green-400 transition-all ease-out duration-300" onclick="my_modal_6.showModal()">Change Pasword
                                        <span class="absolute right-0 w-8 h-32 -mt-12 transition-all duration-1000 transform translate-x-12 bg-white opacity-10 rotate-12 group-hover:-translate-x-40 ease"></span>
                                    </button>
                                    <dialog id="my_modal_6" class="modal modal-bottom sm:modal-middle">
                                        <div class="modal-box bg-white dark:bg-slate-600">
                                            <h3 class="font-bold text-lg text-slate-800 dark:text-slate-100 pb-5 text-center border-b ">Change Password!</h3>
                                            <div class="modal-action flex flex-shrink w-full justify-center mx-0">
                                                <form method="POST">
                                                    <div class="w-full" id="changePassword">
                                                        <label class="form-control w-96">
                                                            <div class="label">
                                                                <span class="label-text font-semibold text-slate-800 dark:text-slate-100">New Password</span>
                                                            </div>
                                                            <input type="password" placeholder="New Password" name="newPassword" required class="input w-full bg-slate-300 dark:bg-slate-100"/>
                                                        </label>
                                                        <label class="form-control w-96">
                                                            <div class="label">
                                                                <span class="label-text font-semibold text-slate-800 dark:text-slate-100">Old Password</span>
                                                            </div>
                                                            <input type="password" placeholder="Old Password" name="oldPassword" required class="input w-full  bg-slate-300 dark:bg-slate-100" />
                                                        </label>
                                                        <div class="flex mt-4 justify-between">
                                                            <button name="changePassword" class="btn rounded px-5 border-none py-2.5 overflow-hidden group bg-primary relative hover:bg-gradient-to-r hover:from-green-500 hover:to-green-400 text-white hover:ring-2 hover:ring-offset-2 hover:ring-green-400 transition-all ease-out duration-300 shadow-xl shadow-primary/50" onclick="my_modal_6.showModal()">Save
                                                                <span class="absolute right-0 w-8 h-32 -mt-12 transition-all duration-1000 transform translate-x-12 bg-white opacity-10 rotate-12 group-hover:-translate-x-40 ease"></span>
                                                            </button>
                                                            <a href="account.php" class="btn rounded px-5 border-none py-2.5 overflow-hidden group bg-primary relative hover:bg-gradient-to-r hover:from-green-500 hover:to-green-400 text-white hover:ring-2 hover:ring-offset-2 hover:ring-green-400 transition-all ease-out duration-300 shadow-xl shadow-primary/50" onclick="my_modal_6.showModal()">Cancel
                                                                <span class="absolute right-0 w-8 h-32 -mt-12 transition-all duration-1000 transform translate-x-12 bg-white opacity-10 rotate-12 group-hover:-translate-x-40 ease"></span>
                                                            </a>
                                                        </div>
                                                    </div>

                                                    <?php 
                                                        if (isset($_POST['changePassword'])) {
                                                            $newPassword = $_POST['newPassword'];
                                                            $oldPassword = $_POST['oldPassword'];
                                                            $email = $_SESSION['email'];

                                                            if ($oldPassword === $d['password']) {
                                                                pg_query($connection, "UPDATE users SET password = '$newPassword' WHERE email = '$email'");
                                                            echo "<script>window.location.href = 'account.php'</script>";    
                                                            } else {
                                                                echo "<script>alert('Wrong PW')</script>";
                                                            }   
                                                        }
                                                    ?>

                                                </form>
                                            </div>
                                        </div>
                                    </dialog>
                                </section>
    
                                <a href="../index.php" class="btn rounded my-4 px-5 border-none py-2.5 overflow-hidden group bg-primary relative hover:bg-gradient-to-r hover:from-green-500 hover:to-green-400 text-white hover:ring-2 hover:ring-offset-2 hover:ring-green-400 transition-all ease-out duration-300 shadow-xl shadow-primary/50">Log Out
                                    <span class="absolute right-0 w-8 h-32 -mt-12 transition-all duration-1000 transform translate-x-12 bg-white opacity-10 rotate-12 group-hover:-translate-x-40 ease"></span>
                                    <?php
                                        session_destroy();
                                    ?>
                                </a>


                            </div>
                        </div>

                    </span>
                </section>
                <!-- Main-End -->
            </div>
        
        

        <script src="../../src/js/account.js"></script>
        <script src="../../src/js/main.js"></script>
    </body>
</html>