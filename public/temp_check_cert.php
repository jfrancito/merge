<?php
header('Content-Type: text/plain');

$cert = <<<EOD
-----BEGIN CERTIFICATE-----
MIIIyDCCBrCgAwIBAgIJVsTr4UcAFQ3XMA0GCSqGSIb3DQEBCwUAMIIBIjELMAkG
A1UEBhMCUEUxDTALBgNVBAgMBExJTUExDTALBgNVBAcMBExJTUExPTA7BgNVBAsM
NHNlZSBjdXJyZW50IGFkZHJlc3MgYXQgd3d3LmNhbWVyZmlybWEuY29tLnBlL2Fk
ZHJlc3MxMDAuBgNVBAsMJ0FDIENBTUVSRklSTUEgUEVSw5ogQ0VSVElGSUNBRE9T
IC0gMjAxNjEUMBIGA1UEBRMLMjA1NjYzMDI0NDcxGjAYBgNVBGEMEU5UUlBFLTIw
NTY2MzAyNDQ3MSAwHgYDVQQKDBdDQU1FUkZJUk1BIFBFUsOaIFMuQS5DLjEwMC4G
A1UEAwwnQUMgQ0FNRVJGSVJNQSBQRVLDmiBDRVJUSUZJQ0FET1MgLSAyMDE2MB4X
DTI2MDcxMDE2MTAyOVoXDTI4MDcwOTE2MTAyOVowggESMS4wLAYJKoZIhvcNAQkB
Fh9jb250YWJpbGlkYWRAZ3J1cG9tb2xpY2VudHJvLnBlMS0wKwYDVQQDDCRDT05T
T1JDSU8gREUgSU5WRVJTSU9ORVMgV0FMVSBTLlIuTC4xFDASBgNVBAcMC0pFU1VT
IE1BUklBMRQwEgYDVQQIDAtMSU1BIC0gTElNQTEUMBIGA1UECwwLMjA1MjQxNjc5
NTcxMzAxBgNVBAsMKklzc3VlZCBieSBBQyBDQU1FUkZJUk1BIFBFUsOaIFNBQyBF
UiBbUEUxXTEtMCsGA1UECgwkQ09OU09SQ0lPIERFIElOVkVSU0lPTkVTIFdBTFUg
Uy5SLkwuMQswCQYDVQQGEwJQRTCCASIwDQYJKoZIhvcNAQEBBQADggEPADCCAQoC
ggEBAMCimspk/5W0flh0syuHallG4QgapKLLthuJggqmxvb4LvhSC5/LLZhaBGML
Lf03MQP5gJnORV9pBfoGWljxDbrPlmzuwC1pLTJQ0HVQzphgbUcun1cmD/0Le2sc
5V7IEabbP/5oGkIsla5x8m8mHxAPg0VmAdkzlRuS4OsUZzrxPsfcA7WfksqWZCeW
5pIawDew5hvQ9n4B2KgCTtEEVw1mSIK8bnoskqtCn97HbpaSkgXZQ2BOsF76dgfC
O0Xjwnoqo2ULeeuYY1thKlIC+vVLr1dknIIwR7vj8Llgzslv4pvLxDRA+u6XrVVw
IHBPJr/0pj+rpIiNKe94/tnPONsCAwEAAaOCAwswggMHMAwGA1UdEwEB/wQCMAAw
DgYDVR0PAQH/BAQDAgbAMB0GA1UdJQQWMBQGCCsGAQUFBwMCBggrBgEFBQcDBDAd
BgNVHQ4EFgQUFKLb7M8ZYgzWo1MJsBugpohlDc0wgY0GCCsGAQUFBwEBBIGAMH4w
VAYIKwYBBQUHMAKGSGh0dHA6Ly93d3cuY2FtZXJmaXJtYS5jb20vY2VydHMvYWNf
Y2FtZXJmaXJtYV9wZXJ1X2NlcnRpZmljYWRvcy0yMDE2LmNydDAmBggrBgEFBQcw
AYYaaHR0cDovL29jc3AuY2FtZXJmaXJtYS5jb20wHwYDVR0jBBgwFoAUOm5lGOdW
0uTzLd2lfHJt/zDhhicwgaAGA1UdHwSBmDCBlTBIoEagRIZCaHR0cDovL2NybC5j
YW1lcmZpcm1hLmNvbS9hY19jYW1lcmZpcm1hX3BlcnVfY2VydGlmaWNhZG9zLTIw
MTYuY3JsMEmgR6BFhkNodHRwOi8vY3JsMS5jYW1lcmZpcm1hLmNvbS9hY19jYW1l
cmZpcm1hX3BlcnVfY2VydGlmaWNhZG9zLTIwMTYuY3JsMIGGBgNVHREEfzB9gR9j
b250YWJpbGlkYWRAZ3J1cG9tb2xpY2VudHJvLnBlpFowWDFWMFQGCisGAQQBgYcu
HgoMRkNFUlRJRklDQURPIERFIFNFTExPIEVMRUNUUk9OSUNPIERFIEVNUFJFU0Eg
UEFSQSBBR0VOVEVTIEFVVE9NQVRJWkFET1MwHgYDVR0SBBcwFYETaW5mb0BjYW1l
cmZpcm1hLmNvbTCBqwYDVR0gBIGjMIGgMIGdBgwrBgEEAYGHLh4QMgEwgYwwNAYI
KwYBBQUHAgEWKGh0dHBzOi8vd3d3LmNhbWVyZmlybWEuY29tLnBlL25vcm1hdGl2
YS8wVAYIKwYBBQUHAgIwSBpGQ0VSVElGSUNBRE8gREUgU0VMTE8gRUxFQ1RST05J
Q08gREUgRU1QUkVTQSBQQVJBIEFHRU5URVMgQVVUT01BVElaQURPUzANBgkqhkiG
9w0BAQsFAAOCAgEAJCtChU3AgJImfz+teC3oybAfpNRPegQ0gvenbUcXbzQ0nArL
/OrrGjnt0Z5h15n8r9jwkj+gXdtQB2OFyL8+0is1MX9UKwxA6Oi0KHAFHKUE7PQ0
CWav1R1tugVLDY0Of7k63LTMQvPy761emJ5qpHODONkFOrdhiU48jMHzkN7RPG/b
i+Hqb2pLEeuIcxteeyfnDZPsK8bjIQTFzkK4Vgs2aiyL1mmlr2NVsgVM7swK6jH7
Ihe9D7pCS6LNlIjvqA4a+dAQpBmi0zq7b1ksshna5paKZkBV+dH3/y6LWzFClZEx
NDTnXRYX9iEk9mbxmI4EJvX4gsiUCf1QUuOfWnvy6I8legQFMXJXiLtNZV4U+VfA
7nuciFMkbHEUfo7FgiImMlDK7tLfaaBA8Fg5ONvJtFASnxlZKEW6DTk0L29CYJ0Z
t8JMqY72iw2NrhrVzpF7nb/9yCUUb8GFLlUHhqaPdeibmhtKNE+F4UQNBryK7HT5
dRiKaKMXl0LxwLDmaBkzrJk5mx1a1dbwTrHdIv2KrOqXjtDEbImKoMPCswPIQdpQ
0VbWgQ3X30N9LFBIrEIGdkFrFdu3bFyURfLgnjXJ+epZcxQJ6398x1qJ7Kp02nlP
DE69kJFgin2u6++zPxdFQzFgU7Njur8clbhCILRlFEXz9RXP/uk/nZ26bZY=
-----END CERTIFICATE-----
EOD;

