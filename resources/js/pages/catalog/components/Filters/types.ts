import { RefObject } from 'react';

export interface ICategories {
    filtersData: TCategory[];
    checkedFilters: number[];
    selectFilter: (id: number, isChecked: boolean, categoryId: number) => void;
}

export type TCategory = {
    id: number;
    name: string;
    values: TSubcategory[];
};

export type TSubcategory = {
    id: number;
    value: string;
    product_count: number;
};

export interface ISubcategories {
    isVisible: boolean;
    categoryId: number;
    values: TSubcategory[];
    checkedFilters: number[];
    selectFilter: (id: number, isChecked: boolean, categoryId: number) => void;
}

export interface IFilters {
    topFilters: any;
    productsSort: boolean;
    favoritesSelected: boolean;
    productsContainer: RefObject<HTMLDivElement>;
    categories: any;
    productsIsLoading: boolean;
    selectedCategory: string;
    selectedDivision: string;
    showCategories: boolean;
    sortColumn: string;
    setProductsIsLoading: (value: boolean) => void;
    loadProducts: (products: any[]) => void;
    setProducts: (products: any[]) => void;
    setIsLastPage: (value: boolean) => void;
    setSecondLoading: () => void;
}

export type TFiltersAPI = {
    category?: number;
    family?: number;
    division?: number;
};

export type TFetchProducts = {
    category?: number;
    family?: number;
    division?: number;
    filter_values?: number[];
    limit?: number;
    price_from?: number;
    price_to?: number;
};
