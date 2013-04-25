<?php
require('PKPass.php');

$logoText = $_POST['logoText'];
$primaryLabel = $_POST['primaryLabel'];
$primaryValue = $_POST['primaryValue'];
$website = $_POST['website'];
$barcode = $_POST['barcode'];
$fg_r = $_POST['foreground-r'];
$fg_g = $_POST['foreground-g'];
$fg_b = $_POST['foreground-b'];
$bg_r = $_POST['background-r'];
$bg_g = $_POST['background-g'];
$bg_b = $_POST['background-b'];

if($barcode == "1"){
	$barcode = "PKBarcodeFormatQR";
}else if($barcode == "2"){
	$barcode = "PKBarcodeFormatPDF417";
}else if($barcode == "3"){
	$barcode = "PKBarcodeFormatAztec";
}else if($barcode == "4"){
	$barcode = "PKBarcodeFormatText";
}else{
	$barcode = "PKBarcodeFormatQR";
}

$pass = new PKPass();

//TODO: Cert.p12, AppleWWDRCA.pem
$pass->setCertificate('../*****');  // Set the path to your Pass Certificate (.p12 file)
$pass->setCertificatePassword('test');     // Set password for certificate
$pass->setWWDRcertPath('../*****'); // Set the path to your WWDR Intermediate certificate (.pem file)

$pass->setJSON('{
  "formatVersion" : 1,
  "passTypeIdentifier" : "pass.example.hellopass",
  "serialNumber" : "E5982H-I2",
  "teamIdentifier" : "222E4LK569",
  "webServiceURL" : "https://example.com/passes/",
  "authenticationToken" : "vxwxd7J8AlNNFPS8k0a0FfUFtq0ewzFdc",
  "barcode" : {
    "message" : "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789",
    "format" : "' . $barcode . '",
    "messageEncoding" : "iso-8859-1"
  },
  "locations" : [
    {
      "longitude" : -122.3748889,
      "latitude" : 37.6189722
    },
    {
      "longitude" : -122.03118,
      "latitude" : 37.33182
    }
  ],
  "organizationName" : "Paw Planet",
  "logoText" : "' . $logoText . '",
  "description" : "temp",
  "foregroundColor" : "rgb(' . $fg_r . ',' . $fg_g . ',' . $fg_b . ')",
  "backgroundColor" : "rgb(' . $bg_r . ',' . $bg_g . ',' . $bg_b . ')",
  "coupon" : {
    "primaryFields" : [
      {
        "key" : "offer",
        "label" : "' . $primaryLabel . '",
        "value" : "' . $primaryValue . '"
      }
    ],
    "auxiliaryFields" : [
      {
        "key" : "expires",
        "label" : "",
        "value" : ""
      }
    ],
    "backFields" : [
      {
        "key" : "website",
        "label" : "website",
        "value" : "' . $website . '"
      }
    ]
  }
}');

// add files to the PKPass package
$pass->addFile('images/icon.png');
$pass->addFile('images/icon@2x.png');
$pass->addFile('images/logo.png');

$pass->create(true); // Create and output the PKPass
