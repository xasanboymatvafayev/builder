<?php
define('API_KEY',"API_TOKEN");

$builder24 = "ADMIN_ID";
$xostfile = "XOST/FILE";
$admins=file_get_contents("statistika/admins.txt");
$admin = explode("\n", $admins);
array_push($admin,$builder24);

function bot($method,$datas=[]){
$url = "https://api.telegram.org/bot".API_KEY."/".$method;
$ch = curl_init();
curl_setopt($ch,CURLOPT_URL,$url);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
curl_setopt($ch,CURLOPT_POSTFIELDS,$datas);
$res = curl_exec($ch);
if(curl_error($ch)){
var_dump(curl_error($ch));
}else{
return json_decode($res);
}}

function deleteFolder($path){
if(is_dir($path) === true){
$files = array_diff(scandir($path), array('.', '..'));
foreach ($files as $file)
deleteFolder(realpath($path) . '/' . $file);
return rmdir($path);
}else if (is_file($path) === true)
return unlink($path);
return false;
}

function hisob(){
$text = "🏆 TOP15 = Hisoblar\n\n";
$daten = [];
$rev = [];
$fayllar = glob("foydalanuvchi/hisob/*.*");
foreach($fayllar as $file){
if(mb_stripos($file,".txt")!==false){
$value = file_get_contents($file);
$id = str_replace(["foydalanuvchi/hisob/",".txt"],["",""],$file);
$daten[$value] = $id;
$rev[$id] = $value;
}
echo $file;
}
asort($rev);
$reversed = array_reverse($rev);
for($i=0;$i<15;$i+=1){
$order = $i+1;
$id = $daten["$reversed[$i]"];
$text.= "<b>{$order}</b>. <a href='tg://user?id={$id}'>{$id}</a> - "."<code>".$reversed[$i]."</code>"." <b>so'm</b>"."\n";
}
return $text;
}

function joinchat($id){
global $mid;
$array = array("inline_keyboard");
$kanallar=file_get_contents("statistika/kanal.txt");
if($kanallar == null){
return true;
}else{
$ex = explode("\n",$kanallar);
for($i=0;$i<=count($ex) -1;$i++){
$first_line = $ex[$i];
$first_ex = explode("@",$first_line);
$url = $first_ex[1];
$ism=bot('getChat',['chat_id'=>"@".$url,])->result->title;
$ret = bot("getChatMember",[
"chat_id"=>"@$url",
"user_id"=>$id,
]);
$stat = $ret->result->status;
if((($stat=="creator" or $stat=="administrator" or $stat=="member"))){
$array['inline_keyboard']["$i"][0]['text'] = "✅ ". $ism;
$array['inline_keyboard']["$i"][0]['url'] = "https://t.me/$url";
}else{
$array['inline_keyboard']["$i"][0]['text'] = "❌ ". $ism;
$array['inline_keyboard']["$i"][0]['url'] = "https://t.me/$url";
$uns = true;
}}
$array['inline_keyboard']["$i"][0]['text'] = "🔄 Tekshirish";
$array['inline_keyboard']["$i"][0]['callback_data'] = "check";
if($uns == true){
bot('sendMessage',[
'chat_id'=>$id,
'text'=>"<b>⚠️ Botdan to'liq foydalanish uchun quyidagi kanallarimizga obuna bo'ling!</b>",
'parse_mode'=>'html',
'disable_web_page_preview'=>true,
'reply_markup'=>json_encode($array),
]);
return false;
}else{
return true;
}}}

$update = json_decode(file_get_contents('php://input'));
$message = $update->message;
$cid = $message->chat->id;
$tx = $message->text;
$mid = $message->message_id;
$name = $message->from->first_name;
$fid = $message->from->id;
$callback = $update->callback_query;
$data = $callback->data;
$callid = $callback->id;
$ccid = $callback->message->chat->id;
$cmid = $callback->message->message_id;
$from_id = $update->message->from->id;
$token = $message->text;
$text = $message->text;
$message_id = $callback->message->message_id;
$data = $update->callback_query->data;
$callcid=$update->callback_query->message->chat->id;
$botdel = $update->my_chat_member->new_chat_member; 
$botdelid = $update->my_chat_member->from->id;
$status= $botdel->status;
$cqid = $update->callback_query->id;
$callfrid = $update->callback_query->from->id;
$botname = bot('getme',['bot'])->result->username;
$yangilash = "0";
#---------------------------------#
mkdir("foydalanuvchi");
mkdir("foydalanuvchi/hisob");
mkdir("foydalanuvchi/ban");
mkdir("foydalanuvchi/til");
mkdir("statistika");
mkdir("hamyon");
mkdir("botlar");
mkdir("step");
#---------------------------------#

if(file_get_contents("statistika/obunachi.txt")){
}else{
file_put_contents("statistika/obunachi.txt","");
}
if(file_get_contents("statistika/chiqdi.txt")){
} else{
file_put_contents("statistika/chiqdi.txt","");
}
if(file_get_contents("statistika/admins.txt")){
}else{
if(file_put_contents("statistika/admins.txt","$builder24"));
}
if(file_get_contents("statistika/kanal.txt")){
}else{
if(file_put_contents("statistika/kanal.txt",""));
}
if(file_get_contents("statistika/payments.txt")){
}else{
if(file_put_contents("statistika/payments.txt",""));
}
if(file_get_contents("statistika/yangilash.txt")){
}else{
if(file_put_contents("statistika/yangilash.txt","3000"));
}
if(file_get_contents("statistika/makerbot.txt")){
}else{
if(file_put_contents("statistika/makerbot.txt","0"));
}
if(file_get_contents("statistika/bonus.kun")){
}else{
if(file_put_contents("statistika/bonus.kun","10"));
}
if(file_get_contents("statistika/tolov.txt")){
}else{
if(file_put_contents("statistika/tolov.txt","500"));
}

if(file_exists("foydalanuvchi/hisob/$fid.txt")){
}else{
file_put_contents("foydalanuvchi/hisob/$fid.txt","0");
}
if(file_exists("foydalanuvchi/hisob/$fid.til")){
}else{
file_put_contents("foydalanuvchi/hisob/$fid.til","uz");
}
if(file_exists("statistika/ref_narx.txt")){
}else{
    file_put_contents("statistika/ref_narx.txt","150"); // Har bir referal uchun 300 so'm
}
if(file_exists("statistika/makerkunlik.txt")){
}else{
    file_put_contents("statistika/makerkunlik.txt","600"); 
}
$ref_narx = file_get_contents("statistika/ref_narx.txt");

$kanallar=file_get_contents("statistika/kanal.txt");
$ver=file_get_contents("statistika/versiya.txt");
$saved = file_get_contents("step/odam.txt");
$ban = file_get_contents("foydalanuvchi/ban/$fid.txt");
$statistika = file_get_contents("statistika/obunachi.txt");
$statchiqdi = file_get_contents("statistika/chiqdi.txt");
$bonuskun = file_get_contents("statistika/bonus.kun");
$makertolov = "600";
$botolov = file_get_contents("statistika/tolov.txt");
$makerbot = file_get_contents("statistika/makerbot.txt");
$hisob = file_get_contents("foydalanuvchi/hisob/$fid.txt");
$til = file_get_contents("foydalanuvchi/hisob/$fid.til");
$userstep=file_get_contents("step/$fid.txt");

if($tx){
if($ban == "ban"){
}else{
}}

if($data){
$ban = file_get_contents("foydalanuvchi/ban/$ccid.txt");
if($ban == "ban"){
}else{
}}

$main_menu = json_encode([
'resize_keyboard'=>true,
'keyboard'=>[
[['text'=>"➕ Bot yaratish"],['text'=>"🤖 Botlarim"]],
[['text'=>"📢 Reklama"],['text'=>"📱 Kabinet"]],
[['text'=>"📚 Qo'llanma"],['text'=>"💶 Pul kiritish"]],
]]);

$reklama = json_encode([
'resize_keyboard'=>true,
'keyboard'=>[
[['text'=>"➕ Reklama berish"],['text'=>"📈 Daromaddagi botlar"]],
[['text'=>"💸 Daromad qilish"]],
[['text'=>"◀️ Orqaga"]],
]]);

$main_menuad = json_encode([
'resize_keyboard'=>true,
'keyboard'=>[
[['text'=>"➕ Bot yaratish"],['text'=>"🤖 Botlarim"]],
[['text'=>"📢 Reklama"],['text'=>"📱 Kabinet"]],
[['text'=>"📚 Qo'llanma"],['text'=>"💶 Pul kiritish"]],
[['text'=>"🗄 Boshqaruv"]],
]]);

if(in_array($cid,$admin)){
$menyu = $main_menuad;
}
if(in_array($cid,$admin)){
}else{
$menyu = $main_menu;
}

if(in_array($ccid,$admin)){
$menyus = $main_menuad;
}
if(in_array($ccid,$admin)){
}else{
$menyus = $main_menu;
}

if(in_array($cid,$admin)){
$menyu = $main_menuad;
}
if(in_array($cid,$admin)){
}else{
$rumenyu = $rumain_menu;
}

if(in_array($ccid,$admin)){
$menyus = $main_menuad;
}
if(in_array($ccid,$admin)){
}else{
$rumenyus = $rumain_menu;
}

if($data == "check"){
if(joinchat($ccid)==true){
$til = file_get_contents("foydalanuvchi/hisob/$ccid.til");
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
if($til=="uz"){
bot('sendMessage',[
'chat_id'=>$ccid,
'text'=>"👋 <b>SkyBuilder — Telegram botlar yaratish uchun qulay platforma</b>

🤖 Bu platforma orqali siz <b>hech qanday kod yozmasdan</b> o‘z Telegram botlaringizni <i>tez va oson</i> yaratishingiz, ularni tahrirlashingiz hamda boshqarishingiz mumkin.

⚡️ <b>Nega aynan SkyBuilder?</b>

<blockquote>🔄 Botlar muntazam yangilanib boriladi  
🗂 Barqaror va mukammal ishlaydigan tizim  
🇺🇿 To‘liq o‘zbek tilidagi qulay interfeys  
💬 Doimiy va tezkor qo‘llab-quvvatlash xizmati  
🤖 Barcha jarayonlar avtomatik va tushunarli</blockquote>
👇 <i>Quyidagi menyudan kerakli bo‘limni tanlang:</i>",
'parse_mode'=>"html",
'reply_markup'=>$menyus,
]);
}elseif($til=="ru"){
bot('sendMessage',[
'chat_id'=>$ccid,
'text'=>"<b>🤖 Здравствуйте!</b>

@$botname поможет вам завести собственного мейкера в сети Telegram!

<b>📢 Следите за новостями:</b> @CreateMaker",
'parse_mode'=>"html",
'reply_markup'=>$rumenyus,
]);
}}else{
$til = file_get_contents("foydalanuvchi/hisob/$ccid.til");
if($til=="uz"){
bot('sendMessage',[
'chat_id'=>$ccid,
'text'=>"👋 <b>SkyBuilder — Telegram botlar yaratish uchun qulay platforma</b>

🤖 Bu platforma orqali siz <b>hech qanday kod yozmasdan</b> o‘z Telegram botlaringizni <i>tez va oson</i> yaratishingiz, ularni tahrirlashingiz hamda boshqarishingiz mumkin.

⚡️ <b>Nega aynan SkyBuilder?</b>

<blockquote>🔄 Botlar muntazam yangilanib boriladi  
🗂 Barqaror va mukammal ishlaydigan tizim  
🇺🇿 To‘liq o‘zbek tilidagi qulay interfeys  
💬 Doimiy va tezkor qo‘llab-quvvatlash xizmati  
🤖 Barcha jarayonlar avtomatik va tushunarli</blockquote>
👇 <i>Quyidagi menyudan kerakli bo‘limni tanlang:</i>",
'parse_mode'=>"html",
'reply_markup'=>$menyus,
]);
}elseif($til=="ru"){
bot('sendMessage',[
'chat_id'=>$ccid,
'text'=>"👋 <b>SkyBuilder — Telegram botlar yaratish uchun qulay platforma</b>

🤖 Bu platforma orqali siz <b>hech qanday kod yozmasdan</b> o‘z Telegram botlaringizni <i>tez va oson</i> yaratishingiz, ularni tahrirlashingiz hamda boshqarishingiz mumkin.

⚡️ <b>Nega aynan SkyBuilder?</b>

<blockquote>🔄 Botlar muntazam yangilanib boriladi  
🗂 Barqaror va mukammal ishlaydigan tizim  
🇺🇿 To‘liq o‘zbek tilidagi qulay interfeys  
💬 Doimiy va tezkor qo‘llab-quvvatlash xizmati  
🤖 Barcha jarayonlar avtomatik va tushunarli</blockquote>
👇 <i>Quyidagi menyudan kerakli bo‘limni tanlang:</i>",
'parse_mode'=>"html",
'reply_markup'=>$rumenyus,
]);
}}}

if(mb_stripos($tx, "/start") !== false){
    $refid = str_replace("/start_df ", "", $tx); // Referal IDni ajratib olish
    $user_list = file_get_contents("statistika/obunachi.txt");
    $is_new_user = (mb_stripos($user_list, $fid) === false); // Yangi yoki eskiligini tekshirish

    // 1. Agar foydalanuvchi yangi bo'lsa
    if($is_new_user){
        file_put_contents("statistika/obunachi.txt", $user_list . $fid . "\n");
        
        if(!empty($refid) && $refid != $fid && is_numeric($refid)){
            // Taklif qilgan odamning hisobini yangilash
            $ref_balance = file_get_contents("foydalanuvchi/hisob/$refid.txt");
            $new_balance = $ref_balance + 300;
            file_put_contents("foydalanuvchi/hisob/$refid.txt", $new_balance);
            
            // Taklif qilganga xabar (Muvaffaqiyatli)
            bot('sendMessage',[
                'chat_id' => $refid,
                'text' => "🔔 <b>Yangi referal!</b>\n\nSizning havolangiz orqali <a href='tg://user?id=$fid'>$name</a> qo'shildi. Hisobingizga <b>300 so'm</b> o'tkazildi.",
                'parse_mode' => 'html',
            ]);
        }
    } 
    // 2. Agar foydalanuvchi allaqachon botda bo'lsa va referal orqali kirgan bo'lsa
    elseif(!empty($refid) && $refid != $fid && is_numeric($refid)){
        bot('sendMessage',[
            'chat_id' => $refid,
            'text' => "⚠️ <b>Ogohlantirish!</b>\n\nSiz taklif qilgan foydalanuvchi (<a href='tg://user?id=$fid'>$name</a>) allaqachon botimizdan foydalanadi. Shu sababli sizga pul berilmadi.",
            'parse_mode' => 'html',
        ]);
    }

    // 3. Botning asosiy start xabari (Majburiy obunadan o'tgan bo'lsa)
    if(joinchat($fid) == "true"){
        $start_msg = "👋 <b>SkyBuilder — Telegram botlar yaratish uchun qulay platforma</b>

🤖 Bu platforma orqali siz <b>hech qanday kod yozmasdan</b> o‘z Telegram botlaringizni <i>tez va oson</i> yaratishingiz, ularni tahrirlashingiz hamda boshqarishingiz mumkin.

⚡️ <b>Nega aynan SkyBuilder?</b>

<blockquote>🔄 Botlar muntazam yangilanib boriladi  
🗂 Barqaror va mukammal ishlaydigan tizim  
🇺🇿 To‘liq o‘zbek tilidagi qulay interfeys  
💬 Doimiy va tezkor qo‘llab-quvvatlash xizmati  
🤖 Barcha jarayonlar avtomatik va tushunarli</blockquote>
👇 <i>Quyidagi menyudan kerakli bo‘limni tanlang:</i>";
        
        bot('sendMessage',[
            'chat_id'=>$cid,
            'text'=>$start_msg,
            'parse_mode'=>"html",
            'reply_markup'=>$menyu,
        ]);
        unlink("step/$cid.txt");
    }
}

$admin1_menu = json_encode([
'resize_keyboard'=>true,
'keyboard'=>[
[['text'=>"*⃣ Birlamchi"],['text'=>"🤖 Narx sozlamasi"]],
[['text'=>"📊 Statistika"],['text'=>"📨 Xabar yuborish"]],
[['text'=>"🔐Majburiy obuna kanallar"]],
[['text'=>"💳 Hamyonlar"],['text'=>"👤 Adminlar"]],
[['text'=>"🔎 Foydalanuvchini boshqarish"]],
[['text'=>"⬆️ Yangilash"],['text'=>"◀️ Orqaga"]],
]]);

if($tx=="📚 Qo'llanma" and joinchat($fid)=="true"){
if($til=="uz"){
bot('sendMessage',[
'chat_id'=>$cid,
'text'=>"📋 <b>Bot yaratish bo'yicha qo'llanma:</b> 

1⃣ @BotFather botiga kiring va /newbot buyrug'ini yuboring. So'ng, bot uchun nom va username (foydalanuvchi nomini) kiriting. Bot yaratilib, sizga TOKEN beriladi, uni nusxalab oling.

2⃣ @SkyBuilderBot botiga o'ting va «➕ Bot yaratish» tugmasini bosing.

3⃣ O'zingizga kerakli bot turini tanlang va «✅ Bot yaratish» tugmasini bosing.

4⃣ @BotFather tomonidan berilgan TOKEN ni botga yuboring. Agar «✅ Botingiz serverga joylandi» xabari chiqqan bo'lsa, botingiz muvaffaqiyatli yaratilgan hisoblanadi.",
'parse_mode'=>"html",
'reply_markup'=>$menyu,
]);
unlink("step/$cid.txt");
}elseif($til=="ru"){
bot('sendMessage',[
'chat_id'=>$cid,
'text'=>"<b>🤖 Здравствуйте!</b>

@$botname поможет вам завести собственного мейкера в сети Telegram!

<b>📢 Следите за новостями:</b> @CreateMaker",
'parse_mode'=>"html",
'reply_markup'=>$rumenyu,
]);
unlink("step/$cid.txt");
}}

if($tx=="⬆️ Yangilash"){
if(in_array($cid,$admin)){
bot('sendMessage',[
'chat_id'=>$cid,
'text'=>"⬆️ <b>Avto yangilash uchun bot turini tanlnag:</b>",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"📝 Yangilash narxi - $yangilash so'm",'callback_data'=>"yangilash_narx"]],
]])
]);
}}

if($data=="yangilash_narx" ){
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('sendMessage',[
'chat_id'=>$ccid,
'text'=>"<b>📝 Yangi qiymatni yuboring:</b>",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'resize_keyboard'=>true,
'keyboard'=>[
[['text'=>"🗄 Boshqaruv"]],
]])
]);
file_put_contents("step/$ccid.txt","yangilash");
}
if($userstep == "yangilash"){
if($tx=="🗄 Boshqaruv"){
unlink("step/$cid.txt");
}else{
file_put_contents("statistika/yangilash.txt","$tx");
bot('sendMessage',[
'chat_id'=>$cid,
'text'=>"<b>Muvaffaqiyatli o'zgartirildi!</b>",
'parse_mode'=>"html",
'reply_markup'=>$admin1_menu
]);
unlink("step/$cid.txt");
}}

