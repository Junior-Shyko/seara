<?php

declare(strict_types=1);

namespace App\Service\Report\DebtReport;

use PhpOffice\PhpSpreadsheet\Exception;
use PhpOffice\PhpSpreadsheet\Shared\File;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use SplFileInfo;

class ExcelReportFormatter implements DebtReportFormatter
{
    /**
     * @var ResultSetToRowsConverter
     */
    private $resultSetConverter;

    public function __construct(ResultSetToRowsConverter $resultSetConverter)
    {
        $this->resultSetConverter = $resultSetConverter;
    }

    /**
     * @inheritDoc
     */
    public function format(DebtReportResultSet $resultSet): SplFileInfo
    {
        $spreadsheet = new Spreadsheet();

        return $this
            ->applyDefaultStyling($spreadsheet, $resultSet)
            ->applyHeaderStyling($spreadsheet, $resultSet)
            ->applyBodyStyling($spreadsheet, $resultSet)
            ->saveReport($spreadsheet);
    }

    /**
     * @param Spreadsheet $spreadsheet
     * @param DebtReportResultSet $resultSet
     * @return ExcelReportFormatter
     * @throws Exception
     */
    private function applyDefaultStyling(Spreadsheet $spreadsheet, DebtReportResultSet $resultSet): self
    {
        $defaultStyle = $spreadsheet->getDefaultStyle();
        $defaultStyle->getFont()->setName('Arial Black');
        $defaultStyle->getFont()->setBold(true);
        $defaultStyle->getFont()->setSize(12);
        $defaultStyle->getAlignment()->setVertical(Alignment::VERTICAL_BOTTOM);
        $defaultStyle->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(6);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(8);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(12);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(45);

        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(15);
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(15);
        $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(15);

        $spreadsheet->getActiveSheet()
            ->getPageSetup()
            ->setPrintArea('A1:G' . $this->calculateLastRowIndex($resultSet))
            ->setFitToPage(true);

        return $this;
    }

    /**
     * @param Spreadsheet $spreadsheet
     * @param DebtReportResultSet $resultSet
     * @return ExcelReportFormatter
     * @throws Exception
     */
    private function applyHeaderStyling(Spreadsheet $spreadsheet, DebtReportResultSet $resultSet): self
    {
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->mergeCells('A1:G1')
            ->setCellValue('A1', $resultSet->getCompanyName());

        $sheet->mergeCells('A2:D2')
            ->setCellValue('A2', $resultSet->getCompanyManager());

        $sheet->mergeCells('A3:B3')
            ->setCellValue('A3', 'COMPETÊNCIA');

        $sheet->setCellValue('C3', 'VCTO/PGTO');
        $sheet->setCellValue('D3', 'DESCRIÇÃO');

        $sheet->mergeCells('E2:E3')
            ->setCellValue('E2', 'VALOR');

        $sheet->getStyle('A2')
            ->getFont()
            ->setBold(false);

        $sheet
            ->setCellValue('F2', 'PAGAMENTO')
            ->setCellValue('F3', 'VALOR')
            ->setCellValue('G2', 'SALDO')
            ->setCellValue('G3', 'DEVEDOR');

        return $this;
    }

    /**
     * @param DebtReportResultSet $resultSet
     * @param Spreadsheet $spreadsheet
     * @return ExcelReportFormatter
     * @throws Exception
     */
    private function applyBodyStyling(
        Spreadsheet $spreadsheet,
        DebtReportResultSet $resultSet
    ): self {
        $sheet = $spreadsheet->getActiveSheet();

        $rows = $this->resultSetConverter->convert($resultSet, 4);
        $sheet->fromArray($rows, null, 'A4');

        $lastRowIdx = $this->calculateLastRowIndex($resultSet);

        $sheet->getStyle("A1:G{$lastRowIdx}")
            ->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => '000000'],
                    ],
                ],
            ]);

        $sheet->getStyle("F2:F" . ($lastRowIdx - 1))
            ->getFont()
            ->setColor(new Color(Color::COLOR_BLUE));

        foreach ($this->getPaymentCoordinates($rows) as $paymentCoordinate) {
            $sheet->getStyle($paymentCoordinate)
                ->getFont()
                ->setColor(new Color(Color::COLOR_BLUE));
        }

        $sheet->getStyle('D4:D' . ($lastRowIdx - 1))
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_LEFT);

        $sheet->getStyle("E4:G{$lastRowIdx}")
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_RIGHT);

        $sheet->getStyle("E4:G{$lastRowIdx}")
            ->getNumberFormat()
            ->setFormatCode('#,##0.00_-');

        // Footer
        $sheet
            ->mergeCells("A{$lastRowIdx}:D{$lastRowIdx}")
            ->setCellValue("A{$lastRowIdx}", 'TOTAIS >>>')
            ->getStyle("A{$lastRowIdx}")
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_RIGHT);

        $sheet->getStyle("A{$lastRowIdx}")
            ->getFont()
            ->setColor(new Color(Color::COLOR_BLACK));


        return $this;
    }

    private function saveReport(Spreadsheet $spreadsheet): SplFileInfo
    {
        $tempFile = @tempnam(File::sysGetTempDir(), 'phpxltmp');

        $writer = new Xlsx($spreadsheet);
        $writer->save($tempFile);

        return new SplFileInfo($tempFile);
    }

    private function getPaymentCoordinates(array $rows)
    {
        $coordinates = [];
        foreach ($rows as $idx => $row) {
            $paidAmount = $row[5] ?? null;

            if (null == $paidAmount) {
                continue;
            }

            $rowNumber = $idx + 4;
            $coordinates[] = "C{$rowNumber}:D{$rowNumber}";
        }
        return $coordinates;
    }

    private function calculateLastRowIndex(DebtReportResultSet $resultSet): int
    {
        return 3 + $resultSet->count() + 1;
    }
}
