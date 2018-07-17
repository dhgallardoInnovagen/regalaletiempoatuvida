<?php

/** PHPExcel */
require_once 'PHPExcel.php';
/** PHPExcel_IOFactory */
require_once 'PHPExcel/IOFactory.php';

class Excel_pdf_manager {

    function import($filename) {
        $objReader = PHPExcel_IOFactory::createReader('Excel2007');
        $objPHPExcel = $objReader->load($filename);

//iterando por el contenido de las celdas
        $objWorksheet = $objPHPExcel->getActiveSheet();
        foreach ($objWorksheet->getRowIterator() as $row) {
            $record = array();
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(false);
            foreach ($cellIterator as $cell) {
                $record[] = $cell->getValue();
            }
        }
    }

    function export($table, $name, $ext) {
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("Innovagen");
        $objPHPExcel->setActiveSheetIndex(0); //poniendo active hoja 1
        $objPHPExcel->getActiveSheet()->setTitle("Hoja1"); //título de la hoja 1
        //llenando celdas
        $column = 0;
        $row = 1;
        foreach ($table as $record) {
            foreach ($record as $value) {
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($column, $row, $value);

                if ($column == 5) {
                    if ($value == 'SI') {
                        $objPHPExcel->getActiveSheet()->getStyle('F' . $row)->getFill()->applyFromArray(array(
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                            'color' => array('rgb' => '5CB85C')
                        ));
                    } else {
                        if ($value == 'NO') {
                            $objPHPExcel->getActiveSheet()->getStyle('F' . $row)->getFill()->applyFromArray(array(
                                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                'color' => array('rgb' => 'D9534F')
                            ));
                        }
                    }
                }
                if ($column == 6) {
                    if ($value == 'SI') {
                        $objPHPExcel->getActiveSheet()->getStyle('G' . $row)->getFill()->applyFromArray(array(
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                            'color' => array('rgb' => '5CB85C')
                        ));
                    } else {
                        if ($value == 'NO') {
                            $objPHPExcel->getActiveSheet()->getStyle('G' . $row)->getFill()->applyFromArray(array(
                                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                'color' => array('rgb' => 'D9534F')
                            ));
                        }
                    }
                }
                if ($column == 7) {
                    if ($value == 'SI') {
                        $objPHPExcel->getActiveSheet()->getStyle('H' . $row)->getFill()->applyFromArray(array(
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                            'color' => array('rgb' => '5CB85C')
                        ));
                    } else {
                        if ($value == 'NO') {
                            $objPHPExcel->getActiveSheet()->getStyle('H' . $row)->getFill()->applyFromArray(array(
                                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                'color' => array('rgb' => 'D9534F')
                            ));
                        }
                    }
                }
                if ($column == 8) {
                    if ($value == 'SI') {
                        $objPHPExcel->getActiveSheet()->getStyle('I' . $row)->getFill()->applyFromArray(array(
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                            'color' => array('rgb' => '5CB85C')
                        ));
                    } else {
                        if ($value == 'NO') {
                            $objPHPExcel->getActiveSheet()->getStyle('I' . $row)->getFill()->applyFromArray(array(
                                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                'color' => array('rgb' => 'D9534F')
                            ));
                        }
                    }
                }
                $column++;
            }
            $column = 0;
            $row++;
        }
        //poniendo en negritas la fila de los títulos
        $styleArray = array('font' => array('bold' => true));
        $objPHPExcel->getActiveSheet()->getStyle('A1:Z1')->applyFromArray($styleArray);
        //poniendo columnas con tamaño auto según el contenido, asumiendo N como la última
        for ($i = 'A'; $i <= 'L'; $i++) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($i)->setAutoSize(true);
        }
        //   $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($column, $row, $value);
        //poniendo algo en una celda
//        $objPHPExcel->getStyle('A1')->applyFromArray(
//                array(
//                    'fill' => array(
//                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
//                        'color' => array('rgb' => 'FF0000')
//                    )
//                )
//        );

        $styleArray = array('font' => array('bold' => true));
        $objPHPExcel->getActiveSheet()->getStyle('A1:Z1')->applyFromArray($styleArray); //poniendo en negritas una fila

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        //poniendo una columna con tamaño auto según el contenido
        //creando un objeto writer para exportar el excel, y direccionando salida hacia el cliente web para invocar diálogo de salvar:
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $name . $ext);
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
    }

}
