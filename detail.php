<?php
    require('header.php');
    echo '<link rel="stylesheet" href="css/detail.css">';
    if (!isset($_GET['id']) && !is_numeric($_GET['id'])) {
        header("Location: ".$config_basedir);
        exit();
    }
    $_SESSION['DISHID'] = $_GET['id'];
    $dish_sql = "SELECT * FROM dish WHERE id = ".$_GET['id'].";";
    $dish_row = $mysqli->query($dish_sql)->fetch_array();

    echo '<img src="'.$dish_row['image'].'"><section id="brief"><h3>'.$dish_row['name'].'</h3><p class="all-skecth">'.$dish_row['sketch'].'</p><div class="clear"><p class="all-price">'.$dish_row['price'].'<span class="yuan">元</span></p><p class="sell-num">已售'.$dish_row["sellnum"].'份</p></div>';
?>
    <form action="order.php" method="post">
        <input type="checkbox" name="checkdish[]" value="<?php echo $_GET['id']; ?> 1" checked style="display: none;">
        <input type="submit" class="button" id="now-buy" value="立即购买">
    </form>
    <div class="button" id="add-cart">加入购物车</div>
</section>
<section id="detail-box">
    <nav>
        <ul>
            <li id="show-detail" class="now-box">详情</li>
            <li id="show-evaluate">评价</li>
        </ul>
    </nav>
    <div id="detail">
        <?php
            echo $dish_row["details"];
        ?>
    </div>
    <?php
        $eva_sql = "SELECT * FROM evaluate WHERE dishid = ".$_GET["id"]." ORDER BY id DESC;";
        $eva_result = $mysqli->query($eva_sql);
        $sum = 0;
        $star1 = 0;
        $star2 = 0;
        $star3 = 0;
        $star4 = 0;
        $star5 = 0;
        while ($eva_row = $eva_result->fetch_array()) {
            switch ($eva_row['star']) {
                case 1:
                    $star1++;
                    break;
                case 2:
                    $star2++;
                    break;
                case 3:
                    $star3++;
                    break;
                case 4:
                    $star4++;
                    break;
                case 5:
                    $star5++;
                    break;
                default:
                    break;
            }
            $sum++;
        }
        $average = (!$sum) ? 0 : ($star1 + $star2*2 + $star3*3 + $star4*4 + $star5*5)/$sum;
        $average = round($average, 1);
        $star = array($star1, $star2, $star3, $star4, $star5);
        sort($star);
        $star1_len = (!$star[4]) ? 0 : ($star1/$star[4])*50;
        $star2_len = (!$star[4]) ? 0 : ($star2/$star[4])*50;
        $star3_len = (!$star[4]) ? 0 : ($star3/$star[4])*50;
        $star4_len = (!$star[4]) ? 0 : ($star4/$star[4])*50;
        $star5_len = (!$star[4]) ? 0 : ($star5/$star[4])*50;
    ?>
    <div id="evaluate">
        <div class="graph">
            <div class="total-box">
                <p class="total-point"><?php echo $average; ?></p>
                <div class="total">
                    <p class="star"><?php
                        for ($i = 0; $i < 5; $i++) {
                            if ($i < $average && $i < floor($average)) {
                                echo "&#xe8f2;";
                            } else if ($i < $average && $i == floor($average)) {
                                echo "&#xe8f3;";
                            } else {
                                echo "&#xe8f4;";
                            }
                        }
                    ?></p>
                    <p><?php echo $sum; ?><span class="person">&#xe8e5;</span></p>
                </div>
            </div>
            <div class="e-total">
                <div class="star-num">&#xe8f2;&#xe8f2;&#xe8f2;&#xe8f2;&#xe8f2;</div>
                <div class="graph-trip" id="graph1" style="width: <?php echo $star5_len; ?>%;"></div>
                <p class="p-num"><?php echo $star5; ?></p>
            </div>
            <div class="e-total">
                <div class="star-num">&#xe8f2;&#xe8f2;&#xe8f2;&#xe8f2;</div>
                <div class="graph-trip" id="graph2" style="width: <?php echo $star4_len; ?>%;"></div>
                <p class="p-num"><?php echo $star4; ?></p>
            </div>
            <div class="e-total">
                <div class="star-num">&#xe8f2;&#xe8f2;&#xe8f2;</div>
                <div class="graph-trip" id="graph3" style="width: <?php echo $star3_len; ?>%;"></div>
                <p class="p-num"><?php echo $star3; ?></p>
            </div>
            <div class="e-total">
                <div class="star-num">&#xe8f2;&#xe8f2;</div>
                <div class="graph-trip" id="graph4" style="width: <?php echo $star2_len; ?>%;"></div>
                <p class="p-num"><?php echo $star2; ?></p>
            </div>
            <div class="e-total">
                <div class="star-num">&#xe8f2;</div>
                <div class="graph-trip" id="graph5" style="width: <?php echo $star1_len; ?>%;"></div>
                <p class="p-num"><?php echo $star1; ?></p>
            </div>
        </div>
        <div class="eva-box">
            <?php
                $eva_sql = "SELECT evaluate.*, user.* FROM evaluate, user WHERE evaluate.dishid = ".$_GET["id"]." AND evaluate.userid = user.id ORDER BY evaluate.id DESC;";
                $eva_result = $mysqli->query($eva_sql);
                $star_arr = array('', '&#xe8f2;&#xe8f4;&#xe8f4;&#xe8f4;&#xe8f4;', '&#xe8f2;&#xe8f2;&#xe8f4;&#xe8f4;&#xe8f4;', '&#xe8f2;&#xe8f2;&#xe8f2;&#xe8f4;&#xe8f4;', '&#xe8f2;&#xe8f2;&#xe8f2;&#xe8f2;&#xe8f4;', '&#xe8f2;&#xe8f2;&#xe8f2;&#xe8f2;&#xe8f2;');
                while ($eva_row = $eva_result->fetch_array()) {
                    echo '<dl class="eva-dl"><dt class="eva-dt"><span class="head-image">&#xe8e7;</span><div class="user-info"><p class="name">'.$eva_row["username"].'</p><p class="info"><span class="user-star">'.$star_arr[$eva_row["star"]].'</span> <span class="time">'.date('Y-m-d', strtotime($eva_row["createtime"])).'</span></p></div></dt><dd class="eva-dd">'.$eva_row["content"].'</dd></dl>';
                }
            ?>
        </div>
    </div>
</section>
<script src="js/detail.js"></script>
<?php
    require('footer.php');
?>