<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Helper\Helper;
use Illuminate\Support\Facades\Cache;

class WeatherController extends Controller
{
    public function index()
    {
        if (Cache::has('weatherForecast')) {
            $data = Cache::get('weatherForecast');

            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        }
    }

    public function getWeatherForecast($city)
    {
        try {
            $response = Http::get('http://api.weatherapi.com/v1/forecast.json?key=f87b901a17b14d4ba4544808243005&q=' . $city . '&days=5')->json();

            $locationName = $response['location']['name'];

            $forecastDay = $response['forecast']['forecastday'];

            $customForecastDay = [];
            foreach ($forecastDay as $item) {
                $date = $item['date'];
                $avgTempC = $item['day']['avgtemp_c'];
                $maxWindMpS = Helper::convertKmHToMS($item['day']['maxwind_kph']);
                $humidity = $item['day']['avghumidity'];
                $conditionIcon = $item['day']['condition']['icon'];
                $conditionText = $item['day']['condition']['text'];

                $customForecastDay[] = [
                    'date' => $date,
                    'avgTempC' => $avgTempC,
                    'maxWindMpS' => $maxWindMpS,
                    'humidity' => $humidity,
                    'conditionIcon' => $conditionIcon,
                    'conditionText' => $conditionText
                ];
            }

            $data = [
                'locationName' => $locationName,
                'customForecastDay' => $customForecastDay
            ];

            Cache::put('weatherForecast', $data, now()->addDay());

            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false
            ]);
        }
    }

    public function loadMore(Request $request)
    {
        $city = $request->input('city');
        $start = $request->input('start');

        try {
            $response = Http::get('http://api.weatherapi.com/v1/forecast.json?key=f87b901a17b14d4ba4544808243005&q=' . $city . '&days=' . $start + 4)->json();

            $forecastDay = $response['forecast']['forecastday'];

            $customForecastDay = [];
            foreach ($forecastDay as $key => $item) {
                if ($key >= $start) {
                    $date = $item['date'];
                    $avgTempC = $item['day']['avgtemp_c'];
                    $maxWindMpS = Helper::convertKmHToMS($item['day']['maxwind_kph']);
                    $humidity = $item['day']['avghumidity'];
                    $conditionIcon = $item['day']['condition']['icon'];
                    $conditionText = $item['day']['condition']['text'];

                    $customForecastDay[] = [
                        'date' => $date,
                        'avgTempC' => $avgTempC,
                        'maxWindMpS' => $maxWindMpS,
                        'humidity' => $humidity,
                        'conditionIcon' => $conditionIcon,
                        'conditionText' => $conditionText
                    ];
                }
            }

            $data = [
                'customForecastDay' => $customForecastDay
            ];

            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false
            ]);
        }
    }
}
