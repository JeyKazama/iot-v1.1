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
    <div class="row mt-5 justify-content-center">
        <div class="col-md-10">
            <h3 class="text-center mb-4">Device Controller</h3>
            
            <!-- Kipas -->
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-3">
                            <h5 class="mb-0">🌀 Kipas</h5>
                        </div>
                        <div class="col-md-3">
                            <label class="me-2">Mode:</label>
                            <select class="form-select form-select-sm d-inline-block w-auto mode-switch" data-device="kipas">
                                <option value="0">Manual</option>
                                <option value="1">Auto</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <span class="status-label">Status: <strong class="status-kipas">OFF</strong></span>
                        </div>
                        <div class="col-md-3 text-end">
                            <label class="switch">
                                <input type="checkbox" class="device-toggle" data-device="kipas" data-column="kipas">
                                <span class="slider">
                                    <span class="label-on">ON</span>
                                    <span class="label-off">OFF</span>
                                </span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
    
            <!-- AC -->
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-3">
                            <h5 class="mb-0">❄️ AC</h5>
                        </div>
                        <div class="col-md-3">
                            <label class="me-2">Mode:</label>
                            <select class="form-select form-select-sm d-inline-block w-auto mode-switch" data-device="ac">
                                <option value="0">Manual</option>
                                <option value="1">Auto</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <span class="status-label">Status: <strong class="status-ac">OFF</strong></span>
                        </div>
                        <div class="col-md-3 text-end">
                            <label class="switch">
                                <input type="checkbox" class="device-toggle" data-device="ac" data-column="ac">
                                <span class="slider">
                                    <span class="label-on">ON</span>
                                    <span class="label-off">OFF</span>
                                </span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
    
            <!-- Air Purifier -->
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-3">
                            <h5 class="mb-0">💨 Air Purifier</h5>
                        </div>
                        <div class="col-md-3">
                            <label class="me-2">Mode:</label>
                            <select class="form-select form-select-sm d-inline-block w-auto mode-switch" data-device="air_purifier">
                                <option value="0">Manual</option>
                                <option value="1">Auto</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <span class="status-label">Status: <strong class="status-air_purifier">OFF</strong></span>
                        </div>
                        <div class="col-md-3 text-end">
                            <label class="switch">
                                <input type="checkbox" class="device-toggle" data-device="air_purifier" data-column="air_purifier">
                                <span class="slider">
                                    <span class="label-on">ON</span>
                                    <span class="label-off">OFF</span>
                                </span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
    
            <!-- LED 1 -->
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h5 class="mb-0">💡 LED 1</h5>
                        </div>
                        <div class="col-md-3">
                            <span class="status-label">Status: <strong class="status-led1">OFF</strong></span>
                        </div>
                        <div class="col-md-3 text-end">
                            <label class="switch">
                                <input type="checkbox" class="device-toggle" data-device="led1" data-column="led1">
                                <span class="slider">
                                    <span class="label-on">ON</span>
                                    <span class="label-off">OFF</span>
                                </span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
    
            <!-- LED 2 -->
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h5 class="mb-0">💡 LED 2</h5>
                        </div>
                        <div class="col-md-3">
                            <span class="status-label">Status: <strong class="status-led2">OFF</strong></span>
                        </div>
                        <div class="col-md-3 text-end">
                            <label class="switch">
                                <input type="checkbox" class="device-toggle" data-device="led2" data-column="led2">
                                <span class="slider">
                                    <span class="label-on">ON</span>
                                    <span class="label-off">OFF</span>
                                </span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
    
            <!-- LED 3 -->
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h5 class="mb-0">💡 LED 3</h5>
                        </div>
                        <div class="col-md-3">
                            <span class="status-label">Status: <strong class="status-led3">OFF</strong></span>
                        </div>
                        <div class="col-md-3 text-end">
                            <label class="switch">
                                <input type="checkbox" class="device-toggle" data-device="led3" data-column="led3">
                                <span class="slider">
                                    <span class="label-on">ON</span>
                                    <span class="label-off">OFF</span>
                                </span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

