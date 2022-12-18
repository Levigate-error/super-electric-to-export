"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const React = require("react");
const classnames_1 = require("classnames");
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
        setFileStatus(Object.assign({}, fileStatus, { [inputId]: countFile }));
    };
    const handleSubmit = e => {
        e.preventDefault();
        if (Object.values(fileStatus).includes(null)) {
            return setIsValid(false);
        }
        setModalState('check');
    };
    const isLoaded = name => fileStatus[name] != null;
    return (React.createElement("div", { className: "loyalty-modal__personal-info personal-info" },
        React.createElement("h1", { className: "mb-3 loyalty-modal__title" }, "\u0414\u0430\u043D\u043D\u044B\u0435 \u0434\u043B\u044F \u043F\u043E\u043B\u0443\u0447\u0435\u043D\u0438\u044F \u043F\u0440\u0438\u0437\u0430"),
        React.createElement("p", { className: "mb-5" }, "\u0421\u0443\u043C\u043C\u0430 \u0432\u044B\u0438\u0433\u0440\u044B\u0448\u0430 \u043F\u0440\u0435\u0434\u043F\u043E\u043B\u0430\u0433\u0430\u0435\u0442 \u0443\u043F\u043B\u0430\u0442\u0443 \u043D\u0430\u043B\u043E\u0433\u043E\u0432. \u041D\u0435 \u0432\u043E\u043B\u043D\u0443\u0439\u0442\u0435\u0441\u044C, \u043C\u044B \u0431\u0435\u0440\u0435\u043C \u0434\u0430\u043D\u043D\u044B\u0435 \u0440\u0430\u0441\u0445\u043E\u0434\u044B \u043D\u0430 \u0441\u0435\u0431\u044F, \u043D\u043E \u043D\u0430\u043C \u043D\u0443\u0436\u043D\u044B \u0432\u0430\u0448\u0438 \u0434\u0430\u043D\u043D\u044B\u0435 \u0434\u043B\u044F \u043F\u0435\u0440\u0435\u0447\u0438\u0441\u043B\u0435\u043D\u0438\u044F \u043D\u0430\u043B\u043E\u0433\u043E\u0432"),
        React.createElement("form", { encType: "multipart/form-data", action: "POST", className: "personal-info__form-info form-info", onSubmit: handleSubmit },
            React.createElement("div", { className: "form-info__block" },
                React.createElement("label", { htmlFor: "series", className: "form-info__label" }, "\u0421\u0435\u0440\u0438\u044F \u043F\u0430\u0441\u043F\u043E\u0440\u0442\u0430"),
                React.createElement("input", { type: "text", id: "series", name: "series", className: "form-info__input", placeholder: "Введите серию паспорта", required: true })),
            React.createElement("div", { className: "form-info__block" },
                React.createElement("label", { htmlFor: "number", className: "form-info__label" }, "\u041D\u043E\u043C\u0435\u0440 \u043F\u0430\u0441\u043F\u043E\u0440\u0442\u0430"),
                React.createElement("input", { type: "text", id: "number", className: "form-info__input", placeholder: "Введите номер паспорта", required: true })),
            React.createElement("div", { className: "form-info__block form-info__block--max" },
                React.createElement("label", { htmlFor: "from", className: "form-info__label" }, "\u041A\u0435\u043C \u0432\u044B\u0434\u0430\u043D"),
                React.createElement("input", { type: "text", id: "from", className: "form-info__input", placeholder: "Укажите кем выдан паспорт", required: true })),
            React.createElement("div", { className: "form-info__block" },
                React.createElement("label", { htmlFor: "date", className: "form-info__label" }, "\u041A\u043E\u0433\u0434\u0430 \u0432\u044B\u0434\u0430\u043D"),
                React.createElement("input", { type: "text", id: "date", className: "form-info__input", placeholder: "ДД / ММ / ГГГГ", required: true })),
            React.createElement("div", { className: "form-info__block" },
                React.createElement("label", { htmlFor: "code", className: "form-info__label" }, "\u041A\u043E\u0434 \u043F\u043E\u0434\u0440\u0430\u0437\u0434\u0435\u043B\u0435\u043D\u0438\u044F"),
                React.createElement("input", { type: "text", id: "code", className: "form-info__input", placeholder: "Введите код подразделения", required: true })),
            React.createElement("div", { className: "form-info__block  form-info__block--max" },
                React.createElement("label", { htmlFor: "registr", className: "form-info__label" }, "\u0420\u0435\u0433\u0438\u0441\u0442\u0440\u0430\u0446\u0438\u044F"),
                React.createElement("input", { type: "text", id: "registr", className: "form-info__input", placeholder: "Введите адрес регистрации указанный в паспорте", required: true })),
            React.createElement("div", { className: "form-info__block  form-info__block--max" },
                React.createElement("label", { htmlFor: "inn", className: "form-info__label" }, "\u0418\u043D\u043D"),
                React.createElement("input", { type: "text", id: "inn", className: "form-info__input", placeholder: "Введите номер ИНН", required: true })),
            React.createElement("div", { className: "form-info__block  form-info__block--max" },
                React.createElement("label", { htmlFor: "photo-pasport", className: classnames_1.default('form-info__label', 'form-info__label--file', {
                        loaded: isLoaded('photo-pasport'),
                    }) },
                    fileStatus['photo-pasport'] === null
                        ? 'Фото паспорта разворот 2 и 3'
                        : `Загружено файлов: ${fileStatus['photo-pasport']}`,
                    React.createElement("span", null)),
                React.createElement("input", { type: "file", id: "photo-pasport", name: "photo-pasport", onChange: handleUpload, className: "form-info__input form-info__input--file", multiple: true })),
            React.createElement("div", { className: "form-info__block  form-info__block--max" },
                React.createElement("label", { htmlFor: "photo-registr", className: classnames_1.default('form-info__label', 'form-info__label--file', {
                        loaded: isLoaded('photo-registr'),
                    }) },
                    fileStatus['photo-registr'] === null
                        ? 'Фото страницы регистрации паспорта'
                        : `Загружено файлов: ${fileStatus['photo-registr']}`,
                    React.createElement("span", null)),
                React.createElement("input", { type: "file", id: "photo-registr", onChange: handleUpload, className: "form-info__input form-info__input--file", multiple: true })),
            React.createElement("div", { className: "form-info__block  form-info__block--max" },
                React.createElement("label", { htmlFor: "photo-inn", className: classnames_1.default('form-info__label', 'form-info__label--file', { loaded: isLoaded('photo-inn') }) },
                    fileStatus['photo-inn'] === null
                        ? 'Фото страницы ИНН'
                        : `Загружено файлов: ${fileStatus['photo-inn']}`,
                    React.createElement("span", null)),
                React.createElement("input", { type: "file", id: "photo-inn", onChange: handleUpload, className: "form-info__input form-info__input--file", multiple: true })),
            !isValid && (React.createElement("p", { className: "form-info__error" }, "\u041D\u0435\u043E\u0431\u0445\u043E\u0434\u0438\u043C\u043E \u043F\u0440\u0438\u043A\u0440\u0435\u043F\u0438\u0442\u044C \u0432\u0441\u0435 \u043D\u0435\u043E\u0431\u0445\u043E\u0434\u0438\u043C\u044B\u0435 \u0444\u043E\u0442\u043E\u0433\u0440\u0430\u0444\u0438\u0438 \u0434\u043E\u043A\u0443\u043C\u0435\u043D\u0442\u043E\u0432.")),
            React.createElement("button", { type: "submit", className: "form-info__btn" }, "\u041E\u0442\u043F\u0440\u0430\u0432\u0438\u0442\u044C"))));
};
exports.default = PersonalInfo;
