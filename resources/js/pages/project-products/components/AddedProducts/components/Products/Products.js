"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const React = require("react");
const lodash_1 = require("lodash");
const api_1 = require("../../api");
const Spinner_1 = require("../../../../../../ui/Spinner");
const Product_1 = require("./components/Product");
const api_2 = require("./api");
const Icons_1 = require("../../../../../../ui/Icons/Icons");
const antd_1 = require("antd");
const reducer_1 = require("./reducer");
const Icons_2 = require("../../../../../../ui/Icons/Icons");
const btnBackStyle = {
    fontSize: '28px',
    marginRight: '10px',
    verticalAlign: 'baseline',
};
const Products = ({ projectId, category, division, back }) => {
    const [{ isLoading, products, showAsRows }, dispatch] = React.useReducer(reducer_1.reducer, {
        isLoading: true,
        showAsRows: false,
        selectedDivision: null,
        divisions: [],
    });
    React.useEffect(() => {
        handleUpdateProducts();
    }, []);
    const handleAddProduct = () => {
        const base_url = window.location.origin;
        window.location.href = `${base_url}/catalog?category_id=${category.id}&division_id=${division.id}`;
    };
    const changeProductAmount = lodash_1.debounce((productId, amount) => {
        dispatch({ type: 'fetch' });
        const params = {
            amount,
        };
        api_2.updateProduct(params, projectId, productId)
            .then(({ data }) => {
            data.result &&
                api_1.fetchDivisionProducts({
                    project_id: projectId,
                    division_id: division.id,
                }).then(response => {
                    dispatch({ type: 'select-products', payload: response });
                });
        })
            .catch(err => { });
    }, 2000);
    const handleChangeDisplayFormat = () => dispatch({ type: 'change-display-format' });
    const handleUpdateProducts = () => {
        dispatch({ type: 'fetch' });
        api_1.fetchDivisionProducts({
            project_id: projectId,
            division_id: division.id,
        }).then(response => {
            dispatch({ type: 'select-products', payload: response });
        });
    };
    return (React.createElement(React.Fragment, null,
        React.createElement("div", { className: "products-title-row" },
            React.createElement(antd_1.Icon, { type: "left-square", onClick: back, style: btnBackStyle }),
            division.name,
            React.createElement("button", { className: "show-as-row-btn", onClick: handleChangeDisplayFormat }, showAsRows ? Icons_1.displayGrid : Icons_1.displayBars)),
        React.createElement("div", { className: showAsRows ? 'products-container-rows' : 'products-container-gird' },
            React.createElement("div", { className: "prodict-item-add-wrapper" },
                React.createElement("button", { className: "add-product-product-btn", onClick: handleAddProduct }, Icons_2.addCircle)),
            !isLoading ? (products.map(product => (React.createElement(Product_1.default, { showAsRows: showAsRows, product: product, key: product.id, changeProductAmount: changeProductAmount, updateProducts: handleUpdateProducts, projectId: projectId })))) : (React.createElement("div", { className: "spinner-wrapper" },
                React.createElement(Spinner_1.default, null))))));
};
exports.default = Products;
