<?php

use Illuminate\Database\Seeder;
use Database\Seeds\Helpers\CertificateResources;
use App\Domain\ServiceContracts\CertificateServiceContract;
use Symfony\Component\Console\Helper\ProgressBar;

/**
 * Class CertificatesSeeder
 */
class CertificatesSeeder extends Seeder
{
    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     */
    public function run(): void
    {
        $resourcesHelper = new CertificateResources();
        $certificates = $resourcesHelper->getData();

        $this->saveCertificates($certificates);
    }

    /**
     * @param  array  $certificates
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function saveCertificates(array $certificates): void
    {
        $service = app()->make(CertificateServiceContract::class);

        $this->command->line('<comment>Parse certificates</comment>');
        $progressBar = new ProgressBar($this->command->getOutput());
        $progressBar->start(count($certificates));

        foreach ($certificates as $certificate) {
            $certificate = $service->getCertificateByCode($certificate);

            if ($certificate->resource !== null) {
                continue;
            }

            $service->createCertificate([
                'code' => $certificate,
            ]);

            $progressBar->advance();
        }

        $progressBar->finish();
        $this->command->line('');
    }
}
