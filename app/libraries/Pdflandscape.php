<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 
class pdflandscape {
    
    function pdf()
    {
        $CI = & get_instance();
        log_message('Debug', 'mPDF class is loaded.');
    }
 
    function load($param=NULL)
    {
        include_once APPPATH.'third_party/mpdf/mpdf.php';
         
        if ($params == NULL)
        {
            //$param = '"en-GB-x","A4","","",10,10,10,10,6,3';         
            //$param = '"en-GB-x","A4-L","","",10,10,10,10,6,3';         
        }
         return new mPDF('utf-8', 'A4-L');
        //return new mPDF($param);
    }
}