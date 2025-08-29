<?php
    if (!defined('pp_allowed_access')) {
        die('Direct access not allowed');
    }
    
    if(isset($_GET['cancel'])){
        pp_set_transaction_status($payment_id, 'failed');
    }
    
    // Load the admin UI rendering function
    function vercel_checkout_load($payment_id) {
        $transaction_details = pp_get_transation($payment_id);
        $setting = pp_get_settings();
        $faq_list = pp_get_faq();
        $support_links = pp_get_support_links();
        
        if($transaction_details['response'][0]['transaction_status'] == "initialize"){
            if(isset($_GET['method'])){
                $raw_method = $_GET['method'];
                $clean_method = explode('/', $raw_method)[0];
                
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    
                }else{
                    echo '
                    <style>
                        .list-unstyled li {
                            height: auto !important;
                            min-height: 40px;
                            font-size: 15px;
                            align-items: center;
                        }
                    </style>';
                }
                
                payment_gateway_include($clean_method, $payment_id);
            }else{
                $viewFile = __DIR__ . '/views/'.$transaction_details['response'][0]['transaction_status'].'-ui.php';
        
                if (file_exists($viewFile)) {
                    include $viewFile;
                } else {
                    echo "<div class='alert alert-warning'>Checkout UI not found.</div>";
                }
            }
        }else{
            $viewFile = __DIR__ . '/views/'.$transaction_details['response'][0]['transaction_status'].'-ui.php';
    
            if (file_exists($viewFile)) {
                include $viewFile;
            } else {
                echo "<div class='alert alert-warning'>Checkout UI not found.</div>";
            }
        }
    }
    
    
    // Load the admin UI rendering function
    function vercel_admin_page() {
        $viewFile = __DIR__ . '/views/admin-ui.php';
    
        if (file_exists($viewFile)) {
            include $viewFile;
        } else {
            echo "<div class='alert alert-warning'>Admin UI not found.</div>";
        }
    }
?>