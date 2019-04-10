<style>
    .viewport{
        width: 100%;
        height:425px;
        display: block;
        position:relative;
        border: solid 1px white;
        
    }
    
    .viewport #imgCanvas{
        width:100%;
        height:100%;
    }
    
    .image{
        background: url('<?php resolveUrl('Images/Webcam/webcamimage.jpg')?>') no-repeat center ;
        width: 100%;
        height:100%;
    }
    
    .viewportWrapper{
        width: 700px;
        display:block;
        margin: 0 auto;
        margin-top:60px;
        padding-bottom: 50px;

    }
    
    .controls table input{
        width: 25px !important;
        height: 25px !important;
        min-width: 25px !important;
        min-height: 25px !important;
    }
    
    .centered{
        margin: 0 auto;
        
    }
    
    .controls{
        width: 100%;
        padding-top: 35px;
        background-color: #36383d;
        height: 125px;
        border-top: solid 2px white;
        
    }
    
    .controls .spaceCell{
        width: 25px;
    }
    
    .divImage{
        width: 100%;
        height:100%;
    }
    
    .staticOverlay{
        background: url('<?php resolveUrl('Images/static.gif')?>') repeat center;
        background-size: 2000px 10px;
        position: absolute;
        width: 100%;
        height: 100%;
        z-index: 100;
    }
    
    .controls{
        border: solid 1px white;

    }
    
    
    
</style>

<script>
    
    function clamp(number, b, c){
        return Math.max(b,Math.min(c,number));
    }
    
    function CamViewModel(vW, vH, image){
        var self = this;
        
        self.timeout = 15;
        
        image.onload = function(){
            self.initImage();
            self.refreshLens();
            self.draw();
        };
        
        self.initImage = function(){
            self.imageWidth = self.image.naturalWidth / .5;
            self.imageHeight = self.image.naturalHeight / .5;
            $('.divImage').css('background-image', 'url(\''+$(self.image).prop('src') + '\')');
        };
        
        self.minZoom = .65;
        self.maxZoom = .90;
        
        self.viewportWidth = vW;
        self.viewportHeight = vH;
        self.image = image;
        self.aspectRatio = vW / vH;
        self.currentZoom = ko.observable(self.viewportWidth * 2);
        self.scale = ko.observable(.7);
        self.zoomedWidth = ko.computed(
            function(){ 
                return self.imageWidth * (self.minZoom / self.currentZoom());
            }, 
        self);
        
        self.zoomedHeight = ko.computed(
            function(){ 
                return self.zoomedWidth() / self.aspectRatio;
            }, 
        self);
        
        self._lens = {
         
        };
        
        self.refreshLens = function(){
            var x, y;
            
            var width = self.imageWidth * (1 - self.scale());
            var height = width / self.aspectRatio;
            
            var maxWidth = self.imageWidth * (1 - self.minZoom);
            var maxHeight = maxWidth / self.aspectRatio;
            
            x = self.currentX() + (self.imageWidth / 2) - (width /2);
            y = self.currentY() + (self.imageHeight / 2) - (height /2);

            var cx = self.viewportWidth / width;
            var cy = self.viewportHeight / height;
            
            self._lens = {
                x: x,
                y: y,
                width: width,
                height: height,
                cx: cx,
                cy: cy,
                maxWidth: maxWidth,
                maxHeight: maxHeight
            };
        };
        
       
       self.lens = function(){
            return self._lens;

        };
        
        self.maxY = function(){
            var lens = self.lens();
            
            var max = self.imageHeight - lens.maxHeight /2;
            
            return max;
        };
        
        self.maxX = function(){
            var lens = self.lens();
            var max = self.imageWidth - lens.maxWidth /2;
            
            return max;
        };
        
        
        self.currentX = ko.observable(0);
        self.currentY = ko.observable(0);
        
        self.delta = 20 ;
        
        self.zoomDelta = .005;
        
        self.pan = function(xDir, yDir, delta = null){
            self.movementActive = true;
            self.recursivePan(xDir, yDir);
        };
        
        self.setPan = function(xDir, yDir, delta = null){
            console.log('pan');
            if(delta == null){
                delta = self.delta;
            }
            if(xDir !== 0){
                var bound = self.maxX() - self.imageWidth / 2;
                self.currentX(clamp(self.currentX() + xDir * delta, -bound, bound));
            }
            if(yDir !== 0){
                var bound = self.maxY() - self.imageHeight / 2;

                self.currentY(clamp(self.currentY() + yDir * delta, -bound, bound));
            }
            self.refreshLens();

            self.draw();
        };
        
        self.setZoom = function(dir){
            self.scale(clamp(self.scale() + dir * self.zoomDelta, self.minZoom, self.maxZoom));
            self.refreshLens();
            self.draw();
        };
        
        self.recursiveZoom = function(dir){
            self.setZoom(dir);
            setTimeout(function(){
                if(self.movementActive){
                    self.recursiveZoom(dir);
                }
            }, self.timeout);
        };
        
        self.recursivePan = function(xDir, yDir, delta = null){
            self.setPan(xDir, yDir, null);
            setTimeout(function(){
                if(self.movementActive){
                    self.recursivePan(xDir, yDir, delta);
                }
            }, self.timeout);
        };
        
        self.zoom = function(dir){
            self.movementActive = true;
            self.recursiveZoom(dir);
        };
        
        self.movementActive = false;
        self.cancel = function(){
            self.movementActive = false;
        };

        
        self.draw = function(){
            
            var img = $('.divImage')[0];
            var x, y;
            var lens = self.lens();
            
            x = lens.x;
            y = lens.y;
            img.style.backgroundPosition =  "-"+(x * lens.cx) + "px -" + (y * lens.cy) + "px";
            img.style.backgroundSize = (self.imageWidth * lens.cx)+"px "+(self.imageHeight * lens.cy) + "px";
        };
    }
    
    var img;
    
    var cWidth = null;
    var cHeight = null;

    var camViewModel;

    $('body')[0].onload = function () {
        var img=  new Image($('.viewport').width(), $('.viewport').height());
        img.src= '<?php getWebCamImageDataUrl() ?>';

        camViewModel = new CamViewModel($('.viewport').width(), $('.viewport').height(), img);
        
        $('body').mouseup(function(){
           camViewModel.cancel(); 
        });
        ko.applyBindings(camViewModel, $('.viewportWrapper')[0]);
    };
    
