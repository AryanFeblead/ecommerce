<?php

require ('function.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['actionName']) && $_POST['actionName'] == 'view_data') {
        view_data();
    }
    if (isset($_POST['actionName']) && $_POST['actionName'] == 'fruit_data') {
        fruit_data();
    }
    if (isset($_POST['actionName']) && $_POST['actionName'] == 'vegetable_data') {
        vegetable_data();
    }
    if (isset($_POST['actionName']) && $_POST['actionName'] == 'searchbar_data') {
        searchbar_data();
    }
    if (isset($_POST['actionName']) && $_POST['actionName'] == 'lowtohigh_data') {
        lowtohigh_data();
    }
    if (isset($_POST['actionName']) && $_POST['actionName'] == 'hightolow_data') {
        hightolow_data();
    }
    if (isset($_POST['actionName']) && $_POST['actionName'] == 'atoz_data') {
        atoz_data();
    }
    if (isset($_POST['actionName']) && $_POST['actionName'] == 'ztoa_data') {
        ztoa_data();
    }
    if (isset($_POST['actionName']) && $_POST['actionName'] == 'add_cart_data') {
        add_cart_data();
    }
    if (isset($_POST['actionName']) && $_POST['actionName'] == 'add_cart_delete') {
        add_cart_delete();
    }
    if (isset($_POST['actionName']) && $_POST['actionName'] == 'update_cart_quantity') {
        update_cart_quantity();
    }
    if (isset($_POST['actionName']) && $_POST['actionName'] == 'all_search') {
        all_search();
    }
    if (isset($_POST['actionName']) && $_POST['actionName'] == 'checkout') {
        checkout();
    }
}
