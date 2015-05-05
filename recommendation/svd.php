<?php
    define("MAX_ITERA", 60);
    define("MIN_DOUBLE", (1e-30));
class SVD {
    public function dluav(&$a, $m, $n, &$u, &$v, $eps) {
        // $i, $j, $k, $l, $it, $ll, $kk, $ix, $iy, $mm, $nn, $iz, $ml, $ks;
        // $d, $dd, $t, $sm, $sml, $eml, $sk, $ek, $b, $c, $shh;
        $fg = array();
        $cs = array();
        $s = array();
        $e = array();
        $w = array();
        for ($i = 1; $i <= $m; $i++) {
            $ix = ($i - 1) * $m + $i - 1;
            $u[$ix] = 0;
        }
        for ($i = 1; $i <= $n; $i++) {
            $iy = ($i - 1) * $n + $i - 1;
            $v[$iy] = 0;
        }
        $it = MAX_ITERA;
        $k = $n;
        if ($m - 1 < $n) {
            $k = $m - 1;
        }
        $l = $m;
        if ($n - 2 < $m) {
            $l = $n -2;
        }
        if ($l < 0) {
            $l = 0;
        }
        $ll = $k;
        if ($l > $k) {
            $ll = $l;
        }
        if ($ll >= 1) {
            for ($kk = 1; $kk <= $ll; $kk++) {
                if ($kk <= $k) {
                    $d = 0.0;
                    for ($i = $kk; $i <= $m; $i++) {
                        $ix = ($i - 1) * $n + $kk - 1;
                        $d = $d + $a[$ix] * $a[$ix];
                    }
                    $s[$kk - 1] = sqrt($d);
                    if (abs($s[$kk - 1]) > MIN_DOUBLE) {
                        $ix = ($kk - 1) * $n + $kk - 1;
                        if (abs($a[$ix]) > MIN_DOUBLE) {
                            $s[$kk - 1] = abs($s[$kk - 1]);
                            if ($a[$ix] < 0.0) {
                                $s[$kk - 1] = -$s[$kk - 1];
                            }
                        }
                        for ($i = $kk; $i <= $m; $i++) {
                            $iy = ($i - 1) * $n + $kk - 1;
                            $a[$iy] = $a[$iy] / $s[$kk - 1];
                        }
                        $a[$ix] = 1.0 + $a[$ix];
                    }
                    $s[$kk - 1] = -$s[$kk - 1];
                }
                if ($n >= $kk + 1) {
                    for ($j = $kk + 1; $j <= $n; $j++) {
                        if ($kk <= $k && abs($s[$kk - 1]) > MIN_DOUBLE) {
                            $d = 0.0;
                            for ($i = $kk; $i <= $m; $i++) {
                                $ix = ($i - 1) * $n + $kk - 1;
                                $iy = ($i - 1) * $n + $j - 1;
                                $d = $d + $a[$ix] * $a[$iy];
                            }
                            $d = -$d / $a[($kk - 1) * $n + $kk - 1];
                            for ($i = $kk; $i <= $m; $i++) {
                                $ix = ($i - 1) * $n + $j - 1;
                                $iy = ($i - 1) * $n + $kk - 1;
                                $a[$ix] = $a[$ix] + $d * $a[$iy];
                            }
                        }
                        $e[$j - 1] = $a[($kk - 1) * $n + $j - 1];
                    }
                }
                if ($kk <= $k) {
                    for ($i = $kk; $i <= $m; $i++) {
                        $ix = ($i - 1) * $m + $kk - 1;
                        $iy = ($i - 1) * $n + $kk - 1;
                        $u[$ix] = $a[$iy];
                    }
                }
                if ($kk <= $l) {
                    $d = 0.0;
                    for ($i = $kk + 1; $i <= $n; $i++) {
                        $d = $d + $e[$i - 1] * $e[$i - 1];
                    }
                    $e[$kk - 1] = sqrt($d);
                    if (abs($e[$kk - 1]) > MIN_DOUBLE) {
                        if (abs($e[$kk]) > MIN_DOUBLE) {
                            $e[$kk - 1] = abs($e[$kk - 1]);
                            if ($e[$kk] < 0.0) {
                                $e[$kk - 1] = -$e[$kk - 1];
                            }
                        }
                        for ($i = $kk + 1; $i <= $n; $i++) {
                            $e[$i - 1] = $e[$i - 1]/$e[$kk - 1];
                        }
                        $e[$kk] = 1.0 + $e[$kk];
                    }
                    $e[$kk - 1] = -$e[$kk - 1];
                    if ($kk + 1 <= $m && abs($e[$kk - 1]) > MIN_DOUBLE) {
                        for ($i = $kk + 1; $i <= $m; $i++) {
                            $w[$i - 1] = 0.0;
                        }
                        for ($j = $kk + 1; $j <= $n; $j++) {
                            for ($i = $kk + 1; $i <= $m; $i++) {
                                $w[$i - 1] = $w[$i - 1] + $e[$j - 1] * $a[($i - 1) * $n + $j - 1];
                            }
                        }
                        for ($j = $kk + 1; $j <= $n; $j++) {
                            for ($i = $kk + 1; $i <= $m; $i++) {
                                $ix = ($i - 1) * $n + $j - 1;
                                $a[$ix] = $a[$ix] - $w[$i - 1] * $e[$j - 1] / $e[$kk];
                            }
                        }
                    }
                    for ($i = $kk + 1; $i <= $n; $i++) {
                        $v[($i - 1) * $n + $kk - 1] = $e[$i - 1];
                    }
                }
            }
        }
        $mm = $n;
        if ($m + 1 < $n) {
            $mm = $m + 1;
        }
        if ($k < $n) {
            $s[$k] = $a[$k * $n + $k];
        }
        if ($m < $mm) {
            $s[$mm - 1] = 0.0;
        }
        if ($l + 1 < $mm) {
            $e[$l] = $a[$l * $n + $mm - 1];
        }
        $e[$mm - 1] = 0.0;
        $nn = $m;
        if ($m > $n) {
            $nn = $n;
        }
        if ($nn >= $k + 1) {
            for ($j = $k + 1; $j <= $nn; $j++) {
                for ($i = 1; $i <= $m; $i++) {
                    $u[($i - 1) * $m + $j - 1] = 0.0;
                }
                $u[($j - 1) * $m + $j - 1] = 1.0;
            }
        }
        if ($k >= 1) {
            for($ll = 1; $ll <= $k; $ll++) {
                $kk = $k - $ll + 1;
                $iz = ($kk - 1) * $m + $kk - 1;
                if (abs($s[$kk - 1]) > MIN_DOUBLE) {
                    if ($nn >= $kk + 1) {
                        for ($j = $kk + 1; $j <= $nn; $j++) {
                            $d = 0.0;
                            for ($i = $kk; $i <= $m; $i++) {
                                $ix = ($i - 1) * $m + $kk - 1;
                                $iy = ($i - 1) * $m + $j - 1;
                                $d = $d + $u[$ix] * $u[$iy] / $u[$iz];
                            }
                            $d = -$d;
                            for ($i = $kk; $i <= $m; $i++) {
                                $ix = ($i - 1) * $m + $j - 1;
                                $iy = ($i - 1) * $m + $kk - 1;
                                $u[$ix] = $u[$ix] + $d * $u[$iy];
                            }
                        }
                        for ($i = $kk; $i <= $m; $i++) {
                            $ix = ($i - 1) * $m + $kk - 1;
                            $u[$ix] = -$u[$ix];
                        }
                        $u[$iz] = 1.0 + $u[$iz];
                        if ($kk - 1 >= 1) {
                            for ($i = 1; $i <= $kk - 1; $i++) {
                                $u[($i - 1) * $m + $kk - 1] = 0.0;
                            }
                        }
                    }
                } else {
                    for($i = 1; $i <= $m; $i++) {
                        $u[($i - 1) * $m + $kk - 1] = 0.0;
                    }
                    $u[($kk - 1) * $m + $kk - 1] = 1.0;
                }
            }
        }
        for ($ll = 1; $ll <= $n; $ll++) {
            $kk = $n - $ll + 1;
            $iz = $kk * $n + $kk - 1;
            if ($kk <= $l && abs($e[$kk - 1]) > MIN_DOUBLE) {
                for ($j = $kk + 1; $j <= $n; $j++) {
                    $d = 0.0;
                    for ($i = $kk + 1; $i <= $n; $i++) {
                        $ix = ($i - 1) * $n + $kk - 1;
                        $iy = ($i - 1) * $n + $j - 1;
                        $d = $d + $v[$ix] * $v[$iy] / $v[$iz];
                    }
                    $d = -$d;
                    for ($i = $kk + 1; $i <= $n; $i++) {
                        $ix = ($i - 1) * $n + $j - 1;
                        $iy = ($i - 1)*$n + $kk - 1;
                        $v[$ix] = $v[$ix] + $d * $v[$iy];
                    }
                }
            }
            for ($i = 1; $i <= $n; $i++) {
                $v[($i - 1) * $n + $kk - 1] = 0.0;
            }
            $v[$iz - $n] = 1.0;
        }
        for($i = 1; $i <= $m; $i++) {
            for($j = 1; $j <= $n; $j++) {
                $a[($i - 1) * $n + $j - 1] = 0.0;
            }
        }
        $ml = $mm;
        $it = MAX_ITERA;
        while (1) {
            if ($mm == 0) {
                $this->ppp($a, $e, $s, $v, $m, $n);
                $s = array();
                $e = array();
                $w = array();
                return $l;
            }
            if ($it == 0) {
                $this->ppp($a, $e, $s, $v, $m, $n);
                $s = array();
                $e = array();
                $w = array();
                return -1;
            }
            $kk = $mm - 1;
            while ($kk != 0 && abs($e[$kk - 1]) > MIN_DOUBLE) {
                $d = abs($s[$kk - 1]) + abs($s[$kk]);
                $dd = abs($e[$kk - 1]);
                if ($dd > $eps * $d) {
                    $kk = $kk - 1;
                } else {
                    $e[$kk - 1] = 0.0;
                }
            }
            if ($kk == $mm - 1) {
                $kk = $kk + 1;
                if($s[$kk - 1] < 0.0) {
                    $s[$kk - 1] = -$s[$kk - 1];
                    for($i = 1; $i <= $n; $i++) {
                        $ix = ($i - 1) * $n + $kk - 1;
                        $v[$ix] = -$v[$ix];
                    }
                }
                while(($kk != $ml) && ($s[$kk - 1] < $s[$kk])) {
                    $d = $s[$kk - 1];
                    $s[$kk - 1] = $s[$kk];
                    $s[$kk] = $d;
                    if ($kk < $n) {
                        for ($i = 1; $i <= $n; $i++) {
                            $ix = ($i - 1) * $n + $kk - 1;
                            $iy = ($i - 1) * $n + $kk;
                            $d = $v[$ix];
                            $v[$ix] = $v[$iy];
                            $v[$iy] = $d;
                        }
                    }
                    if ($kk < $m) {
                        for ($i = 1; $i <= $m; $i++) {
                            $ix = ($i - 1) * $m + $kk - 1;
                            $iy = ($i - 1) * $m + $kk;
                            $d = $u[$ix];
                            $u[$ix] = $u[$iy];
                            $u[$iy] = $d;
                        }
                    }
                    $kk = $kk + 1;
                }
                $it = MAX_ITERA;
                $mm = $mm - 1;
            } else {
                $ks = $mm;
                while(($ks > $kk) && (abs($s[$ks - 1]) > MIN_DOUBLE)) {
                    $d = 0.0;
                    if ($ks != $mm) {
                        $d = $d + abs($e[$ks - 1]);
                    }
                    if ($ks != $kk + 1) {
                        $d = $d + abs($e[$ks - 2]);
                    }
                    $dd = abs($s[$ks - 1]);
                    if ($dd > $eps * $d) {
                        $ks = $ks - 1;
                    } else {
                        $s[$ks - 1] = 0.0;
                    }
                }
                if ($ks == $kk) {
                    $kk = $kk + 1;
                    $d = abs($s[$mm - 1]);
                    $t = abs($s[$mm - 2]);
                    if ($t > $d) {
                        $d = $t;
                    }
                    $t = abs($e[$mm - 2]);
                    if ($t > $d) {
                        $d = $t;
                    }
                    $t = abs($s[$kk - 1]);
                    if ($t > $d) {
                        $d = $t;
                    }
                    $t = abs($e[$kk - 1]);
                    if ($t > $d) {
                        $d = $t;
                    }
                    $sm = $s[$mm - 1] / $d;
                    $sml = $s[$mm - 2] / $d;
                    $eml = $e[$mm - 2] / $d;
                    $sk = $s[$kk - 1] / $d;
                    $ek = $e[$kk - 1] / $d;
                    $b = (($sml + $sm) * ($sml - $sm) + $eml * $eml) / 2.0;
                    $c = $sm * $eml;
                    $c = $c * $c;
                    $shh = 0.0;
                    if ((abs($b) > MIN_DOUBLE) || (abs($c) > MIN_DOUBLE)) {
                        $shh = sqrt($b * $b + $c);
                        if ($b < 0.0) {
                            $shh = -$shh;
                        }
                        $shh = $c / ($b + $shh);
                    }
                    $fg[0] = ($sk + $sm) * ($sk - $sm) - $shh;
                    $fg[1] = $sk * $ek;
                    for ($i = $kk; $i <= $mm - 1; $i++) {
                        $this->sss($fg, $cs);
                        if ($i != $kk) {
                            $e[$i - 2] = $fg[0];
                        }
                        $fg[0] = $cs[0] * $s[$i - 1] + $cs[1] * $e[$i - 1];
                        $e[$i - 1] = $cs[0] * $e[$i - 1] - $cs[1] * $s[$i - 1];
                        $fg[1] = $cs[1] * $s[$i];
                        $s[$i] = $cs[0] * $s[$i];
                        if((abs($cs[0] - 1.0) > MIN_DOUBLE) || (abs($cs[1]) > MIN_DOUBLE)) {
                            for($j = 1; $j <= $n; $j++) {
                                $ix = ($j - 1) * $n + $i - 1;
                                $iy = ($j - 1) * $n + $i;
                                $d = $cs[0] * $v[$ix] + $cs[1] * $v[$iy];
                                $v[$iy] = -$cs[1] * $v[$ix] + $cs[0] * $v[$iy];
                                $v[$ix] = $d;
                            }
                        }
                        $this->sss($fg, $cs);
                        $s[$i - 1] = $fg[0];
                        $fg[0] = $cs[0] * $e[$i - 1] + $cs[1] * $s[$i];
                        $s[$i] = -$cs[1] * $e[$i - 1] + $cs[0] * $s[$i];
                        $fg[1] = $cs[1] * $e[$i];
                        $e[$i] = $cs[0] * $e[$i];
                        if($i < $m) {
                            if((abs($cs[0] - 1.0) > MIN_DOUBLE) || (abs($cs[1]) > MIN_DOUBLE)) {
                                for($j = 1; $j <= $m; $j++) {
                                    $ix = ($j - 1) * $m + $i - 1;
                                    $iy = ($j - 1) * $m + $i;
                                    $d = $cs[0] * $u[$ix] + $cs[1] * $u[$iy];
                                    $u[$iy] = -$cs[1] * $u[$ix] + $cs[0] * $u[$iy];
                                    $u[$ix] = $d;
                                }
                            }
                        }
                    }
                    $e[$mm - 2] = $fg[0];
                    $it = $it - 1;
                } else {
                    if($ks == $mm) {
                        $kk = $kk + 1;
                        $fg[1] = $e[$mm - 2];
                        $e[$mm - 2] = 0.0;
                        for($ll = $kk; $ll <= $mm - 1; $ll++) {
                            $i = $mm + $kk - $ll - 1;
                            $fg[0] = $s[$i - 1];
                            $this->sss($fg, $cs);
                            $s[$i - 1] = $fg[0];
                            if($i != $kk) {
                                $fg[1] = -$cs[1] * $e[$i - 2];
                                $e[$i - 2] = $cs[0] * $e[$i - 2];
                            }
                            if((abs($cs[0] - 1.0) > MIN_DOUBLE) || (abs($cs[1]) > MIN_DOUBLE)) {
                                for($j = 1;$j <= $n; $j++) {
                                    $ix = ($j - 1) * $n + $i - 1;
                                    $iy = ($j - 1) * $n + $mm - 1;
                                    $d = $cs[0] * $v[$ix] + $cs[1] * $v[$iy];
                                    $v[$iy] = -$cs[1] * $v[$ix] + $cs[0] * $v[$iy];
                                    $v[$ix] = $d;
                                }
                            }
                        }
                    } else {
                        $kk = $ks + 1;
                        $fg[1] = $e[$kk - 2];
                        $e[$kk - 2] = 0.0;
                        for($i = $kk; $i <= $mm; $i++) {
                            $fg[0] = $s[$i - 1];
                            $this->sss($fg, $cs);
                            $s[$i - 1] = $fg[0];
                            $fg[1] = -$cs[1] * $e[$i - 1];
                            $e[$i - 1] = $cs[0] * $e[$i - 1];
                            if((abs($cs[0] - 1.0) > MIN_DOUBLE) || (abs($cs[1]) > MIN_DOUBLE)) {
                                for($j = 1; $j <= $m; $j++) {
                                    $ix = ($j - 1) * $m + $i - 1;
                                    $iy = ($j - 1) * $m + $kk - 2;
                                    $d = $cs[0] * $u[$ix] + $cs[1] * $u[$iy];                              
                                    $u[$iy] = -$cs[1] * $u[$ix] + $cs[0] * $u[$iy];
                                    $u[$ix] = $d;
                                }
                            }
                        }
                    }
                }
            }
        }
        $s = array();
        $e = array();
        $w = array();
        return $l;
    }
    public function ppp(&$a, &$e, &$s, &$v, $m, $n) {
        // $i,$j,$p,$q,$d;
        if($m >= $n) {
            $i = $n;
        } else {
            $i = $m;
        }
        for($j = 1; $j <= $i - 1; $j++) {
            $a[($j - 1) * $n + $j - 1] = $s[$j - 1];
            $a[($j - 1) * $n + $j] = $e[$j - 1];
        }
        $a[($i - 1) * $n + $i - 1] = $s[$i - 1];
        if($m < $n) {
            $a[($i - 1) * $n + $i] = $e[$i - 1];
        }
        for($i = 1; $i <= $n - 1; $i++) {
            for($j = $i + 1; $j <= $n; $j++) {
                $p = ($i - 1) * $n + $j - 1;
                $q = ($j - 1) * $n + $i - 1;
                $d = $v[$p];
                $v[$p] = $v[$q];
                $v[$q] = $d;
            }
        }
    }
    public function sss(&$fg, &$cs) {
        // $r,$d;
        if ((abs($fg[0]) + abs($fg[1])) < MIN_DOUBLE) {
            $cs[0] = 1.0;
            $cs[1] = 0.0;
            $d = 0.0;
        } else {
            $d = sqrt($fg[0] * $fg[0] + $fg[1] * $fg[1]);
            if (abs($fg[0]) > abs($fg[1])) {
                $d = abs($d);
                if($fg[0] < 0.0) {
                    $d = -$d;
                }
            }
            if (abs($fg[1]) >= abs($fg[0])) {
                $d = abs($d);
                if($fg[1] < 0.0) {
                    $d = -$d;
                }
            }
            $cs[0] = $fg[0] / $d;
            $cs[1] = $fg[1] / $d;
        }
        $r = 1.0;
        if (abs($fg[0]) > abs($fg[1])) {
            $r = $cs[1];
        } else {
            if(abs($cs[0]) > MIN_DOUBLE) {
                $r = 1.0 / $cs[0];
            }
        }
        $fg[0] = $d;
        $fg[1] = $r;
    }
    //矩阵相乘
    public function damul(&$a, &$b, $m, $n, $k, &$c) {
        // $i,$j,$l,$u;
        for($i = 0; $i <= $m - 1; $i++) {
            for($j = 0; $j <= $k - 1; $j++) {
                $u = $i * $k + $j;
                $c[$u] = 0;
                for($l = 0; $l <= $n - 1; $l++) {
                    $c[$u] = $c[$u] + $a[$i * $n + $l] * $b[$l * $k + $j];
                }
            }
        }
    }
    function __construct(&$a, $m, $n, &$u, &$v, $eps) {
        $this->dluav($a, $m, $n, $u, $v, $eps);
    }
}
define("N", 10);
class OP {
    public function getA(&$arcs, $n) {
        if ($n == 1) {
            return $arcs[0][0];
        }
        $ans = 0;
        $temp = array();
        // int i,j,k;
        for ($i = 0; $i < $n; $i++) {
            $temp[$i] = array();
            for ($j = 0; $j < $n - 1; $j++) {
                for ($k = 0; $k < $n - 1; $k++) {
                    $temp[$j][$k] = $arcs[$j + 1][($k >= $i) ? $k + 1 : $k];
                }
            }
            $t = $this->getA($temp, $n - 1);
            if ($i%2 == 0) {
                $ans += $arcs[0][$i]*$t;
            } else {
                $ans -=  $arcs[0][$i]*$t;
            }
        }
        return $ans;
    }
    function getAStart(&$arcs, $n, &$ans) {
        if ($n == 1) {
            $ans[0][0] = 1;
            return;
        }
        // int i,j,k,t;
        $temp = array();
        for ($i = 0; $i < $n; $i++) {
            $temp[$i] = array();
            for ($j = 0; $j < $n; $j++) {
                for ($k = 0; $k < $n - 1; $k++) {
                    for ($t = 0; $t < $n - 1; $t++) {
                        $temp[$k][$t] = $arcs[$k >= $i ? $k+1 : $k][$t >= $j ? $t+1 : $t];
                    }
                }
                $ans[$j][$i]  =  $this->getA($temp, $n-1);
                if (($i+$j) % 2 == 1) {
                    $ans[$j][$i] = - $ans[$j][$i];
                }
            }
        }
        // print_r($ans);
    }
    public function ni(&$arr) {
        $n = count($arr);
        $a = $this->getA($arr, $n);
        if ($a == 0) {
            echo 'can not transform';
        } else {
            $astar = array();
            for ($i = 0; $i < $n; $i++) {
                $astar[$i] = array();
            }
            $this->getAStart($arr, $n, $astar);
        }
        for ($i = 0; $i < $n; $i++) {
            for ($j = 0; $j < $n; $j++) {
                $arr[$i][$j] = $astar[$i][$j]/$a;
            }
        }
    }
    public function trans($data) {
        $m = count($data);
        $n = count($data[0]);
        $tran = array();
        for ($i = 0; $i < $n; $i++) {
            $tran[$i] = array();
            for ($j = 0; $j < $m; $j++) {
                $tran[$i][$j] = $data[$j][$i];
            }
        }
        return $tran;
    }
    public function twoDimen(&$data, $m, $n) {
        $arr = array();
        for ($i = 0; $i < $m; $i++) {
            $arr[$i] = array();
            for ($j = 0; $j < $n; $j++) {
                $arr[$i][$j] = $data[$i * $n + $j];
            }
        }
        return $arr;
    }
    function multiply($a, $b) {
        $result = array();
        $am = count($a);
        $an = count($a[0]);
        $bm = count($b);
        $bn = count($b[0]);
        for ($i = 0; $i < $am; $i++) {
            $result[$i] = array();
            for ($j = 0; $j < $bn; $j++) {
                $result[$i][$j] = 0;
                for ($x = 0; $x < $bm; $x++) {
                    $result[$i][$j] += $a[$i][$x] * $b[$x][$j];
                }
            }
        }
        return $result;
    }
    public function oneDimen($data) {
        $m = count($data);
        $n = count($data[0]);
        $arr = array();
        for ($i = 0; $i < $m; $i++) {
            for ($j = 0; $j < $n; $j++) {
                $arr[$i*$n + $j] = $data[$i][$j];
            }
        }
        return $arr;
    }
    /*function __construct(&$arr) {
        $this->ni($arr);
    }*/
}
// $data = array(array(1, 2, 3), array(2, 2, 1), array(3, 4, 3));
// $aaa = array(1, 9, 9, 0, 3, 2, 1, 2, 0, 9, 7, 0);
// print_r($data);
// $op->ni($data);
// $op->trans($data);
// $op -> twoDimen($aaa, 3, 4);
// $op = new OP();
// print_r($op->multiply(array(array(1, 2, 3)), array(array(1), array(2), array(3))));
?>