if(mb_stripos($data, "avto=")!==false){
$ex = explode("=",$data);
$boturi = $ex[1];
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('sendMessage',[
'chat_id'=>$ccid,
'text'=>"<b>Avto yangilash boshlandi </b>",
'parse_mode'=>"html",
'reply_markup'=>$admin1_menu,
]);
$idtopish = glob("foydalanuvchi/status/*/status.txt");
foreach($idtopish as $idtopildi){
$ids = str_replace(["foydalanuvchi/status/","/status.txt"], ["",""], $idtopildi);
$botopish = glob("foydalanuvchi/$ids/*/kunlik.tolov");
foreach($botopish as $botopildi){
$exp = str_replace(["foydalanuvchi/$ids/","/kunlik.tolov"], ["",""], $botopildi);
$tokeni = file_get_contents("foydalanuvchi/$ids/$exp/info/token.txt");
$turi = file_get_contents("foydalanuvchi/$ids/$exp/info/turi.txt");
$bots=file_get_contents("foydalanuvchi/$ids/bots.txt");
if($bots==null){
deleteFolder("foydalanuvchi/$ids");
}
if($turi=="MakerBot"){
file_put_contents("foydalanuvchi/$ids/$exp/botlar/SarmoyaBot.php",file_get_contents("botlar/SarmoyaBot.php"));
file_put_contents("foydalanuvchi/$ids/$exp/botlar/ObunachiBot.php",file_get_contents("botlar/ObunachiBot.php"));
file_put_contents("foydalanuvchi/$ids/$exp/botlar/SpecialSMM Lite.php",file_get_contents("botlar/SpecialSMM Lite.php"));
file_put_contents("foydalanuvchi/$ids/$exp/botlar/PulBot Lite.php",file_get_contents("botlar/PulBot Lite.php"));
file_put_contents("foydalanuvchi/$ids/$exp/botlar/TurfaBot.php",file_get_contents("botlar/TurfaBot.php"));
file_put_contents("foydalanuvchi/$ids/$exp/botlar/GramAPIBot.php",file_get_contents("botlar/GramAPIBot.php"));
file_put_contents("foydalanuvchi/$ids/$exp/botlar/AvtoNakrutka.php",file_get_contents("botlar/AvtoNakrutka.php"));
file_put_contents("foydalanuvchi/$ids/$exp/botlar/Obunachi Lite.php",file_get_contents("botlar/Obunachi Lite.php"));
file_put_contents("foydalanuvchi/$ids/$exp/botlar/Reklamachi.php",file_get_contents("botlar/Reklamachi.php"));
file_put_contents("foydalanuvchi/$ids/$exp/botlar/SpecialMember.php",file_get_contents("botlar/SpecialMember.php"));
file_put_contents("foydalanuvchi/$ids/$exp/botlar/NamozVAQT.php",file_get_contents("botlar/NamozVAQT.php"));
file_put_contents("foydalanuvchi/$ids/$exp/botlar/AutoNumber.php",file_get_contents("botlar/AutoNumber.php"));
file_put_contents("foydalanuvchi/$ids/$exp/botlar/VideoDown.php",file_get_contents("botlar/VideoDown.php"));
file_put_contents("foydalanuvchi/$ids/$exp/botlar/KonstruktorBot.php",file_get_contents("botlar/KonstruktorBot.php"));
#mini
mkdir("foydalanuvchi/$ids/$exp/mini");
file_put_contents("foydalanuvchi/$ids/$exp/mini/SarmoyaBot.php",file_get_contents("mini/SarmoyaBot.php"));
file_put_contents("foydalanuvchi/$ids/$exp/mini/ObunachiBot.php",file_get_contents("mini/ObunachiBot.php"));
file_put_contents("foydalanuvchi/$ids/$exp/mini/SpecialSMM Lite.php",file_get_contents("mini/SpecialSMM Lite.php"));
file_put_contents("foydalanuvchi/$ids/$exp/mini/PulBot Lite.php",file_get_contents("mini/PulBot Lite.php"));
file_put_contents("foydalanuvchi/$ids/$exp/mini/TurfaBot.php",file_get_contents("mini/TurfaBot.php"));
file_put_contents("foydalanuvchi//$ids/$exp/mini/GramAPIBot.php",file_get_contents("mini/GramAPIBot.php"));
file_put_contents("foydalanuvchi/$ids/$exp/mini/AvtoNakrutka.php",file_get_contents("mini/AvtoNakrutka.php"));
file_put_contents("foydalanuvchi/$ids/$exp/mini/Obunachi Lite.php",file_get_contents("mini/Obunachi Lite.php"));
file_put_contents("foydalanuvchi/$ids/$exp/mini/Reklamachi.php",file_get_contents("mini/Reklamachi.php"));
file_put_contents("foydalanuvchi/$ids/$exp/mini/SpecialMember.php",file_get_contents("mini/SpecialMember.php"));
file_put_contents("foydalanuvchi/$ids/$exp/mini/NamozVAQT.php",file_get_contents("mini/NamozVAQT.php"));
file_put_contents("foydalanuvchi/$ids/$exp/mini/AutoNumber.php",file_get_contents("mini/AutoNumber.php"));
file_put_contents("foydalanuvchi/$ids/$exp/mini/VideoDown.php",file_get_contents("mini/VideoDown.php"));
}
if($turi=="$boturi"){
$kod =file_get_contents("mini/$boturi.php");
$kod = str_replace("API_TOKEN", "$tokeni", $kod);
$kod = str_replace("ADMIN_ID", "$ids", $kod);
file_put_contents("foydalanuvchi/$ids/$exp/$boturi.php","$kod");
$get = json_decode(file_get_contents("https://api.telegram.org/bot$tokeni/setwebhook?url=https://".$_SERVER['SERVER_NAME']."/$xostfile/foydalanuvchi/$ids/$exp/$boturi.php"))->result;
}}}
bot('sendMessage',[
'chat_id'=>$ccid,
'text'=>"<b>✅ Barcha botlar yangilandi </b>",
'parse_mode'=>"html",
]);
unlink("step/$cid.txt");
}

if($tx=="🤖 Narx sozlamasi" and in_array($cid,$admin)){
bot('sendMessage',[
'chat_id'=>$cid,
'text'=>"🤖 Narx sozlamasi:
<b>Maker uchun kunlik to'lov:</b> $makertolov so'm",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"1",'callback_data'=>"maker_kunlik"]],
]])
]);
}

if($data=="makerkunlik" ){
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('sendMessage',[
'chat_id'=>$ccid,
'text'=>"<b>📝 Yangi qiymatni yuboring:</b>",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'resize_keyboard'=>true,
'keyboard'=>[
[['text'=>"🗄 Boshqaruv"]],
]])
]);
file_put_contents("step/$ccid.txt","ref");
}
if($userstep == "ref"){
if($tx=="🗄 Boshqaruv"){
unlink("step/$cid.txt");
}else{
file_put_contents("statistika/makerkunlik.txt","$tx");
bot('sendMessage',[
'chat_id'=>$cid,
'text'=>"<b>Muvaffaqiyatli o'zgartirildi!</b>",
'parse_mode'=>"html",
'reply_markup'=>$admin1_menu
]);
unlink("step/$cid.txt");
}}

if($tx=="*⃣ Birlamchi" and in_array($cid,$admin)){
bot('sendMessage',[
'chat_id'=>$cid,
'text'=>"<b>*⃣ Birlamchi sozlamalar bo'limi:</b>

<b>1. Kunlik to'lov narxi:</b> $botolov so'm
<b>2. Bonus beriladigan to'lov kun:</b> $bonuskun kun
<b>3. Referal narxi:</b> $ref_narx so'm",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"1",'callback_data'=>"tolov_narxi"],['text'=>"2",'callback_data'=>"bonus_kun"],['text'=>"3",'callback_data'=>"refnarxi"]],
]])
]);
}

if($data=="refnarxi" ){
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('sendMessage',[
'chat_id'=>$ccid,
'text'=>"<b>📝 Yangi qiymatni yuboring:</b>",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'resize_keyboard'=>true,
'keyboard'=>[
[['text'=>"🗄 Boshqaruv"]],
]])
]);
file_put_contents("step/$ccid.txt","ref");
}
if($userstep == "ref"){
if($tx=="🗄 Boshqaruv"){
unlink("step/$cid.txt");
}else{
file_put_contents("statistika/ref_narx.txt","$tx");
bot('sendMessage',[
'chat_id'=>$cid,
'text'=>"<b>Muvaffaqiyatli o'zgartirildi!</b>",
'parse_mode'=>"html",
'reply_markup'=>$admin1_menu
]);
unlink("step/$cid.txt");
}}

if($data=="taklif_narxi" ){
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('sendMessage',[
'chat_id'=>$ccid,
'text'=>"<b>📝 Yangi qiymatni yuboring:</b>",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'resize_keyboard'=>true,
'keyboard'=>[
[['text'=>"🗄 Boshqaruv"]],
]])
]);
file_put_contents("step/$ccid.txt","taklif");
}
if($userstep == "taklif"){
if($tx=="🗄 Boshqaruv"){
unlink("step/$cid.txt");
}else{
file_put_contents("statistika/makerbot.txt","$tx");
bot('sendMessage',[
'chat_id'=>$cid,
'text'=>"<b>Muvaffaqiyatli o'zgartirildi!</b>",
'parse_mode'=>"html",
'reply_markup'=>$admin1_menu
]);
unlink("step/$cid.txt");
}}

if($data=="bonus_kun" ){
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('sendMessage',[
'chat_id'=>$ccid,
'text'=>"<b>📝 Yangi qiymatni yuboring:</b>",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'resize_keyboard'=>true,
'keyboard'=>[
[['text'=>"🗄 Boshqaruv"]],
]])
]);
file_put_contents("step/$ccid.txt","bkun");
}
if($userstep == "bkun"){
if($tx=="🗄 Boshqaruv"){
unlink("step/$cid.txt");
}else{
file_put_contents("statistika/bonus.kun","$tx");
bot('sendMessage',[
'chat_id'=>$cid,
'text'=>"<b>Muvaffaqiyatli o'zgartirildi!</b>",
'parse_mode'=>"html",
'reply_markup'=>$admin1_menu
]);
unlink("step/$cid.txt");
}}

if($data=="tolov_narxi"){
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('sendMessage',[
'chat_id'=>$ccid,
'text'=>"<b>📝 Yangi qiymatni yuboring:</b>",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'resize_keyboard'=>true,
'keyboard'=>[
[['text'=>"🗄 Boshqaruv"]],
]])
]);
file_put_contents("step/$ccid.txt","kunlik");
}
if($userstep == "kunlik"){
if($tx=="🗄 Boshqaruv"){
unlink("step/$cid.txt");
}else{
file_put_contents("statistika/tolov.txt", "$tx");
bot('sendMessage',[
'chat_id'=>$cid,
'text'=>"<b>Muvaffaqiyatli o'zgartirildi!</b>",
'parse_mode'=>"html",
'reply_markup'=>$admin1_menu
]);
unlink("step/$cid.txt");
}}


if($tx == "🗄 Boshqaruv"){
if(in_array($cid,$admin)){
bot('sendMessage',[
'chat_id'=>$cid,
'text'=>"<b>🗄 Boshqaruv paneliga xush kelibsiz!</b>",
'parse_mode'=>"html",
'reply_markup'=>$admin1_menu
]);
unlink("step/$cid.txt");
}}

if($text == "👤 Adminlar"){
if(in_array($cid,$admin)){
if($cid == $builder24){
bot('SendMessage',[
'chat_id'=>$builder24,
'text'=>"<b>Quyidagilardan birini tanlang:</b>",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"📑 Ro'yxatni ko'rish",'callback_data'=>"list"]],
[['text'=>"➕ Qo'shish",'callback_data'=>"add"],['text'=>"🗑 O'chirish",'callback_data'=>"remove"]],
]])
]);
}else{
bot('SendMessage',[
'chat_id'=>$cid,
'text'=>"<b>Quyidagilardan birini tanlang:</b>",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"📑 Ro'yxatni ko'rish",'callback_data'=>"list"]],
]])
]);
}}}

if($data == "admins"){
if($ccid == $builder24){
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);	
bot('SendMessage',[
'chat_id'=>$builder24,
'text'=>"<b>Quyidagilardan birini tanlang:</b>",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"📑 Ro'yxatni ko'rish",'callback_data'=>"list"]],
[['text'=>"➕ Qo'shish",'callback_data'=>"add"],['text'=>"🗑 O'chirish",'callback_data'=>"remove"]],
]])
]);
}else{
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);	
bot('SendMessage',[
'chat_id'=>$ccid,
'text'=>"<b>Quyidagilardan birini tanlang:</b>",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"📑 Ro'yxatni ko'rish",'callback_data'=>"list"]],
]])
]);
}}

if($data == "list"){
$admins=file_get_contents("statistika/admins.txt");
bot('editMessageText',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
'text'=>"<b>📑 Botdagi adminlar ro'yxati:</b>

$admins",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"◀️ Orqaga",'callback_data'=>"admins"]],
]])
]);
}

if($data == "add"){
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('SendMessage',[
'chat_id'=>$builder24,
'text'=>"*Kerakli ID raqamni kiriting:*",
'parse_mode'=>'MarkDown',
'reply_markup'=>json_encode([
'resize_keyboard'=>true,
'keyboard'=>[
[['text'=>"🗄 Boshqaruv"]],
]])
]);
file_put_contents("step/$ccid.txt",'add-admin');
}

if($userstep=="add-admin" and $cid == $builder24){
if($tx=="🗄 Boshqarish"){
unlink("step/$cid.step");
}else{
if(is_numeric($text)=="true"){
if($text != $builder24){
file_put_contents("statistika/admins.txt","$admins\n$text");
bot('SendMessage',[
'chat_id'=>$builder24,
'text'=>"✅ *$text* admin qilib tayinlandi!",
'parse_mode'=>'MarkDown',
'reply_markup'=>$admin1_menu,
]);
unlink("step/$cid.txt");
bot('SendMessage',[
'chat_id'=>$text,
'text'=>"<b>Admin qilib tayinlandingiz!</b>",
'parse_mode'=>'html',
'reply_markup'=>$main_menuad,
]);
}else{
bot('SendMessage',[
'chat_id'=>$cid,
'text'=>"<b>Kerakli ID raqamni kiriting:</b>",
'parse_mode'=>'html',
]);
}}else{
bot('SendMessage',[
'chat_id'=>$cid,
'text'=>"<b>Kerakli ID raqamni kiriting:</b>",
'parse_mode'=>'html',
]);
}}}

if($data == "remove"){
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('SendMessage',[
'chat_id'=>$builder24,
'text'=>"<b>Kerakli ID raqamni kiriting:</b>",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'resize_keyboard'=>true,
'keyboard'=>[
[['text'=>"🗄 Boshqaruv"]],
]])
]);
file_put_contents("step/$ccid.txt",'remove-admin');
}

if($userstep == "remove-admin" and $cid == $builder24){
if($tx=="🗄 Boshqarish"){
unlink("step/$cid.step");
}else{
if(is_numeric($text)=="true"){
if($text != $builder24){
$files=file_get_contents("statistika/admins.txt");
$file = str_replace("\n".$text."","",$files);
file_put_contents("statistika/admins.txt",$file);
bot('SendMessage',[
'chat_id'=>$builder24,
'text'=>"✅ *$text* adminlikdan olindi!",
'parse_mode'=>'MarkDown',
'reply_markup'=>$admin1_menu,
]);
unlink("step/$cid.txt");
bot('SendMessage',[
'chat_id'=>$text,
'text'=>"<b>Adminlikdan olindingiz!</b>",
'parse_mode'=>'html',
'reply_markup'=>$main_menu,
]);
}else{
bot('SendMessage',[
'chat_id'=>$cid,
'text'=>"<b>Kerakli ID raqamni kiriting:</b>",
'parse_mode'=>'html',
]);
}}else{
bot('SendMessage',[
'chat_id'=>$cid,
'text'=>"<b>Kerakli ID raqamni kiriting:</b>",
'parse_mode'=>'html',
]);
}}}

if($tx=="💳 Hamyonlar"){
if(in_array($cid,$admin)){
$kategoriya = file_get_contents("hamyon/kategoriya.txt");
$more = explode("\n",$kategoriya);
$soni = substr_count($kategoriya,"\n");
$keys=[];
for ($for = 1; $for <= $soni; $for++) {
$title=str_replace("\n","",$more[$for]);
$keys[]=["text"=>"$title - o'chirish","callback_data"=>"delete-$title"];
$keysboard2 = array_chunk($keys, 1);
$keysboard2[] = [['text'=>"➕ Yangi to'lov tizimi qo'shish",'callback_data'=>"yangi_tolov"]];
$key = json_encode([
'inline_keyboard'=>$keysboard2,
]);
}}

if($kategoriya != null){
bot('sendMessage',[
'chat_id'=>$cid,
'text'=>"<b>Quyidagilardan birini tanlang:</b>",
'parse_mode'=>"html",
'reply_markup'=>$key,
]);
}else{
bot('sendMessage',[
'chat_id'=>$cid,
'text'=>"<b>Quyidagilardan birini tanlang:</b>",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"➕ Yangi to'lov tizimi qo'shish",'callback_data'=>"yangi_tolov"]],
]])
]);
}}

if(mb_stripos($data, "delete-")!==false){
$ex = explode("-",$data);
$kat = $ex[1];
$royxat = file_get_contents("hamyon/kategoriya.txt");
$k = str_replace("\n".$kat."","",$royxat);
file_put_contents("hamyon/kategoriya.txt",$k);
deleteFolder("hamyon/$kat");
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('SendMessage',[
'chat_id'=>$ccid,
'text'=>"<b>$kat - nomli to'lov tizimi o'chirildi</b>",
'parse_mode'=>'html',
]);
}

if($data== "yangi_tolov"){
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('SendMessage',[
'chat_id'=>$ccid,
'text'=>"<b>Yangi to'lov tizimi nomini yuboring:

Masalan:</b> Click",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'resize_keyboard'=>true,
'keyboard'=>[
[['text'=>"🗄 Boshqaruv"]],
]])
]);
file_put_contents("step/$ccid.txt","tolov");
}

if($userstep=="tolov"){
if($tx=="🗄 Boshqaruv"){
unlink("step/$cid.txt");
}else{
if(isset($text)){
$kategoriya2 = file_get_contents("hamyon/kategoriya.txt");
file_put_contents("hamyon/kategoriya.txt","$kategoriya2\n$text");
mkdir("hamyon/$text");
bot('SendMessage',[
'chat_id'=>$cid,
'text'=>"<b>Ushbu to'lov tizimidagi hamyoningiz raqamini yuboring:</b>",
'parse_mode'=>'html',
]);
file_put_contents("step/$cid.txt","raqam-$text");
}else{
bot('SendMessage',[
'chat_id'=>$cid,
'text'=>"<b>Yangi to'lov tizimi nomini yuboring:

Masalan:</b> Click",
'parse_mode'=>'html',
]);
}}}

if(mb_stripos($userstep, "raqam-")!==false){
$ex = explode("-",$userstep);
$kat = $ex[1];
if($tx=="🗄 Boshqaruv"){
unlink("step/$cid.txt");
unlink("hamyon/$kat");
}else{
if(is_numeric($text)){
file_put_contents("hamyon/$kat/raqam.txt",$text);
bot('SendMessage',[
'chat_id'=>$cid,
'text'=>"<b>$kat - nomli to'lov tizimi qo'shildi</b>",
'parse_mode'=>'html',
'reply_markup'=>$admin1_menu,
]);
unlink("step/$cid.txt");
}else{
bot('SendMessage',[
'chat_id'=>$cid,
'text'=>"<b>Ushbu to'lov tizimidagi hamyoningiz raqamini yuboring:</b>",
'parse_mode'=>'html',
]);
}}}

if($tx=="🔎 Foydalanuvchini boshqarish"){
if(in_array($cid,$admin)){
bot('sendMessage',[
'chat_id'=>$cid,
'text'=>"<b>Kerakli foydalanuvchining ID raqamini yuboring:</b>",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'resize_keyboard'=>true,
'keyboard'=>[
[['text'=>"🗄 Boshqaruv"]],
]])
]);
file_put_contents("step/$cid.txt","idraqam");
}}

if($userstep=="idraqam"){
if($tx=="🗄 Boshqaruv"){
unlink("step/$cid.txt");
}else{
if(stripos($statistika,"$text")== true){
file_put_contents("step/odam.txt",$tx);
$hisob=file_get_contents("foydalanuvchi/hisob/$text.txt");
$ban = file_get_contents("foydalanuvchi/ban/$text.txt");
if($ban == null){
$bans = "🔔 Banlash";
}
if($ban == "ban"){
$bans = "🔕 Bandan olish";
}
bot("sendMessage",[
"chat_id"=>$cid,
"text"=>"<b>✅ Foydalanuvchi topildi:</b> <a href='tg://user?id=$tx'>$tx</a>

<b>Hisob:</b> $hisob so'm",
'parse_mode'=>"html",
"reply_markup"=>json_encode([
'inline_keyboard'=>[
[['text'=>"$bans",'callback_data'=>"ban"]],
[['text'=>"➕ Pul qo'shish",'callback_data'=>"qoshish"],['text'=>"➖ Pul ayirish",'callback_data'=>"ayirish"]],
]])
]); 
unlink("step/$cid.txt");
}else{
bot('SendMessage',[
'chat_id'=>$cid,
'text'=>"<b>Foydalanuvchi topilmadi!</b>

<i>Qayta yuboring:</i>",
'parse_mode'=>'html',
]);
}}}

if($data == "qoshish"){
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('sendMessage',[
'chat_id'=>$ccid,
'parse_mode'=>"html",
'text'=>"<a href='tg://user?id=$saved'>$saved</a> <b>ning hisobiga qancha pul qo'shmoqchisiz?</b>",
'reply_markup'=>json_encode([
'resize_keyboard'=>true,
'keyboard'=>[
[['text'=>"🗄 Boshqaruv"]],
]])
]);
file_put_contents("step/$ccid.txt","qoshish");
}

if($userstep == "qoshish"){
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
if($tx=="🗄 Boshqaruv"){
unlink("step/$cid.txt");
unlink("step/odam.txt");
}else{
$odam=file_get_contents("foydalanuvchi/hisob/$saved.til");
if($odam=="uz"){
$hisob = file_get_contents("foydalanuvchi/hisob/$saved.txt");
$plus = $hisob + $tx;
file_put_contents("foydalanuvchi/hisob/$saved.txt", $plus);
bot('sendMessage',[
'chat_id'=>$saved,
'text'=>"<b>Adminlar tomonidan hisobingiz +$tx so'm to'ldirildi!</b>",
'parse_mode'=>"html",
]);
}elseif($odam=="ru"){
$hisob = file_get_contents("foydalanuvchi/hisob/$saved.txt");
$plus = $hisob + $tx;
file_put_contents("foydalanuvchi/hisob/$saved.txt", $plus);
bot('sendMessage',[
'chat_id'=>$saved,
'text'=>"<b>Администрация пополнила ваш счет +$tx сум!",
'parse_mode'=>"html",
]);
}
bot('sendMessage',[
'chat_id'=>$cid,
'text'=>"<b>Foydalanuvchi hisobiga +$tx qo'shildi!</b>",
'parse_mode'=>"html",
'reply_markup'=>$admin1_menu,
]);
unlink("step/$cid.txt");
unlink("step/odam.txt");
}}

if($data == "ayirish"){
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('sendMessage',[
'chat_id'=>$ccid,
'parse_mode'=>"html",
'text'=>"<a href='tg://user?id=$saved'>$saved</a> <b>ning hisobidan qancha pul ayirmoqchisiz?</b>",
'reply_markup'=>json_encode([
'resize_keyboard'=>true,
'keyboard'=>[
[['text'=>"🗄 Boshqaruv"]],
]])
]);
file_put_contents("step/$ccid.txt","ayirish");
}