</script>

<div class="viewportWrapper">
    <div class="viewport centered">
        <div class='staticOverlay'></div>
        <div class="divImage">

        </div>

    </div>
    <div class="controls">
        <table class="centered">
            <tr>
                <td >
                    <input type="image" src="<?php resolveUrl('Images/UI/zoom-in-button.png')?>" class="pzControl" data-bind="event: {mousedown : function(){ zoom(1); }}"/>
                </td>
                <td class="spaceCell"></td>
                <td></td>
                <td><input type="image" src="<?php resolveUrl('Images/UI/up-button.png')?>" class="pzControl" data-bind="event: {mousedown :  function(){ pan(0, -1); }}" /></td>
                <td></td>
            </tr>
            <tr>
                <td>
                    
                </td>
                <td class="spaceCell"></td>
                <td><input type="image" src="<?php resolveUrl('Images/UI/left-button.png')?>" class="pzControl" data-bind="event: {mousedown : function(){ pan(-1, 0); }}" /></td>
                <td></td>
                <td>
                    <input type="image" src="<?php resolveUrl('Images/UI/right-button.png')?>" class="pzControl" data-bind="event: {mousedown : function(){pan(1, 0);}}" />
                </td>
            </tr>
            <tr>
                <td >
                    <input type="image" src="<?php resolveUrl('Images/UI/zoom-out-button.png')?>" class="pzControl" data-bind="event: {mousedown : function(){zoom(-1);}}" />
                </td>
                <td class="spaceCell"></td>
                <td></td>
                <td><input type="image" src="<?php resolveUrl('Images/UI/down-button.png')?>" class="pzControl" data-bind="event: {mousedown : function(){pan(0, 1);}}" /></td>
                <td></td>
            </tr>
                
        </table>
    </div>
    
    
</div>
