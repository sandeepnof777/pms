<?php
/***************************/
/* Radek HULAN             */
/* http://hulan.info/blog/ */
/***************************/

define('FPDF_FONTPATH', 'font/');

/************************************/
/* global functions                 */
/************************************/
function hex2dec($color = "#000000") {
    $tbl_color = array();
    $tbl_color['R'] = hexdec(substr($color, 1, 2));
    $tbl_color['G'] = hexdec(substr($color, 3, 2));
    $tbl_color['B'] = hexdec(substr($color, 5, 2));
    return $tbl_color;
}

function px2mm($px) {
    return $px * 25.4 / 72;
}

function txtentities($html) {
    $trans = get_html_translation_table(HTML_ENTITIES);
    $trans = array_flip($trans);
    return strtr($html, $trans);
}

/************************************/
/* main class createPDF             */
/************************************/
class createPDF {

    function createPDF($_html, $_title, $_articleurl, $_author, $_date) {
        // main vars
        $this->html = $_html; // html text to _convert to PDF
        $this->title = $_title; // article title
        $this->articleurl = $_articleurl; // article URL
        $this->author = $_author; // article author
        $this->date = $_date; // date being published
        // other options
        $this->directory = './'; // directory for temp files
        $this->http = ''; // http path
        $this->delete = 60; // keep temp files for 60 minutes
        $this->from = 'iso-8859-2'; // input encoding
        $this->to = 'cp1250'; // output encoding
        $this->useiconv = false; // use iconv
        $this->bi = true; // support bold and italic tags
    }

    function _convert($s) {
        if ($this->useiconv) {
            return iconv($this->from, $this->to, $s);
        }
        else
        {
            return $s;
        }
    }

    function _iso2ascii($s) {
        $iso = "��������������������������ť��ة���ݮ����";
        $asc = "acdeeillnorstuuyzaeouACDEEILLNORSTUUYZAEOU";
        return strtr($s, $iso, $asc);
    }

    function _makeFileName($title) {
        $title = $this->_iso2ascii(strip_tags(trim($title)));
        preg_match_all('/[a-zA-Z0-9]+/', $title, $nt);
        return implode('-', $nt[0]);
    }

    function run() {
        // change some win codes, and xhtml into html
        $str = array(
            '<br />' => '
',
            '<hr />' => '<hr>',
            '[r]' => '<red>',
            '[/r]' => '</red>',
            '[l]' => '<blue>',
            '[/l]' => '</blue>',
            '&#8220;' => '"',
            '&#8221;' => '"',
            '&#8222;' => '"',
            '&#8230;' => '...',
            '&#8217;' => '\''
        );
        foreach ($str as $_from => $_to) $this->html = str_replace($_from, $_to, $this->html);

        $pdf = new PDF('P', 'mm', 'A4', $this->title, $this->articleurl, false);
        $pdf->Open();
        $pdf->SetCompression(true);
        $pdf->SetCreator("Script by Radek HULAN, http://hulan.info/blog/");
        $pdf->SetDisplayMode('real');
        $pdf->SetTitle($this->_convert($this->title));
        $pdf->SetAuthor($this->author);
        $pdf->AddPage();

        // face
        $pdf->PutMainTitle($this->_convert($this->title));
        $pdf->PutMinorHeading('Article URL');
        $pdf->PutMinorTitle($this->articleurl, $this->articleurl);
        $pdf->PutMinorHeading('Author');
        $pdf->PutMinorTitle($this->_convert($this->author));
        $pdf->PutMinorHeading("Published: " . date("F j, Y, g:i a", $this->date));
        $pdf->PutLine();
        $pdf->Ln(10);

        // html
        $pdf->WriteHTML($this->_convert(stripslashes($this->html)), $this->bi);

        // save and redirect
        $filename = $this->directory . $this->_makeFileName($this->title) . '.pdf';
        $http = $this->http . $this->_makeFileName($this->title) . '.pdf';
        $pdf->Output($filename);
        header("Location: $http");

        // cleanup
        $files = opendir($this->directory);
        while (false !== ($filename = readdir($files))) {
            if (!(strpos($filename, '.pdf') === false)) {
                // delete old temp files
                $time = filectime($this->directory . $filename);
                if (!($time === false) && $time > 0) {
                    if ($time + $this->delete * 60 < time()) {
                        unlink($this->directory . $filename);
                    }
                }
            }
        }
        // stop processing
        exit;
    }
}

