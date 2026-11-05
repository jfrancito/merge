<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Greenter\Model\Despatch\Despatch;
use Greenter\Model\Company\Company;
use App\Services\SunatService;

$sunatService = new SunatService();
$despatch = new Despatch();
$company = $sunatService->getCompany();

$empresa = \App\Models\Empresa::where('id', '1CIX00000002')->first();
if ($empresa) {
    $company->setRuc($empresa->ruc)
            ->setRazonSocial($empresa->nombre);
}

$despatch->setVersion('2022')
    ->setTipoDoc('09')
    ->setSerie('T001')
    ->setCorrelativo('00000002')
    ->setFechaEmision(new \DateTime())
    ->setCompany($company);

$see = $sunatService->getGuiaSee();
$xml = $see->getXmlSigned($despatch);

echo "SIGNED XML:\n";
echo substr($xml, 0, 3000) . "\n...\n";
