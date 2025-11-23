<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Smarthome Demo</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f5f7fa;
            font-family: "Poppins", sans-serif;
        }
        
        h1 {
            font-weight: 600;
            margin-bottom: 40px;
            color: #2c3e50;
        }
        
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            margin: 15px;
            transition: 0.2s ease;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 18px rgba(0,0,0,0.15);
        }
        
        .card-body h5 {
            font-size: 1.2rem;
            font-weight: 600;
            color: #34495e;
        }
        
        .card-body p {
            font-size: 2rem;
            font-weight: bold;
            color: #2c3e50;
        }
        
        /* -------------------------- */
        /*         TOGGLE CSS (FIXED) */
        /* -------------------------- */
        
        .switch {
          position: relative;
          width: 56px;
          height: 28px;
          display: inline-block;
        }
        
        .switch input {
          display: none;
        }
        
        .slider {
          position: absolute;
          cursor: pointer;
          top: 0;
          left: 0;
          right: 0;
          bottom: 0;
          background-color: #d9534f;
          border-radius: 28px;
          transition: 0.3s;
          display: flex;
          align-items: center;
          padding: 0 6px;
        }
        
        .slider::before {
          content: "";
          position: absolute;
          height: 22px;
          width: 22px;
          left: 3px;
          bottom: 3px;
          background: white;
          border-radius: 50%;
          transition: 0.3s;
        }
        
        input:checked + .slider {
          background-color: #5cb85c;
        }
        
        input:checked + .slider::before {
          transform: translateX(28px);
        }
        
        .label-on, .label-off { 
            font-size: 10px;
            font-weight: 600;
            color: white;
            position: absolute;
            transition: 0.2s;
        }
        
        .label-off {
            right: 8px;
            opacity: 1;
        }
        
        .label-on {
            left: 8px;
            opacity: 0;
        }
        
        input:checked + .slider .label-on { 
            opacity: 1; 
        }
        
        input:checked + .slider .label-off { 
            opacity: 0; 
        }
        </style>
</head>

<body>

<div class="container py-5">
    <h1 class="text-center">Monitoring DHT22 Sensor</h1>

    <div class="row justify-content-center">
        <div class="card col-3">
            <div class="card-body">
                <h5>Temperature</h5>
                <p><span id="temperature"></span> °C</p>
            </div>
        </div>

        <div class="card col-3">
            <div class="card-body">
                <h5>Humidity</h5>
                <p><span id="humidity"></span> %</p>
            </div>
        </div>
    </div>

    <div class="row mt-5 justify-content-center">
        <h2 class="text-center mb-4">SmartHome Controller</h2>

        <!-- ====================== DEVICES ======================== -->

        @php
            $devices = [
                'lampu_tidur' => 'Lampu Tidur',
                'ac' => 'AC',
                'wifi' => 'WiFi',
                'tv' => 'TV',
                'smart_plug' => 'Smart Plug',
                'smart_lock' => 'Smart Lock'
            ];
        @endphp

        @foreach ($devices as $key => $label)
        <div class="col-3 card text-center">
            <div class="card-body">
                <h5>{{ $label }}</h5>

                <label class="switch">
                    <input type="checkbox" id="{{ $key }}-toggle">
                    <span class="slider">
                        <span class="label-on">ON</span>
                        <span class="label-off">OFF</span>
                    </span>
                </label>

            </div>
        </div>
        @endforeach
    </div>

    <form action="/update-nilai-maksimal" method="POST" class="mt-4 mx-auto" style="max-width:400px;">
        @csrf
        <div class="form-group mb-2">
            <label>Nilai Maximum</label>
            <select class="form-select" name="jenis_nilai">
                <option value="">Pilih Nilai</option>
                <option value="max_temperature">Temperature</option>
                <option value="max_humidity">Humidity</option>
            </select>
        </div>

        <div class="form-group mb-2">
            <label>Nilai</label>
            <input type="number" class="form-control" name="nilai">
        </div>

        <button class="btn btn-primary w-100">Save</button>
    </form>

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

<script>

// ================== LOAD SENSOR DATA ===================
function loadSensorData() {
    $.get('/get-data', function(res) {
        $('#temperature').text(res.temperature);
        $('#humidity').text(res.humidity);
    });
}
setInterval(loadSensorData, 2000);


// ================== LOAD SMART DEVICE STATUS ===================
function loadDeviceStatus() {
    $.ajax({
        url: '/status',
        type: 'GET',
        success: function(res) {

            $("#lampu_tidur-toggle").prop("checked", res.lampu_tidur == 1);
            $("#ac-toggle").prop("checked", res.ac == 1);
            $("#wifi-toggle").prop("checked", res.wifi == 1);
            $("#tv-toggle").prop("checked", res.tv == 1);
            $("#smart_plug-toggle").prop("checked", res.smart_plug == 1);
            $("#smart_lock-toggle").prop("checked", res.smart_lock == 1);

        }
    });
}
setInterval(loadDeviceStatus, 1500);


// ================== HANDLE TOGGLE CLICK ===================
function setupToggle(id, device) {
    $("#" + id).on("change", function() {
        $.get("/toggle/" + device);
    });
}

setupToggle("lampu_tidur-toggle", "lampu_tidur");
setupToggle("ac-toggle", "ac");
setupToggle("wifi-toggle", "wifi");
setupToggle("tv-toggle", "tv");
setupToggle("smart_plug-toggle", "smart_plug");
setupToggle("smart_lock-toggle", "smart_lock");

</script>

</body>
</html>
