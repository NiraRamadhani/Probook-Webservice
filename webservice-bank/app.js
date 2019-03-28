var express = require('express');
var app = express();
var mysql = require('mysql');
var connection = mysql.createConnection({
    host : 'localhost',
    user : 'root',
    password : '',
    database : 'bank'
  }
)
var bodyParser = require('body-parser');
var jsonParser = bodyParser.json();
var urlencodedParser =bodyParser.urlencoded({extended: false});
var OTP = require('otp.js');
// get HOTP object
var HOTP = OTP.hotp;

connection.connect(function(err){
  if(err) throw err;
  console.log('connected to DB');
});

app.post('/validasi', urlencodedParser, function(req, res){  
  if(!req.body) return res.sendStatus(400)
  var num = req.body.cardnumber;
  console.log(num);
  connection.query('SELECT * FROM nasabah where nomor_kartu=?', num, function(err, rows, fields){
    if(err) throw err;
    res.writeHead(200, {'Content-Type': 'text/html', "Access-Control-Allow-Origin": "*"});
    if (!num) {  
      res.write("");
    } else {
      if (rows != "") {
        //Card already exist
        res.write("<img id=cardstatus src='public/icons/checked.png' width=15px height=15px>");
      } else {
        //Card doesn't exist
        res.write("<img id=cardstatus src='public/icons/mark.png' width=15px height=15px>");        
      }
    }
    res.end();
    console.log('success post');
  })
});

app.post('/transfer', urlencodedParser, function(req, res){
  if(!req.body) return res.sendStatus(400)
  nomorPengirim = req.body.nomorPengirim;
  nomorPenerima = req.body.nomorPenerima;
  jumlah = req.body.jumlah;
  otp = req.body.otp;
  console.log(nomorPengirim);
  console.log(nomorPenerima);
  console.log(jumlah);
  //VERIFIKASI OTP
  try
  {
    // verify otp '755224' for key '12345678901234567890' in string format
    var result = HOTP.verify('755224', {string:'12345678901234567890'});
    console.log("RESULT : " + result); // print result => {delta:{int:0}}
  }
  catch(ex)
  {
    console.error(ex); // print error occurred during OTP verification process
  }
  if(result){
    connection.query(`SELECT saldo FROM nasabah WHERE nomor_kartu = ${nomorPengirim}`, function(err, rows, fields){
      if(err) throw err;
      console.log(rows[0]['saldo']);
      if(rows[0]['saldo'] >= jumlah){
        connection.query(`INSERT INTO transaksi(nomor_pengirim, nomor_penerima, jumlah) VALUES(${nomorPengirim}, ${nomorPenerima}, ${jumlah})`, function(){
          console.log("insert success");
        });
        connection.query(`UPDATE nasabah SET saldo = saldo - ${jumlah} WHERE nomor_kartu = ${nomorPengirim}`, function(){
          console.log("money sent");
        });
        connection.query(`UPDATE nasabah SET saldo = saldo + ${jumlah} WHERE nomor_kartu = ${nomorPenerima}`, function(){
          console.log("money received");
        });
        res.send(true);
      } else {
        console.log("saldo kurang");
        res.send(false);
      }
    });
  }
});

app.get("/getToken", function(req, res){
  try
  {
    // generate otp for key '12345678901234567890' in string format
    var code = HOTP.gen({string:'12345678901234567890'});
    console.log(code); // print otp result => 755224
    res.send(code);
  }
  catch(ex)
  {
    console.error(ex); // print error occurred during OTP generation process
  }
});

app.listen(3000, function(){
  console.log('listen to port 3000');
});