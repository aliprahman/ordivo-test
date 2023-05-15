<?php

namespace App\Exports;

use App\Models\Order;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class OrderExport implements FromQuery, WithHeadings, ShouldAutoSize, ShouldQueue
{
    public function headings(): array
    {
        return [
            'Order Code',
            'Order Date',
            'User',
            'Quantity',
            'Total',
        ];
    }

    public function query()
    {
        return Order::query()
            ->select('order_code', 'orders.created_at as order_date', 'users.name as user_name', 'total_quantity', 'total_price')
            ->join('users', 'users.id', '=', 'orders.user_id');
    }
}