if($userstep == "ayirish"){
if($tx=="🗄 Boshqaruv"){
unlink("step/$cid.txt");
unlink("step/odam.txt");
}else{
$odam=file_get_contents("foydalanuvchi/hisob/$saved.til");
if($odam=="uz"){
bot('sendMessage',[
'chat_id'=>$saved,
'text'=>"<b>Adminlar tomonidan hisobingizdan $tx so'm olib tashlandi</b>",
'parse_mode'=>"html",
]);
}elseif($odam=="ru"){
bot('sendMessage',[
'chat_id'=>$saved,
'text'=>"<b>$tx сум удалены из вашего аккаунта администраторами</b>",
'parse_mode'=>"html",
]);
}
bot('sendMessage',[
'chat_id'=>$cid,
'text'=>"<b>Foydalanuvchi hisobidan $tx so'm olib tashlandi</b>",
'parse_mode'=>"html",
'reply_markup'=>$admin1_menu,
]);
$get = file_get_contents("foydalanuvchi/hisob/$saved.txt");
$get -= $tx;
file_put_contents("foydalanuvchi/hisob/$saved.txt", $get);
unlink("step/$cid.txt");
unlink("step/odam.txt");
}}

if($data=="ban"){
$ban = file_get_contents("foydalanuvchi/ban/$saved.txt");
if($builder24 != $saved){
if($ban == "ban"){
unlink("foydalanuvchi/ban/$saved.txt");
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('sendMessage',[
'chat_id'=>$ccid,
'text'=>"<b>Foydalanuvchi bandan olindi!</b>",
'parse_mode'=>"html",
'reply_markup'=>$admin1_menu,
]);
}else{
file_put_contents("foydalanuvchi/ban/$saved.txt",'ban');
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('sendMessage',[
'chat_id'=>$ccid,
'text'=>"<b>Foydalanuvchi banlandi!</b>",
'parse_mode'=>"html",
]);
}}else{
bot('answerCallbackQuery',[
'callback_query_id'=>$callid,
'text'=>"Asosiy adminni bloklash mumkin emas!",
'show_alert'=>true,
]);
}}

if($data == "oddiy_xabar"){
$odam=substr_count($statistika,"\n");
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('sendMessage',[
'chat_id'=>$ccid,
'text'=>"<b>$odam ta foydalanuvchiga yuboriladigan xabar matnini yuboring:</b>",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'resize_keyboard'=>true,
'keyboard'=>[
[['text'=>"🗄 Boshqaruv"]],
]])
]);
file_put_contents("step/$ccid.txt","oddiy");
}
if($userstep=="oddiy"){
if($tx=="🗄 Boshqaruv"){
unlink("oddiy.txt");
}else{
$odam=substr_count($statistika,"\n");
bot('sendmessage',[
'chat_id'=>$cid,
'text'=>"<b>$odam ta foydalanuvchiga xabar yuborish boshlandi!</b>",
'parse_mode'=>"html",
'reply_markup'=>$admin1_menu,
]);
$odam = explode("\n",$statistika);
foreach($odam as $odamlar){
$oddiy=bot("sendMessage",[
'chat_id'=>$odamlar,
'text'=>"$text",
'parse_mode'=>'html'
]);
unlink("step/$cid.txt");
}}}
if($oddiy){
$odam=substr_count($statistika,"\n");
bot("sendmessage",[
'chat_id'=>$cid,
'text'=>"<b>$lich ta foydalanuvchiga muvaffaqiyatli yuborildi</b>",
'parse_mode'=>'html',
'reply_markup'=>$admin1_menu,
]);
unlink("step/$cid.txt");
}

if($data =="forward_xabar"){
$odam=substr_count($statistika,"\n");
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('sendMessage',[
'chat_id'=>$ccid,
'text'=>"<b>$odam ta foydalanuvchiga yuboriladigan xabarni forward shaklida yuboring:</b>",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'resize_keyboard'=>true,
'keyboard'=>[
[['text'=>"🗄 Boshqaruv"]],
]])
]);
file_put_contents("step/$ccid.txt","forward");
}
if($userstep=="forward"){
if($tx=="🗄 Boshqaruv"){
unlink("step/$cid.txt");
}else{
$odam=substr_count($statistika,"\n");
bot('sendmessage',[
'chat_id'=>$cid,
'text'=>"<b>$odam ta foydalanuvchiga xabar yuborish boshlandi!</b>",
'parse_mode'=>"html",
'reply_markup'=>$admin1_menu,
]);
$odam = explode("\n",$statistika);
foreach($odam as $odamlar){
$forward=bot("forwardMessage",[
'from_chat_id'=>$cid,
'chat_id'=>$odamlar,
'message_id'=>$mid,
]);
unlink("step/$cid.txt");
}}}
if($forward){
$odam=substr_count($statistika,"\n");
bot("sendmessage",[
'chat_id'=>$cid,
'text'=>"<b>$odam ta foydalanuvchiga muvaffaqiyatli yuborildi</b>",
'parse_mode'=>'html',
'reply_markup'=>$admin1_menu,
]);
unlink("step/$cid.txt");
}


if($tx == "🗣"){ //E
    $ref_link = "https://t.me/$botname?start=$fid";
    
    $keyboard = [
        'inline_keyboard' => [
            [
                ['text' => "📤 Ulashish", 'url' => "https://t.me/share/url?url=$ref_link"]
            ],
        ]
    ];

    bot('sendMessage',[
        'chat_id'=>$cid,
        'text'=>"⛓ Quyidagi linkni do'stlaringizga yuboring:

🛜 • <code>$ref_link</code>

📖 Har bir taklif uchun sizga $ref_narx so'm taqdim etiladi. Qachonki taklifingiz to'liq botdan foydalanishni boshlasagina!❕",
        'parse_mode'=>'html',
        'reply_markup'=>json_encode($keyboard)
    ]);
}

if($tx=="📨 Xabar yuborish"){
if(in_array($cid,$admin)){
bot('sendMessage',[
'chat_id'=>$cid,
'text'=>"<b>📨 Yuboriladigan xabar turini tanlang:</b>",
'parse_mode'=>"html",
'reply_markup'=> json_encode([
'inline_keyboard'=>[
[['text'=>"📨 Oddiy xabar",'callback_data'=>"oddiy_xabar"],['text'=>"📨 Forward xabar",'callback_data'=>"forward_xabar"]],
]])
]);
}}

$admin6_menu = json_encode([
'inline_keyboard'=>[
[['text'=>"📋 Ro'yxatni ko'rish",'callback_data'=>"mroyxat"]],
[['text'=>"➕ Kanal qo'shish",'callback_data'=>"mulash"],['text'=>"🗑 O'chirish",'callback_data'=>"mochir"]],
]]);

if($data=="kanalsoz"){
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('sendMessage',[
'chat_id'=>$ccid,
'text'=>"<b>Quyidagilardan birini tanlang:</b>",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"📋 Ro'yxatni ko'rish",'callback_data'=>"mroyxat"]],
[['text'=>"➕ Kanal qo'shish",'callback_data'=>"mulash"],['text'=>"🗑 O'chirish",'callback_data'=>"mochir"]],
]])
]);
}

if($tx == "📊 Statistika"){
if(in_array($cid,$admin)){
$odam=substr_count($statistika,"\n");
$kick=substr_count($statchiqdi,"\n");
$umumiy = $odam - $kick;
$load = sys_getloadavg();
bot('sendMessage',[
'chat_id'=>$cid,
'text'=>"<b>💡 O'rtacha yuklanish:</b> <code>$load[0]</code>

<b>🔵 Obunachilar: $odam ta</b>
<b>🔴 Tark etganlar: $kick ta</b>
<b>🟢 Faol Obunachilar: $umumiy ta</b>",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"🔁 Yangilash",'callback_data'=>"stats"]],
[['text'=>"🏆 Hisoblarni kuzatish",'callback_data'=>"hisob"]],
]])
]);
}}

if($data=="stats"){
$odam=substr_count($statistika,"\n");
$kick=substr_count($statchiqdi,"\n");
$umumiy = $odam - $kick;
$load = sys_getloadavg();
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('sendMessage',[
'chat_id'=>$ccid,
'text'=>"<b>💡 O'rtacha yuklanish:</b> <code>$load[0]</code>

<b>🔵 Obunachilar: $odam ta</b>
<b>🔴 Tark etganlar: $kick ta</b>
<b>🟢 Faol Obunachilar: $umumiy ta</b>",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"🔁 Yangilash",'callback_data'=>"stats"]],
[['text'=>"🏆 Hisoblarni kuzatish",'callback_data'=>"hisob"]],
]])
]);
}

if($data=="hisob" ){
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
$hisoblar = hisob();
bot('sendMessage',[
'chat_id'=>$ccid,
'text'=>"$hisoblar",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"◀️ Orqaga",'callback_data'=>"stats"]],
]])
]);
}

if($tx=="🔐Majburiy obuna kanallar"){
if(in_array($cid,$admin)){
bot('sendMessage',[
'chat_id'=>$cid,
'text'=>"<b>Quyidagilardan birini tanlang:</b>",
'parse_mode'=>"html",
'reply_markup'=>$admin6_menu
]);
}}

if($data=="mulash"){
bot('sendMessage',[
'chat_id'=>$ccid,
'text'=>"<b>📢 Kerakli kanalni manzilini yuboring:</b>

Namuna: @HaydarovUz",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'resize_keyboard'=>true,
'keyboard'=>[
[['text'=>"🗄 Boshqaruv"]],
]])
]);
file_put_contents("step/$ccid.txt","kanal_ula");
}
if($userstep == "kanal_ula"){
if($tx=="🗄 Boshqaruv"){
unlink("step/$cid.txt");
}else{
if(stripos($text,"@")!==false){
if($kanallar == null){
file_put_contents("statistika/kanal.txt", $text);
bot('SendMessage',[
'chat_id'=>$cid,
'text'=>"<b>$text - kanal qo'shildi</b>",
'parse_mode'=>'html',
'reply_markup'=>$admin1_menu,
]);
unlink("step/$cid.txt");
}else{
file_put_contents("statistika/kanal.txt","$kanallar\n$text");
bot('SendMessage',[
'chat_id'=>$cid,
'text'=>"<b>$text - kanal qo'shildi</b>",
'parse_mode'=>'html',
'reply_markup'=>$admin1_menu,
]);
unlink("step/$cid.txt");
}}else{
bot('SendMessage',[
'chat_id'=>$cid,
'text'=>"<b>⚠️ Kanal manzili kiritishda xatolik:</b>

Masalan: @HaydarovUz",
'parse_mode'=>'html',
]);
}}}

if($data=="mochir"){
bot('editMessageText',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
'text'=>"<b>Barcha kanallar o'chirildi</b>",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"◀️ Orqaga",'callback_data'=>"kanalsoz"]],
]])
]);
deleteFolder("statistika/kanal.txt");
}

if($data=="mroyxat"){
if($kanallar==null){
bot('editMessageText',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
'text'=>"<b>Kanallar ulanmagan!</b>",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"◀️ Orqaga",'callback_data'=>"kanalsoz"]],
]])
]);
}else{
$soni = substr_count($kanallar,"@");
bot('editMessageText',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
'text'=>"<b>Ulangan kanallar ro'yxati ⤵️</b>
➖➖➖➖➖➖➖➖

<i>$kanallar</i>

<b>Ulangan kanallar soni:</b> $soni ta",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"◀️ Orqaga",'callback_data'=>"kanalsoz"]],
]])
]);
}}

if(isset($callback)){
$get = file_get_contents("statistika/obunachi.txt");
if(mb_stripos($get,$callfrid)==false){
file_put_contents("statistika/obunachi.txt", "$get\n$callfrid");
bot('sendMessage',[
'chat_id'=>$builder24,
'text'=>"<b>🟢 Yangi obunachi qo'shildi</b>",
'parse_mode'=>"html"
]);
}}

if(isset($message)){
$get = file_get_contents("statistika/obunachi.txt");
if(mb_stripos($get,$fid)==false){
file_put_contents("statistika/obunachi.txt", "$get\n$fid");
bot('sendMessage',[
'chat_id'=>$builder24,
'text'=>"<b>🟢 Yangi obunachi qo'shildi</b>",
'parse_mode'=>"html"
]);
}}

if($botdel){
if($status=="kicked"){ 
$get = file_get_contents("statistika/chiqdi.txt");
if(mb_stripos($get,$botdelid)==false){
file_put_contents("statistika/chiqdi.txt", "$get\n$botdelid");
bot('sendMessage',[
'chat_id'=>$builder24,
'text'=>"<b>🔴 Obunachi botni tark etdi</b>",
'parse_mode'=>"html"
]);
}}}

if($data == "tezdauz" and joinchat($ccid)=="true"){
bot('answerCallbackQuery',[
'callback_query_id'=>$callid,
'text'=>"ℹ️ Diqqat: Tanlangan bot turi hozircha mavjud emas. Loyhalash jarayonida. Yaqin kunlarda ishga tushadi.",
'show_alert'=>true,
]);
}

if($tx=="➕ Bot yaratish" or $tx=="➕ Создать нового бота"){
if(joinchat($cid)=="true"){
$hisob = file_get_contents("foydalanuvchi/hisob/$cid.txt");
if($til=="uz"){
bot('sendMessage',[
'chat_id'=>$cid,
'text'=>"<b>📂 Bot turini tanlab oling:</b>",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"🎬Media botlar",'callback_data'=>"Mediabotlar"]],
[['text'=>"🚀 SMM botlar",'callback_data'=>"SMMbotlar"]],
[['text'=>"📥 Yuklovchi botlar",'callback_data'=>"Yuklovchibotlar"]],
[['text'=>"💰 Moliyaviy botlar",'callback_data'=>"Moliyaviybotlar"]],
[['text'=>"🤖 Maker botlar",'callback_data'=>"Makerbotlar"]],
[['text'=>"🛍 Savdo va Biznes botlar",'callback_data'=>"SavdovaBiznesbotlar"]],
[['text'=>"🏷 Yordamchi botlar",'callback_data'=>"Yordamchibotlar"]],
]])
]);
}elseif($til=="ru"){
bot('sendMessage',[
'chat_id'=>$cid,
'text'=>"<b>⬇️ Выберите одного из следующих ботов:</b>",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"▫️ MakerBot",'callback_data'=>"create=MakerBot=$makerbot"],['text'=>"▪️ SeenMaker",'callback_data'=>"tezdaru"]],
[['text'=>"*⃣ Дополнительные боты",'callback_data'=>"qoshimcha"]],
]])
]);
}}}

if($data=="yangibot"){
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
$hisob = file_get_contents("foydalanuvchi/hisob/$ccid.txt");
if($til=="uz"){
bot('sendMessage',[
'chat_id'=>$ccid,
'text'=>"<b>📂 Bot turini tanlab oling:</b>",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"🎬Media botlar",'callback_data'=>"Mediabotlar"]],
[['text'=>"🚀 SMM botlar",'callback_data'=>"SMMbotlar"]],
[['text'=>"📥 Yuklovchi botlar",'callback_data'=>"Yuklovchibotlar"]],
[['text'=>"💰 Moliyaviy botlar",'callback_data'=>"Moliyaviybotlar"]],
[['text'=>"🤖 Maker botlar",'callback_data'=>"Makerbotlar"]],
[['text'=>"🛍 Savdo va Biznes botlar",'callback_data'=>"SavdovaBiznesbotlar"]],
[['text'=>"🏷 Yordamchi botlar",'callback_data'=>"Yordamchibotlar"]],
]])
]);
}elseif($til=="ru"){
bot('sendMessage',[
'chat_id'=>$ccid,
'text'=>"<b>⬇️ Выберите одного из следующих ботов:</b>",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"▫️ MakerBot",'callback_data'=>"create=MakerBot=$makerbot"],['text'=>"▪️ SeenMaker️",'callback_data'=>"tezdaru"]],
[['text'=>"*⃣ Дополнительные боты",'callback_data'=>"qoshimcha"]],
]])
]);
}}

if($data=="Yuklovchibotlar"){
    bot('deleteMessage',[
        'chat_id'=>$ccid,
        'message_id'=>$cmid,
    ]);

    // ===== BOTLAR SONINI ANIQLASH =====
    $bots_file = "foydalanuvchi/$ccid/bots.txt";

    if(file_exists($bots_file)){
        $bots = array_filter(explode("\n", trim(file_get_contents($bots_file))));
        $bot_soni = count($bots);
    } else {
        $bot_soni = 0;
    }

    $hisob = file_get_contents("foydalanuvchi/hisob/$ccid.txt");

    if($til=="uz"){
        bot('sendMessage',[
            'chat_id'=>$ccid,
            'text'=>"<b>📋 Ushbu bo‘limda mavjud botlar ro‘yxati:</b>",
            'parse_mode'=>"html",
            'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [['text'=>"📥 Instagram Saver Bot - 25000 so'm",'callback_data'=>"tezdauz"]],
                    [['text'=>"⬅️ Ortga qaytish",'callback_data'=>"yangibot"]],
                ]
            ])
        ]);
    }
}

if($data=="Yordamchibotlar"){
    bot('deleteMessage',[
        'chat_id'=>$ccid,
        'message_id'=>$cmid,
    ]);

    // ===== BOTLAR SONINI ANIQLASH =====
    $bots_file = "foydalanuvchi/$ccid/bots.txt";

    if(file_exists($bots_file)){
        $bots = array_filter(explode("\n", trim(file_get_contents($bots_file))));
        $bot_soni = count($bots);
    } else {
        $bot_soni = 0;
    }

    // ===== NARXNI BELGILASH =====
    if($bot_soni >= 2){
        $narx = "15000";
    } else {
        $narx = "0";
    }

    $hisob = file_get_contents("foydalanuvchi/hisob/$ccid.txt");

    if($til=="uz"){
        bot('sendMessage',[
            'chat_id'=>$ccid,
            'text'=>"<b>📋 Ushbu bo‘limda mavjud botlar ro‘yxati:</b>",
            'parse_mode'=>"html",
            'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [['text'=>"🎀 Suhbatchi bot - $narx so'm",'callback_data'=>"SuhbatchiBot"]],
                    [['text'=>"⬅️ Ortga qaytish",'callback_data'=>"yangibot"]],
                ]
            ])
        ]);
    }
}

if($data=="SuhbatchiBot"){
    bot('deleteMessage',[
        'chat_id'=>$ccid,
        'message_id'=>$cmid,
    ]);

    // ===== BOTLAR SONINI ANIQLASH =====
    $bots_file = "foydalanuvchi/$ccid/bots.txt";

    if(file_exists($bots_file)){
        $bots = array_filter(explode("\n", trim(file_get_contents($bots_file))));
        $bot_soni = count($bots);
    } else {
        $bot_soni = 0;
    }

    // ===== NARXNI BELGILASH =====
    if($bot_soni >= 2){
        $narx = "15000";
    } else {
        $narx = "0";
    }

    $hisob = file_get_contents("foydalanuvchi/hisob/$ccid.txt");

    if($til=="uz"){
        bot('sendMessage',[
            'chat_id'=>$ccid,
            'text'=>"🤖 – « 🎀 Suhbatchi bot »

⚙️ <b>Versiya:</b> 0.0.1 v
🖲 <b>Dastur:</b> php8.4

💵 <b>Narxi:</b> $narx so'm
📆 <b>To'lov:</b> 15000 so'm (500 so'm/kun)


<blockquote>⚙️Muhum sozlamalar:
• Guruhlarga xabar yuborish
• Foydalanuvchilarga xabar yuborish
• Guruhda so'z yodlab gaplasha oladi</blockquote>

🎁 <i>Botning 5 kunlik to'lovi bepul taqdim etiladi!</i>",
            'parse_mode'=>"html",
            'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [['text'=>"🚀 Botni yaratish",'callback_data'=>"creates=SuhbatchiBot"]],
                    [['text'=>"⬅️ Ortga qaytish",'callback_data'=>"Yordamchibotlar"]],
                ]
            ])
        ]);
    }
}

if(mb_stripos($data, "creates=")!==false){
    $ex = explode("=",$data);
    $turi = $ex[1];

    // ===== BOTLAR SONINI ANIQLASH =====
    $bots_file = "foydalanuvchi/$ccid/bots.txt";

    if(file_exists($bots_file)){
        $bots = array_filter(explode("\n", trim(file_get_contents($bots_file))));
        $bot_soni = count($bots);
    } else {
        $bot_soni = 0;
    }

    // ===== NARXNI AVTOMATIK BELGILASH =====
    if($bot_soni >= 2){
        $narx = 15000;
    } else {
        $narx = 0;
    }

    bot('deleteMessage',[
        'chat_id'=>$ccid,
        'message_id'=>$cmid,
    ]);

    $botpul = file_get_contents("foydalanuvchi/hisob/$ccid.txt");
    $til = file_get_contents("foydalanuvchi/hisob/$ccid.til");
    $hisob = file_get_contents("foydalanuvchi/hisob/$ccid.txt");
    $yetmadi = $narx - $botpul;

    // ===== PUL YETMASA =====
    if($botpul < $narx){
        if($til=="uz"){
            bot('sendMessage',[
                'chat_id'=>$ccid,
                'text'=>"‼️ <b>Hisobingizda mablag‘ yetarli emas!</b>

🪫 Balans: $hisob so'm
💰 Bot narxi: $narx so'm
❌ Yetishmaydi: $yetmadi so'm",
                'parse_mode'=>'html',
                'reply_markup'=>json_encode([
                    'inline_keyboard'=>[
                        [['text'=>"💶 Pul kiritish",'callback_data'=>"oplata"]],
                    ]
                ])
            ]);
        }elseif($til=="ru"){
            bot('sendMessage',[
                'chat_id'=>$ccid,
                'text'=>"<b>❌ Недостаточно средств!</b>

Баланс: $hisob сум  
Цена бота: $narx сум  
Не хватает: $yetmadi сум",
                'parse_mode'=>'html',
                'reply_markup'=>json_encode([
                    'inline_keyboard'=>[
                        [['text'=>"💳 Пополнить",'callback_data'=>"oplata"]],
                    ]
                ])
            ]);
        }
    } 
    // ===== PUL YETSA =====
    else {
        if($til=="uz"){
            bot('sendMessage',[
                'chat_id'=>$ccid,
                'text'=>"🔑 @BotFather bergan tokenni yuboring:",
                'parse_mode'=>"html",
                'reply_markup'=>json_encode([
                    'resize_keyboard'=>true,
                    'keyboard'=>[
                        [['text'=>"◀️ Orqaga"]],
                    ]
                ])
            ]);
        }elseif($til=="ru"){
            bot('sendMessage',[
                'chat_id'=>$ccid,
                'text'=>"<b>🔑 Отправьте токен от @BotFather:</b>",
                'parse_mode'=>"html",
                'reply_markup'=>json_encode([
                    'resize_keyboard'=>true,
                    'keyboard'=>[
                        [['text'=>"◀️ Назад"]],
                    ]
                ])
            ]);
        }

        file_put_contents("step/$ccid.txt","createmaker=$turi");
    }
}

