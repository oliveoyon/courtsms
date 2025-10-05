<?php

namespace App\Http\Controllers;

use App\Models\Court;
use App\Services\PdfService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Mpdf\Mpdf;

class PdfController extends Controller
{
    public function generateBanglaPdf()
    {
        // mPDF configuration
        $mpdf = new Mpdf([
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

        // HTML content
        $html = '<h1 style="font-family:solaimanlipi;">বাংলা PDF উদাহরণ</h1>
                 <p style="font-family:solaimanlipi;">এটি বাংলা লেখা প্রদর্শনের জন্য mPDF ব্যবহার করছে।</p>';

        $mpdf->WriteHTML($html);

        // Output PDF inline
        $mpdf->Output('bangla.pdf', 'I');  // 'D' = download
    }

    public function testPdf1()
    {
        // $html = '<h1>বাংলা ও English PDF</h1><p>বাংলা লেখা এবং English text একসাথে।</p>';
        // $pdfService = new PdfService('SolaimanLipi', 'times');
        // $pdfService->generate($html, 'bangla_english.pdf'); // Inline view

        $html = '<h1>বাংলা PDF উদাহরণ</h1><p>এটি বাংলা লেখা প্রদর্শনের জন্য mPDF ব্যবহার করছে।</p>';
        $pdfService = new PdfService(); // SolaimanLipi by default
        $pdfService->generate($html, 'bangla.pdf'); // Inline view
    }

    public function testPdf()
    {
        $courts = Court::with('district')->get();
        $html = View::make('reports.test', [
            'courts' => $courts,
            'reportDate' => now()->format('Y-m-d'),
        ])->render();

        $pdfService = new PdfService(); // SolaimanLipi by default
        $pdfService->generate($html, 'court_report.pdf'); // Inline view
    }
}
