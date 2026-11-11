<?php

namespace App\Http\Controllers;

use Box\Spout\Common\Entity\Style\Border;
use Box\Spout\Common\Entity\Style\CellAlignment;
use Box\Spout\Common\Entity\Style\Color;
use Box\Spout\Writer\Common\Creator\Style\BorderBuilder;
use Box\Spout\Writer\Common\Creator\Style\StyleBuilder;
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use View;
use Session;
use DateTime;
use DateTimeZone;

use App\Traits\ReporteVentaNTraits;


class ReporteDIVSaldosController extends Controller
{

    use ReporteVentaNTraits;

    public function actionAjaxListarDivSaldos(Request $request)
    {
//        $fecha_inicio = $request['fecha_inicio'];
        $fecha_fin = $request['fecha_fin'];
        $idopcion = $request['idopcion'];
        $ind_reporte = $request['opcion'];

        $listareporte = $this->obtener_tabla_div_saldos_n($fecha_fin, $fecha_fin, Session::get('empresas')->COD_EMPR, $ind_reporte);
        $funcion = $this;

        return View::make('reporte/ajax/alistareportedivsaldos',
            [
                'listareporte' => $listareporte,
                'idopcion' => $idopcion,
                'funcion' => $funcion,
                'ajax' => true
            ]);
    }

    public function actionAjaxListarDivSaldosExcel(Request $request)
    {
        set_time_limit(0);
//        $fecha_inicio = $request['startDate'];
        $fecha_fin = $request['endDate'];
        $ind_reporte = $request['opcion'];
        $listareporte = $this->obtener_tabla_div_saldos_n($fecha_fin, $fecha_fin, Session::get('empresas')->COD_EMPR, $ind_reporte);

        $nombre = 'ReporteDivSaldos.xlsx';
        $path = storage_path('reportesdiv/' . $nombre);

        $this->llenarexcel($path, $listareporte);

        if (file_exists($path)) {
            return Response::download($path);
        }

    }

    private function dateToExcelSerialNumber(DateTime $date)
    {
        /*
        $unixTime = $date->getTimestamp();
        $excelStart = (new DateTime('1899-12-30'))->getTimestamp(); // Excel base
        return ($unixTime - $excelStart) / 86400;
        */

        $date->setTimezone(new DateTimeZone('UTC'));
        $excelStart = new DateTime('1899-12-30', new DateTimeZone('UTC'));

        return ($date->getTimestamp() - $excelStart->getTimestamp()) / 86400;

    }

