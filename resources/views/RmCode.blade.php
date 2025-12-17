<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    
    <title>{{config('default.app_name')}}</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body >
    <!-- React root DOM -->
    <div id="root">
        @php $rms = Helper::getAllRmCode();
        @endphp
        <div class="container">
        <div class="row">
        @foreach ($rms as $value)
            <div class="col-md-2" style="margin-top:20px">
                <div class="card" style="width: 10rem;">
                    <img src="{{asset('public/rm/qrcodes/'.$value->qr_code)}}" class="card-img-top" alt="...">
                    <div class="card-body">
                        <p class="card-text" style="font-size: 12px">{{$value->name}}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        </div>
    </div>
    <!-- React JS -->
    <script src="{{ asset('js/app.js') }}" defer></script>
</body>
</html>
