"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const React = require("react");
const lodash_1 = require("lodash");
const classnames_1 = require("classnames");
const Categories_1 = require("./elements/Categories");
const Dropdown_1 = require("../../../../ui/Dropdown");
const Input_1 = require("../../../../ui/Input");
const RangeInputSlider_1 = require("../../../../ui/RangeInputSlider");
const Icons_1 = require("../../../../ui/Icons/Icons");
const api_1 = require("./api");
const dropDownStyle = {
    borderBottom: '0px',
};
class Filters extends React.PureComponent {
    constructor() {
        super(...arguments);
        this.state = {
            category: null,
            family: null,
            division: null,
            categories: this.props.categories,
            families: [],
            divisions: [],
            filters: [],
            filter_values: [],
            familiesIsLoading: false,
            divisionsIsLoading: false,
            filtersIsLoading: false,
            costRangeFilter: [0, 50000],
            costRange: [0, 50000],
            currentPage: null,
            lastPage: null,
            total: null,
            searchValue: '',
            filters_request: [],
        };
        this.familyRef = React.createRef();
        this.categoryRef = React.createRef();
        this.divisionRef = React.createRef();
        this.minCostInputRef = React.createRef();
        this.maxCostInputRef = React.createRef();
        this.handleSelectCategoryByDropdown = (item) => {
            this.categoryRef.current && this.categoryRef.current.handleClick(item);
        };
        this.changeCostFilter = (values) => {
            this.props.topFilters.current.resetTopFilters();
            this.minCostInputRef.current.value = `${values[0]}`;
            this.maxCostInputRef.current.value = `${values[1]}`;
            this.setState({ costRangeFilter: values }, () => {
                this.debouncedGetProducts();
            });
        };
        this.debouncedGetProducts = lodash_1.debounce(() => {
            this.getProducts();
        }, 1500);
        this.prepareProductsRequest = () => {
            const { category, family, division, filters_request, costRangeFilter, searchValue } = this.state;
            const { productsSort, favoritesSelected, sortColumn } = this.props;
            const request = {
                sort_type: productsSort ? 'asc' : 'desc',
                sort_column: sortColumn,
                favorite: favoritesSelected ? 1 : 0,
                price_from: costRangeFilter[0],
                price_to: costRangeFilter[1],
            };
            searchValue !== '' && (request.search = searchValue);
            category && (request.category = category);
            family && (request.family = family);
            division && (request.division = division);
            filters_request.length > 0 && (request.filter_values = filters_request);
            return request;
        };
        this.prepareFilterValuesToRequest = (id, isChecked, categoryId) => {
            const { filters_request } = this.state;
            const categoryExist = filters_request.find(item => item.type_id === categoryId);
            let newCategories = [];
            let newCategory = {
                type_id: categoryId,
                values: [],
            };
            const otherCategories = filters_request.filter(item => item.type_id !== categoryId);
            if (!categoryExist && isChecked) {
                newCategories = [...filters_request, Object.assign({}, newCategory, { values: [id] })];
            }
            else if (categoryExist && isChecked) {
                newCategory.values = [...categoryExist.values, id];
                newCategories = [...otherCategories, newCategory];
            }
            else if (categoryExist && !isChecked) {
                newCategories = otherCategories;
                newCategory.values = categoryExist.values.filter(item => item !== id);
                newCategory.values.length > 0 && newCategories.push(newCategory);
            }
            return newCategories;
        };
        this.selectFilter = (id, isChecked, categoryId) => {
            const { filter_values } = this.state;
            const addFIlter = filter_values.indexOf(id) === -1 && isChecked;
            this.setState({
                filter_values: addFIlter ? [...filter_values, id] : filter_values.filter(item => item !== id),
                filters_request: this.prepareFilterValuesToRequest(id, isChecked, categoryId),
            }, () => {
                this.getProducts();
            });
        };
        this.getProducts = () => {
            const { setProducts, setProductsIsLoading, setIsLastPage, setSecondLoading } = this.props;
            setIsLastPage(false);
            setProductsIsLoading(true);
            setSecondLoading();
            const request = this.prepareProductsRequest();
            api_1.fetchProducts(request)
                .then(response => {
                const { data: { currentPage, lastPage, total, products }, } = response;
                setProducts(products);
                this.setState({
                    currentPage,
                    lastPage,
                    total,
                });
                if (lastPage === currentPage)
                    setIsLastPage(true);
            })
                .catch(err => { })
                .finally(() => setProductsIsLoading(false));
        };
        this.getDropdownValues = () => {
            this.getFamilies();
            this.getDivisions();
        };
        this.getFamilies = () => {
            const { category } = this.state;
            this.setState({
                familiesIsLoading: true,
            });
            const request = {};
            category && (request.category = category);
            api_1.fetchProductFamilies(request).then(({ data: { data } }) => {
                this.setState({
                    familiesIsLoading: false,
                    families: data,
                });
            });
        };
        this.getDivisions = () => {
            const { category, family } = this.state;
            this.setState({
                divisionsIsLoading: true,
            });
            const request = {};
            category && (request.category = category);
            family && (request.family = family);
            api_1.fetchPrpductDivisions(request).then(({ data: { data } }) => {
                this.setState({
                    divisionsIsLoading: false,
                    divisions: data,
                });
            });
        };
        this.getFilters = () => {
            const { category, family, division } = this.state;
            const request = {};
            category && (request.category = category);
            family && (request.family = family);
            division && (request.division = division);
            if (category || family || division) {
                this.setState({
                    filtersIsLoading: true,
                });
                api_1.fetchFilters(Object.assign({}, request)).then(({ data: { data } }) => {
                    this.setState({
                        filtersIsLoading: false,
                        filter_values: [],
                        filters: data,
                    });
                });
            }
            else {
                this.setState({ filters: [], filter_values: [] });
            }
        };
        this.handleSelectCategory = (item) => {
            this.setState({
                category: item.id,
                family: null,
                division: null,
                families: [],
                divisions: [],
                filter_values: [],
            }, () => {
                this.familyRef.current.resetDropdown();
                this.divisionRef.current.resetDropdown();
                this.getFilters();
                this.getDropdownValues();
                this.getProducts();
            });
        };
        this.handleSelectFamily = (item) => {
            this.setState({
                family: item.id,
                division: null,
                divisions: [],
                filter_values: [],
            }, () => {
                this.divisionRef.current.resetDropdown();
                this.getFilters();
                this.getDivisions();
                this.getProducts();
            });
        };
        this.handleSelectDivision = (item) => {
            this.setState({
                division: item.id,
                filter_values: [],
            }, () => {
                this.getFilters();
                this.getProducts();
            });
        };
        this.getMoreProducts = () => {
            const { currentPage, lastPage } = this.state;
            const { loadProducts, setProductsIsLoading, setIsLastPage } = this.props;
            if (currentPage < lastPage) {
                setProductsIsLoading(true);
                const request = this.prepareProductsRequest();
                request.page = currentPage + 1;
                api_1.fetchProducts(request).then(({ data: { currentPage, lastPage, total, products } }) => {
                    loadProducts(products);
                    setProductsIsLoading(false);
                    this.setState({
                        currentPage,
                        lastPage,
                        total,
                    });
                    if (lastPage === currentPage) {
                        setIsLastPage(true);
                    }
                });
            }
        };
        this.clearCategoryDropdown = () => {
            this.setState({
                category: null,
                filter_values: [],
            }, () => {
                this.getDropdownValues();
                this.getProducts();
                this.getFilters();
            });
        };
        this.clearFamilyDropdown = () => {
            this.setState({
                family: null,
                filter_values: [],
            }, () => {
                this.getDivisions();
                this.getProducts();
                this.getFilters();
            });
        };
        this.clearDivisionsDropdown = () => {
            this.setState({
                division: null,
                filter_values: [],
            }, () => {
                this.getProducts();
                this.getFilters();
            });
        };
        this.setCostFilterByInputs = (values, cb) => {
            this.setState({ costRangeFilter: values }, () => {
                cb && cb();
            });
        };
        this.handleApplyFilters = e => {
            if (e.key === 'Enter') {
                this.debouncedGetProducts();
            }
        };
        this.handleChangeMinCostInput = (e) => {
            const { costRangeFilter, costRange } = this.state;
            const val = parseInt(e.target.value);
            if (val) {
                if (val <= costRange[0]) {
                    this.setCostFilterByInputs([0, costRangeFilter[1]], () => {
                        this.minCostInputRef.current.value = `${costRange[0]}`;
                    });
                }
                else if (val >= costRangeFilter[1]) {
                    this.setCostFilterByInputs([costRangeFilter[1], costRangeFilter[1]], () => {
                        this.minCostInputRef.current.value = `${costRangeFilter[1]}`;
                    });
                }
                else {
                    this.setCostFilterByInputs([val, costRangeFilter[1]]);
                }
            }
        };
        this.handleBlurMinCostInput = (e) => {
            const { costRangeFilter, costRange } = this.state;
            const val = parseInt(e.target.value);
            if (!val) {
                this.minCostInputRef.current.value = `${costRange[0]}`;
                this.setCostFilterByInputs([costRange[0], costRangeFilter[1]]);
            }
        };
        this.handleChangeMaxCostInput = (e) => {
            const { costRangeFilter, costRange } = this.state;
            const val = parseInt(e.target.value);
            if (val) {
                if (val >= costRange[1]) {
                    this.setCostFilterByInputs([costRangeFilter[0], costRange[1]], () => {
                        this.maxCostInputRef.current.value = `${costRange[1]}`;
                    });
                }
                else if (val <= costRangeFilter[0]) {
                    this.setCostFilterByInputs([costRangeFilter[0], costRangeFilter[0]], () => {
                        this.maxCostInputRef.current.value = `${costRangeFilter[0]}`;
                    });
                }
                else {
                    this.setCostFilterByInputs([costRangeFilter[0], val]);
                }
            }
        };
        this.handleBlurMaxCostInput = (e) => {
            const { costRangeFilter, costRange } = this.state;
            const val = parseInt(e.target.value);
            if (!val) {
                this.maxCostInputRef.current.value = `${costRange[1]}`;
                this.setCostFilterByInputs([costRangeFilter[0], costRange[1]]);
            }
        };
        this.searchProducts = lodash_1.debounce(() => {
            this.familyRef.current.resetDropdown();
            this.divisionRef.current.resetDropdown();
            this.categoryRef.current.resetDropdown();
            this.setState({
                category: null,
                family: null,
                division: null,
                filter_values: [],
                costRangeFilter: [0, 50000],
                currentPage: null,
                lastPage: null,
            }, () => {
                this.getProducts();
            });
        }, 1500);
        this.handleChangeSearchInput = e => {
            this.setState({ searchValue: e.target.value }, () => this.searchProducts());
        };
        this.handleChangeSearchInputClear = () => {
            const { searchValue } = this.state;
            if (searchValue.length !== 0) {
                this.setState({ searchValue: '' }, () => this.searchProducts());
            }
        };
    }
    componentDidMount() {
        const { selectedCategory, selectedDivision, showCategories } = this.props;
        const { costRange } = this.state;
        this.minCostInputRef.current.value = `${costRange[0]}`;
        this.maxCostInputRef.current.value = `${costRange[1]}`;
        if (!showCategories) {
            if (selectedCategory || selectedDivision) {
                this.setState({
                    category: parseInt(selectedCategory),
                    division: parseInt(selectedDivision),
                }, () => {
                    this.getFilters();
                    this.getProducts();
                    this.getDropdownValues();
                });
            }
            else {
                this.getProducts();
                this.getDropdownValues();
            }
        }
    }
    componentDidUpdate(prevProps) {
        if (this.props.favoritesSelected !== prevProps.favoritesSelected ||
            this.props.productsSort !== prevProps.productsSort ||
            this.props.sortColumn !== prevProps.sortColumn) {
            this.getProducts();
        }
    }
    render() {
        const { categories, families, divisions, filters, filter_values, familiesIsLoading, divisionsIsLoading, costRangeFilter, costRange, searchValue, } = this.state;
        const { selectedCategory, selectedDivision, productsIsLoading } = this.props;
        const defaultCategory = categories.find(item => {
            return item.id === parseInt(selectedCategory);
        });
        const defaultDivision = divisions.find(item => {
            return item.id === parseInt(selectedDivision);
        });
        const defaultCategoryId = defaultCategory ? defaultCategory.id : null;
        const defaultDivisionId = defaultDivision ? defaultDivision.id : null;
        const divisionsDisabled = divisions.length === 0;
        const familiesDisabled = families.length === 0;
        return (React.createElement("div", { className: classnames_1.default('filters', {
                'filters-disabled': productsIsLoading,
            }) },
            React.createElement(Input_1.default, { value: searchValue, isLoading: productsIsLoading, onChange: this.handleChangeSearchInput, iconAction: this.handleChangeSearchInputClear, placeholder: "Поиск по каталогу", disabled: productsIsLoading, icon: searchValue.length !== 0 ? Icons_1.clearIcon : React.createElement("i", { className: "fa fa-search", "aria-hidden": "true" }) }),
            React.createElement("span", { className: "filter-header mt-3" }, "\u041A\u0430\u0442\u0435\u0433\u043E\u0440\u0438\u044F"),
            React.createElement(Dropdown_1.default, { ref: this.categoryRef, onClear: this.clearCategoryDropdown, values: categories, isLoading: false, defaultId: defaultCategoryId, defaultName: 'Выберите категорию', action: this.handleSelectCategory, style: dropDownStyle }),
            React.createElement(Dropdown_1.default, { ref: this.familyRef, values: families, isLoading: familiesIsLoading, defaultName: "Выберите серию", action: this.handleSelectFamily, style: dropDownStyle, onClear: this.clearFamilyDropdown, disabled: familiesDisabled }),
            React.createElement(Dropdown_1.default, { ref: this.divisionRef, values: divisions, isLoading: divisionsIsLoading, defaultId: defaultDivisionId, defaultName: 'Выберите признак', action: this.handleSelectDivision, onClear: this.clearDivisionsDropdown, disabled: divisionsDisabled }),
            React.createElement("div", { className: "mt-3 price-wrapper" },
                React.createElement("span", { className: "filter-header" }, "\u0426\u0435\u043D\u0430"),
                React.createElement("div", { className: "price-inputs" },
                    React.createElement("div", { className: "price-input-wrapper" },
                        React.createElement("input", { type: "number", onBlur: this.handleBlurMinCostInput, onChange: this.handleChangeMinCostInput, ref: this.minCostInputRef, onKeyPress: this.handleApplyFilters }),
                        React.createElement("i", { className: "fa fa-rub", "aria-hidden": "true" })),
                    React.createElement("span", { className: "separator" }),
                    React.createElement("div", { className: "price-input-wrapper" },
                        React.createElement("input", { type: "number", onBlur: this.handleBlurMaxCostInput, onChange: this.handleChangeMaxCostInput, ref: this.maxCostInputRef, onKeyPress: this.handleApplyFilters }),
                        React.createElement("i", { className: "fa fa-rub", "aria-hidden": "true" }))),
                React.createElement("div", { className: "mt-3 range-input-wrapper" },
                    React.createElement(RangeInputSlider_1.default, { min: costRange[0], max: costRange[1], step: 10, values: costRangeFilter, onChange: this.changeCostFilter }))),
            React.createElement("div", { className: " mt-3 filters-wrapper" },
                React.createElement(Categories_1.default, { selectFilter: this.selectFilter, filtersData: filters, checkedFilters: filter_values }))));
    }
}
exports.default = Filters;
