"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const React = require("react");
const PageLayout_1 = require("../../components/PageLayout");
const Input_1 = require("../../ui/Input");
const Button_1 = require("../../ui/Button");
const Checkbox_1 = require("../../ui/Checkbox");
const PhoneInput_1 = require("../../ui/PhoneInput");
const Modal_1 = require("../../ui/Modal");
const antd_1 = require("antd");
const api_1 = require("./api");
const CityInput_1 = require("../../ui/CityInput");
const Publication_1 = require("./publication/Publication");
const Participate_1 = require("../loyality/components/Participate/Participate");
const btnStyle = {
    marginBottom: 20,
    marginTop: 20,
    fontSize: 12,
};
class Home extends React.Component {
    constructor() {
        super(...arguments);
        this.state = {
            firstName: this.props.store.user.first_name,
            lastName: this.props.store.user.last_name,
            personalSite: this.props.store.user.personal_site !== null ? this.props.store.user.personal_site : '',
            emailSubscription: this.props.store.user.email_subscription,
            city: this.props.store.user.city_id !== null ? this.props.store.user.city : null,
            phone: this.props.store.user.phone,
            email: this.props.store.user.email,
            currentPassword: '',
            newPassword: '',
            confirmPassword: '',
            saveUserRequest: false,
            errors: false,
            passwordUpdateRequest: false,
            passwordErrors: false,
            city_id: this.props.store.user.city_id,
            photo: this.props.store.userResource.photo === '' ? false : this.props.store.userResource.photo,
            photoName: '',
            photoError: false,
            deleteModalIsOpen: false,
            participateModalIsOpen: false,
        };
        this.fileInput = React.createRef();
        this.openNotificationWithIcon = (type, description) => {
            antd_1.notification[type]({
                message: 'Изменение учетной записи',
                description,
            });
        };
        this.handleSaveProfileSettings = () => {
            const { firstName, lastName, personalSite, emailSubscription, city_id, phone } = this.state;
            this.setState({ saveUserRequest: true, errors: false });
            const params = {
                first_name: firstName,
                last_name: lastName,
                personal_site: personalSite,
                email_subscription: emailSubscription,
                city_id,
                phone,
            };
            api_1.saveProfileSettings(params)
                .then(response => {
                if (response.errors) {
                    this.setState({ errors: response.errors });
                    throw new Error(response.message);
                }
                this.openNotificationWithIcon('success', 'Данные учетной записи успешно обновлены');
                this.setState({ saveUserRequest: false });
                location.reload();
            })
                .catch(err => {
                this.openNotificationWithIcon('error', err.message);
                this.setState({ saveUserRequest: false });
            });
        };
        this.handleUpdatePassword = () => {
            const { currentPassword, newPassword, confirmPassword } = this.state;
            this.setState({ passwordUpdateRequest: true, passwordErrors: false });
            const params = {
                current_password: currentPassword,
                new_password: newPassword,
                new_password_confirmation: confirmPassword,
            };
            api_1.updatePAssword(params)
                .then(response => {
                if (response.errors) {
                    this.setState({ passwordErrors: response.errors });
                    throw new Error(response.message);
                }
                else {
                    this.openNotificationWithIcon('success', 'Пароль успешно изменен');
                    this.setState({ passwordUpdateRequest: false });
                    location.reload();
                }
            })
                .catch(err => {
                this.openNotificationWithIcon('error', err.message);
                this.setState({ passwordUpdateRequest: false });
            });
        };
        this.handleChangeInput = e => {
            const key = e.target.name;
            const value = e.target.value;
            this.setState({
                [key]: value,
            });
        };
        this.handleChangePhone = value => {
            this.setState({ phone: value });
        };
        this.handleChangeEmailSubscription = value => {
            this.setState({ emailSubscription: value });
        };
        this.handleSelectCity = value => {
            this.setState({ city_id: value.id });
        };
        this.handleSelectPhoto = () => {
            this.setState({ photoName: this.fileInput.current.files[0].name, photoError: false });
        };
        this.handleUploadPhoto = e => {
            e.preventDefault();
            const file = this.fileInput.current.files[0];
            api_1.uploadPhoto({ file })
                .then(response => {
                if (response.errors) {
                    throw new Error(response.errors.photo[0]);
                }
                else {
                    document.location.reload();
                }
            })
                .catch(err => {
                this.setState({ photoError: err.message });
            });
        };
        this.handleDeleteUserModalOpen = () => this.setState({ deleteModalIsOpen: true });
        this.handleDeleteUserModalClose = () => this.setState({ deleteModalIsOpen: false });
        this.handleDeleteUserAccount = () => api_1.removeUser()
            .then(response => document.location.reload())
            .catch(err => { });
    }
    render() {
        const { firstName, lastName, personalSite, emailSubscription, city, phone, email, currentPassword, newPassword, confirmPassword, saveUserRequest, passwordUpdateRequest, errors, passwordErrors, photoName, photo, photoError, deleteModalIsOpen, participateModalIsOpen, } = this.state;
        const checkPassword = currentPassword === '' || newPassword === '' || confirmPassword === '' || confirmPassword !== newPassword;
        return (React.createElement("div", { className: "container mt-4 mb-3 profile-wrapper", key: "container" },
            participateModalIsOpen && (React.createElement(Modal_1.default, { isOpen: participateModalIsOpen, onClose: () => this.setState({ participateModalIsOpen: false }) },
                React.createElement(Participate_1.default, { close: () => this.setState({ participateModalIsOpen: false }) }))),
            deleteModalIsOpen && (React.createElement(Modal_1.default, { isOpen: deleteModalIsOpen, onClose: this.handleDeleteUserModalClose },
                React.createElement("h5", null, "\u0423\u0434\u0430\u043B\u0438\u0442\u044C \u043B\u0438\u0447\u043D\u044B\u0439 \u043A\u0430\u0431\u0438\u043D\u0435\u0442?"),
                React.createElement("p", null, "\u041F\u043E\u0441\u043B\u0435 \u0443\u0434\u0430\u043B\u0435\u043D\u0438\u044F \u043B\u0438\u0447\u043D\u043E\u0433\u043E \u043A\u0430\u0431\u0438\u043D\u0435\u0442\u044B \u0432\u044B \u0431\u043E\u043B\u044C\u0448\u0435 \u043D\u0435 \u0441\u043C\u043E\u0436\u0435\u0442\u0435 \u0435\u0433\u043E \u0432\u043E\u0441\u0441\u0442\u0430\u043D\u043E\u0432\u0438\u0442\u044C"),
                React.createElement("div", { className: "remove-btns-wrapper" },
                    React.createElement(Button_1.default, { value: "Удалить", appearance: "second", onClick: this.handleDeleteUserAccount }),
                    React.createElement(Button_1.default, { value: "Отмена", appearance: "accent", onClick: this.handleDeleteUserModalClose })))),
            React.createElement("div", { className: "row " },
                React.createElement("div", { className: "col-md-12" },
                    React.createElement("h1", null, "\u041C\u043E\u0439 \u043F\u0440\u043E\u0444\u0438\u043B\u044C"))),
            React.createElement("div", { className: "row" },
                React.createElement("div", { className: "col-lg-8" },
                    React.createElement("div", { className: "loyality-info-wrapper" },
                        "\u0412\u044B \u043C\u043E\u0436\u0435\u0442\u0435 \u043F\u0440\u0438\u043D\u044F\u0442\u044C \u0443\u0447\u0430\u0441\u0442\u0438\u0435 \u0432 \u043D\u0430\u0448\u0435\u0439 \u043F\u0440\u043E\u0433\u0440\u0430\u043C\u043C\u0435 \u043B\u043E\u044F\u043B\u044C\u043D\u043E\u0441\u0442\u0438 \u0438 \u043F\u043E\u043B\u0443\u0447\u0430\u0442\u044C \u0441\u0442\u0430\u0442\u0443\u0441\u043D\u044B\u0435 \u043F\u043E\u0434\u0430\u0440\u043A\u0438 \u0437\u0430 \u0434\u043E\u0441\u0442\u0438\u0436\u0435\u043D\u0438\u0435 \u0443\u0440\u043E\u0432\u043D\u0435\u0439. ",
                        React.createElement("a", { href: "/loyalty-program" }, "\u041F\u0435\u0440\u0435\u0439\u0442\u0438")))),
            React.createElement("div", { className: "row" },
                React.createElement("div", { className: "col-lg-8" }, this.props.store.user.certificates.length ? (React.createElement(Publication_1.default, { user: this.props.store.user })) : (React.createElement(Button_1.default, { onClick: () => this.setState({ participateModalIsOpen: true }), value: "Зарегистрировать сертификат", appearance: "accent", style: btnStyle })))),
            React.createElement("div", { className: "row profile-photo-row" },
                React.createElement("div", { className: "col-12" },
                    React.createElement("div", { className: "profile-photo" },
                        photo && React.createElement("img", { src: photo, className: "profile-user-photo" }),
                        React.createElement("form", { onSubmit: this.handleUploadPhoto },
                            React.createElement("label", { className: "profile-photo-label" },
                                React.createElement(antd_1.Icon, { type: "link" }),
                                " ",
                                photoName !== '' ? photoName : 'Загрузить фото',
                                React.createElement("input", { type: "file", className: "profile-photo-input", ref: this.fileInput, onChange: this.handleSelectPhoto })),
                            React.createElement("br", null),
                            photoError && React.createElement("span", { className: "profile-photo-error" }, photoError),
                            photoName !== '' && (React.createElement(Button_1.default, { type: "submit", value: "Загрузить", appearance: "accent", className: "mb-3" })))))),
            React.createElement("div", { className: "row profile-section" },
                React.createElement("div", { className: "col-lg-8" },
                    React.createElement("h3", null, "\u041F\u0435\u0440\u0441\u043E\u043D\u0430\u043B\u044C\u043D\u044B\u0435 \u0434\u0430\u043D\u043D\u044B\u0435"))),
            React.createElement("div", { className: "row mt-2" },
                React.createElement("div", { className: "col-md-4" },
                    React.createElement(Input_1.default, { onChange: this.handleChangeInput, value: firstName, placeholder: "Имя", label: "Имя", name: "firstName" })),
                React.createElement("div", { className: "col-md-4" },
                    React.createElement(Input_1.default, { onChange: this.handleChangeInput, value: lastName, placeholder: "Фамилия", label: "Фамилия", name: "lastName" }))),
            React.createElement("div", { className: "row mt-2" },
                React.createElement("div", { className: "col-md-4" },
                    React.createElement(CityInput_1.default, { onSelect: this.handleSelectCity, defaultValue: city }))),
            React.createElement("div", { className: "row mt-2" },
                React.createElement("div", { className: "col-md-4" },
                    React.createElement(PhoneInput_1.default, { defaultCountry: 'ru', value: phone, onChange: this.handleChangePhone })),
                React.createElement("div", { className: "col-md-4" },
                    React.createElement(Input_1.default, { onChange: this.handleChangeInput, value: email, placeholder: "E-mail", label: "E-mail", name: "email", disabled: true }))),
            React.createElement("div", { className: "row mt-2" },
                React.createElement("div", { className: "col-md-4" },
                    React.createElement(Input_1.default, { onChange: this.handleChangeInput, value: personalSite, placeholder: "http://example.com/", label: "Сайт или страница в соц. сетях", name: "personalSite" }))),
            React.createElement("div", { className: "row mt-3" },
                React.createElement("div", { className: "col-md-4" },
                    React.createElement(Checkbox_1.default, { checked: emailSubscription, onChange: this.handleChangeEmailSubscription, label: React.createElement("span", null,
                            React.createElement("a", { className: "legrand-text-btn", href: "/сonsent_to_receive_promotional_mailings.pdf", target: "_blank" }, "C\u043E\u0433\u043B\u0430\u0441\u0435\u043D\u00A0"),
                            "\u043F\u043E\u043B\u0443\u0447\u0430\u0442\u044C \u0440\u0430\u0441\u0441\u044B\u043B\u043A\u0438 \u043D\u0430 \u044D\u043B.\u043F\u043E\u0447\u0442\u0443"), name: "emailSubscription" }))),
            errors && (React.createElement("div", { className: "row" },
                React.createElement("div", { className: "profile-update-errors col-lg-8" }, Object.keys(errors).map((key) => errors[key].map(el => (React.createElement("span", { className: "profile-update-error", key: el }, el))))))),
            React.createElement("div", { className: "row mt-3" },
                React.createElement("div", { className: "col-md-4" },
                    React.createElement(Button_1.default, { onClick: this.handleSaveProfileSettings, value: saveUserRequest ? (React.createElement(React.Fragment, null,
                            "\u0421\u043E\u0445\u0440\u0430\u043D\u0438\u0442\u044C \u0438\u0437\u043C\u0435\u043D\u0435\u043D\u0438\u044F ",
                            React.createElement(antd_1.Icon, { type: "loading" }))) : ('Сохранить изменения') }))),
            React.createElement("div", { className: "row profile-section" },
                React.createElement("div", { className: "col-lg-8" },
                    React.createElement("h3", null, "\u041F\u0435\u0440\u0441\u043E\u043D\u0430\u043B\u044C\u043D\u044B\u0435 \u0434\u0430\u043D\u043D\u044B\u0435"))),
            React.createElement("div", { className: "row mt-2" },
                React.createElement("div", { className: "col-md-4" },
                    React.createElement(Input_1.default, { onChange: this.handleChangeInput, value: currentPassword, placeholder: "Текущий пароль", name: "currentPassword", label: "Старый пароль", isPassword: true, autoComplete: "off" }))),
            React.createElement("div", { className: "row mt-2" },
                React.createElement("div", { className: "col-md-4" },
                    React.createElement(Input_1.default, { onChange: this.handleChangeInput, value: newPassword, placeholder: "Новый пароль", label: "Новый пароль", name: "newPassword", isPassword: true, autoComplete: "off" })),
                React.createElement("div", { className: "col-md-4" },
                    React.createElement(Input_1.default, { onChange: this.handleChangeInput, value: confirmPassword, placeholder: "Подтвердите пароль", name: "confirmPassword", label: "Подтвердите пароль", isPassword: true, autoComplete: "off" }))),
            passwordErrors && (React.createElement("div", { className: "row" },
                React.createElement("div", { className: "profile-update-errors col-lg-8" }, Object.keys(passwordErrors).map((key) => passwordErrors[key].map(el => (React.createElement("span", { className: "profile-update-error", key: el }, el))))))),
            React.createElement("div", { className: "row mt-3" },
                React.createElement("div", { className: "col-md-4" },
                    React.createElement(Button_1.default, { onClick: this.handleUpdatePassword, value: passwordUpdateRequest ? (React.createElement(React.Fragment, null,
                            "\u0421\u043C\u0435\u043D\u0438\u0442\u044C \u043F\u0430\u0440\u043E\u043B\u044C ",
                            React.createElement(antd_1.Icon, { type: "loading" }))) : ('Сменить пароль'), disabled: checkPassword }))),
            React.createElement("div", { className: "row remove-account-row" },
                React.createElement("div", { className: "col-12" },
                    React.createElement("button", { className: "legrand-text-btn", onClick: this.handleDeleteUserModalOpen }, "\u0423\u0434\u0430\u043B\u0438\u0442\u044C \u043B\u0438\u0447\u043D\u044B\u0439 \u043A\u0430\u0431\u0438\u043D\u0435\u0442")))));
    }
}
exports.default = PageLayout_1.default(Home);
