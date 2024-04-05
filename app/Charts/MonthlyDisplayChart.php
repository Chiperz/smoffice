<?php

namespace App\Charts;

use App\Models\DetailStoreVisit;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class MonthlyDisplayChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\PieChart
    {
        $display = DetailStoreVisit::selectRaw('count(category_product_id')
            ->join('display_products', 'display_products.id', 'detail_store_visits.display_product_id')
            ->groupBy('month' ,'detail_store_visits.display_product_id', 'display_products.name')
            ->whereBetween('month', [date('m', strtotime('-3 months')), date('m')])
            ->get();

        return $this->chart->pieChart()
            ->setTitle('')
            // ->setSubtitle('Season 2021.')
            ->addData([40, 50, 30])
            ->setLabels(['Player 7', 'Player 10', 'Player 9']);
    }
}
