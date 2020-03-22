<?php
if (!defined('RA')) {
    die('Tidak boleh diakses langsung.');
}

/*
Contoh penggunaan :
~~~~~~~~~~~~~~~~~~~~~
Kirim Aksi
----------
(typing, upload_photo, record_video, upload_video, record_audio, upload_audio, upload_document, find_location) :
    sendApiAction($chatid);
    sendApiAction($chatid, 'upload_photo');

Kirim Pesan :
----------
    sendApiMsg($chatid, 'pesan');
    sendApiMsg($chatid, 'pesan *tebal*', false, 'Markdown');

Kirim Markup Keyboard :
----------
    $keyboard = [
        [ 'tombol 1', 'tombol 2' ],
        [ 'tombol 3', 'tombol 4' ],
        [ 'tombol 5' ]
    ];
    sendApiKeyboard($chatid, 'tombol pilihan', $keyboard);
Kirim Inline Keyboard
----------
    $inkeyboard = [
        [
            ['text'=>'tombol 1', 'callback_data' => 'data 1'],
            ['text'=>'tombol 2', 'callback_data' => 'data 2']
        ],
        [
            ['text'=>'tombol akhir', 'callback_data' => 'data akhir']
        ]
    ];
    sendApiKeyboard($chatid, 'tombol pilihan', $inkeyboard, true);

editMessageText
----------
    editMessageText($chatid, $message_id, $text, $inkeyboard, true);

Menyembunyikan keyboard :
----------
    sendApiHideKeyboard($chatid, 'keyboard off');

kirim sticker
----------
    sendApiSticker($chatid, 'BQADAgADUAADxKtoC8wBeZm11cjsAg')
Dan Lain-lain :-D
~~~~~~~~~~~~~~~~~~~~~
*/

function prosesApiMessage($sumber)
{
    $updateid = $sumber['update_id'];
   // if ($GLOBALS['debug']) mypre($sumber);
    if (isset($sumber['message'])) {
        $message = $sumber['message'];
        if (isset($message['text'])) {
            prosesPesanTeks($message);
        } elseif (isset($message['sticker'])) {
            prosesPesanSticker($message);
        } else {
            // gak di proses silakan dikembangkan sendiri
        }
    }
    if (isset($sumber['callback_query'])) {
        prosesCallBackQuery($sumber['callback_query']);
    }
    return $updateid;
}

function prosesPesanSticker($message)
{
    // if ($GLOBALS['debug']) mypre($message);
}
function prosesCallBackQuery($message)
{
    $message_id = $message['message']['message_id'];
    $chatid = $message['message']['chat']['id'];
    $data = $message['data'];
    editMessageText($chatid, $message_id, '*pesan sedang aku proses.. 👀 *');
    $messageupdate = $message['message'];
    $messageupdate['text'] = $data;
    deleteMsg($chatid, $message_id);
    prosesPesanTeks($messageupdate);
    //editMessageText($chatid, $message_id, '*✔️ Selesai!*');
    
}

function tgl_indo($tgl){
 date_default_timezone_set('Asia/Jakarta'); 
 $seminggu = array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu");
 $hari = date("w");
 $hari_ini = $seminggu[$hari];
 $nama_bln=array(1=> "Januari", "Februari", "Maret", "April", "Mei", 
    "Juni", "Juli", "Agustus", "September", 
    "Oktober", "November", "Desember");

 $tanggal = substr($tgl,8,2);
 $bulan = getBulan(substr($tgl,5,2));
 $tahun = substr($tgl,0,4);
 $jam = substr($tgl,11,2);
 $menit = substr($tgl,14,2);
 $detik = substr($tgl,17,2);
 return $tanggal.' '.$bulan.' '.$tahun.' || '.$jam.':'.$menit.':'.$detik;		 
}

function getBulan($bln){
    switch ($bln){
       case 1: 
       return "Jan";
       break;
       case 2:
       return "Feb";
       break;
       case 3:
       return "Mar";
       break;
       case 4:
       return "Apr";
       break;
       case 5:
       return "May";
       break;
       case 6:
       return "Jun";
       break;
       case 7:
       return "Jul";
       break;
       case 8:
       return "Aug";
       break;
       case 9:
       return "Sept";
       break;
       case 10:
       return "Oct";
       break;
       case 11:
       return "Nov";
       break;
       case 12:
       return "Dec";
       break;
   }
}

function curl_download($Url){
    if (!function_exists('curl_init')){
        die('Sorry cURL is not installed!');
    }
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $Url);
    curl_setopt($ch, CURLOPT_REFERER, "https://google.com/stats");
    curl_setopt($ch, CURLOPT_USERAGENT, "MozillaXYZ/1.0");
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 15);
    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
}

