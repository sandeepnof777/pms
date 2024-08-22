<?php

class pdf_merger {
    function __construct() {
        require_once "pdf_merger/PDFMerger.php";
        require_once "pdf_merger/fpdf/fpdf.php";
        require_once "pdf_merger/fpdi/fpdi.php";
    }
}