<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\Kiosk;
use App\Models\OrderItem;
use Auth;
use DB;

class purchase_behaviour_export implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct(String $startDate = null, String $endDate = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        // dd($this->startDate);
    }
    public function collection()
    {
        $singleTransactions = OrderItem::where('qty', 1)->whereBetween('created_at', [$this->startDate, $this->endDate])->sum('qty');
        $singlePackUnit = OrderItem::where('qty', 1)->whereBetween('created_at', [$this->startDate, $this->endDate])->count();
        $singlePackTotal = OrderItem::where('qty', 1)->whereBetween('created_at', [$this->startDate, $this->endDate])->sum('total_amount');

        $towTransactions = OrderItem::whereBetween('qty', [2, 4])->whereBetween('created_at', [$this->startDate, $this->endDate])->sum('qty');
        $towPackUnit = OrderItem::whereBetween('qty', [2, 4])->whereBetween('created_at', [$this->startDate, $this->endDate])->count();
        $towPackTotal = OrderItem::whereBetween('qty', [2, 4])->whereBetween('created_at', [$this->startDate, $this->endDate])->sum('total_amount');

        $fiveTransactions = OrderItem::whereBetween('qty', [5, 7])->whereBetween('created_at', [$this->startDate, $this->endDate])->sum('qty');
        $fivePackUnit = OrderItem::whereBetween('qty', [5, 7])->whereBetween('created_at', [$this->startDate, $this->endDate])->count();
        $fivePackTotal = OrderItem::whereBetween('qty', [5, 7])->whereBetween('created_at', [$this->startDate, $this->endDate])->sum('total_amount');

        $eightTransactions = OrderItem::whereBetween('qty', [8, 10])->whereBetween('created_at', [$this->startDate, $this->endDate])->sum('qty');
        $eightPackUnit = OrderItem::whereBetween('qty', [8, 10])->whereBetween('created_at', [$this->startDate, $this->endDate])->count();
        $eightPackTotal = OrderItem::whereBetween('qty', [8, 10])->whereBetween('created_at', [$this->startDate, $this->endDate])->sum('total_amount');

        $tenTransactions = OrderItem::where('qty', '>', 10)->whereBetween('created_at', [$this->startDate, $this->endDate])->sum('qty');
        $tenPackUnit = OrderItem::where('qty', '>', 10)->whereBetween('created_at', [$this->startDate, $this->endDate])->count();
        $tenPackTotal = OrderItem::where('qty', '>', 10)->whereBetween('created_at', [$this->startDate, $this->endDate])->sum('total_amount');
        
        $packageArr = [
            'Pack1' => ['name' =>'Single Pack','singlePackUnit' => $singlePackUnit,'singleTransactions' => $singleTransactions,'singlePackTotal' => $singlePackTotal],
            'Pack2' => ['name'=>'2-4 Pack','towPackUnit' => $towPackUnit,'towTransactions' => $towTransactions,'towPackTotal' => $towPackTotal],
            'Pack3' => ['name'=>'5-7 Pack','fivePackUnit' => $fivePackUnit,'fiveTransactions' => $fiveTransactions,'fivePackTotal' => $fivePackTotal],
            'Pack4' => ['name'=>'8-10 Pack','eightPackUnit' => $eightPackUnit, 'eightPackTotal' => $eightPackTotal,'eightTransactions' => $eightTransactions ],
            'Pack5' => ['name'=>'Above 10 Pack','tenPackUnit' => $tenPackUnit,  'tenTransactions' => $tenTransactions, 'tenPackTotal' => $tenPackTotal],
        ];
        // dd($packageArr);
        return $packageArr;
    }

    public function headings(): array
    {
        return [
            'Pack',
            'Unit',
            'Transactions',
            'Amount (in INR)',
        ];
    }
}
