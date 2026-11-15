RX TOPUP — PHP bKash + Nagad Payment Module
============================================

গুরুত্বপূর্ণ:
- আপনার মূল ওয়েবসাইটটি Node.js/Render-এ চলে। Render-এর Node service-এ .php ফাইল সরাসরি execute হবে না।
- এই PHP module চালাতে PHP 8.0+ ও HTTPS সমর্থিত PHP hosting লাগবে।
- এটি বর্তমানে Manual payment submission + Admin verification। এটি bKash/Nagad-এর official API auto-payment নয় এবং TrxID নিজে থেকে verify করে না।
- Supplier API যুক্ত না হওয়া পর্যন্ত Diamond delivery-ও automatic হবে না।

সেটআপ:
1) php-payment ফোল্ডারটি PHP hosting-এর public web directory-তে আপলোড করুন।
2) config.sample.php কপি করে config.php নাম দিন।
3) config.php-তে bKash/Nagad merchant নম্বর, payment note এবং admin_password_hash সেট করুন।
4) Admin password hash তৈরি করুন PHP command line-এ:
   php -r "echo password_hash('আপনার-শক্ত-পাসওয়ার্ড', PASSWORD_DEFAULT), PHP_EOL;"
   পাওয়া hash config.php-র admin_password_hash-এ বসান।
5) data/ ফোল্ডারে PHP process-এর write permission দিন। data/.htaccess থাকলেও Nginx hosting হলে hosting control panel থেকে data directory web access বন্ধ করুন।
6) Payment page: https://আপনার-php-domain/php-payment/index.php
   Admin: https://আপনার-php-domain/php-payment/admin.php
7) Live করার আগে test payment দিয়ে যাচাই করুন। config.php কখনো GitHub-এ commit করবেন না।

বর্তমান সীমাবদ্ধতা:
- এই module আপনার Node.js checkout-এ এখনো যুক্ত নয়। আলাদা PHP URL হিসেবে কাজ করবে।
- bKash/Nagad official checkout API যুক্ত করতে সংশ্লিষ্ট Merchant account, API credentials এবং provider-এর অনুমোদন/ডকুমেন্টেশন প্রয়োজন।
- Verified মানে admin হাতে যাচাই করেছেন। Delivered status-ও admin হাতে update করেন।
