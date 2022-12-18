import * as React from 'react';
import { ICatalog } from './types';
import classnames from 'classnames';
import Filters from './components/Filters';
import Products from './components/Products';
import TopFilters from './components/TopFilters';
import PageLayout from '../../components/PageLayout';
import Spinner from '../../ui/Spinner';
import Categorieslist from './components/CategoriesList';

interface IState {
    showAsRows: boolean;
    products: any[];
    favoritesSelected: boolean;
    productsSort: boolean;
    productsIsLoading: boolean;
    textFilterLoading: boolean;
    isLastPage: boolean;
    firstLoading: boolean;
    sortColumn: string;
}

class Catalog extends React.Component<ICatalog, IState> {
    productsContainer = React.createRef<HTMLDivElement>();
    filtersRef = React.createRef<Filters>();
    topFiltersRef = React.createRef<TopFilters>();

    state = {
        showAsRows: false,
        favoritesSelected: false,
        products: [],
        productsSort: false, // asc - true | desc - false
        productsIsLoading: true,
        textFilterLoading: false,
        isLastPage: false,
        firstLoading: true,
        sortColumn: 'recommended_retail_price',
    };

    setIsLastPage = value => this.setState({ isLastPage: value });

    handleSortByPriceAsc = () => {
        this.setState({ productsSort: true, sortColumn: 'recommended_retail_price' });
    };

    handleSortByPriceDesc = () => {
        this.setState({ productsSort: false, sortColumn: 'recommended_retail_price' });
    };

    handleSortByRate = () => {
        this.setState({ productsSort: false, sortColumn: 'rank' });
    };

    setProductsIsLoading = (value: boolean) => {
        this.setState({
            productsIsLoading: value,
        });
    };

    setProducts = products => {
        this.setState({
            products,
        });
    };

    loadProducts = products => {
        this.setState({
            products: [...this.state.products, ...products],
        });
    };

    changeDisplayFormat = () => {
        const { showAsRows } = this.state;
        this.setState({ showAsRows: !showAsRows });
    };

    handleToggleFavorites = () => {
        const { favoritesSelected } = this.state;
        this.setState({ favoritesSelected: !favoritesSelected });
    };

    handleChangeSortColumn = value => {
        this.setState({ sortColumn: value });
    };

    topActions = {
        onChangeDisplayFormat: this.changeDisplayFormat,
        onToggleFavorites: this.handleToggleFavorites,
        onChangeSortColumn: this.handleChangeSortColumn,
        onSortByPriceAsc: this.handleSortByPriceAsc,
        onSortByPriceDesc: this.handleSortByPriceDesc,
        onSortByRate: this.handleSortByRate,
    };

    handleGetMoreProducts = () => this.filtersRef.current.getMoreProducts();

    goToLastProject = id => {
        const base_url = window.location.origin;
        document.location.href = `${base_url}/project/specifications/${id}`;
    };

    componentDidMount() {
        const {
            store: { selected_category_id, selected_division_id },
        } = this.props;

        if (selected_category_id || selected_division_id) {
            this.setState({ firstLoading: false });
        }
    }

    handleSetSecondLoading = () => {
        const { firstLoading } = this.state;
        if (firstLoading) {
            this.setState({ firstLoading: false });
        }
    };

    render() {
        const {
            showAsRows,
            products,
            favoritesSelected,
            productsSort,
            productsIsLoading,
            textFilterLoading,
            isLastPage,
            firstLoading,
            sortColumn,
        } = this.state;
        const {
            store: { categories, selected_category_id, selected_division_id, user, userResource },
        } = this.props;

        const selectedCategory = this.filtersRef.current && this.filtersRef.current.state.category;
        const selectedDivision = this.filtersRef.current && this.filtersRef.current.state.division;
        const selectedFamily = this.filtersRef.current && this.filtersRef.current.state.family;

        const showProducts =
            selectedCategory ||
            selectedDivision ||
            selectedFamily ||
            selected_category_id ||
            selected_division_id ||
            !firstLoading;

        let lastProjectActivity: any = false;

        if (!Array.isArray(userResource)) {
            const project = userResource.activities.project;
            if (!Array.isArray(project)) {
                lastProjectActivity = project;
            }
        }

        return (
            <div className="container catalog-wrapper">
                <div className="row justify-content-between mt-4">
                    <div className="col-md-3">
                        <h3>Каталог</h3>
                        {user && !!lastProjectActivity && (
                            <button
                                onClick={() => this.goToLastProject(lastProjectActivity.source_id)}
                                className="legrand-text-btn back-to-proj-btn"
                            >
                                &#8592; Вернутся в проект
                            </button>
                        )}
                    </div>
                    {showProducts && (
                        <div className=" col-md-9">
                            <TopFilters
                                ref={this.topFiltersRef}
                                showAsRows={showAsRows}
                                actions={this.topActions}
                                favoritesSelected={favoritesSelected}
                                productsSort={productsSort}
                                sortColumn={sortColumn}
                                textFilterLoading={textFilterLoading}
                                productsIsLoading={productsIsLoading}
                            />
                        </div>
                    )}
                </div>
                <div className="row mt-5" />

                <div className="row ">
                    <div className={classnames('col-md-3', { 'hidden-filters': !showProducts })}>
                        <Filters
                            ref={this.filtersRef}
                            categories={categories}
                            setProducts={this.setProducts}
                            sortColumn={sortColumn}
                            favoritesSelected={favoritesSelected}
                            productsSort={productsSort}
                            productsContainer={this.productsContainer}
                            loadProducts={this.loadProducts}
                            setProductsIsLoading={this.setProductsIsLoading}
                            productsIsLoading={productsIsLoading}
                            selectedCategory={selected_category_id}
                            selectedDivision={selected_division_id}
                            setIsLastPage={this.setIsLastPage}
                            topFilters={this.topFiltersRef}
                            setSecondLoading={this.handleSetSecondLoading}
                            showCategories={!showProducts}
                        />
                    </div>
                    {showProducts ? (
                        <div className="col-md-9">
                            <div ref={this.productsContainer}>
                                <Products showAsRows={showAsRows} products={products} />
                                {!isLastPage && (
                                    <div className="load-more-wrapper">
                                        {productsIsLoading ? (
                                            <Spinner />
                                        ) : (
                                            <button
                                                onClick={this.handleGetMoreProducts}
                                                className="catalog-load-more-btn"
                                            >
                                                Показать еще
                                            </button>
                                        )}
                                    </div>
                                )}
                            </div>
                        </div>
                    ) : (
                        <Categorieslist categories={categories} filters={this.filtersRef} />
                    )}
                </div>
            </div>
        );
    }
}

export default PageLayout(Catalog);
