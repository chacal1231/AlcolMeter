<script type="text/javascript" src="http://static.fusioncharts.com/code/latest/fusioncharts.js"></script>
<?php
class FusionCharts {
        
        private $constructorOptions = array();

        private $constructorTemplate = '
        <script type="text/javascript">
            FusionCharts.ready(function () {
                new FusionCharts(__constructorOptions__);
            });
        </script>';

        private $renderTemplate = '
        <script type="text/javascript">
            FusionCharts.ready(function () {
                FusionCharts("__chartId__").render();
            });
        </script>
        ';

        // constructor
        function __construct($type, $id, $width = 400, $height = 300, $renderAt, $dataFormat, $dataSource) {
            isset($type) ? $this->constructorOptions['type'] = $type : '';
            isset($id) ? $this->constructorOptions['id'] = $id : 'php-fc-'.time();
            isset($width) ? $this->constructorOptions['width'] = $width : '';
            isset($height) ? $this->constructorOptions['height'] = $height : '';
            isset($renderAt) ? $this->constructorOptions['renderAt'] = $renderAt : '';
            isset($dataFormat) ? $this->constructorOptions['dataFormat'] = $dataFormat : '';
            isset($dataSource) ? $this->constructorOptions['dataSource'] = $dataSource : '';

            $tempArray = array();
            foreach($this->constructorOptions as $key => $value) {
                if ($key === 'dataSource') {
                    $tempArray['dataSource'] = '__dataSource__';
                } else {
                    $tempArray[$key] = $value;
                }
            }
            
            $jsonEncodedOptions = json_encode($tempArray);
            
            if ($dataFormat === 'json') {
                $jsonEncodedOptions = preg_replace('/\"__dataSource__\"/', $this->constructorOptions['dataSource'], $jsonEncodedOptions);
            } elseif ($dataFormat === 'xml') { 
                $jsonEncodedOptions = preg_replace('/\"__dataSource__\"/', '\'__dataSource__\'', $jsonEncodedOptions);
                $jsonEncodedOptions = preg_replace('/__dataSource__/', $this->constructorOptions['dataSource'], $jsonEncodedOptions);
            } elseif ($dataFormat === 'xmlurl') {
                $jsonEncodedOptions = preg_replace('/__dataSource__/', $this->constructorOptions['dataSource'], $jsonEncodedOptions);
            } elseif ($dataFormat === 'jsonurl') {
                $jsonEncodedOptions = preg_replace('/__dataSource__/', $this->constructorOptions['dataSource'], $jsonEncodedOptions);
            }
            $newChartHTML = preg_replace('/__constructorOptions__/', $jsonEncodedOptions, $this->constructorTemplate);

            echo $newChartHTML;
        }

        // render the chart created
        // It prints a script and calls the FusionCharts javascript render method of created chart
        function render() {
           $renderHTML = preg_replace('/__chartId__/', $this->constructorOptions['id'], $this->renderTemplate);
           echo $renderHTML;
        }

    }
    //Pacientes
    $QueryPacientes=mysqli_query($link,"SELECT * FROM pacientes");
    $Pacientes=mysqli_num_rows($QueryPacientes);

    //Temperatura mínima
    $Query1=mysqli_query($link,"SELECT * FROM pacientes WHERE estado='1 Grado'");
    $Query2=mysqli_query($link,"SELECT * FROM pacientes WHERE estado='2 Grado'");
    $Query3=mysqli_query($link,"SELECT * FROM pacientes WHERE estado='3 Grado'");
    $g1=mysqli_num_rows($Query1);
    $g2=mysqli_num_rows($Query2);
    $g3=mysqli_num_rows($Query3);
?>

<div class="row">
    <div class="col-md-6">
        <div class="mini-stat clearfix">
            <font size="1"><b>Pacientes evaluados</b></font>
            <span class="mini-stat-icon green"><i class="fa fa-thermometer-half"></i></span>
            <div class="mini-stat-info">
               <button type="button" class="btn btn-success btn-xs"><?=$Pacientes?></button><font size="2"> Pacientes</font><br>
                </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="mini-stat clearfix">
            <font size="1"><b>Embriaguez alcohólica</b></font>
            <span class="mini-stat-icon tar"><i class="fa fa-tint"></i></span>
            <div class="mini-stat-info">
                <button type="button" class="btn btn-success btn-xs"><?=$g1?></button><font size="2"> 1 grado</font>
                <button type="button" class="btn btn-info btn-xs"><?=$g2?></button><font size="2"> 2 grado</font>
                <button type="button" class="btn btn-danger btn-xs"><?=$g3?></button><font size="2"> 3 grado</font>
             
            </div>
        </div>
    </div>
