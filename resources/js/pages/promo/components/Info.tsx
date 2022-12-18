import * as React from 'react';

const Info = () => (
    <div className="promo-info">
        <div className="promo-info__title">
            <h1>Inspiria</h1>
            <p>Вдохновение в квадрате</p>
        </div>

        <div className="promo-info__subtitle">
            <h2>Выгода в кубе</h2>
            <div className="promo-info__info-desc info-desc">
                <div className="info-desc__el">
                    <div className="info-desc__el-number">
                        <span>1</span>
                    </div>
                    <div className="info-desc__el-text">
                        Качественная
                        <br />
                        продукция
                    </div>
                </div>
                <div className="info-desc__el">
                    <div className="info-desc__el-number">
                        <span>2</span>
                    </div>
                    <div className="info-desc__el-text">
                        Довольные
                        <br />
                        клиенты
                    </div>
                </div>
                <div className="info-desc__el">
                    <div className="info-desc__el-number">
                        <span>3</span>
                    </div>
                    <div className="info-desc__el-text">
                        Ценные
                        <br />
                        призы
                    </div>
                </div>
            </div>
        </div>

        <div className="promo-info__more">
            <p>Покупай продукцию из новой коллекции Inspiria и получи шанс выиграть ценные призы!</p>
            {/*<button type="button" className="promo-info__button">*/}
            {/*    Подробнее*/}
            {/*</button>*/}
        </div>

        <img src="./images/promo/promo-img.png" alt="" className="promo-info__img" />
        <img src="./images/promo/promo-img-mobile.png" alt="" className="promo-info__img--mobile" />
    </div>
);
export default Info;
