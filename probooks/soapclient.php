<?php
  $options = array(
    'uri'=>'http://schemas.xmlsoap.org/soap/envelope/',
    'style'=>SOAP_RPC,
    'use'=>SOAP_ENCODED,
    'soap_version'=>SOAP_1_1,
    'cache_wsdl'=>WSDL_CACHE_NONE,
    'connection_timeout'=>15,
    'trace'=>true,
    'encoding'=>'UTF-8',
    'exceptions'=>true,
  );
  $client = new SoapClient("http://localhost:8888/service/transaksi?wsdl", $options);
  if(isset($_POST['judul'])){
    $params = array(
      "arg0" => $_POST['judul']
    );
    try {
      $response = $client->__soapCall("searchBook", $params);  
      $books = json_encode($response);
      echo($books);
    } catch (SoapFault $sf) { 
      echo "Soapfault"; 
    } catch (Exception $e) { 
      echo "Exception"; 
    }
  } elseif (isset($_POST['add'])) {
    $params = array(
      "arg0" => $_POST['idbook'],
      "arg1" => $_POST['quantity']
    );
    $response = $client->__soapCall("tambahpembelian", $params);
    echo($response);
  } elseif (isset($_POST['idbook']) and isset($_POST['quantity']) and isset($_POST['nomorPengirim'])) {
    $params = array(
      "arg0" => $_POST['idbook'],
      "arg1" => $_POST['quantity'],
      "arg2" => $_POST['nomorPengirim']
    );
    $response = $client->__soapCall("pembelian", $params);
    echo($response);
  }
?>
