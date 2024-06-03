$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function () {
    init();

    let city;

    $("#searchBtn").click(function () {
        city = $("#city").val();
        if (city) {
            setWithExpiry('city', city, 24 * 60 * 60 * 1000); // set localStorage & Time to live = 1 day => (mili second)
            callAjax(city);
        } else {
            alert("Please input city name");
        }
    });

    let start = 5;
    $("#loadMoreBtn").click(function () {
        if (city) {
            $.ajax({
                url: "/loadmore",
                type: "GET",
                data: { city: city, start: start },
                dataType: "json",
                success: function (response) {
                    if (response.data.customForecastDay.length > 0) {
                        let html = '';
                        let customForecastDay = response.data.customForecastDay;

                        for (let i = 0; i < customForecastDay.length; i++) {
                            let temp = customForecastDay[i];
                            html += `
                                <div class="col-6 col-md-3 mb-3">
                                    <div class="card bg-secondary">
                                        <div class="card-body">
                                            <h5 id="date`+ start + `" class="card-title">` + temp.date + `</h5>
                                            <img id="condition-icon`+ start + `" src="` + temp.conditionIcon + `" class="" alt="">
                                            <p class="card-text">Temp: <span id="temperature`+ start + `">` + temp.avgTempC + `</span> &deg;C</p>
                                            <p class="card-text">Wind: <span id="wind`+ start + `">` + temp.maxWindMpS + `</span> M/S</p>
                                            <p class="card-text">Humidity: <span id="humidity`+ start + `">` + temp.humidity + `</span>%</p>
                                        </div>
                                    </div>
                                </div>
                            `;
                            start++;
                        }

                        let newElement = $('<div class="row mb-3">' + html + '</div>').insertBefore('#flag').hide();

                        newElement.slideDown("slow");
                        $('html, body').animate({
                            scrollTop: newElement.offset().top
                        }, '');
                    } else {
                        alert("No More Data Available");
                    }
                }
            });
        } else {
            alert("Please input city name");
        }
    });

    $("#currentLocationBtn").click(function () {
        getLocation();
    });
});

function init() {
    // let city = getWithExpiry('city');

    // if (city) {
    //     callAjax(city);
    // } else {
    //     callAjax("London");
    // }

    $.ajax({
        url: "/weather-forecast",
        type: "GET",
        dataType: "json",
        success: function (response) {
            let data = response.data;

            let forecastDay = data.customForecastDay;
            $("#location, #date, #temperature, #wind, #humidity, #condition-icon, #condition-text").hide();
            $("#location").text(data.locationName).fadeIn("slow");
            $("#date").text(forecastDay[0].date).fadeIn("slow");
            $("#temperature").text(forecastDay[0].avgTempC).fadeIn("slow");
            $('#wind').text(forecastDay[0].maxWindMpS).fadeIn("slow");
            $('#humidity').text(forecastDay[0].humidity).fadeIn("slow");
            $('#condition-icon').attr('src', forecastDay[0].conditionIcon).fadeIn("slow");
            $('#condition-text').text(forecastDay[0].conditionText).fadeIn("slow");

            for (let i = 1; i < forecastDay.length; i++) {
                $(`#location${i}, #date${i}, #temperature${i}, #wind${i}, #humidity${i}, #condition-icon${i}, #condition-text${i}`).hide();
                $("#date" + i).text(forecastDay[i].date).fadeIn("slow");
                $("#temperature" + i).text(forecastDay[0].avgTempC).fadeIn("slow");
                $('#wind' + i).text(forecastDay[0].maxWindMpS).fadeIn("slow");
                $('#humidity' + i).text(forecastDay[0].humidity).fadeIn("slow");
                $('#condition-icon' + i).attr('src', forecastDay[0].conditionIcon).fadeIn("slow");
                $('#condition-text' + i).text(forecastDay[0].conditionText).fadeIn("slow");
            }
        }
    });
}

function callAjax(city) {
    $.ajax({
        url: "/weather-forecast/" + city,
        type: "GET",
        dataType: "json",
        success: function (response) {
            let data = response.data;

            if (response.success === false) {
                alert('City name is invalid !!!');
                return;
            }

            let forecastDay = data.customForecastDay;
            $("#location, #date, #temperature, #wind, #humidity, #condition-icon, #condition-text").hide();
            $("#location").text(data.locationName).fadeIn("slow");
            $("#date").text(forecastDay[0].date).fadeIn("slow");
            $("#temperature").text(forecastDay[0].avgTempC).fadeIn("slow");
            $('#wind').text(forecastDay[0].maxWindMpS).fadeIn("slow");
            $('#humidity').text(forecastDay[0].humidity).fadeIn("slow");
            $('#condition-icon').attr('src', forecastDay[0].conditionIcon).fadeIn("slow");
            $('#condition-text').text(forecastDay[0].conditionText).fadeIn("slow");

            for (let i = 1; i < forecastDay.length; i++) {
                $(`#location${i}, #date${i}, #temperature${i}, #wind${i}, #humidity${i}, #condition-icon${i}, #condition-text${i}`).hide();
                $("#date" + i).text(forecastDay[i].date).fadeIn("slow");
                $("#temperature" + i).text(forecastDay[0].avgTempC).fadeIn("slow");
                $('#wind' + i).text(forecastDay[0].maxWindMpS).fadeIn("slow");
                $('#humidity' + i).text(forecastDay[0].humidity).fadeIn("slow");
                $('#condition-icon' + i).attr('src', forecastDay[0].conditionIcon).fadeIn("slow");
                $('#condition-text' + i).text(forecastDay[0].conditionText).fadeIn("slow");
            }
        }
    });
}

function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(getData);
    } else {
        x.innerHTML = "Geolocation is not supported by this browser.";
    }
}

function getData(position) {
    let coordinates = position.coords.latitude + "," + position.coords.longitude;
    callAjax(coordinates);
}

function setWithExpiry(key, value, ttl) {
    const now = new Date()

    // `item` is an object which contains the original value
    // as well as the time when it's supposed to expire
    const item = {
        value: value,
        expiry: now.getTime() + ttl,
    }
    localStorage.setItem(key, JSON.stringify(item))
}

function getWithExpiry(key) {
    const itemStr = localStorage.getItem(key)
    // if the item doesn't exist, return null
    if (!itemStr) {
        return null
    }
    const item = JSON.parse(itemStr)
    const now = new Date()
    // compare the expiry time of the item with the current time
    if (now.getTime() > item.expiry) {
        // If the item is expired, delete the item from storage
        // and return null
        localStorage.removeItem(key)
        return null
    }
    return item.value
}