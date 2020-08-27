<?php


namespace App\Applications\VisitCard\Processors;


use TCPDF;

class PDFProcessor
{
    /*private string $outputDir;
    private array $result = [];

    public function __construct(string $outputDir)
    {
        $this->outputDir = $outputDir;
    }

    public function generate(array $input)
    {
        foreach ($input as $path) {
            if (!is_file($path)) {
                throw new RuntimeException("Not a file");
            }

            $this->result[] = $this->convertToPDF($path);
        }
    }

    public function getResult(): array
    {
        return $this->result;
    }

        private function convertToPDF($SVGDocument)
        {
            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            $pdf->AddPage();
            //if want to parse svg string, add @ to file arg
            $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
            $pdf->setRasterizeVectorImages(true);
            $pdf->ImageSVG($file = $SVGDocument, $x=15, $y=30, $w=100, $h=100, $link='http://www.tcpdf.org', $align='', $palign='', $border=1, $fitonpage=true);
            $path = $this->outputDir . '/' . substr(str_shuffle(md5(microtime())), 0, 10) . '.pdf';
            $pdf->Output($path, 'F');
            return $path;
        }

    private function convertToPDF($SVGDocument)
    {
        $pdf = new Mpdf();
        $pdf->Image($SVGDocument, 0, 0, 100, 100, 'svg', '', true, false);
        $pdf->Write(10, 'test');
        $path = $this->outputDir . '/' . substr(str_shuffle(md5(microtime())), 0, 10) . '.pdf';
        $pdf->Output($path, 'F');
        return $path;
    }
*/
}