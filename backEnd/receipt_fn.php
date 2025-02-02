<?php

    function sales_info($data){
        
        // Display sales information
        if (isset($data) && is_array($data)) {
            foreach ($data as $sale) {

                echo 
                '
                    <tr>
                        <td>'.      $sale['no']                 .'</td>
                        <td>'.      $sale['item']               .'</td>
                        <td>'.      $sale['desc_en']            .'</br>'.$sale['desc_ar'].' </td>
                        <td>'.      abs($sale['Quantity'])      .'</td>
                        <td>'.      $sale['Price']              .'</td>
                        <td>'.      abs($sale['vat'])           .'</td>
                        <td>'.      abs($sale['total'])         .'</td>
                    </tr>
                ';
                        
                
            }
        } else {
            echo "No sales data found.";
        }

    }

    function companyinfo_info($data){
        
        // Display companyinfo information
        if (isset($data) && is_array($data)) {

            echo 
            '
                <p><strong>'                .$data["Name"].                  '</strong></p>
                <p>'                        .$data["Name 2"].                '</p>
                <p>'                        .$data["City"].                  '</p>
                <p>'                        .$data["Address"].               '</p>
                <p>Phone: '                 .$data["Phone No_"].             ' :الهاتف</p>
                <p>VAT Registration No.: '  .$data["VAT Registration No_"].  ' :رقم تسجيل ضريبة القيمة المضافة</p>
            ';
                        
            
        } else {
            echo "No companyinfo data found.";
        }

    }

    function transhdr_info($data){
        
        // Display transhdr information
        if (isset($data) && is_array($data)) {

            echo 
            '

                <div class="rowsHandlesr">
                    
                    <div class="row">
                        <p><strong>Transaction No:</strong></p>
                        <p style="text-align: center;">'.$data["transno"].'</p>
                    </div>

                    <div class="row">
                        <p><strong>Store:</strong></p>
                        <p style="text-align: center;">'.$data["store"].'</p>
                    </div>

                    <div class="row">
                        <p><strong>Receipt No:</strong></p>
                        <p style="text-align: center;">'.$data["recno"].'</p>
                    </div>

                </div>

                <div class="rowsHandlesr">

                    <div class="row">
                        <p style="text-align: center;"><strong>Date:</strong></p>
                        <p>'.substr($data["Date"],0,10).'</p>
                    </div>

                    <div class="row">
                        <p style="text-align: center;"><strong>Staff ID:</strong></p>
                        <p>'.$data['staff'].'</p>
                    </div>

                    <div class="row">
                        <p style="text-align: center;"><strong>Customer:</strong></p>
                        <p>'.$data["customer"].'</p>
                    </div>

                </div>

            ';
                        
            
        } else {
            echo "No transhdr data found.";
        }

    }

?>