<?php
    header("Access-Control-Allow-Origin:*");
    date_default_timezone_set('UTC');

    function getInputParams($symbol, $duration, $period){
        $params = '{"Normalized":false,"NumberOfDays":'. $duration .',"DataPeriod":"' . $period . '","Elements":[{"Symbol":"'. $symbol . '","Type":"price","Params":["ohlc"]},{"Symbol":"'. $symbol .'","Type":"volume"}]}';
        return $params;
    }

    # Error handling in PHP
    function errorHandler($enum, $errorMsg, $eFile, $eSeverity){
        throw new ErrorException($errorMsg);
    }
    set_error_handler("errorHandler");

    error_reporting(E_ERROR | E_WARNING | E_PARSE);

    try{
        if(isset($_GET["operation"]) && $_GET["operation"] == "lookup"){
            if(isset($_GET["name"])){
                $query = "http://dev.markitondemand.com/MODApis/Api/v2/Lookup/json?input=" . urlencode($_GET["name"]);
                $result   = file_get_contents($query) or die("Unable to retrieve values from Market on Demand");
                echo $result;
            }
        }
        else if(isset($_GET["operation"]) && $_GET["operation"] == "getstock"){
            if(isset($_GET["symbol"])){
                $query = "http://dev.markitondemand.com/MODApis/Api/v2/Quote/json?symbol=" . urlencode($_GET["symbol"]);
                $result   = file_get_contents($query) or die("Unable to retrieve values from Market on Demand");
                echo $result;
            }
        }
        else if(isset($_GET["operation"]) && $_GET["operation"] == "charts"){
            if(isset($_GET["symbol"])){
                $query = "http://dev.markitondemand.com/MODApis/Api/v2/InteractiveChart/json?parameters=" . urlencode(getInputParams($_GET["symbol"], $_GET["duration"], $_GET["period"] ));
                $result   = file_get_contents($query) or die("Unable to retrieve values from Market on Demand");
                echo $result;
            }
        }
        else if(isset($_GET["operation"]) && $_GET["operation"] == "news"){
            if(isset($_GET["symbol"])){
                $query = "https://ajax.googleapis.com/ajax/services/search/news?v=1.0&userip=173.194.204.141&q=" . urlencode($_GET["symbol"]);
                $result   = file_get_contents($query) or die("Unable to retrieve values from Market on Demand");
                echo $result;
            }
        }
        else if(isset($_GET["operation"]) && $_GET["operation"] == "bingnews"){
            if(isset($_GET["symbol"])){
                $accountKey = 'dwO9E9fD4soMHF83khoFbhWoSdMSvqYjsj9cfAnUSFM';
                $ServiceRootURL =  'https://api.datamarket.azure.com/Bing/Search/v1/';                    
                $WebSearchURL = $ServiceRootURL . 'News?$format=json&Query=';

                $context = stream_context_create(array(
                    'http' => array(
                        'request_fulluri' => true,
                        'header'  => "Authorization: Basic " . base64_encode($accountKey . ":" . $accountKey)
                    )
                ));
                $request = $WebSearchURL . urlencode( '\'' . $_GET["symbol"] . '\'');
                $response = file_get_contents($request, 0, $context);
                echo $response;
            }
        }
        else if(isset($_GET["operation"]) && $_GET["operation"] == "readFav"){
            $query = "gs://stock-app-csci.appspot.com/stock.json";
            $result   = file_get_contents($query) or die("Unable to retrieve values from Market on Demand");
            echo $result;
        }
        else if(isset($_GET["operation"]) && $_GET["operation"] == "writeFav"){
            if(isset($_GET["fav"])){
                $query = "gs://stock-app-csci.appspot.com/stock.json";
                $result   = file_put_contents($query,$_GET["fav"]) or die("Unable to write values from Market on Demand");
                echo $result;
            }
        }
        else if(isset($_GET["operation"]) && $_GET["operation"] == "fav"){
            $query = "gs://stock-app-csci.appspot.com/stock.json";
            $result  = file_get_contents($query) or die("Unable to write values from Market on Demand");
            $jsonval = json_decode($result);
            $arr = array();
            foreach($jsonval->symbol as $val){
                $query = "http://dev.markitondemand.com/MODApis/Api/v2/Quote/json?symbol=" . urlencode($val);
                $result   = file_get_contents($query) or die("Unable to retrieve values from Market on Demand");
                array_push($arr, $result);
            }
            echo json_encode($arr);
            
        }
    }catch(Exception $e){
        echo $e;
        http_response_code(404);
        $er = array(
            "errorCode"    => "404",
            "errorMessage" => "The necessary fields are missing",
            "fields"       => "Symbol or Name of company is needed"
        );
        echo json_encode($er);
    }    

?>