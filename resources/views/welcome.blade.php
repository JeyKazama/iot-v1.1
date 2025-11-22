<!doctype html>
<html lang="en">
  <head>
    <style>
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

    /* Form style */
    form {
        background: white;
        padding: 20px;
        border-radius: 15px;
        box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        max-width: 400px;
        margin: auto;
    }

    label {
        font-weight: 600;
        color: #2c3e50;
    }

    select, input[type="number"] {
        width: 100%;
        margin-top: 10px;
        padding: 8px 12px;
        border: 1px solid #ced6e0;
        border-radius: 10px;
        outline: none;
        transition: 0.2s;
    }

    select:focus, input[type="number"]:focus {
        border-color: #3498db;
        box-shadow: 0 0 0 3px rgba(52,152,219,0.2);
    }

    button {
        width: 100%;
        margin-top: 15px;
        border-radius: 10px !important;
        font-weight: 600;
    }
    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Smarthome Demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
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
            <div>
                <form action="/update-nilai-maksimal" method="POST">
                    @csrf
                    <div class="form-group">
                    <div class="form-label">Nilai Maximum</div>
                    <select name="jenis_nilai" id="jenis_nilai">
                        <option value="">Pilih Nilai</option>
                        <option value="max_temperature">Temperature</option>
                        <option value="max_humidity">Humidity</option>
                    </select>
                    </div>
                    <div class="form-group">
                    <div class="form-label">Nilai</div>
                    <input type="number" name="nilai" id="nilai">
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm">Save</button>
                </form>
            </div>
        </div>
        </form>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            function getData() {
                $.ajax({
                    url: '/get-data',
                    type: 'GET',
                    success: function(response) {
                        let temperature = response.temperature;
                        let humidity = response.humidity;
                        $('#temperature').text(temperature);
                        $('#humidity').text(humidity);
                    console.log(response);
                    }
                });
            }
            setInterval(() => {
                getData();
            }, 2000);
        });
setInterval(() => {
    loadDeviceStatus();
}, 2000);
    </script>
</body>
</html>