<?php

namespace Tests\Feature\Mails;

use App\Mail\AnalogueNotFound as AnalogueNotFoundMail;
use App\Mail\Feedback as FeedbackMail;
use App\Mail\ImportNews as ImportNewsMail;
use App\Mail\LoyaltyUserAdmin as LoyaltyUserAdminMail;
use App\Mail\LoyaltyUserProposalAdmin as LoyaltyUserProposalAdminMail;
use App\Mail\ResetPassword as ResetPasswordMail;
use App\Mail\UserEmailVerification as UserEmailVerificationMail;
use App\Mail\LoyaltyUser as LoyaltyUserMail;
use App\Mail\LoyaltyUserProposal as LoyaltyUserProposalMail;
use App\Models\Feedback;
use App\Models\Loyalty\LoyaltyUser;
use App\Models\Loyalty\LoyaltyUserProposal;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Support\Facades\Mail;
use Tests\Feature\Http\Controllers\Authenticatable;

/**
 * Class SendMailsTest
 * @package Tests\Feature\Mails
 */
class SendMailsTest extends TestCase
{
    use Authenticatable;

    /**
     * @var User
     */
    protected $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = $this->createUser();

        Mail::fake();
    }

    /**
     * Не найден аналог
     */
    public function testAnalogNotFound(): void
    {
        $params = [
            'vendor_code' => 'qwerty123'
        ];

        Mail::send(new AnalogueNotFoundMail($params));

        Mail::assertQueued(AnalogueNotFoundMail::class, static function (AnalogueNotFoundMail $mail) {
            return $mail->hasTo($mail->getAddresses());
        });
    }

    /**
     * Обратная связь
     */
    public function testFeedback(): void
    {
        $feedback = factory(Feedback::class)->create();

        Mail::send(new FeedbackMail($feedback));

        Mail::assertQueued(FeedbackMail::class, static function (FeedbackMail $mail) {
            return $mail->hasTo($mail->getAddresses());
        });
    }

    /**
     * Админу. Новая рега в программе лояльности
     */
    public function testLoyaltyUserAdmin(): void
    {
        $loyaltyUser = factory(LoyaltyUser::class)->create();

        Mail::send(new LoyaltyUserAdminMail($loyaltyUser));

        Mail::assertQueued(LoyaltyUserAdminMail::class, static function (LoyaltyUserAdminMail $mail) {
            return $mail->hasTo($mail->getAddresses());
        });
    }

    /**
     * Админу. Новая рега кода продукта в программе лояльности
     */
    public function testLoyaltyUserProposalAdmin(): void
    {
        $loyaltyUserProposal = factory(LoyaltyUserProposal::class)->create();

        Mail::send(new LoyaltyUserProposalAdminMail($loyaltyUserProposal));

        Mail::assertQueued(LoyaltyUserProposalAdminMail::class, static function (LoyaltyUserProposalAdminMail $mail) {
            return $mail->hasTo($mail->getAddresses());
        });
    }

    /**
     * Смена пароля
     */
    public function testResetPassword(): void
    {
        $user = $this->user;

        Mail::send(new ResetPasswordMail($user, 'token'));

        Mail::assertQueued(ResetPasswordMail::class, static function (ResetPasswordMail $mail) use ($user) {
            return $mail->hasTo($user->email);
        });
    }

    /**
     * Подтверждение e-mail
     */
    public function testUserEmailVerification(): void
    {
        $user = $this->user;

        Mail::send(new UserEmailVerificationMail($user));

        Mail::assertQueued(UserEmailVerificationMail::class, static function (UserEmailVerificationMail $mail) use ($user) {
            return $mail->hasTo($user->email);
        });
    }

    /**
     * Юзеру. Рега в программе лояльности
     */
    public function testLoyaltyUser(): void
    {
        $user = $this->user;

        Mail::send(new LoyaltyUserMail($user));

        Mail::assertQueued(LoyaltyUserMail::class, static function (LoyaltyUserMail $mail) use ($user) {
            return $mail->hasTo($user->email);
        });
    }

    /**
     * Юзеру. Рега кода продукта в программе лояльности
     */
    public function testLoyaltyUserProposal(): void
    {
        $user = $this->user;

        Mail::send(new LoyaltyUserProposalMail($user));

        Mail::assertQueued(LoyaltyUserProposalMail::class, static function (LoyaltyUserProposalMail $mail) use ($user) {
            return $mail->hasTo($user->email);
        });
    }

    /**
     * Админу. Сообщение на почту о новой новости
     */
    public function testImportNews(): void
    {
        $news = [
            implode(';', [
                'id'     => 1,
                'title'  => 'Legrand представляет «Академию ЦОД»',
                'source' => 'https://legrand.ru/press/newslist/events/445553/',
            ]),
           implode(';', [
               'id'     => 2,
               'title'  => 'Мероприятие с LINDEX/3D DATA',
               'source' => 'https://legrand.ru/press/newslist/events/445552/',
           ]),
           implode(';', [
               'id'     => 3,
               'title'  => 'Открытие учебных классов Legrand в сочинском профессиональном техникуме',
               'source' => 'https://legrand.ru/press/newslist/events/445551/',
           ])
        ];

        Mail::send(new ImportNewsMail($news));

        Mail::assertQueued(ImportNewsMail::class, static function (ImportNewsMail $mail) {
            return $mail->hasTo($mail->getAddresses());
        });
    }
}
