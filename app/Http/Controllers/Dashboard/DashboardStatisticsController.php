<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Resources\Dashboard\DatabaseBackupResource;
use App\Models\Booking;
use App\Models\Invoice;
use App\Models\InvoicePayment;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Modules\Driver\Models\Driver;
use Modules\User\Models\User;
use App\Enums\BookingStatus;
use App\Enums\InvoiceStatusEnum;
use App\Models\NextBooking;
use App\Services\ReportTaxiChartsDashboardService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardStatisticsController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return [
            new Middleware('can:Dashboard', only: ['index','getTotalRevenuePerMonths','getTotalRevenueForEachYearPerMonths']),
        ];
    }


    public function __construct(private ReportTaxiChartsDashboardService $reportTaxiChartsDashboardService)
    {

    }

    public function index(Request $request)
    {

        $statistics = [];
        $statistics['top_five_users_has_bookings'] =
        User::select('id','name','phone','image')->withCount(['bookings' => function($q) {
            $q->where('sys_bookings.status', BookingStatus::COMPLETED->value);
        }])->orderByDesc('bookings_count')->take(5)->get()->map(function($item) {
            return [
                'id' => $item->id,
                'name' => $item->name,
                'phone' => $item->phone,
                'image' => $item->image,
                'rating_average' => $item->rating_average,
                'number_of_rated_bookings' => $item->number_of_rated_bookings,
                'bookings_count' => $item->bookings_count,
            ];
        });
        

        $statistics['top_five_drivers_has_bookings'] =
        Driver::select('id','name','phone')->withCount(['bookings' => function($q) {
            $q->where('sys_bookings.status', BookingStatus::COMPLETED->value);
        }])->orderByDesc('bookings_count')->take(5)->get()->map(function($item) {
            return [
                'id' => $item->id,
                'name' => $item->name,
                'phone' => $item->phone,
                'image' => $item->image,
                'rating_average' => $item->rating_average,
                'number_of_rated_bookings' => $item->number_of_rated_bookings,
                'bookings_count' => $item->bookings_count,
            ];
        });

        $statistics['total_amount_for_each_month_in_year'] = $this->reportTaxiChartsDashboardService->getTotalAmountOrCountForEachMonthInYear(now()->year, 'amount');
        $statistics['total_count_for_each_month_in_year'] = $this->reportTaxiChartsDashboardService->getTotalAmountOrCountForEachMonthInYear(now()->year, 'count');

        $last_month_date = now()->subMonth();
        $statistics['bookings_for_current_month'] =  $this->reportTaxiChartsDashboardService->getBookingsThroughMonthGroubByWeeks(Booking::where('status', BookingStatus::COMPLETED->value),now()->year, now()->month);
        $statistics['bookings_for_last_month'] =  $this->reportTaxiChartsDashboardService->getBookingsThroughMonthGroubByWeeks(Booking::where('status', BookingStatus::COMPLETED->value),$last_month_date->year, $last_month_date->month);
        
        $statistics['invoices_amount_for_current_month'] =  $this->reportTaxiChartsDashboardService->getInoviceAmountThroughMonthGroubByWeeks(Invoice::query(),now()->year, now()->month);
        $statistics['invoices_amount_for_last_month'] =  $this->reportTaxiChartsDashboardService->getInoviceAmountThroughMonthGroubByWeeks(Invoice::query(),$last_month_date->year, $last_month_date->month);
       
        $peakPeriods = getPeakPeriod('sys_bookings');
        $statistics['peak_periods'] = $peakPeriods?$peakPeriods['periods']:[];    



        // client
        $statistics['clientActiveCount'] = User::where('status',1)->count();
        $statistics['clientDeActiveCount'] = User::where('status',0)->count();
        $statistics['clientCount'] = $statistics['clientActiveCount'] + $statistics['clientDeActiveCount'];

        //driver
        $statistics['driverActiveCount'] = Driver::where('status',1)->where('is_approve',1)->count();
        $statistics['driverDeActiveCount'] = Driver::where('status',0)->where('is_approve',1)->count();
        $statistics['driverCount'] = $statistics['driverActiveCount'] + $statistics['driverDeActiveCount'];

        //invoices
        $statistics['invoiceCount'] = Invoice::count();
        $statistics['invoiceRevenue'] = InvoicePayment::whereRelation('invoice','status',InvoiceStatusEnum::PAID->value)->sum('amount');
        $statistics['invoiceStatisticsMonth'] = InvoicePayment::whereRelation('invoice','status',InvoiceStatusEnum::PAID->value)
        ->whereMonth('created_at', now()->month)
        ->selectRaw('DATE(created_at) as day, SUM(amount) as total_amount')
        ->groupBy('day')
        ->orderBy('day')
        ->get();

        //booking
        $statistics['pending_booking'] = Booking::where('status', BookingStatus::PENDING)->count();
        $statistics['processing_booking'] = Booking::where('status', BookingStatus::PROCESSING)->count();
        $statistics['started_booking'] = Booking::where('status', BookingStatus::STARTED)->count();
        $statistics['completed_booking'] = Booking::where('status', BookingStatus::COMPLETED)->count();
        $statistics['canceled_booking'] = Booking::where('status', BookingStatus::CANCELED)->count();
        $statistics['total_booking'] = $statistics['pending_booking'] + $statistics['processing_booking'] + $statistics['started_booking'] + $statistics['completed_booking'] + $statistics['canceled_booking'];

        //next booking
        $statistics['pending_next_booking'] = NextBooking::where('status', BookingStatus::PENDING)->count();
        $statistics['processing_next_booking'] = NextBooking::where('status', BookingStatus::PROCESSING)->count();
        $statistics['started_next_booking'] = NextBooking::where('status', BookingStatus::STARTED)->count();
        $statistics['completed_next_booking'] = NextBooking::where('status', BookingStatus::COMPLETED)->count();
        $statistics['canceled_next_booking'] = NextBooking::where('status', BookingStatus::CANCELED)->count();
        $statistics['total_next_booking'] = $statistics['pending_next_booking'] + $statistics['processing_next_booking'] + $statistics['started_next_booking'] + $statistics['completed_next_booking'] + $statistics['canceled_next_booking'];

        return responseJson($statistics,
            'Dashboard Statistics',
            200
        );

    }


    public function getTotalRevenuePerMonths(){
        $statistics['requests_data'] = Booking::
        join('sys_invoices', 'sys_invoices.model_id', 'sys_bookings.id')
        ->join('sys_invoice_payments', 'sys_invoice_payments.invoice_id', '=', 'sys_invoices.id')
        ->select(
            DB::raw("DATE_FORMAT(sys_invoices.created_at, '%M') as month"),
            DB::raw('SUM(sys_invoice_payments.amount) as total')
        )
        ->where('sys_invoices.status', InvoiceStatusEnum::PAID->value)
        ->where('sys_invoices.model_type',Booking::class)
        ->where('sys_bookings.status',BookingStatus::COMPLETED->value)
        ->when(request()->date_from, function ($query) {
            $query->where('sys_bookings.created_at', '>=', request()->date_from);
        })
        ->when(request()->date_to, function ($query) {
            $query->where('sys_bookings.created_at', '<=', request()->date_to);
        })
        ->groupBy('month')
        ->get()->values();

        return response()->json(['statistics' => $statistics]);
    }

   
    public function getTotalRevenueForEachYearPerMonths(){

        $currentYear = now()->year;
        $startDate = Carbon::createFromDate(($currentYear-1),1, 1);
        $endDate = Carbon::createFromDate($currentYear, 12, 31);

        if (request()->date_from)
            $startDate = Carbon::parse(request()->date_from);


        if(request()->date_to)
            $endDate = Carbon::parse(request()->date_to);


        $statistics['requests_data'] = [];
        while ($startDate <= $endDate) {
            $date = $startDate->format('Y');

            $data = Invoice::join('sys_invoice_payments', 'sys_invoice_payments.invoice_id', '=', 'sys_invoices.id')
            ->select(
                DB::raw("DATE_FORMAT(sys_invoices.created_at, '%M') as month"), // Use DATE_FORMAT for month
                DB::raw("SUM(sys_invoice_payments.amount) as total")
            )
            ->where('sys_invoices.status', InvoiceStatusEnum::PAID->value)
            ->whereRaw("YEAR(sys_invoices.created_at) = ?", [$date]) // Use YEAR() to filter by year
            ->groupBy('month')
            ->get()
            ->map(function($item) use ($date) {
                return [
                    'name' => $date,
                    'month' => $item->month,
                    'total' => $item->total,
                ];
            });
            if($data->count() == 0)
                $data []= ['name' => $date,'month' => '','total' => 0];
            
            $statistics['requests_data'][] = $data;

            $startDate->addYear();
        }

        return response()->json(['statistics' => $statistics]);
    }

}
