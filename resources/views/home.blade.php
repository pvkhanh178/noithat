<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <div class="contianer-fluid bg-light p-4">
        <div class="container">
            <div class="card">
                <div class="card-header text-center">
                    <h5>SELECT PRODUCT</h5>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="">Material:</label>
                        <select class="form-control" name="materials" id="materials">
                            <option value=""></option>
                            <option value="1"></option>
                        </select>
                        <div id="mate"></div>
                    </div>
                    <div class="form-group">
                        <label for="">Products:</label>
                        <select class="form-control" name="products" id="products">
                            <option value=""></option>
                        </select>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col text-left">
                            <p id="Details"></p>
                            <hr>
                            <p id="Images"></p>
                        </div>
                        <div class="col text-left">
                            <p id="Attributes"></p>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <script type="text/javascript">
        $('document').ready(function(){
            $(window).on('load', function(){
                $('#Details').html("");
                $('#Attributes').html("");
                $('#Images').html("");
                $.get('api/materials',function(data){
                    var _data = data.Materials
                    var html = "<option value=\"\">Select...</option>";
                    $.each( _data, function(i, __data) {
                        html+="<option value=\""+__data.id+"\">"+__data.name+"</option>";
                    });
                    $('#materials').html(html);
                });
            });
            $('#materials').change(function(){
                $('#products').html("");
                $('#Details').html("");
                $('#Attributes').html("");
                $('#Images').html("");
                if($('#materials').val()!=''){
                    var id = $(this).val();
                    $.get('api/products/material/' + id,function(data){
                        var _data = data.Products;
                        var html = "<option value=\"\">Select...</option>";
                        $.each( _data, function(i, __data) {
                            html+="<option value=\""+__data.id+"\">"+__data.name+"</option>";
                        });
                        $('#products').append(html);
                    });
                }else{
                    $('#products').html("<option value='' selected>No select</option>");
                }
            });
            $('#products').change(function(){
                $('#product').html("");
                $('#Details').html("");
                $('#Attributes').html("");
                $('#Images').html("");
                if($('#products').val()!=''){
                    var id = $(this).val();
                    $.get('api/products/details/' + id,function(data){
                        console.log(data);
                        var product = data.Product;
                        var attribute = data.Attributes;
                        var images = data.Images;
                        var Details = "";
                        Details += "<h5><b>Products</b></h5>";
                        Details += "Name: <b>"+product[0].name+"</b><br>";
                        Details += "Cost: <b>"+product[0].cost_price+"</b><br>";
                        Details += "Sale: <b>"+product[0].sale_price+"</b><br>";
                        Details += "Description: <b>"+product[0].description+"</b><br>";
                        Details += "Model: <b>"+product[0].model+"</b><br>";
                        Details += "Specification: <b>"+product[0].specification+"</b><br>";

                        var Images = "";
                        $.each( images, function(i, index) {
                            Images += "<h5></b>"+images[i].name+"</b></h5><br>";
                            Images += "Type: <b>"+images[i].type+"</b><br>";
                            Images += "Object Type: <b>"+images[i].obj_type+"</b><br>";
                            Images += "Size: <b>"+images[i].size+"</b><br>";
                            Images += "Path: <b>"+images[i].path+"</b><br>";
                            Images += "Description: <b>"+images[i].description+"</b><br><hr>";
                        });
                        
                        var Attribute = "";
                        $.each( attribute, function(i, index) {
                            Attribute += "<h5></b>"+attribute[i].name+"</b></h5><br>";
                            Attribute += "Color: <b>"+attribute[i].color+"</b><br>";
                            Attribute += "Size: <b>"+attribute[i].size+"</b><br>";
                            Attribute += "Unit: <b>"+attribute[i].unit+"</b><br>";
                            Attribute += "Description: <b>"+attribute[i].description+"</b><br><hr>";
                        });
                        $('#Details').html(Details);
                        $('#Images').html(Images);
                        $('#Attributes').html(Attribute);
                    });

                }else{
                    $('#product').html("<option value='' selected>No select</option>");
                }
            });
        });
      </script>
</body>

</html>