<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Laravel</title>

    <!-- Styles -->
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 1200px;
            margin: 0 auto;
        }

        .header {
            padding: 15px 0;
        }

        .content {

        }

        img {
            width: 150px;
            height: auto;
        }

    </style>
</head>
<body>
<div class="flex-center position-ref full-height">
    <div class="container">
        <div class="header">
            <h1>Add Watermark</h1>
        </div>
        <div class="content">
            <form method="post" action="{{route('watermark.store')}}"  enctype="multipart/form-data">
                @csrf
                <label for="Product Name">Ảnh nguồn: </label>
                <input type="file" class="form-control" name="photos[]" accept="image/jpeg, image/png" multiple />
                <input type="submit" class="btn btn-primary" value="Upload" />
            </form>
            <br/>
            @isset($urls)
                <div>
                    @foreach($urls as $url)
                        <img src="{{$url}}" />
                        @endforeach
                </div>
                @endisset
        </div>
    </div>
</div>
</body>
</html>
