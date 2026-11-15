<?php require __DIR__.'/common.php';
$success = isset($_GET['sent']); page_start('Payment'); ?>
<div class="card"><h1>RX TOPUP — Payment</h1><p class="muted">bKash এবং Nagad আলাদা পেমেন্ট অপশন। পেমেন্ট করার পর Transaction ID জমা দিন।</p>
<?php if ($success): ?><div class="ok">আপনার পেমেন্ট তথ্য জমা হয়েছে। Admin যাচাই করার পর অর্ডার আপডেট হবে। Order ID: <b><?=h($_GET['sent'])?></b></div><?php endif; ?>
<form method="post" action="submit.php" autocomplete="on"><input type="hidden" name="csrf" value="<?=h(csrf())?>">
<label>Free Fire UID</label><input name="uid" inputmode="numeric" pattern="[0-9]{5,20}" maxlength="20" required placeholder="আপনার Player UID">
<label>প্যাকেজের নাম</label><input name="package" maxlength="100" required placeholder="যেমন: 100 Diamonds">
<label>টাকার পরিমাণ (৳)</label><input name="amount" type="number" min="1" max="100000" step="1" required placeholder="যেমন: 100">
<label>Payment Method</label><select name="method" id="method" required><option value="">পেমেন্ট মাধ্যম বাছাই করুন</option><option value="bKash">bKash</option><option value="Nagad">Nagad</option></select>
<div class="method" id="instructions">পেমেন্ট মাধ্যম বাছাই করলে নম্বর দেখাবে।</div>
<label>যে নম্বর থেকে টাকা পাঠিয়েছেন</label><input name="sender" inputmode="numeric" pattern="01[0-9]{9}" maxlength="11" required placeholder="01XXXXXXXXX">
<label>Transaction ID (TrxID)</label><input name="trxid" maxlength="80" required placeholder="পেমেন্টের TrxID">
<label>কাস্টমারের নাম</label><input name="customer" maxlength="80" required placeholder="আপনার নাম">
<button type="submit">পেমেন্ট তথ্য জমা দিন</button></form><p class="muted">এটি আপাতত Manual verification। শুধু TrxID জমা দিলেই পেমেন্ট সফল প্রমাণ হয় না।</p></div>
<script>const cfg={bkash:<?=json_encode($config['bkash_number']??'নম্বর সেট করা হয়নি')?>,nagad:<?=json_encode($config['nagad_number']??'নম্বর সেট করা হয়নি')?>};document.getElementById('method').addEventListener('change',function(){let k=this.value==='bKash'?'bkash':this.value==='Nagad'?'nagad':'';document.getElementById('instructions').textContent=k?(this.value+' নম্বর: '+cfg[k]+'. '+<?=json_encode($config['payment_note']??'')?>):'পেমেন্ট মাধ্যম বাছাই করলে নম্বর দেখাবে।'});</script>
<?php page_end(); ?>
