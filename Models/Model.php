<?php

    class ImagePosition{
        public function __construct($x, $y) {
            $this->x = $x;
            $this->y = $y;
        }
        public $x;
        public $y;
    }
    
    class ImagePositionGroup{
        public function __construct($left, $right, $up, $down) {
            $this->left = $left;
            $this->right = $right;
            $this->down = $down;
            $this->up =$up;
        }
        
        public $left = null;
        public $right = null;
        public $up = null;
        public $down = null;
    }

?>