/************************************/
/* class PDF                        */
/************************************/
class PDF extends FPDF {
    var $B;
    var $I;
    var $U;
    var $HREF;
    var $fontList;
    var $issetfont;
    var $issetcolor;
    var $bi;
    var $listBullet;
    var $listCounter;

    function PDF($orientation = 'P', $unit = 'mm', $format = 'A4', $_title = 'PDF TITLE', $_url = 'URL', $_debug = false) {
        $this->FPDF($orientation, $unit, $format);
        $this->B = 0;
        $this->I = 0;
        $this->U = 0;
        $this->HREF = '';
        $this->PRE = false;
//        $this->SetFont('Arial', '', 11);
//        $this->fontlist = array("Times", "Courier");
        $this->issetfont = false;
        $this->issetcolor = false;
        $this->articletitle = $_title;
        $this->articleurl = $_url;
        $this->debug = $_debug;
        $this->AliasNbPages();

        $this->listBullet = chr(149);
        $this->listCounter = 0;
    }

    function WriteHTML($html, $bi = false) {
        //remove all unsupported tags
        $this->bi = $bi;
        if ($bi) {
            $html = strip_tags($html, "<a><img><p><font><tr><blockquote><h1><h2><h3><h4><pre><red><blue><ul><ol><li><hr><b><i><u><strong><em>");
        } else {
            $html = strip_tags($html, "<a><img><p><font><tr><blockquote><h1><h2><h3><h4><pre><red><blue><ul><ol><li><hr>");
        }
        $html = str_replace("\n", ' ', $html); //replace carriage returns by spaces
        // debug
        if ($this->debug) {
            echo $html;
            exit;
        }

        $html = str_replace('&trade;', '�', $html);
        $html = str_replace('&copy;', '�', $html);
        $html = str_replace('&euro;', '�', $html);

        $a = preg_split('/<(.*)>/U', $html, -1, PREG_SPLIT_DELIM_CAPTURE);
        $skip = false;
        foreach ($a as $i => $e)
        {
            if (!$skip) {
                if ($this->HREF) {
                    $e = str_replace("\n", "", str_replace("\r", "", $e));
                }
                if ($i % 2 == 0) {
                    // new line
                    if ($this->PRE) {
                        $e = str_replace("\r", "\n", $e);
                    }
                    else
                    {
                        $e = str_replace("\r", "", $e);
                    }
                    //Text
                    if ($this->HREF) {
                        $this->PutLink($this->HREF, $e);
                        $skip = true;
                    } else
                    {
                        $this->Write(5, stripslashes(txtentities($e)));
                    }
                } else {
                    //Tag
                    if (substr(trim($e), 0, 1) == '/') {
                        $this->CloseTag(strtoupper(substr($e, strpos($e, '/'))));
                    }
                    else {
                        //Extract attributes
                        $a2 = explode(' ', $e);
                        $tag = strtoupper(array_shift($a2));
                        $attr = array();
                        foreach ($a2 as $v) if (ereg('^([^=]*)=["\']?([^"\']*)["\']?$', $v, $a3)) {
                            $attr[strtoupper($a3[1])] = $a3[2];
                        }
                        $this->OpenTag($tag, $attr);
                    }
                }
            } else {
                $this->HREF = '';
                $skip = false;
            }
        }
    }

