<?php

namespace App\Charts;

use App\Models\OutletVisitProduct;

use ArielMejiaDev\LarapexCharts\LarapexChart;

class MarketShareChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\PieChart
    {
        $top5Item = OutletVisitProduct::selectRaw('count(outlet_visit_products.product_id) as product_count,products.name')
            ->join('products', 'products.id', 'outlet_visit_products.product_id')
            // ->whereMonth('outlet_visit_products.created_at', date('M'))
            ->groupBy('outlet_visit_products.product_id', 'products.name')
            // ->orderBy('outlet_visit_products.product_id', 'ASC')
            ->orderBy('product_count', 'DESC')
            ->limit(5)
            ->get();
        return $this->chart->pieChart()
            ->setTitle('Top 5 Market Share Produk')
            ->setSubtitle('Berdasarkan Kunjungan Karyawan')
            ->addData(array_map('intval',$top5Item->pluck('product_count')->toArray()))
            ->setLabels($top5Item->pluck('name')->toArray());
    }
}
