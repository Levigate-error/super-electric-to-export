"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const React = require("react");
const utils_1 = require("../../../../utils/utils");
const Modal_1 = require("../../../../ui/Modal");
const LoyalityInfo = ({ points, position, toFirtst }) => {
    const [photoModalVisibility, setPhotoModalVisibility] = React.useState(false);
    const handleClosePhotoModal = () => setPhotoModalVisibility(false);
    return (React.createElement("div", { className: "loyality-info-wrapper" },
        photoModalVisibility && (React.createElement(Modal_1.default, { isOpen: photoModalVisibility, onClose: handleClosePhotoModal },
            React.createElement("h5", null, "\u0417\u0430\u0433\u0440\u0443\u0437\u0438\u0442\u0435 \u0444\u043E\u0442\u043E"),
            React.createElement("p", null,
                "\u0414\u043B\u044F \u043F\u0443\u0431\u043B\u0438\u043A\u0430\u0446\u0438\u0438 \u043F\u0440\u043E\u0444\u0438\u043B\u044F \u043D\u0435\u043E\u0431\u0445\u043E\u0434\u0438\u043C\u043E",
                ' ',
                React.createElement("a", { className: "legrand-text-btn", href: "/user/profile" }, "\u0437\u0430\u0433\u0440\u0443\u0437\u0438\u0442\u044C"),
                ' ',
                "\u0412\u0430\u0448\u0443 \u0444\u043E\u0442\u043E\u0433\u0440\u0430\u0444\u0438\u044E."))),
        React.createElement("div", { className: "loyality-info-total-wrapper" },
            React.createElement("span", { className: "total-points" }, points),
            React.createElement("span", { className: "total-text" }, ` ${utils_1.num2str(points, ['балл', 'балла', 'баллов'])}`)),
        !!points && (React.createElement("div", { className: "loyality-rate-wrapper" },
            React.createElement("span", { className: "rate-info-row" },
                "\u0412\u044B \u043D\u0430 ",
                React.createElement("strong", null, position),
                " \u043C\u0435\u0441\u0442\u0435 \u0432 \u0440\u0435\u0439\u0442\u0438\u043D\u0433\u0435!"),
            toFirtst !== 0 && (React.createElement("span", { className: "rate-info-text" },
                "\u0417\u0430\u0440\u0435\u0433\u0438\u0441\u0442\u0440\u0438\u0440\u0443\u0439\u0442\u0435",
                React.createElement("strong", null, ` ${toFirtst} ${utils_1.num2str(toFirtst, ['код', 'кода', 'кодов'])}, `),
                "\u0447\u0442\u043E\u0431\u044B \u043F\u043E\u043F\u0430\u0441\u0442\u044C \u043D\u0430 \u043F\u0435\u0440\u0432\u043E\u0435 \u043C\u0435\u0441\u0442\u043E"))))));
};
exports.default = LoyalityInfo;
