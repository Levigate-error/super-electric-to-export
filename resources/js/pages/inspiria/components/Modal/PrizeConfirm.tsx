import * as React from 'react';
import {choseGift} from '../../api';
import {useState} from "react";

const PrizeConfirm = ({ setModalState, prizePoints, prizeName, prizeNumber, currentPoints, setCurrentPoints}) => {
    const [buttonText, setButtonText] = React.useState('Выбор приза');
    const [loading, setLoading] = useState(false)

    const handleConfirm = () => {
        const chozenPoints = prizePoints
        setLoading(true)
        choseGift(prizeNumber).then(response => {
            if (response.status != 200){
                setButtonText('Ошибка запроса')
            }
            else {
                setCurrentPoints(currentPoints -= chozenPoints);
                setModalState('prize-check');
            }
            setLoading(false)
        });
    };

    return (
        <React.Fragment>
        <h1 className="mb-3 loyalty-modal__title">{buttonText}</h1>
        <p>Вы выбрали приз “{prizeName}”
            с вашего баланса баллов будет списано {prizePoints} баллов</p>
        <button
            type="button"
            className="loyalty-modal__btn loyalty-modal__btn--red"
            onClick={handleConfirm}
            disabled={loading}
        >
            Согласен
        </button>
    </React.Fragment>
    );
};
export default PrizeConfirm;
