<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    header('Content-Type: text/html; charset=utf-8');

    require_once '../vendor/autoload.php';
    require '../vendor/tecnickcom/tcpdf/tcpdf.php';

    use Endroid\QrCode\QrCode;
    use Endroid\QrCode\Writer\PngWriter;
    use Endroid\QrCode\ErrorCorrectionLevel;


    if (!isset($_POST['receipt'])) {
        return false;
    }
    // $receipt = '000000P008000348877';
    $receipt = $_POST['receipt'];
    
    
    // $receipt = '000000P008000348877';
    $url = "https://shop.alamer-market.com/api/navservices/showreceipt?receipt=$receipt";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    if ($response === false) {
        die('Failed to fetch data from API');
    }

    $data = json_decode($response, true);
    if (!is_array($data) || empty($data)) {
        die('Invalid or empty response from API');
    }

    if (!isset($data["transhdr"], $data["sales"], $data["companyinfo"])) {
        die('Missing required keys in the response data');
    }

    $hieght = (count($data["sales"]) * 20) + 310;

    $pdf = new TCPDF('P', 'mm', [200, $hieght]);

    // إعداد الصفحة
    $pdf->AddPage();
    $pdf->SetFont('Amiri', '', 12);
    $pdf->setRTL(true);

    // إضافة شعار الشركة
    $pdf->Image('../images/Al_Amer_Market_Logo.png', 150, 10, 100, 0, 'PNG', '', '', false, 300, '', false, false, 0, false, false, false);
    $pdf->Ln(40);

    $pdf->Cell(0, 10, 'فاتورة شراء', 0, 1, 'C');

    // بيانات الشركة
    $pdf->Cell(0, 10, $data["companyinfo"]["Name"], 0, 1, 'C');
    $pdf->Cell(0, 10, $data["companyinfo"]["Name 2"], 0, 1, 'C');
    $pdf->Cell(0, 10, $data["companyinfo"]["City"], 0, 1, 'C');
    $pdf->Cell(0, 10, $data["companyinfo"]["Address"], 0, 1, 'C');
    $pdf->Cell(0, 10, 'الهاتف: ' . $data["companyinfo"]["Phone No_"], 0, 1, 'C');
    $pdf->Cell(0, 10, 'رقم تسجيل ضريبة القيمة المضافة: ' . $data["companyinfo"]["VAT Registration No_"], 0, 1, 'C');

    // إضافة تفاصيل المعاملة
    $pdf->Ln(10);
    $pdf->Cell(70, 10, 'رقم المعاملة: ' . $data["transhdr"]["transno"], 0, 0, 'L');
    $pdf->Cell(67, 10, 'المتجر: ' . $data["transhdr"]["store"], 0, 1, 'L');
    $pdf->Cell(100, 10, 'رقم الإيصال: ' . $data["transhdr"]["recno"], 0, 0, 'L');
    $pdf->Cell(50, 10, 'التاريخ: ' . substr($data["transhdr"]["Date"], 0, 10), 0, 1, 'L');

    $pdf->Ln(10);
    $pdf->SetFont('Amiri', '', 10);


    $pdf->Cell(20, 10, 'رقم.', 1, 0, 'C');
    $pdf->Cell(80, 10, 'الوصف', 1, 0, 'C');
    $pdf->Cell(20, 10, 'الكمية', 1, 0, 'C');
    $pdf->Cell(20, 10, 'السعر', 1, 0, 'C');
    $pdf->Cell(20, 10, 'الضريبة', 1, 0, 'C');
    $pdf->Cell(20, 10, 'الإجمالي', 1, 1, 'C');


    foreach ($data["sales"] as $sale) {
        $pdf->Cell(20, 10, count($data["sales"]), 0, 0, 'C');
        $pdf->MultiCell(80, 10, $sale["desc_en"] . "\n" . $sale["desc_ar"], 0, 'C', false, 0);
        $pdf->Cell(20, 10, abs($sale["Quantity"]), 0, 0, 'C');
        $pdf->Cell(20, 10, abs($sale["Price"]), 0, 0, 'C');
        $pdf->Cell(20, 10, abs($sale["vat"]), 0, 0, 'C');
        $pdf->Cell(20, 10, abs($sale["total"]), 0, 1, 'C');
        
        $pdf->Ln(5);

    }


    $pdf->Ln(50);
    $pdf->Cell(70, 10, 'الرصيد: ' . abs($data["transhdr"]["balance"]), 0, 0, 'L');
    $pdf->Cell(70, 10, 'الدفع: ' . abs($data["transhdr"]["Payment"]), 0, 1, 'L');

    // إضافة QR code
    $zatca = $data["zatcaqr"];
    $qrCode = new QrCode($zatca);
    $qrCode->setSize(300);


    $writer = new PngWriter();
    $result = $writer->write($qrCode);

    $qrCodeImagePath = 'qrcode.png';
    $result->saveToFile($qrCodeImagePath);

    $pdf->Image($qrCodeImagePath, 120, $pdf->GetY() + 10, 50, 50, 'PNG', '', '', true, 350, '', false, false, 0, false, false, false);

    if (file_exists($qrCodeImagePath)) {
        unlink($qrCodeImagePath);
    }

    // إخراج ملف PDF
    $pdf->Output('https://shop.alamer-market.com/public/storage/recipts/'.$receipt.'.pdf', 'F');
    // $pdf->Output('C:/xampp/htdocs/whatsApp_Sender/invoice.pdf', 'I');
?>