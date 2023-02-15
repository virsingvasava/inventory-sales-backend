<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\Order;
use Auth;
use DB;

class InsentiveExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct()
    {
    }

    public function collection()
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

        $arr = [];
        if(!empty($responseArr) && count($responseArr) > 0)
        {
            foreach($responseArr as $k => $v)
            {
                $arr[$k]['sr_no'] = $k+1;
                $arr[$k]['sales_person'] = $v['sale_person_name'];
                $arr[$k]['kiosk_city'] = $v['kiosk_city'];
                $arr[$k]['kiosk_outlet'] = $v['kiosk_outlet'];
                $arr[$k]['kiosk_name'] = $v['kiosk_name'];
                $arr[$k]['kiosk_airport'] = $v['kiosk_airport'];
                $arr[$k]['FY'] = date('Y',strtotime($v['order_date']));
                $arr[$k]['date'] = date('d-m-Y',strtotime($v['order_date']));
                $arr[$k]['month'] = date('M Y',strtotime($v['order_date']));
                $arr[$k]['packge_size'] = $v['product_package_size'];
                $arr[$k]['brand_name'] = $v['product_name'];
                $arr[$k]['sku'] = $v['sku'];
                $arr[$k]['order_receipt'] = '';
                if($v['order_receipt'] != "")
                {
                    $arr[$k]['order_receipt'] = asset('assets/order_receipt/'.$v['order_receipt']);
                }
                $arr[$k]['payment_mode'] = $v['payment_mode'];
                $arr[$k]['qty'] = $v['qty'];
                $arr[$k]['ecpa_consumer'] = $v['ecpa_consumer'];
                $arr[$k]['ecpa_staff'] = $v['ecpa_staff'];
            }
        }

        return $arr;
    }

    public function headings(): array
    {
        return [
            'Sr.No.',
            'Sales Person',
            'City',
            'Outlet',
            'Outlet Location',
            'Domestic/International',
            'FY',
            'Date',
            'Month',
            'Pack size',
            'Brand Name',
            'SKU Name',
            'Order Receipt',
            'Payment Mode',
            'QTY',
            'ECPA Consumer',
            'ECPA Staff'
        ];
    }
}
