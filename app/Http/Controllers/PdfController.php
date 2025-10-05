<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mpdf\Mpdf;

class PdfController extends Controller
{
    public function index()
    {
        $districts = [];

        for ($i = 1; $i <= 10; $i++) {
            $districts[] = (object)[
                'name' => 'ডিস্ট্রিক্ট ' . $i,  // Example Bangla district name
                'profile_no' => 100 + $i       // Example profile number
            ];
        }

        return view('reports.test', compact('districts'));
    }


    public function generatePdf(Request $request)
    {
        $send['data'] = $request->input('pdf_data');
        $send['title'] = $request->input('title', 'Report');

        $fname = $request->input('fname', 'report.pdf');

        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'orientation' => $request->input('orientation', 'P'),
            'margin_top' => 30,
            'margin_bottom' => 5,
            'margin_header' => 5,
            'fontDir' => array_merge((new \Mpdf\Config\ConfigVariables())->getDefaults()['fontDir'], [
                public_path('dashboard/fonts')
            ]),
            'fontdata' => array_merge((new \Mpdf\Config\FontVariables())->getDefaults()['fontdata'], [
                'solaimanlipi' => [
                    'R' => 'SolaimanLipi.ttf',
                    'useOTL' => 0xFF,
                    'useKashida' => 75,
                ]
            ]),
            'default_font' => 'solaimanlipi'
        ]);

        $mpdf->setAutoBottomMargin = 'stretch';
        $mpdf->SetAutoPageBreak(true);
        $mpdf->SetAuthor('GIZ');

        // Render Blade template with passed data
        $bladeViewPath = 'reports.template';
        $html = view($bladeViewPath, $send)->render();
        $mpdf->WriteHTML($html);

        // Make sure the "reports" folder exists in public
        $reportsPath = public_path('reports');
        if (!is_dir($reportsPath)) {
            mkdir($reportsPath, 0755, true);
        }

        // Save PDF in public/reports folder
        $pdfFilePath = $reportsPath . '/' . $fname;
        $mpdf->Output($pdfFilePath, 'F');

        // Construct public URL
        $pdfUrl = url('reports/' . $fname);

        return response()->json(['pdf_url' => $pdfUrl, 'message' => 'PDF generated successfully']);
    }
}
