import * as React from 'react';
import {manuallyUploadReceipt} from '../../api';
let manualData = {
    fp: "",
    fd: "",
    fn: "",
    amount: 0,
    'receipt_datetime': null,
}

const Manual = ({ setModalState, currentReceipt }) => {
  const [inputErrors,setInputErrors] = React.useState(null)

    const handleSubmit = () => {
        manuallyUploadReceipt(manualData, currentReceipt).then(response => {
          if (response && response.status === 200){
            setInputErrors(null)
            setModalState('check');
          } else if (response?.errors) {
            setInputErrors(response?.errors || null)
          }
        });
    };


    const manualDataChange = (e) =>{
        manualData[e.target.dataset.key] = e.target.value;
    }


    return (
        <React.Fragment>
            <h1 className="mb-3 loyalty-modal__title">Регистрация чека</h1>
            <h2 className="loyalty-modal__subtitle mb-3">Ввод чека вручную</h2>
            <div className="loyalty-modal__manual pb-5 mb-4">
                <div className="loyalty-modal__loyalty-form loyalty-form">
                    <div className="loyalty-form__block">
                        <label htmlFor="date" className="loyalty-form__label">
                            Дата и время покупки
                        </label>
                        <input
                            data-key="receipt_datetime"
                            type="datetime-local"
                            id="date"
                            className="loyalty-form__input"
                            placeholder="Введите дату и время"
                            required
                            onChange={(e)=>manualDataChange(e)}
                        />
                        <b className="loyalty-form__icon">1</b>
                      {inputErrors?.receipt_datetime && (<div className="loyalty-form__error">{inputErrors.receipt_datetime}</div>)}
                    </div>
                    <div className="loyalty-form__block">
                        <label htmlFor="fn" className="loyalty-form__label">
                           ФН
                        </label>
                        <input
                            data-key="fn"
                            type="text"
                            id="fn"
                            className="loyalty-form__input"
                            placeholder="Введите ФН"
                            required
                            onChange={(e)=>manualDataChange(e)}
                        />
                        <b className="loyalty-form__icon">2</b>
                      {inputErrors?.fn && (<div className="loyalty-form__error">{inputErrors.fn}</div>)}
                    </div>
                    <div className="loyalty-form__block">
                        <label htmlFor="fp" className="loyalty-form__label">
                            ФП
                        </label>
                        <input
                            type="text"
                            data-key="fp"
                            id="fp"
                            className="loyalty-form__input"
                            placeholder="Введите ФП"
                            required
                            onChange={(e)=>manualDataChange(e)}
                        />
                        <b className="loyalty-form__icon">3</b>
                      {inputErrors?.fp && (<div className="loyalty-form__error">{inputErrors.fp}</div>)}
                    </div>
                    <div className="loyalty-form__block">
                        <label htmlFor="fd" className="loyalty-form__label">
                            ФД
                        </label>
                        <input
                            data-key="fd"
                            type="text"
                            id="fd"
                            className="loyalty-form__input"
                            placeholder="Введите ФД"
                            required
                            onChange={(e)=>manualDataChange(e)}
                        />
                        <b className="loyalty-form__icon">4</b>
                      {inputErrors?.fd && (<div className="loyalty-form__error">{inputErrors.fd}</div>)}
                    </div>
                    <div className="loyalty-form__block">
                        <label htmlFor="sum" className="loyalty-form__label">
                            Сумма покупки
                        </label>
                        <input
                            data-key="amount"
                            type="text"
                            name="sum"
                            className="loyalty-form__input"
                            placeholder="Введите сумму покупки"
                            required
                            onChange={(e)=>manualDataChange(e)}
                        />
                        <b className="loyalty-form__icon">5</b>
                      {inputErrors?.amount && (<div className="loyalty-form__error">{inputErrors.amount}</div>)}
                    </div>
                    <button className="loyalty-form__btn" onClick={handleSubmit}>
                        Зарегистрироваться
                    </button>
                </div>
                <img src="./images/loyalty/check.png" alt="Пример чека" />
            </div>
        </React.Fragment>
    );
};
export default Manual;
