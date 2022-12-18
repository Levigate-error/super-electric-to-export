import * as React from 'react';

const Prize = () => (
    <div className="promo-prize" id="prize">
        <div className="promo-prize__sides" />
        <h2 className="promo-prize__title">Получай призы</h2>
        <p className="promo-prize__subtitle">
            Копи баллы с покупок продукции Legrand Inspiria и обменивай их на ценные призы
        </p>
        <div className="promo-prize__box">
            <article className="promo-prize__prize-card prize-card">
                <div className="prize-card__month">Наборы управления Netatmo</div>
                <div className="prize-card__img">
                    <div>
                        <img src="./images/promo/prize-img1.png" alt="Наборы управления Netatmo" className="double" />
                    </div>
                    {/*<span>+</span>*/}
                    <div>
                        <img src="./images/promo/prize-img2.png" alt="Наборы управления Netatmo" />
                    </div>
                </div>
                <div className="prize-card__desc">
                    Для управления светом
                </div>
            </article>
            <article className="promo-prize__prize-card prize-card">
                <div className="prize-card__month">Наборы ЭУИ Legrand</div>
                <div className="prize-card__img">
                    <div>
                        <img src="./images/promo/prize-img3.png" alt="Наборы ЭУИ Legrand" />
                    </div>
                    {/*<span>+</span>*/}
                    <div>
                        <img src="./images/promo/prize-img4.png" alt="Наборы ЭУИ Legrand" />
                    </div>
                </div>
                <div className="prize-card__desc">
                    Серий Quteo, Plexo, Inspiria, Valena Life/<br/>Allure, DX3
                </div>
            </article>
            <article className="promo-prize__prize-card prize-card">
                <div className="prize-card__month">Денежные призы на Qiwi-кошелёк</div>
                <div className="prize-card__img">
                    <div>
                        <img src="./images/promo/prize-img5.png" alt="Денежные призы на Qiwi-кошелёк" />
                    </div>
                    {/*<span>+</span>*/}
                    {/*<div>*/}
                    {/*    <img src="./images/promo/prize-img6.png" alt="Поясная сумка электрика" />*/}
                    {/*</div>*/}
                </div>
                <div className="prize-card__desc">
                    3000 рублей
                </div>
            </article>
            <article className="promo-prize__prize-card prize-card">
                <div className="prize-card__month">Источник бесперебойного питания</div>
                <div className="prize-card__img">
                    <div>
                        <img src="./images/promo/prize-img7.png" alt="Источник бесперебойного питания" />
                    </div>
                    {/*<span>+</span>*/}
                    {/*<div>*/}
                    {/*    <img src="./images/promo/prize-img8.png" alt="Изолированные бокорезы" />*/}
                    {/*</div>*/}
                </div>
                <div className="prize-card__desc">
                    Keor Multiplug 600 ВА
                </div>
            </article>
        </div>
        <p className="promo-prize__mark">
            И другие ценные призы
        </p>
    </div>
);
export default Prize;
