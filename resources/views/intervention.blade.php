<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Image Intervention</title>
  </head>
  <body>
    <div class="container">
        <h1>Image Intervention example</h1>
        <form id="image_transform" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}

            <div class="form-group">
                <label for="Product Name">Upload a photo</label>
                <input id="photo" type="file" class="form-control" name="photo"  />
            </div> 
            
            <div class="form-group">
                <label for="Brightness">Brightness</label>
                <div class="slidecontainer">
                <input type="range" min="1" max="100" value="50" class="slider" id="brightness_range" name="brightness">
                </div>
            </div>

            <div class="form-group">
                <label for="Blur">Blur</label>
                <div class="slidecontainer">
                <input type="range" min="0" max="100" value="0" class="slider" id="blur_range" name="blur">
                </div>
            </div>

            <div class="form-group">
                <label for="Brightness">Contrast</label>
                <div class="slidecontainer">
                <input type="range" min="0" max="100" value="0" class="slider" id="contrast_range" name="contrast">
                </div>
            </div>
            <div class="form-group">
                <label for="height">Height</label>
                <div class="img_height">
                <input type="text" class="form-control" id="img_height" name="height">
                </div>
            </div>
            <div class="form-group">
                <label for="width">Width</label>
                <div class="img_width">
                <input type="text" class="form-control" id="img_width" name="width">
                </div>
            </div>

            <input type="submit" class="btn btn-primary" id="image_transform" value="Submit" />
        </form>
        <div id="img_cont" style="text-align:center; padding: 20px;"></div>
    </div>


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script
          src="https://code.jquery.com/jquery-3.4.1.min.js"
          integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
          crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript">

            
        $("#image_transform").submit(function(e){
                e.preventDefault();
                console.log(new FormData(this));
                $.ajax({ url: "/uploadPhoto", 
                          method:"POST",
                          data:new FormData(this),
                          dataType:'JSON',
                          contentType: false,
                          cache: false,
                          processData: false,
                        success: function(result){
                            console.log(result);
                            $("#img_cont").html("<div class='alert alert-success'>Image uploaded successfully</div>");
                            $("#img_cont").fadeIn();
                            $("#img_cont").html("<img src="+result+">");
                        }
                    });
            });
    </script>

  </body>
</html>