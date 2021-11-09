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

        <div style="position: absolute; top: 100px;">
            <div style="margin-bottom: 10px; text-align: right;"><span>LICENCE NUMBER</span></div>
            <div style="text-align: right; font-size: 20px; color: #bb1c25;"><span>{{$data['licence']}}</span></div>
        </div>
        
        <div style="position: absolute; top: 240px;">
            @if($type == 'community_pharmacy_renewal')
            <div style="font-family: 'OLDENGL'; margin-bottom: 20px; font-size: 38px; text-align: center;  color: #bb1c25;"><span>Certificate of Registration/Retention of Community Pharmacy Premises</span></div>
            @endif
            @if($type == 'distribution_premises_renewal')
            <div style="font-family: 'OLDENGL'; margin-bottom: 20px; font-size: 38px; text-align: center;  color: #bb1c25;"><span>Certificate of Registration/Retention of Distribution Premises</span></div>
            @endif
            @if($type == 'manufacturing_premises_renewal')
            <div style="font-family: 'OLDENGL'; margin-bottom: 20px; font-size: 38px; text-align: center;  color: #bb1c25;"><span>Certificate of Registration/Retention ofManufacturing Premises</span></div>
            @endif

            <div style="margin-bottom: 20px; font-size: 14px; text-align: center;"><span>The premises situated at:</span></div>
            <div style="margin-bottom: 20px; font-size: 18px; text-align: center; color: #bb1c25; font-weight: bold;"><span>{{ucwords($data['other_registration']['company']['address'])}} ,{{ucwords($data['other_registration']['company']['company_lga']['name'])}}, {{ucwords($data['other_registration']['company']['company_state']['name'])}}</span></div>

            <div style="margin-bottom: 20px; font-size: 14px; text-align: center;"><span>and owned by,</span></div>
            <div style="margin-bottom: 20px; font-size: 18px; text-align: center; color: #bb1c25; font-weight: bold;"><span>{{ucwords($data['other_registration']['company']['name'])}}</span></div>

            <div style="margin-bottom: 20px; font-size: 14px; text-align: center;"><span>under Superintendent Pharmacist:</span></div>
            <div style="margin-bottom: 20px; font-size: 18px; text-align: center; color: #bb1c25; font-weight: bold;"><span>Pharm. {{ucwords($data['user']['firstname'])}} {{ucwords($data['user']['lastname'])}}</span></div>
        
            @if($type == 'community_pharmacy_renewal')
            <div style="margin-bottom: 20px; font-size: 19px; text-align: center;  color: #505050;"><span>was on <span style="font-weight: bold;">{{strtoupper($data['updated_at']->format('jS'))}} DAY OF  {{strtoupper($data['updated_at']->format('M'))}}, {{$data['updated_at']->format('Y')}}</span> duly registered for the purpose of mixing, compounding, preparing, counselling and selling of drugs, medicines and poisons to patients in accordance with the provisions of the Pharmacists Council of Nigeria Act, Cap P17, LFN, 2004.</span></div>
            @endif
            @if($type == 'distribution_premises_renewal')
            <div style="margin-bottom: 20px; font-size: 19px; text-align: center;  color: #505050;"><span>was on <span style="font-weight: bold;">{{strtoupper($data['updated_at']->format('jS'))}} DAY OF  {{strtoupper($data['updated_at']->format('M'))}}, {{$data['updated_at']->format('Y')}}</span> duly registered for theimportation only of drugs, medicines and poisons to registereddistributors, wholesalers and hospitals in accordance with theprovisions of the Pharmacists Council of Nigeria Act, Cap PI7,LFN, 2004.</span></div>
            @endif
            @if($type == 'manufacturing_premises_renewal')
            <div style="margin-bottom: 20px; font-size: 19px; text-align: center;  color: #505050;"><span>was on <span style="font-weight: bold;">{{strtoupper($data['updated_at']->format('jS'))}} DAY OF  {{strtoupper($data['updated_at']->format('M'))}}, {{$data['updated_at']->format('Y')}}</span> duly registered for themanufacturing and sales of such drugs, medicines and poisonsso manufactured to registered distributors, wholesalers andhospitals in accordance with the provisions of the PharmacistsCouncil of Nigeria Act, Cap P17, LFN, 2004</span></div>
            @endif
        </div>
        
        <div style="position: absolute; top: 760px;">
            <div style="margin-bottom: 20px; font-size: 16px; text-align: center;"><span>REGISTRAR / SECRETARY</span></div>
            <div style="font-size: 10px; text-align: center;"><span>DATED THIS {{strtoupper($data['updated_at']->format('jS'))}} DAY OF  {{strtoupper($data['updated_at']->format('M'))}}, {{$data['updated_at']->format('Y')}} LICENCE EXPIRES ON {{strtoupper(\Carbon\Carbon::parse($data['expires_at'])->format('jS'))}} {{strtoupper(\Carbon\Carbon::parse($data['expires_at'])->format('M'))}}, {{\Carbon\Carbon::parse($data['expires_at'])->format('Y')}}</span></div>
        </div>
        
        <div style="position: absolute; top: 920px;">
            <div style="font-size: 10px; text-align: center;"><span>FEDERAL REPUBLIC OF NIGERIA</span></div>
        </div>
       
        <div style="position: absolute; top: 1000px;">
            <div style="font-size: 10px; text-align: right; color: #fff;"><span>FEDERAL REPUBLIC OF NIGERIA</span></div>
            <div style="font-size: 10px; text-align: right; color: #fff;"><span>VALID FOR ONLY THE APPROVED LOCATION STATED ABOVE</span></div>
        </div>
    </div>

</body>
</html>