function prosesPesanTeks($message)
{
    // if ($GLOBALS['debug']) mypre($message);
    $pesan = $message['text'];
    $chatid = $message['chat']['id'];
    $fromid = $message['from']['id'];
    $nama = $message['from']['first_name'];
    $nama2 = $message['from']['last_name'];
    $username = $message['from']['username'];
    $wktkirim = $message['date'];
    $wktnow = time();
    $bagi=1000;
    $hitung = $wktkirim-$wktnow;
    
    switch (true) {       
        case $pesan == '/start':
        sendApiAction($chatid, 'typing');
        $text = "*🔢 Test Bot....!*\n\n";
        $text .= "berhasil -> * (success!) *\n";
        $text .= "ID kamu adalah".$fromid;
        sendApiMsg($chatid, $text);
        break;
        case $pesan == '/starts':
        if ($fromid = 'ID_Telegram-mu') {
            sendApiAction($chatid, 'typing');

            $curl = curl_init();
            curl_setopt_array($curl, array(
              CURLOPT_URL => "https://api.byu.id/api/profile/xxxx",
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "GET",
              CURLOPT_HTTPHEADER => array(
                "msisdn: 61815xxxxxxx",
                "Content-Type: application/json",
                "Authorization: Bearer ISIKAN_BEARER_TOKEN_DISINI"
            ),
          ));
            $response = curl_exec($curl);
            curl_close($curl);
            $json1 = json_decode($response,true);

            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://api.byu.id/api/planRemaining",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array(
                    "msisdn: 61815xxxxxxx",
                    "Content-Type: application/json",
                    "Authorization: Bearer ISIKAN_BEARER_TOKEN_DISINI"
                ),
            ));
            $response = curl_exec($curl);
            curl_close($curl);
            $json2 = json_decode($response,true);
            
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://api.byu.id/api/inbox",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array(
                    "msisdn: 61815xxxxxxx",
                    "Content-Type: application/json",
                    "Authorization: Bearer ISIKAN_BEARER_TOKEN_DISINI"
                ),
            ));
            $response = curl_exec($curl);
            curl_close($curl);
            $json3 = json_decode($response,true);


                //INI SEKAT BIAR GAPUSHINK


            $text = "*Hello ".$json1['data']['name']."!, this is your by.U account*\n\n";

                $sensor = $json1['data']['phone'];
                $hitungsensor = strlen($sensor) - 9;
                $sensortampil = substr_replace($sensor, str_repeat('x', $hitungsensor), 10, $hitungsensor);
            $text .= "💳 Your phone number: `".$sensortampil."`\n";

                $tibanaktif1 = $json1['data']['created_at'];
                $tibanaktif2 = str_replace("T"," ","$tibanaktif1");
                $tibanaktif3 = str_replace(".000000Z", "", $tibanaktif2);
            $text .= "👤 Status: `Actived` (Active since ".$tibanaktif3.")\n";
            $text .= "💰 Credit: `Rp ".$json2['total']['credit']['total_offering']."`\n\n";

            $text .= "*📊 Data Plan*\n";
                $hitungplan = count($json2['detail']['data_plan']);
                for ($i=0; $i < $hitungplan; $i++) {
                $plan = $json2['detail']['data_plan'][$i];
            $text .= "*•".$plan['title']."*\n";
            $text .= "Total Quota/Used Quota: `".$plan['totalOffering']."/".$plan['used']."`\n";
            $text .= "Remaining: `".$plan['remaining']."GB`\n\n";
                }

            $text .= "*📊 Addon Plan*\n";
                $hitungaddon = count($json2['detail']['data_addon']);
                for ($i=0; $i < $hitungaddon; $i++) {
                $addon = $json2['detail']['data_addon'][$i];
            $text .= "*•".$addon['title']."*\n";
            $text .= "Total Quota/Used Quota: `".$addon['totalOffering']."/".$addon['used']."`\n";
            $text .= "Remaining: `".$addon['remaining']."GB`\n\n";
                }

            $text .= "*📊 Voice Plan*\n";
                $hitungvoice = count($json2['detail']['voice']);
                for ($i=0; $i < $hitungvoice; $i++) {
                $voice = $json2['detail']['voice'][$i];
            $text .= "*•".$voice['title']."*\n";
            $text .= "Total Quota/Used Quota: `".$voice['totalOffering']."/".$voice['used']."`\n";
            $text .= "Remaining: `".$voice['remaining'];
                if ($voice['remaining'] > 1) {
                    $text .= " minutes`\n\n";
                } else {
                    $text .= " minute`\n\n";
                }
                }

            $text .= "\n\n📩 *Last Inbox*\n";
                if ($json3['data'][0]['hasRead'] == 1) {
                    $wisurung = "Already read";
                } else {
                    $wisurung = "Unread";
                }
            $text .= "Message ID: `".$json3['data'][0]['id']."`\n";
            $text .= "Title: *".$json3['data'][0]['title']."*\n";
            $text .= "Message: ".$json3['data'][0]['content']."\n";
            $text .= "Time received: `".$json3['data'][0]['timestamp']."`\n";
            
            $text .= "`Processed in ".$hitung." seconds`";
            sendApiMsg($chatid, $text);
        } else {
                die();
        }
        break;
    }
}
