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
                font-family: Arial;
        }
        @page { 
            size: 570pt 800pt; 
            padding: 0;
            margin: 0;
        }
        span.cls_002{font-family:Arial,serif;font-size:24.1px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
        div.cls_002{font-family:Arial,serif;font-size:24.1px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
        span.cls_003{font-family:Arial,serif;font-size:14.1px;color:rgb(0,0,0);font-weight:normal;font-style:normal;text-decoration: none}
        div.cls_003{font-family:Arial,serif;font-size:14.1px;color:rgb(0,0,0);font-weight:normal;font-style:normal;text-decoration: none}
        span.cls_004{font-family:Arial,serif;font-size:14.1px;color:rgb(74,78,77);font-weight:normal;font-style:normal;text-decoration: none}
        div.cls_004{font-family:Arial,serif;font-size:14.1px;color:rgb(74,78,77);font-weight:normal;font-style:normal;text-decoration: none}
        span.cls_005{font-family:Arial,serif;font-size:24.1px;color:rgb(187,28,37);font-weight:normal;font-style:normal;text-decoration: none}
        div.cls_005{font-family:Arial,serif;font-size:24.1px;color:rgb(187,28,37);font-weight:normal;font-style:normal;text-decoration: none}
        span.cls_006{font-family:Arial,serif;font-size:47.5px;color:rgb(187,28,37);font-weight:normal;font-style:normal;text-decoration: none}
        div.cls_006{font-family:Arial,serif;font-size:47.5px;color:rgb(187,28,37);font-weight:normal;font-style:normal;text-decoration: none}
        span.cls_007{font-family:Arial,serif;font-size:18.1px;color:rgb(0,0,0);font-weight:normal;font-style:normal;text-decoration: none}
        div.cls_007{font-family:Arial,serif;font-size:18.1px;color:rgb(0,0,0);font-weight:normal;font-style:normal;text-decoration: none}
        span.cls_008{font-family:Arial,serif;font-size:18.1px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
        div.cls_008{font-family:Arial,serif;font-size:18.1px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
        span.cls_009{font-family:Arial,serif;font-size:14.6px;color:rgb(74,78,77);font-weight:normal;font-style:normal;text-decoration: none}
        div.cls_009{font-family:Arial,serif;font-size:14.6px;color:rgb(74,78,77);font-weight:normal;font-style:normal;text-decoration: none}
        span.cls_010{font-family:Arial,serif;font-size:10.1px;color:rgb(74,78,77);font-weight:normal;font-style:normal;text-decoration: none}
        div.cls_010{font-family:Arial,serif;font-size:10.1px;color:rgb(74,78,77);font-weight:normal;font-style:normal;text-decoration: none}
    </style>
<body style="background-image: url({{$background}}); width: 100%; height: 100%;">
<div style="padding-top: 70px;padding-left: 70px;padding-right: 70px;">
    <div style="margin-bottom: 130px; text-align: center;"><span class="cls_002">PHARMACISTS COUNCIL OF NIGERIA</span></div>
    <div style="margin-bottom: 20px; text-align: center;" class="cls_003"><span class="cls_003">TIERED PATENT AND PROPRIETARY MEDICINES VENDOR'S LICENCE</span></div>
    
    <div style="text-align: center; margin-bottom: 25px;"><img src="{{$photo}}" alt="" style="width: 170px; height: 170px; border-radius: 20px;"></div>
    
    <div style="position: absolute; top: 250px;">
    <div style="margin-bottom: 10px; text-align: right;" class="cls_004"><span class="cls_004">LICENCE NUMBER</span></div>
    <div style="margin-bottom: 80px; text-align: right;" class="cls_005"><span class="cls_005">{{$data['licence']}}</span></div>
    </div>

    <div style="margin-bottom: 10px; text-align: center;" class="cls_006"><span class="cls_006">{{strtoupper($data['meptp_application']['tier']['name'])}}</span></div>
    <div style="margin-bottom: 10px; text-align: center;" class="cls_007"><span class="cls_007">This licence is hereby granted to</span></div>
    <div style="margin-bottom: 10px; text-align: center;" class="cls_008"><span class="cls_008">{{strtoupper($data['user']['firstname'])}} {{strtoupper($data['user']['lastname'])}}</span></div>
    <div style="margin-bottom: 5px; text-align: center;" class="cls_007"><span class="cls_007">to sell Patent and Proprietary Medicines shown</span></div>
    <div style="margin-bottom: 5px; text-align: center;" class="cls_007"><span class="cls_007">in the approved list in premises situated at:</span></div>
    <div style="margin-bottom: 5px; text-align: center;" class="cls_008"><span class="cls_008">{{strtoupper($data['meptp_application']['shop_address'])}}</span></div>
    <div style="margin-bottom: 5px; text-align: center;" class="cls_008"><span class="cls_008">{{$data['user']['user_lga']['name']}} L.G.A.</span></div>
    <div style="margin-bottom: 100px; text-align: center;" class="cls_008"><span class="cls_008">{{$data['user']['user_state']['name']}} STATE</span></div>

    <div style="margin-bottom: 10px; text-align: center;" class="cls_009"><span class="cls_009">REGISTRAR</span></div>
    <div style="margin-bottom: 1px; text-align: center;" class="cls_010"><span class="cls_010">DATED THIS {{strtoupper($data['updated_at']->format('jS'))}} DAY OF  {{strtoupper($data['updated_at']->format('M'))}}, {{$data['updated_at']->format('Y')}}</span></div>
    <div style="margin-bottom: 132px; text-align: center;" class="cls_010"><span class="cls_010">LICENCE EXPIRES ON {{strtoupper(\Carbon\Carbon::parse($data['expires_at'])->format('jS'))}} {{strtoupper(\Carbon\Carbon::parse($data['expires_at'])->format('M'))}}, {{\Carbon\Carbon::parse($data['expires_at'])->format('Y')}}</span></div>
    
    <div style="margin-bottom: 3px; text-align: center;" class="cls_010"><span class="cls_010">FEDERAL REPUBLIC OF NIGERIA</span></div>
    <div style="margin-bottom: 3px; text-align: center;" class="cls_010"><span class="cls_010">NOT-TRANSFERABLE</span></div>
    <div style="margin-bottom: 3px; text-align: center;" class="cls_010"><span class="cls_010">VALID FOR ONLY THE APPROVED LOCATION STATED ABOVE</span></div>
</div>

</body>
</html>
