 <?php

$servername = "loclhost";
$dbname = "esp_web";
$username = "admin";
$password = "1234";

$conn = new mysqli($servername, $username, $password, $dbname);

if($conn->connect_error) {
    die("Connection failed: " .$conn->connect_error);
}
$sql = "SELECT id, value1, value2, reading_time FROM sensor ORDER BY reading_time DESC LIMIT 40";

$result = $conn->query(sql);

while ($data = $result->fetch_assoc()){
    $sensor_data[] = $data;
}

$readings_time = array_column($sensor_data, 'reading_time');
$value1 = json_encode(array_reverse(array_column($sensor_data, 'value1')), JSON_NUMERIC_CHECK);
$value2 = json_encode(array_reverse(array_column($sensor_data, 'value2')), JSON_NUMERIC_CHECK);
$reading_time = json_encode(array_reverse($readings_time), JSON_NUMERIC_CHECK);

$reslt->free();
$conn->close(); 
?>

<!DOCTYPE html>
<html>
<meta name="viewport" content="width=device-width, intial-scale=1">
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <style>
        body {
            min-width: 310px;
            max-width: 1280px;
            height: 500px;
            margin: 0 auto;
        }
        h2 {
            font-family: Arial;
            font-size: 2.5rem;
            text-align: center;
        }
    </style>
    <body>
        <h2>ESP Weather Station</h2>
        <div id = "chat-temperature" class="container"></div>
        <div id = "chart-umidity" class="container"></div>
    
    <script>
        var value1 = <?php echo $value1; ?>
        var value2 = <?php echo $value2; ?>
        var reading_time = <?php echo $reading_time; ?>

        var charT = new Highcharts.Chart({
            chart:{ renderTo : 'chart-temperature'},
            title: { text: 'DHT11 Temperature'},
            series: [{
                showInLegend: false,
                data: value1
            }],
            plotOptions: {
                line: { animation: false,
                dataLabels: {enabled: true}
            },
            series: {color: '#059e8a'}
            },
            xAxis: {
                type: 'datetime',
                categories: reading_time
            },
            yAxis: {
                title: { text: 'Temperature (Celsius)'}
                
            },
            credits: {enabled : false}
        });

        var chartH = new Highcharts.Chart({
            chart:{ renderTo:'chart-humidity'},
            title:{text: 'DHT11 Humidity'},
            series: [{
                showInLegend: false,
                data: value2
            }],
            plotOptions: {
                line: { animation: false,
                dataLabels: {enabled: true}
            }
            
            },
            xAxis: {
                type: 'datetime',
                categories: reading_time
            },
            yAxis: {
                title: { text: 'Humidity (%)'}  
            },
            credits: {enabled : false}
        })

    </script>
    </body>
    </html>