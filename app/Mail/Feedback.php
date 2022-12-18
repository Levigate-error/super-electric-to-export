<?php

namespace App\Mail;

use App\Domain\Dictionaries\Setting\SettingDictionary;
use App\Helpers\SettingAddressHelper;
use App\Models\Feedback as FeedbackModel;

/**
 * Class Feedback
 * @package App\Mail
 */
class Feedback extends BaseMail
{
    /**
     * @var array
     */
    public $params;

    /**
     * Feedback constructor.
     *
     * @param FeedbackModel $feedback
     */
    public function __construct(FeedbackModel $feedback)
    {
        $siteHost = $this->getSiteHost();
        $addressees = $this->getAddresses();

        $this->to($addressees);
        $this->subject(__('feedback.email.subject', ['url' => $siteHost]));

        $this->params = $feedback->toArray();
        $this->title = __('feedback.email.title');
        $this->text = __('feedback.email.text', ['url' => $siteHost]);
        $this->buttonUrl = route('admin.feedback.edit', ['feedback' => $feedback->id]);
        $this->buttonTitle = __('feedback.email.button-title');
    }

    /**
     * {@inheritDoc}
     */
    protected function getExtraAddressees(): array
    {
        return SettingAddressHelper::get(SettingDictionary::FEEDBACK_EMAILS);
    }
}
