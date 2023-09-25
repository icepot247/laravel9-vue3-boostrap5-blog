<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Ayat;
use App\Services\Context;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class QuarnController extends BaseController
{
    public function search(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'query' => 'required|string',
            'lang' => 'required|string',
        ]);
        if ($validator->fails()) {
            foreach ($validator->messages()->getMessages() as $messages) {
                return $this->sendError(901, $messages[0]);
            }
        }else{

            $lang = $request->get('lang');
            $query = trim($request->get('query'));

//            $question = 'কে আকাশ থেকে পানি বর্ষণ করেন ও পৃথিবীকে মৃত্যুর পরে সঞ্জীবিত করেন?';

            $contextObj = new Context($lang);
            $keys = $contextObj->extractKeyWords($query);
            $keywords = implode(', ', $keys);
            $keywordsLike =  implode(' | ', $keys);
            $matchColumn = ($lang == 'BN')?'ayat_bn':'ayat_en';

            $data =  Ayat::selectRaw("*, MATCH(ayat_bn)AGAINST('$keywords')")
                ->whereRaw("MATCH($matchColumn)AGAINST('$keywords')")
                ->whereRaw("$matchColumn RLIKE '$keywordsLike'")
                ->orderBy("MATCH(ayat_bn)AGAINST('$keywords')", 'desc')
                ->orderBy('sura_id', 'asc')
                ->get();

            $context = "";
            if($data){
                foreach ($data as $d){
                    $context .= $d->ayat_bn.'। ';
                }
            }

            $answer = $this->req('POST', "http://127.0.0.1:5000/api/nlp/qa", [ "Content-Type: application/json"], [ 'query'=>$query, 'context'=>$context ]);

            return $this->sendSuccess(
                'Data found',
                [
                    'keywords'=>$keywords,
                    'data' => $data,
                    'lang'=>$lang,
                    'query'=>$query,
                    'context'=>$context,
                    'answer'=>json_decode($answer)
                ]
            );
        }
    }

    public function req($method='GET', $url=null, $header=[], $params=[] ){
        $url = (strtoupper($method) == 'GET' && count($params)>0) ? sprintf("%s?%s", $url, http_build_query($params)) : $url;

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        if(strtoupper($method) == 'POST'){
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
        }
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $result = curl_exec($ch);
        if(curl_errno($ch)){
            $error = curl_error($ch);
        }else{
            $error = false;
        }
        curl_close($ch);

        return $result;
    }


    public function aiCall($query, $context){
        $url = "https://api-inference.huggingface.co/models/sagorsarker/mbert-bengali-tydiqa-qa";
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $headers = array(
            "Content-Type: application/json",
            "Authorization: Bearer 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",
        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
//        "question": "কার কাছে আশ্রয় চাইব",


        $data = '{
                "inputs": { 
                    "question": "'.$query.'",
                    "context": $context
                 }
             }';

        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        //for debug only!
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $resp = curl_exec($curl);
        curl_close($curl);

        $data = json_decode($resp);
        return isset($data->answer)?$data->answer:'';
    }

}