    public function llenarexcel($path, $listaovdivsinconcpe)
    {
        set_time_limit(0);

        $writer = WriterEntityFactory::createXLSXWriter();

        $writer->openToFile($path);

        $border = (new BorderBuilder())
            ->setBorderRight(Color::BLACK, Border::WIDTH_THIN, Border::STYLE_SOLID)
            ->setBorderLeft(Color::BLACK, Border::WIDTH_THIN, Border::STYLE_SOLID)
            ->setBorderTop(Color::BLACK, Border::WIDTH_THIN, Border::STYLE_SOLID)
            ->setBorderBottom(Color::BLACK, Border::WIDTH_THIN, Border::STYLE_SOLID)
            ->build();

        $style_cabecera = (new StyleBuilder())
            ->setFontName('Cambria')
            ->setFontBold()
            ->setFontSize(10)
            ->setFontColor(Color::WHITE)
            ->setShouldWrapText(false)
            ->setCellAlignment(CellAlignment::CENTER)
            ->setBorder($border)
            ->setBackgroundColor(Color::DARK_BLUE)
            ->build();

        $styleGeneral = (new StyleBuilder())
            ->setFontName('Cambria')
            ->setFontSize(8)
            ->setFontColor(Color::BLACK)
            ->setShouldWrapText(false)
            ->setCellAlignment(CellAlignment::LEFT)
            ->setBorder($border)
            ->build();

        $styleNumber = (new StyleBuilder())
            ->setFontName('Cambria')
            ->setFormat('#,##0.00')
            ->setFontSize(9)
            ->setFontColor(Color::BLACK)
            ->setShouldWrapText(false)
            ->setCellAlignment(CellAlignment::RIGHT)
            ->setBorder($border)
            ->build();

        $styleFecha = (new StyleBuilder())
            ->setFontName('Cambria')
            ->setFormat('yyyy-mm-dd')
            ->setFontSize(9)
            ->setFontColor(Color::BLACK)
            ->setShouldWrapText(false)
            ->setCellAlignment(CellAlignment::RIGHT)
            ->setBorder($border)
            ->build();

        $newSheet1 = $writer->getCurrentSheet();
        $newSheet1->setName('DIV Saldos');

        // === Cabeceras ===
        $cabeceras = [
            'COD_DIV', 'NRO_DIV', 'FECHA_DIV', 'FECHA_VEN_DIV', 'TITULAR_DIV',
            'IMPORTE_DIV', 'TOTAL NCI', 'COBRADO', 'POR_COBRAR',
            'COD_DOCUMENTO_CTBLE', 'TXT_CATEGORIA_TIPO_DOC',
            'NRO_SERIE', 'NRO_DOC', 'FECHA_DOC', 'FECHA_VEN_DOC', 'TITULAR_DOC',
            'ALTERNATIVO_DOC', 'TOTAL_DOC', 'TOTAL NC', 'TOTAL ND', 'CAN_AMORTIZADO', 'FILA'
        ];

        $cells = [];
        foreach ($cabeceras as $c) {
            $cells[] = WriterEntityFactory::createCell($c);
        }
        $writer->addRow(WriterEntityFactory::createRow($cells, $style_cabecera));

        foreach ($listaovdivsinconcpe as $item) {
            $date = new DateTime($item["FEC_DIV_ORIGINAL"], new DateTimeZone('UTC'));
            $date01 = new DateTime($item["FEC_CPE_ORIGINAL"], new DateTimeZone('UTC'));
            $date02 = new DateTime($item["FEC_CPE_VEN_ORIGINAL"], new DateTimeZone('UTC'));
            $date03 = new DateTime($item["FEC_DIV_VEN_ORIGINAL"], new DateTimeZone('UTC'));
            // Convertir a número de serie Excel
            $excelDate = $this->dateToExcelSerialNumber($date);
            $excelDate01 = $this->dateToExcelSerialNumber($date01);
            $excelDate02 = $this->dateToExcelSerialNumber($date02);
            $excelDate03 = $this->dateToExcelSerialNumber($date03);
            $cells = [
                WriterEntityFactory::createCell($item["COD_DIV"], $styleGeneral),
                WriterEntityFactory::createCell($item["NRO_DIV"], $styleGeneral),
                WriterEntityFactory::createCell($excelDate, $styleFecha),
                WriterEntityFactory::createCell($excelDate03, $styleFecha),
                WriterEntityFactory::createCell($item["TITULAR_DIV"], $styleGeneral),
                WriterEntityFactory::createCell((float) $item["IMPORTE_DIV"], $styleNumber),
                WriterEntityFactory::createCell((float) $item["TOTAL_NCI"], $styleNumber),
                WriterEntityFactory::createCell((float) $item["COBRADO"], $styleNumber),
                WriterEntityFactory::createCell((float) $item["POR_COBRAR"], $styleNumber),
                WriterEntityFactory::createCell($item["COD_DOCUMENTO_CTBLE"], $styleGeneral),
                WriterEntityFactory::createCell($item["TXT_CATEGORIA_TIPO_DOC"], $styleGeneral),
                WriterEntityFactory::createCell($item["NRO_SERIE"], $styleGeneral),
                WriterEntityFactory::createCell($item["NRO_DOC"], $styleGeneral),
                WriterEntityFactory::createCell($excelDate01, $styleFecha),
                WriterEntityFactory::createCell($excelDate02, $styleFecha),
                WriterEntityFactory::createCell($item["TITULAR_DOC"], $styleGeneral),
                WriterEntityFactory::createCell($item["ALTERNATIVO_DOC"], $styleGeneral),
                WriterEntityFactory::createCell((float) $item["TOTAL_DOC"], $styleNumber),
                WriterEntityFactory::createCell((float) $item["TOTAL_NC"], $styleNumber),
                WriterEntityFactory::createCell((float) $item["TOTAL_ND"], $styleNumber),
                WriterEntityFactory::createCell((float) $item["CAN_AMORTIZADO"], $styleNumber),
                WriterEntityFactory::createCell($item["FILA"], $styleGeneral),
            ];
            $writer->addRow(WriterEntityFactory::createRow($cells));
        }

        $writer->close();

    }

    public function actionListarDivSaldos($idopcion)
    {
        $fecha_inicio = date('Y-m-d');
        $fecha_fin = date('Y-m-d');

        View::share('titulo', 'Reporte DIV Saldos');

        return View::make('reporte/listareportedivsaldos',
            [
                'fecha_inicio' => $fecha_inicio,
                'fecha_fin' => $fecha_fin,
                'listareporte' => [],
                'idopcion' => $idopcion,
                'funcion' => $this,
                'ajax' => true
            ]);
    }


}
