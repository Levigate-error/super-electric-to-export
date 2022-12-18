"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const React = require("react");
const api_1 = require("../../api");
const Method = ({ setModalState }) => {
    // const [isSubmitting, setIsSubmitting] = useState<boolean>(false);
    const handleUpload = (e) => {
        console.log("files1: ", e.target.files);
        api_1.uploadPhotoReceipt(e.target.files).then(response => {
            if (response.errors) {
            }
            else {
                //setIsSubmitting(true);
                setModalState('check');
            }
        });
    };
    return (React.createElement(React.Fragment, null,
        React.createElement("h1", { className: "mb-3 loyalty-modal__title" }, "\u0420\u0435\u0433\u0438\u0441\u0442\u0440\u0430\u0446\u0438\u044F \u0447\u0435\u043A\u0430"),
        React.createElement("label", { htmlFor: "file", className: "mb-3 mt-4 loyalty-modal__btn loyalty-modal__btn--red" }, "\u0417\u0430\u0433\u0440\u0443\u0437\u0438\u0442\u044C \u0438\u0437 \u0433\u0430\u043B\u0435\u0440\u0435\u0438"),
        React.createElement("input", { type: "file", multiple: true, name: "file", id: "file", className: "loyalty-modal__input", onChange: (e) => handleUpload(e) }),
        React.createElement("button", { className: "mb-4 loyalty-modal__btn", onClick: () => setModalState('manual') }, "\u0412\u0432\u0435\u0441\u0442\u0438 \u0432\u0440\u0443\u0447\u043D\u0443\u044E"),
        React.createElement("span", { className: "mb-4 loyalty-modal__title" }, "\u0438\u043B\u0438"),
        React.createElement("a", { href: "https://api.whatsapp.com/send?phone=79670986132" },
            React.createElement("button", { className: "mb-3 loyalty-modal__btn loyalty-modal__btn--whatsapp" },
                React.createElement("img", { src: "./images/loyalty/Whatsapp.svg", alt: "Whatsapp" }),
                "WhatsApp-\u0411\u043E\u0442")),
        React.createElement("a", { href: "http://t.me/legrand_promoel_bot" },
            React.createElement("button", { className: "mb-5 loyalty-modal__btn loyalty-modal__btn--tg" },
                React.createElement("img", { src: "./images/loyalty/TG.svg", alt: "Telegram" }),
                "Telegram-\u0411\u043E\u0442")),
        React.createElement("a", { href: "#", className: "loyalty-modal__link" }, "\u041F\u0440\u0430\u0432\u0438\u043B\u0430 \u0430\u043A\u0446\u0438\u0438")));
};
exports.default = Method;
