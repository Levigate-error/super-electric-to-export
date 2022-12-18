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
const AddItem_1 = require("../../../../../../ui/AddItem");
const Input_1 = require("../../../../../../ui/Input");
const lodash_1 = require("lodash");
const reducer_1 = require("./reducer");
const antd_1 = require("antd");
const { Option } = antd_1.AutoComplete;
const api_1 = require("./api");
const searchRowStyle = { width: 300 };
const AddProduct = ({ projectId, section, updateSpec, specificationId }) => {
    const [{ isLoading, dropdownIsVisible, values }, dispatch] = React.useReducer(reducer_1.reducer, {
        isLoading: false,
        dropdownIsVisible: false,
        values: [],
    });
    const onSelect = product_id => {
        if (section.fake_section) {
            api_1.addProduct({
                product: parseInt(product_id),
                projects: [
                    {
                        amount: 1,
                        project: projectId,
                    },
                ],
            }).then(result => {
                dispatch({ type: 'hide-search' });
                updateSpec(projectId);
            });
        }
        else {
            api_1.addProductToSection({
                specification_id: specificationId,
                specification_section_id: section.id,
                product: product_id,
            }).then(result => {
                dispatch({ type: 'hide-search' });
                updateSpec(projectId);
            });
        }
    };
    const searchResult = (query) => __awaiter(this, void 0, void 0, function* () {
        const response = yield api_1.searchProducts({ search: query, limit: 10 });
        return response.data.products;
    });
    const handleSearch = lodash_1.debounce((value) => __awaiter(this, void 0, void 0, function* () {
        const result = yield searchResult(value);
        dispatch({ type: 'set-values', payload: result });
    }), 1000);
    const handleShowSerachRow = () => {
        dispatch({ type: 'open-search' });
    };
    return (React.createElement("div", { className: "add-product-to-spec-row" },
        isLoading,
        dropdownIsVisible ? (React.createElement("div", { className: "global-search-wrapper", style: searchRowStyle },
            React.createElement(antd_1.AutoComplete, { className: "global-search", size: "large", style: { width: '100%' }, dataSource: values.map(renderOption), onSelect: onSelect, onSearch: handleSearch, optionLabelProp: "text" },
                React.createElement(Input_1.default, { icon: React.createElement(antd_1.Icon, { type: "search" }), placeholder: "Поиск продукта" })))) : (React.createElement(AddItem_1.default, { icon: React.createElement(antd_1.Icon, { type: "plus-square" }), text: "Добавить продукт", action: handleShowSerachRow }))));
};
function renderOption(item) {
    return (React.createElement(Option, { key: item.id },
        React.createElement("span", { className: "add-product-to-spec-vendor-code" }, item.vendor_code),
        React.createElement("span", { className: "add-product-to-spec-name" }, item.name)));
}
exports.default = AddProduct;