if($data=="SavdovaBiznesbotlar"){
    bot('deleteMessage',[
        'chat_id'=>$ccid,
        'message_id'=>$cmid,
    ]);

    // ===== BOTLAR SONINI ANIQLASH =====
    $bots_file = "foydalanuvchi/$ccid/bots.txt";

    if(file_exists($bots_file)){
        $bots = array_filter(explode("\n", trim(file_get_contents($bots_file))));
        $bot_soni = count($bots);
    } else {
        $bot_soni = 0;
    }

    // ===== NARXNI BELGILASH =====
    if($bot_soni >= 2){
        $narx = "20000";
    } else {
        $narx = "0";
    }

    $hisob = file_get_contents("foydalanuvchi/hisob/$ccid.txt");

    if($til=="uz"){
        bot('sendMessage',[
            'chat_id'=>$ccid,
            'text'=>"<b>📋 Ushbu bo‘limda mavjud botlar ro‘yxati:</b>",
            'parse_mode'=>"html",
            'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [['text'=>"🛍 Mahsulot bot 🔒",'callback_data'=>"tezdauz"]],
                    [['text'=>"⭐️ Stars sotuvchi Bot 🔒",'callback_data'=>"tezdauz"]],
                    [['text'=>"📞 Nomer bot [SPIDER-TG API] 🔒",'callback_data'=>"tezdauz"]],
                    [['text'=>"🗳 Open Budget",'callback_data'=>"OpenBudgetBot"]],
                    [['text'=>"⬅️ Ortga qaytish",'callback_data'=>"yangibot"]],
                ]
            ])
        ]);
    }
}

if($data=="OpenBudgetBot"){
    bot('deleteMessage',[
        'chat_id'=>$ccid,
        'message_id'=>$cmid,
    ]);

    // ===== BOTLAR SONINI ANIQLASH =====
    $bots_file = "foydalanuvchi/$ccid/bots.txt";

    if(file_exists($bots_file)){
        $bots = array_filter(explode("\n", trim(file_get_contents($bots_file))));
        $bot_soni = count($bots);
    } else {
        $bot_soni = 0;
    }

    // ===== NARXNI BELGILASH =====
    if($bot_soni >= 1){
        $narx = "15000";
    } else {
        $narx = "0";
    }

    $hisob = file_get_contents("foydalanuvchi/hisob/$ccid.txt");

    if($til=="uz"){
        bot('sendMessage',[
            'chat_id'=>$ccid,
            'text'=>"🤖 – « 🗳 Open Budget »

⚙️ <b>Versiya:</b> 0.0.3 v
🖲 <b>Dastur:</b> php8.4

💵 <b>Narxi:</b> $narx so'm
📆 <b>To'lov:</b> 15000 so'm (500 so'm/kun)


<blockquote>
⚙️Muhum sozlamalar:
• Kiritilmagan</blockquote>

🎁 <i>Botning 5 kunlik to'lovi bepul taqdim etiladi!</i>",
            'parse_mode'=>"html",
            'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [['text'=>"🚀 Botni yaratish",'callback_data'=>"createo=OpenBudget"]],
                    [['text'=>"⬅️ Ortga qaytish",'callback_data'=>"SavdovaBiznesbotlar"]],
                ]
            ])
        ]);
    }
}

if(mb_stripos($data, "createo=")!==false){
    $ex = explode("=",$data);
    $turi = $ex[1];

    // ===== BOTLAR SONINI ANIQLASH =====
    $bots_file = "foydalanuvchi/$ccid/bots.txt";

    if(file_exists($bots_file)){
        $bots = array_filter(explode("\n", trim(file_get_contents($bots_file))));
        $bot_soni = count($bots);
    } else {
        $bot_soni = 0;
    }

    // ===== NARXNI AVTOMATIK BELGILASH =====
    if($bot_soni >= 1){
        $narx = 15000;
    } else {
        $narx = 0;
    }

    bot('deleteMessage',[
        'chat_id'=>$ccid,
        'message_id'=>$cmid,
    ]);

    $botpul = file_get_contents("foydalanuvchi/hisob/$ccid.txt");
    $til = file_get_contents("foydalanuvchi/hisob/$ccid.til");
    $hisob = file_get_contents("foydalanuvchi/hisob/$ccid.txt");
    $yetmadi = $narx - $botpul;

    // ===== PUL YETMASA =====
    if($botpul < $narx){
        if($til=="uz"){
            bot('sendMessage',[
                'chat_id'=>$ccid,
                'text'=>"‼️ <b>Hisobingizda mablag‘ yetarli emas!</b>

🪫 Balans: $hisob so'm
💰 Bot narxi: $narx so'm
❌ Yetishmaydi: $yetmadi so'm",
                'parse_mode'=>'html',
                'reply_markup'=>json_encode([
                    'inline_keyboard'=>[
                        [['text'=>"💶 Pul kiritish",'callback_data'=>"oplata"]],
                    ]
                ])
            ]);
        }elseif($til=="ru"){
            bot('sendMessage',[
                'chat_id'=>$ccid,
                'text'=>"<b>❌ Недостаточно средств!</b>

Баланс: $hisob сум  
Цена бота: $narx сум  
Не хватает: $yetmadi сум",
                'parse_mode'=>'html',
                'reply_markup'=>json_encode([
                    'inline_keyboard'=>[
                        [['text'=>"💳 Пополнить",'callback_data'=>"oplata"]],
                    ]
                ])
            ]);
        }
    } 
    // ===== PUL YETSA =====
    else {
        if($til=="uz"){
            bot('sendMessage',[
                'chat_id'=>$ccid,
                'text'=>"🔑 @BotFather bergan tokenni yuboring:",
                'parse_mode'=>"html",
                'reply_markup'=>json_encode([
                    'resize_keyboard'=>true,
                    'keyboard'=>[
                        [['text'=>"◀️ Orqaga"]],
                    ]
                ])
            ]);
        }elseif($til=="ru"){
            bot('sendMessage',[
                'chat_id'=>$ccid,
                'text'=>"<b>🔑 Отправьте токен от @BotFather:</b>",
                'parse_mode'=>"html",
                'reply_markup'=>json_encode([
                    'resize_keyboard'=>true,
                    'keyboard'=>[
                        [['text'=>"◀️ Назад"]],
                    ]
                ])
            ]);
        }

        file_put_contents("step/$ccid.txt","createmaker=$turi");
    }
}

if($data=="Makerbotlar"){
    bot('deleteMessage',[
        'chat_id'=>$ccid,
        'message_id'=>$cmid,
    ]);

    // ===== BOTLAR SONINI ANIQLASH =====
    $bots_file = "foydalanuvchi/$ccid/bots.txt";

    if(file_exists($bots_file)){
        $bots = array_filter(explode("\n", trim(file_get_contents($bots_file))));
        $bot_soni = count($bots);
    } else {
        $bot_soni = 0;
    }

    // ===== NARXNI BELGILASH =====
    if($bot_soni >= 2){
        $narx = "25000";
    } else {
        $narx = "0";
    }

    $hisob = file_get_contents("foydalanuvchi/hisob/$ccid.txt");

    if($til=="uz"){
        bot('sendMessage',[
            'chat_id'=>$ccid,
            'text'=>"<b>📋 Ushbu bo‘limda mavjud botlar ro‘yxati:</b>",
            'parse_mode'=>"html",
            'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [['text'=>"🤖 Maker bot - $narx so'm",'callback_data'=>"MakerBot"]],
                    [['text'=>"⬅️ Ortga qaytish",'callback_data'=>"yangibot"]],
                ]
            ])
        ]);
    }
}

if($data=="MakerBot"){
    bot('deleteMessage',[
        'chat_id'=>$ccid,
        'message_id'=>$cmid,
    ]);

    // ===== BOTLAR SONINI ANIQLASH =====
    $bots_file = "foydalanuvchi/$ccid/bots.txt";

    if(file_exists($bots_file)){
        $bots = array_filter(explode("\n", trim(file_get_contents($bots_file))));
        $bot_soni = count($bots);
    } else {
        $bot_soni = 0;
    }

    // ===== NARXNI BELGILASH =====
    if($bot_soni >= 2){
        $narx = "25000";
    } else {
        $narx = "0";
    }

    $hisob = file_get_contents("foydalanuvchi/hisob/$ccid.txt");

    if($til=="uz"){
        bot('sendMessage',[
            'chat_id'=>$ccid,
            'text'=>"🤖 – « 🤖 Maker bot »

⚙️ <b>Versiya:</b> 0.0.3 v
🖲 <b>Dastur:</b> php8.4

💵 <b>Narxi:</b> $narx so'm
📆 <b>To'lov:</b> 18000 so'm (600 so'm/kun)


<blockquote>
⚙️Muhum sozlamalar:
• Botlarni sozlash:
  - Kategoriya qo'shish,
  - Bot qo'shish,
  - Narx belgilash,
  - Kunlik/Oylik to'lovni belgilash,
  - Tavsif kiritish,
  - 10 xil turdagi botlar tayyor qo'shilgan narxlarni belgilasangiz bo'ldi,
• Xabar yuborish:
  - Forward,
  - Userga,
  - Oddiy,
• Kanal sozlash:
  - Majburiy obuna(Faqat ommaviy),
  - Promokod kanal
• Statistika:
  - Jami obunachilar
  - Faol obunachilar tark etganlar
• Bot holati:
  - Yoqish/O'chirish
• To'lov tizimlarini kiritish;
• Promokod tizimi;</blockquote>

🎁 <i>Botning 5 kunlik to'lovi bepul taqdim etiladi!</i>",
            'parse_mode'=>"html",
            'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [['text'=>"🚀 Botni yaratish",'callback_data'=>"createm=MakerBot"]],
                    [['text'=>"⬅️ Ortga qaytish",'callback_data'=>"Makerbotlar"]],
                ]
            ])
        ]);
    }
}

if(mb_stripos($data, "createm=")!==false){
    $ex = explode("=",$data);
    $turi = $ex[1];

    // ===== BOTLAR SONINI ANIQLASH =====
    $bots_file = "foydalanuvchi/$ccid/bots.txt";

    if(file_exists($bots_file)){
        $bots = array_filter(explode("\n", trim(file_get_contents($bots_file))));
        $bot_soni = count($bots);
    } else {
        $bot_soni = 0;
    }

    // ===== NARXNI AVTOMATIK BELGILASH =====
    if($bot_soni >= 2){
        $narx = 25000;
    } else {
        $narx = 0;
    }

    bot('deleteMessage',[
        'chat_id'=>$ccid,
        'message_id'=>$cmid,
    ]);

    $botpul = file_get_contents("foydalanuvchi/hisob/$ccid.txt");
    $til = file_get_contents("foydalanuvchi/hisob/$ccid.til");
    $hisob = file_get_contents("foydalanuvchi/hisob/$ccid.txt");
    $yetmadi = $narx - $botpul;

    // ===== PUL YETMASA =====
    if($botpul < $narx){
        if($til=="uz"){
            bot('sendMessage',[
                'chat_id'=>$ccid,
                'text'=>"‼️ <b>Hisobingizda mablag‘ yetarli emas!</b>

🪫 Balans: $hisob so'm
💰 Bot narxi: $narx so'm
❌ Yetishmaydi: $yetmadi so'm",
                'parse_mode'=>'html',
                'reply_markup'=>json_encode([
                    'inline_keyboard'=>[
                        [['text'=>"💶 Pul kiritish",'callback_data'=>"oplata"]],
                    ]
                ])
            ]);
        }elseif($til=="ru"){
            bot('sendMessage',[
                'chat_id'=>$ccid,
                'text'=>"<b>❌ Недостаточно средств!</b>

Баланс: $hisob сум  
Цена бота: $narx сум  
Не хватает: $yetmadi сум",
                'parse_mode'=>'html',
                'reply_markup'=>json_encode([
                    'inline_keyboard'=>[
                        [['text'=>"💳 Пополнить",'callback_data'=>"oplata"]],
                    ]
                ])
            ]);
        }
    } 
    // ===== PUL YETSA =====
    else {
        if($til=="uz"){
            bot('sendMessage',[
                'chat_id'=>$ccid,
                'text'=>"🔑 @BotFather bergan tokenni yuboring:",
                'parse_mode'=>"html",
                'reply_markup'=>json_encode([
                    'resize_keyboard'=>true,
                    'keyboard'=>[
                        [['text'=>"◀️ Orqaga"]],
                    ]
                ])
            ]);
        }elseif($til=="ru"){
            bot('sendMessage',[
                'chat_id'=>$ccid,
                'text'=>"<b>🔑 Отправьте токен от @BotFather:</b>",
                'parse_mode'=>"html",
                'reply_markup'=>json_encode([
                    'resize_keyboard'=>true,
                    'keyboard'=>[
                        [['text'=>"◀️ Назад"]],
                    ]
                ])
            ]);
        }

        file_put_contents("step/$ccid.txt","createmaker=$turi");
    }
}

if($data=="Moliyaviybotlar"){
    bot('deleteMessage',[
        'chat_id'=>$ccid,
        'message_id'=>$cmid,
    ]);

    // ===== BOTLAR SONINI ANIQLASH =====
    $bots_file = "foydalanuvchi/$ccid/bots.txt";

    if(file_exists($bots_file)){
        $bots = array_filter(explode("\n", trim(file_get_contents($bots_file))));
        $bot_soni = count($bots);
    } else {
        $bot_soni = 0;
    }

    // ===== NARXNI BELGILASH =====
    if($bot_soni >= 2){
        $narx = "15000";
    } else {
        $narx = "0";
    }

    $hisob = file_get_contents("foydalanuvchi/hisob/$ccid.txt");

    if($til=="uz"){
        bot('sendMessage',[
            'chat_id'=>$ccid,
            'text'=>"<b>📋 Ushbu bo‘limda mavjud botlar ro‘yxati:</b>",
            'parse_mode'=>"html",
            'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [['text'=>"⭐️ Stars ishlovchi bot - $narx so'm",'callback_data'=>"Starsishlovchibot"]],
                    [['text'=>"💎 Almaz ishlovchi bot - $narx so'm",'callback_data'=>"Almazishlovchibot"]],
                    [['text'=>"⬅️ Ortga qaytish",'callback_data'=>"yangibot"]],
                ]
            ])
        ]);
    }
}

if($data=="Almazishlovchibot"){
    bot('deleteMessage',[
        'chat_id'=>$ccid,
        'message_id'=>$cmid,
    ]);

    // ===== BOTLAR SONINI ANIQLASH =====
    $bots_file = "foydalanuvchi/$ccid/bots.txt";

    if(file_exists($bots_file)){
        $bots = array_filter(explode("\n", trim(file_get_contents($bots_file))));
        $bot_soni = count($bots);
    } else {
        $bot_soni = 0;
    }

    // ===== NARXNI BELGILASH =====
    if($bot_soni >= 2){
        $narx = "15000";
    } else {
        $narx = "0";
    }

    $hisob = file_get_contents("foydalanuvchi/hisob/$ccid.txt");

    if($til=="uz"){
        bot('sendMessage',[
            'chat_id'=>$ccid,
            'text'=>"🤖 – « 💎 Almaz ishlovchi bot »

⚙️ <b>Versiya:</b> 0.0.1 v
🖲 <b>Dastur:</b> php8.4

💵 <b>Narxi:</b> $narx so'm
📆 <b>To'lov:</b> 15000 so'm (500 so'm/kun)


<blockquote>⚙️Muhum sozlamalar:
• Referal chaqirish orqali almaz ishlash;
• Majburiy obunalar ulash;
• Xabar yuborish;
• To'lov tizimlari qo'shish;
• Foydalanuvchialrni boshqarish;
• O'yinlar o'ynab almaz ishlash;
  - Kosti
  - Merganchi
  - Bowling
  - Basketbal
• Va boshqa sozlamalar</blockquote>

🎁 <i>Botning 5 kunlik to'lovi bepul taqdim etiladi!</i>",
            'parse_mode'=>"html",
            'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [['text'=>"🚀 Botni yaratish",'callback_data'=>"createa=AlmazBot"]],
                    [['text'=>"⬅️ Ortga qaytish",'callback_data'=>"Moliyaviybotlar"]],
                ]
            ])
        ]);
    }
}

if(mb_stripos($data, "createa=")!==false){
    $ex = explode("=",$data);
    $turi = $ex[1];

    // ===== BOTLAR SONINI ANIQLASH =====
    $bots_file = "foydalanuvchi/$ccid/bots.txt";

    if(file_exists($bots_file)){
        $bots = array_filter(explode("\n", trim(file_get_contents($bots_file))));
        $bot_soni = count($bots);
    } else {
        $bot_soni = 0;
    }

    // ===== NARXNI AVTOMATIK BELGILASH =====
    if($bot_soni >= 2){
        $narx = 15000;
    } else {
        $narx = 0;
    }

    bot('deleteMessage',[
        'chat_id'=>$ccid,
        'message_id'=>$cmid,
    ]);

    $botpul = file_get_contents("foydalanuvchi/hisob/$ccid.txt");
    $til = file_get_contents("foydalanuvchi/hisob/$ccid.til");
    $hisob = file_get_contents("foydalanuvchi/hisob/$ccid.txt");
    $yetmadi = $narx - $botpul;

    // ===== PUL YETMASA =====
    if($botpul < $narx){
        if($til=="uz"){
            bot('sendMessage',[
                'chat_id'=>$ccid,
                'text'=>"‼️ <b>Hisobingizda mablag‘ yetarli emas!</b>

🪫 Balans: $hisob so'm
💰 Bot narxi: $narx so'm
❌ Yetishmaydi: $yetmadi so'm",
                'parse_mode'=>'html',
                'reply_markup'=>json_encode([
                    'inline_keyboard'=>[
                        [['text'=>"💶 Pul kiritish",'callback_data'=>"oplata"]],
                    ]
                ])
            ]);
        }elseif($til=="ru"){
            bot('sendMessage',[
                'chat_id'=>$ccid,
                'text'=>"<b>❌ Недостаточно средств!</b>

Баланс: $hisob сум  
Цена бота: $narx сум  
Не хватает: $yetmadi сум",
                'parse_mode'=>'html',
                'reply_markup'=>json_encode([
                    'inline_keyboard'=>[
                        [['text'=>"💳 Пополнить",'callback_data'=>"oplata"]],
                    ]
                ])
            ]);
        }
    } 
    // ===== PUL YETSA =====
    else {
        if($til=="uz"){
            bot('sendMessage',[
                'chat_id'=>$ccid,
                'text'=>"🔑 @BotFather bergan tokenni yuboring:",
                'parse_mode'=>"html",
                'reply_markup'=>json_encode([
                    'resize_keyboard'=>true,
                    'keyboard'=>[
                        [['text'=>"◀️ Orqaga"]],
                    ]
                ])
            ]);
        }elseif($til=="ru"){
            bot('sendMessage',[
                'chat_id'=>$ccid,
                'text'=>"<b>🔑 Отправьте токен от @BotFather:</b>",
                'parse_mode'=>"html",
                'reply_markup'=>json_encode([
                    'resize_keyboard'=>true,
                    'keyboard'=>[
                        [['text'=>"◀️ Назад"]],
                    ]
                ])
            ]);
        }

        file_put_contents("step/$ccid.txt","createmaker=$turi");
    }
}

if($data=="Starsishlovchibot"){
    bot('deleteMessage',[
        'chat_id'=>$ccid,
        'message_id'=>$cmid,
    ]);

    // ===== BOTLAR SONINI ANIQLASH =====
    $bots_file = "foydalanuvchi/$ccid/bots.txt";

    if(file_exists($bots_file)){
        $bots = array_filter(explode("\n", trim(file_get_contents($bots_file))));
        $bot_soni = count($bots);
    } else {
        $bot_soni = 0;
    }

    // ===== NARXNI BELGILASH =====
    if($bot_soni >= 2){
        $narx = "15000";
    } else {
        $narx = "0";
    }

    $hisob = file_get_contents("foydalanuvchi/hisob/$ccid.txt");

    if($til=="uz"){
        bot('sendMessage',[
            'chat_id'=>$ccid,
            'text'=>"🤖 – « ⭐️ Stars ishlovchi bot »

⚙️ <b>Versiya:</b> 0.0.1 v
🖲 <b>Dastur:</b> php8.4

💵 <b>Narxi:</b> $narx so'm
📆 <b>To'lov:</b> 15000 so'm (500 so'm/kun)


<blockquote>⚙️Muhum sozlamalar:
• Referal chaqirish orqali stars ishlash;
• Majburiy obunalar ulash;
• Xabar yuborish;
• To'lov tizimlari qo'shish;
• Foydalanuvchialrni boshqarish;
• Va boshqa sozlamalar</blockquote>

🎁 <i>Botning 5 kunlik to'lovi bepul taqdim etiladi!</i>",
            'parse_mode'=>"html",
            'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [['text'=>"🚀 Botni yaratish",'callback_data'=>"createi=Starsishlovchibot"]],
                    [['text'=>"⬅️ Ortga qaytish",'callback_data'=>"Moliyaviybotlar"]],
                ]
            ])
        ]);
    }
}

