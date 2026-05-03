<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href ="css/style.css">
</head>
<body>

    @extends('layout.app')
      @section('content')
          <div style="display: flex; gap: 20px; flex-wrap: wrap;">
        
        <x-product-card 
        image="https://p16-images-sign-sg.tokopedia-static.net/tos-alisg-i-aphluv4xwc-sg/80b53c4a4ca44e58a853b0e133230f4f~tplv-aphluv4xwc-white-pad-v1:1600:1600.jpeg?lk3s=0ccea506&x-expires=1777113984&x-signature=pu9ZjdTr%2FwYwYfQoNT8IFItxM7o%3D&x-signature-webp=38iSSwXBHjAFvc52O83eS9kFH%2Fo%3D"
        name="Contoh Produk"
        brand="Contoh brand"
        price="250000"
        />
        
    </div>
     @endsection

</body>
</html>