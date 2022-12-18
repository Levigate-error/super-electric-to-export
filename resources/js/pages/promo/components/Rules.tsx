import * as React from 'react';

const Rules = () => (
    <div className="promo-rules" id="rules">
        <h2 className="promo-rules__title">Правила акции</h2>
        <p className="promo-rules__subtitle">Сроки проведения с 1 ноября по 31 декабря</p>
        <div className="promo-rules__box">
            <article className="promo-rules__rule rule">
                <section className="rule__wrapper">
                    <img src="./images/promo/Coin.svg" alt="" className="rule__img" />
                    <p className="rule__desc">Покупай и устанавливай оборудование Legrand INSPIRIA</p>
                </section>
                <div className="rule__cube"></div>
            </article>
            <article className="promo-rules__rule rule">
                <section className="rule__wrapper">
                    <img src="./images/promo/Chek.svg" alt="" className="rule__img" />
                    <p className="rule__desc">Регистрируй чеки <span>на&nbsp;сайте или через</span></p>
                </section>
                <a href="https://api.whatsapp.com/send?phone=79670986132" className="rule__btn">
                    <img src="./images/promo/Whatsapp.png" />
                    WhatsApp-Бот
                </a>
                <a  href="http://t.me/legrand_promoel_bot" className="rule__btn">
                    <img src="./images/promo/TG.png" />
                    Telegram-Бот
                </a>
                <div className="rule__cube"></div>
            </article>
            <article className="promo-rules__rule rule">
                <section className="rule__wrapper">
                    <img src="./images/promo/Gift.svg" alt="" className="rule__img" />
                    <p className="rule__desc">Совершай больше покупок, копи баллы и обменивай на&nbsp;призы</p>
                </section>
                <a  href="/rules_el.pdf" className="rule__btn">
                    Полные правила
                </a>
            </article>
        </div>
    </div>
);
export default Rules;
