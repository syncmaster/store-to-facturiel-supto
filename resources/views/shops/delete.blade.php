@include('header')

<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div class="head-title text-center">
                <h1>Изтриване - {{$shop->name}} </h1>
            </div>
        </div>
    </div>
    <form method="POST" class="text-center">
        @csrf
        <input type="hidden" value="{{$shop->id}}"/>
        <button type="submit" class="btn btn-danger">Изтриване</button>
        <a href="{{route('shops.index')}}" class="btn btn-default">Върни се обратното</a>
    </form>
</div>
@include('footer')