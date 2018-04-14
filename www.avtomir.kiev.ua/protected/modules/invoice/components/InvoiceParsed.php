<?php
/**
 * Created by PhpStorm.
 * User: alexr
 * Date: 07.03.2017
 * Time: 13:31
 */
class InvoiceParsed {
    private $origin;

    public function __construct($source){
        $this->origin = $source;
    }

    public function details() {
        $invoice = new InvoiceList();
        foreach (explode("\n", $this->origin) as $line) {
            $row = explode("\t", $line);
            if (count($row)==3) {
                $invoice->add(new InvoiceLine(new InvPartNumber($row[0], $row[1]), $row[2]));
            }
        }
        /*
         * THIS IS TEST
        $pn = new InvPartNumber("FIAT","SP149125AE");
        new DumpExit($invoice->toString(),false);
        new DumpExit($invoice->contains($pn),false);
        $invoice->remove($pn);
        new DumpExit($invoice->contains($pn),false);
        new DumpExit($invoice->toString(),false);
        */
        return $invoice;
    }
}