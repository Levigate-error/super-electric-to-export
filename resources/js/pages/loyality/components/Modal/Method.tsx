import * as React from 'react';
import { uploadPhotoReceipt } from '../../api';

const Method = ({ setModalState }) => {
   // const [isSubmitting, setIsSubmitting] = useState<boolean>(false);

    const handleUpload = (e) => {

        console.log("files1: ", e.target.files)
        uploadPhotoReceipt(e.target.files).then(response => {
            if (response.errors) {

            } else {
                //setIsSubmitting(true);
                setModalState('check');
            }
        });
    };

    return (
        <React.Fragment>
            <h1 className="mb-3 loyalty-modal__title">Регистрация чека</h1>
            <label htmlFor="file" className="mb-3 mt-4 loyalty-modal__btn loyalty-modal__btn--red">
                Загрузить из галереи
            </label>
            <input
                type="file"
                multiple
                name="file"
                id="file"
                className="loyalty-modal__input"
                onChange={(e)=>handleUpload(e)}
            />
            <button className="mb-4 loyalty-modal__btn" onClick={() => setModalState('manual')}>
                Ввести вручную
            </button>
            <span className="mb-4 loyalty-modal__title">или</span>
            <a href="https://api.whatsapp.com/send?phone=79670986132">
            <button className="mb-3 loyalty-modal__btn loyalty-modal__btn--whatsapp">
                <img src="./images/loyalty/Whatsapp.svg" alt="Whatsapp" />
                WhatsApp-Бот
            </button>
            </a>
            <a href="http://t.me/legrand_promoel_bot">
                <button className="mb-5 loyalty-modal__btn loyalty-modal__btn--tg">
                    <img src="./images/loyalty/TG.svg" alt="Telegram" />
                    Telegram-Бот
                </button>
            </a>

            <a href="#" className="loyalty-modal__link">
                Правила акции
            </a>
        </React.Fragment>
    );
};
export default Method;
