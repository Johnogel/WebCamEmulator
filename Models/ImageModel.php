<?php
require_once 'Model.php';
class Image{
    
    public $positionGroup;
    public $position;
    
    
    public function __construct($position, $xLength, $yLength) {
        $this->position = $position;
        $x = $position->x;
        $y = $position->y;
        
        $left = $x - 1 >= 0 ? new ImagePosition($x-1, $y) : null;
        $right = $x + 1 < $xLength ? new ImagePosition($x+1, $y) : null;
        $up = $y - 1 >= 0 ?  new ImagePosition($x, $y - 1): null;
        $down = $y + 1 < $yLength ?  new ImagePosition($x, $y + 1) : null;
        
        $this->positionGroup = new ImagePositionGroup($left, $right, $up, $down);
        
    }
    
    
}

$myTestImage = new Image($test, $test, $test);

?>

