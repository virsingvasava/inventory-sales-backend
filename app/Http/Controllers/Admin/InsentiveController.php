<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Kiosk;
use App\Models\OrderItem;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\InsentiveExport;

class InsentiveController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function insentive(Request $request)
    {
        $InsenviteResponse = Order::select('id','sale_by_user_id','kiosk_id','total_amount','payment_mode','order_receipt')->with(['sales_person' => function($row){ $row->select('id','name','email','mobile','user_id','profile_img'); },'kiosk_details' => function($row){ $row->select('id','kiosk_id','city_id','kiosk_name','outlet_location_id','airport')->with(['single_city_name' => function($row){ $row->select('id','name'); },'outlet_location_single' => function($row){ $row->select('id','name'); }]); }, 'order_items' => function($row){ $row->select('user_id','order_id','product_id','city_id','qty','price','total_amount','order_date')->with(['products_detail' => function($row){ $row->select('id','brand_id','sku','name','packge_size','price','discount','image','text','status'); }]); }])->where('payment_mode','!=','Cash')->orderBy('id','DESC')->get()->toArray();

        $responseArr = [];
        $i = 0;
        if(!empty($InsenviteResponse) && count($InsenviteResponse) > 0)
        {
            foreach($InsenviteResponse as $key => $value)
            {
                if(!empty($value['order_items']) && count($value['order_items']) > 0)
                {
                    foreach($value['order_items'] as $k => $v)
                    {
                        if(!empty($v['products_detail']))
                        {
                            if((int)$v['products_detail']['packge_size'] == 20 || (int)$v['products_detail']['packge_size'] == 16)
                            {

                                if((int)$v['qty'] == 1)
                                {   
                                    if(in_array($v['products_detail']['sku'],['CLS_017','C_21','GF_008']))
                                    {
                                        $responseArr[$i]['product_id'] = $v['products_detail']['id'];
                                        $responseArr[$i]['product_name'] = $v['products_detail']['name'];
                                        $responseArr[$i]['product_price'] = $v['products_detail']['price'];
                                        $responseArr[$i]['product_package_size'] = $v['products_detail']['packge_size'];
                                        $responseArr[$i]['sku'] = $v['products_detail']['sku'];
                                        $responseArr[$i]['qty'] = $v['qty'];
                                        $responseArr[$i]['order_date'] = $v['order_date'];
                                        $responseArr[$i]['order_receipt'] = $value['order_receipt'];
                                        $responseArr[$i]['payment_mode'] = $value['payment_mode'];
                                        $responseArr[$i]['sale_by_user_id'] = $value['sale_by_user_id'];
                                        $responseArr[$i]['sale_person_name'] = "";
                                        $responseArr[$i]['sale_person_email'] = "";
                                        $responseArr[$i]['sale_person_mobile'] = "";
                                        $responseArr[$i]['sale_person_user_id'] = "";
                                        $responseArr[$i]['sale_person_profile_img'] = "";
                                        if(!empty($value['sales_person']))
                                        {
                                            $responseArr[$i]['sale_person_name'] = $value['sales_person']['name'];
                                            $responseArr[$i]['sale_person_email'] = $value['sales_person']['email'];
                                            $responseArr[$i]['sale_person_mobile'] = $value['sales_person']['mobile'];
                                            $responseArr[$i]['sale_person_user_id'] = $value['sales_person']['user_id'];
                                            $responseArr[$i]['sale_person_profile_img'] = $value['sales_person']['profile_img'];
                                        }

                                        $responseArr[$i]['kiosk_id'] = $value['kiosk_id'];
                                        $responseArr[$i]['kiosk_detail_id'] = "";
                                        $responseArr[$i]['kiosk_name'] = "";
                                        $responseArr[$i]['kiosk_airport'] = "";
                                        $responseArr[$i]['kiosk_city'] = "";
                                        $responseArr[$i]['kiosk_outlet'] = "";
                                        $responseArr[$i]['ecpa_consumer'] = 0;
                                        $responseArr[$i]['ecpa_staff'] = 0;
                                        if(!empty($value['kiosk_details']))
                                        {
                                            $responseArr[$i]['kiosk_id'] = $value['kiosk_id'];
                                            $responseArr[$i]['kiosk_detail_id'] = $value['kiosk_details']['kiosk_id'];
                                            $responseArr[$i]['kiosk_name'] = $value['kiosk_details']['kiosk_name'];
                                            $responseArr[$i]['kiosk_airport'] = $value['kiosk_details']['airport'];
                                            if(!empty($value['kiosk_details']['single_city_name']))
                                            {
                                                $name = $value['kiosk_details']['single_city_name']['name'];
                                                $responseArr[$i]['kiosk_city'] = $name;;
                                            }
                                            if(!empty($value['kiosk_details']['outlet_location_single']))
                                            {
                                                $name = $value['kiosk_details']['outlet_location_single']['name'];
                                                $responseArr[$i]['kiosk_outlet'] = $name;
                                            }
                                        }
                                        $responseArr[$i]['ecpa_consumer'] = 20;
                                        $responseArr[$i]['ecpa_staff'] = 15;
                                    }
                                }
                                else
                                {
                                    $responseArr[$i]['product_id'] = $v['products_detail']['id'];
                                    $responseArr[$i]['product_name'] = $v['products_detail']['name'];
                                    $responseArr[$i]['product_price'] = $v['products_detail']['price'];
                                    $responseArr[$i]['product_package_size'] = $v['products_detail']['packge_size'];
                                    $responseArr[$i]['sku'] = $v['products_detail']['sku'];
                                    $responseArr[$i]['qty'] = $v['qty'];
                                    $responseArr[$i]['order_date'] = $v['order_date'];
                                    $responseArr[$i]['order_receipt'] = $value['order_receipt'];
                                    $responseArr[$i]['payment_mode'] = $value['payment_mode'];
                                    $responseArr[$i]['sale_by_user_id'] = $value['sale_by_user_id'];
                                    $responseArr[$i]['sale_person_name'] = "";
                                    $responseArr[$i]['sale_person_email'] = "";
                                    $responseArr[$i]['sale_person_mobile'] = "";
                                    $responseArr[$i]['sale_person_user_id'] = "";
                                    $responseArr[$i]['sale_person_profile_img'] = "";
                                    if(!empty($value['sales_person']))
                                    {
                                        $responseArr[$i]['sale_person_name'] = $value['sales_person']['name'];
                                        $responseArr[$i]['sale_person_email'] = $value['sales_person']['email'];
                                        $responseArr[$i]['sale_person_mobile'] = $value['sales_person']['mobile'];
                                        $responseArr[$i]['sale_person_user_id'] = $value['sales_person']['user_id'];
                                        $responseArr[$i]['sale_person_profile_img'] = $value['sales_person']['profile_img'];
                                    }

                                    $responseArr[$i]['kiosk_id'] = $value['kiosk_id'];
                                    $responseArr[$i]['kiosk_detail_id'] = "";
                                    $responseArr[$i]['kiosk_name'] = "";
                                    $responseArr[$i]['kiosk_airport'] = "";
                                    $responseArr[$i]['kiosk_city'] = "";
                                    $responseArr[$i]['kiosk_outlet'] = "";
                                    $responseArr[$i]['ecpa_consumer'] = 0;
                                    $responseArr[$i]['ecpa_staff'] = 0;
                                    if(!empty($value['kiosk_details']))
                                    {
                                        $responseArr[$i]['kiosk_id'] = $value['kiosk_id'];
                                        $responseArr[$i]['kiosk_detail_id'] = $value['kiosk_details']['kiosk_id'];
                                        $responseArr[$i]['kiosk_name'] = $value['kiosk_details']['kiosk_name'];
                                        $responseArr[$i]['kiosk_airport'] = $value['kiosk_details']['airport'];
                                        if(!empty($value['kiosk_details']['single_city_name']))
                                        {
                                            $name = $value['kiosk_details']['single_city_name']['name'];
                                            $responseArr[$i]['kiosk_city'] = $name;;
                                        }
                                        if(!empty($value['kiosk_details']['outlet_location_single']))
                                        {
                                            $name = $value['kiosk_details']['outlet_location_single']['name'];
                                            $responseArr[$i]['kiosk_outlet'] = $name;
                                        }
                                    }

                                    if((int)$v['qty'] == 2 || (int)$v['qty'] == 3)
                                    {
                                        $responseArr[$i]['ecpa_consumer'] = 40;
                                        $responseArr[$i]['ecpa_staff'] = 40;
                                    }

                                    if((int)$v['qty'] == 4)
                                    {
                                        $responseArr[$i]['ecpa_consumer'] = 80;
                                        $responseArr[$i]['ecpa_staff'] = 80;
                                    }

                                    if((int)$v['qty'] == 5)
                                    {
                                        $responseArr[$i]['ecpa_consumer'] = 100;
                                        $responseArr[$i]['ecpa_staff'] = 60;
                                    }

                                    if((int)$v['qty'] == 6)
                                    {
                                        $responseArr[$i]['ecpa_consumer'] = 120;
                                        $responseArr[$i]['ecpa_staff'] = 120;
                                    }

                                    if((int)$v['qty'] == 7)
                                    {
                                        $responseArr[$i]['ecpa_consumer'] = 140;
                                        $responseArr[$i]['ecpa_staff'] = 100;
                                    }

                                    if((int)$v['qty'] == 8)
                                    {
                                        $responseArr[$i]['ecpa_consumer'] = 160;
                                        $responseArr[$i]['ecpa_staff'] = 160;
                                    }

                                    if((int)$v['qty'] == 9)
                                    {
                                        $responseArr[$i]['ecpa_consumer'] = 180;
                                        $responseArr[$i]['ecpa_staff'] = 140;
                                    }

                                    if((int)$v['qty'] == 10)
                                    {
                                        $responseArr[$i]['ecpa_consumer'] = 200;
                                        $responseArr[$i]['ecpa_staff'] = 100;
                                    }
                                }

                            }

                            if((int)$v['products_detail']['packge_size'] == 10)
                            {
                                if((int)$v['qty'] == 1)
                                {   
                                    if(in_array($v['products_detail']['sku'],['CLS_017','C_21','GF_008']))
                                    {
                                        $responseArr[$i]['product_id'] = $v['products_detail']['id'];
                                        $responseArr[$i]['product_name'] = $v['products_detail']['name'];
                                        $responseArr[$i]['product_price'] = $v['products_detail']['price'];
                                        $responseArr[$i]['product_package_size'] = $v['products_detail']['packge_size'];
                                        $responseArr[$i]['sku'] = $v['products_detail']['sku'];
                                        $responseArr[$i]['qty'] = $v['qty'];
                                        $responseArr[$i]['order_date'] = $v['order_date'];
                                        $responseArr[$i]['order_receipt'] = $value['order_receipt'];
                                        $responseArr[$i]['payment_mode'] = $value['payment_mode'];
                                        $responseArr[$i]['sale_by_user_id'] = $value['sale_by_user_id'];
                                        $responseArr[$i]['sale_person_name'] = "";
                                        $responseArr[$i]['sale_person_email'] = "";
                                        $responseArr[$i]['sale_person_mobile'] = "";
                                        $responseArr[$i]['sale_person_user_id'] = "";
                                        $responseArr[$i]['sale_person_profile_img'] = "";
                                        if(!empty($value['sales_person']))
                                        {
                                            $responseArr[$i]['sale_person_name'] = $value['sales_person']['name'];
                                            $responseArr[$i]['sale_person_email'] = $value['sales_person']['email'];
                                            $responseArr[$i]['sale_person_mobile'] = $value['sales_person']['mobile'];
                                            $responseArr[$i]['sale_person_user_id'] = $value['sales_person']['user_id'];
                                            $responseArr[$i]['sale_person_profile_img'] = $value['sales_person']['profile_img'];
                                        }

                                        $responseArr[$i]['kiosk_id'] = $value['kiosk_id'];
                                        $responseArr[$i]['kiosk_detail_id'] = "";
                                        $responseArr[$i]['kiosk_name'] = "";
                                        $responseArr[$i]['kiosk_airport'] = "";
                                        $responseArr[$i]['kiosk_city'] = "";
                                        $responseArr[$i]['kiosk_outlet'] = "";
                                        $responseArr[$i]['ecpa_consumer'] = 0;
                                        $responseArr[$i]['ecpa_staff'] = 0;
                                        if(!empty($value['kiosk_details']))
                                        {
                                            $responseArr[$i]['kiosk_id'] = $value['kiosk_id'];
                                            $responseArr[$i]['kiosk_detail_id'] = $value['kiosk_details']['kiosk_id'];
                                            $responseArr[$i]['kiosk_name'] = $value['kiosk_details']['kiosk_name'];
                                            $responseArr[$i]['kiosk_airport'] = $value['kiosk_details']['airport'];
                                            if(!empty($value['kiosk_details']['single_city_name']))
                                            {
                                                $name = $value['kiosk_details']['single_city_name']['name'];
                                                $responseArr[$i]['kiosk_city'] = $name;;
                                            }
                                            if(!empty($value['kiosk_details']['outlet_location_single']))
                                            {
                                                $name = $value['kiosk_details']['outlet_location_single']['name'];
                                                $responseArr[$i]['kiosk_outlet'] = $name;
                                            }
                                        }
                                        $responseArr[$i]['ecpa_consumer'] = 10;
                                        $responseArr[$i]['ecpa_staff'] = 10;
                                    }
                                }
                                else
                                {
                                    $responseArr[$i]['product_id'] = $v['products_detail']['id'];
                                    $responseArr[$i]['product_name'] = $v['products_detail']['name'];
                                    $responseArr[$i]['product_price'] = $v['products_detail']['price'];
                                    $responseArr[$i]['product_package_size'] = $v['products_detail']['packge_size'];
                                    $responseArr[$i]['sku'] = $v['products_detail']['sku'];
                                    $responseArr[$i]['qty'] = $v['qty'];
                                    $responseArr[$i]['order_date'] = $v['order_date'];
                                    $responseArr[$i]['order_receipt'] = $value['order_receipt'];
                                    $responseArr[$i]['payment_mode'] = $value['payment_mode'];
                                    $responseArr[$i]['sale_by_user_id'] = $value['sale_by_user_id'];
                                    $responseArr[$i]['sale_person_name'] = "";
                                    $responseArr[$i]['sale_person_email'] = "";
                                    $responseArr[$i]['sale_person_mobile'] = "";
                                    $responseArr[$i]['sale_person_user_id'] = "";
                                    $responseArr[$i]['sale_person_profile_img'] = "";
                                    if(!empty($value['sales_person']))
                                    {
                                        $responseArr[$i]['sale_person_name'] = $value['sales_person']['name'];
                                        $responseArr[$i]['sale_person_email'] = $value['sales_person']['email'];
                                        $responseArr[$i]['sale_person_mobile'] = $value['sales_person']['mobile'];
                                        $responseArr[$i]['sale_person_user_id'] = $value['sales_person']['user_id'];
                                        $responseArr[$i]['sale_person_profile_img'] = $value['sales_person']['profile_img'];
                                    }

                                    $responseArr[$i]['kiosk_id'] = $value['kiosk_id'];
                                    $responseArr[$i]['kiosk_detail_id'] = "";
                                    $responseArr[$i]['kiosk_name'] = "";
                                    $responseArr[$i]['kiosk_airport'] = "";
                                    $responseArr[$i]['kiosk_city'] = "";
                                    $responseArr[$i]['kiosk_outlet'] = "";
                                    $responseArr[$i]['ecpa_consumer'] = 0;
                                    $responseArr[$i]['ecpa_staff'] = 0;
                                    if(!empty($value['kiosk_details']))
                                    {
                                        $responseArr[$i]['kiosk_id'] = $value['kiosk_id'];
                                        $responseArr[$i]['kiosk_detail_id'] = $value['kiosk_details']['kiosk_id'];
                                        $responseArr[$i]['kiosk_name'] = $value['kiosk_details']['kiosk_name'];
                                        $responseArr[$i]['kiosk_airport'] = $value['kiosk_details']['airport'];
                                        if(!empty($value['kiosk_details']['single_city_name']))
                                        {
                                            $name = $value['kiosk_details']['single_city_name']['name'];
                                            $responseArr[$i]['kiosk_city'] = $name;;
                                        }
                                        if(!empty($value['kiosk_details']['outlet_location_single']))
                                        {
                                            $name = $value['kiosk_details']['outlet_location_single']['name'];
                                            $responseArr[$i]['kiosk_outlet'] = $name;
                                        }
                                    }
                                    if((int)$v['qty'] == 2 || (int)$v['qty'] == 3)
                                    {
                                        $responseArr[$i]['ecpa_consumer'] = 20;
                                        $responseArr[$i]['ecpa_staff'] = 20;
                                    }

                                    if((int)$v['qty'] == 4)
                                    {
                                        $responseArr[$i]['ecpa_consumer'] = 40;
                                        $responseArr[$i]['ecpa_staff'] = 40;
                                    }

                                    if((int)$v['qty'] == 5)
                                    {
                                        $responseArr[$i]['ecpa_consumer'] = 50;
                                        $responseArr[$i]['ecpa_staff'] = 30;
                                    }

                                    if((int)$v['qty'] == 6)
                                    {
                                        $responseArr[$i]['ecpa_consumer'] = 60;
                                        $responseArr[$i]['ecpa_staff'] = 60;
                                    }

                                    if((int)$v['qty'] == 7)
                                    {
                                        $responseArr[$i]['ecpa_consumer'] = 70;
                                        $responseArr[$i]['ecpa_staff'] = 50;
                                    }

                                    if((int)$v['qty'] == 8)
                                    {
                                        $responseArr[$i]['ecpa_consumer'] = 80;
                                        $responseArr[$i]['ecpa_staff'] = 80;
                                    }

                                    if((int)$v['qty'] == 9)
                                    {
                                        $responseArr[$i]['ecpa_consumer'] = 90;
                                        $responseArr[$i]['ecpa_staff'] = 70;
                                    }

                                    if((int)$v['qty'] == 10)
                                    {
                                        $responseArr[$i]['ecpa_consumer'] = 100;
                                        $responseArr[$i]['ecpa_staff'] = 50;
                                    }
                                }
                            }
                        }
                    }   
                }
                $i++;
            }
        }

        $responseArr = array_values($responseArr);

        return view('admin.ajax_insentive',compact('responseArr'));
    }

    public function insentiveExport(Request $request)
    {
        return Excel::download(new InsentiveExport(), 'insentive.csv');
    }
}