    function OpenTag($tag, $attr) {
        //Opening tag
        switch ($tag) {
            case 'STRONG':
            case 'B':
                if ($this->bi) {
                    $this->SetStyle('B', true);
                }
                else
                {
                    $this->SetStyle('U', true);
                }
                break;
            case 'H1':
                $this->Ln(5);
                $this->SetTextColor(150, 0, 0);
                $this->SetFontSize(22);
                break;
            case 'H2':
                $this->Ln(5);
                $this->SetFontSize(18);
                $this->SetStyle('U', true);
                break;
            case 'H3':
                $this->Ln(5);
                $this->SetFontSize(16);
                $this->SetStyle('U', true);
                break;
            case 'H4':
                $this->Ln(5);
                $this->SetTextColor(102, 0, 0);
                $this->SetFontSize(14);
                if ($this->bi) {
                    $this->SetStyle('B', true);
                }
                break;
            case 'PRE':
                $this->SetFont('Courier', '', 11);
                $this->SetFontSize(11);
                $this->SetStyle('B', false);
                $this->SetStyle('I', false);
                $this->PRE = true;
                break;
            case 'RED':
                $this->SetTextColor(255, 0, 0);
                break;
            case 'BLOCKQUOTE':
                $this->mySetTextColor(100, 0, 45);
                $this->Ln(3);
                break;
            case 'BLUE':
                $this->SetTextColor(0, 0, 255);
                break;
            case 'I':
            case 'EM':
                if ($this->bi) {
                    $this->SetStyle('I', true);
                }
                break;
            case 'U':
                $this->SetStyle('U', true);
                break;
            case 'A':
                $this->HREF = $attr['HREF'];
                break;
            case 'IMG':
                if (isset($attr['SRC']) and (isset($attr['WIDTH']) or isset($attr['HEIGHT']))) {
                    if (!isset($attr['WIDTH'])) {
                        $attr['WIDTH'] = 0;
                    }
                    if (!isset($attr['HEIGHT'])) {
                        $attr['HEIGHT'] = 0;
                    }
                    $this->Image($attr['SRC'], $this->GetX(), $this->GetY(), px2mm($attr['WIDTH']), px2mm($attr['HEIGHT']));
                    $this->Ln(3);
                }
                break;
            case 'LI':
                $this->Ln(2);
                $this->Write(5, '     � ');
                break;
            case 'TR':
                $this->Ln(7);
                $this->PutLine();
                break;
            case 'BR':
                $this->Ln(2);
                break;
            case 'P':
                $this->Ln(5);
                break;
            case 'HR':
                $this->PutLine();
                break;
            case 'FONT':
                if (isset($attr['COLOR']) and $attr['COLOR'] != '') {
                    $coul = hex2dec($attr['COLOR']);
                    $this->mySetTextColor($coul['R'], $coul['G'], $coul['B']);
                    $this->issetcolor = true;
                }
                if (isset($attr['FACE']) and in_array(strtolower($attr['FACE']), $this->fontlist)) {
                    $this->SetFont(strtolower($attr['FACE']));
                    $this->issetfont = true;
                }
                break;
        }
    }

    function CloseTag($tag) {
        //Closing tag
        if ($tag = 'H1' || $tag = 'H2' || $tag = 'H3' || $tag = 'H4') {
            $this->Ln(6);
            $this->SetFont('Arial', '', 11);
            $this->SetFontSize(11);
            $this->SetStyle('U', false);
            $this->SetStyle('B', false);
            $this->mySetTextColor(-1);
        }
        if ($tag = 'PRE') {
            $this->SetFont('Arial', '', 11);
            $this->SetFontSize(11);
            $this->PRE = false;
        }
        if ($tag = 'RED' || $tag = 'BLUE') {
            $this->mySetTextColor(-1);
        }
        if ($tag = 'BLOCKQUOTE') {
            $this->mySetTextColor(0, 0, 0);
            $this->Ln(3);
        }
        if ($tag == 'STRONG') {
            $tag = 'B';
        }
        if ($tag == 'EM') {
            $tag = 'I';
        }
        if ((!$this->bi) && $tag == 'B') {
            $tag = 'U';
        }
        if ($tag == 'B' or $tag == 'I' or $tag == 'U') {
            $this->SetStyle($tag, false);
        }
        if ($tag == 'A') {
            $this->HREF = '';
        }
        if ($tag == 'FONT') {
            if ($this->issetcolor == true) {
                $this->SetTextColor(0, 0, 0);
            }
            if ($this->issetfont) {
                $this->SetFont('Arial', '', 11);
                $this->issetfont = false;
            }
        }
    }

    function Footer() {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->SetTextColor(100, 100, 100);
        $this->Cell(0, 10, 'Generated by Neyra Proposal Management System, owned by Neyra Industries, Inc.', 0, 0, 'C');
        $this->Ln(5);
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
        //Go to 1.5 cm from bottom
        //        $this->SetY(-15);
        //Select Arial italic 8
        //        $this->SetFont('Times', '', 8);
        //Print centered page number
        //        $this->SetTextColor(0, 0, 0);
        //        $this->Cell(0, 4, 'Page ' . $this->PageNo() . '/{nb}', 0, 1, 'C');
        //        $this->SetTextColor(0, 0, 180);
        //        $this->Cell(0, 4, 'Created by HTML2PDF / FPDF', 0, 0, 'C', 0, 'http://hulan.info/blog/');
        //        $this->mySetTextColor(-1);
    }

