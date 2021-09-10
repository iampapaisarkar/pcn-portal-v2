<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Examination Card (Batch: {{$data->batch->batch_no}}-{{$data->batch->year}}) - {{env('APP_NAME')}} </title>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
        <style type="text/css">
        body{
                font-family: Arial;
        }
        @page { 
            size: 285pt 400pt;
            margin: 0;
            padding: 0;
        }
        .cls_003{font-family:Arial,serif;font-size:14.2px;color:rgb(65,64,121);font-weight:bold;font-style:normal;text-decoration: none; text-align: center;}
        .cls_003{font-family:Arial,serif;font-size:14.2px;color:rgb(65,64,121);font-weight:bold;font-style:normal;text-decoration: none; text-align: center;}
        .cls_004{font-family:Arial,serif;font-size:24.3px;color:rgb(219,35,31);font-weight:bold;font-style:normal;text-decoration: none; text-align: center;}
        .cls_004{font-family:Arial,serif;font-size:24.3px;color:rgb(219,35,31);font-weight:bold;font-style:normal;text-decoration: none; text-align: center;}
        .cls_005{font-family:Arial,serif;font-size:14.2px;color:rgb(219,35,31);font-weight:normal;font-style:normal;text-decoration: none; text-align: center;}
        .cls_005{font-family:Arial,serif;font-size:14.2px;color:rgb(219,35,31);font-weight:normal;font-style:normal;text-decoration: none; text-align: center;}
        .cls_002{font-family:Arial,serif;font-size:24.3px;color:rgb(65,64,121);font-weight:bold;font-style:normal;text-decoration: none; text-align: center;}
        .cls_002{font-family:Arial,serif;font-size:24.3px;color:rgb(65,64,121);font-weight:bold;font-style:normal;text-decoration: none; text-align: center;}
        .cls_006{font-family:Arial,serif;font-size:16.2px;color:rgb(65,64,121);font-weight:bold;font-style:normal;text-decoration: none; text-align: center;}
        .cls_006{font-family:Arial,serif;font-size:16.2px;color:rgb(65,64,121);font-weight:bold;font-style:normal;text-decoration: none; text-align: center;}
        .cls_007{font-family:Arial,serif;font-size:16.2px;color:rgb(65,64,121);font-weight:normal;font-style:normal;text-decoration: none; text-align: center;}
        .cls_007{font-family:Arial,serif;font-size:16.2px;color:rgb(65,64,121);font-weight:normal;font-style:normal;text-decoration: none; text-align: center;}
        .cls_008{font-family:Arial,serif;font-size:24.3px;color:rgb(65,64,121);font-weight:normal;font-style:normal;text-decoration: none; text-align: center;}
        .cls_008{font-family:Arial,serif;font-size:24.3px;color:rgb(65,64,121);font-weight:normal;font-style:normal;text-decoration: none; text-align: center;}
        .cls_009{font-family:Arial,serif;font-size:16.1px;color:rgb(255,254,255);font-weight:normal;font-style:normal;text-decoration: none; text-align: center;}
        .cls_009{font-family:Arial,serif;font-size:16.1px;color:rgb(255,254,255);font-weight:normal;font-style:normal;text-decoration: none; text-align: center;}
        </style>
    <body style="background-image: url({{$background}}); width: 100%; height: 100%;">
        <div style="text-align: center; margin-bottom: 10px; margin-top: 30px;"><img src="{{$photo}}" alt="" style="width: 170px; height: 170px; border-radius: 20px;"></div>
        <div style="text-align: center; margin-bottom: 10px;"><span class="cls_003">{{$data->user->firstname}} {{$data->user->lastname}}</span></div>
        <div style="text-align: center; margin-bottom: 10px;"><span class="cls_004">{{strtoupper($data->tier->name)}}</span></div>
        <div style="text-align: center; margin-bottom: 10px;"><span class="cls_005">{{$data->indexNumber->arbitrary_1 .'/'. $data->indexNumber->arbitrary_2 .'/'. $data->indexNumber->batch_year .'/'. $data->indexNumber->state_code .'/'. $data->indexNumber->school_code .'/'. $data->indexNumber->tier .'/'. $data->indexNumber->id}}</span></div>
        <div style="text-align: center; margin-bottom: 10px;"><span class="cls_002">Batch: {{$data->batch->batch_no}}-{{$data->batch->year}}</span></div>
        <div style="text-align: center; margin-bottom: 10px;"><span class="cls_006">Training Centre:</span></div>
        <div style="text-align: center; margin-bottom: 10px;"><span class="cls_007">{{$data->school->name}}</span></div>
        <div style="text-align: center; margin-bottom: 10px;"><span class="cls_008">{{$data->user_state->name}}</span> </div>
        <div style="text-align: left; margin-top: 66px; margin-left: 15px;"><span class="cls_009">MEPTP Examination Card</span></div>
    </body>
</html>
