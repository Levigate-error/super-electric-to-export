import * as React from 'react';
import cn from 'classnames';

const PersonalInfo = ({ setModalState }) => {
    const [isValid, setIsValid] = React.useState(true);
    const [fileStatus, setFileStatus] = React.useState({
        'photo-pasport': null,
        'photo-registr': null,
        'photo-inn': null,
    });

    const handleUpload = e => {
        const inputId = e.target.id;
        const countFile = e.target.files.length;
        setFileStatus({ ...fileStatus, [inputId]: countFile });
    };

    const handleSubmit = e => {
        e.preventDefault();
        if (Object.values(fileStatus).includes(null)) {
            return setIsValid(false);
        }
        setModalState('check');
    };

    const isLoaded = name => fileStatus[name] != null;

    return (
        <div className="loyalty-modal__personal-info personal-info">
            <h1 className="mb-3 loyalty-modal__title">Данные для получения приза</h1>
            <p className="mb-5">
                Сумма выигрыша предполагает уплату налогов. Не волнуйтесь, мы берем данные расходы на себя, но нам нужны
                ваши данные для перечисления налогов
            </p>
            <form
                encType="multipart/form-data"
                action="POST"
                className="personal-info__form-info form-info"
                onSubmit={handleSubmit}
            >
                <div className="form-info__block">
                    <label htmlFor="series" className="form-info__label">
                        Серия паспорта
                    </label>
                    <input
                        type="text"
                        id="series"
                        name="series"
                        className="form-info__input"
                        placeholder="Введите серию паспорта"
                        required
                    />
                </div>
                <div className="form-info__block">
                    <label htmlFor="number" className="form-info__label">
                        Номер паспорта
                    </label>
                    <input
                        type="text"
                        id="number"
                        className="form-info__input"
                        placeholder="Введите номер паспорта"
                        required
                    />
                </div>
                <div className="form-info__block form-info__block--max">
                    <label htmlFor="from" className="form-info__label">
                        Кем выдан
                    </label>
                    <input
                        type="text"
                        id="from"
                        className="form-info__input"
                        placeholder="Укажите кем выдан паспорт"
                        required
                    />
                </div>
                <div className="form-info__block">
                    <label htmlFor="date" className="form-info__label">
                        Когда выдан
                    </label>
                    <input type="text" id="date" className="form-info__input" placeholder="ДД / ММ / ГГГГ" required />
                </div>
                <div className="form-info__block">
                    <label htmlFor="code" className="form-info__label">
                        Код подразделения
                    </label>
                    <input
                        type="text"
                        id="code"
                        className="form-info__input"
                        placeholder="Введите код подразделения"
                        required
                    />
                </div>
                <div className="form-info__block  form-info__block--max">
                    <label htmlFor="registr" className="form-info__label">
                        Регистрация
                    </label>
                    <input
                        type="text"
                        id="registr"
                        className="form-info__input"
                        placeholder="Введите адрес регистрации указанный в паспорте"
                        required
                    />
                </div>
                <div className="form-info__block  form-info__block--max">
                    <label htmlFor="inn" className="form-info__label">
                        Инн
                    </label>
                    <input type="text" id="inn" className="form-info__input" placeholder="Введите номер ИНН" required />
                </div>
                <div className="form-info__block  form-info__block--max">
                    <label
                        htmlFor="photo-pasport"
                        className={cn('form-info__label', 'form-info__label--file', {
                            loaded: isLoaded('photo-pasport'),
                        })}
                    >
                        {fileStatus['photo-pasport'] === null
                            ? 'Фото паспорта разворот 2 и 3'
                            : `Загружено файлов: ${fileStatus['photo-pasport']}`}
                        <span></span>
                    </label>
                    <input
                        type="file"
                        id="photo-pasport"
                        name="photo-pasport"
                        onChange={handleUpload}
                        className="form-info__input form-info__input--file"
                        multiple
                    />
                </div>
                <div className="form-info__block  form-info__block--max">
                    <label
                        htmlFor="photo-registr"
                        className={cn('form-info__label', 'form-info__label--file', {
                            loaded: isLoaded('photo-registr'),
                        })}
                    >
                        {fileStatus['photo-registr'] === null
                            ? 'Фото страницы регистрации паспорта'
                            : `Загружено файлов: ${fileStatus['photo-registr']}`}
                        <span></span>
                    </label>
                    <input
                        type="file"
                        id="photo-registr"
                        onChange={handleUpload}
                        className="form-info__input form-info__input--file"
                        multiple
                    />
                </div>
                <div className="form-info__block  form-info__block--max">
                    <label
                        htmlFor="photo-inn"
                        className={cn('form-info__label', 'form-info__label--file', { loaded: isLoaded('photo-inn') })}
                    >
                        {fileStatus['photo-inn'] === null
                            ? 'Фото страницы ИНН'
                            : `Загружено файлов: ${fileStatus['photo-inn']}`}
                        <span></span>
                    </label>
                    <input
                        type="file"
                        id="photo-inn"
                        onChange={handleUpload}
                        className="form-info__input form-info__input--file"
                        multiple
                    />
                </div>
                {!isValid && (
                    <p className="form-info__error">Необходимо прикрепить все необходимые фотографии документов.</p>
                )}
                <button type="submit" className="form-info__btn">
                    Отправить
                </button>
            </form>
        </div>
    );
};
export default PersonalInfo;
