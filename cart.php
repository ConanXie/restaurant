<?php
    require('header.php');
    if (!isset($_SESSION["USERID"])) {
        header("Location: ".$config_basedir);
        exit();
    }
    echo '<link rel="stylesheet" href="css/cart.css">';
?>
<section id="cart-box">
    <div class="cart-box">
        <div class="check">
            <input type="checkbox">
        </div>
        <div class="cart-image"></div>
        <div class="cart-info">
            <div class="dish-info">
                <div class="dish-name">
                    <h3>水煮鱼</h3>
                    <p>水煮鱼是什么</p>
                </div>
                <div class="dish-price">
                    <p>30<span class="yuan">元</span></p>
                    <p class="dish-num">x1</p>
                </div>
                <input type="button" value="编辑">
            </div>
            <div class="edit-box">
                <div class="edit-num">
                    <input type="button" value="-" onclick="a.subtractNum()">
                    <input type="button" value="1" id="num">
                    <input type="button" value="+" onclick="a.addNum()">
                    <input type="button" value="删除">
                    <input type="button" value="完成">
                </div>
            </div>
        </div>
    </div>
</section>
<footer>
    <input type="checkbox" id="check-all">全选
</footer>
<script src="js/cart.js"></script>
<?php
    require('footer.php');
?>