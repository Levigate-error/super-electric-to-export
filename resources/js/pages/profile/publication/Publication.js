"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const React = require("react");
const react_1 = require("react");
const Button_1 = require("../../../ui/Button");
const Modal_1 = require("../../../ui/Modal");
const api_1 = require("./api");
const btnStyle = {
    marginBottom: 20,
    marginTop: 20,
    fontSize: 12,
};
const Publication = ({ user }) => {
    const [published, setPublished] = react_1.useState(user.published);
    const [isLoading, setIsLoading] = react_1.useState(false);
    const [photoModalVisibility, setPhotoModalVisibility] = React.useState(false);
    const handlePublish = () => {
        setIsLoading(true);
        !user.photo
            ? setPhotoModalVisibility(true)
            : api_1.publishProfile({ published: true })
                .then(response => {
                setPublished(true);
            })
                .finally(() => {
                setIsLoading(false);
            });
    };
    const handleDisablePublish = () => {
        setIsLoading(true);
        api_1.publishProfile({ published: false })
            .then(response => {
            setPublished(false);
        })
            .finally(() => {
            setIsLoading(false);
        });
    };
    const handleModalClose = () => {
        setIsLoading(false);
        setPhotoModalVisibility(false);
    };
    return (React.createElement("div", { className: "loyality-info-wrapper" },
        photoModalVisibility && (React.createElement(Modal_1.default, { isOpen: photoModalVisibility, onClose: handleModalClose },
            React.createElement("h5", null, "\u0417\u0430\u0433\u0440\u0443\u0437\u0438\u0442\u0435 \u0444\u043E\u0442\u043E"),
            React.createElement("p", null, "\u0414\u043B\u044F \u043F\u0443\u0431\u043B\u0438\u043A\u0430\u0446\u0438\u0438 \u043F\u0440\u043E\u0444\u0438\u043B\u044F \u043D\u0435\u043E\u0431\u0445\u043E\u0434\u0438\u043C\u043E \u0437\u0430\u0433\u0440\u0443\u0437\u0438\u0442\u044C \u0412\u0430\u0448\u0443 \u0444\u043E\u0442\u043E\u0433\u0440\u0430\u0444\u0438\u044E \u0432 \u043F\u0440\u043E\u0444\u0438\u043B\u0435."))),
        published ? (React.createElement(React.Fragment, null,
            React.createElement("div", { className: "loyality-publish-wrapper" },
                React.createElement("span", null,
                    "\u0412\u0430\u0448 \u043F\u0440\u043E\u0444\u0438\u043B\u044C \u043E\u043F\u0443\u0431\u043B\u0438\u043A\u043E\u0432\u0430\u043D \u043D\u0430",
                    ' ',
                    React.createElement("a", { href: "https://legrand.ru/smart-home", target: "_blank" }, "https://legrand.ru/smart-home"))),
            React.createElement(Button_1.default, { onClick: handleDisablePublish, value: "Отменить публикацию", appearance: "second", style: btnStyle, isLoading: isLoading, disabled: isLoading }))) : (React.createElement(React.Fragment, null,
            React.createElement("div", { className: "loyality-publish-wrapper" },
                React.createElement("span", null,
                    "\u041E\u043F\u0443\u0431\u043B\u0438\u043A\u0443\u0439\u0442\u0435 \u0441\u0432\u043E\u0439 \u043F\u0440\u043E\u0444\u0438\u043B\u044C \u043D\u0430",
                    ' ',
                    React.createElement("a", { href: "https://legrand.ru/smart-home", target: "_blank" }, "https://legrand.ru/smart-home"))),
            React.createElement(Button_1.default, { onClick: handlePublish, isLoading: isLoading, value: "Опубликовать", appearance: "accent", style: btnStyle, disabled: isLoading })))));
};
exports.default = Publication;
