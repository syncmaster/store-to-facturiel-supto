<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Shop;
use Validator;
use Carbon\Carbon;

class ShopController extends Controller
{

    public function __construct() {
        $this->shops = new Shop();

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shops = $this->shops::orderBy('created_at', 'DESC')->get();
        return view('shops.index')->with('shops', $shops);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('shops.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'name' => 'required',
            'url' => 'required',
            'number' => 'required',
            'key' => 'required'
        ]);

        if ($validator->fails()) {
            return view('shops.create')->with(['errors' => $validator->messages(), 'data' => $data]);
        }

        $insert = [
            'name' => $data['name'],
            'url' => $data['url'],
            'api_number' => $data['number'],
            'api_key' => $data['key'],
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()

        ];

        try {
            $this->shops->create($insert);
            return view('shops.create')->with('success', 'Успешно добавен магазин');
        } catch (Exception $e) {
            return view('shops.create')->with('error', $e->getMessage());
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $shop = $this->shops->find($id);

        $data = [
            'id' => $shop->id,
            'name' => $shop->name,
            'number' => $shop->api_number,
            'key' => $shop->api_key,
            'url' => $shop->url
        ];

        return view('shops.edit')->with('data', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'name' => 'required',
            'url' => 'required',
            'number' => 'required',
            'key' => 'required'
        ]);

        $info = [
            'name' => $data['name'],
            'url' => $data['url'],
            'number' => $data['number'],
            'key' => $data['key']
        ];

        if ($validator->fails()) {
            return view('shops.edit', ['id' => $id])->with(['errors' => $validator->messages(), 'data' => $info]);
        }

        $update = [
            'id' => $id,
            'name' => $data['name'],
            'url' => $data['url'],
            'api_number' => $data['number'],
            'api_key' => $data['key'],
            'updated_at' => Carbon::now()

        ];

        $data = [
            'id' => $id,
            'name' => $data['name'],
            'url' => $data['url'],
            'number' => $data['number'],
            'key' => $data['key']
        ];
        
        try {
            $this->shops->updateShop($id, $update);
            return view('shops.edit', ['id' => $id])->with(['success'=> 'Успешно редактиран магазин', 'data' => $data]);
        } catch (Exception $e) {
            return view('shops.edit', ['id' => $id])->with(['error' => $e->getMessage(), 'data' => $data]);
        }
    }

    public function delete($id) {
        $shop = $this->shops->find($id);

        return view('shops.delete')->with('shop', $shop);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $this->shops->destroyShop($id);
            $shops = $this->shops::orderBy('created_at', 'DESC')->get();
            return view('shops.index')->with('shops', $shops);
        } catch(Exception $e) {
            return view('shops.delete', ['id' => $id])->with('error', $e->getMessage());
        }
    }
}