if(mb_stripos($data, "createi=")!==false){
    $ex = explode("=",$data);
    $turi = $ex[1];

    // ===== BOTLAR SONINI ANIQLASH =====
    $bots_file = "foydalanuvchi/$ccid/bots.txt";

    if(file_exists($bots_file)){
        $bots = array_filter(explode("\n", trim(file_get_contents($bots_file))));
        $bot_soni = count($bots);
    } else {
        $bot_soni = 0;
    }

    // ===== NARXNI AVTOMATIK BELGILASH =====
    if($bot_soni >= 2){
        $narx = 15000;
    } else {
        $narx = 0;
    }

    bot('deleteMessage',[
        'chat_id'=>$ccid,
        'message_id'=>$cmid,
    ]);

    $botpul = file_get_contents("foydalanuvchi/hisob/$ccid.txt");
    $til = file_get_contents("foydalanuvchi/hisob/$ccid.til");
    $hisob = file_get_contents("foydalanuvchi/hisob/$ccid.txt");
    $yetmadi = $narx - $botpul;

    // ===== PUL YETMASA =====
    if($botpul < $narx){
        if($til=="uz"){
            bot('sendMessage',[
                'chat_id'=>$ccid,
                'text'=>"‼️ <b>Hisobingizda mablag‘ yetarli emas!</b>

🪫 Balans: $hisob so'm
💰 Bot narxi: $narx so'm
❌ Yetishmaydi: $yetmadi so'm",
                'parse_mode'=>'html',
                'reply_markup'=>json_encode([
                    'inline_keyboard'=>[
                        [['text'=>"💶 Pul kiritish",'callback_data'=>"oplata"]],
                    ]
                ])
            ]);
        }elseif($til=="ru"){
            bot('sendMessage',[
                'chat_id'=>$ccid,
                'text'=>"<b>❌ Недостаточно средств!</b>

Баланс: $hisob сум  
Цена бота: $narx сум  
Не хватает: $yetmadi сум",
                'parse_mode'=>'html',
                'reply_markup'=>json_encode([
                    'inline_keyboard'=>[
                        [['text'=>"💳 Пополнить",'callback_data'=>"oplata"]],
                    ]
                ])
            ]);
        }
    } 
    // ===== PUL YETSA =====
    else {
        if($til=="uz"){
            bot('sendMessage',[
                'chat_id'=>$ccid,
                'text'=>"🔑 @BotFather bergan tokenni yuboring:",
                'parse_mode'=>"html",
                'reply_markup'=>json_encode([
                    'resize_keyboard'=>true,
                    'keyboard'=>[
                        [['text'=>"◀️ Orqaga"]],
                    ]
                ])
            ]);
        }elseif($til=="ru"){
            bot('sendMessage',[
                'chat_id'=>$ccid,
                'text'=>"<b>🔑 Отправьте токен от @BotFather:</b>",
                'parse_mode'=>"html",
                'reply_markup'=>json_encode([
                    'resize_keyboard'=>true,
                    'keyboard'=>[
                        [['text'=>"◀️ Назад"]],
                    ]
                ])
            ]);
        }

        file_put_contents("step/$ccid.txt","createmaker=$turi");
    }
}

if($data=="SMMbotlar"){
    bot('deleteMessage',[
        'chat_id'=>$ccid,
        'message_id'=>$cmid,
    ]);

    // ===== BOTLAR SONINI ANIQLASH =====
    $bots_file = "foydalanuvchi/$ccid/bots.txt";

    if(file_exists($bots_file)){
        $bots = array_filter(explode("\n", trim(file_get_contents($bots_file))));
        $bot_soni = count($bots);
    } else {
        $bot_soni = 0;
    }

    // ===== NARXNI BELGILASH =====
    if($bot_soni >= 2){
        $narx = "15000";
    } else {
        $narx = "0";
    }

    $hisob = file_get_contents("foydalanuvchi/hisob/$ccid.txt");

    if($til=="uz"){
        bot('sendMessage',[
            'chat_id'=>$ccid,
            'text'=>"<b>📋 Ushbu bo‘limda mavjud botlar ro‘yxati:</b>",
            'parse_mode'=>"html",
            'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [['text'=>"🚀 Nakrutka bot - $narx so'm",'callback_data'=>"NakrutkaBot"]],
                    [['text'=>"⬅️ Ortga qaytish",'callback_data'=>"yangibot"]],
                ]
            ])
        ]);
    }
}

if($data=="NakrutkaBot"){
    bot('deleteMessage',[
        'chat_id'=>$ccid,
        'message_id'=>$cmid,
    ]);

    // ===== BOTLAR SONINI ANIQLASH =====
    $bots_file = "foydalanuvchi/$ccid/bots.txt";

    if(file_exists($bots_file)){
        $bots = array_filter(explode("\n", trim(file_get_contents($bots_file))));
        $bot_soni = count($bots);
    } else {
        $bot_soni = 0;
    }

    // ===== NARXNI BELGILASH =====
    if($bot_soni >= 2){
        $narx = "15000";
    } else {
        $narx = "0";
    }

    $hisob = file_get_contents("foydalanuvchi/hisob/$ccid.txt");

    if($til=="uz"){
        bot('sendMessage',[
            'chat_id'=>$ccid,
            'text'=>"🤖 – « 🚀 Nakrutka bot »

⚙️ <b>Versiya:</b> 0.0.1 v
🖲 <b>Dastur:</b> php8.4

💵 <b>Narxi:</b> $narx so'm
📆 <b>To'lov:</b> 15000 so'm (500 so'm/kun)


<blockquote>⚙️Muhum sozlamalar:
• Foydalanuvchini boshqarish;
• Statistika;
• Xabar yuborish:
  - Forward,
  - Oddiy,
• Xizmatlarni sozlash;
• API ulash(1 dona)
• Majburiy obuna:
  - Kanal ulash, o'chirish, ro'yhati,
• To'lov tizimlarini sozlash;
• Admin qo'shish funksiyalari:
  - Admin qo'shish
  - Admin o'chirish
  - Adminlar ro'yhati
• Tugmalarni sozlash funksiyalari:
  - Tugmalarni nomini o'zgartirish
  - Tugmalarni o'z holatiga qaytarish
• Bot holati funksiyalari:
  - Botni o'chirib qo'yish (ya'ni texnik ishlar yoki muammo bosa kerak)
  - Botni yoqish
• Va boshqa sozlamalar</blockquote>

🎁 <i>Botning 5 kunlik to'lovi bepul taqdim etiladi!</i>",
            'parse_mode'=>"html",
            'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [['text'=>"🚀 Botni yaratish",'callback_data'=>"createn=NakrutkaBot"]],
                    [['text'=>"⬅️ Ortga qaytish",'callback_data'=>"SMMbotlar"]],
                ]
            ])
        ]);
    }
}

if(mb_stripos($data, "createn=")!==false){
    $ex = explode("=",$data);
    $turi = $ex[1];

    // ===== BOTLAR SONINI ANIQLASH =====
    $bots_file = "foydalanuvchi/$ccid/bots.txt";

    if(file_exists($bots_file)){
        $bots = array_filter(explode("\n", trim(file_get_contents($bots_file))));
        $bot_soni = count($bots);
    } else {
        $bot_soni = 0;
    }

    // ===== NARXNI AVTOMATIK BELGILASH =====
    if($bot_soni >= 2){
        $narx = 15000;
    } else {
        $narx = 0;
    }

    bot('deleteMessage',[
        'chat_id'=>$ccid,
        'message_id'=>$cmid,
    ]);

    $botpul = file_get_contents("foydalanuvchi/hisob/$ccid.txt");
    $til = file_get_contents("foydalanuvchi/hisob/$ccid.til");
    $hisob = file_get_contents("foydalanuvchi/hisob/$ccid.txt");
    $yetmadi = $narx - $botpul;

    // ===== PUL YETMASA =====
    if($botpul < $narx){
        if($til=="uz"){
            bot('sendMessage',[
                'chat_id'=>$ccid,
                'text'=>"‼️ <b>Hisobingizda mablag‘ yetarli emas!</b>

🪫 Balans: $hisob so'm
💰 Bot narxi: $narx so'm
❌ Yetishmaydi: $yetmadi so'm",
                'parse_mode'=>'html',
                'reply_markup'=>json_encode([
                    'inline_keyboard'=>[
                        [['text'=>"💶 Pul kiritish",'callback_data'=>"oplata"]],
                    ]
                ])
            ]);
        }elseif($til=="ru"){
            bot('sendMessage',[
                'chat_id'=>$ccid,
                'text'=>"<b>❌ Недостаточно средств!</b>

Баланс: $hisob сум  
Цена бота: $narx сум  
Не хватает: $yetmadi сум",
                'parse_mode'=>'html',
                'reply_markup'=>json_encode([
                    'inline_keyboard'=>[
                        [['text'=>"💳 Пополнить",'callback_data'=>"oplata"]],
                    ]
                ])
            ]);
        }
    } 
    // ===== PUL YETSA =====
    else {
        if($til=="uz"){
            bot('sendMessage',[
                'chat_id'=>$ccid,
                'text'=>"🔑 @BotFather bergan tokenni yuboring:",
                'parse_mode'=>"html",
                'reply_markup'=>json_encode([
                    'resize_keyboard'=>true,
                    'keyboard'=>[
                        [['text'=>"◀️ Orqaga"]],
                    ]
                ])
            ]);
        }elseif($til=="ru"){
            bot('sendMessage',[
                'chat_id'=>$ccid,
                'text'=>"<b>🔑 Отправьте токен от @BotFather:</b>",
                'parse_mode'=>"html",
                'reply_markup'=>json_encode([
                    'resize_keyboard'=>true,
                    'keyboard'=>[
                        [['text'=>"◀️ Назад"]],
                    ]
                ])
            ]);
        }

        file_put_contents("step/$ccid.txt","createmaker=$turi");
    }
}

if($data=="Mediabotlar"){
    bot('deleteMessage',[
        'chat_id'=>$ccid,
        'message_id'=>$cmid,
    ]);

    // ===== BOTLAR SONINI ANIQLASH =====
    $bots_file = "foydalanuvchi/$ccid/bots.txt";

    if(file_exists($bots_file)){
        $bots = array_filter(explode("\n", trim(file_get_contents($bots_file))));
        $bot_soni = count($bots);
    } else {
        $bot_soni = 0;
    }

    // ===== NARXNI BELGILASH =====
    if($bot_soni >= 2){
        $narx = "10000";
    } else {
        $narx = "0";
    }

    if($bot_soni >= 2){
        $narxa = "12000";
    } else {
        $narxa = "0";
    }

    $hisob = file_get_contents("foydalanuvchi/hisob/$ccid.txt");

    if($til=="uz"){
        bot('sendMessage',[
            'chat_id'=>$ccid,
            'text'=>"<b>📋 Ushbu bo‘limda mavjud botlar ro‘yxati:</b>",
            'parse_mode'=>"html",
            'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [['text'=>"🎬 KinoBot - $narx so'm",'callback_data'=>"KinoBot"]],
                    [['text'=>"🌌 AnimeBot - $narxa so'm",'callback_data'=>"AnimeBot"]],
                    [['text'=>"⬅️ Ortga qaytish",'callback_data'=>"yangibot"]],
                ]
            ])
        ]);
    }
}

if($data=="AnimeBot"){
    bot('deleteMessage',[
        'chat_id'=>$ccid,
        'message_id'=>$cmid,
    ]);

    // ===== BOTLAR SONINI ANIQLASH =====
    $bots_file = "foydalanuvchi/$ccid/bots.txt";

    if(file_exists($bots_file)){
        $bots = array_filter(explode("\n", trim(file_get_contents($bots_file))));
        $bot_soni = count($bots);
    } else {
        $bot_soni = 0;
    }

    // ===== NARXNI BELGILASH =====
    if($bot_soni >= 2){
        $narx = "12000";
    } else {
        $narx = "0";
    }

    $hisob = file_get_contents("foydalanuvchi/hisob/$ccid.txt");

    if($til=="uz"){
        bot('sendMessage',[
            'chat_id'=>$ccid,
            'text'=>"🤖 – « 🌌 AnimeBot »

⚙️ <b>Versiya:</b> 0.0.1 v
🖲️ <b>Dastur:</b> php8.4

💵 <b>Narxi:</b> $narx so'm
📆 <b>To'lov:</b> 18000 so'm (600 so'm/kun)


<blockquote>⚙️ Muhim sozlamalar:

• Animelar qo'shish | Qism qo‘shish;
• Anime taxrirlash | Anime o'chirish;
• Majburiy a'zo kanal qo'shish:
   - Ommaviy kanal, 
   - Shaxsiy kanal,
   - Zayafka kanal;
• Qo'shimcha link qo'shish;
• Ko'p qamrovli statistika;
• Xabar yuborish; 
• Adminlar qo'shish;
• Bot holati:
   - Botni ochirib yoqish;
</blockquote>

🎁 <i>Botning 5 kunlik to‘lovi bepul taqdim etiladi!</i>",
            'parse_mode'=>"html",
            'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [['text'=>"🚀 Botni yaratish ",'callback_data'=>"createan=AnimeBot"]],
                    [['text'=>"⬅️ Ortga qaytish",'callback_data'=>"Mediabotlar"]],
                ]
            ])
        ]);
    }
}

if(mb_stripos($data, "createan=")!==false){
    $ex = explode("=",$data);
    $turi = $ex[1];

    // ===== BOTLAR SONINI ANIQLASH =====
    $bots_file = "foydalanuvchi/$ccid/bots.txt";

    if(file_exists($bots_file)){
        $bots = array_filter(explode("\n", trim(file_get_contents($bots_file))));
        $bot_soni = count($bots);
    } else {
        $bot_soni = 0;
    }

    // ===== NARXNI AVTOMATIK BELGILASH =====
    if($bot_soni >= 2){
        $narx = 12000;
    } else {
        $narx = 0;
    }

    bot('deleteMessage',[
        'chat_id'=>$ccid,
        'message_id'=>$cmid,
    ]);

    $botpul = file_get_contents("foydalanuvchi/hisob/$ccid.txt");
    $til = file_get_contents("foydalanuvchi/hisob/$ccid.til");
    $hisob = file_get_contents("foydalanuvchi/hisob/$ccid.txt");
    $yetmadi = $narx - $botpul;

    // ===== PUL YETMASA =====
    if($botpul < $narx){
        if($til=="uz"){
            bot('sendMessage',[
                'chat_id'=>$ccid,
                'text'=>"‼️ <b>Hisobingizda mablag‘ yetarli emas!</b>

🪫 Balans: $hisob so'm
💰 Bot narxi: $narx so'm
❌ Yetishmaydi: $yetmadi so'm",
                'parse_mode'=>'html',
                'reply_markup'=>json_encode([
                    'inline_keyboard'=>[
                        [['text'=>"💶 Pul kiritish",'callback_data'=>"oplata"]],
                    ]
                ])
            ]);
        }elseif($til=="ru"){
            bot('sendMessage',[
                'chat_id'=>$ccid,
                'text'=>"<b>❌ Недостаточно средств!</b>

Баланс: $hisob сум  
Цена бота: $narx сум  
Не хватает: $yetmadi сум",
                'parse_mode'=>'html',
                'reply_markup'=>json_encode([
                    'inline_keyboard'=>[
                        [['text'=>"💳 Пополнить",'callback_data'=>"oplata"]],
                    ]
                ])
            ]);
        }
    } 
    // ===== PUL YETSA =====
    else {
        if($til=="uz"){
            bot('sendMessage',[
                'chat_id'=>$ccid,
                'text'=>"🔑 @BotFather bergan tokenni yuboring:",
                'parse_mode'=>"html",
                'reply_markup'=>json_encode([
                    'resize_keyboard'=>true,
                    'keyboard'=>[
                        [['text'=>"◀️ Orqaga"]],
                    ]
                ])
            ]);
        }elseif($til=="ru"){
            bot('sendMessage',[
                'chat_id'=>$ccid,
                'text'=>"<b>🔑 Отправьте токен от @BotFather:</b>",
                'parse_mode'=>"html",
                'reply_markup'=>json_encode([
                    'resize_keyboard'=>true,
                    'keyboard'=>[
                        [['text'=>"◀️ Назад"]],
                    ]
                ])
            ]);
        }

        file_put_contents("step/$ccid.txt","createmaker=$turi");
    }
}

if($data=="KinoBot"){
    bot('deleteMessage',[
        'chat_id'=>$ccid,
        'message_id'=>$cmid,
    ]);

    // ===== BOTLAR SONINI ANIQLASH =====
    $bots_file = "foydalanuvchi/$ccid/bots.txt";

    if(file_exists($bots_file)){
        $bots = array_filter(explode("\n", trim(file_get_contents($bots_file))));
        $bot_soni = count($bots);
    } else {
        $bot_soni = 0;
    }

    // ===== NARXNI BELGILASH =====
    if($bot_soni >= 2){
        $narx = "10000";
    } else {
        $narx = "0";
    }

    $hisob = file_get_contents("foydalanuvchi/hisob/$ccid.txt");

    if($til=="uz"){
        bot('sendMessage',[
            'chat_id'=>$ccid,
            'text'=>"🤖 – « 🎬 Kino bot »

⚙️ <b>Versiya:</b> 0.0.1 v
🖲️ <b>Dastur:</b> php8.4

💵 <b>Narxi:</b> $narx so'm
📆 <b>To'lov:</b> 18000 so'm (600 so'm/kun)


<blockquote>⚙️ Muhim sozlamalar:
• Filmlar qo'shish;
• Majburiy a'zo kanal qo'shish:
   - Ommaviy kanal,
   - Shaxsiy kanal,
   - Zayafka kanal;
• Qo'shimcha link qo'shish;
• Xabar yuborish tizimi;
• 💎 Premium sozlash bo'limi:
   - Karta ulash,
   - Foydalanuvchini premiumga qo'shish/ayirish;
• Ulashish | Yuklash sozlamalari:
   - Yuklab olishni yoqish/o'chirish,
   - Ulashishni yoqish/o'chirish;
• Admin qo'shish bo'limi:
   - Admin qo'shish/o'chirish/ro'yxati,
   - Adminga botni boshqarish huquqlari;
• Statistika ko‘rish:
   - Obunachilar soni,
   - Faol / Tark etganlar,
   - 24 soat / 7 kun / 30 kunlik o‘sish,
   - Yuklangan kinolar soni;
• Bot holati:
   - Botni yoqish/o‘chirish;
</blockquote>

🎁 <i>Botning 5 kunlik to‘lovi bepul taqdim etiladi!</i>",
            'parse_mode'=>"html",
            'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [['text'=>"🚀 Botni yaratish",'callback_data'=>"create=KinoBot"]],
                    [['text'=>"⬅️ Ortga qaytish",'callback_data'=>"Mediabotlar"]],
                ]
            ])
        ]);
    }
}

if(mb_stripos($data, "create=")!==false){
    $ex = explode("=",$data);
    $turi = $ex[1];

    // ===== BOTLAR SONINI ANIQLASH =====
    $bots_file = "foydalanuvchi/$ccid/bots.txt";

    if(file_exists($bots_file)){
        $bots = array_filter(explode("\n", trim(file_get_contents($bots_file))));
        $bot_soni = count($bots);
    } else {
        $bot_soni = 0;
    }

    // ===== NARXNI AVTOMATIK BELGILASH =====
    if($bot_soni >= 2){
        $narx = 10000;
    } else {
        $narx = 0;
    }

    bot('deleteMessage',[
        'chat_id'=>$ccid,
        'message_id'=>$cmid,
    ]);

    $botpul = file_get_contents("foydalanuvchi/hisob/$ccid.txt");
    $til = file_get_contents("foydalanuvchi/hisob/$ccid.til");
    $hisob = file_get_contents("foydalanuvchi/hisob/$ccid.txt");
    $yetmadi = $narx - $botpul;

    // ===== PUL YETMASA =====
    if($botpul < $narx){
        if($til=="uz"){
            bot('sendMessage',[
                'chat_id'=>$ccid,
                'text'=>"‼️ <b>Hisobingizda mablag‘ yetarli emas!</b>

🪫 Balans: $hisob so'm
💰 Bot narxi: $narx so'm
❌ Yetishmaydi: $yetmadi so'm",
                'parse_mode'=>'html',
                'reply_markup'=>json_encode([
                    'inline_keyboard'=>[
                        [['text'=>"💶 Pul kiritish",'callback_data'=>"oplata"]],
                    ]
                ])
            ]);
        }elseif($til=="ru"){
            bot('sendMessage',[
                'chat_id'=>$ccid,
                'text'=>"<b>❌ Недостаточно средств!</b>

Баланс: $hisob сум  
Цена бота: $narx сум  
Не хватает: $yetmadi сум",
                'parse_mode'=>'html',
                'reply_markup'=>json_encode([
                    'inline_keyboard'=>[
                        [['text'=>"💳 Пополнить",'callback_data'=>"oplata"]],
                    ]
                ])
            ]);
        }
    } 
    // ===== PUL YETSA =====
    else {
        if($til=="uz"){
            bot('sendMessage',[
                'chat_id'=>$ccid,
                'text'=>"🔑 @BotFather bergan tokenni yuboring:",
                'parse_mode'=>"html",
                'reply_markup'=>json_encode([
                    'resize_keyboard'=>true,
                    'keyboard'=>[
                        [['text'=>"◀️ Orqaga"]],
                    ]
                ])
            ]);
        }elseif($til=="ru"){
            bot('sendMessage',[
                'chat_id'=>$ccid,
                'text'=>"<b>🔑 Отправьте токен от @BotFather:</b>",
                'parse_mode'=>"html",
                'reply_markup'=>json_encode([
                    'resize_keyboard'=>true,
                    'keyboard'=>[
                        [['text'=>"◀️ Назад"]],
                    ]
                ])
            ]);
        }

        file_put_contents("step/$ccid.txt","createmaker=$turi");
    }
}

