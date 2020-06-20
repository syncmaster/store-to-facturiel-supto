@include('header')

<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div class="head-title text-center">
                <h1>Продукти</h1>
            </div>
        </div>
    </div>
    <div class="row">
        <form action="{{route('search')}}" method="POST" class="form-inline" role="search">
            {{ csrf_field() }}
            <form class="form-inline" action="/action_page.php">
                <div class="form-group">
                  <label for="search">Търсене.:</label>
                  <input @isset($data['search']) value="{{$data['search']}}"@endisset type="search" name="search" class="form-control" id="search">
                </div>
                <div class="form-group">
                
                  <label for="shop">Магазини:</label>
                  <select class="form-control" id="shop" name="shop">
                      <option value="0">Всички</option>
                      @foreach($shops as $shop)
                        <option @if (isset($data['shop']) && $data['shop'] == $shop->id)selected="selected"@endif value="{{$shop->id}}">{{$shop->name}}</option>
                      @endforeach
                  </select>
                </div>
                <button type="submit" class="btn btn-default">Търси</button>
              </form>
        </form>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">   
                <table id="mytable" class="table table-bordred table-striped">
                    <thead>
                        <th>Поръчка</th>
                        <th>Цена</th>
                        <th>Магазин</th>
                        <th>Статус</th>
                        <th>Създаден</th>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                            <tr>
                                <td>{{$product->order_id}}</td>
                                <td>{{$product->price}}</td>
                                <td>{{$product->shops->name}}</td>
                                <td>{{$product->status}}</td>
                                <td>{{$product->created_at}}</td>
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