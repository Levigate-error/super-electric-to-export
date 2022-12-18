import * as React from 'react';

const PrizeConfirm = ({ setModalState, prizePoints}) => {

  console.log('TEST PRIZE LOG')
    const handleConfirm = () => {
        setModalState('prize-check');
    };

    return (
        <React.Fragment>
        <h1 className="mb-3 loyalty-modal__title">Выбор приза aaaaa</h1>
        <p>Вы выбрали приз “Футболка Superelektrik”
            с вашего баланса баллов будет списано {prizePoints} баллов</p>
        <button
            type="button"
            className="loyalty-modal__btn loyalty-modal__btn--red"
            onClick={handleConfirm}
        >
            Согласен
        </button>
    </React.Fragment>
    );
};
export default PrizeConfirm;
