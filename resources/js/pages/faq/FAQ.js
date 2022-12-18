"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const React = require("react");
const PageLayout_1 = require("../../components/PageLayout");
const FAQRow_1 = require("./components/FAQRow");
const api_1 = require("./api");
const Feedback_1 = require("../../components/Feedback");
const Button_1 = require("../../ui/Button");
class FAQ extends React.Component {
    constructor() {
        super(...arguments);
        this.state = {
            faqs: [],
            modalIsOpen: false,
        };
        this.handleToggleModal = () => this.setState({ modalIsOpen: !this.state.modalIsOpen });
        this.handleGetFaq = () => {
            api_1.getFaq({})
                .then(response => {
                if (response.data) {
                    this.setState({ faqs: response.data.faqs });
                }
            })
                .catch(err => { });
        };
    }
    componentDidMount() {
        this.handleGetFaq();
    }
    render() {
        const { faqs, modalIsOpen } = this.state;
        return (React.createElement("div", { className: "container faq-wrapper " },
            React.createElement("div", { className: "row mt-4" },
                React.createElement("div", { className: "col-12" },
                    React.createElement("h3", null, "\u041F\u043E\u043C\u043E\u0449\u044C"))),
            React.createElement("div", { className: "row mt-3" },
                React.createElement("div", { className: "col-12" },
                    React.createElement("h3", { className: "faq-page-title mt-3" }, "\u0427\u0430\u0441\u0442\u043E \u0437\u0430\u0434\u0430\u0432\u0430\u0435\u043C\u044B\u0435 \u0432\u043E\u043F\u0440\u043E\u0441\u044B"))),
            React.createElement("div", { className: "row mt-3" },
                React.createElement("div", { className: "col-sm-12 col-md-8" }, faqs.map(item => (React.createElement(FAQRow_1.default, { row: item, key: item.id }))))),
            React.createElement("div", { className: "row mt-3" },
                React.createElement("div", { className: "col-12" },
                    modalIsOpen && (React.createElement(Feedback_1.default, { isOpen: modalIsOpen, onClose: this.handleToggleModal, type: "common" })),
                    React.createElement(Button_1.default, { onClick: this.handleToggleModal, value: "Задать вопрос", appearance: "accent" })))));
    }
}
exports.FAQ = FAQ;
exports.default = PageLayout_1.default(FAQ);
