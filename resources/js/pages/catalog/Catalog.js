"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const React = require("react");
const classnames_1 = require("classnames");
const Filters_1 = require("./components/Filters");
const Products_1 = require("./components/Products");
const TopFilters_1 = require("./components/TopFilters");
const PageLayout_1 = require("../../components/PageLayout");
const Spinner_1 = require("../../ui/Spinner");
const CategoriesList_1 = require("./components/CategoriesList");
class Catalog extends React.Component {
    constructor() {
        super(...arguments);
        this.productsContainer = React.createRef();
        this.filtersRef = React.createRef();
        this.topFiltersRef = React.createRef();
        this.state = {
            showAsRows: false,
            favoritesSelected: false,
            products: [],
            productsSort: false,
            productsIsLoading: true,
            textFilterLoading: false,
            isLastPage: false,
            firstLoading: true,
            sortColumn: 'recommended_retail_price',
        };
        this.setIsLastPage = value => this.setState({ isLastPage: value });
        this.handleSortByPriceAsc = () => {
            this.setState({ productsSort: true, sortColumn: 'recommended_retail_price' });
        };
        this.handleSortByPriceDesc = () => {
            this.setState({ productsSort: false, sortColumn: 'recommended_retail_price' });
        };
        this.handleSortByRate = () => {
            this.setState({ productsSort: false, sortColumn: 'rank' });
        };
        this.setProductsIsLoading = (value) => {
            this.setState({
                productsIsLoading: value,
            });
        };
        this.setProducts = products => {
            this.setState({
                products,
            });
        };
        this.loadProducts = products => {
            this.setState({
                products: [...this.state.products, ...products],
            });
        };
        this.changeDisplayFormat = () => {
            const { showAsRows } = this.state;
            this.setState({ showAsRows: !showAsRows });
        };
        this.handleToggleFavorites = () => {
            const { favoritesSelected } = this.state;
            this.setState({ favoritesSelected: !favoritesSelected });
        };
        this.handleChangeSortColumn = value => {
            this.setState({ sortColumn: value });
        };
        this.topActions = {
            onChangeDisplayFormat: this.changeDisplayFormat,
            onToggleFavorites: this.handleToggleFavorites,
            onChangeSortColumn: this.handleChangeSortColumn,
            onSortByPriceAsc: this.handleSortByPriceAsc,
            onSortByPriceDesc: this.handleSortByPriceDesc,
            onSortByRate: this.handleSortByRate,
        };
        this.handleGetMoreProducts = () => this.filtersRef.current.getMoreProducts();
        this.goToLastProject = id => {
            const base_url = window.location.origin;
            document.location.href = `${base_url}/project/specifications/${id}`;
        };
        this.handleSetSecondLoading = () => {
            const { firstLoading } = this.state;
            if (firstLoading) {
                this.setState({ firstLoading: false });
            }
        };
    }
    componentDidMount() {
        const { store: { selected_category_id, selected_division_id }, } = this.props;
        if (selected_category_id || selected_division_id) {
            this.setState({ firstLoading: false });
        }
    }
    render() {
        const { showAsRows, products, favoritesSelected, productsSort, productsIsLoading, textFilterLoading, isLastPage, firstLoading, sortColumn, } = this.state;
        const { store: { categories, selected_category_id, selected_division_id, user, userResource }, } = this.props;
        const selectedCategory = this.filtersRef.current && this.filtersRef.current.state.category;
        const selectedDivision = this.filtersRef.current && this.filtersRef.current.state.division;
        const selectedFamily = this.filtersRef.current && this.filtersRef.current.state.family;
        const showProducts = selectedCategory ||
            selectedDivision ||
            selectedFamily ||
            selected_category_id ||
            selected_division_id ||
            !firstLoading;
        let lastProjectActivity = false;
        if (!Array.isArray(userResource)) {
            const project = userResource.activities.project;
            if (!Array.isArray(project)) {
                lastProjectActivity = project;
            }
        }
        return (React.createElement("div", { className: "container catalog-wrapper" },
            React.createElement("div", { className: "row justify-content-between mt-4" },
                React.createElement("div", { className: "col-md-3" },
                    React.createElement("h3", null, "\u041A\u0430\u0442\u0430\u043B\u043E\u0433"),
                    user && !!lastProjectActivity && (React.createElement("button", { onClick: () => this.goToLastProject(lastProjectActivity.source_id), className: "legrand-text-btn back-to-proj-btn" }, "\u2190 \u0412\u0435\u0440\u043D\u0443\u0442\u0441\u044F \u0432 \u043F\u0440\u043E\u0435\u043A\u0442"))),
                showProducts && (React.createElement("div", { className: " col-md-9" },
                    React.createElement(TopFilters_1.default, { ref: this.topFiltersRef, showAsRows: showAsRows, actions: this.topActions, favoritesSelected: favoritesSelected, productsSort: productsSort, sortColumn: sortColumn, textFilterLoading: textFilterLoading, productsIsLoading: productsIsLoading })))),
            React.createElement("div", { className: "row mt-5" }),
            React.createElement("div", { className: "row " },
                React.createElement("div", { className: classnames_1.default('col-md-3', { 'hidden-filters': !showProducts }) },
                    React.createElement(Filters_1.default, { ref: this.filtersRef, categories: categories, setProducts: this.setProducts, sortColumn: sortColumn, favoritesSelected: favoritesSelected, productsSort: productsSort, productsContainer: this.productsContainer, loadProducts: this.loadProducts, setProductsIsLoading: this.setProductsIsLoading, productsIsLoading: productsIsLoading, selectedCategory: selected_category_id, selectedDivision: selected_division_id, setIsLastPage: this.setIsLastPage, topFilters: this.topFiltersRef, setSecondLoading: this.handleSetSecondLoading, showCategories: !showProducts })),
                showProducts ? (React.createElement("div", { className: "col-md-9" },
                    React.createElement("div", { ref: this.productsContainer },
                        React.createElement(Products_1.default, { showAsRows: showAsRows, products: products }),
                        !isLastPage && (React.createElement("div", { className: "load-more-wrapper" }, productsIsLoading ? (React.createElement(Spinner_1.default, null)) : (React.createElement("button", { onClick: this.handleGetMoreProducts, className: "catalog-load-more-btn" }, "\u041F\u043E\u043A\u0430\u0437\u0430\u0442\u044C \u0435\u0449\u0435"))))))) : (React.createElement(CategoriesList_1.default, { categories: categories, filters: this.filtersRef })))));
    }
}
exports.default = PageLayout_1.default(Catalog);
