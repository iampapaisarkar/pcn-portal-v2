<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Licence - {{$data['renewal_year']}} ({{$data['licence']}}) </title>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <style type="text/css">
        body{
                font-family: sans-serif;
        }
        @font-face {
            font-family: 'OLDENGL';
            src: url('{{ storage_path('fonts/OLDENGL.TTF') }}') format("truetype");
            font-weight: 400;
            font-style: normal;
        }
        @page { 
            size: 570pt 800pt; 
            padding: 0;
            margin: 0;
        }
    </style>
<body style="background-image: url({{$background}}); width: 100%; height: 100%;">
    <div style="padding-top: 32px;padding-left: 70px;padding-right: 70px;">
        <div style="text-align: center; font-weight: bold; font-size: 30px;"><span>PHARMACISTS COUNCIL OF NIGERIA</span></div>
        
        <div style="position: absolute; top: 75px; left: 45px;">
            <img src="{{$photo}}" style="width: 170px; height: 170px; border-radius: 20px;" />
        </div>

        <div style="margin-top: 50px;">
            <div style="margin-bottom: 10px; text-align: right;"><span>LICENCE NUMBER</span></div>
            <div style="text-align: right; font-size: 20px; color: #bb1c25;"><span>{{$data['licence']}}</span></div>
        </div>
        
        <div style="margin-top: 100px;">
            <div style="font-family: 'OLDENGL'; margin-bottom: 20px; font-size: 38px; text-align: center;  color: #bb1c25;"><span>Patent and Proprietary MedicinesVendor's Licence</span></div>
            
            <div style="margin-bottom: 14px; font-size: 14px; text-align: center;"><span>Licence is hereby granted to</span></div>
            <div style="margin-bottom: 14px; font-size: 16px; text-align: center; color: #bb1c25; font-weight: bold;"><span>{{ucwords($data['user']['firstname'])}} {{ucwords($data['user']['lastname'])}}</span></div>

            <div style="margin-bottom: 14px; font-size: 14px; text-align: center;"><span>to sell Patent and Proprietary Medicines shown in the approvedlist in premises situated at:</span></div>
            <div style="margin-bottom: 14px; font-size: 16px; text-align: center; color: #bb1c25; font-weight: bold;"><span>{{ucwords($data['user']['shop_address'])}}, {{ucwords($data['user']['user_lga']['name'])}} LGA, {{ucwords($data['user']['user_state']['name'])}} STATE</span></div>
        </div>
        
        <div style="margin-top: 250px;">
            <div style="margin-bottom: 20px; font-size: 16px; text-align: center;"><span>REGISTRAR / SECRETARY</span></div>
            <div style="font-size: 10px; text-align: center;"><span>DATED THIS {{strtoupper($data['updated_at']->format('jS'))}} DAY OF  {{strtoupper($data['updated_at']->format('M'))}}, {{$data['updated_at']->format('Y')}} LICENCE EXPIRES ON {{strtoupper(\Carbon\Carbon::parse($data['expires_at'])->format('jS'))}} {{strtoupper(\Carbon\Carbon::parse($data['expires_at'])->format('M'))}}, {{\Carbon\Carbon::parse($data['expires_at'])->format('Y')}}</span></div>
        </div>
        
        <div style="margin-top: 105px;">
            <div style="font-size: 10px; text-align: center;"><span>FEDERAL REPUBLIC OF NIGERIA</span></div>
        </div>
       
        <div style="margin-top: 60px;">
            <div style="font-size: 10px; text-align: right; color: #fff;"><span>FEDERAL REPUBLIC OF NIGERIA</span></div>
            <div style="font-size: 10px; text-align: right; color: #fff;"><span>VALID FOR ONLY THE APPROVED LOCATION STATED ABOVE</span></div>
        </div>
    </div>

</body>
</html>
