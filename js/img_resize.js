var image;


//https://www.youtube.com/watch?v=bXf_UdyDzSA
function preview(){    
    //alert('preview worked');
    const file = document.querySelector("#upload").files[0];

    if(!file) return;
    

    const reader = new FileReader();

    reader.readAsDataURL(file);

    reader.onload = function(event){
        const imgElement = document.createElement("img");
        imgElement.src = event.target.result;
        //document.querySelector("#input").src = event.target.result;
        imgElement.onload = function(e){
            const canvas =document.createElement("canvas");
            const MAX_WIDTH = 400;
            
            const scaleSize = MAX_WIDTH / e.target.width;
            canvas.width = MAX_WIDTH;
            canvas.height = e.target.height * scaleSize;

            const ctx = canvas.getContext("2d");

            ctx.drawImage(e.target, 0, 0, canvas.width, canvas.height);
                //console.log(e.target);
            const srcEncodeed = ctx.canvas.toDataURL(e.target, "image/jpg");
            document.querySelector("#output").src = srcEncodeed;
                //console.log(srcEncodeed);
            image = srcEncodeed;
            
            document.querySelector('#btnUpload').removeAttribute('hidden');
        }
    }
}

function process(facebook_id, image){
    $.ajax({        
        url: "upload-img.php",
        type: "POST",
        data: {facebook_id : facebook_id, base64Img : image},                
        success: function(response){
            //alert(response);
            location.reload();                   
        },
    });
}


