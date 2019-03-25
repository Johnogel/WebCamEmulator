<style>
    .viewport{
        width: 700px;
        height:500px;
        display: block;
        padding-top:100px;
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
        display:block;
        margin: 0 auto;
    }
    
    .controls table input{
        width: 30px;
        height: 30px;

    }
    
    .centered{
        margin: 0 auto;
        
    }
    
    .controls{
        width: 100%;
        padding-top: 35px;
    }
    
    .controls .spaceCell{
        width: 50px;
    }
    
    .divImage{
        background: url('<?php getWebCamImageDataUrl() ?>') no-repeat center;
        
        width: 100%;
        height:100%;
    }
    
    
</style>

<script>
    
    function clamp(number, b, c){
        return Math.max(b,Math.min(c,number));
    }
    
    function CamViewModel(vW, vH, image){
        var self = this;
        
        image.onload = function(){
            self.initImage();
            self.refreshLens();
            self.draw();
        };
        
        self.initImage = function(){
            self.imageWidth = self.image.naturalWidth / .5;
            self.imageHeight = self.image.naturalHeight / .5;
        };
        
        self.minZoom = .35;
        self.maxZoom = 1;
        
        self.viewportWidth = vW;
        self.viewportHeight = vH;
        self.image = image;
        self.initImage();
//        self.imageWidth = image.naturalWidth;
//        self.imageHeight = image.naturalHeight;
        self.aspectRatio = vW / vH;
        self.currentZoom = ko.observable(self.viewportWidth * 2);
        self.scale = ko.observable(.5);
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
                cy: cy
            };
        };
        
       
       self.lens = function(){
            return self._lens;
//            var x, y;
//            
//            var width = self.imageWidth * (1 - self.scale());
//            var height = width / self.aspectRatio;
//            
//            x = self.currentX() + (self.imageWidth / 2) - (width / 2);
//            y = self.currentY() + (self.imageHeight / 2) - (height / 2);
//
//            var cx = self.viewportWidth / width;
//            var cy = self.viewportHeight / height;
//            
//            return {
//                x: x,
//                y: y,
//                width: width,
//                height: height,
//                cx: cx,
//                cy: cy
//            };
        };
        
        self.maxY = function(){
            var lens = self.lens();
            
            var max = self.imageHeight - lens.height /2;
            
            return max;
        };
        
        self.maxX = function(){
         //            return self.imageWidth - self.zoomedWidth();
            var lens = self.lens();
            
            var max = self.imageWidth - lens.width /2;
            
            return max;
        };
        
        
        self.currentX = ko.observable(0);
        self.currentY = ko.observable(0);
        
        self.delta = 15 ;
        
        self.zoomDelta = .005;
        
        self.pan = function(xDir, yDir, delta = null){
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
        
        self.zoom = function(dir){
            //self.currentZoom(clamp(self.currentZoom() + dir * self.zoomDelta, self.minZoom, self.maxZoom));
            self.scale(clamp(self.scale() + dir * self.zoomDelta, self.minZoom, self.maxZoom));
            self.refreshLens();
            //self.pan(1, 1, self.zoomDelta * .35);
            self.draw();
        };
        
        
        
        
        //self.canvas = document.getElementById('imgCanvas'); 
        //self.context = self.canvas.getContext('2d'); 
        
        self.draw = function(){
            
            var img = $('.divImage')[0];

            var pos, x, y;
            
            var lens = self.lens();
            
            x = lens.x;
            y = lens.y;
            /* Prevent the lens from being positioned outside the image: */
//            if (x > self.imageWidth - lens.width) {x = self.imageWidth - lens.width;}
//            if (x < 0) {x = 0;}
//            if (y > self.imageHeight - lens.height) {y = self.imageHeight - lens.height;}
//            if (y < 0) {y = 0;}
            /* Set the position of the lens: */
//            img.style.left = x + "px";
//            img.style.top = y + "px";
            /* Display what the lens "sees": */
            img.style.backgroundPosition =  "-"+(x * lens.cx) + "px -" + (y * lens.cy) + "px";
            
            img.style.backgroundSize = (self.imageWidth * lens.cx)+"px "+(self.imageHeight * lens.cy) + "px";
            
//            self.context.clearRect(0, 0, self.canvas.width, self.canvas.height);
            
//            self.context.clearRect(0,0, self.canvas.width, self.canvas.height);
//
//
//            self.context.save();
//            self.context.setTransform(1,0,0,1,0,0);
//            
//            
//            var baseScale = (self.maxZoom - self.minZoom) / 2; 
//            
//            
//            self.context.scale(scale, scale);
//            self.context.drawImage(self.image, self.currentX(), self.currentY(), self.zoomedWidth(),self.zoomedHeight(), 0,0, self.viewportWidth, self.viewportHeight); 
//            self.context.restore();
        };
    }
    
    var img;
    
    var cWidth = null;
    var cHeight = null;

    var camViewModel;

    window.onload = function () {
        var img=  new Image($('.viewport').width(), $('.viewport').height());
        img.src= '<?php getWebCamImageDataUrl() ?>';

        camViewModel = new CamViewModel($('.viewport').width(), $('.viewport').height(), img);
        //camViewModel.draw();
        ko.applyBindings(camViewModel, $('.viewportWrapper')[0]);
    };
    
</script>

<div class="viewportWrapper">
    <div class="viewport centered">
<!--        <div class="image">
            
        </div>-->
<!--        <canvas id="imgCanvas">
            
        </canvas>-->
        <div class="divImage">

        </div>
        <!--<img id="imgRoom" src="<?php getWebCamImageDataUrl() ?>" width="300" />-->
    </div>
    <div class="controls">
        <table class="centered">
            <tr>
                <td >
                    <input type="image" src="Images/UI/zoom-in-button.png" data-bind="click: function(){ zoom(1); }"/>
                </td>
                <td class="spaceCell"></td>
                <td></td>
                <td><input type="image" src="Images/UI/up-button.png" data-bind="click: function(){ pan(0, -1); }" /></td>
                <td></td>
            </tr>
            <tr>
                <td>
                    
                </td>
                <td class="spaceCell"></td>
                <td><input type="image" src="Images/UI/left-button.png" data-bind="click: function(){ pan(-1, 0); }" /></td>
                <td></td>
                <td>
                    <input type="image" src="Images/UI/right-button.png" data-bind="click: function(){pan(1, 0);}" />
                </td>
            </tr>
            <tr>
                <td >
                    <input type="image" src="Images/UI/zoom-out-button.png" data-bind="click: function(){zoom(-1);}" />
                </td>
                <td class="spaceCell"></td>
                <td></td>
                <td><input type="image" src="Images/UI/down-button.png" data-bind="click: function(){pan(0, 1);}" /></td>
                <td></td>
            </tr>
                
        </table>
    </div>
    
    
</div>
