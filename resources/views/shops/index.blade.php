@include('header')

<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div class="head-title text-center">
                <h1>Магазини</h1>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="add text-right">
            <a href="{{route('shops.create')}}" class="btn btn-primary">Добави </a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">   
                <table id="mytable" class="table table-bordred table-striped">
                    <thead>
                        <th>Име</th>
                        <th>Api номер</th>
                        <th>Api ключ</th>
                        <th>Линк към продуктите</th>
                        <th>Създаден</th>
                        <th>Опции</th>
                    </thead>
                    <tbody>
                        @foreach($shops as $shop)
                            <tr>
                                <td>{{$shop->name}}</td>
                                <td>{{$shop->api_number}}</td>
                                <td>{{$shop->api_key}}</td>
                                <td><a href="{{$shop->url}}" target="_blank">Линк</a></td>
                                <td>{{$shop->created_at}}</td>
                                <td>
                                    <a href="{{route('shops.edit', ['id' => $shop->id])}}" class=" btn btn-primary">Редактирай</a>
                                    <a href="{{route('shops.delete', ['id' => $shop->id])}}" class=" btn btn-danger">Изтрий</a>
                                </td>
                            </tr>
                        @endforeach
                        
                        
                    </tbody>
            
                </table>

                <div class="clearfix"></div>
            </div>  
        </div>
	</div>
</div>

@include('footer')