    function Header() {
        //Select Arial bold 15
        //        $this->SetTextColor(0, 0, 0);
        //        $this->SetFont('Times', '', 10);
        //        $this->Cell(0, 10, $this->articletitle, 0, 0, 'C');
        //        $this->Ln(4);
        //        $this->Cell(0, 10, $this->articleurl, 0, 0, 'C');
        //        $this->Ln(7);
        //        $this->Line($this->GetX(), $this->GetY(), $this->GetX() + 187, $this->GetY());
        //Line break
        //        $this->Ln(12);
        //        $this->SetFont('Arial', '', 11);
        //        $this->mySetTextColor(-1);
    }

    function SetStyle($tag, $enable) {
        $this->$tag += ($enable ? 1 : -1);
        $style = '';
        foreach (array('B', 'I', 'U') as $s)
            if ($this->$s > 0) {
                $style .= $s;
            }
        $this->SetFont('', $style);
    }

    function PutLink($URL, $txt) {
        //Put a hyperlink
        $this->SetTextColor(0, 0, 255);
        $this->SetStyle('U', true);
        $this->Write(5, $txt, $URL);
        $this->SetStyle('U', false);
        $this->mySetTextColor(-1);
    }

    function PutLine() {
        $this->Ln(2);
        $this->Line($this->GetX(), $this->GetY(), $this->GetX() + 187, $this->GetY());
        $this->Ln(3);
    }

    function mySetTextColor($r, $g = 0, $b = 0) {
        static $_r = 0, $_g = 0, $_b = 0;

        if ($r == -1) {
            $this->SetTextColor($_r, $_g, $_b);
        }
        else {
            $this->SetTextColor($r, $g, $b);
            $_r = $r;
            $_g = $g;
            $_b = $b;
        }
    }

    function PutMainTitle($title) {
        if (strlen($title) > 55) {
            $title = substr($title, 0, 55) . "...";
        }
        $this->SetTextColor(33, 32, 95);
        $this->SetFontSize(20);
        $this->SetFillColor(255, 204, 120);
        $this->Cell(0, 20, $title, 1, 1, "C", 1);
        $this->SetFillColor(255, 255, 255);
        $this->SetFontSize(11);
        $this->Ln(5);
    }

    function PutMinorHeading($title) {
        $this->SetFontSize(11);
        $this->Cell(0, 5, $title, 0, 1, "C");
        $this->SetFontSize(11);
    }

    function PutMinorTitle($title, $url = '') {
        $title = str_replace('http://', '', $title);
        if (strlen($title) > 70) {
            if (!(strrpos($title, '/') == false)) {
                $title = substr($title, strrpos($title, '/') + 1);
            }
        }
        $title = substr($title, 0, 70);
        $this->SetFontSize(16);
        if ($url != '') {
            $this->SetStyle('U', false);
            $this->SetTextColor(0, 0, 180);
            $this->Cell(0, 6, $title, 0, 1, "C", 0, $url);
            $this->SetTextColor(0, 0, 0);
            $this->SetStyle('U', false);
        } else
        {
            $this->Cell(0, 6, $title, 0, 1, "C", 0);
        }
        $this->SetFontSize(11);
        $this->Ln(4);
    }
} // class PDF

