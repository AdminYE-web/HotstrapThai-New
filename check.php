<?php $img = imagecreatefrompng("public/images/hero-banner.png"); var_dump(imagecolorsforindex($img, imagecolorat($img, 1, 150))); var_dump(imagecolorsforindex($img, imagecolorat($img, 1020, 150)));
