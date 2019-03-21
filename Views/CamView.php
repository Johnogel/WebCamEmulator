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
        background: url('<?php getWebCamImageDataUrl() ?>') no-repeat center ;
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
    
    
</style>

<script>
    
    function clamp(number, b, c){
        return Math.max(b,Math.min(c,number));
    }
    
    function CamViewModel(vW, vH, image){
        var self = this;
        
        image.onload = function(){
            self.initImage();
            self.draw();
        }
        
        self.initImage = function(){
            self.imageWidth = self.image.naturalWidth / .5;
            self.imageHeight = self.image.naturalHeight / .5;
        }
        
        self.minZoom = 2;
        self.maxZoom = 20;
        
        self.viewportWidth = vW;
        self.viewportHeight = vH;
        self.image = image;
        self.initImage();
//        self.imageWidth = image.naturalWidth;
//        self.imageHeight = image.naturalHeight;
        self.aspectRatio = vW / vH;
        self.currentZoom = ko.observable(7);
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
       
        
        self.maxY = ko.computed(function(){
            return self.imageWidth - self.zoomedWidth();
        }, self);
        
        self.maxX = ko.computed(function(){
            return self.imageHeight - self.zoomedHeight();
        }, self);
        
        
        
        self.currentX = ko.observable(0);
        self.currentY = ko.observable(0);
        
        
        
        
        self.delta = 15;
        
        self.zoomDelta = 0.1;
        
        self.pan = function(xDir, yDir){
            console.log({xDir, yDir});
            if(xDir !== 0){
                self.currentX(clamp(self.currentX() + xDir * self.delta, 0, self.maxX()));
            }
            else if(yDir !== 0){
                self.currentY(clamp(self.currentY() + yDir * self.delta, 0, self.maxY()));
            }
            console.log('pan');
            self.draw();
        };
        
        self.zoom = function(dir){
            self.currentZoom(clamp(self.currentZoom() + dir * self.zoomDelta, self.minZoom, self.maxZoom));
            console.log('zoom');
            self.draw();
        };
        
        self.canvas = document.getElementById('imgCanvas'); 
        self.context = self.canvas.getContext('2d'); 
        
        self.draw = function(){
            
//            
            console.log('test');
//            self.context.clearRect(0, 0, self.canvas.width, self.canvas.height);
            
            self.context.clearRect(0,0, self.canvas.width, self.canvas.height);


            self.context.save();
            self.context.setTransform(1,0,0,1,0,0);
            
            
            var baseScale = (self.maxZoom - self.minZoom) / 2; 
            
            var scale = baseScale / self.currentZoom;
            
            self.context.scale(scale, scale);
            self.context.drawImage(self.image, self.currentX(), self.currentY(), self.zoomedWidth(),self.zoomedHeight(), 0,0, self.viewportWidth, self.viewportHeight); 
            self.context.restore();
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
        <canvas id="imgCanvas">
            
        </canvas>
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
