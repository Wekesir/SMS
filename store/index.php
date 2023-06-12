<!DOCTYPE html>
<html>
    <head>
        <?php 
        require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';
        include '../store/header.php';
        $count=1;
        ?>
        <style>
        #menu-content-div{
            max-height: 83.5vh;
            overflow-y: auto;
        }
        </style>
    </head>
    <body>
     <?php include '../store/navigation.php'; ?>
        <div id="menuDiv">
            <ul>
                <li class="main_list"><a href="/school/store/index.php" title="View Items in store">View Store</a></li>       
                <li class="main_list"><a href="/school/store/index.php?add=1" title="Add a new item that does not exist already.">Add Item</a> </li>
                <li class="main_list"><a href="/school/store/index.php?issueItem=1" title="Give out an item from store.">Issue Item</a></li>
                <li class="main_list"><a  href="/school/store/index.php?borrowedItems=1">Borrowed Items</a></li>
                <li class="main_list"><a href="/school/store/index.php?restockedItems=1" title="Check out all items that have been restocked.">Restocked Items</a></li>
                <li class="main_list"><a href="/school/store/index.php?suppliers">Suppliers</a></li>
                <li class="main_list"><a href="/school/store/index.php?addSupplier" title="Add a new supplier that does not exist already."> Add Supplier.</a></li>
            </ul>
        </div>
        <div class="container-fluid" id="menu-content-div">            
            <?php
                if(isset($_REQUEST['borrowedItems'])){
                    include '../store/borrowed-items.php';
                }else{
                if(isset($_REQUEST['suppliers'])){
                      include '../store/suppliers.php';
                }else{
                if(isset($_REQUEST['restockedItems']) && $_REQUEST['restockedItems']==1){
                     include '../store/restockeditems.php';
                }else{
                if(isset($_REQUEST['issueItem']) && $_REQUEST['issueItem']==1){
                     include '../store/issueitem.php';
                }else{
                if(isset($_REQUEST['addSupplier']) || isset($_REQUEST['editSupplier']) && $_REQUEST['editSupplier']>0){
                    include '../store/addsupplier.php';
                }else{
                if(isset($_REQUEST['add'])&& $_REQUEST['add']==1 ||isset($_REQUEST['editItem'])&& $_REQUEST['editItem']!=0){
                    include '../store/additem.php';
                }else{
                    include '../store/home.php';
                }}}}}}
            ?>
        </div>      
    </body>
</html>
