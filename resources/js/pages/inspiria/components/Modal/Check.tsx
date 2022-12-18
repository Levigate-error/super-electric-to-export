import * as React from 'react';

const Check = ({ setModalIsOpen }) => (
    <React.Fragment>
        <h1 className="mb-3 loyalty-modal__title">Ваши данные на проверке</h1>
        <p>Мы пришлем вам уведомление когда проверим корректность введенных данных</p>
        <button
            type="button"
            className="loyalty-modal__btn loyalty-modal__btn--red"
            onClick={() => setModalIsOpen(false)}
        >
            Понятно
        </button>
    </React.Fragment>
);
export default Check;
