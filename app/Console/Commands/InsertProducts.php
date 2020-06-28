<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Shop;
use App\Product;
use Carbon\Carbon;
class InsertProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse:products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get Products from Shop and insert them to Factoriel';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $shops = Shop::get();
        foreach($shops as $shop) {
            $products = $this->parseXml($shop->url);
            $sales = $this->structureData($products);

            $settings = [
                'api_url' => env('FACTORIEL_URL'),
                'api_key' => $shop->api_key,
                'api_number' => $shop->api_number
            ];
            foreach($sales as $sale) {
                $status = $this->sendDataToFacturiel($sale, $settings);
                $this->insertProducts($sale, $shop->id, $status);
            }
        }

    }

    private function parseXml($url) {
        $xml = new \SimpleXmlIterator($url, null, true);
        $namespaces = $xml->getNamespaces(true);
        // echo '<pre>'; print_r($namespaces); die;
        $arr = $this->xmlToArray($xml,$namespaces);
        return $arr;
    }
    private function structureData($products) {
        $data = [];
        $products = $products['sale'];
        $count = count($products);
        for($i = 0; $i < $count; $i++) {

            $data[] = [
                'client_number' => $products[$i]['client_number'][0],
                'order_id' => (int) $products[$i]['order_id'][0],
                'payment_method_id' => $products[$i]['payment_method_id'][0],
                'total' => $products[$i]['total'][0],
                'var_percent' => $products[$i]['vat_percent'][0] > 0 ? $products[$i]['vat_percent'][0] : 0,
                'source_id' => $products[$i]['source_id'][0],
                'object_id' => $products[$i]['object_id'][0],
                'station_id' => $products[$i]['station_id'][0],
                'add_to_catalog' => $products[$i]['add_to_catalog'][0],
                'autoload_measure' => $products[$i]['autoload_measure'][0],
                'rows' => $this->structureRows($products[$i]['rows'])
            ];
        }

        return $data;
    }

    private function structureRows($rows) {
        $data = [];
        for ($i = 0; $i < count($rows[0]['name']); $i++) {
            $data[] = [
                'name' => isset($rows[0]['name'][$i]) ? $rows[0]['name'][$i] : null,
                'quantity' => isset($rows[0]['quantity'][$i]) ? $rows[0]['quantity'][$i] : null,
                'measure_id' => isset($rows[0]['measure_id'][$i]) ? $rows[0]['measure_id'][$i] : null,
                'price' => isset($rows[0]['price'][$i]) ? $rows[0]['price'][$i] : null,
                'discount_percent' => isset($rows[0]['discount_percent'][$i]) ? $rows[0]['discount_percent'][$i] : null,
                'code' => isset($rows[0]['code'][$i]) ? $rows[0]['code'][$i] : null,
            ];
        }

        return $data;
    }

    private function xmlToArray($xml,$ns=null){
        $a = array();
        for($xml->rewind(); $xml->valid(); $xml->next()) {
            $key = $xml->key();
            if(!isset($a[$key])) { $a[$key] = array(); $i=0; }
            else $i = count($a[$key]);
            $simple = true;
            foreach($xml->current()->attributes() as $k=>$v) {
                $a[$key][$i][$k]=(string)$v;
                $simple = false;
            }
            if($ns) foreach($ns as $nid=>$name) {
                foreach($xml->current()->attributes($name) as $k=>$v) {
                    $a[$key][$i][$nid.':'.$k]=(string)$v;
                    $simple = false;
                }
            }
            if($xml->hasChildren()) {
                if($simple) $a[$key][$i] = $this->xmlToArray($xml->current(), $ns);
                else $a[$key][$i]['contet'] = $this->xmlToArray($xml->current(), $ns);
            } else {
                if($simple) $a[$key][$i] = strval($xml->current());
                else $a[$key][$i]['content'] = strval($xml->current());
            }
         $i++;
        }
        return $a;
    }

    private function sendDataToFacturiel($sale, $settings = ['api_url' => '', 'api_key' => '', 'api_number' => '']) {
        if (empty($settings['api_url']) || empty($settings['api_key']) || empty($settings['api_number'])) {
            return;
        }

        $ch = curl_init();
        try{
            curl_setopt($ch, CURLOPT_URL, $settings['api_url']. 'sale_create');
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Basic '. base64_encode($settings['api_number'].':'.$settings['api_key'])));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(json_encode(['sale' => $sale])));
            $response = curl_exec($ch);
            $this->P($response);
            // $status = 'Успешно записан във Фактуриел с номер: ' .$response['sale']['id'];
          }catch (Exception $ex) {
            $status = 'Грешка: '.$ex->getMessage();
          }finally{
            curl_close($ch);
          }
        return $status;
    }

    private function insertProducts($products, $shopId, $status) {
        $data = [
            'shop_id' => $shopId,
            'order_id' => (int) $products['order_id'],
            'price' => $products['total'],
            'status' => $status,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ];

        Product::insert($data);
    }

    private function P($data) {
        echo "<pre>";
        print_r($data);
        echo "</pre>";
    }
}
