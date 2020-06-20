@include('header')

<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div class="head-title text-center">
                <h1>Добави Магазин</h1>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-md-6 col-md-push-3">
            <form method="POST">
                @csrf
                <div class="form-group @if($errors->has('name')) has-error @endif">
                    <label for="name">Име:</label>
                    <input type="text" @isset($data['name'])value="{{$data['name']}}"@endisset name="name" class="form-control" id="name">
                    @if($errors->has('name'))<small class="text-danger">{{$errors->first('name')}}</small>@endif
                </div>
                <div class="form-group @if($errors->has('url')) has-error @endif">
                    <label for="link">Линк към продуктите:</label>
                    <input type="text" @isset($data['url'])value="{{$data['name']}}"@endisset name="url" class="form-control" id="link">
                    @if($errors->has('url'))<small class="text-danger">{{$errors->first('url')}}</small>@endif
                </div>
                <div class="form-group @if($errors->has('number')) has-error @endif">
                    <label for="number">Api номер:</label>
                    <input type="text" @isset($data['number'])value="{{$data['name']}}"@endisset name="number" class="form-control" id="number">
                    @if($errors->has('number'))<small class="text-danger">{{$errors->first('number')}}</small>@endif
                </div>
                <div class="form-group @if($errors->has('key')) has-error @endif">
                    <label for="key">Api ключ:</label>
                    <input type="text" @isset($data['key'])value="{{$data['name']}}"@endisset name="key" class="form-control" id="key">
                    @if($errors->has('key'))<small class="text-danger">{{$errors->first('key')}}</small>@endif
                </div>
                <button type="submit" class="btn btn-primary">Добави</button>
                <a href="{{route('shops.index')}}" class="btn btn-default">Върни се обратното</a>
            </form>
            @if(isset($error))
                <div class="alert alert-danger" style="margin-tpop: 10px;">
                    <p>{{$error}}</p>
                </div>
            @endif

            @if(isset($success))
                <div class="alert alert-success" style="margin-tpop: 10px;">
                    <p>{{$success}} <a href="{{route('shops.index')}}">Върнете се обратно</a>
                </div>
            @endif
        </div>
    </div>
</div>

@include('footer')