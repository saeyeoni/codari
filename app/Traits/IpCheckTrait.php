<?php

namespace App\Traits;

trait ipCheckTrait
{
  public function ipCheck(){
    $request = request();
    $ip = $request->ip();
    $key = "2020030911132280329920";
    $dataFormat = "json";
    $url ="http://whois.kisa.or.kr/openapi/ipascc.jsp?query=".$ip."&key=".$key."&answer=".$dataFormat."";
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url); curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch,CURLOPT_NOSIGNAL, 1);
    //curl_setopt($ch,CURLOPT_POST, 1); //Method를 POST로 지정, 이 라인이 아예 없으면 GET

    $data = curl_exec($ch);
    $curl_errno = curl_errno($ch);
    $curl_error = curl_error($ch);

    curl_close($ch);
    $decodeJsonData = json_decode($data, true);
    dd($decodeJsonData);
    return ($decodeJsonData['whois']['countryCode']);
  }

}
