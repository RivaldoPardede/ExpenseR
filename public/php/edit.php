<?php
    session_start();
    include '../../src/php/koneksi.php';

    if(!isset($_SESSION['email'])) {
        header("Location: ../index.php");
        exit;
    }
    
    $id = $_GET["id"];

    if(isset($_POST["submit"])) {
        $categoryId = $_POST["category"];

        $dateString = $_POST["date"];
        $date = DateTime::createFromFormat('d-m-Y', $dateString);
        $formattedDate = $date->format('Y-m-d');

        $description = $_POST["description"];
        $type = $_POST["type"];
        $amount = $_POST["amount"];
        
        $editQuery = pg_query($connection, 
            "UPDATE transaksi SET 
                amount = '$amount',
                transaction_date = '$formattedDate',
                transaction_type = '$type',
                description = '$description',
                category_id = '$categoryId'
            WHERE id = '$id'");
        echo "<script>window.location.href = 'transaction.php'</script>";
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="../css/style.css" />
        <title>Edit Data</title>
    </head>
    <body class="bg-slate-200 transition duration-300 transform">
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>

    <div class="flex h-screen rounded-r-xl">
        <section id="main" class="flex-1 w-full ">
            <span>
                <div class="relative">
                    <div class=" absolute top-[220px] lg:top-[110px] left-0 right-0  px-6 pt-8 m-auto">
                        <div class=" max-w-md px-6 py-12 my-auto  bg-white dark:bg-slate-600 border-0 shadow-xl shadow-slate-500/50 z-50 mx-auto rounded-xl sm:rounded-3xl">
                            <h1 class="text-2xl font-bold mb-8 text-center dark:text-slate-100">Edit Transaction</h1>
                            <?php 
                                
                                
                            $transaction = pg_fetch_assoc(pg_query($connection, "SELECT * FROM transaksi WHERE id = '$id'"));
                            ?>
                            <form id="form" method="post" action="">
                            <!-- Category-Start -->
                                <div class="relative z-0 w-full mb-5">
                                    <select
                                    name="category"
                                    onclick="this.setAttribute('value', this.value);"
                                    required
                                    autocomplete="false"
                                    class="pt-3 pb-2 block w-full px-0 mt-0 border-0 border-b-2 bg-transparent appearance-none z-1 focus:outline-none focus:ring-0 focus:border-black dark:focus:border-white border-gray-200"
                                    >
                                        <option value="" disabled hidden></option>
                                        <?php
                                            $category_id = $transaction["category_id"];
                                            $category = pg_fetch_all(pg_query($connection, 'SELECT * FROM category'));
                                            foreach( $category as $row ):
                                                if($row['id'] == $category_id):
                                        ?>
                                        <option value="<?= $row['id'] ?>" selected><?=$row['category_type']?></option>
                                        <?php
                                                else:
                                        ?>
                                        <option value="<?= $row['id'] ?>"><?=$row['category_type']?></option>
                                        <?php
                                                endif;
                                            endforeach;
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
                                        value="<?php 
                                                    $oldDateFormat = $transaction["transaction_date"];
                                                    $newDateFormat = date("d-m-Y", strtotime($oldDateFormat));
                                                    echo $newDateFormat; 
                                                ?>"
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
                                        value="<?= $transaction["description"] ?>"
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
                                        onclick="this.setAttribute('value', this.value);"
                                        required
                                        autocomplete="off"
                                        class="pt-3 pb-2 block w-full px-0 mt-0 bg-transparent border-0 border-b-2 appearance-none z-1 focus:outline-none focus:ring-0 focus:border-black dark:focus:border-white border-gray-200">
                                        <option value="" disabled hidden></option>
                                        <option value="Expense" <?php if($transaction["transaction_type"] == "Expense"){echo "selected";} ?>>Expense</option>
                                        <option value="Income" <?php if($transaction["transaction_type"] == "Income"){echo "selected";} ?>>Income</option>
                                    </select>
                                    <label for="select" class="absolute duration-300 top-3 -z-1 origin-0 text-gray-500 dark:text-slate-100">Change Type</label>
                                </div>
                                <!-- Type-End -->
                                                            
                                <!-- Amount-Start -->
                                <div class="relative z-0 w-full mb-5">
                                    <input
                                        type="number"
                                        name="amount"
                                        value="<?= $transaction["amount"] ?>"
                                        placeholder=""
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
                            <?php 
                                    
                            ?>
                        </div>
                    </div>
                </div>
            </span>
        </section>
    </div>
                        
        <script src="../../src/js/TWE.js" type="module/javascript"></script>
        <script type="text/javascript" src="../../node_modules/tw-elements/dist/js/tw-elements.umd.min.js"></script>
        <!-- <script src="../../src/js/main.js"></script> -->
    </body>
</html>