<?php
    require('../config.php');
?>
<!doctype html>
<html lang="zh">
<head>
    <meta charset="utf-8">
    <title>admin</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
<?php
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $dish = mysql_fetch_array(mysql_query("SELECT * FROM dish WHERE id = ".$_GET['id'].";"));
    } else {
        header("Location: ".$config_basedir."admin/cate.php");
        exit();
    }
    $cate = mysql_query("SELECT * FROM dishcate;");
?>
    <form action="" method="post">
        <?php
            while ($cate_row = mysql_fetch_array($cate)) {
                if ($cate_row['id'] == $dish['dishcate']) {
                    echo '<input type="radio" name="cate" value="'.$cate_row.'" checked><span>'.$cate_row['cate'].'</span>';
                } else {
                    echo '<input type="radio" name="cate" value="'.$cate_row.'"><span>'.$cate_row['cate'].'</span>';
                }
            }
            echo '<input type="text" name="name" value="'.$dish['name'].'">';
            echo '<input type="text" name="price" value="'.$dish['price'].'">';
            if (!$dish['spec']) {
                echo '<input type="radio" name="spec" value="1"><span>特价</span>';
                echo '<span>原价</span><input type="text" name="oriprice" value="'.$dish['oriprice'].'" style="display: none;">';
                echo '<input type="radio" name="spec" value="0" checked><span>取消特价</span>';
            } else {
                echo '<input type="radio" name="spec" value="1" checked><span>特价</span>';
                echo '<span>原价</span><input type="text" name="oriprice" value="'.$dish['oriprice'].'">';
                echo '<input type="radio" name="spec" value="0"><span>取消特价</span>';
            }
            if ($dish['reco']) {
                echo '<input type="radio" name="reco" value="1" checked><span>推荐</span>';
                echo '<input type="radio" name="reco" value="0"><span>不推荐</span>';
            } else {
                echo '<input type="radio" name="reco" value="1"><span>推荐</span>';
                echo '<input type="radio" name="reco" value="0" checked><span>不推荐</span>';
            }
        ?>
    </form>
</body>