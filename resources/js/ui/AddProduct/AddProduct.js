"use strict";
var __awaiter = (this && this.__awaiter) || function (thisArg, _arguments, P, generator) {
    return new (P || (P = Promise))(function (resolve, reject) {
        function fulfilled(value) { try { step(generator.next(value)); } catch (e) { reject(e); } }
        function rejected(value) { try { step(generator["throw"](value)); } catch (e) { reject(e); } }
        function step(result) { result.done ? resolve(result.value) : new P(function (resolve) { resolve(result.value); }).then(fulfilled, rejected); }
        step((generator = generator.apply(thisArg, _arguments || [])).next());
    });
};
Object.defineProperty(exports, "__esModule", { value: true });
const React = require("react");
const Input_1 = require("../Input");
const Button_1 = require("../Button");
const api_1 = require("./api");
const createProjectBtn = {
    padding: 0,
    fontSize: 14,
};
function reducer(state, { type, payload }) {
    switch (type) {
        case 'fetch':
            return Object.assign({}, state, { isLoading: true, errors: [] });
        case 'set-amount':
            return Object.assign({}, state, { productCount: payload });
        case 'add-failure':
            return Object.assign({}, state, { isLoading: false, errors: payload });
        default:
            throw new Error();
    }
}
const AddProduct = ({ projects, productId, closeModal, userResource }) => {
    const [{ isLoading, productCount, errors }, dispatch] = React.useReducer(reducer, {
        isLoading: false,
        productCount: projects.map(el => (Object.assign({}, el, { amount: 0 }))),
        errors: [],
    });
    const handleChangeAmount = e => {
        const id = parseInt(e.target.dataset.id);
        const value = e.target.value || '0';
        const index = productCount.map(el => el.id).indexOf(id);
        const result = Array.from(productCount);
        result[index].amount = parseInt(value, 10);
        dispatch({ type: 'set-amount', payload: result });
    };
    const addProduct = () => __awaiter(this, void 0, void 0, function* () {
        dispatch({ type: 'fetch' });
        const params = {
            product: productId,
            projects: productCount
                .filter(el => el.amount && el.amount > 0)
                .map(el => ({ project: el.id, amount: el.amount })),
        };
        api_1.addProductRequest(params).then(response => {
            response.data
                ? closeModal()
                : dispatch({
                    type: 'add-failure',
                    payload: response.errors.projects,
                });
        });
    });
    const handleCreateProject = () => {
        const base_url = window.location.origin;
        api_1.createProject().then(response => {
            document.location.href = base_url + '/project/update/' + response.data.id;
        });
    };
    let lastProjectActivity = false;
    if (userResource && !Array.isArray(userResource)) {
        const project = userResource.activities.project;
        if (!Array.isArray(project)) {
            lastProjectActivity = project;
        }
    }
    const lastProject = lastProjectActivity && productCount.find(item => lastProjectActivity.source_id === item.id);
    const projectsInWork = productCount.filter(item => item.status.slug === 'in_work');
    return (React.createElement("div", { className: "add-product-wrapper" }, projects.length ? (React.createElement(React.Fragment, null,
        React.createElement("h3", null, "\u0414\u043E\u0431\u0430\u0432\u043B\u0435\u043D\u0438\u0435 \u043F\u0440\u043E\u0434\u0443\u043A\u0442\u0430 \u0432 \u043F\u0440\u043E\u0435\u043A\u0442"),
        React.createElement("ul", { className: "add-product-ul" },
            lastProjectActivity && lastProject && lastProject.status.slug === 'in_work' && (React.createElement("li", { key: lastProjectActivity.source_id, className: "add-product-li add-product-last" },
                React.createElement("span", { className: "project-title" }, lastProjectActivity.title),
                React.createElement(Input_1.default, { id: lastProjectActivity.source_id, value: lastProject.amount || 0, onChange: handleChangeAmount, type: "number" }))),
            productCount.map(item => {
                return (lastProjectActivity.source_id !== item.id &&
                    item.status.slug === 'in_work' && (React.createElement("li", { key: item.id, className: "add-product-li" },
                    React.createElement("span", { className: "project-title" }, item.title),
                    React.createElement(Input_1.default, { id: item.id, value: `${parseInt(item.amount, 10)}`, onChange: handleChangeAmount, type: "number" }))));
            }),
            !lastProject && projectsInWork.length === 0 && (React.createElement("li", { className: "add-product-in-work-projects-err" }, "\u041D\u0435\u0442 \u043F\u0440\u043E\u0435\u043A\u0442\u043E\u0432 \u0441\u043E \u0441\u0442\u0430\u0442\u0443\u0441\u043E\u043C \"\u0412 \u0440\u0430\u0431\u043E\u0442\u0435\"."))),
        errors.length > 0 && React.createElement("span", { className: "add-product-err" }, "\u041E\u0448\u0438\u0431\u043A\u0430 \u0434\u043E\u0431\u0430\u0432\u043B\u0435\u043D\u0438\u044F \u043F\u0440\u043E\u0434\u0443\u043A\u0442\u0430"),
        (!!lastProject || projectsInWork.length > 0) && (React.createElement(Button_1.default, { appearance: "accent", onClick: addProduct, value: "Добавить продукт", isLoading: isLoading })))) : (React.createElement(React.Fragment, null,
        React.createElement("h5", null, "\u0415\u0449\u0435 \u043D\u0435 \u0441\u043E\u0437\u0434\u0430\u043D\u043E \u043D\u0438 \u043E\u0434\u043D\u043E\u0433\u043E \u043F\u0440\u043E\u0435\u043A\u0442\u0430"),
        React.createElement("p", null,
            "\u0414\u043B\u044F \u0434\u043E\u0431\u0430\u0432\u043B\u0435\u043D\u0438\u0435 \u043F\u0440\u043E\u0434\u0443\u043A\u0442\u043E\u0432 \u0412\u0430\u043C \u043D\u0435\u043E\u0431\u0445\u043E\u0434\u0438\u043C\u043E",
            ' ',
            React.createElement("button", { className: "legrand-text-btn", onClick: handleCreateProject, style: createProjectBtn }, "\u0441\u043E\u0437\u0434\u0430\u0442\u044C \u043F\u0440\u043E\u0435\u043A\u0442"),
            ".")))));
};
exports.default = AddProduct;
