import * as React from 'react';

const Range = () => (
    <div className="promo-range">
        <div>
            <h2 className="promo-range__subtitle">10 цветов декоративных рамок</h2>
            <a href="https://legrand.ru/products/elektroustanovochnye-izdeliya/vnutrenniy-montazh/inspiria/?cityId=510743&collections=inspiria">
                <button className="promo-range__btn promo-info__button">Полный каталог</button>
            </a>

        </div>
        <div className="promo-range__classic">
            <h2 className="promo-range__subtitle">Классические</h2>
            <img src="./images/promo/range-img-classic.png" alt="Классические" className="promo-range__img" />
        </div>
        <div className="promo-range__trand">
            <h2 className="promo-range__subtitle">Трендовые</h2>
            <img src="./images/promo/range-img-trand.png" alt="Трендовые" className="promo-range__img" />
        </div>
        <div className="promo-range__premium">
            <h2 className="promo-range__subtitle">Премиальные</h2>
            <img src="./images/promo/range-img-premium.png" alt="Премиальные" className="promo-range__img" />
        </div>
        <div className="promo-range__pastel">
            <h2 className="promo-range__subtitle">Пастельные</h2>
            <img src="./images/promo/range-img.png" alt="Пастельные" className="promo-range__img" />
        </div>
        <a href="https://legrand.ru/products/elektroustanovochnye-izdeliya/vnutrenniy-montazh/inspiria/?cityId=510743&collections=inspiria">
            <button className="promo-range__btn--mobile promo-info__button">Полный каталог</button>
        </a>

    </div>
);
export default Range;