$res = openssl_x509_read($cert);
$data = openssl_x509_parse($res);

echo "Subject CN: " . ($data['subject']['CN'] ?? 'N/A') . "\n";
echo "Issuer CN: " . ($data['issuer']['CN'] ?? 'N/A') . "\n";
echo "Serial Decimal: " . ($data['serialNumber'] ?? 'N/A') . "\n";

if (function_exists('gmp_init')) {
    $hex = gmp_strval(gmp_init($data['serialNumber'], 10), 16);
    echo "Serial Hex (GMP): " . $hex . "\n";
} else {
    // Basic PHP decimal to hex conversion for very large integers using bcmath if available, or custom
    $dec = $data['serialNumber'];
    $hex = '';
    while ($dec > 0) {
        $last = bcmod($dec, 16);
        $hex = dechex($last) . $hex;
        $dec = bcdiv($dec, 16, 0);
    }
    echo "Serial Hex (BC): " . $hex . "\n";
}

$validFrom = isset($data['validFrom_time_t']) ? date('Y-m-d H:i:s', $data['validFrom_time_t']) : 'N/A';
$validTo = isset($data['validTo_time_t']) ? date('Y-m-d H:i:s', $data['validTo_time_t']) : 'N/A';
echo "Valid From: " . $validFrom . "\n";
echo "Valid To: " . $validTo . "\n";
