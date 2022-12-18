import * as React from 'react';
import debounce from '../../../../utils/debounce.js';
import { IFilters } from './types';
import classnames from 'classnames';
import Categories from './elements/Categories';
import Dropdown from '../../../../ui/Dropdown';
import Input from '../../../../ui/Input';
import RangeInputSlider from '../../../../ui/RangeInputSlider';
import { clearIcon } from '../../../../ui/Icons/Icons';

import { fetchProductFamilies, fetchPrpductDivisions, fetchFilters, fetchProducts } from './api';

const dropDownStyle = {
    borderBottom: '0px',
};

export default class Filters extends React.PureComponent<IFilters> {
    state = {
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

    familyRef = React.createRef<Dropdown>();
    categoryRef = React.createRef<Dropdown>();
    divisionRef = React.createRef<Dropdown>();

    minCostInputRef = React.createRef<HTMLInputElement>();
    maxCostInputRef = React.createRef<HTMLInputElement>();

    handleSelectCategoryByDropdown = (item: { id: number; name: string }) => {
        this.categoryRef.current && this.categoryRef.current.handleClick(item);
    };

    changeCostFilter = (values: number[]) => {
        this.props.topFilters.current.resetTopFilters();

        this.minCostInputRef.current.value = `${values[0]}`;
        this.maxCostInputRef.current.value = `${values[1]}`;

        this.setState({ costRangeFilter: values }, () => {
            this.debouncedGetProducts();
        });
    };

    debouncedGetProducts = debounce(() => {
        this.getProducts();
    }, 1500);

    prepareProductsRequest = () => {
        const { category, family, division, filters_request, costRangeFilter, searchValue } = this.state;
        const { productsSort, favoritesSelected, sortColumn } = this.props;

        const request: any = {
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

    prepareFilterValuesToRequest = (id, isChecked, categoryId) => {
        const { filters_request } = this.state;

        const categoryExist = filters_request.find(item => item.type_id === categoryId);
        let newCategories = [];
        let newCategory = {
            type_id: categoryId,
            values: [],
        };

        const otherCategories = filters_request.filter(item => item.type_id !== categoryId);

        if (!categoryExist && isChecked) {
            newCategories = [...filters_request, { ...newCategory, values: [id] }];
        } else if (categoryExist && isChecked) {
            newCategory.values = [...categoryExist.values, id];
            newCategories = [...otherCategories, newCategory];
        } else if (categoryExist && !isChecked) {
            newCategories = otherCategories;
            newCategory.values = categoryExist.values.filter(item => item !== id);
            newCategory.values.length > 0 && newCategories.push(newCategory);
        }

        return newCategories;
    };

    selectFilter = (id, isChecked, categoryId) => {
        const { filter_values } = this.state;
        const addFIlter = filter_values.indexOf(id) === -1 && isChecked;
        this.setState(
            {
                filter_values: addFIlter ? [...filter_values, id] : filter_values.filter(item => item !== id),
                filters_request: this.prepareFilterValuesToRequest(id, isChecked, categoryId),
            },
            () => {
                this.getProducts();
            },
        );
    };

    getProducts = () => {
        const { setProducts, setProductsIsLoading, setIsLastPage, setSecondLoading } = this.props;
        setIsLastPage(false);
        setProductsIsLoading(true);
        setSecondLoading();
        const request = this.prepareProductsRequest();
        fetchProducts(request)
            .then(response => {
                const {
                    data: { currentPage, lastPage, total, products },
                } = response;

                setProducts(products);
                this.setState({
                    currentPage,
                    lastPage,
                    total,
                });
                if (lastPage === currentPage) setIsLastPage(true);
            })
            .catch(err => {})
            .finally(() => setProductsIsLoading(false));
    };

    getDropdownValues = () => {
        this.getFamilies();
        this.getDivisions();
    };

    getFamilies = () => {
        const { category } = this.state;
        this.setState({
            familiesIsLoading: true,
        });
        const request: any = {};
        category && (request.category = category);

        fetchProductFamilies(request).then(({ data: { data } }) => {
            this.setState({
                familiesIsLoading: false,
                families: data,
            });
        });
    };

    getDivisions = () => {
        const { category, family } = this.state;
        this.setState({
            divisionsIsLoading: true,
        });
        const request: any = {};
        category && (request.category = category);
        family && (request.family = family);

        fetchPrpductDivisions(request).then(({ data: { data } }) => {
            this.setState({
                divisionsIsLoading: false,
                divisions: data,
            });
        });
    };

    getFilters = () => {
        const { category, family, division } = this.state;

        const request: any = {};

        category && (request.category = category);
        family && (request.family = family);
        division && (request.division = division);

        if (category || family || division) {
            this.setState({
                filtersIsLoading: true,
            });
            fetchFilters({
                ...request,
            }).then(({ data: { data } }) => {
                this.setState({
                    filtersIsLoading: false,
                    filter_values: [],
                    filters: data,
                });
            });
        } else {
            this.setState({ filters: [], filter_values: [] });
        }
    };

    handleSelectCategory = (item: { id: number; name: string }) => {
        this.setState(
            {
                category: item.id,
                family: null,
                division: null,
                families: [],
                divisions: [],
                filter_values: [],
            },
            () => {
                this.familyRef.current.resetDropdown();
                this.divisionRef.current.resetDropdown();

                this.getFilters();
                this.getDropdownValues();
                this.getProducts();
            },
        );
    };

    handleSelectFamily = (item: { id: number; name: string }) => {
        this.setState(
            {
                family: item.id,
                division: null,
                divisions: [],
                filter_values: [],
            },
            () => {
                this.divisionRef.current.resetDropdown();

                this.getFilters();
                this.getDivisions();
                this.getProducts();
            },
        );
    };

    handleSelectDivision = (item: { id: number; name: string }) => {
        this.setState(
            {
                division: item.id,
                filter_values: [],
            },
            () => {
                this.getFilters();
                this.getProducts();
            },
        );
    };

    getMoreProducts = () => {
        const { currentPage, lastPage } = this.state;
        const { loadProducts, setProductsIsLoading, setIsLastPage } = this.props;

        if (currentPage < lastPage) {
            setProductsIsLoading(true);
            const request = this.prepareProductsRequest();
            request.page = currentPage + 1;

            fetchProducts(request).then(({ data: { currentPage, lastPage, total, products } }) => {
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

    clearCategoryDropdown = () => {
        this.setState(
            {
                category: null,
                filter_values: [],
            },
            () => {
                this.getDropdownValues();
                this.getProducts();
                this.getFilters();
            },
        );
    };

    clearFamilyDropdown = () => {
        this.setState(
            {
                family: null,
                filter_values: [],
            },
            () => {
                this.getDivisions();
                this.getProducts();
                this.getFilters();
            },
        );
    };

    clearDivisionsDropdown = () => {
        this.setState(
            {
                division: null,
                filter_values: [],
            },
            () => {
                this.getProducts();
                this.getFilters();
            },
        );
    };

    componentDidMount() {
        const { selectedCategory, selectedDivision, showCategories } = this.props;
        const { costRange } = this.state;

        this.minCostInputRef.current.value = `${costRange[0]}`;
        this.maxCostInputRef.current.value = `${costRange[1]}`;

        if (!showCategories) {
            if (selectedCategory || selectedDivision) {
                this.setState(
                    {
                        category: parseInt(selectedCategory),
                        division: parseInt(selectedDivision),
                    },
                    () => {
                        this.getFilters();
                        this.getProducts();
                        this.getDropdownValues();
                    },
                );
            } else {
                this.getProducts();
                this.getDropdownValues();
            }
        }
    }

    componentDidUpdate(prevProps) {
        if (
            this.props.favoritesSelected !== prevProps.favoritesSelected ||
            this.props.productsSort !== prevProps.productsSort ||
            this.props.sortColumn !== prevProps.sortColumn
        ) {
            this.getProducts();
        }
    }

    setCostFilterByInputs = (values: [number, number], cb?: () => void) => {
        this.setState({ costRangeFilter: values }, () => {
            cb && cb();
        });
    };

    handleApplyFilters = e => {
        if (e.key === 'Enter') {
            this.debouncedGetProducts();
        }
    };

    handleChangeMinCostInput = (e): void => {
        const { costRangeFilter, costRange } = this.state;
        const val = parseInt(e.target.value);
        if (val) {
            if (val <= costRange[0]) {
                this.setCostFilterByInputs([0, costRangeFilter[1]], () => {
                    this.minCostInputRef.current.value = `${costRange[0]}`;
                });
            } else if (val >= costRangeFilter[1]) {
                this.setCostFilterByInputs([costRangeFilter[1], costRangeFilter[1]], () => {
                    this.minCostInputRef.current.value = `${costRangeFilter[1]}`;
                });
            } else {
                this.setCostFilterByInputs([val, costRangeFilter[1]]);
            }
        }
    };

    handleBlurMinCostInput = (e): void => {
        const { costRangeFilter, costRange } = this.state;
        const val = parseInt(e.target.value);
        if (!val) {
            this.minCostInputRef.current.value = `${costRange[0]}`;
            this.setCostFilterByInputs([costRange[0], costRangeFilter[1]]);
        }
    };

    handleChangeMaxCostInput = (e): void => {
        const { costRangeFilter, costRange } = this.state;
        const val = parseInt(e.target.value);

        if (val) {
            if (val >= costRange[1]) {
                this.setCostFilterByInputs([costRangeFilter[0], costRange[1]], () => {
                    this.maxCostInputRef.current.value = `${costRange[1]}`;
                });
            } else if (val <= costRangeFilter[0]) {
                this.setCostFilterByInputs([costRangeFilter[0], costRangeFilter[0]], () => {
                    this.maxCostInputRef.current.value = `${costRangeFilter[0]}`;
                });
            } else {
                this.setCostFilterByInputs([costRangeFilter[0], val]);
            }
        }
    };

    handleBlurMaxCostInput = (e): void => {
        const { costRangeFilter, costRange } = this.state;
        const val = parseInt(e.target.value);
        if (!val) {
            this.maxCostInputRef.current.value = `${costRange[1]}`;
            this.setCostFilterByInputs([costRangeFilter[0], costRange[1]]);
        }
    };

    searchProducts = debounce(() => {
        this.familyRef.current.resetDropdown();
        this.divisionRef.current.resetDropdown();
        this.categoryRef.current.resetDropdown();
        this.setState(
            {
                category: null,
                family: null,
                division: null,
                filter_values: [],
                costRangeFilter: [0, 50000],
                currentPage: null,
                lastPage: null,
            },
            () => {
                this.getProducts();
            },
        );
    }, 1500);

    handleChangeSearchInput = e => {
        this.setState({ searchValue: e.target.value }, () => this.searchProducts());
    };

    handleChangeSearchInputClear = () => {
        const { searchValue } = this.state;
        if (searchValue.length !== 0) {
            this.setState({ searchValue: '' }, () => this.searchProducts());
        }
    };

    render() {
        const {
            categories,
            families,
            divisions,
            filters,
            filter_values,
            familiesIsLoading,
            divisionsIsLoading,
            costRangeFilter,
            costRange,
            searchValue,
        } = this.state;

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

        return (
            <div
                className={classnames('filters', {
                    'filters-disabled': productsIsLoading,
                })}
            >
                <Input
                    value={searchValue}
                    isLoading={productsIsLoading}
                    onChange={this.handleChangeSearchInput}
                    iconAction={this.handleChangeSearchInputClear}
                    placeholder="Поиск по каталогу"
                    disabled={productsIsLoading}
                    icon={searchValue.length !== 0 ? clearIcon : <i className="fa fa-search" aria-hidden="true" />}
                />
                <span className="filter-header mt-3">Категория</span>
                <Dropdown
                    ref={this.categoryRef}
                    onClear={this.clearCategoryDropdown}
                    values={categories}
                    isLoading={false}
                    defaultId={defaultCategoryId}
                    defaultName={'Выберите категорию'}
                    action={this.handleSelectCategory}
                    style={dropDownStyle}
                />
                <Dropdown
                    ref={this.familyRef}
                    values={families}
                    isLoading={familiesIsLoading}
                    defaultName="Выберите серию"
                    action={this.handleSelectFamily}
                    style={dropDownStyle}
                    onClear={this.clearFamilyDropdown}
                    disabled={familiesDisabled}
                />

                <Dropdown
                    ref={this.divisionRef}
                    values={divisions}
                    isLoading={divisionsIsLoading}
                    defaultId={defaultDivisionId}
                    defaultName={'Выберите признак'}
                    action={this.handleSelectDivision}
                    onClear={this.clearDivisionsDropdown}
                    disabled={divisionsDisabled}
                />
                <div className="mt-3 price-wrapper">
                    <span className="filter-header">Цена</span>
                    <div className="price-inputs">
                        <div className="price-input-wrapper">
                            <input
                                type="number"
                                onBlur={this.handleBlurMinCostInput}
                                onChange={this.handleChangeMinCostInput}
                                ref={this.minCostInputRef}
                                onKeyPress={this.handleApplyFilters}
                            />
                            <i className="fa fa-rub" aria-hidden="true" />
                        </div>

                        <span className="separator" />
                        <div className="price-input-wrapper">
                            <input
                                type="number"
                                onBlur={this.handleBlurMaxCostInput}
                                onChange={this.handleChangeMaxCostInput}
                                ref={this.maxCostInputRef}
                                onKeyPress={this.handleApplyFilters}
                            />
                            <i className="fa fa-rub" aria-hidden="true" />
                        </div>
                    </div>
                    <div className="mt-3 range-input-wrapper">
                        <RangeInputSlider
                            min={costRange[0]}
                            max={costRange[1]}
                            step={10}
                            values={costRangeFilter}
                            onChange={this.changeCostFilter}
                        />
                    </div>
                </div>

                <div className=" mt-3 filters-wrapper">
                    <Categories selectFilter={this.selectFilter} filtersData={filters} checkedFilters={filter_values} />
                </div>
            </div>
        );
    }
}
