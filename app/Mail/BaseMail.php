<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Class BaseMail
 * @package App\Mail
 */
class BaseMail extends Mailable implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    /**
     * @var int
     */
    public $tries = 5;

    /**
     * @var string
     */
    public $title;

    /**
     * @var string
     */
    public $subTitle;

    /**
     * @var string
     */
    public $text;

    /**
     * @var string
     */
    public $buttonUrl;

    /**
     * @var string
     */
    public $buttonTitle;

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): self
    {
        return $this->markdown('emails.common');
    }

    /**
     * @return array
     */
    public function getAddresses(): array
    {
        $configAdminEmail = config('mail.admin_address');

        $emails = $this->getExtraAddressees();

        if (empty($configAdminEmail) === false) {
            $emails[] = $configAdminEmail;
        }

        return array_unique($emails);
    }

    /**
     * Получить дополнительные адреса получателей для рассылки.
     * Предполагается переопределение в конкретном письме.
     *
     * @return array
     */
    protected function getExtraAddressees(): array
    {
        return [];
    }

    /**
     * @return string
     */
    protected function getSiteHost(): string
    {
        $siteUrl = parse_url(url('/'));

        return $siteUrl['host'] ?? '';
    }
}
