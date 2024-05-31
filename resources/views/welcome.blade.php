<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    {{-- Rubik Font --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap"
        rel="stylesheet">
    {{-- Jquery --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    {{-- CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <style>
        * {
            margin: 0;
            padding: 0;
            border: 0;
            font-size: 100%;
        }

        body {
            font-family: 'Rubik', sans-serif;
        }

        .card {
            color: white;
        }
    </style>
</head>

<body>
    <div class="container-fluid bg-secondary-subtle" style="min-height: 900px">
        <div class="container bg-primary-subtle pb-5">
            {{-- Start Header --}}
            <div class="row bg-primary" style="height: 80px">
                <div class="col d-flex justify-content-center align-items-center">
                    <h3 class="text-white fw-bold ">Weather Dashboard</h3>
                </div>
            </div>
            {{-- End Header --}}

            {{-- Start Content --}}
            <div class="row pt-4">
                <div class="col-lg-4">
                    <div class="mb-3">
                        <label for="city" class="fw-bold form-label">Enter a City Name</label>
                        <input class="form-control" name="city" id="city" type="text"
                            placeholder="E.g., New York, London, Tokyo">
                    </div>
                    <button id="searchBtn" class="mb-3 w-100 btn btn-primary">Search</button>
                    <div class="mb-3 text-center">or</div>
                    <button id="currentLocationBtn" class="mb-3 w-100 btn btn-secondary">Use Current Location</button>
                </div>

                <div class="col-lg-8">
                    <div class="row mb-3">
                        <div class="col">
                            <div class="card w-100 bg-primary">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-8">
                                            <h5 id="location" class="card-title">London</h5>
                                            <h5 id="date" class="card-title">2023-06-19</h5>
                                            <p class="card-text">Temperature: <span id="temperature">18.71</span> &deg;C</p>
                                            <p class="card-text">Wind: <span id="wind">4.31</span> M/S</p>
                                            <p class="card-text">Humidity: <span id="humidity">76</span>%</p>
                                        </div>
                                        <div class="col-4">
                                            {{-- img --}}
                                            <img id="condition-icon" src="" alt="">
                                            <p id="condition-text"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 fw-bold">4-Day Forecast</div>
                    <div class="row mb-3">
                        <div class="col-6 col-md-3 mb-3">
                            <div class="card bg-secondary">
                                <div class="card-body">
                                    <h5 id="date1" class="card-title">2023-06-19</h5>
                                    <img id="condition-icon1" src="" class="" alt="">
                                    <p class="card-text">Temp: <span id="temperature1">18.71</span> &deg;C</p>
                                    <p class="card-text">Wind: <span id="wind1">4.31</span> M/S</p>
                                    <p class="card-text">Humidity: <span id="humidity1">76</span>%</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3 mb-3">
                            <div class="card bg-secondary">
                                <div class="card-body">
                                    <h5 id="date2" class="card-title">2023-06-19</h5>
                                    <img id="condition-icon2" src="" class="" alt="">
                                    <p class="card-text">Temp: <span id="temperature2">18.71</span> &deg;C</p>
                                    <p class="card-text">Wind: <span id="wind2">4.31</span> M/S</p>
                                    <p class="card-text">Humidity: <span id="humidity2">76</span>%</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3 mb-3">
                            <div class="card bg-secondary">
                                <div class="card-body">
                                    <h5 id="date3" class="card-title">2023-06-19</h5>
                                    <img id="condition-icon3" src="" class="" alt="">
                                    <p class="card-text">Temp: <span id="temperature3">18.71</span> &deg;C</p>
                                    <p class="card-text">Wind: <span id="wind3">4.31</span> M/S</p>
                                    <p class="card-text">Humidity: <span id="humidity3">76</span>%</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3 mb-3">
                            <div class="card bg-secondary">
                                <div class="card-body">
                                    <h5 id="date4" class="card-title">2023-06-19</h5>
                                    <img id="condition-icon4" src="" class="" alt="">
                                    <p class="card-text">Temp: <span id="temperature4">18.71</span> &deg;C</p>
                                    <p class="card-text">Wind: <span id="wind4">4.31</span> M/S</p>
                                    <p class="card-text">Humidity: <span id="humidity4">76</span>%</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="flag" class="row">
                        <div class="col">
                            <button id="loadMoreBtn" class="w-100 btn btn-primary">Load More</button>
                        </div>
                    </div>
                </div>
            </div>
            {{-- End Content --}}
        </div>
    </div>

    {{-- Bootstrap v5.3 --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="/js/weather-forecast.js"></script>
</body>

</html>
