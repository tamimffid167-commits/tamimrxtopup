<?php require __DIR__.'/common.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: index.php'); exit; }
check_csrf();
$uid = preg_replace('/\D+/', '', $_POST['uid'] ?? ''); $package = trim((string)($_POST['package'] ?? '')); $amount = filter_var($_POST['amount'] ?? null, FILTER_VALIDATE_INT); $method = (string)($_POST['method'] ?? ''); $sender = preg_replace('/\D+/', '', $_POST['sender'] ?? ''); $trxid = strtoupper(trim((string)($_POST['trxid'] ?? ''))); $customer = trim((string)($_POST['customer'] ?? ''));
if (!preg_match('/^[0-9]{5,20}$/', $uid) || !$package || strlen($package)>100 || !$amount || $amount<1 || $amount>100000 || !in_array($method,['bKash','Nagad'],true) || !preg_match('/^01[0-9]{9}$/',$sender) || !preg_match('/^[A-Z0-9-]{5,80}$/',$trxid) || !$customer || strlen($customer)>80) { http_response_code(422); exit('তথ্যগুলো সঠিকভাবে পূরণ করুন।'); }
$orders=orders_read(); foreach($orders as $o){ if(strcasecmp($o['trxid']??'', $trxid)===0){ http_response_code(409); exit('এই Transaction ID আগে জমা হয়েছে।'); } }
$id='RX'.date('ymd').strtoupper(bin2hex(random_bytes(3)));
$orders[]=['id'=>$id,'uid'=>$uid,'package'=>$package,'amount'=>$amount,'method'=>$method,'sender'=>$sender,'trxid'=>$trxid,'customer'=>$customer,'status'=>'Pending','created_at'=>date('c')]; orders_write($orders);
header('Location: index.php?sent='.urlencode($id)); exit;