if(mb_stripos($userstep, "createmaker=")!==false){
$ex = explode("=",$userstep);
$turi = $ex[1];
$post=file_get_contents("step/$cid.post");
bot('deleteMessage',[
'chat_id'=>$cid,
'message_id'=>$post,
]);
if($tx=="◀️ Orqaga" or $tx=="◀️ Назад"){
unlink("step/$cid.txt");
}else{
if(mb_stripos($tx, ":")!==false){
bot('deleteMessage',[
'chat_id'=>$cid,
'message_id'=>$mid,
]);
if($til=="uz"){
$getid = bot('SendMessage',[
'chat_id'=>$cid,
'text'=>"<b>⚙ Yuklanmoqda...</b>",
'parse_mode'=>'html',
])->result->message_id;
}elseif($til=="ru"){
$getid = bot('SendMessage',[
'chat_id'=>$cid,
'text'=>"<b>⚙ Загрузка...</b>",
'parse_mode'=>'html',
])->result->message_id;
}
$botuser = json_decode(file_get_contents("https://api.telegram.org/bot$tx/getme"))->result->username;
$kod=file_get_contents("mini/$turi.php");
$kod = str_replace("API_TOKEN", "$tx", $kod);
$kod = str_replace("ADMIN_ID", "$fid", $kod);

mkdir("foydalanuvchi/$cid");
mkdir("foydalanuvchi/$cid/$botuser");
file_put_contents("foydalanuvchi/$cid/$botuser/$turi.php", $kod);

if($turi=="MakerBot"){
mkdir("foydalanuvchi/$cid/$botuser/botlar");
file_put_contents("foydalanuvchi/$cid/$botuser/botlar/SarmoyaBot.php",file_get_contents("botlar/SarmoyaBot.php"));
file_put_contents("foydalanuvchi/$cid/$botuser/botlar/ObunachiBot.php",file_get_contents("botlar/ObunachiBot.php"));
file_put_contents("foydalanuvchi/$cid/$botuser/botlar/SpecialSMM Lite.php",file_get_contents("botlar/SpecialSMM Lite.php"));
file_put_contents("foydalanuvchi/$cid/$botuser/botlar/PulBot Lite.php",file_get_contents("botlar/PulBot Lite.php"));
file_put_contents("foydalanuvchi/$cid/$botuser/botlar/TurfaBot.php",file_get_contents("botlar/TurfaBot.php"));
file_put_contents("foydalanuvchi/$cid/$botuser/botlar/AvtoNakrutka.php",file_get_contents("botlar/AvtoNakrutka.php"));
file_put_contents("foydalanuvchi/$cid/$botuser/botlar/Obunachi Lite.php",file_get_contents("botlar/Obunachi Lite.php"));
file_put_contents("foydalanuvchi/$cid/$botuser/botlar/Reklamachi.php",file_get_contents("botlar/Reklamachi.php"));
file_put_contents("foydalanuvchi/$cid/$botuser/botlar/SpecialMember.php",file_get_contents("botlar/SpecialMember.php"));
file_put_contents("foydalanuvchi/$cid/$botuser/botlar/Kinobot.php",file_get_contents("botlar/Kinobot.php"));
file_put_contents("foydalanuvchi/$cid/$botuser/botlar/userinfo.php",file_get_contents("botlar/userinfo.php"));
}

$get = json_decode(file_get_contents("https://api.telegram.org/bot$tx/setwebhook?url=https://".$_SERVER['SERVER_NAME']."/$xostfile/foydalanuvchi/$cid/$botuser/$turi.php"))->result;

if($get){
$botuser = json_decode(file_get_contents("https://api.telegram.org/bot$tx/getme"))->result->username;
$nomi = json_decode(file_get_contents("https://api.telegram.org/bot$tx/getme"))->result->first_name;
$id = json_decode(file_get_contents("https://api.telegram.org/bot$tx/getme"))->result->id;
$soat = date("H:i",strtotime("2 hour"));
$kun = date("d.m.y",strtotime("2 hour"));
mkdir("foydalanuvchi/$cid/$botuser/info");
file_put_contents("foydalanuvchi/$cid/$botuser/info/soat.txt","$soat");
file_put_contents("foydalanuvchi/$cid/$botuser/info/kunida.txt","$kun");
file_put_contents("foydalanuvchi/$cid/$botuser/info/token.txt","$tx");
file_put_contents("foydalanuvchi/$cid/$botuser/info/turi.txt","$turi");
file_put_contents("foydalanuvchi/$cid/bots.txt");
$bots=file_get_contents("foydalanuvchi/$cid/bots.txt");
file_put_contents("foydalanuvchi/$cid/bots.txt", "$bots\n$botuser");
date_default_timezone_set('Asia/Tashkent');
$t=date("d");
$d['sana']=$t;
$d['kun']=$bonuskun;
file_put_contents("foydalanuvchi/$cid/$botuser/kunlik.tolov",json_encode($d));
sleep(2);
bot('deleteMessage',[
'chat_id'=>$cid,
'message_id'=>$getid,
]);
$hisob = file_get_contents("foydalanuvchi/hisob/$cid.txt");
$minus = $hisob - $narx;
file_put_contents("foydalanuvchi/hisob/$cid.txt", $minus);
if($til=="uz"){
bot('sendMessage',[
'chat_id'=>$cid,
'message_id'=>$getid,
'text'=>"<b>✅ Botingiz serverga muvaffaqiyatli ulandi!</b>

<b>🤖 Bot nomi:</b> <u>$nomi</u>
<b>🔎 Bot useri:</b> @$botuser
<b>🔑 Bot tokeni:</b> <pre>$text</pre>

<b>🗓 Ochilgan vaqt:</b> $kun 
<b>⏳ To'lov holati:</b> $bonuskun kun

<b>⚠️ Bot yangiliklar kanalini kuzating!</b>",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"➡️ Botga o'tish",'url'=>"https://t.me/$botuser"]],
]])
]);
}elseif($til=="ru"){
bot('sendMessage',[
'chat_id'=>$cid,
'message_id'=>$getid,
'text'=>"<b> ✅ Ваш бот успешно подключился к серверу!</b>

<b>🤖 Имя бота:</b> <u>$nomi</u>
<b>🔎 Пользователь бота:</b> @$botuser
<b>🔑 Токен бота:</b> <pre>$text</pre>

<b>🗓 Время работы:</b> $kun
<b>⏳ Статус платежа:</b> $bonuskun дней

<b>⚠️ Следите за новостной лентой бота!</b>",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"🌐 Новости ботов",'url'=>"https://t.me/CreateMaker"]],
[['text'=>"➡️ Переключиться на бота",'url'=>"https://t.me/$botuser"]],
]])
]);
}}
unlink("step/$cid.txt");
}else{
if($til=="uz"){
bot('sendMessage',[
'chat_id'=>$cid,
'text'=>"<b>⛔️ Kechirasiz token qabul qilinmadi!</b>

Qayta yuboring:",
'parse_mode'=>"html",
]);
}elseif($til=="ru"){
bot('sendMessage',[
'chat_id'=>$cid,
'text'=>"<b>⛔️ К сожалению, токен не принят!</b>

Отправить:",
'parse_mode'=>"html",
]);
}}}}

if($text=="/qollanma" and joinchat($fid)=="true"){
if($til=="uz"){
bot('sendMessage',[
'chat_id'=>$cid,
'text'=>"<b>📋 Botdagi muhim ma'lumotlar:</b>

<b>❗️SAVOL - Botga qanday qilib to'lov qilsam bo'ladi?
✅ JAVOB </b>- Botga ( /tolov ) buyrug'ini yuboring va to'lov qilib chekni adminga yuboring!",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"🎞 YouTube video",'url'=>"https://youtu.be/AeRNQf3-yuE"]],
]])
]);
}elseif($til=="ru"){
bot('sendMessage',[
'chat_id'=>$cid,
'text'=>"<b>📋 Важная информация о боте:</b>

<b>❗️ВОПРОС - Как оплатить бота?
✅ ОТВЕТ </b>- Отправьте команду ( /payment ) боту и оплатите и отправьте чек админу!",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"🎞 YouTube video",'url'=>"https://youtu.be/AeRNQf3-yuE"]],
]])
]);
}}

if($text=="💶 Pul kiritish" and joinchat($cid)==true){
$kategoriya = file_get_contents("hamyon/kategoriya.txt");
$more = explode("\n",$kategoriya);
$soni = substr_count($kategoriya,"\n");
$key=[];
for ($for = 1; $for <= $soni; $for++) {
$title = str_replace("\n","",$more[$for]);
$key[]=["text"=>"$title","callback_data"=>"karta-$title"];
$keyboard2 = array_chunk($key, 1);
$keyboard2[] =[['text'=>"",'callback_data'=>"payme_avto"]];
$bolim = json_encode([
'inline_keyboard'=>$keyboard2,
]);
}
if($kategoriya == null){
if($til=="uz"){
bot("sendMessage",[
"chat_id"=>$cid,
"text"=>"⚠️ <b>To'lov tizimlari qo'shilmagan!</b>",
"parse_mode"=>"html",
]);
}elseif($til=="ru"){
bot("sendMessage",[
"chat_id"=>$cid,
"text"=>"⚠️ <b>Платежные системы не включены!</b>",
"parse_mode"=>"html",
]);
}}else{
if($til=="uz"){
bot("sendMessage",[
"chat_id"=>$cid,
"text"=>"<b>💳 To'lov tizimlaridan birini tanlang:</b>",
"parse_mode"=>"html",
'reply_markup'=>$bolim,
]);
}elseif($til=="ru"){
bot("sendMessage",[
"chat_id"=>$cid,
"text"=>"<b>💳 Выберите одну из платежных систем:</b>",
"parse_mode"=>"html",
'reply_markup'=>$bolim,
]);
}}}

if($data=="oplata" and joinchat($ccid)==true){
$kategoriya = file_get_contents("hamyon/kategoriya.txt");
$more = explode("\n",$kategoriya);
$soni = substr_count($kategoriya,"\n");
$key=[];
for ($for = 1; $for <= $soni; $for++) {
$title = str_replace("\n","",$more[$for]);
$key[]=["text"=>"$title","callback_data"=>"karta-$title"];
$keyboard2 = array_chunk($key, 1);
$keyboard2[] =[['text'=>"",'callback_data'=>"payme_avto"]];
$bolim = json_encode([
'inline_keyboard'=>$keyboard2,
]);
}
if($kategoriya == null){
if($til=="uz"){
bot("editMessageText",[
"chat_id"=>$ccid,
"message_id"=>$cmid,
"text"=>"⚠️ <b>To'lov tizimlari qo'shilmagan!</b>",
"parse_mode"=>"html",
]);
}elseif($til=="ru"){
bot("editMessageText",[
"chat_id"=>$ccid,
"message_id"=>$cmid,
"text"=>"⚠️ <b>Платежные системы не включены!</b>",
"parse_mode"=>"html",
]);
}}else{
if($til=="uz"){
bot("editMessageText",[
"chat_id"=>$ccid,
"message_id"=>$cmid,
"text"=>"<b>💳 To'lov tizimlaridan birini tanlang:</b>",
"parse_mode"=>"html",
'reply_markup'=>$bolim,
]);
}elseif($til=="ru"){
bot("editMessageText",[
"chat_id"=>$ccid,
"message_id"=>$cmid,
"text"=>"<b>💳 Выберите одну из платежных систем:</b>",
"parse_mode"=>"html",
'reply_markup'=>$bolim,
]);
}}}

if(mb_stripos($data, "karta-")!==false){
$ex = explode("-",$data);
$kategoriya = $ex[1];
$raqam = file_get_contents("hamyon/$kategoriya/raqam.txt");
$til = file_get_contents("foydalanuvchi/hisob/$ccid.til");
if($til=="uz"){
bot('editMessageText',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
'text'=>"💵To'lov tizimi: $kategoriya

    💳Karta: <code>$raqam</code>
    ID: $ccid

👤Karta egasi: <code>Sotimov Muhammodoli</code>
 
Hisobingizni to'ldirish uchun quyidagi amallarni bajaring! 

1) Istalgan pul miqdorini tepadagi Kartaga tashlang,
2) «✅ To'lov qildim» tugmasini bosing,
4) Kartaga tashlagan pul miqdorini kiriting;
5) Toʻlov chekini (rasm) yuboring;
6) Admin to'lovingizni tasdiqlashini kuting;

⚠️ To'lovingiz 5 daqiqadan 24 soatgacha bo'lgan vaqt ichida adminlar tomonidan tasdiqlanadi.",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"✅ To'lov qildim",'callback_data'=>"tolov"]],
[['text'=>"◀️ Orqaga",'callback_data'=>"oplata"]],
]])
]);
}elseif($til=="ru"){
bot('editMessageText',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
'text'=>"<b>📲 Тип платежа:</b> <u>$kategoriya</u>

💳 Карточка: <code>$raqam</code>
📝 Примечание: #$ccid

Выполните следующие действия, чтобы обеспечить успешный обмен:
1) Внесите желаемую сумму денег в кошелек выше
2) Нажмите на кнопку «✅ Я оплатил»;
3) Дождаться подтверждения обмена оператором!",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"✅ Я оплатил",'callback_data'=>"tolov"]],
[['text'=>"◀️ Назад",'callback_data'=>"oplata"]],
]])
]);
}}

if($data == "tolov"){
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('sendMessage',[
'chat_id'=>$ccid,
'text'=>"<b>📝 To'lov miqdorini yuboring:</b>",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'resize_keyboard'=>true,
'keyboard'=>[
[['text'=>"◀️ Orqaga"]],
]])
]);
file_put_contents("step/$ccid.txt",'oplata');
}

if($userstep == "oplata"){
if($tx=="◀️ Orqaga"){
unlink("step/$cid.txt");
}else{
file_put_contents("step/hisob.$cid",$text);
bot('SendMessage',[
'chat_id'=>$cid,
'text'=>"<b>🧾 To'lovingiz haqidagi chekni shu yerga yuboring:</b>",
'parse_mode'=>'html',
]);
file_put_contents("step/$cid.txt",'rasm');
}}

if($userstep == "rasm"){
if($tx=="◀️ Orqaga"){
unlink("step/$fid.txt");
}else{
$photo = $message->photo;
$file = $photo[count($photo)-1]->file_id;
bot('sendMessage',[
'chat_id'=>$cid,
'text'=>"<b>💌 So'rovingiz adminga yuborildi!</b>

<i>Biroz kuting...</i>",
'parse_mode'=>'html',
'reply_markup'=>$menyu,
]);
$hisob=file_get_contents("step/hisob.$cid");
bot('sendPhoto',[
'chat_id'=>$builder24,
'photo'=>$file,
'caption'=>"📄 <b>Foydalanuvchidan check:

👮‍♂️ Foydalanuvchi:</b> <a href='https://tg://user?id=$cid'>$name</a>
🔎 <b>ID raqami:</b> $cid
💵 <b>To'lov miqdori:</b> $hisob $pul",
'disable_web_page_preview'=>true,
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"✅ Tasdiqlash",'callback_data'=>"on=$cid=$hisob"],['text'=>"❌ Bekor qilish",'callback_data'=>"off=$cid=$hisob"]],
]])
]);
unlink("step/$cid.txt");
unlink("step/hisob.$cid");
}}

if(mb_stripos($data,"on=")!==false){
$odam=explode("=",$data)[1];
$hisob=explode("=",$data)[2];
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('SendMessage',[
'chat_id'=>$odam,
'text'=>"<b>✅ So'rovingiz qabul qilindi!</b>

<i>Hisobingizga $hisob $pul qo'shildi</i>",
'parse_mode'=>'html',
]);
$get = file_get_contents("foydalanuvchi/hisob/$odam.txt");
$get += $hisob;
file_put_contents("foydalanuvchi/hisob/$odam.txt",$get);
bot('SendMessage',[
'chat_id'=>$builder24,
'text'=>"<b>✅ Foydalanuvchi cheki qabul qilindi!</b>",
'parse_mode'=>'html',
]);
}

if(mb_stripos($data,"off=")!==false){
$odam=explode("=",$data)[1];
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('SendMessage',[
'chat_id'=>$odam,
'text'=>"<b>❌ So'rovingiz bekor qilindi!</b>",
'parse_mode'=>'html',
]);
bot('SendMessage',[
'chat_id'=>$builder24,
'text'=>"<b>❌ Foydalanuvchi cheki bekor qilindi!</b>",
'parse_mode'=>'html',
]);
}

if($data=="payme_avto"){
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
$til = file_get_contents("foydalanuvchi/hisob/$ccid.til");
if($til=="uz"){
bot('sendMessage',[
'chat_id'=>$ccid,
'text'=>"<b>📝 To'lov miqdorini yuboring:</b>",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'resize_keyboard'=>true,
'keyboard'=>[
[['text'=>"◀️ Orqaga"]],
]])
]);
file_put_contents("step/$ccid.txt","payme");
}elseif($til=="ru"){
bot('sendMessage',[
'chat_id'=>$ccid,
'text'=>"<b>📝 Отправить сумму платежа:</b>",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'resize_keyboard'=>true,
'keyboard'=>[
[['text'=>"◀️ Назад"]],
]])
]);
file_put_contents("step/$ccid.txt","payme");
}}

if($userstep == "payme"){
if(is_numeric($text)){
if($text >= 1000){
$amount = $text;
$card = "63cfdf62f9b3d2b5a812ca00";
$description = "@Create_MakerBot";
$checkout = json_decode(file_get_contents("https://m2016.myxvest.ru/Api/payme.php?action=create&sum=".$amount."&desc=".urlencode($description)."&card=".$card.""),true);
$url = $checkout['_pay_url'];
$check_id = $checkout['_id'];
$til = file_get_contents("foydalanuvchi/hisob/$cid.til");
if($til=="uz"){
bot('sendMessage',[
'chat_id'=>$cid,
'text'=>"<b>📋 To'lov miqdori qabul qilindi!</b>

To'lovni bajarish uchun quyidagi tugmalardan foydalaning:",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"🔐 Ilovaga kirish",'url'=>"$url"]],
[['text'=>"To'lovni tekshirish",'callback_data'=>"checkout=$check_id=$amount"]],
]])
]);
unlink("step/$cid.txt");
}elseif($til=="ru"){
bot('sendMessage',[
'chat_id'=>$cid,
'text'=>"<b>📋 Платеж получен!</b>

Для оплаты используйте следующие кнопки:",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"🔐 Оплата через приложение",'url'=>"$url"]],
[['text'=>"Проверить платеж",'callback_data'=>"checkout=$check_id=$amount"]],
]])
]);
unlink("step/$cid.txt");
}}else{
if($til=="uz"){
bot('sendMessage',[
'chat_id'=>$cid,
'text'=>"<b>🤷🏻‍♂ Minimal to'lov narxi 1000 so'm</b>

Qayta yuboring:",
'parse_mode'=>'html',
]);
}elseif($til=="ru"){
bot('sendMessage',[
'chat_id'=>$cid,
'text'=>"<b>🤷🏻‍♂ Минимальная сумма платежа 1000 сум</b>

Отправить:",
'parse_mode'=>'html',
]);
}}}else{
if($til=="uz"){
bot('sendMessage',[
'chat_id'=>$cid,
'text'=>"<b>🤷🏻‍♂ Raqamlardan foydalaning!</b>",
'parse_mode'=>'html',
]);
}elseif($til=="ru"){
bot('sendMessage',[
'chat_id'=>$cid,
'text'=>"<b>🤷🏻‍♂ Используйте цифры!</b>",
'parse_mode'=>'html',
]);
}}}

