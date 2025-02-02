<?php
    // if (!isset($_POST['phone'])) {
    //     return error_log("dosen't Recive a Phone Number");
    // };

    // $phone = $_POST['phone'];
    // $name = $_POST['name'];


    // echo($phone);
    $url = 'https://graph.facebook.com/v15.0/545202698675840/messages';
    $token = 'EAAVccrv3Qa0BO0hBpRYxkk3HIzyVrAJ4fgb1TclaNEkbQEX3fD9WDoVfdkvuORyMmvcD5XJZBk1SprTOnTg8McolTHEvBxGnTrz4HsQFO8w3m4xDH4o56D0kczWvjHHH2f5OzamJj89OtHznfbiT7nAXG9r5KIIzxeUDhysCsYuhQGL7Nru7R1DMa7HpCNf9fhyhB5thh1bkUG6DCesdZA3egZD';
    
    // $data = [
    //     'messaging_product' => 'whatsapp',
    //     'to' => '966569160996',
    //     'type' => 'document',
    //     'document' => [
    //         // 'link' => 'https://alamer-market.com/data1/images/%D8%A7%D9%84%D8%B9%D8%B1%D8%B6%20%D8%B3%D8%A7%D8%B1%D9%8A%20%D9%85%D9%86%2023%20%D8%A5%D9%84%D9%89%2029%20%D8%B1%D8%AC%D8%A8%201446%D9%87%D9%80.pdf',
    //         'link' => 'https://shop.alamer-market.com/public/storage/vat.pdf',
    //         'filename' => 'عروض نار وشرار 🔥',
    //         'caption' =>  ' لاتفوتك عروض العامر الرمضانية! 😍🌙'
    //     ]




        




        
    // ];



    $data = [
        'messaging_product' => 'whatsapp',
        'recipient_type' => 'individual',
        'to' => '966569160996',
        'type' => 'template',
        'template' => [
            'name' => 'pdf',
            'language' => [
                'code' => 'ar' 
            ],
            'components' => [
                [
                    'type' => 'header', 
                    'parameters' => [
                        [
                            'type' => 'document',
                            'document' => [
                                'link' => 'https://shop.alamer-market.com/public/storage/vat.pdf', 
                                'filename' => 'عروض العامر'
                            ]
                        ]
                    ]
                ],
                [
                    'type' => 'body',
                    'parameters' => [
                        [
                            'type' => 'text',
                            'text' => '🔥 لا تفوت عروض العامر الرمضانية! 🌙'
                        ]
                    ]
                ]
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

?>
