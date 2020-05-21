<?php
$config = array(
    "digest_alg" => "sha256",
    "private_key_bits" => 1024,
    "private_key_type" => OPENSSL_KEYTYPE_RSA,
    );
$res = openssl_pkey_new($config);
openssl_pkey_export($res, $privkey);
// $privkey = "-----BEGIN PRIVATE KEY-----
// MIICeAIBADANBgkqhkiG9w0BAQEFAASCAmIwggJeAgEAAoGBANq2uVjg0G4qrjS1
// VSN6Kh2vBsyWp8vuLIFNiaaqrG3yOxmCxuBDv98KPmGnoL5ppGQu/CYcnHm6WrAr
// XnRJfBXK2DCh3Y3L98daDWGc12Cg9m1d3Jw2wDqs+c3jCMskv+PS7iQwukOcWOYJ
// BDC9RkO5IadUSSeAO1U6Xen2tTxlAgMBAAECgYBpp3l0CO5HOdD731kokTxFKKcF
// MAYRCpZvRDCp1asEVc7c7QL7lV7b9Qvbiumo8kmap+Pg2VNxrmde0SSI0nLhA4Rx
// mELgJgdEozn1erlD2m8p5iVZRbM736TAUehg/8nQEoJjxC3y/0iEZebOFh8f+UTd
// oJGpbLWXU0aRwD+ThQJBAO5Cuf31n+VOpKIYLd8tAMTA9KibWS2FKwfL3lhB/LCl
// RQNPuKQLQOvmapDnApj6KzOeoFNgILOHYLeXPWbFSisCQQDq/26IP1qICHEgTAJv
// GjWnH3+q71qKypHdqhMqF7vMIaww5lgngPNEXQINT2txkSSPA63breBUqeVJIXDr
// jxuvAkEAv5HbJfzWYXNIICS8zVLL6WcT0HWH0HfgT1Z2IhR8bjOUN8NjvFJoEsSj
// Lnrvtbx/+/MxCZii8naJJ1RtRDKhHQJBAKpltx9CWQHkpSrXEri/F4JsW6V104Bq
// LGS/6w+NkBYPoI0AqZFTdpHuowtFuFHr/cdZ0ppFNTIO03w4rGmSJm8CQQCurM3T
// BQ8qZXVrakrFGFD5ZE/gkw27yR3PHvwaTgU+D8SSTokA/YkSmBSdHrCex7ZtPMuQ
// SqfJ61FBgmIEC/1J
// -----END PRIVATE KEY-----";

openssl_private_encrypt("something is wrong?", $crypted, $privkey);
$pubkey = openssl_pkey_get_details($res);
$pubkey = $pubkey["key"];
// $pubkey = "-----BEGIN PUBLIC KEY-----
// MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDatrlY4NBuKq40tVUjeiodrwbM
// lqfL7iyBTYmmqqxt8jsZgsbgQ7/fCj5hp6C+aaRkLvwmHJx5ulqwK150SXwVytgw
// od2Ny/fHWg1hnNdgoPZtXdycNsA6rPnN4wjLJL/j0u4kMLpDnFjmCQQwvUZDuSGn
// VEkngDtVOl3p9rU8ZQIDAQAB
// -----END PUBLIC KEY-----";

openssl_public_decrypt($crypted, $decrypted, $pubkey);
echo $privkey;
echo "<br />";
echo $pubkey;

?>