</div>
 <div class="row">
    <div class="col-sm-6">
        <section class="panel">
            <header class="panel-heading">
               Embriaguez alcohólica VS Pacientes
            </header>
            <div class="panel-body"> 
                <div class="table-responsive">
                    <table class="display table table-bordered table-striped">
                    <html>
   <head>
  </head>

   <body>
    <?php

        // Form the SQL query that returns the top 10 most populous countries
        $result_graph=mysqli_query($link,"SELECT estado, COUNT(estado) as total FROM pacientes GROUP BY estado");
        

        // If the query returns a valid response, prepare the JSON string
        if ($result_graph) {
            // The `$arrData` array holds the chart attributes and data
            $arrData = array(
                  "chart" => array(
                  "caption" => "Embriaguez alcohólica VS Pacientes",
                  "renderAt" => 'chart-container',
                  "xAxisName"=> "Pacientes",
                  "yAxisName"=> "Embriaguez alcohólica",
                  "paletteColors" => "#c20014",
                  "bgColor" => "#ffffff",
                  "borderAlpha"=> "20",
                  "canvasBorderAlpha"=> "0",
                  "usePlotGradientColor"=> "0",
                  "plotBorderAlpha"=> "10",
                  "showXAxisLine"=> "1",
                  "xAxisLineColor" => "#999999",
                  "showValues" => "1",
                  "divlineColor" => "#999999",
                  "divLineIsDashed" => "1",
                  "showAlternateHGridColor" => "0",
                  "formatnumberscale" => "0",
                  "thousandSeparator" => ".",
                  "numberSuffix"=> " Personas",
                  "rotateValues" => "1",
                  "placevaluesInside" => "0",

                )
            );

            $arrData["data"] = array();

            
    // Push the data into the array
            while($row_while = mysqli_fetch_array($result_graph)) {
            array_push($arrData["data"], array(
                "label" => $row_while["estado"],
                "value" => $row_while["total"],
                )
            );
            }
            /*JSON Encode the data to retrieve the string containing the JSON representation of the data in the array. */

            $jsonEncodedData = json_encode($arrData);

    /*Create an object for the column chart using the FusionCharts PHP class constructor. Syntax for the constructor is ` FusionCharts("type of chart", "unique chart id", width of the chart, height of the chart, "div id to render the chart", "data format", "data source")`. Because we are using JSON data to render the chart, the data format will be `json`. The variable `$jsonEncodeData` holds all the JSON data for the chart, and will be passed as the value for the data source parameter of the constructor.*/

            $columnChart = new FusionCharts("column2d", "myFirstChart" , "100%", 300, "chart-1", "json", $jsonEncodedData);

            // Render the chart
            $columnChart->render();            
        }

    ?>

    <div id="chart-1"><!-- Fusion Charts will render here--></div>

   </body>

</html>
                    </table>
                </div>
            </div>
        </section>
    </div>

        <div class="col-sm-6">
        <section class="panel">
            <header class="panel-heading">
                Pacientes VS sexo
            </header>
            <div class="panel-body"> 
                <div class="table-responsive">
                    <table class="display table table-bordered table-striped">
                    <?php
                    $result_graph_mes=mysqli_query($link,"SELECT sexo, COUNT(sexo) AS total FROM pacientes GROUP BY sexo ORDER BY total ASC");

                    $arrData = array(
                    "chart" => array(
                        "caption" => "Pacientes VS sexo",
                        "bgColor" => "#ffffff",
                        "startingangle" => "120",
                        "showlabels" => "1",
                        "showlegend" => "1",
                        "enablemultislicing" => "0",
                        "slicingdistance" => "15",
                        "showpercentvalues" => "1",
                        "showpercentintooltip" => "0",
                        "formatnumberscale" => "0",
                        "thousandSeparator" => ".",
                        "numberSuffix"=> " Pacientes",
                        )

                );

        $arrData["data"] = array();

        while($row_while = mysqli_fetch_array($result_graph_mes)) {
            array_push($arrData["data"], array(
                "label" => $row_while["sexo"],
                "value" => $row_while["total"],
                )
            );
            }
             $jsonEncodedData2 = json_encode($arrData);
             $columnChart = new FusionCharts("doughnut2d", "ex2", "100%", 300, "chart-2", "json", $jsonEncodedData2);
             $columnChart->render();

?>
                    <div id="chart-2"><!-- Fusion Charts will render here--></div>
                    </table>
                    </div>
                    </div>
                    </section>
                    </div>
                    </div>