/*OLD CODE...*/
/*
//Some useful functions
function hex2dec($color = "#000000") {
    $tbl_color = array();
    $tbl_color['R'] = hexdec(substr($color, 1, 2));
    $tbl_color['G'] = hexdec(substr($color, 3, 2));
    $tbl_color['B'] = hexdec(substr($color, 5, 2));
    return $tbl_color;
}

function px2mm($px) {
    return $px * 25.4 / 72;
}

function txtentities($html) {
    $trans = get_html_translation_table(HTML_ENTITIES);
    $trans = array_flip($trans);
    return strtr($html, $trans);
}

class PDF extends FPDF {
    var $B;
    var $I;
    var $U;
    var $HREF;
    var $listType;
    var $listSeparator;
    var $listCounter;

    function PDF($orientation = 'P', $unit = 'mm', $size = 'A4') {
        $this->FPDF($orientation, $unit, $size);
        $this->B = 0;
        $this->I = 0;
        $this->U = 0;
        $this->HREF = '';
        $this->listSeparator = chr(149);
        $this->listCounter = 0;
        $this->listIndent = 6;
        $this->listType = 'UL';
    }

    function Header() {
        // Logo
        //        $this->Image('logo.png', 10, 6, 30);
        // Arial bold 15
        //        $this->SetFont('Arial', 'B', 15);
        // Move to the right
        //        $this->Cell(80);
        // Title
        //        $this->Cell(30, 10, 'Title', 1, 0, 'C');
        // Line break
        //        $this->Ln(20);
    }

    function Footer() {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->SetTextColor(100, 100, 100);
        $this->Cell(0, 10, 'Generated by Neyra Proposal Management System, owned by Neyra Industries, Inc.', 0, 0, 'C');
        $this->Ln(5);
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }

    function WriteHTML($html) {
        // HTML parser
        $html = str_replace("\n", ' ', $html);
        $a = preg_split('/<(.*)>/U', $html, -1, PREG_SPLIT_DELIM_CAPTURE);
        $isListItem = false;
        foreach ($a as $i => $e) {
            if ($i % 2 == 0) {
                if ($isListItem) {
                    $this->MultiCell(0, 5, $e);
                    $isListItem = false;
                } else {
                    // Text
                    if ($this->HREF) {
                        $this->PutLink($this->HREF, $e);
                    } else {
                        $this->Write(5, $e);
                    }
                }
            } else {
                // Tag
                if ($e[0] == '/') {
                    $this->CloseTag(strtoupper(substr($e, 1)));
                } else {
                    // Extract attributes
                    $a2 = explode(' ', $e);
                    $tag = strtoupper(array_shift($a2));
                    $attr = array();
                    foreach ($a2 as $v) {
                        if (preg_match('/([^=]*)=["\']?([^"\']*)/', $v, $a3)) {
                            $attr[strtoupper($a3[1])] = $a3[2];
                        }
                    }
                    $this->OpenTag($tag, $attr);
                    if ($tag == 'LI') {
                        $isListItem = true;
                    }
                }
            }
        }
    }

    function OpenTag($tag, $attr) {
        if ($tag == 'B' || $tag == 'I' || $tag == 'U') {
            $this->SetStyle($tag, true);
        } else {
            switch ($tag) {
                case 'A';
                    $this->HREF = $attr['HREF'];
                    break;
                case 'BR':
                    $this->Ln();
                    break;
                case 'UL':
                    $this->listType = $tag;
                    $this->Ln();
                    break;
                case 'OL':
                    $this->listType = $tag;
                    $this->listCounter = 0;
                    $this->Ln();
                    break;
                case 'LI';
                    if ($this->listType == 'UL') {
                        $this->Cell($this->listIndent, 5);
                        $bullet = $this->listSeparator;
                    } else {
                        $this->Cell($this->listIndent + 2, 5);
                        $this->listCounter++;
                        $bullet = $this->listCounter . '.';
                    }
                    $this->Cell(3, 5, $bullet, 0, 0, 'R');
                    break;
            }
        }
    }

    function CloseTag($tag) {
        if ($tag == 'B' || $tag == 'I' || $tag == 'U') {
            $this->SetStyle($tag, false);
        } else {
            switch ($tag) {
                case 'A':
                    $this->HREF = '';
                    break;
                case 'OL':
                    $this->listCounter = 0;
                    break;
            }
        }
    }

    function SetStyle($tag, $enable) {
        $this->$tag += ($enable ? 1 : -1);
        $style = '';
        foreach (array('B', 'I', 'U') as $s) {
            if ($this->$s > 0) {
                $style .= $s;
            }
        }
        $this->SetFont('', $style);
    }

    function PutLink($URL, $txt) {
        $this->SetTextColor(0, 0, 255);
        $this->SetStyle('U', true);
        $this->Write(5, $txt, $URL);
        $this->SetStyle('U', false);
        $this->SetTextColor(0);
    }
}*/