<script>

// ================== LOAD SENSOR DATA ===================
function loadSensorData() {
    $.get('/get-data', function(res) {
        $('#temperature').text(res.dht.temperature);
        $('#humidity').text(res.dht.humidity);
    });
}
setInterval(loadSensorData, 2000);

// ================== LOAD DEVICE STATUS ===================
function loadDeviceStatus() {
    $.get('/get-device-status', function(res) {
        // Update toggle switches
        $('.device-toggle[data-device="kipas"]').prop('checked', res.kipas == 1);
        $('.device-toggle[data-device="ac"]').prop('checked', res.ac == 1);
        $('.device-toggle[data-device="air_purifier"]').prop('checked', res.air_purifier == 1);
        $('.device-toggle[data-device="led1"]').prop('checked', res.led1 == 1);
        $('.device-toggle[data-device="led2"]').prop('checked', res.led2 == 1);
        $('.device-toggle[data-device="led3"]').prop('checked', res.led3 == 1);

        // Update mode selects
        $('.mode-switch[data-device="kipas"]').val(res.kipas_auto);
        $('.mode-switch[data-device="ac"]').val(res.ac_auto);
        $('.mode-switch[data-device="air_purifier"]').val(res.air_purifier_auto);

        // Update status text
        $('.status-kipas').text(res.kipas == 1 ? 'ON' : 'OFF');
        $('.status-ac').text(res.ac == 1 ? 'ON' : 'OFF');
        $('.status-air_purifier').text(res.air_purifier == 1 ? 'ON' : 'OFF');
        $('.status-led1').text(res.led1 == 1 ? 'ON' : 'OFF');
        $('.status-led2').text(res.led2 == 1 ? 'ON' : 'OFF');
        $('.status-led3').text(res.led3 == 1 ? 'ON' : 'OFF');

        // Disable toggle if in auto mode
        if(res.kipas_auto == 1) {
            $('.device-toggle[data-device="kipas"]').prop('disabled', true).closest('.switch').css('opacity', '0.6');
        } else {
            $('.device-toggle[data-device="kipas"]').prop('disabled', false).closest('.switch').css('opacity', '1');
        }

        if(res.ac_auto == 1) {
            $('.device-toggle[data-device="ac"]').prop('disabled', true).closest('.switch').css('opacity', '0.6');
        } else {
            $('.device-toggle[data-device="ac"]').prop('disabled', false).closest('.switch').css('opacity', '1');
        }

        if(res.air_purifier_auto == 1) {
            $('.device-toggle[data-device="air_purifier"]').prop('disabled', true).closest('.switch').css('opacity', '0.6');
        } else {
            $('.device-toggle[data-device="air_purifier"]').prop('disabled', false).closest('.switch').css('opacity', '1');
        }
    });
}

// Load device status every 2 seconds
setInterval(loadDeviceStatus, 2000);
loadDeviceStatus(); // Initial load

// ================== TOGGLE DEVICE (Manual Mode) ===================
$(document).on('change', '.device-toggle', function() {
    let device = $(this).data('device');
    let column = $(this).data('column');
    let status = $(this).is(':checked') ? 1 : 0;

    $.ajax({
        url: '/update-device',
        method: 'POST',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            column: column,
            status: status
        },
        success: function(res) {
            console.log('Device updated:', res);
        },
        error: function(err) {
            console.error('Error updating device:', err);
            alert('Failed to update device');
        }
    });
});

// ================== SWITCH MODE (Auto/Manual) ===================
$(document).on('change', '.mode-switch', function() {
    let device = $(this).data('device');
    let mode = $(this).val();
    let column = device + '_auto';

    $.ajax({
        url: '/update-device-mode',
        method: 'POST',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            column: column,
            mode: mode
        },
        success: function(res) {
            console.log('Mode updated:', res);
            loadDeviceStatus(); // Reload to update toggle state
        },
        error: function(err) {
            console.error('Error updating mode:', err);
            alert('Failed to update mode');
        }
    });
});

</script>

</body>
</html>