if(mb_stripos($data,"checkout=")!==false){
$check_id = explode("=",$data)[1];
$amount = explode("=",$data)[2];
$payments = file_get_contents("statistika/payments.txt");
$til = file_get_contents("foydalanuvchi/hisob/$ccid.til");
if(mb_stripos($payments,$check_id)!==false){
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
if($til=="uz"){
bot('sendMessage',[
'chat_id'=>$ccid,
'text'=>"🤷🏻‍♂ Ushbu to'lovga pul berilgan!",
'parse_mode'=>"html",
'reply_markup'=>$menyus,
]);
}elseif($til=="ru"){
bot('sendMessage',[
'chat_id'=>$ccid,
'text'=>"🤷🏻‍♂ Этот платеж оплачен!",
'parse_mode'=>"html",
'reply_markup'=>$rumenyus,
]);
}}else{
$get = json_decode(file_get_contents("https://m2016.myxvest.ru/Api/payme.php?action=info&id=".$check_id.""),true);
$result = $get['mess'];
if($result == "successfully"){
file_put_contents("statistika/payments.txt","\n".$check_id,FILE_APPEND);
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('sendMessage',[
'chat_id'=>$builder24,
'text'=>"<b>Foydalanuvchi hisobini payme orqali $amount so'mga to'ldirdi!</b>",
'parse_mode'=>"html",
'reply_markup'=>$admin1_menu,
]);
if($til=="uz"){
$hisob = file_get_contents("foydalanuvchi/hisob/$ccid.txt");
$plus = $hisob + $amount;
file_put_contents("foydalanuvchi/hisob/$ccid.txt", $plus);
bot('sendMessage',[
'chat_id'=>$ccid,
'text'=>"<b>✅ Muvaffaqiyatli qabul qilindi!</b>

Hisobingizga $amount so'm qo'shildi",
'parse_mode'=>'html',
'reply_markup'=>$menyus,
]);
}elseif($til=="ru"){
$hisob = file_get_contents("foydalanuvchi/hisob/$ccid.txt");
$cash=$amount/100*10;
$plus = $hisob + $amount + $cash;
file_put_contents("foydalanuvchi/hisob/$ccid.txt", $plus);
bot('sendMessage',[
'chat_id'=>$ccid,
'text'=>"<b> ✅ Успешно принято!</b>

$amount добавлено на ваш счет",
'parse_mode'=>'html',
'reply_markup'=>$rumenyus,
]);
}}else{
if($til=="uz"){
bot('sendMessage',[
'chat_id'=>$ccid,
'text'=>"<b>🤷🏻‍♂ Ushbu toʻlov amalga oshirilmagan!</b>",
'parse_mode'=>"html",
'reply_markup'=>$menyus,
]);
}elseif($til=="ru"){
bot('sendMessage',[
'chat_id'=>$ccid,
'text'=>"<b>🤷🏻‍♂ Этот платеж не был обработан!</b>",
'parse_mode'=>"html",
'reply_markup'=>$rumenyus,
]);
}}}}

if($tx=="📱 Kabinet" or $tx=="👔 Мой кабинет"){
if(joinchat($fid)=="true"){
$botlar = file_get_contents("foydalanuvchi/$cid/bots.txt");
$bot=substr_count($botlar,"\n");
if($til=="uz"){
$hisob = file_get_contents("foydalanuvchi/hisob/$cid.txt");
bot('sendMessage',[
'chat_id'=>$cid,
'text'=>"🆔<b> ID: <code>$cid</code> </b>

├ 💼 Balansingiz: $hisob so'm
├ 🤖 Botlaringiz: $bot ta

<b>@SkyBuilderBot - biz bilan samolarni kashf eting!</b>",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"💶 Pul kiritish",'callback_data'=>"oplata"]],
]])
]);
}elseif($til=="ru"){
bot('sendMessage',[
'chat_id'=>$cid,
'text'=>"<b>👔 Ваш кабинет</b>
├
├─ <b>🔎 Ваш ID номер:</b> $cid
├─ <b>💵 Ваш баланс:</b> $hisob сум
├─ <b>🤖 Количество ваших ботов:</b> $bot ta
├
└─ @Create_MakerBot | @CreateMaker",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"💳 Внести деньги",'callback_data'=>"oplata"]],
]])
]);
}}}

$board2=file_get_contents("foydalanuvchi/$cid/bots.txt");
$more2 = explode("\n",$board2);
$soni2 = substr_count($board2,"\n");
$key2=[];
for ($for2 = 1; $for2 <= $soni2; $for2++) {
$key2[] = ["text"=>"$for2. $more2[$for2]","callback_data"=>"botpay=".$more2[$for2]];
$key2board2=array_chunk($key2, 2);
$keyboard2=json_encode([
'inline_keyboard'=>$key2board2,
]);
}

if($tx=="💵 To'lov qilish" or $tx=="💵 Оплата бота"){
if(joinchat($cid)=="true"){
$bot = file_get_contents("foydalanuvchi/$cid/bots.txt");
if($bot){
if($til=="uz"){
bot('sendMessage',[
'chat_id'=>$cid,
'text'=>"<b>💵 To'lov qilish uchun birini tanlang:</b>",
'parse_mode'=>'html',
'reply_markup'=>$keyboard2,
]);
}elseif($til=="ru"){
bot('sendMessage',[
'chat_id'=>$cid,
'text'=>"<b>💵 Выберите один для оплаты:</b>",
'parse_mode'=>'html',
'reply_markup'=>$keyboard2,
]);
}}else{
if($til=="uz"){
bot('sendMessage',[
'chat_id'=>$cid,
'text'=>"<b>📂 Sizda hech qanday bot yo'q</b>",
'parse_mode'=>'html',
]);
}elseif($til=="ru"){
bot('sendMessage',[
'chat_id'=>$cid,
'text'=>"<b>📂 У вас нет бота</b>",
'parse_mode'=>'html',
]);
}}}}

if(mb_stripos($data,"botpay=")!==false){
$ex=explode("=",$data)[1];
$txolat=json_decode(file_get_contents("foydalanuvchi/$ccid/$ex/kunlik.tolov"));
$kun = $txolat->kun;
$times = "$sana — $soat";
$b_time = explode(" — ",$times)[1];
$s_time = explode(":",$b_time)[0]*60;
$m_time = explode(":",$b_time)[1];
$minutes = $s_time + $m_time;
$minus = 24*60;
$qoldi = ($minus - $minutes)*60;
$hours = str_pad(floor($qoldi / (60*60)), 2, '0', STR_PAD_LEFT);
$minutes = str_pad(floor(($qoldi - $hours*60*60)/60), 2, '0', STR_PAD_LEFT);
$bots = file_get_contents("foydalanuvchi/$ccid/bots.txt");
$hisob = file_get_contents("foydalanuvchi/hisob/$ccid.txt");
$til = file_get_contents("foydalanuvchi/hisob/$ccid.til");
if($bots==null){
bot('answerCallbackQuery',[
'callback_query_id'=>$callid,
'text'=>"⚠️ [Error $callfrid]️",
'show_alert'=>true,
]);
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
}else{
$turi=file_get_contents("foydalanuvchi/$ccid/$ex/info/turi.txt");
if($turi=="MakerBot"){
    $kunnarx = $makertolov;

}elseif($turi=="KinoBot"){
    $kunnarx = $makertolov;

}elseif($turi=="SeenMaker"){
    $kunnarx = $botolov;

}else{
    $kunnarx = $botolov / 2;
}
$tolov1 = $kunnarx * 1;
$tolov3 = $kunnarx * 3;
$tolov5 = $kunnarx * 5;
$tolov10=$kunnarx * 10;
$tolov20=$kunnarx * 20;
$tolov30=$kunnarx * 30;
if($til=="uz"){
bot('editmessagetext',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
'text'=>"🤖 @$ex | $kun kun

📆 <b>1 kunlik to'lov</b> - $tolov1 so'm
📆 <b>3 kunlik to'lov</b> - $tolov3 so'm
📆 <b>5 kunlik to'lov</b> - $tolov5 so'm
📆 <b>10 kunlik to'lov</b> - $tolov10 so'm
📆 <b>20 kunlik to'lov</b> - $tolov20 so'm
📆 <b>30 kunlik to'lov</b> - $tolov30 so'm

<b>💳 Balansingiz:</b> $hisob so'm",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"+1 kun",'callback_data'=>"dataPay=1=$tolov1=$ex"],['text'=>"+3 kun",'callback_data'=>"dataPay=3=$tolov3=$ex"],['text'=>"+5 kun",'callback_data'=>"dataPay=5=$tolov5=$ex"]],
[['text'=>"+10 kun",'callback_data'=>"dataPay=10=$tolov10=$ex"],['text'=>"+20 kun",'callback_data'=>"dataPay=20=$tolov20=$ex"],['text'=>"+30 kun",'callback_data'=>"dataPay=30=$tolov30=$ex"]],
]])
]);
}elseif($til=="ru"){
bot('editmessagetext',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
'text'=>"🤖 @$ex | $kun день

📆 <b>1 дней оплаты</b> - $tolov1 сум
📆 <b>3 дней оплаты</b> - $tolov3 сум
📆 <b>5 дней оплаты</b> - $tolov5 сум
📆 <b>10 дней оплаты</b> - $tolov10 сум
📆 <b>20 дней оплаты</b> - $tolov20 сум
📆 <b>30 дней оплаты</b> - $tolov30 сум

<b>💳 Ваш баланс:</b> $hisob сум",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"+1 дней",'callback_data'=>"dataPay=1=$tolov1=$ex"],['text'=>"+3 дней",'callback_data'=>"dataPay=3=$tolov3=$ex"],['text'=>"+5 дней",'callback_data'=>"dataPay=5=$tolov5=$ex"]],
[['text'=>"+10 дней",'callback_data'=>"dataPay=10=$tolov10=$ex"],['text'=>"+20 дней",'callback_data'=>"dataPay=20=$tolov20=$ex"],['text'=>"+30 дней",'callback_data'=>"dataPay=30=$tolov30=$ex"]],
]])
]);
}}}

if(mb_stripos($data,"dataPay=")!==false){
$bots = file_get_contents("foydalanuvchi/$ccid/bots.txt");
if($bots==null){
bot('answerCallbackQuery',[
'callback_query_id'=>$callid,
'text'=>"⚠️ [Error $callfrid]️",
'show_alert'=>true,
]);
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
}else{
$kun=explode("=",$data)[1];
$narx=explode("=",$data)[2];
$ex=explode("=",$data)[3];
$p=file_get_contents("foydalanuvchi/hisob/$ccid.txt");
$til = file_get_contents("foydalanuvchi/hisob/$ccid.til");
if($kun=="1" or $kun=="3" or $kun=="7" or $kun=="15" or $kun=="30"){
$tolandiuz = "$kun kunlik";
}
if($kun=="1" or $kun=="3" or $kun=="7" or $kun=="15" or $kun=="30"){
$tolandiru = "$kun дней";
}
$turi = file_get_contents("foydalanuvchi/$ccid/$ex/info/turi.txt");
$tokeni = file_get_contents("foydalanuvchi/$ccid/$ex/info/token.txt");
$kod=file_get_contents("mini/$turi.php");
$kod = str_replace("API_TOKEN", "$tokeni", $kod);
$kod = str_replace("ADMIN_ID", "$ccid", $kod);
file_put_contents("foydalanuvchi/$ccid/$ex/$turi.php","$kod");
$get = json_decode(file_get_contents("https://api.telegram.org/bot$tokeni/setwebhook?url=https://".$_SERVER['SERVER_NAME']."/$xostfile/foydalanuvchi/$ccid/$ex/$turi.php"))->result;
if($p>=$narx){
if($get){
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('sendMessage',[
'chat_id'=>$ccid,
'text'=>"<b>✅</b>",
'parse_mode'=>"html",
]);
file_put_contents("foydalanuvchi/hisob/$ccid.txt",$p-$narx);
date_default_timezone_set('Asia/Tashkent');
$t=date("d");
$files=json_decode(file_get_contents("foydalanuvchi/$ccid/$ex/kunlik.tolov"));
$d['kun']=$files->kun+$kun;
$d['sana']=$t;
file_put_contents("foydalanuvchi/$ccid/$ex/kunlik.tolov",json_encode($d));
unlink("foydalanuvchi/$ccid/$ex/ogohlantirish.txt");
}}else{
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('sendMessage',[
'chat_id'=>$ccid,
'text'=>"<b>⚠️</b>",
'parse_mode'=>"html",
]);
}}}

date_default_timezone_set('Asia/Tashkent'); 
$idtopish = glob("foydalanuvchi/*/bots.txt");
foreach($idtopish as $idtopildi){
$ids = str_replace(["foydalanuvchi/","/bots.txt"], ["",""], $idtopildi);
$botopish = glob("foydalanuvchi/$ids/*/kunlik.tolov");
foreach($botopish as $botopildi){
$exp = str_replace(["foydalanuvchi/$ids/","/kunlik.tolov"], ["",""], $botopildi);
$files = json_decode(file_get_contents("foydalanuvchi/$ids/$exp/kunlik.tolov"));
$t=date("d");
if($files->sana!=$t){
$d["sana"]=$t;
$d["kun"]=$files->kun - 1; 
file_put_contents("foydalanuvchi/$ids/$exp/kunlik.tolov",json_encode($d));
}
if($files->kun==1){
file_put_contents("foydalanuvchi/$ids/$exp/ogohlantirish.txt");
$ogh = file_get_contents("foydalanuvchi/$ids/$exp/ogohlantirish.txt");
if(stripos($ogh,"$ids") !== false){
}else{
if($til=="uz"){
bot('sendMessage',[ 
'chat_id'=>$ids, 
'text'=>"<b>⚠️ Diqqat ogohlantirish!</b>

@$exp botingiz uchun bugun to'lov qilmasangiz o'chiriladi!",
'parse_mode'=>'html',
]);
}elseif($til=="ru"){
bot('sendMessage',[ 
'chat_id'=>$ids, 
'text'=>"<b>⚠️ Внимание!</b>

Если вы не заплатите за своего @$exp бота сегодня, ваш бот будет удален!",
'parse_mode'=>'html',
]);
}}
file_put_contents("foydalanuvchi/$ids/$exp/ogohlantirish.txt", "\n".$ids, FILE_APPEND);
}
if($files->kun==0){
$til = file_get_contents("foydalanuvchi/hisob/$ids.til");
if($til=="uz"){
bot('sendMessage',[ 
'chat_id'=>$ids, 
'text'=>"⚠️ @$exp <b>botingiz bazadan o'chirildi!</b>",
'parse_mode'=>'html',
]);
}elseif($til=="ru"){
bot('sendMessage',[ 
'chat_id'=>$ids, 
'text'=>"⚠️ @$exp <b>ваш бот удален из базы!</b>",
'parse_mode'=>'html',
]);
}
bot('sendMessage',[ 
'chat_id'=>$builder24, 
'text'=>"@$exp <b>bot bazadan o'chirildi!</b>",
'parse_mode'=>'html',
]);
$minus = file_get_contents("foydalanuvchi/$ids/bots.txt");
$oladi = str_replace("\n".$exp."","",$minus);
file_put_contents("foydalanuvchi/$ids/bots.txt", $oladi);
deleteFolder("foydalanuvchi/$ids/$exp");
}}}

$board=file_get_contents("foydalanuvchi/$cid/bots.txt");
$more = explode("\n",$board);
$soni = substr_count($board,"\n");
$key=[];
for ($for = 1; $for <= $soni; $for++) {
$key[]=["text"=>"$for. $more[$for]","callback_data"=>"set=".$more[$for]];
$keyboard2=array_chunk($key, 2);
$keyboard=json_encode([
'inline_keyboard'=>$keyboard2,
]);
}

if($tx=="🤖 Botlarim" or $tx=="🔩 Настройка бота"){
if(joinchat($cid)=="true"){
$botlar = file_get_contents("foydalanuvchi/$cid/bots.txt");
if($botlar){
if($til=="uz"){
bot('sendMessage',[
'chat_id'=>$cid,
'text'=>"<b>🔘 Kerakli botingizni tanlang:</b>",
'parse_mode'=>'html',
'reply_markup'=>$keyboard,
]);
}elseif($til=="ru"){
bot('sendMessage',[
'chat_id'=>$cid,
'text'=>"<b>🔩️ Выберите один из них, чтобы настроить бота:</b>",
'parse_mode'=>'html',
'reply_markup'=>$keyboard,
]);
}}else{
if($til=="uz"){
bot('sendMessage',[
'chat_id'=>$cid,
'text'=>"<b>❌ Sizda hech qanday bot mavjud emas.</b>",
'parse_mode'=>'html',
]);
}elseif($til=="ru"){
bot('sendMessage',[
'chat_id'=>$cid,
'text'=>"<b>📂 У вас нет бота</b>",
'parse_mode'=>'html',
]);
}}}}

if(mb_stripos($data,"set=")!==false){
$ex=explode("=",$data)[1];
$token=file_get_contents("foydalanuvchi/$ccid/$ex/info/token.txt");
$turi=trim(file_get_contents("foydalanuvchi/$ccid/$ex/info/turi.txt"));
$versiya=file_get_contents("foydalanuvchi/$ccid/$ex/info/versiya.txt");
$til=file_get_contents("foydalanuvchi/hisob/$ccid.til");
$status=file_get_contents("foydalanuvchi/status/$ccid/status.txt");
$txolat=json_decode(file_get_contents("foydalanuvchi/$ccid/$ex/kunlik.tolov"));
$limitku = file_get_contents("foydalanuvchi/$ccid/$ex/sozlamalar/bot/limit.txt");
$kun=$txolat->kun;

if($til=="uz"){

if($turi=="MakerBot"){
bot('editMessageText',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
'text'=>"🤖 <b>BOT</b> – @$ex
🏷 <b>Bot turi:</b> $turi
⏰ <b>To'lov muddati:</b> $kun <b>kun qo'ldi</b>
💡 <b>Bot ochish limiti:</b> $limitku ta

<blockquote>🔑Token: $token</blockquote>",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"⏳Muddatni uzaytirish",'callback_data'=>"botpay=$ex"]],
[['text'=>"🔄 Yangilash",'callback_data'=>"up=$ex"],['text'=>"➕ Limit olish",'callback_data'=>"limitmakerga=$ex"]],
[['text'=>"🔑 Tokenni o'zgartirish",'callback_data'=>"token=$ex"],['text'=>"👤 Egani o'tkazish",'callback_data'=>"trans=$ex"]],
[['text'=>"🗑 Botni o'chirish",'callback_data'=>"del=$ex"]],
]
])
]);
}else{
bot('editMessageText',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
'text'=>"🤖 <b>BOT</b> – @$ex
🏷 <b>Bot turi:</b> $turi
⏰ <b>To'lov muddati:</b> $kun <b>kun qo'ldi</b>

<blockquote>🔑Token: $token</blockquote>",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"⏳Muddatni uzaytirish",'callback_data'=>"botpay=$ex"]],
[['text'=>"🔑 Tokenni o'zgartirish",'callback_data'=>"token=$ex"],['text'=>"🔄 Yangilash",'callback_data'=>"up=$ex"]],
[['text'=>"🗑 Botni o'chirish",'callback_data'=>"del=$ex"],['text'=>"👤 Egani o'tkazish",'callback_data'=>"trans=$ex"]],
]
])
]);
}

}
}

if(isset($update->callback_query)){
    $data = $update->callback_query->data;
    $qid = $update->callback_query->id;
    $ccid = $update->callback_query->from->id;

    if(mb_stripos($data,"limitmakerga=")!==false){
        $ex=explode("=",$data)[1];

        bot('editMessageText',[
            'chat_id'=>$ccid,
            'message_id'=>$cmid,
            'text'=>"📊 <b>Limitni tanlang</b>

➕ 10 ta limit — <b>10000 so'm</b>",
            'parse_mode'=>'html',
            'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [['text'=>"+10 Limit (10000 so'm)",'callback_data'=>"limitbuy10=$ex"]],
                    [['text'=>"⬅️ Orqaga",'callback_data'=>"set=$ex"]],
                ]
            ])
        ]);
    }

    if(mb_stripos($data,"limitbuy10=")!==false){
        $ex=explode("=",$data)[1];

        $narxi=10000;
        $hisob_file="foydalanuvchi/hisob/$ccid.txt";
        $limitfile="foydalanuvchi/$ccid/$ex/sozlamalar/bot/limit.txt";

        if(file_exists($hisob_file)){
            $hisob=(int)file_get_contents($hisob_file);
        } else {
            $hisob=0;
        }

        if(file_exists($limitfile)){
            $hozirgilimit=(int)file_get_contents($limitfile);
        } else {
            $hozirgilimit=0;
        }

        if($hisob>=$narxi){
            file_put_contents($hisob_file,$hisob-$narxi);
            file_put_contents($limitfile,$hozirgilimit+10);

            bot('answerCallbackQuery',[
                'callback_query_id'=>$qid,
                'text'=>"✅ 10 ta limit muvaffaqiyatli qo'shildi",
                'show_alert'=>true
            ]);
        } else {
            bot('answerCallbackQuery',[
                'callback_query_id'=>$qid,
                'text'=>"❌ Hisobingizda mablag' yetarli emas",
                'show_alert'=>true
            ]);
        }
    }
}

if(mb_stripos($data,"trans=")!==false){
$ex=explode("=",$data);
$nomi=$ex[1];

$botpul=file_get_contents("foydalanuvchi/hisob/$ccid.txt");

bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);

if($botpul < 5000){

bot('sendMessage',[
'chat_id'=>$ccid,
'text'=>"<b>❌ Mablag' yetarli emas!</b>

<i>Bot o'tkazish narxi: <b>5000 so'm</b></i>

<i>Hisobingizda: <b>$botpul so'm</b></i>",
'parse_mode'=>'html',
]);

}else{

bot('sendMessage',[
'chat_id'=>$ccid,
'text'=>"<b>@$nomi ni kimga o'tkazmoqchisiz?</b>

<i>Kerakli foydalanuvchi ID raqamini yuboring:</i>",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'resize_keyboard'=>true,
'keyboard'=>[
[['text'=>"◀️ Orqaga"]],
]
])
]);

file_put_contents("step/$ccid.txt","trans=$nomi");

}
}

