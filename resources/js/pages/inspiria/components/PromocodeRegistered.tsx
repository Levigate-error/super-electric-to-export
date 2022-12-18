import * as React from 'react';

const PromocodeRegistered = ({ onClose, promocode }) => {
    const [currentPromocode] = React.useState(promocode)

    return (
        <React.Fragment>
            <h1 className="mb-3 loyalty-modal__title">Регистрация промокода</h1>
            <p>Ваш промокод успешно зарегистрирован, не забудьте загрузить чек данной покупки, после проверки мы
                начислим ваши баллы</p>
            <button
                type="button"
                className="loyalty-modal__btn loyalty-modal__btn--red"
                onClick={() => onClose(currentPromocode)}
            >
                Отлично!
            </button>
        </React.Fragment>
    )
};
export default PromocodeRegistered;
