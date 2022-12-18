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
const ProductParams_1 = require("./elements/ProductParams");
const Input_1 = require("../../../../../../../../ui/Input");
const Spinner_1 = require("../../../../../../../../ui/Spinner");
const reducer_1 = require("./reducer");
const antd_1 = require("antd");
const api_1 = require("./api");
const errorImageStyle = {
    background: 'url(/images/default_product.jpg) no-repeat center center',
    backgroundSize: 'cover',
};
const normalImageStyle = {
    background: 'none',
};
const Product = ({ product, changeProductAmount, updateProducts, projectId }) => {
    const [{ imgError, amount, fetch }, dispatch] = React.useReducer(reducer_1.reducer, {
        imgError: false,
        fetch: false,
        amount: product.amount,
    });
    const setDeafultImage = () => {
        dispatch({ type: 'imgLoadingError' });
    };
    const handleChangeCount = e => {
        const value = parseInt(e.target.value);
        dispatch({ type: 'changeAmount', payload: value || '' });
        const amount = !value || value <= 0 ? 1 : value;
        changeProductAmount(product.id, amount);
    };
    const handleRemoveProduct = () => __awaiter(this, void 0, void 0, function* () {
        dispatch({ type: 'fetch' });
        yield api_1.removeProduct({ project_id: projectId, product_id: product.id });
        updateProducts();
    });
    const imgStyle = imgError ? errorImageStyle : normalImageStyle;
    return (React.createElement("div", { className: "product-wrapper" },
        React.createElement("div", { className: "product" },
            React.createElement("div", { className: "product-photo", style: imgStyle },
                React.createElement("div", { className: "delete-button-wrapper" },
                    React.createElement(antd_1.Icon, { type: "close-circle", onClick: handleRemoveProduct })),
                React.createElement("img", { src: product.img, alt: product.name, onError: setDeafultImage })),
            React.createElement("a", { href: `/catalog/product/${product.id}`, className: "product-title" }, product.name),
            React.createElement("span", { className: "product-vendor-code" },
                "\u0410\u0440\u0442. ",
                product.vendor_code),
            React.createElement(ProductParams_1.ProductParams, { params: product.attributes })),
        React.createElement("span", { className: "catalog-product-cost" },
            product.recommended_retail_price,
            " \u20BD"),
        React.createElement("div", { className: "product-count" },
            React.createElement(Input_1.default, { onChange: handleChangeCount, value: amount })),
        fetch && React.createElement(Spinner_1.default, null)));
};
exports.default = Product;
