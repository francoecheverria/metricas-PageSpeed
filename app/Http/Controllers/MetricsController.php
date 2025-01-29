<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\MetricHistoryRun;
use App\Models\Strategy;
use Symfony\Component\HttpClient\HttpClient;
use Yajra\DataTables\DataTables;

class MetricsController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $strategies = Strategy::all();
        return view('metrics.index', compact('categories', 'strategies'));
    }

    public function historyMetrics(Request $request)
    {
        if ($request->ajax()) {
            $metrics = MetricHistoryRun::all();
            return DataTables::of($metrics)
                ->addIndexColumn()
                ->editColumn('strategy_id', function ($metrics){
                    return $metrics->strategy->name;
                })
                ->make(true);
        }
    }

    public function getMetrics(Request $request)
    {

        $request->validate([
            'url' => 'required|url',
            'categories' => 'required|array',
            'strategy' => 'required|exists:strategies,id'
        ]);

        $url = $request->input('url');
        $categories = $request->input('categories');
        $strategy = $request->input('strategy');

        $apiKey = env('PAGESPEED_API_KEY');
        $categoriesString = implode('&category=', $categories);
        $apiUrl = "https://www.googleapis.com/pagespeedonline/v5/runPagespeed?url={$url}&key={$apiKey}&category={$categoriesString}&strategy={$strategy}";

        $client = HttpClient::create(['verify_peer' => false]);

        try {
            $response = $client->request('GET', $apiUrl);
            $data = $response->toArray();
            
            $scores = [];
            foreach ($categories as $category) {

                $apiCategory = strtolower($category);

                if ($category === 'BEST_PRACTICES') {
                    $apiCategory = 'best-practices';
                }

                if (isset($data['lighthouseResult']['categories'][$apiCategory]['score'])) {
                    $scores[$category] = $data['lighthouseResult']['categories'][$apiCategory]['score'];
                } else {
                    $scores[$category] = null;
                }
            }

            $metrics = new MetricHistoryRun();
            $metrics->url = $url;
            $metrics->accesibility_metric = isset($data['lighthouseResult']['categories']['accessibility']['score']) ? $data['lighthouseResult']['categories']['accessibility']['score'] : null;
            $metrics->pwa_metric = isset($data['lighthouseResult']['categories']['pwa']['score']) ? $data['lighthouseResult']['categories']['pwa']['score'] : null;
            $metrics->performance_metric = isset($data['lighthouseResult']['categories']['performance']['score']) ? $data['lighthouseResult']['categories']['performance']['score'] : null;
            $metrics->seo_metric = isset($data['lighthouseResult']['categories']['seo']['score']) ? $data['lighthouseResult']['categories']['seo']['score'] : null;
            $metrics->best_practices_metric = isset($data['lighthouseResult']['categories']['best-practices']['score']) ? $data['lighthouseResult']['categories']['best-practices']['score'] : null;
            $metrics->strategy_id = $strategy;
            $metrics->save();


            return response()->json($scores);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