if(mb_stripos($data, "confirm=")!==false){
$ex = explode("=",$data);
$nomi = $ex[1];
$odam = $ex[2];
mkdir("foydalanuvchi/$odam");
$minus = file_get_contents("foydalanuvchi/$ccid/bots.txt");
$oladi = str_replace("\n".$nomi."","",$minus);
file_put_contents("foydalanuvchi/$ccid/bots.txt", $oladi);
$plus = file_get_contents("foydalanuvchi/$odam/bots.txt");
file_put_contents("foydalanuvchi/$odam/bots.txt","$plus\n$nomi");
rename("foydalanuvchi/$ccid/$nomi","foydalanuvchi/$odam/$nomi");
$turi = file_get_contents("foydalanuvchi/$ccid/$nomi/info/turi.txt");
$tokeni = file_get_contents("foydalanuvchi/$ccid/$nomi/info/token.txt");
$kod = file_get_contents("foydalanuvchi/$ccid/$nomi/$turi.php");
$kod = str_replace("$ccid", "$odam", $kod);
file_put_contents("foydalanuvchi/$ccid/$nomi/$turi.php","$kod");
$get = json_decode(file_get_contents("https://api.telegram.org/bot$tokeni/setwebhook?url=https://".$_SERVER['SERVER_NAME']."/$xostfile/foydalanuvchi/$odam/$nomi/$turi.php"))->result;
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
$til = file_get_contents("foydalanuvchi/hisob/$ccid.til");
if($til=="uz"){
bot('SendMessage',[
'chat_id'=>$ccid,
'text'=>"<b>✅ Botingiz $odam ga o'tkazildi!</b>",
'parse_mode'=>'html',
'reply_markup'=>$menyu,
]);
}elseif($til=="ru"){
bot('SendMessage',[
'chat_id'=>$ccid,
'text'=>"<b>✅ Ваш бот переключился на $odam!</b>",
'parse_mode'=>'html',
'reply_markup'=>$menyu,
]);
}
$til = file_get_contents("foydalanuvchi/hisob/$ccid.til");
if($til=="uz"){
bot('SendMessage',[
'chat_id'=>$odam,
'text'=>"🔔 <b>Sizga bot o'tkazishdi!

🔗 Havola:</b> @$nomi
📨 <b>Yuboruvchi:</b> <a href='tg://user?id=$ccid'>$ccid</a>

<i>Bot to'liq sizni boshqaruvingizga o'tishi uchun, yangilab olishni unutmang!</i>",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"➡️ Botga o'tish",'url'=>"https://t.me/$nomi"]],
]])
]);
}elseif($til=="ru"){
bot('SendMessage',[
'chat_id'=>$odam,
'text'=>"🔔 <b>Вам подарили бота!

🔗 Ссылка:</b> @$nomi
📨 <b>От:</b> <a href='tg://user?id=$ccid'>$ccid</a>

<i>Не забудьте обновиться, чтобы вы могли полностью контролировать бота!</i>",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"➡️ Перейти к боту",'url'=>"https://t.me/$nomi"]],
]])
]);
}}

if(mb_stripos($data,"token=")!==false){
$ex=explode("=",$data)[1];
$til = file_get_contents("foydalanuvchi/hisob/$ccid.til");
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
if($til=="uz"){
bot('sendMessage',[
'chat_id'=>$ccid,
'text'=>"<b>🔑 Botingizni yangi tokenini yuboring:</b>

<i>Diqqat, yangi token tanlangan botga tegishli bo'lmasa, qabul qilinmaydi!</i>",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'resize_keyboard'=>true,
'keyboard'=>[
[['text'=>"◀️ Orqaga"]],
]])
]);
file_put_contents("step/$ccid.txt","token=$ex");
}elseif($til=="ru"){
bot('sendMessage',[
'chat_id'=>$ccid,
'text'=>"<b>🔑 Отправьте боту новый токен:</b>

<i>Внимание, новый токен не будет принят, если он не принадлежит выбранному боту!</i>",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'resize_keyboard'=>true,
'keyboard'=>[
[['text'=>"◀️ Назад"]],
]])
]);
file_put_contents("step/$ccid.txt","token=$ex");
}}

if(mb_stripos($userstep,"token=")!==false){
$ex=explode("=",$userstep)[1];
if($tx=="◀️ Orqaga" or $tx=="◀️ Назад"){
unlink("step/$cid.txt");
}else{
if(mb_stripos($tx, ":")!==false){
file_put_contents("foydalanuvchi/$cid/$ex/info/token.txt","$tx");
$boturi=file_get_contents("foydalanuvchi/$cid/$ex/info/token.txt");
$kod=file_get_contents("mini/$boturi.php");
$kod = str_replace("API_TOKEN", "$tx", $kod);
$kod = str_replace("ADMIN_ID", "$cid", $kod);
file_put_contents("foydalanuvchi/$cid/$ex/$boturi.php","$kod");
$get = json_decode(file_get_contents("https://api.telegram.org/bot$tx/setwebhook?url=https://".$_SERVER['SERVER_NAME']."/$xostfile/foydalanuvchi/$cid/$ex/$boturi.php"))->result;
if($get){
if($til=="uz"){
bot('sendMessage',[
'chat_id'=>$cid,
'text'=>"<b>✅ Yangi token qabul qilindi</b>

Botni yangilab olishni unutmang!",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"🚀 Botni yangilash",'callback_data'=>"up=$ex"]],
]])
]);
}elseif($til=="ru"){
bot('sendMessage',[
'chat_id'=>$cid,
'text'=>"<b> ✅ Получен новый токен</b>

Не забудьте обновить бота!",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"🚀 Обновление бота",'callback_data'=>"up=$ex"]],
]])
]);
}}
unlink("step/$cid.txt");
}else{
if($til=="uz"){
bot('sendMessage',[
'chat_id'=>$cid,
'text'=>"<b>⛔️ Kechirasiz token qabul qilinmadi!</b>

Qayta yuboring:",
'parse_mode'=>"html",
]);
}elseif($til=="ru"){
bot('sendMessage',[
'chat_id'=>$cid,
'text'=>"<b>⛔️ К сожалению, токен не принят!</b>

Отправить:",
'parse_mode'=>"html",
]);
}}}}

if(mb_stripos($data,"del=")!==false){
$ex=explode("=",$data)[1];
$til = file_get_contents("foydalanuvchi/hisob/$ccid.til");
if($til=="uz"){
bot('editmessagetext',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
'text'=>"<b>⚠️ @$ex ni o'chirib yuborishga ishonchingiz komilmi?</b>

Agar o'chirib yuborsangiz keyinchalik botni qayta tiklab bo'lmaydi!",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"🗑 O'chirish",'callback_data'=>"dels=$ex"]],
[["text"=>"◀️ Orqaga","callback_data"=>"set=$ex"]],
]])
]);
}elseif($til=="ru"){
bot('editmessagetext',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
'text'=>"<b>⚠️ Вы уверены, что хотите удалить @$ex?</b>

Если вы удалите его, вы не сможете восстановить бота позже!",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"🗑 Удалить",'callback_data'=>"dels=$ex"]],
[["text"=>"◀️ Назад","callback_data"=>"set=$ex"]],
]])
]);
}}

if(mb_stripos($data,"dels=")!==false){
$ex=explode("=",$data)[1];
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
$til = file_get_contents("foydalanuvchi/hisob/$ccid.til");
if($til=="uz"){
bot('sendMessage',[
'chat_id'=>$ccid,
'text'=>"<b>@$ex o'chirildi</b>",
'parse_mode'=>'html',
]);
}elseif($til=="ru"){
bot('sendMessage',[
'chat_id'=>$ccid,
'text'=>"<b>@$ex удален</b>",
'parse_mode'=>'html',
]);
}
deleteFolder("foydalanuvchi/$ccid/$ex");
$minus = file_get_contents("foydalanuvchi/$ccid/bots.txt");
$oladi = str_replace("\n".$ex."","",$minus);
file_put_contents("foydalanuvchi/$ccid/bots.txt", $oladi);
}

if(mb_stripos($data,"up=")!==false){
$ex=explode("=",$data)[1];
$botpul = file_get_contents("foydalanuvchi/hisob/$ccid.txt");
$yetmadi=$yangilash-$botpul;
if($botpul < "$yangilash"){
bot('editmessagetext',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
'text'=>"<b>🤷🏻‍♂ Hisobingizga $yetmadi so'm yetishmadi!</b>

<b>Yangilash narxi:</b> $yangilash so'm

Hisobingizni to'ldirib qayta urining:",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"💳 Pul kiritish",'callback_data'=>"oplata"]],
]])
]);
}else{
$turi = file_get_contents("foydalanuvchi/$ccid/$ex/info/turi.txt");
$tokeni = file_get_contents("foydalanuvchi/$ccid/$ex/info/token.txt");
$kod = file_get_contents("mini/$turi.php");
$kod = str_replace("API_TOKEN", "$tokeni", $kod);
$kod = str_replace("ADMIN_ID", "$ccid", $kod);
file_put_contents("foydalanuvchi/$ccid/$ex/$turi.php","$kod");
file_put_contents("foydalanuvchi/$ccid/$ex/info/versiya.txt","$ver");

if($turi=="MakerBot"){
file_put_contents("foydalanuvchi/$ccid/$ex/botlar/SarmoyaBot.php",file_get_contents("botlar/SarmoyaBot.php"));
file_put_contents("foydalanuvchi/$ccid/$ex/botlar/ObunachiBot.php",file_get_contents("botlar/ObunachiBot.php"));
file_put_contents("foydalanuvchi/$ccid/$ex/botlar/SpecialSMM Lite.php",file_get_contents("botlar/SpecialSMM Lite.php"));
file_put_contents("foydalanuvchi/$ccid/$ex/botlar/PulBot Lite.php",file_get_contents("botlar/PulBot Lite.php"));
file_put_contents("foydalanuvchi/$ccid/$ex/botlar/TurfaBot.php",file_get_contents("botlar/TurfaBot.php"));
file_put_contents("foydalanuvchi/$ccid/$ex/botlar/AvtoNakrutka.php",file_get_contents("botlar/AvtoNakrutka.php"));
file_put_contents("foydalanuvchi/$ccid/$ex/botlar/Obunachi Lite.php",file_get_contents("botlar/Obunachi Lite.php"));
file_put_contents("foydalanuvchi/$ccid/$ex/botlar/Reklamachi.php",file_get_contents("botlar/Reklamachi.php"));
file_put_contents("foydalanuvchi/$ccid/$ex/botlar/SpecialMember.php",file_get_contents("botlar/SpecialMember.php"));
file_put_contents("foydalanuvchi/$cid/$botuser/botlar/Kinobot.php",file_get_contents("botlar/Kinobot.php"));
file_put_contents("foydalanuvchi/$cid/$botuser/botlar/userinfo.php",file_get_contents("botlar/userinfo.php"));
#mini
mkdir("foydalanuvchi/$ccid/$ex/");
file_put_contents("foydalanuvchi/$ccid/$ex/mini/SarmoyaBot.php",file_get_contents("mini/SarmoyaBot.php"));
file_put_contents("foydalanuvchi/$ccid/$ex/mini/ObunachiBot.php",file_get_contents("mini/ObunachiBot.php"));
file_put_contents("foydalanuvchi/$ccid/$ex/mini/SpecialSMM Lite.php",file_get_contents("mini/SpecialSMM Lite.php"));
file_put_contents("foydalanuvchi/$ccid/$ex/mini/PulBot Lite.php",file_get_contents("mini/PulBot Lite.php"));
file_put_contents("foydalanuvchi/$ccid/$ex/mini/TurfaBot.php",file_get_contents("mini/TurfaBot.php"));
file_put_contents("foydalanuvchi//$ccid/$ex/mini/GramAPIBot.php",file_get_contents("mini/GramAPIBot.php"));
file_put_contents("foydalanuvchi/$ccid/$ex/mini/AvtoNakrutka.php",file_get_contents("mini/AvtoNakrutka.php"));
file_put_contents("foydalanuvchi/$ccid/$ex/mini/Obunachi Lite.php",file_get_contents("mini/Obunachi Lite.php"));
file_put_contents("foydalanuvchi/$ccid/$ex/mini/Reklamachi.php",file_get_contents("mini/Reklamachi.php"));
file_put_contents("foydalanuvchi/$ccid/$ex/mini/SpecialMember.php",file_get_contents("mini/SpecialMember.php"));
file_put_contents("foydalanuvchi/$ccid/$ex/mini/NamozVAQT.php",file_get_contents("mini/NamozVAQT.php"));
file_put_contents("foydalanuvchi/$ccid/$ex/mini/AutoNumber.php",file_get_contents("mini/AutoNumber.php"));
file_put_contents("foydalanuvchi/$ccid/$ex/mini/VideoDown.php",file_get_contents("mini/VideoDown.php"));
}
$get = json_decode(file_get_contents("https://api.telegram.org/bot$tokeni/setwebhook?url=https://".$_SERVER['SERVER_NAME']."/$xostfile/foydalanuvchi/$ccid/$ex/$turi.php"))->result;
if($get){
$til = file_get_contents("foydalanuvchi/hisob/$ccid.til");
$hisob = file_get_contents("foydalanuvchi/hisob/$ccid.txt");
$minus = $hisob - $yangilash;
file_put_contents("foydalanuvchi/hisob/$ccid.txt", $minus);
if($til=="uz"){
bot('editMessageText',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
'text'=>"⏱ <b>Yangilanmoqda...</b>",
'parse_mode'=>'html',
]);
bot('editMessageText',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
'text'=>"⏱ <b>Yangilanmoqda...</b>",
'parse_mode'=>'html',
]);
bot('editmessagetext',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
'text'=>"<b>✅ Botingiz muvaffaqiyatli yangilandi</b>",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"➡️ Botga o'tish",'url'=>"https://t.me/$ex"]],
[['text'=>"◀️ Orqaga",'callback_data'=>"set=$ex"]],
]])
]);
}elseif($til=="ru"){
bot('editMessageText',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
'text'=>"⏱ <b>Обновление...</b>",
'parse_mode'=>'html',
]);
bot('editMessageText',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
'text'=>"⏱ <b>Обновление...</b>",
'parse_mode'=>'html',
]);
bot('editmessagetext',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
'text'=>"<b> ✅ Ваш бот успешно обновлен</b>",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"➡️ Переключиться на бота",'url'=>"https://t.me/$ex"]],
[['text'=>"◀️ Назад",'callback_data'=>"set=$ex"]],
]])
]);
}}}}

if($tx=="◀️ Orqaga" or $tx=="◀️ Назад"){
if(joinchat($cid)=="true"){
if($til=="uz"){
bot('sendMessage',[
'chat_id'=>$cid,
'text'=>"👋 <b>SkyBuilder — Telegram botlar yaratish uchun qulay platforma</b>

🤖 Bu platforma orqali siz <b>hech qanday kod yozmasdan</b> o‘z Telegram botlaringizni <i>tez va oson</i> yaratishingiz, ularni tahrirlashingiz hamda boshqarishingiz mumkin.

⚡️ <b>Nega aynan SkyBuilder?</b>

<blockquote>🔄 Botlar muntazam yangilanib boriladi  
🗂 Barqaror va mukammal ishlaydigan tizim  
🇺🇿 To‘liq o‘zbek tilidagi qulay interfeys  
💬 Doimiy va tezkor qo‘llab-quvvatlash xizmati  
🤖 Barcha jarayonlar avtomatik va tushunarli</blockquote>
👇 <i>Quyidagi menyudan kerakli bo‘limni tanlang:</i>",
'parse_mode'=>"html",
'reply_markup'=>$menyu,
]);
unlink("step/$cid.txt");
}elseif($til=="ru"){
bot('sendMessage',[
'chat_id'=>$cid,
'text'=>"<b>🤖 Здравствуйте!</b>

@$botname поможет вам завести собственного мейкера в сети Telegram!

<b>📢 Следите за новостями:</b> @CreateMaker",
'parse_mode'=>"html",
'reply_markup'=>$rumenyu,
]);
unlink("step/$cid.txt");
}}}

if($tx=="⚙ Sozlamalar" or $tx=="⚙ Настройки"){
if(joinchat($cid)=="true"){
if($til=="uz"){
$uztil = "- (✓)";
$uzku = "uztil";
}else{
$uzku = "uz";
}
if($til=="ru"){
$rutil = "️- (✓)";
$ruku = "rutil";
}else{
$ruku = "ru";
}
if($til=="uz"){
bot('sendMessage',[
'chat_id'=>$cid,
'text'=>"<b>💬 Quyidagi tillardan birini tanlang:</b>",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"🇺🇿O'zbekcha $uztil",'callback_data'=>"$uzku"]],
[['text'=>"🇷🇺Русский $rutil",'callback_data'=>"$ruku"]],
]])
]);
}elseif($til=="ru"){
bot('sendMessage',[
'chat_id'=>$cid,
'text'=>"<b>💬 Выберите один из следующих языков:</b>",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"🇺🇿O'zbekcha $uztil",'callback_data'=>"$uzku"]],
[['text'=>"🇷🇺Русский $rutil",'callback_data'=>"$ruku"]],
]])
]);
}}}

if($data == "uztil" and joinchat($ccid)=="true"){
bot('answerCallbackQuery',[
'callback_query_id'=>$callid,
'text'=>"⚠️ Siz ushbu tildan foydalanyapsiz!",
'show_alert'=>true,
]);
}

if($data == "rutil" and joinchat($ccid)=="true"){
bot('answerCallbackQuery',[
'callback_query_id'=>$callid,
'text'=>"⚠️ Вы используете этот язык!",
'show_alert'=>true,
]);
}

if($data=="ru"){
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('sendMessage',[
'chat_id'=>$ccid,
'text'=>"<b>🤖 Здравствуйте!</b>

@$botname поможет вам завести собственного мейкера в сети Telegram!

<b>📢 Следите за новостями:</b> @CreateMaker",
'parse_mode'=>"html",
'reply_markup'=>$rumenyu,
]);
file_put_contents("foydalanuvchi/hisob/$ccid.til","ru");
}

if($data=="uz"){
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('sendMessage',[
'chat_id'=>$ccid,
'text'=>"👋 <b>SkyBuilder — Telegram botlar yaratish uchun qulay platforma</b>

🤖 Bu platforma orqali siz <b>hech qanday kod yozmasdan</b> o‘z Telegram botlaringizni <i>tez va oson</i> yaratishingiz, ularni tahrirlashingiz hamda boshqarishingiz mumkin.

⚡️ <b>Nega aynan SkyBuilder?</b>

<blockquote>🔄 Botlar muntazam yangilanib boriladi  
🗂 Barqaror va mukammal ishlaydigan tizim  
🇺🇿 To‘liq o‘zbek tilidagi qulay interfeys  
💬 Doimiy va tezkor qo‘llab-quvvatlash xizmati  
🤖 Barcha jarayonlar avtomatik va tushunarli</blockquote>
👇 <i>Quyidagi menyudan kerakli bo‘limni tanlang:</i>",
'parse_mode'=>"html",
'reply_markup'=>$menyu,
]);
file_put_contents("foydalanuvchi/hisob/$ccid.til","uz");
}

if($tx=="test" or $tx=="☎️ Помощь"){
if(joinchat($fid)=="true"){
if($til=="uz"){
bot('sendMessage',[
'chat_id'=>$cid,
'text'=>"<b>📝 Murojaat matnini yuboring:</b>",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'resize_keyboard'=>true,
'keyboard'=>[
[['text'=>"◀️ Orqaga"]],
]])
]);
file_put_contents("step/$cid.txt","suport");
}elseif($til=="ru"){
bot('sendMessage',[
'chat_id'=>$cid,
'text'=>"<b>📝 Отправить текст помощи:</b>",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'resize_keyboard'=>true,
'keyboard'=>[
[['text'=>"◀️ Назад"]],
]])
]);
file_put_contents("step/$cid.txt","suport");
}}}

if($userstep=="suport"){
if($tx=="◀️ Orqaga" or $tx=="◀️ Назад"){
unlink("step/$cid.txt");
}else{
bot('sendMessage',[
'chat_id'=>$builder24,
'text'=>"<b>📨 Yangi murojat keldi:</b> <a href='tg://user?id=$cid'>$cid</a>

<b>📑 Murojat matni:</b> $tx",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"Javob yozish",'callback_data'=>"yozish=$cid"]],
]])
]);
if($til=="uz"){
bot('sendMessage',[
'chat_id'=>$cid,
'text'=>"<b>✅ Murojaatingiz yuborildi.</b>

<i>Tez orada javob qaytaramiz!</i>",
'parse_mode'=>'html',
'reply_markup'=>$menyu,
]);
unlink("step/$cid.txt");
}elseif($til=="ru"){
bot('sendMessage',[
'chat_id'=>$cid,
'text'=>"<b>✅ Ваше сообщение отправлено.</b>

<i>скоро ответим!</i>",
'parse_mode'=>'html',
'reply_markup'=>$rumenyu,
]);
}}}

if(mb_stripos($data,"yozish=")!==false){
$odam=explode("=",$data)[1];
bot('editMessageText',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
'text'=>"⏱ <b>Yuklanmoqda...</b>",
'parse_mode'=>'html',
]);
bot('editMessageText',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
'text'=>"⏱ <b>Yuklanmoqda...</b>",
'parse_mode'=>'html',
]);
bot('deleteMessage',[
'chat_id'=>$ccid,
'message_id'=>$cmid,
]);
bot('sendMessage',[
'chat_id'=>$ccid,
'text'=>"<b>Javob matnini yuboring:</b>",
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'resize_keyboard'=>true,
'keyboard'=>[
[['text'=>"◀️ Orqaga"]],
]])
]);
file_put_contents("step/$ccid.txt","javob");
file_put_contents("step/$ccid.javob","$odam");
}

if($userstep=="javob"){
if($tx=="◀️ Orqaga"){
unlink("step/$cid.txt");
unlink("step/$cid.javob");
}else{
$murojat=file_get_contents("step/$cid.javob");
bot('sendMessage',[
'chat_id'=>$murojat,
'text'=>"<b>☎️ Administrator:</b>

$tx",
'parse_mode'=>'html',
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"Javob yozish",'callback_data'=>"boglanish"]],
]])
]);
bot('sendMessage',[
'chat_id'=>$builder24,
'text'=>"<b>Javob yuborildi</b>",
'parse_mode'=>"html",
'reply_markup'=>$menyu,
]);
unlink("step/$murojat.murojat");
unlink("step/$cid.txt");
unlink("step/$cid.javob");
}}

?>
