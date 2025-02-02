<?php
    if (!isset($_POST['phone'])) {
        return error_log("dosen't Recive a Phone Number");
    };

    $phone = $_POST['phone'];
    $name = $_POST['name'];


    // echo($phone);
    $url = 'https://graph.facebook.com/v15.0/545202698675840/messages';
    $token = 'EAAVccrv3Qa0BO6GdNHCSNmfvU63CwMFIVpZCpx2mHDs0RaDiIKXwTFK0DSALpswKtiZBKu5w81rPWNXdZCO1rNaM0qsnlCObMZCrszYFCfu8njQTXJ752LG0n8UV7POAYeqCDkpcI0bTHNRKX8MWi2E3E8td6cVI6ivvrd2kMKf9psKdNjqiCMQLjww0bYZBfnoQDnPYAzlIZAt9ZAGSEg3fZBQofQ4c';
    
    $data = [
        'messaging_product' => 'whatsapp',
        'to' => '966569160996',
        // 'type' => 'document',
        // 'document' => [
        //     // 'link' => 'https://alamer-market.com/data1/images/%D8%A7%D9%84%D8%B9%D8%B1%D8%B6%20%D8%B3%D8%A7%D8%B1%D9%8A%20%D9%85%D9%86%2023%20%D8%A5%D9%84%D9%89%2029%20%D8%B1%D8%AC%D8%A8%201446%D9%87%D9%80.pdf',
        //     'link' => 'https://172.16.9.123/whatsapp_sender/a.pdf',
        //     'filename' => 'عروض نار وشرار 🔥',
        //     'caption' =>  ' لاتفوتك عروض العامر الرمضانية! 😍🌙'
        // ]

        
        'type' => 'template',
        'template' => [
            'name' => 'hello_emp_from_programmer',
            'language' => [
                'code' => 'ar'
            ],
            'components' => [
                [
                    'type' => 'header',
                    'parameters' => [
                        [
                            'type' => 'text',
                            'text' => 'علي' // متغير النص في الهيدر
                        ]
                    ]
                ],

            ]
        ]
        
    ];

    $headers = [
        'Authorization: Bearer ' . $token,
        'Content-Type: application/json',
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    curl_close($ch);

    echo $response;
    $responseData = json_decode($response, true);

?>
