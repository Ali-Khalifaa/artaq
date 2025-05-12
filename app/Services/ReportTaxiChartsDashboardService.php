<?php

namespace App\Services;

use App\Enums\BookingStatus;
use App\Enums\InvoiceStatusEnum;
use App\Models\Invoice;
use Illuminate\Support\Facades\DB;

class ReportTaxiChartsDashboardService
{
    public function getTotalAmountOrCountForEachMonthInYear($year,$type){

        $totalAmountByMonth =Invoice::join('sys_invoice_payments', 'sys_invoice_payments.invoice_id', '=', 'sys_invoices.id')
        ->join("sys_bookings", "sys_bookings.id", "=", "sys_invoices.model_id")
        ->select(
            DB::raw("DATE_FORMAT(sys_invoices.created_at, '%M') as month"),
            DB::raw($type == 'count' ? 'COUNT(sys_bookings.id) as total_count' : 'SUM(sys_invoice_payments.amount) as total_amount')
        )
        ->where('sys_invoices.status', InvoiceStatusEnum::PAID->value)
        ->where('sys_bookings.status',BookingStatus::COMPLETED->value)
        ->whereYear('sys_invoices.created_at', $year)
        ->groupBy('month') // Ensure month is grouped correctly
        ->get();
        return $totalAmountByMonth;

    }

    public function getBookingsThroughMonthGroubByWeeks($q, $year, $month) {
        return $q
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->selectRaw('DAY(created_at) as day, COUNT(*) as count')
            ->groupBy('day') // Group by the day of the month
            ->get()
            ->map(function ($item) {
                // Get the week number in the month
                $day = (int) $item->day;
                $weekNumber = ceil($day / 7); // Calculate week number (1-4)
                $item->week = $this->getNameOfWeekInMounth($weekNumber); // Assuming this function takes week number
                return $item;
            })->groupBy('week')
            ->map(function ($item) {
                return [
                    'week' => $item[0]->week,
                    'number' => $item->sum('count'),
                ];
            })->values();

 
    }
    public function getInoviceAmountThroughMonthGroubByWeeks($q, $year, $month) {
        // Get the invoice amounts grouped by weeks
        return $q->join('sys_invoice_payments', 'sys_invoice_payments.invoice_id', '=', 'sys_invoices.id')
            ->whereYear('sys_invoices.created_at', $year)
            ->whereMonth('sys_invoices.created_at', $month)
            ->whereStatus(InvoiceStatusEnum::PAID->value)
            ->selectRaw('DAY(sys_invoices.created_at) as day, SUM(sys_invoice_payments.amount) as amount')
            ->groupBy('day') // Group by the day of the month
            ->get()
            ->map(function ($item) {
                // Calculate the week number in the month
                $day = (int) $item->day;
                $weekNumber = ceil($day / 7); // Calculate week number (1-4 or 5)
                $item->week = $this->getNameOfWeekInMounth($weekNumber); // Get week name
                return $item;
            })
            ->groupBy('week')
            ->map(function ($item) {
                return [
                    'week' => $item[0]->week,
                    'number' => $item->sum('amount'), // Sum of the amounts
                ];
            })
            ->values();
    }
    
    public function getNameOfWeekInMounth($week_number) {
        switch(true) {
            case ($week_number <= 1):
                $week_name = 'First Week';
                break;
            case ($week_number <= 2):
                $week_name = 'Second Week';
                break;
            case ($week_number <= 3):
                $week_name = 'Third Week';
                break;
            case ($week_number <= 4):
                $week_name = 'Fourth Week';
                break;
            case ($week_number <= 5):
                $week_name = 'Fifth Week';
                break;
            default:
                $week_name = 'Unknown Week'; // Fallback if needed
                break;
        }
        return $week_name;
    }}
