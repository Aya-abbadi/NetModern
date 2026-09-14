<?php

require 'vendor/autoload.php';

use Dompdf\Dompdf;

$dompdf = new Dompdf();

$html = "
<h1>NetModern</h1>
<h2>Test PDF réussi !</h2>
<p>Félicitations ! DomPDF fonctionne correctement.</p>
";

$dompdf->loadHtml($html);

$dompdf->setPaper('A4', 'portrait');

$dompdf->render();

$dompdf->stream("test.pdf", ["Attachment" => false]);