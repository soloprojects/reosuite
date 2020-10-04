<?php

namespace App\Http\Controllers;

use App\Helpers\Finance;
use App\Helpers\Utility;
use App\Helpers\Notify;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;
use Input;
use Hash;
use DB;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\model\AccountJournal;
use App\model\JournalExtension;
use App\model\TransClass;
use App\model\TransLocation;
use App\model\AccountChart;
use App\model\FinancialYear;
use Hamcrest\Util;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Log;

class VendorReportController extends Controller
{
    //

    public function vendorReport(Request $request)
    {
        //
        //$req = new Request();
        $finYear = FinancialYear::getAllData();
        $transClass = TransClass::getAllData();
        $transLocation = TransLocation::getAllData();

        
            return view::make('vendor_report.main_view')->with('transClass',$transClass)
            ->with('transLocation',$transLocation)->with('finYear',$finYear);
     
    }

    public static function inventoryReport(Request $request){       
        
        $from = $request->input('from_date'); $to = $request->input('to_date');
        $mainData = Finance::contactAccountInventoryReport($request);

        if(!empty($mainData)){
        return view::make('vendor_report.inventory_report')->with('mainData',$mainData)
            ->with('from',$from)->with('to',$to);
        }else{
            return 'No Results Found';
        }

    }

    public static function accountsReport(Request $request){       
        
        $from = $request->input('from_date'); $to = $request->input('to_date');
        $mainData = Finance::contactAccountInventoryReport($request);

        if(!empty($mainData)){
        return view::make('vendor_report.account_report')->with('mainData',$mainData)
            ->with('from',$from)->with('to',$to);
        }else{
            return 'No Results found';
        }

    }

    public static function contactTransactionReport(Request $request){

        $from = $request->input('from_date'); $to = $request->input('to_date');
        
        $mainData = Finance::contactTransactionReport($request);
        $chartData = $mainData->chartData;

        return view::make('vendor_report.transaction_report')->with('mainData',$mainData)
            ->with('chartData',$chartData)->with('from',$from)->with('to',$to);

    }

    public static function openBillReport(Request $request){

        $from = $request->input('from_date'); $to = $request->input('to_date');
        
        $mainData = Finance::openBillReport($request);
        
        return view::make('vendor_report.open_bill')->with('mainData',$mainData)
            ->with('from',$from)->with('to',$to);

    }

    public static function overdueBillReport(Request $request){

        $from = $request->input('from'); $to = $request->input('to');
        
        $mainData = Finance::overdueBillReport($request);

        return view::make('vendor_report.overdue_bill')->with('mainData',$mainData)
            ->with('from',$from)->with('to',$to);

    }

}
