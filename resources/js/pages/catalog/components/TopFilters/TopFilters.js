"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const React = require("react");
const antd_1 = require("antd");
const classnames_1 = require("classnames");
const react_switch_1 = require("react-switch");
const AuthRegister_1 = require("../../../../components/AuthRegister");
const PageLayout_1 = require("../../../../components/PageLayout/PageLayout");
const Icons_1 = require("../../../../ui/Icons/Icons");
class TopFilters extends React.Component {
    constructor() {
        super(...arguments);
        this.state = {
            sortASC: true,
            authModalIsOpen: false,
        };
        this.resetTopFilters = () => {
            this.setState({ sortASC: true });
        };
        this.handleToggleFavorites = () => {
            const { actions: { onToggleFavorites }, } = this.props;
            onToggleFavorites();
        };
        this.handleChangeDisplayFormat = () => {
            const { actions: { onChangeDisplayFormat }, } = this.props;
            onChangeDisplayFormat();
        };
        this.menu = () => {
            const { sortColumn, productsSort } = this.props;
            return (React.createElement(antd_1.Menu, null,
                React.createElement(antd_1.Menu.Item, { className: classnames_1.default('sort-control-legrand-dropdown-item', {
                        'selected-sort-item': sortColumn === 'recommended_retail_price' && !productsSort,
                    }), onClick: this.props.actions.onSortByPriceDesc },
                    React.createElement("span", { className: "sort-control-legrand-text-btn" }, "\u043F\u043E \u0443\u0431\u044B\u0432\u0430\u043D\u0438\u044E \u0446\u0435\u043D\u044B")),
                React.createElement(antd_1.Menu.Item, { className: classnames_1.default('sort-control-legrand-dropdown-item', {
                        'selected-sort-item': sortColumn === 'recommended_retail_price' && productsSort,
                    }), onClick: this.props.actions.onSortByPriceAsc },
                    React.createElement("span", { className: "sort-control-legrand-text-btn" }, "\u043F\u043E \u0432\u043E\u0437\u0440\u0430\u0441\u0442\u0430\u043D\u0438\u044E \u0446\u0435\u043D\u044B")),
                React.createElement(antd_1.Menu.Item, { className: classnames_1.default('sort-control-legrand-dropdown-item', {
                        'selected-sort-item': sortColumn === 'rank',
                    }), onClick: this.props.actions.onSortByRate },
                    React.createElement("span", { className: "sort-control-legrand-text-btn" }, "\u043F\u043E \u043F\u043E\u043F\u0443\u043B\u044F\u0440\u043D\u043E\u0441\u0442\u0438"))));
        };
    }
    render() {
        const { showAsRows, favoritesSelected, sortColumn, productsSort } = this.props;
        let sortText = '';
        if (sortColumn === 'recommended_retail_price') {
            sortText = productsSort ? 'по возрастанию цены' : 'по убыванию цены';
        }
        else if (sortColumn === 'rank') {
            sortText = 'по популярности';
        }
        return (React.createElement("div", { className: "catalog-top-row mt-3 mt-md-0 " },
            React.createElement("span", { className: "control sort-control-wrapper" },
                React.createElement("span", null, "\u0421\u043E\u0440\u0442\u0438\u0440\u043E\u0432\u0430\u0442\u044C:"),
                React.createElement(antd_1.Dropdown, { overlay: this.menu },
                    React.createElement("span", { className: "legrand-text-btn" },
                        sortText,
                        " ",
                        React.createElement(antd_1.Icon, { type: "down", className: "sort-control-icon" })))),
            React.createElement(AuthRegister_1.default, { wrapped: React.createElement("label", { className: "control favorites-control-wrapper" },
                    React.createElement("span", null, "\u0418\u0437\u0431\u0440\u0430\u043D\u043D\u043E\u0435:"),
                    React.createElement(react_switch_1.default, { onChange: this.handleToggleFavorites, checked: favoritesSelected, offColor: "#c7c7c7", onColor: "#c7c7c7", offHandleColor: "#727272", onHandleColor: "#ed1b24", handleDiameter: 22, uncheckedIcon: false, checkedIcon: false, height: 14, width: 46, disabled: !this.context.user })) }),
            React.createElement("span", { className: "control sort-control-wrapper", role: "button" },
                React.createElement("span", null, "\u0412\u0438\u0434:"),
                React.createElement("button", { className: classnames_1.default('show-as-row-btn', { 'show-as-row-btn-disabled': showAsRows }), onClick: this.handleChangeDisplayFormat }, showAsRows ? Icons_1.listIconAccent : Icons_1.listIcon),
                React.createElement("button", { className: classnames_1.default('show-as-row-btn', { 'show-as-row-btn-disabled': !showAsRows }), onClick: this.handleChangeDisplayFormat }, showAsRows ? Icons_1.tilesIcon : Icons_1.tilesIconAccent))));
    }
}
TopFilters.contextType = PageLayout_1.UserContext;
exports.default = TopFilters;
