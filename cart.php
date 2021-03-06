<?php
    require('header.php');
    if (!isset($_SESSION["USERID"])) {
        header("Location: ".$config_basedir);
        exit();
    }
    echo '<link rel="stylesheet" href="css/cart.css">';
?>
<form action="order.php" method="post" onsubmit="return calculate.checkNull();">
<section id="cart-sec">
    <?php
        $cart_sql = "SELECT cart.*, dish.* FROM cart, dish WHERE userid = ".$_SESSION["USERID"]." AND cart.dishid = dish.id ORDER BY cart.id DESC;";
        $cart_result = $mysqli->query($cart_sql);
        while ($cart_row = $cart_result->fetch_array()) {
            ?>
            <div class="cart-box" data-num="<?php echo $cart_row["num"]; ?>" data-price="<?php echo $cart_row["price"]; ?>" data-cartid="<?php echo $cart_row[0]; ?>" data-dishid="<?php echo $cart_row[5]; ?>">
                <div class="check">
                    <input type="checkbox" name="checkdish[]" class="checkbox" value="<?php echo $cart_row[5]; ?> <?php echo $cart_row['num']; ?>">
                </div>
                <div class="cart-image" style="background-image: url(<?php echo $cart_row['image']; ?>);"></div>
                <div class="cart-info">
                    <div class="dish-info">
                        <a href="detail.php?id=<?php echo $cart_row["dishid"]; ?>">
                            <div class="dish-name">
                                <h3><?php echo $cart_row["name"]; ?></h3>
                                <p><?php echo $cart_row["sketch"]; ?></p>
                            </div>
                            <div class="dish-price">
                                <p><?php echo $cart_row["price"]; ?><span class="yuan">元</span></p>
                                <p class="dish-num">x<?php echo $cart_row["num"]; ?></p>
                            </div>
                        </a>
                        <input type="button" class="edit-btn" value="编辑">
                    </div>
                    <div class="edit-box">
                        <div class="edit-num">
                            <input type="button" class="subtract-btn" value="-">
                            <input type="button" class="num-now" value="<?php echo $cart_row["num"]; ?>">
                            <input type="button" class="plus-btn" value="+">
                            <input type="button" class="delete-btn" value="&#xe620;">
                        </div>
                        <input type="button" class="finish-btn" value="完成">
                    </div>
                </div>
            </div>
            <?php
        }
    ?>
</section>
<div class="occupy"></div>
<footer>
    <input type="checkbox" id="check-all"><span> 全选</span>
    <input type="submit" id="submit" value="结算">
    <p>合计: <span id="sum-price">0</span><span class="yuan">元</span></p>
</footer>
</form>
<script src="js/cart.js"></script>
<?php
    require('footer.php');
?>