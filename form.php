<?php

$mysqli = new mysqli("localhost", "root", "root", "transformer");

if ($_POST["price"] == 'retail_price') {
    $sell = $_GET['retail_price'] ? $mysqli->real_escape_string(trim($_GET['retail_price'])) : '';
    $sell = $_POST['sell'];
    $sellTWO = $sell;
    $sellTWO = $_POST['sellTWO'];
    $quantity = $_GET['product_availability_in_stock_one'] and $_GET['product_availability_in_stock_two'] ? $mysqli->real_escape_string(trim($_GET['product_availability_in_stock_one'] and $_GET['product_availability_in_stock_two'])) : '';
    $quantity = $_POST["quantity"];
    if ($_POST["selectTWO"] == "more") {
        $result = $mysqli->prepare("SELECT * FROM `product` WHERE `retail_price` >= ? AND `retail_price` <= ? AND `product_availability_in_stock_one` AND `product_availability_in_stock_two` >= ?");
    } else {
        $result = $mysqli->prepare("SELECT * FROM `product` WHERE `retail_price` >= ? AND `retail_price` <= ? AND `product_availability_in_stock_one` AND `product_availability_in_stock_two` <= ?");
    };
    $result->bind_param("iii", $sell, $sellTWO, $quantity);
    $result->execute();
    $result = $result->get_result();
} else {
    $sell = $_GET['wholesale_price'] ? $mysqli->real_escape_string(trim($_GET['wholesale_price'])) : '';
    $sell = $_POST['sell'];
    $sellTWO = $sell;
    $sellTWO = $_POST['sellTWO'];
    $quantity = $_GET['product_availability_in_stock_one'] and $_GET['product_availability_in_stock_two'] ? $mysqli->real_escape_string(trim($_GET['product_availability_in_stock_one'] and $_GET['product_availability_in_stock_two'])) : '';
    $quantity = $_POST["quantity"];
    if ($_POST["selectTWO"] == "more") {
        $result = $mysqli->prepare("SELECT * FROM `product` WHERE `wholesale_price` >= ? AND `wholesale_price` <= ? AND `product_availability_in_stock_one` AND `product_availability_in_stock_two` >= ?");
    } else {
        $result = $mysqli->prepare("SELECT * FROM `product` WHERE `wholesale_price` >= ? AND `wholesale_price` <= ? AND `product_availability_in_stock_one` AND `product_availability_in_stock_two` <= ?");
    };
    $result->bind_param("iii", $sell, $sellTWO, $quantity);
    $result->execute();
    $result = $result->get_result();
};
?>

<table class="table table-striped">
    <thead>
        <tr>
            <th>Наименование товара</th>
            <?php
            if ($_POST["price"] == 'retail_price') : ?>
                <th>Розничная цена</th>
            <?php endif; ?>
            <?php
            if ($_POST["price"] == 'wholesale_price') : ?>
                <th>Оптовая цена</th>
            <?php endif; ?>
            <th>Наличие на складе 1</th>
            <th>Наличие на складе 2</th>
            <th>Cтрана производитель</th>
        </tr>
    </thead>
    <tbody>
        <?php
        while ($row = $result->fetch_assoc()) : ?>
            <tr>
                <td>
                    <? echo $row["name"]; ?>
                </td>
                <?php
                if ($_POST["price"] == 'retail_price') : ?>
                    <td>
                        <? echo $row["retail_price"]; ?>
                    </td>
                <?php endif; ?>
                <?php
                if ($_POST["price"] == 'wholesale_price') : ?>
                    <td>
                        <? echo $row["wholesale_price"]; ?>
                    </td>
                <?php endif; ?>
                <td>
                    <? echo $row["product_availability_in_stock_one"]; ?>
                </td>
                <td>
                    <? echo $row["product_availability_in_stock_two"]; ?>
                </td>
                <td>
                    <? echo $row["made_in"]; ?>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>